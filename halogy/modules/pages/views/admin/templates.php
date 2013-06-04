<script type="text/javascript">
$(function(){
	$('div.hidden').hide();
	$('a.showform').click(function(event){ 
		event.preventDefault();
		$('div.hidden div.inner').load('/templates/add/');		
		$('div.hidden').fadeIn();
	});
	$('p.hide a').click(function(event){ 
		event.preventDefault();		
		$(this).parent().parent().fadeOut();
	});
	$('.toggle-zip').click(function(event){ 
		event.preventDefault();		
		$('div#upload-zip').toggle('400');
		$('div#upload-image:visible, div#loader:visible').toggle('400');
	});
	$('select#filter').change(function(){
		var status = ($(this).val());
		window.location.href = '<?php echo site_url('/admin/pages/templates'); ?>/'+status;
	});
});
</script>

<div class="headingleft">
<h1 class="headingleft">Page Templates</h1>
</div>

<div class="headingright">
	<label for="filter">Filter:</label> 
	<?php
		$options = array(
			'' => 'View All',
			'page' => 'Page Templates',
			'module' => 'Module Templates'
		);
		
		echo form_dropdown('filter', $options, $type, 'id="filter"');
	?>
	<a href="<?php echo site_url('/admin/pages/includes'); ?>" class="btn btn-info">Includes</a>
	<a href="#" class="btn btn-info toggle-zip">Import Theme</a>
	<a href="<?php echo site_url('/admin/pages/add_template'); ?>" class="btn btn-success">Add Template <i class="icon-plus-sign"></i></a>
</div>

<div class="hidden">
	<p class="hide"><a href="#">x</a></p>
	<div class="inner"></div>
</div>

<div class="clear"></div>

<?php if ($errors = validation_errors()): ?>
	<div class="error clear">
		<?php echo $errors; ?>
	</div>
<?php endif; ?>

<div id="upload-zip" class="hidden clear">
	<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="default">
	
		<label for="image">ZIP File:</label>
		<div class="uploadfile">
			<?php echo @form_upload('zip', '', 'size="16" id="image"'); ?>
		</div>
		<br class="clear" /><br />	

		<input type="submit" value="Import Theme" name="upload_zip" class="button nolabel" id="submit" />
		<a href="<?php echo site_url('/admin/images'); ?>" class="button cancel grey">Cancel</a>
			
	</form>
</div>

<?php if ($templates): ?>

<?php echo $this->pagination->create_links(); ?>

<table class="default clear">
	<tr>
		<th>Template</th>
		<th>Date Modified</th>		
		<th>Usage</th>	
		<th class="tiny">&nbsp;</th>
		<th class="tiny">&nbsp;</th>		
	</tr>
<?php
	$i = 0;
	foreach ($templates as $template): 
	$class = ($i % 2) ? ' class="alt"' : ''; $i++;
?>
	<tr<?php echo $class;?>>
		<td><?php echo anchor(site_url('/admin/pages/edit_template/'.$template['templateID']), ($template['modulePath'] != '') ? '<small>Module</small>: '.$template['modulePath'].' <em>('.ucfirst(preg_replace('/^(.+)_/i', '', $template['modulePath'])).')</em>' : $template['templateName']); ?></td>
		<td><?php echo dateFmt($template['dateCreated']); ?></td>		
		<td><?php if ($this->pages->get_template_count($template['templateID']) > 0): ?>
				<?php echo $this->pages->get_template_count($template['templateID']); ?> <small>page(s)</small>
			<?php endif; ?></td>
		<td>
			<?php echo anchor(site_url('/admin/pages/edit_template/'.$template['templateID']), 'Edit <i class="icon-edit"></i>', 'class="btn btn-info"'); ?>
		</td>
		<td>
			<?php echo anchor(site_url('/admin/pages/delete_template/'.$template['templateID']), 'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this?\')', 'class' => 'btn btn-danger')); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->pagination->create_links(); ?>

<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

<p>There are no templates here yet.</p>


<?php endif; ?>

