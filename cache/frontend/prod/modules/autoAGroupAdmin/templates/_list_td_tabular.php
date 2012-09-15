<td class="a-admin-text name"><?php echo link_to($sf_guard_group->getName(), 'a_group_admin_edit', $sf_guard_group) ?></td>
<td class="a-admin-text description"><?php echo $sf_guard_group->getDescription() ?></td>
<td class="a-admin-date created_at"><?php echo false !== strtotime($sf_guard_group->getCreatedAt()) ? format_date($sf_guard_group->getCreatedAt(), "f") : '&nbsp;' ?></td>
