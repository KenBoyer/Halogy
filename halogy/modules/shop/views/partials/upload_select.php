<?php
// Upload_select partial for generating uploads laid out for user selection
// created 9-4-2013
?>
	<h4>You now have more than one photo in our system. Select the photo you wish to get processed from among the thumbnails below. When you select it, that photo will be made available for cropping and other options, and the "Continue" button will become visible.</h4>
	<h3>Number of uploaded photos: <?php echo $upload_count;?></h3>
	<div class="row-fluid">
	<ul class="thumbnails">
<?php
	$i = 0;
	foreach ($uploads as $upload)
	{
?>
		<li class="span4">
        <div class="thumbnail"><img src="<?php echo site_url($this->uploads->uploadsPath.'/'.$upload['filename']); ?>" alt="<?php echo $upload['uploadName']; ?>" class="upload-select" id="<?php echo $upload['uploadID']; ?>" />
		<p>Filename: <?php echo $upload['uploadName']; ?></p>
		<p>Description: <small><?php echo $upload['description']; ?></small></p>
		<p>Upload date: <?php dateFmt($upload['dateCreated'], ($this->site->config['dateOrder'] == 'MD') ? 'M jS Y' : 'jS M Y'); ?></p>
		<?php echo anchor('/shop/select_upload/'.$upload['uploadID'],  'Select <i class="icon-edit"></i>', 'class="btn btn-info edit"'); ?>
<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
		</div>
		</li>
<?php
		$i++;
		if ($i == $this->shop->siteVars['shopItemsPerRow'])
		{
			// row "padding"
			echo '</ul></div><div class="row-fluid"><ul class="thumbnails">';
		}
	}
?>
	</div>
