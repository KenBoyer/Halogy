<script type="text/javascript">
function preview(el){
	$.post('<?php echo site_url('/admin/files/preview'); ?>', { body: $(el).val() }, function(data){
		$('div.preview').html(data);
	});
}

$(function(){
	$('.helpbutton').popover({placement: 'right', html: 'true'});

	$('textarea#body').focus(function(){
		$('.previewbutton').show();
	});
	$('textarea#body').blur(function(){
		preview(this);
	});
	preview($('textarea#body'));	
});
</script>

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

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="default">
	<div style="width: 40%; float: left;">

	<label for="fileRef">Reference:</label>
	<?php echo @form_input('fileRef', $data['fileRef'], 'class="form-control" id="fileRef"'); ?>
	<br class="clear" />

	<label for="folderID">Folder: <small>[<a href="<?php echo site_url('/admin/files/folders'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')">update</a>]</small></label>
	<?php
		$options[0] = 'No Folder';
		if ($folders):
			foreach ($folders as $folderID):
				$options[$folderID['folderID']] = $folderID['folderName'];
			endforeach;
		endif;
			
		echo @form_dropdown('folderID',$options,set_value('folderID', $data['folderID']),'id="folderID" class="form-control"');
	?>	
	<br class="clear" />

	<label for="buttons">Formatting:</label>
	<div class="buttons" id="buttons">
		<a href="#" class="btn boldbutton" title="Bold"><i class="icon-bold"></i></a>
		<a href="#" class="btn italicbutton" title="Italic"><i class="icon-italic"></i></a>
		<a href="#" class="btn btn-small h1button" title="Heading 1">h1</a>
		<a href="#" class="btn btn-small h2button" title="Heading 2">h2</a>
		<a href="#" class="btn btn-small h3button" title="Heading 3">h3</a>
		<a href="#" class="btn urlbutton"><i class="icon-link" title="Insert URL Link"></i></a>
		<a href="<?php echo site_url('/admin/images/browser'); ?>" class="btn halogycms_imagebutton" title="Insert Image"><i class="icon-picture"></i></a>
		<a href="<?php echo site_url('/admin/files/browser'); ?>" class="btn halogycms_filebutton" title="Insert File"><i class="icon-file-alt"></i></a>
		<a href="#" class="btn helpbutton" data-toggle="popover" data-original-title="Formatting Help" data-content="<p>Select desired text, then click button to format or insert.</p><p>Additional formatting options:</p><ul><li>+ before list elements</li><li>> before block quotes</li><li>4 space indentation to format code listings</li><li>3 hyphens on a line by themselves to make a horizontal rule</li><li>` (backtick quote) to span code within text</li></ul>"><i class="icon-question-sign" title="Formatting Help"></i></a>
		<a href="#" class="btn previewbutton" title="Update Preview"><i class="icon-eye-open"></i></a>
	</div>

	<label for="body">Description:</label>
	<?php echo @form_textarea('description', set_value('description', $data['description']), 'id="body" class="form-control code"'); ?>
	<br class="clear" />

<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
	<button type="submit" class="btn btn-success" id="submit">Save Changes <i class="icon-save"></i></button>
	<a href="<?php echo $this->session->userdata('lastPage'); ?>" class="btn cancel">Cancel <i class="icon-remove-sign"></i></a>
	<br class="clear" />
	</div>

	<div style="float: right; width: 60%;">
		<div class="preview"></div>
	</div>
</form>

<br class="clear" />