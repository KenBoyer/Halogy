<script type="text/javascript">
function preview(el){
	$.post('<?php echo site_url('/admin/shop/preview'); ?>', { body: $(el).val() }, function(data){
		$('div.preview').html(data);
	});
}
$(function(){
	$('.helpbutton').popover({placement: 'right', html: 'true'});

	$('input[id=image]').change(function() {
	   $('#image-repl').val($(this).val());
	});

	$('div.category>span, div.category>input').hover(
		function() {
			if (!$(this).prev('input').attr('checked') && !$(this).attr('checked')){
				$(this).parent().addClass('hover');
			}
		},
		function() {
			if (!$(this).prev('input').attr('checked') && !$(this).attr('checked')){
				$(this).parent().removeClass('hover');
			}
		}
	);	
	$('div.category>span').click(function(){
		if ($(this).prev('input').attr('checked')){
			$(this).prev('input').attr('checked', false);
			$(this).parent().removeClass('hover');
		} else {
			$(this).prev('input').attr('checked', true);
			$(this).parent().addClass('hover');
		}
	});
	$('a.showtab').click(function(event){
		event.preventDefault();
		var div = $(this).attr('href'); 
		$('div#details, div#desc, div#variations').hide();
		$(div).show();
	});

	$('#product-tabs a:first').tab('show');

	$('.addvar').click(function(event){
		event.preventDefault();
		$(this).parent().parent().siblings('div').toggle('400');
	});
	if ($('input#variation1-1').val()){
		$('div#variation1').children('div.showvars').show();
	}
	if ($('input#variation2-1').val()){
		$('div#variation2').children('div.showvars').show();
	}
	if ($('input#variation3-1').val()){
		$('div#variation3').children('div.showvars').show();
	}	
	$('div#desc, div#variations').hide();

	$('input.save').click(function(){
		var requiredFields = 'input#productName, input#catalogueID';
		var success = true;
		$(requiredFields).each(function(){
			if (!$(this).val()) {
				$('div.panes').scrollTo(
					0, { duration: 400, axis: 'x' }
				);					
				$(this).addClass('error').prev('label').addClass('error');
				$(this).focus(function(){
					$(this).removeClass('error').prev('label').removeClass('error');
				});
				success = false;
			}
		});
		if (!success){
			$('div.tab').hide();
			$('div.tab:first').show();
		}
		return success;
	});
	$('textarea#body').focus(function(){
		$('.previewbutton').show();
	});
	$('textarea#body').blur(function(){
		preview(this);
	});
	preview($('textarea#body'));
});
</script>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="default">

<div class="headingleft">
<h1 class="headingleft">Edit Product</h1>
<a href="<?php echo site_url('/admin/shop/products'); ?>" class="btn">Back to Products <i class="icon-arrow-up"></i></a>
</div>

<div class="headingright">
	<input type="submit" name="view" value="View Product" class="btn btn-info save" />
	<input type="submit" value="Save Changes" class="btn btn-success save" />
</div>

<div class="clear"></div>

<?php if ($errors = validation_errors()): ?>
	<div class="alert alert-error">
		<?php echo $errors; ?>
	</div>
<?php endif; ?>
<?php if (isset($message)): ?>
	<div class="alert">
		<?php echo $message; ?>
	</div>
<?php endif; ?>

<br class="clear" />

<ul class="nav nav-tabs" id="product-tabs">
	<li class="selected"><a href="#details" data-toggle="tab" class="showtab">Details</a></li>
	<li><a href="#desc" data-toggle="tab" class="showtab">Description</a></li>
	<li><a href="#variations" data-toggle="tab" class="showtab">Options &amp; Variations</a></li>	
</ul>

<br class="clear" />

