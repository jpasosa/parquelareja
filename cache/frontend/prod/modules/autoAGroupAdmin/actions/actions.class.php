<?php

require_once(dirname(__FILE__).'/../lib/BaseAGroupAdminGeneratorConfiguration.class.php');
require_once(dirname(__FILE__).'/../lib/BaseAGroupAdminGeneratorHelper.class.php');

/**
 * aGroupAdmin actions.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage aGroupAdmin
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 12493 2008-10-31 14:43:26Z fabien $
 */
class autoAGroupAdminActions extends sfActions
{
  public function preExecute()
  {
    $this->configuration = new aGroupAdminGeneratorConfiguration();

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($this->getActionName())))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $this->dispatcher->notify(new sfEvent($this, 'admin.pre_execute', array('configuration' => $this->configuration)));

    $this->helper = new aGroupAdminGeneratorHelper();

    aTools::setAllowSlotEditing(false);
  }

  public function executeIndex(sfWebRequest $request)
  {
    // sorting
    if ($request->getParameter('sort'))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    aTools::setAllowSlotEditing(false);

    // There is no really great way to determine whether the filters differ from the defaults
    // do it the tedious way
    $this->filtersActive = false;

    // Without this check we crash admin gen that has no filters
    if ($this->configuration->hasFilterForm())
    {
      $defaults = $this->configuration->getFilterDefaults();
      $filters = $this->getFilters();
    
      foreach ($filters as $key => $val)
      {
        if (isset($defaults[$key]))
        {
          $this->filtersActive = true;
        }
        else
        {
          if (!$this->isEmptyFilter($val))
          {
            $this->filtersActive = true;
          }
        }
      }
    }
  }
  
  protected function isEmptyFilter($val)
  {
    if (!$val)
    {
      return true;
    }
    if (is_array($val))
    {
      foreach ($val as $v)
      {
        if ($v)
        {
          return false;
        }
      }
      return true;
    }
  }

  public function executeFilter(sfWebRequest $request)
  {
    $this->setPage(1);

    if ($request->hasParameter('_reset'))
    {
      $this->setFilters($this->configuration->getFilterDefaults());

      $this->redirect('@a_group_admin');
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters());

    $this->filters->bind($request->getParameter($this->filters->getName()));
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());

      $this->redirect('@a_group_admin');
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    $this->setTemplate('index');
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->sf_guard_group = $this->form->getObject();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->sf_guard_group = $this->form->getObject();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->sf_guard_group = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->sf_guard_group);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->sf_guard_group = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->sf_guard_group);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->delete();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@a_group_admin');
  }

  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@a_group_admin');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@a_group_admin');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $validator = new sfValidatorDoctrineChoice(array('multiple' => true,  'model' => 'sfGuardGroup'));
    try
    {
      // validate ids
      $ids = $validator->clean($ids);

      // execute batch
      $this->$method($request);
    }
    catch (sfValidatorError $e)
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items as some items do not exist anymore.');
    }

    $this->redirect('@a_group_admin');
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    // TBB: use collection delete rather than a delete query. This ensures
    // that the object's delete() method is called, which provides
    // for checking userHasPrivileges()
    
    $ids = $request->getParameter('ids');

    $items = Doctrine_Query::create()
      ->from('sfGuardGroup')
      ->whereIn('id', $ids)
      ->execute();
    $count = count($items);
    $error = false;
    try
    {
      $items->delete();
    } catch (Exception $e)
    {
      $error = true;
    }
    
    if (($count == count($ids)) && (!$error))
    {
      $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'An error occurred while deleting the selected items.');
    }

    $this->redirect('@a_group_admin');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice', $form->getObject()->isNew() ? $this->__('The item was created successfully.', null, 'apostrophe') : $this->__('The item was updated successfully.', null, 'apostrophe'));

      $sf_guard_group = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $sf_guard_group)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' ' . $this->__('You can add another one below.', null, 'apostrophe'));

        $this->redirect('@a_group_admin_new');
      }
      elseif ($request->hasParameter('_save'))
      {
        $this->redirect('@a_group_admin_edit?id='.$sf_guard_group->getId());
      }
      // The default is _save_and_list
      else
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice'));

        $this->redirect('@a_group_admin');
      }
    }
    else
    {
      $this->getUser()->setFlash('error', $this->__('The item has not been saved due to some errors.', null, 'apostrophe'));
    }
  }

  protected function __($s, $params, $catalogue)
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
    return __($s, $params, $catalogue);
  }

  protected function getFilters()
  {
    return $this->getUser()->getAttribute('aGroupAdmin.filters', $this->configuration->getFilterDefaults(), 'admin_module');
  }

  protected function setFilters(array $filters)
  {
    return $this->getUser()->setAttribute('aGroupAdmin.filters', $filters, 'admin_module');
  }

  protected function getPager()
  {
    $pager = $this->configuration->getPager('sfGuardGroup');
    $pager->setQuery($this->buildQuery());
    $pager->setPage($this->getPage());
    $pager->init();

    return $pager;
  }

  protected function setPage($page)
  {
    $this->getUser()->setAttribute('aGroupAdmin.page', $page, 'admin_module');
  }

  protected function getPage()
  {
    return $this->getUser()->getAttribute('aGroupAdmin.page', 1, 'admin_module');
  }

  protected function buildQuery()
  {
    $tableMethod = $this->configuration->getTableMethod();
    if (is_null($this->filters))
    {
      $this->filters = $this->configuration->getFilterForm($this->getFilters());
    }

    $this->filters->setTableMethod($tableMethod);

    $query = $this->filters->buildQuery($this->getFilters());

    $this->addSortQuery($query);

    $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_query'), $query);
    $query = $event->getReturnValue();

    return $query;
  }

  protected function addSortQuery($query)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }
    
    if (!in_array(strtolower($sort[1]), array('asc', 'desc')))
    {
      $sort[1] = 'asc';
    }

    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function getSort()
  {
    if (!is_null($sort = $this->getUser()->getAttribute('aGroupAdmin.sort', null, 'admin_module')))
    {
      return $sort;
    }

    $this->setSort($this->configuration->getDefaultSort());

    return $this->getUser()->getAttribute('aGroupAdmin.sort', null, 'admin_module');
  }

  protected function setSort(array $sort)
  {
    if (!is_null($sort[0]) && is_null($sort[1]))
    {
      $sort[1] = 'asc';
    }

    $this->getUser()->setAttribute('aGroupAdmin.sort', $sort, 'admin_module');
  }
}
