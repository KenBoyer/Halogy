<style type="text/css">
.ac_results { padding: 0px; border: 1px solid black; background-color: white; overflow: hidden; z-index: 99999; }
.ac_results ul { width: 100%; list-style-position: outside; list-style: none; padding: 0; margin: 0; }
.ac_results li { margin: 0px; padding: 2px 5px; cursor: default; display: block; font: menu; font-size: 12px; line-height: 16px; overflow: hidden; }
.ac_results li span.email { font-size: 10px; } 
.ac_loading { background: white url('<?php echo $this->config->item('staticPath'); ?>/images/loader.gif') right center no-repeat; }
.ac_odd { background-color: #eee; }
.ac_over { background-color: #0A246A; color: white; }

div#gallery p {
margin: 8px 0 4px;
font-size: 1.2em;
}
</style>

<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/images/order/image'); ?>',$(this).sortable('serialize'),function(data){ });
};

function initOrder(el){
	$('ol.order').height($('ol.order').height());
	$(el).sortable({ 
		axis: 'y',
	    revert: false, 
	    delay: '80',
		distance: '10',
	    opacity: '0.5',
	    update: setOrder
	});
};

$(function(){
	$('.edit').click(function(event){
		event.preventDefault();
		$.scrollTo(0, '200');
		$('div#loader').load(this.href, function(){
		});
	});
	
	function formatItem(row) {
		if (row[0].length) return row[1]+'<br /><span class="email">(#'+row[0]+')</span>';
		else return 'No results';
	}

	$('select#folderID').change(function(){
		var folderID = ($(this).val());
		window.location.href = '<?php echo site_url('/admin/images/viewall'); ?>/'+folderID;
	});

	initOrder('ol.order, ol.order ol');
});
</script>

<link rel="stylesheet" href="<?php echo $this->config->item('staticPath'); ?>/css/jquery.hoverZoom.css">
<script src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.hoverZoom.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.thumb img').hoverZoom({speedView:600, speedRemove:400, showCaption:true, speedCaption:600, debug:true, hoverIntent: true, loadingIndicatorPos: 'center'});
	});
</script>

<div class="headingleft">
<h1 class="headingleft">Images</h1>
</div>

<div class="headingright">

	<div class="controls controls-row">
	<form method="post" action="<?php echo site_url('/admin/images/viewall'); ?>" class="search" id="search" style="display: none;">
		<div class="input-append">
			<input type="text" name="searchbox" id="searchbox" class="span2 inactive" title="Search Images..." />
			<button class="btn btn-primary" type="submit" id="searchbutton"><i class="icon-search"></i></button>
		</div>
	</form>

	<label for="folderID">Folder:</label> 
	<?php
		$options = '';
		$options['me'] = 'My Images';
		if (@in_array('images_all', $this->permission->permissions)):
			$options['all'] = 'View All Images';

			if ($folders):
				foreach ($folders as $folder):
					$options[$folder['folderID']] = $folder['folderName'];
				endforeach;
			endif;
		endif;
		echo form_dropdown('folderID', $options, $folderID, 'id="folderID" class="form-control"');
	?>

	<?php if ($this->site->config['plan'] = 0 || $this->site->config['plan'] = 6 || (($this->site->config['plan'] > 0 && $this->site->config['plan'] < 6) && $quota < $this->site->plans['storage'])): ?>

		<a href="#upload-zip" class="btn btn-info accordion-toggle" data-toggle="collapse" data-parent="#accordion">Upload Zip <i class="icon-upload"></i></a>
		<a href="#upload-image" class="btn btn-info accordion-toggle" data-toggle="collapse" data-parent="#accordion">Upload Image <i class="icon-upload"></i></a>

	<?php endif; ?>
	</div>

</div>

<?php if ($errors = validation_errors()): ?>
	<div class="alert alert-error clear">
		<?php echo $errors; ?>
	</div>
<?php endif; ?>

<?php if ($this->site->config['plan'] > 0 && $this->site->config['plan'] < 6): ?>

	<?php if ($quota > $this->site->plans['storage']): ?>
	
	<div class="error clear">
		<p>You have gone over your storage capacity, we will be contacting you soon.</p>
	</div>
	
	<div class="quota">
		<div class="over"><?php echo floor($quota / $this->site->plans['storage'] * 100); ?>%</div>
	</div>
	
	<?php else: ?>
	
	<div class="quota">
		<div class="used" style="width: <?php echo ($quota > 0) ? (floor($quota / $this->site->plans['storage'] * 100)) : 0; ?>%"><?php echo floor($quota / $this->site->plans['storage'] * 100); ?>%</div>
	</div>
	
	<?php endif; ?>

	<p><small>You have used <strong><?php echo number_format($quota); ?>kb</strong> out of your <strong><?php echo number_format($this->site->plans['storage']); ?> KB</strong> quota.</small></p>

<?php endif; ?>

<div class="clear">

