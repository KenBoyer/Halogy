<div class="headingleft">
<h1 class="headingleft">Blog Posts</h1>
</div>

<div class="headingright">
	<?php if (in_array('blog_edit', $this->permission->permissions)): ?>
		<a href="<?php echo site_url('/admin/blog/add_post'); ?>" class="btn btn-success">Add Post <i class="icon-plus-sign"></i></a>
	<?php endif; ?>
</div>

<?php if ($blog_posts): ?>

<?php echo $this->pagination->create_links(); ?>

<table class="default clear">
	<tr>
		<th><?php echo order_link('/admin/blog/viewall','posttitle','Post'); ?></th>
		<th><?php echo order_link('/admin/blog/viewall','datecreated','Date Created'); ?></th>
		<th class="narrow"><?php echo order_link('/admin/blog/viewall','published','Status'); ?></th>
		<th class="tiny">&nbsp;</th>
		<th class="tiny">&nbsp;</th>
	</tr>
<?php foreach ($blog_posts as $post): ?>
	<tr class="<?php echo (!$post['published']) ? 'draft' : ''; ?>">
		<td><?php echo (in_array('blog_edit', $this->permission->permissions)) ? anchor('/admin/blog/edit_post/'.$post['postID'], $post['postTitle']) : $post['postTitle']; ?></td>
		<td><?php echo dateFmt($post['dateCreated'], '', '', TRUE); ?></td>
		<td>
			<?php if ($post['published']): ?>
				<span class="label label-success">Published</span>
			<?php else: ?>
				<span class="label">Draft</span>
			<?php endif; ?>
		</td>
		<td class="tiny">
			<?php if (in_array('blog_edit', $this->permission->permissions)): ?>
				<?php echo anchor('/admin/blog/edit_post/'.$post['postID'], 'Edit <i class="icon-edit"></i>', 'class="btn btn-info"'); ?>
			<?php endif; ?>
		</td>
		<td class="tiny">			
			<?php if (in_array('blog_delete', $this->permission->permissions)): ?>
				<?php echo anchor('/admin/blog/delete_post/'.$post['postID'], 'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this?\')', 'class' => 'btn btn-danger')); ?>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->pagination->create_links(); ?>

<br class="clear" />
<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

<p class="clear">There are no blog posts yet.</p>

<?php endif; ?>