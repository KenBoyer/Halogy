<div class="headingleft">
	<h1 class="headingleft">User Groups</h1>
</div>

<div class="headingright">

	<?php if (in_array('users', $this->permission->permissions)): ?>
		<a href="<?php echo site_url('/admin/users'); ?>" class="btn btn-info">Users</a>
	<?php endif; ?>

	<?php if (in_array('users_groups', $this->permission->permissions)): ?>
		<a href="<?php echo site_url('/admin/users/add_group'); ?>" class="btn btn-success">Add Group <i class="icon-plus-sign"></i></a>
	<?php endif; ?>
</div>

<?php if ($permission_groups): ?>

<?php echo $this->pagination->create_links(); ?>

<table class="default clear">
	<tr>
		<th><?php echo order_link('/admin/users/viewall','groupName','Group name'); ?></th>
		<th class="tiny">&nbsp;</th>
		<th class="tiny">&nbsp;</th>		
	</tr>
<?php foreach ($permission_groups as $group): ?>
	<tr>
		<td><?php echo (in_array('users_groups', $this->permission->permissions)) ? anchor('/admin/users/edit_group/'.$group['groupID'], $group['groupName']) : $group['groupName']; ?></td>
		<td class="tiny">
			<?php echo anchor('/admin/users/edit_group/'.$group['groupID'], 'Edit'); ?>
		</td>
		<td class="tiny">
			<?php echo anchor('/admin/users/delete_group/'.$group['groupID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->pagination->create_links(); ?>

<br class="clear" />
<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

<p class="clear">There are no permission groups set up yet.</p>

<?php endif; ?>