<?php 
if ($cart):

	foreach ($cart as $key => $item): 

		$variationHTML = '';
		
		// get variation 1
		if ($item['variation1']) $variationHTML .= ' ('.$this->site->config['shopVariation1'].': '.$item['variation1'].')';
		
		// get variations 2
		if ($item['variation2']) $variationHTML .= ' ('.$this->site->config['shopVariation2'].': '.$item['variation2'].')';
	
		// get variations 3
		if ($item['variation3']) $variationHTML .= ' ('.$this->site->config['shopVariation3'].': '.$item['variation3'].')';
	
		$key = $this->core->encode($key);
?>

<tr>
	<td><a href="/shop/<?php echo $item['productID']; ?>/<?php echo strtolower(url_title($item['productName'])); ?>"><?php echo $item['productName']; ?><?php echo $variationHTML; ?></a></td>
	<?php if ($this->uri->segment(2) == 'checkout'): ?>
	<td>
		<div class="control-group">
			<div class="controls">
				<div class="input-append">
					<input style="margin:0px;" name="quantity[<?php echo $key; ?>]"  value="<?php echo $item['quantity']; ?>" size="3" type="text"><button class="btn btn-danger" type="button" onclick="if(confirm('Are you sure you want to remove this item?')){window.location='/shop/cart/remove/<?php echo $key; ?>';}"><i class="icon-remove icon-white"></i></button>
				</div>
			</div>
		</div>
	</td>
	<?php else: ?>
	<td>
		<div class="control-group">
			<div class="controls">
				<div class="input-append">
					<input style="margin:0px;" name="quantity[<?php echo $key; ?>]"  value="<?php echo $item['quantity']; ?>" size="3" maxlength="2" type="text"><button class="btn btn-danger" type="button" onclick="if(confirm('Are you sure you want to remove this item?')){window.location='/shop/cart/remove/<?php echo $key; ?>';}"><i class="icon-remove icon-white"></i></button>
				</div>
			</div>
		</div>
	</td>
	<?php endif; ?>
	<td>
	<?php
	if ($item['price'] == 0)
	{
		echo "--";
	}
	else
	{
		echo currency_symbol();
		echo number_format(($item['price'] * $item['quantity']), 2);
	}
	?>
	</td>
</tr>

<?php endforeach; ?>
<?php
	// find out if there is a donation (adding it after the postage)
	if ($this->session->userdata('cart_donation') > 0):
?>
<tr>
	<td>Donation</td>
	<td>1 <a href="/shop/cart/remove_donation/">[remove]</a></td>
	<td><?php echo currency_symbol(); ?><?php echo number_format($this->session->userdata('cart_donation'), 2); ?></td>
</tr>
<?php endif; ?>
<?php endif; ?>