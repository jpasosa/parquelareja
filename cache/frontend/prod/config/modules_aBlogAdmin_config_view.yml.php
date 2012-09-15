<?php
// auto-generated by sfViewConfigHandler
// date: 2011/11/17 22:16:13
$response = $this->context->getResponse();


  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());



  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'layout' ? false : 'layout'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);

  $response->addStylesheet('/apostropheExtraSlotsPlugin/css/aExtraSlots.less', '', array (  'data-asset-group' => 'global',));
  $response->addStylesheet('/apostropheFeedbackPlugin/css/aFeedback.less', '', array (  'data-asset-group' => 'global',));
  $response->addStylesheet('main.css', 'last', array (  'data-asset-group' => 'global',));
  $response->addJavascript('/apostropheBlogPlugin/js/aBlog.js', 'last', array (  'data-asset-group' => 'global',));
  $response->addJavascript('/apostropheExtraSlotsPlugin/js/aExtraSlots.js', 'last', array (  'data-asset-group' => 'global',));
  $response->addJavascript('/apostropheFeedbackPlugin/js/aFeedback.js', 'last', array (  'data-asset-group' => 'global',));
  $response->addJavascript('jquery.ui.datepicker-es.js', 'last', array (  'data-asset-group' => 'global',));
  $response->addJavascript('site.js', 'last', array (  'data-asset-group' => 'global',));


