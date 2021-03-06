<style type="text/css">
.ac_results { padding: 0px; border: 1px solid black; background-color: white; overflow: hidden; z-index: 99999; }
.ac_results ul { width: 100%; list-style-position: outside; list-style: none; padding: 0; margin: 0; }
.ac_results li { margin: 0px; padding: 2px 5px; cursor: default; display: block; font: menu; font-size: 12px; line-height: 16px; overflow: hidden; }
.ac_results li span.email { font-size: 10px; } 
.ac_loading { background: white url('<?php echo $this->config->item('staticPath'); ?>/images/loader.gif') right center no-repeat; }
.ac_odd { background-color: #eee; }
.ac_over { background-color: #0A246A; color: white; }
</style>

<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.fieldreplace.js"></script>
<script type="text/javascript">
$(function(){
    $('#searchbox').fieldreplace();
	function formatItem(row) {
		if (row[0].length) return row[1]+'<br /><span class="email">('+row[0]+')</span>';
		else return 'No results';
	}
	$('#searchbox').autocomplete("<?php echo site_url('/halogy/ac_sites'); ?>", { delay: "0", selectFirst: false, matchContains: true, formatItem: formatItem, minChars: 2 });
	$('#searchbox').result(function(event, data, formatted){
		$(this).parent('form').submit();
	});	
});
</script>

<div class="headingleft">
	<h1 class="headingleft">All Sites</h1>
</div>

<div class="headingright">
	<form method="post" action="<?php echo site_url('/halogy/sites'); ?>" class="default" id="search">
		<div class="input-append">
			<input type="text" name="searchbox" id="searchbox" class="span2" title="Search Sites..." />
			<button class="btn btn-primary" type="submit" id="searchbutton"><i class="icon-search"></i></button>
		</div>
<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
	</form>
	<a href="<?php echo site_url('/halogy/add_site'); ?>" class="btn btn-success">Add Site <i class="icon-plus-sign"></i></a>
</div>

<div class="clear"></div>

<?php if ($sites): ?>

<?php echo $this->pagination->create_links(); ?>

<table class="default">
	<tr>
		<th><?php echo order_link('halogy/sites/viewall','siteName','Site Name / URL'); ?></th>
		<th><?php echo order_link('halogy/sites/viewall','dateCreated','Date Created'); ?></th>
		<th><?php echo order_link('halogy/sites/viewall','siteDomain','Domain'); ?></th>
		<th><?php echo order_link('halogy/sites/viewall','altDomain','Staging Domain'); ?></th>		
		<th class="narrow"><?php echo order_link('halogy/sites/viewall','active','Status'); ?></th>		
		<th class="tiny">&nbsp;</th>
		<th class="tiny">&nbsp;</th>
	</tr>
<?php
	$i=0;
	foreach ($sites as $site):
	$class = ($i % 2) ? ' class="alt"' : ''; $i++;
?>
	<tr<?php echo $class; ?>>
<!--		<td><?php echo anchor('/halogy/edit_site/'.$site['siteID'], $site['siteName']); ?></td> -->
		<td><?php echo anchor('http://'.$site['siteDomain'], $site['siteName']); ?></td>
		<td><?php echo dateFmt($site['dateCreated']); ?></td>		
		<td><?php echo $site['siteDomain']; ?></td>
		<td><?php echo $site['altDomain']; ?></td>		
		<td>
			<?php
				if ($site['active']) echo '<span class="label label-success">Active</span>';
				if (!$site['active']) echo '<span class="label label-warning">Suspended</span>';
			?>
		</td>	
		<td class="tiny">
			<?php echo anchor('/halogy/edit_site/'.$site['siteID'], 'Edit <i class="icon-edit"></i>', 'class="btn btn-info"'); ?>
		</td>
		<td class="tiny">
			<?php echo anchor('/halogy/delete_site/'.$site['siteID'], 'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this site?\n\nThere is no undo!\')', 'class' => 'btn btn-danger')); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->pagination->create_links(); ?>

<br class="clear" />
<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

	<?php if (count($_POST)): ?>
	
		<p>No sites found.</p>
	
	<?php else: ?>
	
		<p>You haven't created any sites yet. Create one using the &ldquo;Add Site&rdquo; link above.</p>
	
	<?php endif; ?>

<?php endif; ?>

