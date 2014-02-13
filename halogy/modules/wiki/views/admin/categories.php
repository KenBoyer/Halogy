<script type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/wiki/order/cat'); ?>',$(this).sortable('serialize'),function(data){ });
};

function initOrder(el){
	$(el).sortable({ 
		axis: 'y',
	    revert: false, 
	    delay: '80',
	    opacity: '0.5',
	    update: setOrder
	});
};

$(function(){
	initOrder('ol.order, ol.order ol');
});
</script>

<div class="headingleft">
	<h1 class="headingleft">Wiki Categories</h1>
</div>

<div class="headingright">
	<a href="<?php echo site_url('/admin/wiki/viewall'); ?>" class="btn btn-info">View Wiki Pages</a>
	<a href="<?php echo site_url('/admin/wiki/add_cat'); ?>" class="showform btn btn-success">Add Category <i class="icon-plus-sign"></i></a>
</div>

<p class="clear">Order your categories below by dragging the items up or down.</p>

<div class="hidden"></div>

<?php if ($parents): ?>

	<hr />

	<ol class="order">
	<?php foreach ($parents as $cat): ?>
		<li id="wiki_cats-<?php echo $cat['catID']; ?>" class="<?php echo (@$children[$cat['catID']]) ? 'haschildren' : ''; ?>">
			<div class="col1">
				<span><strong><?php echo $cat['catName']; ?></strong></span>
			</div>
			<div class="col2">&nbsp;</div>
			<div class="buttons">
				<a href="<?php echo site_url('/admin/wiki/edit_cat/'.$cat['catID']); ?>" class="showform"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_edit.png" alt="Edit" /></a>
				<a href="<?php echo site_url('/admin/wiki/delete_cat/'.$cat['catID']); ?>" onclick="return confirm('Are you sure you want to delete this?')"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_delete.png" alt="Delete" /></a>
			</div>
			<div class="clear"></div>
			<?php if (@$children[$cat['catID']]): ?>
				<ol class="subcat">
				<?php foreach ($children[$cat['catID']] as $child): ?>
					<li id="wiki_cat-<?php echo $child['catID']; ?>">
						<div class="col1">
							<span class="padded"><img src="<?php echo $this->config->item('staticPath'); ?>/images/arrow_child.gif" alt="Arrow" /></span>
							<span><strong><?php echo $child['catName']; ?></strong></span>
						</div>
						<div class="col2">&nbsp;</div>
						<div class="buttons">
							<a href="<?php echo site_url('/admin/wiki/edit_cat/'.$child['catID']); ?>" class="showform"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_edit.png" alt="Edit" /></a>
							<a href="<?php echo site_url('/admin/wiki/delete_cat/'.$child['catID']); ?>" onclick="return confirm('Are you sure you want to delete this?')"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_delete.png" alt="Delete" /></a>
						</div>
						<div class="clear"></div>
					</li>
				<?php endforeach; ?>
				</ol>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	</ol>

<?php else: ?>

<p>You haven't set up any wiki categories yet.</p>

<?php endif; ?>

