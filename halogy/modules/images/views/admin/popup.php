<?php if ($errors = validation_errors()): ?>
	<div class="error clear">
		<?php echo $errors; ?>
	</div>
<?php endif; ?>

<?php if ($this->core->is_ajax()): ?>

	<a class="halogycms_close" href="#"><img title="Close" src="<?php echo $this->config->item('staticPath'); ?>/images/btn_close.png"/></a>
	<a href="<?php echo site_url('/admin/images'); ?>" class="halogycms_button halogycms_confirm" target="_top">Manage Images</a>

<?php endif; ?>		

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="halogycms_form">

<?php
	$image = $this->uploads->load_image($data['imageRef']);
	$thumb = $this->uploads->load_image($data['imageRef'], true);
	$imagePath = site_url($image['src']);
	$imageThumbPath = site_url($thumb['src']);
?>	
<?php echo ($thumb = display_image($imageThumbPath, $data['imageName'], 100, 'class="pic" ')) ? $thumb : display_image($imagePath, $data['imageName'], 100, 'class="pic"'); ?>

	<label for="image">Image:</label>
	<div class="uploadfile">
		<?php echo @form_upload('image', '', 'size="16" id="image"'); ?>
	</div>
	<br class="clear" />

	<label for="folderID">Folder:</label>
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

	<label for="imageDesc">Description:</label>
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
	<input type="submit" value="Save Changes" class="button nolabel" id="submit" />
	<br class="clear" />
	
</form>

<br class="clear" />