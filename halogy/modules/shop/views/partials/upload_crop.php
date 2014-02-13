<?php
// Uploads partial for generating uploads laid out according to whether there are one or more than one
// created 9-4-2013

if ($upload_count > 1)
{
?>
	<h4>You have already uploaded more than one photo. When you select from among the thumbnails below, that photo will be made available for cropping and other options, and the "Continue" button will become visible.</h4>
	<form class="form-horizontal" id="select-form" name="select-form" method="post" action="/shop/select_upload">
	<h3>Number of uploaded photos: <?php echo $upload_count;?></h3>
	<div class="row-fluid">
<?php
	$i = 0;
	foreach ($uploads as $upload)
	{
?>
		<div class="span4">
        <p><img src="<?php echo site_url($this->uploads->uploadsPath.'/'.$upload['filename']); ?>" alt="<?php echo $upload['uploadName']; ?>" class="upload-select" id="<?php echo $upload['uploadID']; ?>" /></p>
		<p>Filename: <?php echo $upload['uploadName']; ?></p>
		<p>Upload date: <?php dateFmt($upload['dateCreated'], ($this->site->config['dateOrder'] == 'MD') ? 'M jS Y' : 'jS M Y'); ?></p>

		<?php echo anchor('/admin/images/edit/'.$image['imageID'].'/'.$this->core->encode($this->uri->uri_string()),  'Edit <i class="icon-edit"></i>', 'class="btn btn-info edit" data-parent="#accordion"'); ?>

<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
		</div>
		$output['uploads'][$i]['upload:caption'] = $upload['uploadName'];
		$output['uploads'][$i]['upload:date'] = dateFmt($upload['dateCreated'], ($this->site->config['dateOrder'] == 'MD') ? 'M jS Y' : 'jS M Y');

		// TBD: This needs to be the uploadID from the database table
		$output['uploads'][$i]['upload:id'] = $upload['uploadID'];
<?php
		$i++;
		if ((12 % $i) == 0)
		{
			// row "padding"
			echo '</div><div class="row-fluid">';
		}
	}
}
else
{
?>
	<form class="form-horizontal" id="crop-form" name="crop-form" method="post" action="/shop/update_upload">
	<input type="hidden" name="category" value="print-media-selection" />
	<input type="hidden" id="crop_x" name="crop_x" value="0" />
	<input type="hidden" id="crop_y" name="crop_y" value="0" />
	<input type="hidden" id="crop_w" name="crop_w" value="0" />
	<input type="hidden" id="crop_h" name="crop_h" value="0" />
	{selectedupload}
	<input type="hidden" id="uploadID" name="uploadID" value="{upload:id}" />
	<p>{upload:image}</p>
	<h3>Filename: {upload:caption}</h3>
	<h4>Upload date: {upload:date}</h4>
	{/selectedupload}
	<h4>
	  To crop your photo, place your mouse pointer on the image, then hold the left button while you select the area from the photo that you wish to have printed.
	</h4>
	<h4>
	  Image quality: {upload:quality}
	</h4>
	<p>The resolution of your uploaded picture allows for the following maximum dimensions (you will choose the final size on the following pages):</p>
	<h4>{upload:maxheight}" x {upload:maxwidth}"</h4>

<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
	<button type="submit" class="btn btn-primary btn-large">Continue <i class="icon-arrow-right"></i></button>
	</form>
<?php
}
	// populate template
	$output['rowpad'] = '';
	for ($x = 0; $x < ($this->shop->siteVars['shopItemsPerRow'] - sizeof($products)); $x++)
	{
//				$output['rowpad'] .= '<td width="'.floor((1 / $this->shop->siteVars['shopItemsPerRow']) * 100).'%">&nbsp;</td>';
		$output['rowpad'] .= '<div class="span'.floor((12 / $this->shop->siteVars['shopItemsPerRow'])).'">&nbsp;</div>';
	}

//
		// retrieve any upload data for display
		$uploads = $this->shop->get_uploads($this->session->userdata('userID'));
		if ($uploads)
		{
			$upload_count = count($uploads);
		}
		else
		{
			$upload_count = 0;
		}

		if ($upload_count > 1)
		{
			$i = 0;
//			print_r($uploads);
			foreach ($uploads as $upload)
			{
				$output['uploads'][$i]['upload:image'] = '<img src="'.site_url($this->uploads->uploadsPath.'/'.$upload['filename']).'" alt="'.$upload['uploadName'].'" class="upload-select" id="'.$upload['uploadID'].'" />';
				$output['uploads'][$i]['upload:caption'] = $upload['uploadName'];
				$output['uploads'][$i]['upload:date'] = dateFmt($upload['dateCreated'], ($this->site->config['dateOrder'] == 'MD') ? 'M jS Y' : 'jS M Y');

				// TBD: This needs to be the uploadID from the database table
				$output['uploads'][$i]['upload:id'] = $upload['uploadID'];
				$i++;
			}
			$output['uploads:count'] = $i;
			// TBD: If the user's email matches a user who has already uploaded items, then we need to display all images they have uploaded
			// as thumbnails, so they can fit nicely on the screen

			// need to build a "table" of all of the user's uploads

			// TBD: Get all uploads by this user and populate a row/column matrix:
//			$output['useruploads'] = @$this->parser->parse('partials/uploads', $data, TRUE);
		}
		else if ($upload_count == 1)
		{
			$i = 0;
//			print_r($uploads);
			foreach ($uploads as $upload)
			{
				$output['uploads'][$i]['upload:image'] = '<img src="'.site_url($this->uploads->uploadsPath.'/'.$upload['filename']).'" alt="'.$upload['uploadName'].'" id="upload" />';
				$output['uploads'][$i]['upload:caption'] = $upload['uploadName'];
				$output['uploads'][$i]['upload:date'] = dateFmt($upload['dateCreated'], ($this->site->config['dateOrder'] == 'MD') ? 'M jS Y' : 'jS M Y');

				// TBD: This needs to be the uploadID from the database table
				$output['uploads'][$i]['upload:id'] = $upload['uploadID'];
				$i++;
			}
			$output['uploads:count'] = $i;
		}
		else
		{
			// if there's still nothing in the database, what should we do?
			$uploaded_images = '';
			$files = $this->session->userdata('uploads');
			if ($files)
			{
				$i = 0;
				foreach ($files as $name => $fileData)
				{
					$output['uploads'][$i]['upload:image'] = '<img src="'.site_url($this->uploads->uploadsPath.'/'.$fileData['file_name']).'" alt="'.$fileData['client_name'].'" id="upload" />';
					$output['uploads'][$i]['upload:caption'] = $fileData['client_name'];

					// TBD: This needs to be the uploadID from the database table
					$output['uploads'][$i]['upload:id'] = $i + 1;
					$i++;
				}
			}
		}
