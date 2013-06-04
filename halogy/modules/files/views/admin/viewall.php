<style type="text/css">
.ac_results { padding: 0px; border: 1px solid black; background-color: white; overflow: hidden; z-index: 99999; }
.ac_results ul { width: 100%; list-style-position: outside; list-style: none; padding: 0; margin: 0; }
.ac_results li { margin: 0px; padding: 2px 5px; cursor: default; display: block; font: menu; font-size: 12px; line-height: 16px; overflow: hidden; }
.ac_results li span.email { font-size: 10px; } 
.ac_loading { background: white url('<?php echo $this->config->item('staticPath'); ?>/images/loader.gif') right center no-repeat; }
.ac_odd { background-color: #eee; }
.ac_over { background-color: #0A246A; color: white; }
</style>

<script type="text/javascript">
$(function(){
	$('.toggle').click(function(event){ 
		event.preventDefault();		
		$('div#upload-file').slideToggle('400');
		$('div#upload-zip:visible, div#loader:visible').slideToggle('400');
	});

	$('.toggle-zip').click(function(event){ 
		event.preventDefault();		
		$('div#upload-zip').toggle('400');
		$('div#upload-file:visible, div#loader:visible').slideToggle('400');
	});

	$('.edit').click(function(event){
		event.preventDefault();
		$.scrollTo(0, '200');
		$('div#loader').load(this.href, function(){
			$('div#loader:hidden').toggle('400');
			$('div#upload-zip:visible, div#upload-file:visible').slideToggle('400');
		});
	});

	$('select#folderID').change(function(){
		var folderID = ($(this).val());
		window.location.href = '<?php echo site_url('/admin/files/viewall'); ?>/'+folderID;
	});
});
</script>

<div class="headingleft">
<h1 class="headingleft">Files</h1>
</div>

<div class="headingright">

	<form method="post" action="<?php echo site_url('/admin/files/viewall'); ?>" class="search" id="search" style="display: none;">
		<div class="input-append">
			<input type="text" name="searchbox" id="searchbox" class="span2 inactive" title="Search Files..." />
			<button class="btn btn-primary" type="submit" id="searchbutton"><i class="icon-search"></i></button>
		</div>
	</form>

	<label for="folderID">Folder:</label> 
	<?php
		$options = '';
		$options['me'] = 'My Files';
		if (@in_array('files_all', $this->permission->permissions)):
			$options['all'] = 'View All Files';

			if ($folders):
				foreach ($folders as $folder):
					$options[$folder['folderID']] = $folder['folderName'];
				endforeach;
			endif;
		endif;
		echo form_dropdown('folderID', $options, $folderID, 'id="folderID"');
	?>

	<?php if ($this->site->config['plan'] = 0 || $this->site->config['plan'] = 6 || (($this->site->config['plan'] > 0 && $this->site->config['plan'] < 6) && $quota < $this->site->plans['storage'])): ?>

		<a href="#" class="btn btn-info toggle">Upload File <i class="icon-upload"></i></a>

	<?php endif; ?>
	
</div>

<?php if ($errors = validation_errors()): ?>
	<div class="alert alert-error clear">
		<?php echo $errors; ?>
	</div>
<?php endif; ?>

<div id="upload-file"class="hidden clear">
	<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="default">
	
		<label for="file">File:</label>
		<div class="uploadfile">
			<?php echo @form_upload('file',$this->validation->file, 'size="16" id="file"'); ?>
		</div>
		<br class="clear" />

		<label for="fileFolderID">Folder: <small>[<a href="<?php echo site_url('/admin/files/folders'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')">update</a>]</small></label>
		<?php
			$options = '';		
			$options[0] = 'No Folder';
			if ($folders):
				foreach ($folders as $folderID):
					$options[$folderID['folderID']] = $folderID['folderName'];
				endforeach;
			endif;
				
			echo @form_dropdown('folderID',$options,set_value('folderID', $data['folderID']),'id="fileFolderID" class="formelement"');
		?>	
		<br class="clear" /><br />
			
		<input type="submit" value="Upload File" class="button nolabel" id="submit" />
		<a href="<?php echo site_url('/admin/files'); ?>" class="button cancel grey">Cancel</a>
		
	</form>
</div>

<div id="loader" class="hidden clear"></div>

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

<?php if ($files): ?>

	<?php echo $this->pagination->create_links(); ?>

	<table class="images files clear" style="border-collapse: separate;">	
		<tr>
		<?php
			$numItems = sizeof($files);
			$itemsPerRow = 6;
			$i = 0;
						
			foreach ($files as $file)
			{
				if (($i % $itemsPerRow) == 0 && $i > 1)
				{
					echo '</tr><tr>'."\n";
					$i = 0;
				}
				echo '<td align="center" valign="bottom" width="'.floor(( 1 / $itemsPerRow) * 100).'%">';

				$extension = substr($file['filename'], strpos($file['filename'], '.')+1);
				$filePath = '/files/'.$file['fileRef'].'.'.$extension;				

		?>
				<a href="<?php echo $filePath; ?>" title="<?php echo $file['fileRef']; ?>"><img src="<?php echo $this->config->item('staticPath'); ?>/fileicons/<?php echo $extension; ?>.png" alt="<?php echo $file['fileRef']; ?>" class="file" /></a>

				<p><strong><?php echo $file['fileRef']; ?></strong></p>

				<div class="buttons">
					<?php echo anchor('/admin/files/edit/'.$file['fileID'].'/', 'Edit <i class="icon-edit"></i>', 'class="btn btn-info edit"'); ?>
					<?php echo anchor('/admin/files/delete/'.$file['fileID'], 'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this file?\')', 'class' => 'btn btn-danger')); ?>
				</div>

		<?php
				echo '</td>'."\n";
				$i++;
			}
		
			for($x = 0; $x < ($itemsPerRow - $i); $x++)
			{
				echo '<td width="'.floor((1 / $itemsPerRow) * 100).'%">&nbsp;</td>';
			}
		?>
		</tr>
	</table>
	
	<?php echo $this->pagination->create_links(); ?>

	<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

<p class="clear">You have not yet uploaded any files.</p>

<?php endif; ?>

