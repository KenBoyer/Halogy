<?php
	if(!$this->session->userdata('session_admin')) {
?>

	<script type="text/javascript">
	$(function(){
		$('#username').focus();
	});
	</script>

<div class="row-fluid">
<div class="span4">

	<div class="headingleft">
		<h1>Login</h1>
	</div>

	<br class="clear" />

	<?php if ($errors = validation_errors()): ?>
		<div class="alert alert-error">
			<?php echo $errors; ?>
		</div>
	<?php endif; ?>
	
	<form action="" method="post" class="default">

		<label for="username">Username:</label>
		<div class="input-group">
			<span class="input-group-addon"><i class="icon-user"></i></span>
			<input type="text" class="form-control" id="username" name="username" style="width: 40%;" />
		</div>

		<br class="clear" />

		<label for="password">Password:</label>
		<div class="input-group">
			<span class="input-group-addon"><i class="icon-key"></i></span>
			<input type="password" class="form-control" id="password" name="password" style="width: 40%;" />
		</div>
<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
		<br class="clear" />
		<button type="submit" id="login" name="login" class="btn btn-success">Login <i class="icon-signin"></i></button>
	
	</form>

<?php
	} else {
?>

	<h1>Logout</h1>

	<p><a href="/login/logout/">Click here to logout.</a></p>
	
<?php
	}
?>
</div>
<div class="span8">
</div>
</div>