<div class="tab-content">
<div id="details" class="tab-pane active">
	<div class="row">
	<div class="col-lg-6">
	<h2 class="underline">Product Details</h2>
	
	<label for="productName">Product name:</label>
	<?php echo @form_input('productName',set_value('productName', $data['productName']), 'id="productName" class="form-control"'); ?>
	<br class="clear" />

	<label for="catalogueID">Catalog ID:</label>
	<?php echo @form_input('catalogueID',set_value('catalogueID', $data['catalogueID']), 'id="catalogueID" class="form-control"'); ?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Catalog ID Help" data-content="The catalog ID can be used for your own catalog reference and stockkeeping."><i class="icon-question-sign" title="Catalog ID Help"></i></a>
	</span>
	<br class="clear" />

	<label for="subtitle">Ext. URL / Subtitle:</label>
	<?php echo @form_input('subtitle',set_value('subtitle', $data['subtitle']), 'id="subtitle" class="form-control"'); ?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="External URL Help" data-content="If your product has an external website, enter the URL for the site here."><i class="icon-question-sign" title="External URL Help"></i></a>
	</span>
	<br class="clear" />

	<label for="tags">Tags:</label>
	<?php echo @form_input('tags', set_value('tags', $data['tags']), 'id="tags" class="form-control"'); ?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Tag Help" data-content="Separate tags with a comma (e.g. &ldquo;places, hobbies, favorite work&rdquo;)"><i class="icon-question-sign" title="Tag Help"></i></a>
	</span>
	<br class="clear" />
	
	<label for="price">Price:</label>
	<span class="price"><strong><?php echo currency_symbol(); ?></strong></span>
	<?php echo @form_input('price',number_format(set_value('price', $data['price']),2,'.',''), 'id="price" class="form-control small"'); ?>
	<br class="clear" />

	<label for="image">Image:</label>
	<div class="uploadfile">
		<?php if (isset($imagePath)):?>
			<img src="<?php echo $imagePath; ?>" alt="Product image" />
		<?php endif; ?>
		<?php echo @form_upload('image',$this->validation->image, 'size="16" id="image" class="hide"'); ?>
		<div class="input-append">
		   <input id="image-repl" class="input-medium" type="text" value="<?php echo $imagePath; ?>">
		   <a class="btn" onclick="$('input[id=image]').click();">Browse</a>
		</div>
	</div>
	<br class="clear" />
	
	<label for="category">Category:</label>
	<div class="categories">
		<?php if ($categories): ?>
		<?php foreach($categories as $category): ?>
			<div class="category<?php echo (isset($data['categories'][$category['catID']])) ? ' hover' : ''; ?>">
				<?php echo @form_checkbox('catsArray['.$category['catID'].']', $category['catName'], (isset($data['categories'][$category['catID']])) ? 1 : ''); ?><span><?php echo ($category['parentID']) ? '<small>'.$category['parentName'].' &gt;</small> '.$category['catName'] : $category['catName']; ?></span>
			</div>
		<?php endforeach; ?>
		<?php else: ?>
			<div class="category">
				<strong>Warning:</strong> It is strongly recommended that you use categories or this may not appear properly. <a href="<?php echo site_url('/admin/blog/categories'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')"><strong>Please update your categories here</strong></a>.
			</div>
		<?php endif; ?>
	</div>
	<a href="<?php echo site_url('/admin/shop/categories'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')" class="btn">Edit Categories <i class="icon-edit"></i></a>
	<br class="clear" /><br />

	</div>
	<div class="col-lg-6">
	<h2 class="underline">Availability</h2>
	
	<label for="status">Status:</label>
	<?php 
		$values = array(
			'S' => 'In stock',
			'O' => 'Out of stock',
			'P' => 'Pre-order',
			'D' => 'Display only'
		);
		echo @form_dropdown('status',$values,set_value('status', $data['status']), 'id="status" class="form-control"'); 
	?>
	<br class="clear" />
	
	<?php if ($this->site->config['shopStockControl']): ?>
		<label for="stock">Stock:</label>
		<?php echo @form_input('stock',set_value('stock', $data['stock']), 'id="stock" class="form-control small"'); ?>
		<br class="clear" />
	<?php endif; ?>	

	<label for="featured">Featured?</label>
	<?php 
		$values = array(
			'N' => 'No',
			'Y' => 'Yes',
		);
		echo @form_dropdown('featured',$values,set_value('featured', $data['featured']), 'id="featured" class="form-control"'); 
	?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Featured Product Help" data-content="Featured products will show on the online store front page."><i class="icon-question-sign" title="Featured Product Help"></i></a>
	</span>
	<br class="clear" />
	
	<label for="published">Visible:</label>
	<?php 
		$values = array(
			1 => 'Yes',
			0 => 'No (hide product)',
		);
		echo @form_dropdown('published',$values,set_value('published', $data['published']), 'id="published"'); 
	?>
	<br class="clear" />
	</div>
	</div>

