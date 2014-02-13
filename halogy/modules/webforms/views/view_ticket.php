<form action="<?php echo site_url($this->uri->uri_string()); ?>" method="post" class="default">

	<div class="headingleft">
	<h1 class="headingleft">View Ticket</h1>
	<a href="<?php echo site_url('/admin/webforms/tickets'); ?>" class="btn">Back to Tickets <i class="icon-arrow-up"></i></a>
	</div>

	<div class="headingright">
		<button type="submit" class="btn btn-success">Update Ticket <i class="icon-refresh"></i></button>	
	</div>

	<br class="clear" />

	<div class="alert alert-info">
		<p>
			<strong>Subject:</strong> [#<?php echo $data['ticketID']; ?>]:</strong> <?php echo $data['subject']; ?><br />
			<strong>Date sent:</strong> <?php echo dateFmt($data['dateCreated']); ?><br />
			<?php if ($data['formName']): ?>
				<strong>Web Form:</strong> <?php echo $data['formName']; ?>
			<?php endif; ?>
		</p>
	</div>

	<div class="row-fluid">
		<div class="span6">
		
			<h2 class="underline">Body</h2>

			<div class="well">
			<?php echo nl2br(auto_link($data['body'])); ?>
			</div>

		</div>

		<div class="span6">
		
			<h2 class="underline">User Details</h2>
		
			<label for="name">Full name:</label>
			<p><?php echo $data['fullName']; ?></p>

			<label for="email">Email:</label>
			<p><a href="mailto:<?php echo $data['email']; ?>?subject=Re: [#<?php echo $data['ticketID']; ?>]: <?php echo $data['subject']; ?>"><?php echo $data['email']; ?></a></p>
			<br class="clear" />

			<h2 class="underline">Process Ticket</h2>

			<label for="closed">Status:</label>
			<?php
				$options = array(
						0 => 'Open',
						1 => 'Closed');
				
				echo form_dropdown('closed',$options,set_value('closed', $data['closed']),'id="closed"');
			?>

			<br class="clear" />

			<label for="notes">Ticket notes:</label>
			<?php echo form_textarea('notes',set_value('notes', $data['notes']), 'id="notes" class="form-control"'); ?>

		</div>
	</div>

<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>
<br class="clear" />

<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
