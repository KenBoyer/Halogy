<?php if ($bands): ?>
	<?php foreach($bands as $band): ?>
		<option value="<?php echo $band['multiplier']; ?>" <?php echo ($band['multiplier'] == $shippingBand) ? 'selected="selected"' : ''; ?>><?php echo $band['bandName']; ?></option>
	<?php endforeach; ?>
<?php endif; ?>