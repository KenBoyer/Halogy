<?php
// Alternate variations partial for creating a list of radio buttons instead of a select dropdown
// created 8-7-2013
// TBD: Might be nice to have a flag that enables/disables the appearance of the "+" for cases where the variations establish the price
// TBD: if ($variation['price'] > 0) - option to enable / disable
?>
<?php if ($variation1): ?>
	<label class="variationlabel" for="variation1"><?php echo $this->site->config['shopVariation1']; ?>:</label>
	<br class="clear" />
	<?php foreach ($variation1 as $variation): ?>
		<div class="input-group variation1">
		<span class="input-group-addon">
		<input type="radio" name="variation1" class="variation" id="variation1" <?php if ($variation1 == $variation["variation1"]) echo 'checked="checked" '; ?> value="<?php echo $variation['variation1']; ?>" />
		</span>
		<input type="text" class="form-control" value='<?php echo $variation["variation"].' +'.currency_symbol().$variation["price"]; ?>' readonly />
		</div>
	<?php endforeach; ?>
	<br class="clear" />
<?php endif; ?>

<?php if ($variation2): ?>
	<label class="variationlabel" for="variation2"><?php echo $this->site->config['shopVariation2']; ?>:</label>
	<br class="clear" />
	<?php foreach ($variation2 as $variation): ?>
		<div class="input-group variation2">
		<span class="input-group-addon">
		<input type="radio" name="variation2" class="variation" id="variation2" <?php if ($variation2 == $variation["variation"]) echo 'checked="checked" '; ?> value="<?php echo $variation['variationID']; ?>" />
		</span>
		<input type="text" class="form-control" value='<?php echo $variation["variation"].' +'.currency_symbol().$variation["price"]; ?>' readonly />
		</div>
	<?php endforeach; ?>
	<br class="clear" />
<?php endif; ?>

<?php if ($variation3): ?>
	<label class="variationlabel" for="variation3"><?php echo $this->site->config['shopVariation3']; ?>:</label>
	<br class="clear" />
	<?php foreach ($variation3 as $variation): ?>
		<div class="input-group variation3">
		<span class="input-group-addon">
		<input type="radio" name="variation3" class="variation" id="variation3" <?php if ($variation3 == $variation["variation"]) echo 'checked="checked" '; ?> value="<?php echo $variation['variationID']; ?>" />
		</span>
		<input type="text" class="form-control" value='<?php echo $variation["variation"].' +'.currency_symbol().$variation["price"]; ?>' readonly />
		</div>
	<?php endforeach; ?>
	<br class="clear" />
<?php endif; ?>
