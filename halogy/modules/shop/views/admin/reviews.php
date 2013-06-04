<div class="headingleft">	
	<h1 class="headingleft">Product Reviews</h1>
</div>

<?php if ($reviews): ?>

<?php echo $this->pagination->create_links(); ?>

<table class="default clear">
	<tr>
		<th>Date Posted</th>
		<th>Product</th>
		<th>Author</th>
		<th>Email</th>
		<th>Review</th>
		<th class="narrow">Status</th>
		<th class="tiny">&nbsp;</th>
		<th class="tiny">&nbsp;</th>
	</tr>
<?php foreach ($reviews as $review): ?>
	<tr>
		<td><?php echo dateFmt($review['dateCreated']); ?></td>
		<td><?php echo anchor('/shop/viewproduct/'.$review['productID'], $review['productName']); ?></td>
		<td><?php echo $review['fullName']; ?></td>
		<td><?php echo $review['email']; ?></td>
		<td><?php echo (strlen($review['review'] > 50)) ? substr($review['review'], 0, 50).'...' : $review['review']; ?></td>
		<td><?php echo ($review['active']) ? '<span style="color:green;">Active</span>' : '<span style="color:orange;">Pending</span>'; ?></td>
		<td>
		<?php
			if (!$review['active'])
			{
				echo anchor('/admin/shop/approve_review/'.$review['reviewID'], 'Approve');
			}
			else
			{
				echo anchor('/admin/shop/deactivate_review/'.$review['reviewID'], 'Deactivate');
			}
		?>
		<td>
			<?php echo anchor('/admin/shop/delete_review/'.$review['reviewID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->pagination->create_links(); ?>

<br class="clear" />
<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php endif; ?>

