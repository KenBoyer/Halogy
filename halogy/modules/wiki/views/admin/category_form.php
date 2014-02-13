<script type="text/javascript">
$(function(){
	tinymce.init({
		selector: "textarea#description",
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
});
</script>

<?php if (!$this->core->is_ajax()): ?>
	<h1><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Category</h1>
<?php endif; ?>

<?php if ($errors = validation_errors()): ?>
	<div class="alert alert-error">
		<?php echo $errors; ?>
	</div>
<?php endif; ?>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">

	<label for="catName">Title:</label>
	<?php echo @form_input('catName', $data['catName'], 'class="form-control" id="catName"'); ?>
	<br class="clear" />

	<label for="templateID">Parent:</label>
	<?php
	if ($parents):
		$options = '';		
		$options[0] = 'Top Level';		
		foreach ($parents as $parent):
			if ($parent['catID'] != @$data['catID']) $options[$parent['catID']] = $parent['catName'];
		endforeach;
		
		echo @form_dropdown('parentID',$options,$data['parentID'],'id="parentID" class="form-control"');
	endif;
	?>	
	<br class="clear" />

	<label for="description">Description:</label>
	<?php echo @form_textarea('description', set_value('description', $data['description']), 'id="description" class="form-control small"'); ?>
	<br class="clear" /><br />

<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
	<input type="submit" value="Save Changes" class="btn btn-success" />
	<input type="button" value="Cancel" id="cancel" class="btn" />
	
</form>

<br class="clear" />
