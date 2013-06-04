<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/files/order/folder'); ?>',$(this).sortable('serialize'),function(data){ });
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
<h1 class="headingleft">File Folders</h1>
</div>

<div class="headingright">
	<a href="<?php echo site_url('/admin/files/viewall'); ?>" class="btn btn-info">View Files <i class="icon-eye-open"></i></a>
	<a href="#" class="toggle btn btn-info">Add Folder <i class="icon-plus-sign"></i></a>
</div>

<div class="clear"></div>

<div class="hidden">
	<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">
	
		<label for="folderName">Folder Name:</label>
		
		<?php echo @form_input('folderName',$files_folders['folderName'], 'class="formelement" id="folderName"'); ?>
<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
		<input type="submit" value="Add Folder" id="submit" class="button" />

		<br class="clear" />
		
	</form>
</div>

<?php if ($folders): ?>

<form method="post" action="<?php echo site_url('/admin/files/edit_folder'); ?>">

	<ol class="order">
	<?php foreach ($folders as $folder): ?>
		<li id="file_folders-<?php echo $folder['folderID']; ?>">
			<div class="col1">
				<span><strong><?php echo $folder['folderName']; ?></strong></span>
				<?php echo @form_input($folder['folderID'].'[folderName]', $folder['folderName'], 'class="formelement hide" title="folder Name"'); ?><input type="submit" class="button hide" value="Edit" />
			</div>
			<div class="col2">
				&nbsp;
			</div>
			<div class="buttons">
				<a href="#" class="btn btn-info edit">Edit <i class="icon-edit"></i></a>
				<a href="<?php echo site_url('/admin/files/delete_folder/'.$folder['folderID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="btn btn-danger">Delete <i class="icon-trash"></i></a>
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

