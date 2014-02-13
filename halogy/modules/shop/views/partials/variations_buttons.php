<?php
// Alternate variations partial for creating a list of radio buttons instead of a select dropdown
// created 8-7-2013
// TBD: Might be nice to have a flag that enables/disables the appearance of the "+" for cases where the variations establish the price
// TBD: if ($variation['price'] > 0) - option to enable / disable
// TBD: Bootstrap "radio button group"
?>
<?php if ($variation1): ?>
	<label class="variationlabel" for="variation1"><?php echo $this->site->config['shopVariation1']; ?>:</label>
	<div class="btn-group btn-group-vertical" data-toggle="buttons-radio">
	<?php $i = 0; foreach ($variation1 as $variation): ?>
		<button type="button" class="btn variation1" name="variation1" class="variation" id="variation1<?php echo $i; ?>"><?php echo $variation["variation"].'<span> +'.currency_symbol().$variation["price"].'</span>'; ?></button>
	<?php $i++; endforeach; ?>
	</div>
	<br class="clear" />
<?php endif; ?>

<?php if ($variation2): ?>
	<label class="variationlabel" for="variation2"><?php echo $this->site->config['shopVariation2']; ?>:</label>
	<div class="btn-group btn-group-vertical" data-toggle="buttons-radio">
	<?php $i = 0; foreach ($variation2 as $variation): ?>
		<button type="button" class="btn variation2" name="variation2" class="variation" id="variation2<?php echo $i; ?>"><?php echo $variation["variation"].'<span> +'.currency_symbol().$variation["price"].'</span>'; ?></button>
	<?php $i++; endforeach; ?>
	</div>
	<br class="clear" />
<?php endif; ?>

<?php if ($variation3): ?>
	<label class="variationlabel" for="variation3"><?php echo $this->site->config['shopVariation3']; ?>:</label>
	<div class="btn-group btn-group-vertical" data-toggle="buttons-radio">
	<?php $i = 0; foreach ($variation3 as $variation): ?>
		<button type="button" class="btn variation3" name="variation3" class="variation" id="variation3<?php echo $i; ?>"><?php echo $variation["variation"].'<span> +'.currency_symbol().$variation["price"].'</span>'; ?></button>
	<?php $i++; endforeach; ?>
	</div>
	<br class="clear" />
<?php endif; ?>
