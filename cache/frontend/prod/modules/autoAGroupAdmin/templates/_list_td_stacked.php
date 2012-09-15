<td colspan="3">
  <?php echo __('%%name%% - %%description%% - %%created_at%%', array('%%name%%' => link_to($sf_guard_group->getName(), 'a_group_admin_edit', $sf_guard_group), '%%description%%' => $sf_guard_group->getDescription(), '%%created_at%%' => false !== strtotime($sf_guard_group->getCreatedAt()) ? format_date($sf_guard_group->getCreatedAt(), "f") : '&nbsp;'), 'apostrophe') ?>
</td>
