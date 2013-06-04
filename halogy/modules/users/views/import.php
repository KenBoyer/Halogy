<div class="headingleft">
	<h1 class="headingleft">Import Users</h1>
	<a href="<?php echo site_url('/admin/users'); ?>" class="btn">Back to Users <i class="icon-arrow-up"></i></a>
</div>

<br class="clear" />

<?php if ($errors = validation_errors()): ?>
	<div class="alert alert-error">
		<?php echo $errors; ?>
	</div>
<?php endif; ?>

<?php if (isset($message)): ?>
	<div class="alert">
		<?php echo $message; ?>
	</div>
<?php endif; ?>

<br class="clear" />

<p>NOTE: To import a list of users into the database, please make sure the CSV file being imported has the first column labeled "Email", the second column labeled "First name", and the third column labeled "Second name".</p>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="default">
		<label for="csv">CSV File:</label>
		<div class="uploadfile">
			<?php echo @form_upload('csv', '', 'size="16" id="csv"'); ?>
		</div>
		<br class="clear" />

		<input type="hidden" name="test" value="" />

		<input type="submit" value="Upload File" class="btn btn-success" id="submit" />
		
</form>
