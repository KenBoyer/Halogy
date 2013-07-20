<div class="headingleft">
<h1 class="headingleft">Blog Comments</h1>
</div>

<?php if ($comments): ?>

<?php echo $this->pagination->create_links(); ?>

<table class="default clear">
	<tr>
		<th>Date Posted</th>
		<th>Post</th>
		<th>Author</th>
		<th>Email</th>
		<th>Comment</th>	
		<th>Status</th>
		<th>&nbsp;</th>
		<th class="tiny">&nbsp;</th>
	</tr>
<?php foreach ($comments as $comment): ?>
	<tr>
		<td><?php echo dateFmt($comment['dateCreated']); ?></td>
		<td><?php echo anchor('/blog/'.dateFmt($comment['uriDate'], 'Y/m/').$comment['uri'], $comment['postTitle']); ?></td>
		<td><?php echo $comment['fullName']; ?></td>
		<td><?php echo $comment['email']; ?></td>
		<td><small><?php echo (strlen($comment['comment'] > 50)) ? htmlentities(substr($comment['comment'], 0, 50)).'...' : htmlentities($comment['comment']); ?></small></td>						
		<td><?php echo ($comment['active']) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Pending</span>'; ?></td>
		<td>
		<?php
			if (!$comment['active'])
			{
				echo anchor('/admin/blog/approve_comment/'.$comment['commentID'], 'Approve <i class="icon-check"></i>', 'class="btn btn-success"');
			}
			else
			{
				echo anchor('/admin/blog/deactivate_comment/'.$comment['commentID'], 'Deactivate <i class="icon-off"></i>', 'class="btn btn-warning"');
			}
		?>
		</td>
		<td>
			<?php echo anchor('/admin/blog/delete_comment/'.$comment['commentID'], 'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this?\')', 'class' => 'btn btn-danger')); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->pagination->create_links(); ?>

<br class="clear" />
<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

<p class="clear">There are no comments yet.</p>

<?php endif; ?>

