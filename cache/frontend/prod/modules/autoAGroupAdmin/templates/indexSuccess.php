<?php use_helper('a', 'Date') ?>
<?php include_partial('aGroupAdmin/assets') ?>

<?php slot('a-page-header')?>
<div class="a-ui a-admin-header">
	<h3 class="a-admin-title"><?php echo __('Group list', array(), 'apostrophe') ?></h3>
	<ul class="a-ui a-controls a-admin-controls">
    <?php include_partial('aGroupAdmin/list_actions', array('helper' => $helper)) ?>   
  </ul>
			<?php echo a_js_button(a_('Filters'), array('icon','a-filters','lite', 'alt','a-align-right', 'big'), 'a-admin-filters-open-button') ?>
	</div>
<?php end_slot() ?>

<?php slot('a-subnav') ?>
<div class="a-ui a-subnav-wrapper admin">
	<div class="a-subnav-inner">
		<ul class="a-ui a-controls">
				<li><?php include_partial('aGroupAdmin/list_header', array('pager' => $pager)) ?></li>
		</ul>
	</div>
</div>
<?php end_slot() ?>

<div class="a-ui a-admin-container <?php echo $sf_params->get('module') ?>">

	<div class="a-admin-content main">
		
				  <?php include_partial('aGroupAdmin/filters', array('form' => $filters, 'configuration' => $configuration, 'filtersActive' => $filtersActive)) ?>
		
		<?php include_partial('aGroupAdmin/flashes') ?>
		
					<form action="<?php echo url_for('a_group_admin_collection', array('action' => 'batch')) ?>" method="post" id="a-admin-batch-form">
				
		<?php include_partial('aGroupAdmin/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>

		<ul class="a-ui a-admin-actions">
      <?php include_partial('aGroupAdmin/list_batch_actions', array('helper' => $helper)) ?>
    </ul>

				  </form>
				
	</div>

  <div class="a-admin-footer">
    <?php include_partial('aGroupAdmin/list_footer', array('pager' => $pager)) ?>
  </div>

</div>

<?php a_js_call('apostrophe.aAdminEnableFilters()') ?>