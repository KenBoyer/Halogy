<script type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
$(function(){
	$('.helpbutton').popover({placement: 'right', html: 'true'});

	tinymce.init({
		selector: "textarea#body",
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
/*		file_browser_callback: function(field_name, url, type, win) { 
        win.document.getElementById(field_name).value = 'my browser value';
		win.open('/admin/images/browser'
		} */
	});

	$flag = false;
	$('div.permissions input[type="checkbox"]').each(function(){
		if ($(this).attr('checked')) {
			$(this).parent('div').prev('div').children('input[type="checkbox"]').attr('checked', true);
		}
	});
	$('.selectall').click(function(){
		$el = $(this).parent('div').next('div').children('input[type="checkbox"]');
		$flag = $(this).attr('checked');
		if ($flag) {
			$($el).attr('checked', true);
		}
		else {
			$($el).attr('checked', false);
		}
	});
	$('.seemore').click(function(){
		$el = $(this).parent('div').next('div');
		$($el).toggle('400');
	});
	$('a.selectall').click(function(event){
		event.preventDefault();
		$('input[type="checkbox"]').attr('checked', true);
	});
	$('a.deselectall').click(function(event){
		event.preventDefault();
		$('input[type="checkbox"]').attr('checked', false);
	});
});
</script>

	<div class="headingleft">
		<h1 class="headingleft">Edit User Group</h1>
		<a href="<?php echo site_url('/admin/users/groups'); ?>" class="btn">Back to User Groups <i class="icon-arrow-up"></i></a>
	</div>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">

	<div class="headingright">
		<input type="submit" value="Save Changes" class="btn btn-success" />
	</div>
	
	<div class="clear"></div>
	
	<?php if ($errors = validation_errors()): ?>
		<div class="alert alert-error">
			<?php echo $errors; ?>
		</div>
	<?php endif; ?>
	<?php if (isset($message)): ?>
		<div class="alert">
			<?php echo $message; ?>
		</div>
	<?php endif; ?>

	<label for="groupName">Group Name:</label>
	<?php echo @form_input('groupName',set_value('groupName', $data['groupName']), 'id="groupName" class="form-control"'); ?>
	<br class="clear" />

<div class="row-fluid">

	<?php if ($permissions): ?>

<div class="span6">

	<h2 class="underline">Administrative Permissions</h2>
	
	<p><a href="#" class="selectall btn">Select All</a> <a href="#" class="deselectall btn">De-Select All</a></p>
	
	<?php foreach ($permissions as $cat => $perms): ?>

		<div class="perm-heading">
			<label for="<?php echo strtolower($cat); ?>_all" class="radio"><?php echo $cat; ?></label>
			<input type="checkbox" class="selectall checkbox" id="<?php echo strtolower($cat); ?>_all" />
			<input type="button" value="See more" class="seemore btn" />
		</div>

		<div class="permissions">

		<?php foreach ($perms as $perm): ?>

			<label for="<?php echo 'perm_'.$perm['key']; ?>" class="radio"><?php echo $perm['permission']; ?></label>
			<?php echo @form_checkbox('perm'.$perm['permissionID'], 1, set_value('perm'.$perm['permissionID'], $data['perm'.$perm['permissionID']]), 'id="'.'perm_'.$perm['key'].'" class="checkbox"'); ?>
			<br class="clear" />

		<?php endforeach; ?>

		</div>

	<?php endforeach; ?>
</div>
	<?php endif; ?>
<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>

<div class="span6">

	<h2 class="underline">Group Emailer</h2>
	<!-- Add group-based email -->

<form method="post" action="/admin/users/send_group_message" class="default">
	<input type="hidden" name="groupName" id="groupName" value="<?php echo $data['groupName']; ?>" />

	<!-- TinyMCE text box to edit email -->
	<label for="body">Email content:</label>
	<?php echo @form_textarea('body', set_value('body', $data['body']), 'id="body" class="form-control code"'); ?>

<!-- Add links for more information; hooks from TinyMCE -->

<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
	<br class="clear" />

	<input type="submit" value="Send email" class="btn btn-success" />
</form>


</div>

<br class="clear" />
<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
