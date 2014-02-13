<?php if ($cart): ?>
<table style="border: 1px solid black; padding: 4px;">
	<tr style="border: 1px solid black;">
		<td style="background-color:gray; color:white; padding: 4px; text-align:left;">Item</td>
		<td style="background-color:gray; color:white; padding: 4px; text-align:left;">Variations</td>
		<td style="background-color:gray; color:white; padding: 4px; text-align:left;">Quantity</td>
	</tr>
<?php
	foreach ($cart as $key => $item):

		$variationHTML = '';

		// get variation 1
		if ($item['variation1']) $variationHTML .= ' ('.$this->site->config['shopVariation1'].': '.$item['variation1'].')';

		// get variations 2
		if ($item['variation2']) $variationHTML .= ' ('.$this->site->config['shopVariation2'].': '.$item['variation2'].')';

		// get variations 3
		if ($item['variation3']) $variationHTML .= ' ('.$this->site->config['shopVariation3'].': '.$item['variation3'].')';
?>
	<tr>
		<td><?php echo $item['productName']; ?></td>
		<td><?php echo $variationHTML; ?></td>
		<td><?php echo $item['quantity']; ?></td>
	</tr>
<?php endforeach; ?>

<tr style="background-color:green; color:white;">
	<td colspan="2" style="padding: 4px;">Discount Code:</td>
	<td style="padding: 4px;"><?php echo $discountCode; ?></td>
</tr>
<tr>
	<td style="border: 1px solid black; padding: 4px;">Name</td>
	<td style="border: 1px solid black; padding: 4px;">Email</td>
	<td style="border: 1px solid black; padding: 4px;">Phone</td>
</tr>
<tr>
	<td style="border: 1px solid black; padding: 4px;"><?php echo $name; ?></td>
	<td style="border: 1px solid black; padding: 4px;"><?php echo $email; ?></td>
	<td style="border: 1px solid black; padding: 4px;"><?php echo $phone; ?></td>
</tr>

</table>
<?php endif; ?>
