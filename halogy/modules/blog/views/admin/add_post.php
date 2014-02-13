<script type="text/javascript">
function preview(el){
	$.post('<?php echo site_url('/admin/blog/preview'); ?>', { body: $(el).val() }, function(data){
		$('div.preview').html(data);
	});
}
$(function(){
	$('.helpbutton').popover({placement: 'right', html: 'true'});

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
	$('textarea#body').focus(function(){
		$('.previewbutton').show();
	});
	$('textarea#body').blur(function(){
		preview(this);
	});
	preview($('textarea#body'));
});
</script>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">

<div class="headingleft">
<h1 class="headingleft">Add Blog Post</h1>
<a href="<?php echo site_url('/admin/blog'); ?>" class="btn">Back to Blog Posts <i class="icon-arrow-up"></i></a>
</div>

<div class="headingright">
	<input type="submit" value="Save Changes" class="btn btn-success" />
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

<label for="postName">Title:</label>
<?php echo @form_input('postTitle', set_value('postTitle', $data['postTitle']), 'id="postTitle" class="form-control"'); ?>
<br class="clear" />

<label>Categories:</label>
<div class="categories">
	<?php if ($categories): ?>
	<?php foreach($categories as $category): ?>
		<div class="category">
			<?php echo @form_checkbox('catsArray['.$category['catID'].']', $category['catName']); ?><span><?php echo $category['catName']; ?></span>
		</div>
	<?php endforeach; ?>
	<?php else: ?>
		<div class="category">
			<strong>Warning:</strong> It is strongly recommended that you use categories or this may not appear properly. <a href="<?php echo site_url('/admin/blog/categories'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')"><strong>Please update your categories here</strong></a>.
		</div>
	<?php endif; ?>
</div>
<a href="<?php echo site_url('/admin/blog/categories'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')" class="btn">Edit Categories <i class="icon-edit"></i></a>
<br class="clear" />

<div class="row-fluid">
<div class="span6">

<h2 class="underline">Content</h2>

<label for="excerpt">Excerpt:</label>
<?php echo @form_textarea('excerpt', set_value('excerpt', $data['excerpt']), 'id="excerpt" class="form-control code"'); ?>
<br class="clear" /><br />

</div>
<div class="span6">

<h2 class="underline">Publishing and Options</h2>

<label for="uri">Blog post URI:</label>
<?php echo @form_input('uri', set_value('uri', $data['uri']), 'id="uri" class="form-control"'); ?>
<span class="help">
<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="If your blog post is on an external blog, enter the link to the post here."><i class="icon-question-sign" title="Help"></i></a>
</span>
<br class="clear" />

<label for="tags">Tags:</label>
<?php echo @form_input('tags', set_value('tags', $data['tags']), 'id="tags" class="form-control"'); ?>
<span class="help">
<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="Separate tags with a comma (e.g. &ldquo;places, hobbies, favorite work&rdquo;)"><i class="icon-question-sign" title="Help"></i></a>
</span>
<br class="clear" />

<label for="published">Publish:</label>
<?php 
	$values = array(
		1 => 'Yes',
		0 => 'No (save as draft)',
	);
	echo @form_dropdown('published',$values,set_value('published', $data['published']), 'id="published"'); 
?>
<br class="clear" />	

<label for="allowComments">Allow Comments:</label>
<?php 
	$values = array(
		1 => 'Yes',
		0 => 'No',
	);
	echo @form_dropdown('allowComments',$values,set_value('allowComments', $data['allowComments']), 'id="allowComments"'); 
?>
<br class="clear" />

</div>
</div>

<div class="row-fluid">
<div class="span6">
<h2 class="underline">Body Markdown</h2>

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
</div>
<br class="clear" /><br />

<div class="autosave">
	<?php echo @form_textarea('body', set_value('body', $data['body']), 'id="body" class="form-control code"'); ?>
</div>
<br class="clear" />

</div>
<div class="span6">

<h2 class="underline">Body Preview <a href="#" class="btn previewbutton" title="Update Preview">Update Preview <i class="icon-eye-open"></i></a></h2>
<div class="buttons" id="buttons">
</div>
<div class="preview"></div>
<br class="clear" />

</div>
</div>

<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>