<div class="panel-group" id="accordion">
<div id="upload-image" class="panel collapse">
<div class="panel-heading">Upload Image</div>
  <div class="panel-body">
  <form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="default">
	
		<label for="image">Image:</label>
		<div class="uploadfile">
			<?php echo @form_upload('image', '', 'size="16" id="image"'); ?>
		</div>
		<br class="clear" />

		<label for="imageFolderID">Folder:</label>
		<?php
			$options[0] = 'No Folder';
			if ($folders):
				foreach ($folders as $folderID):
					$options[$folderID['folderID']] = $folderID['folderName'];
				endforeach;
			endif;
				
			echo @form_dropdown('folderID',$options,set_value('folderID', $data['folderID']),'id="imageFolderID" class="form-control"');
		?>	
		<br class="clear" />
		
		<label for="imageName">Name:</label>
		<?php echo @form_input('imageName', $data['imageName'], 'class="form-control" id="imageName"'); ?>
		<br class="clear" />

		<label for="imageDesc">Description:</label>
		<?php echo @form_textarea('description', set_value('description', $data['description']), 'id="body" class="form-control code"'); ?>
		<br class="clear" />

<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
		<button type="submit" class="btn btn-success" id="submit">Upload Image <i class="icon-upload"></i></button>
		<a href="#upload-image" class="btn btn-default accordion-toggle" data-toggle="collapse" data-parent="#accordion">Cancel <i class="icon-remove-sign"></i></a>
	</form>
	</div>
</div>

<div id="upload-zip" class="panel collapse">
<div class="panel-heading">Upload ZIP</div>
	<div class="panel-body">
	<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="default">
	
		<label for="image">ZIP File:</label>
		<div class="uploadfile">
			<?php echo @form_upload('zip', '', 'size="16" id="image"'); ?>
		</div>
		<br class="clear" />

		<label for="zipFolderID">Folder: <small>[<a href="<?php echo site_url('/admin/images/folders'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')">update</a>]</small></label>
		<?php
			$options[0] = 'No Folder';
			if ($folders):
				foreach ($folders as $folderID):
					$options[$folderID['folderID']] = $folderID['folderName'];
				endforeach;
			endif;
				
			echo @form_dropdown('folderID',$options,set_value('folderID', $data['folderID']),'id="zipFolderID" class="form-control"');
		?>
		<br class="clear" /><br />		
<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
		<input type="submit" value="Upload Zip" name="upload_zip" class="btn btn-success" />
		<a href="#upload-zip" class="btn btn-default accordion-toggle" data-toggle="collapse" data-parent="#accordion">Cancel</a>
			
	</form>
	</div>
</div>

<div id="loader" class="clear"></div>
</div>

<?php if ($images): ?>

	<!-- https://github.com/blueimp/Bootstrap-Image-Gallery -->
	<!-- modal-gallery is the modal dialog used for the image gallery -->
	<div id="modal-gallery" class="modal modal-gallery hide fade" tabindex="-1">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3 class="modal-title"></h3>
		</div>
		<div class="modal-body"><div class="modal-image"></div></div>
		<div class="modal-footer">
			<a class="btn btn-primary modal-next">Next <i class="icon-arrow-right icon-white"></i></a>
			<a class="btn btn-info modal-prev"><i class="icon-arrow-left icon-white"></i> Previous</a>
			<a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play icon-white"></i> Slideshow</a>
			<a class="btn modal-download" target="_blank"><i class="icon-download"></i> Download</a>
		</div>
	</div>

	<div id="gallery" data-toggle="modal-gallery" data-target="#modal-gallery" data-slideshow="3000">

	<script src="<?php echo $this->config->item('staticPath'); ?>/js/load-image.min.js"></script>
	<script src="<?php echo $this->config->item('staticPath'); ?>/js/bootstrap-image-gallery.min.js"></script>

	<?php echo $this->pagination->create_links(); ?>
	<ol class="order thumb">
		<?php
			$numItems = sizeof($images);
			foreach ($images as $image)
			{
				$imageData = $this->uploads->load_image($image['imageRef']);
				$imagePath = $imageData['src'];
				$imageData = $this->uploads->load_image($image['imageRef'], true);				
				$imageThumbPath = $imageData['src'];
		?>
				<li class="images" id="images-<?php echo $image['imageID']; ?>">
				<div class="col1">
				<a data-gallery="gallery" href="<?php echo $imagePath; ?>" title="<?php echo $image['imageName']; ?>">
				<?php echo ($thumb = display_image($imageThumbPath, $image['imageName'], 40, 'title="pic"')) ? $thumb : display_image($imagePath, $image['imageName'], 40, 'title="pic"'); ?>
				</a>
				</div>

				<div class="col2">
					<p><strong>
					<?php
					if ($options):
						$folderName = $options[$imageData['folderID']];
						echo $folderName.'/';
					endif;
					echo $image['imageRef'];
					?>
					</strong></p>
				</div>

				<div class="buttons">
					<?php echo anchor('/admin/images/edit/'.$image['imageID'].'/'.$this->core->encode($this->uri->uri_string()),  'Edit <i class="icon-edit"></i>', 'class="btn btn-info edit" data-parent="#accordion"'); ?>
					<?php echo anchor('/admin/images/delete/'.$image['imageID'].'/'.$this->core->encode($this->uri->uri_string()),  'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this image?\')', 'class' => 'btn btn-danger')); ?>
				</div>
				<div class="clear"></div>
				</li>
		<?php
			}
		?>
	</ol>

	<?php echo $this->pagination->create_links(); ?>

	<br class="clear" />
	<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
	</div>

<?php else: ?>

<p class="clear">You have not yet uploaded any images.</p>

<?php endif; ?>

