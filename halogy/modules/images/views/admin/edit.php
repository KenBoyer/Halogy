<script type="text/javascript">
function preview(el){
	$.post('<?php echo site_url('/admin/images/preview'); ?>', { body: $(el).val() }, function(data){
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

<div id="edit-image" class="panel collapse in">
<div class="panel-heading">Edit Image</div>
<div class="panel-body">
<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="default">
	<div class="row">
	<div class="col-lg-5">
	<label for="image">Image:</label>
	<div class="uploadfile">
		<?php echo @form_upload('image', '', 'size="16" id="image"'); ?>
	</div>
	<br class="clear" />

	<label for="folderID">Folder: <small>[<a href="<?php echo site_url('/admin/images/folders'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')">update</a>]</small></label>
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

	<label for="imageName">Name:</label>
	<?php echo @form_input('imageName', $data['imageName'], 'class="form-control" id="imageName"'); ?>
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
	// TBD: Should this be readonly? Why would anyone change it?
	?>
	<label for="imageRef">Reference:</label>
	<?php echo @form_input('imageRef', $data['imageRef'], 'class="form-control" id="imageRef"'); ?>
	<br class="clear" />

	<label for="class">Display:</label>
	<?php
		$values = array(
			'default' => 'Default',
			'left' => 'Left Align',
			'center' => 'Center Align',
			'right' => 'Right Align',
			'bordered' => 'Border',
			'bordered left' => 'Border - Left Align',
			'bordered center' => 'Border - Center Align',
			'bordered right' => 'Border - Right Align',
			'full' => 'Full Width',
			'' => 'No Style'
		);
		echo @form_dropdown('class',$values,$data['class'], 'class="form-control"');
	?>
	<br class="clear" />

	<label for="maxsize">Max Size (px):</label>
	<?php echo @form_input('maxsize', set_value('maxsize', (($data['maxsize']) ? $data['maxsize'] : '')), 'class="form-control" id="maxsize"'); ?>
	<br class="clear" /><br />
<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
	<button type="submit" class="btn btn-success accordion-toggle" id="submit">Save Changes <i class="icon-save"></i></button>
	<a href="#edit-image" class="btn btn-default accordion-toggle" data-toggle="collapse" data-parent="#accordion">Cancel <i class="icon-remove-sign"></i></a>
	<br class="clear" />
	</div>

	<div class="col-lg-7">
		<?php
			$image = $this->uploads->load_image($data['imageRef']);
			$thumb = $this->uploads->load_image($data['imageRef'], true);
			$imagePath = $image['src'];
			$imageThumbPath = $thumb['src'];
		?>
		<?php echo ($thumb = display_image($imageThumbPath, $data['imageName'], 600, 'class="pic" ')) ? $thumb : display_image($imagePath, $data['imageName'], 600, 'class="pic"'); ?>

		<div class="preview"></div>
	</div>
	</div>

</form>
</div>
</div>

<br class="clear" />