<style type="text/css">
.ac_results { padding: 0px; border: 1px solid black; background-color: white; overflow: hidden; z-index: 99999; }
.ac_results ul { width: 100%; list-style-position: outside; list-style: none; padding: 0; margin: 0; }
.ac_results li { margin: 0px; padding: 2px 5px; cursor: default; display: block; font: menu; font-size: 12px; line-height: 16px; overflow: hidden; }
.ac_results li span.email { font-size: 10px; } 
.ac_loading { background: white url('<?php echo $this->config->item('staticPath'); ?>/images/loader.gif') right center no-repeat; }
.ac_odd { background-color: #eee; }
.ac_over { background-color: #0A246A; color: white; }
</style>

<script language="javascript" type="text/javascript">
function formatItem(row) {
	if (row[0].length) return row[1]+'<br /><span class="email">(#'+row[0]+')</span>';
	else return 'No results';
}
$(function(){
	$('#searchbox').autocomplete("<?php echo site_url('/admin/shop/ac_orders'); ?>", { delay: "0", selectFirst: false, matchContains: true, formatItem: formatItem, minChars: 2 });
	$('#searchbox').result(function(event, data, formatted){
		$(this).parent('form').submit();
	});
	$('select#filter').change(function(){
		var status = ($(this).val());
		window.location.href = '<?php echo site_url('/admin/shop/orders'); ?>/'+status;
	});	
});
</script>

<div class="headingleft">
<h1 class="headingleft">Orders <?php if ($trackingStatus) echo '('.$statusArray[$trackingStatus].')'?></h1>
</div>

<div class="headingright">
	<form method="post" action="<?php echo site_url('/admin/shop/orders'); ?>" class="default" id="search">
<?php /*
		<div class="input-append">
			<input type="text" name="searchbox" id="searchbox" class="span2" title="Search Orders..." />
			<button class="btn btn-primary" type="submit" id="searchbutton"><i class="icon-search"></i></button>
		</div>
<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
*/ ?>
	<label for="filter">Filter:</label> 
	<?php
		foreach ($statusArray as $key => $status):
			$options[$key] = $status;
		endforeach;
		
		echo form_dropdown('filter',$options,$trackingStatus,'id="filter"');
	?>
	</form>
	
	<a href="<?php echo site_url('/admin/shop/export_orders'); ?>" class="btn btn-info">Export Orders as CSV <i class="icon-download-alt"></i></a>

</div>

<div class="clear"></div>

<?php if ($orders): ?>

<?php echo $this->pagination->create_links(); ?>

<table class="default">
	<tr>
		<th>Order ID</th>
		<th>Date Ordered</th>
		<th>Full Name</th>
		<th>Number of Items</th>
		<th class="narrow">Total (<?php echo currency_symbol(); ?>)</th>
		<th>Status</th>
		<th class="tiny">&nbsp;</th>
		<th class="tiny">&nbsp;</th>
	</tr>
<?php foreach ($orders as $order): 
	if (!$order['viewed']) $class = 'style="font-weight: bold;"'; else $class='';
?>
	<tr <?php echo $class ?>>
		<td><?php echo anchor('/admin/shop/view_order/'.$order['transactionID'], $order['transactionCode']); ?></td>
		<td><?php echo dateFmt($order['dateCreated'], '', '', TRUE); ?></td>
		<td><?php echo $order['firstName']; ?> <?php echo $order['lastName']; ?></td>
		<td><?php echo $order['numItems']; ?></td>
		<td><?php echo currency_symbol().number_format($order['amount'],2); ?></td>
		<td>
			<?php
				if ($order['trackingStatus'] == 'U' && $order['paid']) echo 'Unprocessed';
				elseif ($order['trackingStatus'] == 'L') echo 'Allocated';
				elseif ($order['trackingStatus'] == 'A') echo 'Awaiting Goods';
				elseif ($order['trackingStatus'] == 'O') echo 'Out of Stock';
				elseif ($order['trackingStatus'] == 'D') echo 'Dispatched';
				else echo 'Unpaid Checkout';
			?>
		</td>
		<td><?php echo anchor('/admin/shop/view_order/'.$order['transactionID'], 'View <i class="icon-eye-open"></i>', 'class="btn btn-warning"'); ?></td>
		<td><?php echo anchor('/admin/shop/delete_order/'.$order['transactionID'], 'Delete <i class="icon-trash"></i>', array('onclick="return confirm(\'Are you absolutely sure you want to delete this order? There is no undo.\')"', 'class' => 'btn btn-danger')); ?></td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->pagination->create_links(); ?>

<br class="clear" />
<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

<p class="clear">There were no orders found.</p>

<?php endif; ?>

