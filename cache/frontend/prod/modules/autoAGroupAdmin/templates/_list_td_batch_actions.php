<td class="batch-actions first">
  <?php if ((!method_exists($sf_guard_group, 'userHasPrivilege')) || $sf_guard_group->userHasPrivilege('edit')): ?>
  <input type="checkbox" name="ids[]" value="<?php echo $sf_guard_group->getPrimaryKey() ?>" class="a-admin-batch-checkbox a-checkbox" />
  <?php endif; ?>
</td>
