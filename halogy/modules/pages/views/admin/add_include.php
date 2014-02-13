<script type="text/javascript">
// $(function(){
	// $('input#submit').click(function(){
		// $('span.autosave-saving').fadeIn('fast');
		// $.post('<?php echo site_url($this->uri->uri_string()); ?>', {
				// includeRef: $('#includeRef').val(),
				// body: $('#body').val()
		// }, function(data){
			// $('span.autosave-saving').fadeOut('fast');
			// $('span.autosave-complete').text(data).fadeIn('fast').delay(3000).fadeOut('fast');
		// });
		// return false;
	// });
// });
</script>
<script src="<?php echo $this->config->item('staticPath'); ?>/codemirror/lib/codemirror.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('staticPath'); ?>/codemirror/lib/codemirror.css">
<style>
.CodeMirror {
border: 1px solid #AAA;
border-radius: 4px;
margin: 4px 0 0 0;
height: 400px;
}
</style>
<script src="<?php echo $this->config->item('staticPath'); ?>/codemirror/addon/hint/show-hint.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('staticPath'); ?>/codemirror/addon/hint/show-hint.css">
<script src="<?php echo $this->config->item('staticPath'); ?>/codemirror/addon/edit/closetag.js"></script>
<script src="<?php echo $this->config->item('staticPath'); ?>/codemirror/addon/hint/html-hint.js"></script>
<script src="<?php echo $this->config->item('staticPath'); ?>/codemirror/mode/xml/xml.js"></script>
<script src="<?php echo $this->config->item('staticPath'); ?>/codemirror/mode/javascript/javascript.js"></script>
<script src="<?php echo $this->config->item('staticPath'); ?>/codemirror/mode/css/css.js"></script>
<script src="<?php echo $this->config->item('staticPath'); ?>/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script type="text/javascript">
var editor;

$(function(){
	$('.helpbutton').popover({placement: 'right', html: 'true'});

<?php
	if ($type == 'C') {
?>
	editor = CodeMirror.fromTextArea(document.getElementById("body"), {
		autoCloseTags: true,
		lineNumbers: true,
		matchBrackets: true,
		mode: 'text/css',
		tabMode: "indent",
		extraKeys: {"Ctrl-Space": "autocomplete"}
	});
<?php
	} elseif ($type == 'L') {
?>
	editor = CodeMirror.fromTextArea(document.getElementById("body"), {
		autoCloseTags: true,
		lineNumbers: true,
		matchBrackets: true,
		mode: 'text/x-less',
		tabMode: "indent",
		extraKeys: {"Ctrl-Space": "autocomplete"}
	});
<?php
	} elseif ($type == 'J') {
?>
	editor = CodeMirror.fromTextArea(document.getElementById("body"), {
		autoCloseTags: true,
		lineNumbers: true,
		matchBrackets: true,
		mode: 'text/javascript',
		tabMode: "indent",
		extraKeys: {"Ctrl-Space": "autocomplete"}
	});
<?php
	} elseif ($type == 'H') {
?>
	editor = CodeMirror.fromTextArea(document.getElementById("body"), {
		autoCloseTags: true,
		lineNumbers: true,
		matchBrackets: true,
		mode: 'text/html',
		tabMode: "indent",
		extraKeys: {"Ctrl-Space": "autocomplete"}
	});
<?php
	} else {
?>
	editor = CodeMirror.fromTextArea(document.getElementById("body"), {
		autoCloseTags: true,
		lineNumbers: true,
		matchBrackets: true,
		mode: 'text/html',
		tabMode: "indent",
		extraKeys: {"Ctrl-Space": "autocomplete"}
	});
<?php
	}
?>
});
</script>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">

	<div class="headingleft">
	<h1 class="headingleft">Add 
		<?php
		if ($type == 'C' || $type == "css") {
			echo 'CSS File';
			$type = 'C';
			$typeLink = 'css';
			$list_type = 'CSS';
		} elseif ($type == 'L' || $type == "less") {
			echo 'LESS File';
			$type = 'L';
			$typeLink = 'less';
			$list_type = 'LESS';
		} elseif ($type == 'J' || $type == "js") {
			echo 'JS File';
			$type = 'J';
			$typeLink = 'js';
			$list_type = 'Javascript';
		} else {
			echo 'Include File';
			$type = 'H';
			$typeLink = '';
			$list_type = 'Include';
		}
		?>
	</h1>
	<a href="<?php echo site_url('/admin/pages/includes'); ?>/<?php echo $typeLink; ?>" class="btn">Back to <?php echo $list_type; ?> Files <i class="icon-arrow-up"></i></a>
	</div>
	
	<div class="headingright">
		<input type="submit" value="Save Changes" id="submit" class="btn btn-success" />
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

<?php if ($type == 'C'): ?>

	<label for="includeRef">Filename:</label>
	<?php echo @form_input('includeRef',set_value('includeRef', $data['includeRef']), 'id="includeRef" class="form-control"'); ?>
	<span class="help">
	<a href="#" class="btn helpbutton" data-toggle="popover" data-original-title="Filename Help" data-content="Your file will be found at &ldquo;/css/filename.css&rdquo; (make sure you use the '.css' extension)."><i class="icon-question-sign" title="Filename Help"></i></a>
	</span>
	<br class="clear" />

	<?php echo @form_hidden('type', 'C'); ?>

<?php elseif ($type == 'L'): ?>

	<label for="includeRef">Filename:</label>
	<?php echo @form_input('includeRef',set_value('includeRef', $data['includeRef']), 'id="includeRef" class="form-control"'); ?>
	<span class="help">
	<a href="#" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="Your LESS file will be compiled into a target css file when you save it (make sure you use the '.less' extension)."><i class="icon-question-sign" title="Help"></i></a>
	</span>
	<br class="clear" />

	<?php echo @form_hidden('type', 'L'); ?>

<?php elseif ($type == 'J'): ?>

	<label for="includeRef">Filename:</label>
	<?php echo @form_input('includeRef',set_value('includeRef', $data['includeRef']), 'id="includeRef" class="form-control"'); ?>
	<span class="help">
	<a href="#" class="btn helpbutton" data-toggle="popover" data-original-title="Filename Help" data-content="Your file will be found at &ldquo;/js/filename.js&rdquo; (make sure you use the '.js' extension)."><i class="icon-question-sign" title="Filename Help"></i></a>
	</span>
	<br class="clear" />

	<?php echo @form_hidden('type', 'J'); ?>

<?php else: ?>

	<label for="includeRef">Reference:</label>
	<?php echo @form_input('includeRef',set_value('includeRef', $data['includeRef']), 'id="includeRef" class="form-control"'); ?>
	<span class="help">
	<a href="#" class="btn helpbutton" data-toggle="popover" data-original-title="Filename Help" data-content="To use this include file, enter {include:<i>reference</i>} in your template."><i class="icon-question-sign" title="Filename Help"></i></a>
	</span>
	<br class="clear" />

	<?php echo @form_hidden('type', 'H'); ?>

<?php endif; ?>

	<label for="body">Markup:</label>	
	<?php echo @form_textarea('body',set_value('body', $data['body']), 'id="body" class="code editor"'); ?>
	<br class="clear" />

<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
	
<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>