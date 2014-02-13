<div class="headingleft">
<h1 class="headingleft">Include Files</h1>
</div>

<div class="headingright">
	<a href="<?php echo site_url('/admin/pages/templates'); ?>" class="btn btn-info">Templates</a>
	<a href="<?php echo site_url('/admin/pages/includes/css'); ?>" class="btn btn-info">CSS</a>
	<a href="<?php echo site_url('/admin/pages/includes/less'); ?>" class="btn btn-info">LESS</a>
	<a href="<?php echo site_url('/admin/pages/includes/js'); ?>" class="btn btn-info">Javascript</a>	
	<a href="<?php echo site_url('/admin/pages/add_include'); ?>" class="btn btn-success">Add Include <i class="icon-plus-sign"></i></a>
</div>

<div class="hidden">
	<p class="hide"><a href="#">x</a></p>
	<div class="inner"></div>
</div>

<div class="clear"></div>

<?php if ($includes): ?>

<?php echo $this->pagination->create_links(); ?>

<table class="default">
	<tr>
		<th>Filename (Reference)</th>
		<th>Date Modified</th>
		<th class="tiny">&nbsp;</th>
		<th class="tiny">&nbsp;</th>
	</tr>
<?php
	$i = 0;
	foreach ($includes as $include):
	$class = ($i % 2) ? ' class="alt"' : ''; $i++;
?>
	<tr<?php echo $class;?>>
		<td><?php echo anchor('/admin/pages/edit_include/'.$include['includeID'], $include['includeRef']); ?></td>	
		<td><?php echo dateFmt($include['dateCreated']); ?></td>
		<td>
			<?php echo anchor('/admin/pages/edit_include/'.$include['includeID'], 'Edit <i class="icon-edit"></i>', 'class="btn btn-info"'); ?>
		</td>
		<td>			
			<?php echo anchor('/admin/pages/delete_include/'.$include['includeID'], 'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this?\')', 'class' => 'btn btn-danger')); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->pagination->create_links(); ?>

<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

<p class="clear">You haven't made any Include files yet.</p>

<?php endif; ?>

