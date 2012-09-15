<?php use_helper('a', 'Date') ?>
<?php include_partial('aGroupAdmin/assets') ?>

<?php slot('a-subnav') ?>
<div class="a-ui a-subnav-wrapper admin">
	<div class="a-subnav-inner">
		<?php include_partial('aGroupAdmin/form_header', array('sf_guard_group' => $sf_guard_group, 'form' => $form, 'configuration' => $configuration)) ?>
	</div>	
</div>
<?php end_slot() ?>

<div class="a-ui a-admin-container <?php echo $sf_params->get('module') ?>">
  <?php include_partial('aGroupAdmin/form_bar', array('title' => __('Editing Group "%%name%%"', array('%%name%%' => $sf_guard_group->getName()), 'apostrophe'))) ?>

  <div class="a-admin-content main">
	  <?php include_partial('aGroupAdmin/flashes') ?>
 		<?php include_partial('aGroupAdmin/form', array('sf_guard_group' => $sf_guard_group, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div class="a-admin-footer">
 		<?php include_partial('aGroupAdmin/form_footer', array('sf_guard_group' => $sf_guard_group, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

</div>
