<script type="text/javascript">
$(function(){
	var originalTrackingStatus = $('#trackingStatus').val();
	$('input.confirm').click(function(){
		if ($('#trackingStatus').val() == 'D'){
			return confirm('You are updating this order as Shipped so a shipping confirmation email will be sent to the customer.\n\nProceed?');
		} else if (originalTrackingStatus == 'N' && $('#trackingStatus').val() != 'N'){
			return confirm('You are forcing an unpaid checkout to paid so an order confirmation email will be sent to the customer.\n\nProceed?');
		}
		else return true;
	});
});
</script>

<style type="text/css" media="print">
body, div.content p, div.content table td { font-size: 18px; }
div#header, div#navigation, div#footer, .printhide{ display: none; }
#tpl-3col .col1 { width: 100%; clear: both; margin-bottom: 50px; }
#tpl-3col .col2, #tpl-3col .col3 { width: 410px; padding: 30px; border: 1px dashed #ccc; margin-bottom: 50px; min-height: 300px; }
div.content h2.underline, div.content h3.underline { border: none; }
</style>

<form action="<?php echo site_url($this->uri->uri_string()); ?>" method="post" class="default">

	<div class="headingleft">
	<h1 class="headingleft">View Order</h1>
	<a href="<?php echo site_url('/admin/shop/orders'); ?>" class="btn">Back to Orders <i class="icon-arrow-up"></i></a>
	</div>

	<div class="headingright">
		<button type="submit" class="btn btn-success printhide confirm">Update Order <i class="icon-refresh"></i></button>
	</div>
	
	<div class="clear"></div>
	
	<?php if (isset($message)): ?>
		<div class="alert">
			<?php echo $message; ?>
		</div>
	<?php endif; ?>

	<div class="alert alert-info">
		<p>
			<strong>Order ID #:</strong> <?php echo $order['transactionCode']; ?><br /> 
			<strong>Date:</strong> <?php echo dateFmt($order['dateCreated'], '', '', TRUE); ?><br />
			<?php if ($order['discountCode']): ?>
				<strong>Discount Code:</strong> <?php echo $order['discountCode']; ?>
			<?php endif; ?>
		</p>
	</div>
	
	<div class="row">
		<div class="col-lg-6">

			<h2 class="underline">Products Ordered</h2>
		
			<?php if ($item_orders): ?>
			<table class="default">
				<tr>
					<th>Product</th>
					<th>Quantity</th>
					<th width="80">Price (<?php echo currency_symbol(); ?>)</th>
				</tr>
				<?php foreach ($item_orders as $item): 
					$variationHTML = '';
					$downloadHTML = '';
					
					// get variation 1
					if ($item['variation1']) $variationHTML .= ' ('.$this->site->config['shopVariation1'].': <strong>'.$item['variation1'].'</strong>)';
					
					// get variations 2
					if ($item['variation2']) $variationHTML .= ' ('.$this->site->config['shopVariation2'].': <strong>'.$item['variation2'].'</strong>)';
				
					// get variations 3
					if ($item['variation3']) $variationHTML .= ' ('.$this->site->config['shopVariation3'].': <strong>'.$item['variation3'].'</strong>)';
		
					// check if its a file
					if ($item['fileID'])
					{
						$file = $this->shop->get_file($item['fileID']);
						$downloadHTML .= ' ['.anchor('/files/'.$this->core->encode($file['fileRef'].'|'.$transactionID), 'Download').']';
						$downloadHTML .= ' ['.anchor('/admin/shop/renew_downloads/'.$transactionID, 'Renew Expiry').']';				
					}			
					
				?>
				<tr>
					<td>
						<a href="/shop/viewproduct/<?php echo $item['productID']; ?>"><?php echo $item['productName']; ?></a>
						<small><?php echo $variationHTML; ?><?php echo $downloadHTML; ?></small>
					</td>
					<td><?php echo $item['quantity']; ?></td>
					<td><?php echo currency_symbol(); ?><?php echo number_format(($item['price'] * $item['quantity']), 2); ?></td>
				</tr>
				
			<?php endforeach; ?>
			
				<?php
					// find out if there is a donation (adding it after the postage)
					if ($order['donation'] > 0):
				?>
					<tr>
						<td>Donation</td>
						<td>1</td>
						<td><?php echo currency_symbol(); ?><?php echo number_format($order['donation'], 2); ?></td>
					</tr>
				<?php endif; ?>	
				<?php if ($order['discounts'] > 0): ?>
					<tr class="shade">
						<td colspan="2">Discounts applied:</td>
						<td>(<?php echo currency_symbol(); ?><?php echo number_format($order['discounts'], 2); ?>)</td>
					</tr>
				<?php endif; ?>
				<tr class="shade">
					<td colspan="2">Subtotal:</td>
					<td><?php echo currency_symbol(); ?><?php echo number_format(($order['amount'] - $order['postage'] - $order['tax']), 2); ?></td>
				</tr>
				<tr class="shade">
					<td colspan="2">Shipping &amp; Handling:</td>
					<td><?php echo currency_symbol(); ?><?php echo number_format($order['postage'], 2); ?></td>
				</tr>
				<?php if ($order['tax'] > 0): ?>
					<tr class="shade">
						<td colspan="2">Sales Tax:</td>
						<td><?php echo currency_symbol(); ?><?php echo number_format($order['tax'], 2); ?></td>
					</tr>
				<?php endif; ?>
				<tr class="shade">
					<td colspan="2"><strong>Total:</strong></td>
					<td><strong><?php echo currency_symbol(); ?><?php echo number_format($order['amount'], 2); ?></strong></td>
				</tr>
				
			</table>
			<?php endif; ?>
	
		</div>
	
		<div class="col-lg-3">
		
			<h3 class="underline">Shipping Address</h3>
		
			<p>
				<?php if ($order['firstName'] && $order['lastName']): ?>
					<?php echo $order['firstName'] ?> <?php echo $order['lastName']; ?><br />
				<?php else: ?>
					<em>No name set</em>
				<?php endif; ?>
				<?php echo ($order['address1']) ? $order['address1'].'<br />' : ''; ?>
				<?php echo ($order['address2']) ? $order['address2'].'<br />' : ''; ?>
				<?php echo ($order['address3']) ? $order['address3'].'<br />' : ''; ?>
				<?php echo ($order['city']) ? $order['city'] : ''; ?>
				<?php echo ($order['state']) ? ', '.$order['state'].' ' : ' '; ?>
				<?php echo ($order['postcode']) ? $order['postcode'].'<br />' : '<br />'; ?>
				<?php echo ($order['country']) ? lookup_country($order['country']).'<br />' : ''; ?>
				<?php echo ($order['phone']) ? $order['phone'].'<br />' : ''; ?>
				<?php echo ($order['email']) ? mailto($order['email']) : ''; ?>
			</p>
			<a href="#" class="btn btn-info" onclick="window.print();">Print Shipping Label <i class="icon-print"></i></a>

		</div>

		<div class="col-lg-3">
		
			<h3 class="underline">Billing Address</h3>
		
			<p>
				<?php if ($order['billingAddress1'] || $order['billingAddress2'] || $order['billingCity'] || $order['billingPostcode']): ?>
					<?php echo ($order['firstName']) ? $order['firstName'] : '(no firstname)'; ?> <?php echo ($order['lastName']) ? $order['lastName'] : '(no surname)'; ?><br />
					<?php echo ($order['billingAddress1']) ? $order['billingAddress1'].'<br />' : ''; ?>
					<?php echo ($order['billingAddress2']) ? $order['billingAddress2'].'<br />' : ''; ?>
					<?php echo ($order['billingAddress3']) ? $order['billingAddress3'].'<br />' : ''; ?>
					<?php echo ($order['billingCity']) ? $order['billingCity'] : ''; ?>
					<?php echo ($order['billingState']) ? ', '.$order['billingState'].' ' : ' '; ?>
					<?php echo ($order['billingPostcode']) ? $order['billingPostcode'].'<br />' : '<br />'; ?>
					<?php echo ($order['billingCountry']) ? lookup_country($order['billingCountry']).'<br />' : ''; ?>
				<?php else: ?>
					<small><em>Same as Shipping Address</em></small>
				<?php endif; ?>
			</p>
			
		</div>
	</div>
	<div class="clear"></div>
	
	<br />
	
	<div class="printhide">			
		<h2 class="underline">Process Order</h2>
	
		<label for="trackingStatus">Tracking status:</label>
		<?php
			foreach ($statusArray as $key => $status):
				$options[$key] = $status;
			endforeach;
			
			if (!$data['paid'])
			{
				$data['trackingStatus'] = 'N';
			}
			
			echo form_dropdown('trackingStatus',$options,set_value('trackingStatus', $data['trackingStatus']),'id="trackingStatus"');
		?>
		<br class="clear" />
	
		<label for="notes">Order notes:</label>
		<?php echo form_textarea('notes',set_value('notes', $data['notes']), 'id="notes" class="form-control"'); ?>
	</div>
	<br class="clear" /><br />	

<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>
<br class="clear" />

<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
