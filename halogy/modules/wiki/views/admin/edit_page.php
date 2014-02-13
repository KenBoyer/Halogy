<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">

	<div class="headingleft">
		<h1 class="headingleft">Edit Wiki Page</h1>
		<a href="<?php echo site_url('/admin/wiki/viewall'); ?>" class="btn">Back to Wiki Pages <i class="icon-arrow-up"></i></a>
	</div>

	<div class="headingright">
		<input type="submit" value="Save Changes" class="btn btn-success" />
	</div>

	<?php if ($errors = validation_errors()): ?>
		<div class="alert alert-error">
			<?php echo $errors; ?>
		</div>
	<?php endif; ?>

	<label for="pageName">Title:</label>
	<?php echo @form_input('pageName',set_value('pageName', $data['pageName']), 'id="pageName" class="formelement"'); ?>
	<br class="clear" />

	<label for="uri">URI:</label>
	<?php echo @form_input('uri',set_value('uri', $data['uri']), 'id="uri" class="formelement"'); ?>
	<br class="clear" />

	<label for="category">Category:</label>
	<?php
		$options[''] = 'No Category';
	if ($categories):
		foreach ($categories as $category):
			$options[$category['catID']] = $category['catName'];
		endforeach;
		
		echo @form_dropdown('catID',$options,set_value('catID', $data['catID']),'id="category" class="formelement"');
	endif;
	?>
	<a href="<?php echo site_url('/admin/wiki/categories'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')" class="btn">Edit Categories <i class="icon-edit"></i></a>

	<br class="clear" />

	<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
	<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
	?>

</form>
