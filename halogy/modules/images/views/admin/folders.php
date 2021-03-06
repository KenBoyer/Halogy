<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/images/order/folder'); ?>',$(this).sortable('serialize'),function(data){ });
};

function initOrder(el){
	$(el).sortable({ 
		axis: 'y',
	    revert: false, 
	    delay: '80',
	    opacity: '0.5',
	    update: setOrder
	});
};

$(function(){
	$('a.toggle').click(function(event){ 
		event.preventDefault();		
		$('div.hidden').slideToggle('400');
	});

	$('a.edit').click(function(event){
		event.preventDefault();
		$(this).parent().siblings('.col1').children('input').show();
		$(this).parent().siblings('.col1').children('span').hide();
	});

	initOrder('ol.order');
});
</script>

<div class="headingleft">
<h1 class="headingleft">Image Folders</h1>
</div>

<div class="headingright">
	<a href="<?php echo site_url('/admin/images/viewall'); ?>" class="btn btn-info">View Images <i class="icon-eye-open"></i></a>
	<a href="#add-folder" class="btn btn-info accordion-toggle" data-toggle="collapse" data-parent="#accordion">Add Folder <i class="icon-plus-sign"></i></a>
</div>

<div class="clear"></div>

<div class="panel-group" id="accordion">
<div id="add-folder" class="panel collapse">
<div class="panel-heading">Add File Folder</div>
  <div class="panel-body">
	<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">
	
		<label for="folderName">Folder Name:</label>
		
		<?php echo @form_input('folderName',$images_folders['folderName'], 'class="form-control" id="folderName"'); ?>
<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
		<input type="submit" value="Add Folder" id="submit" class="btn btn-success" />

		<br class="clear" />
		
	</form>
</div>
</div>
</div>

<?php if ($folders): ?>

<form method="post" action="<?php echo site_url('/admin/images/edit_folder'); ?>">

	<ol class="order">
	<?php foreach ($folders as $folder): ?>
		<li id="image_folders-<?php echo $folder['folderID']; ?>">
			<div class="col1">
				<span><strong><?php echo $folder['folderName']; ?></strong> <small>(<?php echo url_title(strtolower($folder['folderName'])); ?>)</small></span>
				<?php echo @form_input($folder['folderID'].'[folderName]', $folder['folderName'], 'class="form-control hide" title="folder Name"'); ?><button type="submit" class="btn btn-success hide">Edit <i class="icon-edit"></i></button>
			</div>
			<div class="col2">
				&nbsp;
			</div>
			<div class="buttons">
				<a href="#" class="btn btn-info edit">Edit <i class="icon-edit"></i></a>
				<a href="<?php echo site_url('/admin/images/delete_folder/'.$folder['folderID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="btn btn-danger">Delete <i class="icon-trash"></i></a>
			</div>
			<div class="clear"></div>
		</li>
	<?php endforeach; ?>
	</ol>
<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>

<?php else: ?>

<p>No folders have been created yet.</p>

<?php endif; ?>

