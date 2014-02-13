<?php if (!$this->core->is_ajax()): ?>
	<h1><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Shipping postage</h1>
<?php endif; ?>

<?php if ($errors = validation_errors()): ?>
	<div class="error">
		<?php echo $errors; ?>
	</div>
<?php endif; ?>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">

	<label for="total">Total:</label>
	<span class="price"><?php echo currency_symbol(); ?></span><?php echo @form_input('total', $data['total'], 'class="form-control small" id="total"'); ?>
	<span class="tip">When the shopping cart total reaches the given amount, then this rate will be applied.</span>
	<br class="clear" />
		
	<label for="cost">Cost:</label>
	<span class="price"><?php echo currency_symbol(); ?></span><?php echo @form_input('cost', $data['cost'], 'class="form-control small" id="cost"'); ?>
	<span class="tip">What do you want to charge for this rate?</span>
	<br class="clear" /><br />
		
	<input type="submit" value="Save Changes" class="btn btn-success" />
	<input type="button" value="Cancel" id="cancel" class="btn" />

<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>

<br class="clear" />
