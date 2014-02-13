<script type="text/javascript">
function showGroup(){
	if ($('select#account').val() == 0){
		$('div.showGroup').hide();
	} else {
		$('div.showGroup').fadeIn();
	}
}
$(function(){
	$('.helpbutton').popover({placement: 'right', html: 'true'});

	$('select#account').change(function(){
		showGroup();
	});
	showGroup();
});
</script>

<form name="form" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">
	
	<div class="headingleft">
	<h1 class="headingleft">Edit Web Form</h1>
	<a href="<?php echo site_url('/admin/webforms/viewall'); ?>" class="btn">Back to Web Forms <i class="icon-arrow-up"></i></a>
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
	<?php if (isset($message)): ?>
		<div class="alert">
			<?php echo $message; ?>
		</div>
	<?php endif; ?>

	<label for="formName">Form Name:</label>
	<?php echo @form_input('formName', set_value('formName', $data['formName']), 'id="formName" class="form-control"'); ?>
	<br class="clear" />
	
	<label for="fieldSet">Type of Form:</label>
	<?php 
		$values = array(
			3 => 'Contact Form',
			2 => 'Newsletter Form',
			1 => 'Inquiry Form',
			0 => 'Custom'
		);
		echo @form_dropdown('fieldSet',$values,set_value('fieldSet', $data['fieldSet']), 'id="fieldSet" class="form-control"'); 
	?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Type Help" data-content="Automatically populate your form with fields based on the type, or select 'Custom' to not populate with fields."><i class="icon-question-sign" title="Type Help"></i></a>
	</span>
	<br class="clear" />
	
	<label for="fileTypes">Allow Files?</label>
	<?php 
		$values = array(
			'' => 'Don\'t allow files',
			'jpg|gif|png|jpeg' => 'Allow images',
			'doc|docx|pdf|txt|rtf|xls' => 'Allow documents',
			'jpg|gif|png|jpeg|doc|docx|pdf|txt|rtf|xls|swf' => 'Allow images and documents',
			'jpg|gif|png|jpeg|doc|docx|pdf|txt|rtf|xls|swf|mp3|mp4' => 'Allow all files'
		);
		echo @form_dropdown('fileTypes',$values,set_value('fileTypes', $data['fileTypes']), 'id="fileTypes" class="form-control"'); 
	?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="File Help" data-content="You can allow users to upload files such as images and documents if you wish. Form must have the correct enctype."><i class="icon-question-sign" title="File Help"></i></a>
	</span>
	<br class="clear" />

	<br />

	<h2 class="underline">Outcomes <small>(optional)</small></h2>	

	<label for="account">Create User Account?</label>
	<?php 
		$values = array(
			0 => 'No',
			1 => 'Yes',
		);
		echo @form_dropdown('account',$values,set_value('account', $data['account']), 'id="account" class="form-control"'); 
	?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="Optionally create user account."><i class="icon-question-sign" title="Help"></i></a>
	</span>
	<br class="clear" />

	<div class="showGroup">
		<label for="groupID">Move to Group:</label>
		<?php 
			$values = array(
				0 => 'None'
			);		
			if ($groups)
			{
				foreach($groups as $group)
				{
					$values[$group['groupID']] = $group['groupName'];
				}
			}
			echo @form_dropdown('groupID',$values,set_value('groupID', $data['groupID']), 'id="groupIDs" class="form-control"'); 
		?>
		<span class="tip">You can only move the user to a group without admin permissions.</span>
		<br class="clear" />
	</div>	

	<label for="outcomeEmails">Emails to CC:</label>
	<?php echo @form_input('outcomeEmails', set_value('outcomeEmails', $data['outcomeEmails']), 'id="outcomeEmails" class="form-control"'); ?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="CC Help" data-content="This will override the default email that the ticket is CCed to. Separate emails with a comma."><i class="icon-question-sign" title="CC Help"></i></a>
	</span>
	<br class="clear" />

	<label for="outcomeRedirect">Redirect:</label>
	<?php echo @form_input('outcomeRedirect', set_value('outcomeRedirect', $data['outcomeRedirect']), 'id="outcomeRedirect" class="form-control"'); ?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Redirect Help" data-content="Here you can redirect the user to a URL on your website if you wish (e.g. form/success)."><i class="icon-question-sign" title="Redirect Help"></i></a>
	</span>
	<br class="clear" />

	<label for="outcomeMessage">Message:</label>
	<?php echo @form_textarea('outcomeMessage', set_value('outcomeMessage', $data['outcomeMessage']), 'id="outcomeMessage" class="form-control small"'); ?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Message Help" data-content="Here you can display a custom message after the user submits the form."><i class="icon-question-sign" title="Message Help"></i></a>
	</span>
	<br class="clear" />
<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>

<br class="clear" />

<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
