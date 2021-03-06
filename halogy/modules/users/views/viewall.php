<style type="text/css">
.ac_results { padding: 0px; border: 1px solid black; background-color: white; overflow: hidden; z-index: 99999; }
.ac_results ul { width: 100%; list-style-position: outside; list-style: none; padding: 0; margin: 0; }
.ac_results li { margin: 0px; padding: 2px 5px; cursor: default; display: block; font: menu; font-size: 12px; line-height: 16px; overflow: hidden; }
.ac_results li span.email { font-size: 10px; } 
.ac_loading { background: white url('<?php echo $this->config->item('staticPath'); ?>/images/loader.gif') right center no-repeat; }
.ac_odd { background-color: #eee; }
.ac_over { background-color: #0A246A; color: white; }
</style>

<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.fieldreplace.js"></script>
<script type="text/javascript">
$(function(){
    $('#searchbox').fieldreplace();
	function formatItem(row) {
		if (row[0].length) return row[1]+'<br /><span class="email">('+row[0]+')</span>';
		else return 'No results';
	}
	$('#searchbox').autocomplete("<?php echo site_url('/admin/users/ac_users'); ?>", { delay: "0", selectFirst: false, matchContains: true, formatItem: formatItem, minChars: 2 });
	$('#searchbox').result(function(event, data, formatted){
		$(this).parent('form').submit();
	});	
});
</script>

<div class="headingleft">
	<h1 class="headingleft">Users</h1>
</div>

<div class="headingright">

	<form method="post" action="<?php echo site_url('/admin/users/viewall'); ?>" class="default" id="search">
		<div class="input-append">
			<input type="text" name="searchbox" id="searchbox" class="span2" title="Search Users..." />
			<button class="btn btn-primary" type="submit" id="searchbutton"><i class="icon-search"></i></button>
		</div>
<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
	</form>

	<?php if (in_array('users_import', $this->permission->permissions)): ?>
		<a href="<?php echo site_url('/admin/users/import'); ?>" class="btn btn-info">Import Users <i class="icon-upload-alt"></i></a>
		<a href="<?php echo site_url('/admin/users/export'); ?>" class="btn btn-info">Export Users <i class="icon-download-alt"></i></a>		
	<?php endif; ?>

	<?php if (in_array('users_groups', $this->permission->permissions)): ?>
		<a href="<?php echo site_url('/admin/users/groups'); ?>" class="btn btn-info">Groups</a>
	<?php endif; ?>	

	<?php if (in_array('users_edit', $this->permission->permissions)): ?>
		<a href="<?php echo site_url('/admin/users/add'); ?>" class="btn btn-success">Add User <i class="icon-plus-sign"></i></a>
	<?php endif; ?>
</div>

<?php if ($users): ?>

<?php echo $this->pagination->create_links(); ?>

<table class="default clear">
	<tr>
		<th><?php echo order_link('/admin/users/viewall','username','Username'); ?></th>
		<th><?php echo order_link('/admin/users/viewall','datecreated','Date Created'); ?></th>
		<th><?php echo order_link('/admin/users/viewall','lastname','Name'); ?></th>
		<th><?php echo order_link('/admin/users/viewall','email','Email'); ?></th>
		<th><?php echo order_link('/admin/users/viewall','groupid','Group'); ?></th>
		<th class="tiny">&nbsp;</th>
		<th class="tiny">&nbsp;</th>		
	</tr>
<?php foreach ($users as $user): ?>
<?php 
	$class = '';
	if ($user['groupID'] == $this->site->config['groupID'] || $user['groupID'] < 0) $class = 'class="blue"';
	elseif (@in_array($user['groupID'], $adminGroups)) $class = 'class="orange"';

	$username = ($user['username']) ? $user['username'] : '(not set)';
	$userlink = (in_array('users_edit', $this->permission->permissions)) ? anchor('/admin/users/edit/'.$user['userID'], $username) : $username;
	
?>
	<tr <?php echo $class; ?>>
		<td><?php echo $userlink; ?></td>
		<td><?php echo dateFmt($user['dateCreated'], '', '', TRUE); ?></td>
		<td><?php echo trim($user['firstName'].' '.$user['lastName']); ?></td>
		<td><?php echo $user['email']; ?></td>
		<td>
			<?php
				if ($user['groupID'] == $this->site->config['groupID'] || $user['groupID'] < 0) echo 'Administrator';
				elseif (@in_array($user['groupID'], $adminGroups)) echo $userGroups[$user['groupID']];
				elseif (@in_array($user['groupID'], $normalGroups)) echo $userGroups[$user['groupID']];
			?>
		</td>
		<td class="tiny">
			<?php if (in_array('users_edit', $this->permission->permissions)): ?>
				<?php echo anchor('/admin/users/edit/'.$user['userID'], 'Edit <i class="icon-edit"></i>', 'class="btn btn-info"'); ?>
			<?php endif; ?>
		</td>
		<td class="tiny">
			<?php if (in_array('users_delete', $this->permission->permissions)): ?>
				<?php echo anchor('/admin/users/delete/'.$user['userID'], 'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this user?\')', 'class' => 'btn btn-danger')); ?>
			<?php endif; ?>

		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->pagination->create_links(); ?>

<br class="clear" />
<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

<p class="clear">No users found.</p>

<?php endif; ?>