</div>

<div id="desc" class="tab-pane">	

	<h2 class="underline">Product Description</h2>
		
	<label for="buttons">Formatting:</label>
	<div class="buttons" id="buttons">
		<a href="#" class="btn boldbutton" title="Bold"><i class="icon-bold"></i></a>
		<a href="#" class="btn italicbutton" title="Italic"><i class="icon-italic"></i></a>
		<a href="#" class="btn btn-small h1button" title="Heading 1">h1</a>
		<a href="#" class="btn btn-small h2button" title="Heading 2">h2</a>
		<a href="#" class="btn btn-small h3button" title="Heading 3">h3</a>
		<a href="#" class="btn urlbutton"><i class="icon-link" title="Insert URL Link"></i></a>
		<a href="<?php echo site_url('/admin/images/browser'); ?>" class="btn halogycms_imagebutton" title="Insert Image"><i class="icon-picture"></i></a>
		<a href="<?php echo site_url('/admin/files/browser'); ?>" class="btn halogycms_filebutton" title="Insert File"><i class="icon-file-alt"></i></a>
		<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Formatting Help" data-content="<p>Select desired text, then click button to format or insert.</p><p>Additional formatting options:</p><ul><li>+ before list elements</li><li>> before block quotes</li><li>4 space indentation to format code listings</li><li>3 hyphens on a line by themselves to make a horizontal rule</li><li>` (backtick quote) to span code within text</li></ul>"><i class="icon-question-sign" title="Formatting Help"></i></a>
		<a href="#" class="btn previewbutton" title="Update Preview"><i class="icon-eye-open"></i></a>
	</div>
	<label for="body">Body:</label>
	<?php echo @form_textarea('description', set_value('description', $data['description']), 'id="body" class="form-control code half"'); ?>
	<div class="preview"></div>
	<br class="clear" /><br />

	<label for="excerpt">Excerpt:</label>
	<?php echo @form_textarea('excerpt',set_value('excerpt', $data['excerpt']), 'id="excerpt" class="form-control short"'); ?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Excerpt Help" data-content="The excerpt is a brief description of your product which is used in some templates."><i class="icon-question-sign" title="Excerpt Help"></i></a>
	</span>
	<br class="clear" /><br />

</div>

<div id="variations" class="tab-pane">

	<h2 class="underline">Options</h2>

	<label for="freePostage">Free Shipping?</label>
	<?php 
		$values = array(
			0 => 'No',
			1 => 'Yes',
		);
		echo @form_dropdown('freePostage',$values,set_value('freePostage', $data['freePostage']), 'id="freePostage"'); 
	?>
	<br class="clear" />

	<label for="files">File:</label>
	<?php
		$options = '';
		$options[0] = 'This product is not a file';			
		if ($files):
			foreach ($files as $file):
				$ext = @explode('.', $file['filename']);
				$options[$file['fileID']] = $file['fileRef'].' ('.strtoupper($ext[1]).')';
			endforeach;
		endif;					
		echo @form_dropdown('fileID',$options,set_value('fileID', $data['fileID']),'id="files" class="form-control"');
	?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="File Help" data-content="You can make this product a downloadable file (e.g. a premium MP3 or document)."><i class="icon-question-sign" title="File Help"></i></a>
	</span>
	<br class="clear" />

	<label for="bands">Shipping Band:</label>
	<?php
		$options = '';
		$options[0] = 'No product is not restricted';			
		if ($bands):
			foreach ($bands as $band):
				$options[$band['bandID']] = $band['bandName'];
			endforeach;
		endif;					
		echo @form_dropdown('bandID', $options, set_value('bandID', $data['bandID']),'id="bands" class="form-control"');
	?>
	<span class="help">
		<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Shipping Help" data-content="You can restrict this product to a shipping band if necessary."><i class="icon-question-sign" title="Shipping Help"></i></a>
	</span>
	<br class="clear" /><br />
	
	<h2 class="underline">Variations</h2>

	<div id="variation1">
		<div class="addvars">
			<p><a href="#" class="addvar btn btn-success">Add <?php echo $this->site->config['shopVariation1']; ?> Variations <i class="icon-plus-sign"></i></a></p>
			<br class="clear" />				
		</div>
		<div class="showvars" style="display: none;">

			<?php foreach (range(1,5) as $x): $i = $x-1; ?>
				
			<label for="variation1-<?php echo $x; ?>"><?php echo $this->site->config['shopVariation1']; ?> <?php echo $x; ?>:</label>
			<?php echo @form_input('variation1-'.$x,set_value('variation1-'.$x, $variation1[$i]['variation']), 'id="variation1-'.$x.'" class="form-control"'); ?><span class="price"><strong><?php echo currency_symbol(); ?></strong></span><?php echo @form_input('variation1_price-'.$x,number_format(set_value('variation1_price-'.$x, $variation1[$i]['price']),2), 'class="form-control small"'); ?>
			<br class="clear" />		

			<?php endforeach; ?>		
										
		</div>
	</div>


	<div id="variation2">
		<div class="addvars">
			<p><a href="#" class="addvar btn btn-success">Add <?php echo $this->site->config['shopVariation2']; ?> Variations <i class="icon-plus-sign"></i></a></p>
			<br class="clear" />				
		</div>
		<div class="showvars" style="display: none;">
			
			<?php foreach (range(1,5) as $x): $i = $x-1; ?>
				
			<label for="variation2-<?php echo $x; ?>"><?php echo $this->site->config['shopVariation2']; ?> <?php echo $x; ?>:</label>
			<?php echo @form_input('variation2-'.$x,set_value('variation2-'.$x, $variation2[$i]['variation']), 'id="variation2-'.$x.'" class="form-control"'); ?><span class="price"><strong><?php echo currency_symbol(); ?></strong></span><?php echo @form_input('variation2_price-'.$x,number_format(set_value('variation2_price-'.$x, $variation2[$i]['price']),2), 'class="form-control small"'); ?>
			<br class="clear" />		

			<?php endforeach; ?>
										
		</div>
	</div>

	<div id="variation3">
		<div class="addvars">
			<p><a href="#" class="addvar btn btn-success">Add <?php echo $this->site->config['shopVariation3']; ?> Variations <i class="icon-plus-sign"></i></a></p>
			<br class="clear" />				
		</div>
		<div class="showvars" style="display: none;">
			
			<?php foreach (range(1,5) as $x): $i = $x-1; ?>
				
			<label for="variation3-<?php echo $x; ?>"><?php echo $this->site->config['shopVariation3']; ?> <?php echo $x; ?>:</label>
			<?php echo @form_input('variation3-'.$x,set_value('variation3-'.$x, $variation3[$i]['variation']), 'id="variation3-'.$x.'" class="form-control"'); ?><span class="price"><strong><?php echo currency_symbol(); ?></strong></span><?php echo @form_input('variation3_price-'.$x,number_format(set_value('variation3_price-'.$x, $variation3[$i]['price']),2), 'class="form-control small"'); ?>
			<br class="clear" />		

			<?php endforeach; ?>
										
		</div>
	</div>

</div>
</div>

<br class="clear" />

<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>
