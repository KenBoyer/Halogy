<?php if ($user['userID'] != $this->session->userdata('userID')): ?>

	<li><?php echo anchor('/messages/send_message/'.$user['userID'], 'Send a message', 'class="btn sendmessage"'); ?></li>

<?php else: ?>

	<li><?php echo anchor('/users/account#changeavatar', 'Change profile picture', 'class="btn changeavatar"'); ?></li>

<?php endif; ?>