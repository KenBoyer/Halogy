<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">

	<div class="headingleft">
	<h1 class="headingleft">Edit Forum</h1>
	<a href="<?php echo site_url('/admin/forums/forums'); ?>" class="btn">Back to Forums <i class="icon-arrow-up"></i></a>
	</div>

	<div class="headingright">
		<button type="submit" class="btn btn-success">Save Changes <i class="icon-save"></i></button>
	</div>

	<div class="clear"></div>

	<?php if ($errors = validation_errors()): ?>
		<div class="alert alert-error">
			<?php echo $errors; ?>
		</div>
	<?php endif; ?>

	<label for="forumName">Forum Name:</label>
	<?php echo @form_input('forumName', set_value('forumName', $data['forumName']), 'id="forumName" class="form-control"'); ?>
	<br class="clear" />

	<label for="description">Description:</label>
	<?php echo @form_input('description', set_value('description', $data['description']), 'id="description" class="form-control"'); ?>
	<br class="clear" />

	<label for="category">Category: <small>[<a href="<?php echo site_url('/admin/forums/categories'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')">update</a>]</small></label>
	<?php
	if ($categories):
		foreach ($categories as $category):
			$options[$category['catID']] = $category['catName'];
		endforeach;
		
		echo @form_dropdown('catID',$options,set_value('catID', $data['catID']),'id="category" class="form-control"');
	endif;
	?>	
	<br class="clear" />	

	<label for="groupID">Group:</label>
	<?php 
		$values = array(
			0 => 'Everyone',
			$this->session->userdata('groupID') => 'Administrators only'
		);
		if ($groups)
		{
			foreach($groups as $group)
			{
				$values[$group['groupID']] = $group['groupName'];
			}
		}					
		echo @form_dropdown('groupID',$values,$data['groupID'], 'id="groupID" class="form-control"'); 
	?>
	<span class="tip">Who has access to this forum?</span>
	<br class="clear" />

	<label for="active">Active?</label>
	<?php
		$options = array();
		$options[1] = 'Yes';
		$options[0] = 'No';		
		echo @form_dropdown('active',$options,set_value('active', $data['active']),'id="active" class="form-control"');

	?>
	<br class="clear" /><br />
<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>
