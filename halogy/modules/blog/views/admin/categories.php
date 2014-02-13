<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/blog/order/cat'); ?>',$(this).sortable('serialize'),function(data){ });
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
	$('a.toggle').click(function(event){ 
		event.preventDefault();		
		$('div.hidden-form').slideToggle('400');
	});

	$('.col2').children('input').hide();

	$('a.edit').click(function(event){
		event.preventDefault();
		$(this).parent().siblings('.col2').children('input').show();
		$(this).parent().siblings('.col1').children('span').hide();
	});

	$('input.btn.hide').click(function(event){
		$('.col2').children('input').hide();
		$(this).parent().siblings('.col1').children('span').show();
	});

	initOrder('ol.order');
});
</script>

<div class="headingleft">
<h1 class="headingleft">Blog Categories</h1>
</div>

<div class="headingright">
	<a href="<?php echo site_url('/admin/blog/viewall'); ?>" class="btn btn-info">View Posts</a>
	<a href="#" class="toggle btn btn-success">Add Category <i class="icon-plus-sign"></i></a>
</div>

<div class="clear"></div>

<div class="hidden-form">
	<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">
	
		<label for="categoryName">Category name:</label>
		
		<?php echo @form_input('catName',$blog_cats['catName'], 'class="form-control" id="catName"'); ?>
			
		<input type="submit" value="Add Category" id="submit" class="btn btn-success" />

		<br class="clear" />
<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
	</form>
</div>

<?php if ($categories): ?>

<hr />

<form method="post" action="<?php echo site_url('/admin/blog/edit_cat'); ?>" class="default">

	<ol class="order">
	<?php foreach ($categories as $category): ?>
		<li id="blog_cats-<?php echo $category['catID']; ?>">
			<div class="col1">
				<span><strong><?php echo $category['catName']; ?></strong> <small>(<?php echo url_title(strtolower(trim($category['catName']))); ?>)</small></span>
			</div>
			<div class="col2">
				<?php echo @form_input($category['catID'].'[catName]', $category['catName'], 'class="form-control hide" title="Category Name"'); ?>
				<input type="submit" class="btn btn-success hide" value="Save Changes" />
				<input type="button" class="btn hide" value="Cancel" id="cancel" />
			</div>
			<div class="buttons">
				<a href="#" class="edit btn btn-info">Edit <i class="icon-edit"></i></a>
				<a href="<?php echo site_url('/admin/blog/delete_cat/'.$category['catID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="btn btn-danger">Delete <i class="icon-trash"></i></a>
			</div>
			<div class="clear"></div>
		</li>
	<?php endforeach; ?>
	</ol>
<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>

<br class="clear" />
<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

<p>No blog categories have been created yet.</p>

<?php endif; ?>

