<?php
// Alternate variations partial for creating a list of radio buttons instead of a select dropdown
// created 8-7-2013
// TBD: Might be nice to have a flag that enables/disables the appearance of the "+" for cases where the variations establish the price
// TBD: if ($variation['price'] > 0) - option to enable / disable
// TBD: Bootstrap "radio button group"?
        // <div class="btn-group" data-toggle="buttons-radio">
          // <button class="btn" id="Couch">Couch</button>
          // <button class="btn" id="DiningRoom">Dining Room</button>
          // <button class="btn" id="Bed">Bed</button>
        // </div>
?>
<?php if ($variation1): ?>
	<label class="variationlabel" for="variation1"><?php echo $this->site->config['shopVariation1']; ?>:</label>
	<div class="input-group">
	<?php foreach ($variation1 as $variation): ?>
		<span class="input-group-addon">
		<input type="radio" name="variation1" class="variation" id="variation1" value="<?php echo $variation['variationID']; ?>"><?php echo $variation['variation']; ?>
		<?php echo '+'.currency_symbol().$variation['price']; ?>
		<br class="clear" />
	<?php endforeach; ?>
	</div>
	<br class="clear" />
<?php endif; ?>

<?php if ($variation2): ?>
	<label class="variationlabel" for="variation2"><?php echo $this->site->config['shopVariation2']; ?>:</label>
	<div class="input-group">
	<?php foreach ($variation2 as $variation): ?>
		<span class="input-group-addon">
		<input name="variation2" class="variation" id="variation2" value="<?php echo $variation['variationID']; ?>"><?php echo $variation['variation']; ?>
		<?php if ($variation['price'] > 0) echo '+'.currency_symbol().$variation['price']; ?>
		</span>
		<br class="clear" />
	<?php endforeach; ?>
	<br class="clear" />
<?php endif; ?>

<?php if ($variation3): ?>
	<label class="variationlabel" for="variation3"><?php echo $this->site->config['shopVariation3']; ?>:</label>
	<div class="input-group">
	<?php foreach ($variation3 as $variation): ?>
		<span class="input-group-addon">
		<input type="radio" name="variation2" value="<?php echo $variation['variationID']; ?>"><?php echo $variation['variation']; ?>
		<?php if ($variation['price'] > 0) echo '+'.currency_symbol().$variation['price']; ?>
		</span>
		<br class="clear" />
	<?php endforeach; ?>
	</div>
	<br class="clear" />
<?php endif; ?>
