<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/shop/order/cat'); ?>',$(this).sortable('serialize'),function(data){ });
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
<h1 class="headingleft">Shop Categories</h1>
</div>

<div class="headingright">
	<a href="<?php echo site_url('/admin/shop/products'); ?>" class="btn btn-info">View Products</a>
	<a href="<?php echo site_url('/admin/shop/add_cat'); ?>" class="showform btn btn-success">Add Category <i class="icon-plus-sign"></i></a>
</div>

<div class="clear"></div>
<div class="hidden-form"></div>

<?php if ($parents): ?>

<hr />

<form method="post" action="<?php echo site_url('/admin/shop/edit_cat'); ?>">

	<ol class="order">
	<?php foreach ($parents as $cat): ?>
		<li id="shop_cats-<?php echo $cat['catID']; ?>" class="<?php echo (@$children[$cat['catID']]) ? 'haschildren' : ''; ?>">
			<div class="col1">			
				<span><strong><?php echo $cat['catName']; ?></strong></span>
				<small>(<?php echo $cat['catSafe']; ?>)</small>
			</div>
			<div class="col2">&nbsp;</div>
			<div class="buttons">
				<a href="<?php echo site_url('/admin/shop/edit_cat/'.$cat['catID']); ?>" class="showform btn btn-info">Edit <i class="icon-edit"></i></a>
				<a href="<?php echo site_url('/admin/shop/delete_cat/'.$cat['catID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="btn btn-danger">Delete <i class="icon-trash"></i></a>
			</div>
			<div class="clear"></div>
			<?php if (@$children[$cat['catID']]): ?>
				<ol class="subcat">
				<?php foreach ($children[$cat['catID']] as $child): ?>
					<li id="shop_cats-<?php echo $child['catID']; ?>">
						<div class="col1">
							<span class="padded"><img src="<?php echo $this->config->item('staticPath'); ?>/images/arrow_child.gif" alt="Arrow" /></span>
							<span><strong><?php echo $child['catName']; ?></strong></span>
						</div>
						<div class="col2">&nbsp;</div>
						<div class="buttons">
							<a href="<?php echo site_url('/admin/shop/edit_cat/'.$child['catID']); ?>" class="showform btn btn-info">Edit <i class="icon-edit"></i></a>
							<a href="<?php echo site_url('/admin/shop/delete_cat/'.$child['catID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="btn btn-danger">Delete <i class="icon-trash"></i></a>
						</div>
						<div class="clear"></div>
					</li>
				<?php endforeach; ?>
				</ol>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	</ol>

</form>

<?php else: ?>

<p>You haven't set up any shop categories yet.</p>

<?php endif; ?>
