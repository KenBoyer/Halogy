<script type="text/javascript">
function preview(el){
	$.post('<?php echo site_url('/admin/events/preview'); ?>', { body: $(el).val() }, function(data){
		$('div.preview').html(data);
	});
}

$(function(){
	$('.helpbutton').popover({placement: 'right', html: 'true'});

	$('input.datebox').datetimepicker({
	dateFormat: 'd M yy',
	timeFormat: 'h:mm tt',
	stepMinute: 15
	});

	$('textarea#body').focus(function(){
		$('.previewbutton').css("display", "inline-block");
	});
	$('textarea#body').blur(function(){
		preview(this);
	});
	preview($('textarea#body'));	
});
</script>

<form name="form" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">

	<div class="headingleft">
		<h1 class="headingleft">Edit Event</h1>
		<a href="<?php echo site_url('/admin/events'); ?>" class="btn">Back to Events <i class="icon-arrow-up"></i></a>
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

	<div class="row-fluid">
	<div class="span6">

	<h2 class="underline">Place and Time</h2>

	<label for="eventName">Event title:</label>
	<?php echo @form_input('eventTitle', set_value('eventTitle', $data['eventTitle']), 'id="eventTitle" class="form-control"'); ?>
	<br class="clear" />

	<label for="eventDate">Start Date and Time:</label>
	<?php echo @form_input('eventDate', date('d M Y g:i a', strtotime($data['eventDate'])), 'id="eventDate" class="form-control datebox" readonly="readonly"'); ?>
	<br class="clear" />

	<label for="eventEnd">End Date and Time:</label>
	<?php echo @form_input('eventEnd', (($data['eventEnd'] > 0) ? date('d M Y g:i a', strtotime($data['eventEnd'])) : ''), 'id="eventEnd" class="form-control datebox" readonly="readonly"'); ?>
	<br class="clear" />

	<label for="time">Repeats:</label>
	<?php
	$options = array(
		'NO' => 'Single Occurrence',
		'DAILY' => 'Daily',
		'MTWTHF' => 'Every weekday (Monday to Friday)',
		'MWF' => 'Every Monday, Wednesday, and Friday',
		'TTH' => 'Every Tuesday and Thursday',
		'WKLY' => 'Weekly',
		'MNTHLY' => 'Monthly',
		'YRLY' => 'Yearly',
	);
	echo @form_dropdown('time', $options, $data['time']);
	?>
	<br class="clear" />

	<label for="location">Location:</label>
	<?php echo @form_input('location', set_value('location', $data['location']), 'id="location" class="form-control"'); ?>
	<br class="clear" />
	</div>

	<div class="span6">
	<h2 class="underline">Publishing</h2>
	
	<label for="featured">Featured:</label>
	<?php 
		$values = array(
			0 => 'No',
			1 => 'Yes',
		);
		echo @form_dropdown('featured',$values,set_value('featured', $data['featured']), 'id="featured"'); 
	?>
	<br class="clear" />

	<label for="tags">Tags:</label>
	<?php echo @form_input('tags', set_value('tags', $data['tags']), 'id="tags" class="form-control"'); ?>
	<span class="help">
	<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="Separate tags with spaces (e.g. &ldquo;event popular London&rdquo;)"><i class="icon-question-sign" title="Help"></i></a>
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

	<label for="excerpt">Headline Excerpt:</label>
	<?php echo @form_textarea('excerpt', set_value('excerpt', $data['excerpt']), 'id="excerpt" class="form-control code"'); ?>
	<br class="clear" /><br />

	</div>
	</div>

	<div class="row-fluid">
	<div class="span6">

	<h2 class="underline">Event Description</h2>	

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

	<?php echo @form_textarea('description', set_value('description', $data['description']), 'id="body" class="form-control code"'); ?>

	</div>
	<div class="span6">

	<h2 class="underline">Event Preview <a href="#" class="btn previewbutton" title="Update Preview">Update Preview <i class="icon-eye-open"></i></a>
</h2>
	<div class="preview"></div>

	</div>
	</div>

	<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>
