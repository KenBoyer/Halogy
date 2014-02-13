<style type="text/css">
.ac_results { padding: 0px; border: 1px solid black; background-color: white; overflow: hidden; z-index: 99999; }
.ac_results ul { width: 100%; list-style-position: outside; list-style: none; padding: 0; margin: 0; }
.ac_results li { margin: 0px; padding: 2px 5px; cursor: default; display: block; font: menu; font-size: 12px; line-height: 16px; overflow: hidden; }
.ac_results li span.email { font-size: 10px; } 
.ac_loading { background: white url('<?php echo $this->config->item('staticPath'); ?>/images/loader.gif') right center no-repeat; }
.ac_odd { background-color: #eee; }
.ac_over { background-color: #0A246A; color: white; }
</style>

<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.fieldreplace.js"></script>
<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/shop/order/product'); ?>',$(this).sortable('serialize'),function(data){ });
};

function initOrder(el){
	$('ol.order').height($('ol.order').height());
	$(el).sortable({ 
		axis: 'y',
	    revert: false, 
	    delay: '80',
		distance: '10',
	    opacity: '0.5',
	    update: setOrder
	});
};

function formatItem(row){
	if (row[0].length) return row[1]+'<br /><span class="email">(#'+row[0]+')</span>';
	else return 'No results';
}

$(function(){
    $('#searchbox').fieldreplace();
	function formatItem(row) {
		if (row[0].length) return row[1]+'<br /><span class="email">('+row[0]+')</span>';
		else return 'No results';
	}
	// $('#searchbox').autocomplete("<?php echo site_url('/halogy/ac_sites'); ?>", { delay: "0", selectFirst: false, matchContains: true, formatItem: formatItem, minChars: 2 });
	// $('#searchbox').result(function(event, data, formatted){
		// $(this).parent('form').submit();
	// });	

	$('select#category').change(function(){
		var folderID = ($(this).val());
		window.location.href = '<?php echo site_url('/admin/shop/products'); ?>/'+folderID;
	});	

	initOrder('ol.order, ol.order ol');
});
</script>

<div class="headingleft">
<h1 class="headingleft">Products</h1>
</div>

<div class="headingright">

	<form method="post" action="<?php echo site_url('/admin/shop/products'); ?>" class="form-horizontal" id="search">
	<div class="form-group">
		<div class="input-group">
			<input type="text" name="searchbox" id="searchbox" class="form-control" title="Search Products..." />
			<span class="input-group-btn">
			<button class="btn btn-primary" type="submit" id="searchbutton"><i class="icon-search"></i></button>
			</span>
		</div>
<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
	</div>
	</form>
	
	<label for="category">Category:</label> 
	<?php
		$options = array(
			'' => 'View All Products...',
			'featured' => 'Featured'
		);
		if ($categories):
			foreach ($categories as $category):
				$options[$category['catID']] = ($category['parentID']) ? '-- '.$category['catName'] : $category['catName'];
			endforeach;
		endif;					
		echo @form_dropdown('catID', $options, set_value('catID', $catID), 'id="category" class="form-control"');
	?>	

	<?php if (in_array('shop_edit', $this->permission->permissions)): ?>	
		<a href="<?php echo site_url('/admin/shop/add_product'); ?>" class="btn btn-success">Add Product <i class="icon-plus-sign"></i></a>
	<?php endif; ?>
</div>

<div class="clear"></div>

<?php if ($products): ?>

<hr />

<?php echo $this->pagination->create_links(); ?>
<ol class="order">
	<?php foreach ($products as $product): ?>
	<li class="<?php echo (!$product['published']) ? 'draft' : ''; ?>" id="shop_products-<?php echo $product['productID']; ?>">
		<div class="col1">
			<span <?php if ($product['published']) echo 'style="color:green;"'; ?>>
			<strong><?php echo $product['productName']; ?></strong>
			</span><br />
			<small><?php echo "Catalog ID: ".$product['catalogueID']; ?></small>
		</div>
		<div class="col2">
			<?php echo $product['subtitle']; ?>
		</div>
		<div class="buttons">
			<a href="<?php echo site_url('/shop/viewproduct/'.$product['productID'].'/'); ?>" class="btn btn-warning">View <i class="icon-eye-open"></i></a>
			<a href="<?php echo site_url('/admin/shop/edit_product/'.$product['productID']); ?>" class="btn btn-info">Edit <i class="icon-edit"></i></a>
			<a href="<?php echo site_url('/admin/shop/delete_product/'.$product['productID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="btn btn-danger">Delete <i class="icon-trash"></i></a>
		</div>
		<div class="clear"></div>
	</li>
	<?php endforeach; ?>
</ol>

<?php echo $this->pagination->create_links(); ?>

<br class="clear" />

<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

<p>No products were found.</p>


<?php endif; ?>

