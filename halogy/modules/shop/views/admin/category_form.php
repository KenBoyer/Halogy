<!-- <script type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/tinymce/tinymce.min.js"></script> -->
<script type="text/javascript">
function preview(el){
	$.post('<?php echo site_url('/admin/shop/preview'); ?>', { body: $(el).val() }, function(data){
		$('div.preview').html(data);
	});
}

$(function(){
	$('.helpbutton').popover({placement: 'right', html: 'true'});

	// tinymce.init({
		// selector: "textarea#body",
		// plugins: [
			// "advlist autolink lists link image charmap print preview anchor",
			// "searchreplace visualblocks code fullscreen",
			// "insertdatetime media table contextmenu paste moxiemanager"
		// ],
		// toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	// });

	$('input.datebox').datepicker({
	dateFormat: 'd M yy'
	});

	$('textarea#body').focus(function(){
		$('.previewbutton').show();
	});
	$('textarea#body').blur(function(){
		preview(this);
	});
	preview($('textarea#body'));
});
</script>

<style>
.ui-datepicker-year{
    display:none;
}
</style>

<?php if (!$this->core->is_ajax()): ?>
<div class="headingleft">
	<h1 class="headingleft"><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Categories</h1>
</div>
<?php endif; ?>

<br class="clear" />

<?php if ($errors = validation_errors()): ?>
	<div class="error">
		<?php echo $errors; ?>
	</div>
<?php endif; ?>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">
	<div style="width: 40%; float: left;">

	<label for="catName">Title:</label>
	<?php echo @form_input('catName', $data['catName'], 'class="form-control" id="catName"'); ?>
	<br class="clear" />
		
	<label for="templateID">Parent:</label>
	<?php
		$options = '';		
		$options[0] = 'Top Level';
		if ($parents):	
			foreach ($parents as $parent):
				if ($parent['catID'] != @$data['catID']) $options[$parent['catID']] = $parent['catName'];
			endforeach;
		endif;
		
		echo @form_dropdown('parentID',$options,$data['parentID'],'id="parentID" class="form-control"');
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

	<label for="description">Description:</label>
	<?php echo @form_textarea('description',set_value('description', $data['description']), 'id="body" class="form-control code"'); ?>
	<br class="clear" />

	<label for="catStart">Start Date:</label>
	<?php echo @form_input('catStart', (($data['catStart'] > 0) ? date('d M Y', strtotime($data['catStart'])) : ''), 'id="catStart" class="form-control datebox" readonly="readonly"'); ?>
	<br class="clear" />

	<label for="catStop">Stop Date:</label>
	<?php echo @form_input('catStop', (($data['catStop'] > 0) ? date('d M Y', strtotime($data['catStop'])) : ''), 'id="catStop" class="form-control datebox" readonly="readonly"'); ?>
	<br class="clear" />

<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
	<input type="submit" value="Save Changes" class="btn btn-success" />
	<input type="button" value="Cancel" id="cancel" class="btn" />
	</div>

	<div style="float: right; width: 60%;">
		<div class="preview"></div>
	</div>
</form>

<br class="clear" />
