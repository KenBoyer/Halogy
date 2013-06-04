<script type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/templates.js" /></script>
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
$(function(){
	$('.helpbutton').popover({placement: 'right', html: 'true'});

	// Define an extended mixed-mode that understands vbscript and
	// leaves mustache/handlebars embedded templates in html mode
	var mixedMode = {
		name: "htmlmixed",
		scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
			mode: null},
			{matches: /(text|application)\/(x-)?vb(a|script)/i,
			mode: "vbscript"}]
	};

	var editor = CodeMirror.fromTextArea(document.getElementById("body"), {
		autoCloseTags: true,
		lineNumbers: true,
		mode: mixedMode,
		tabMode: "indent",
		extraKeys: {"Ctrl-Space": "autocomplete"}
	});
});
</script>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" id="templateform" class="default">

<div class="headingleft">
	<h1 class="headingleft">Edit Template</h1>
	<a href="<?php echo site_url('/admin/pages/templates'); ?>" class="btn">Back to Templates <i class="icon-arrow-up"></i></a>
</div>

	<div class="headingright">
		<input type="button" id="default" value="Reset to Default" class="btn btn-info" />	
		<input type="submit" id="submit" value="Save Changes" class="btn btn-success" />
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
	<div class="autosave" style="display: none;">
		<span class="autosave-saving">
		<div class="alert alert-info">Saving...</div>
		</span>
		<div class="alert alert-success">
		<span class="autosave-complete"></span>
		</div>
	</div>

	<div class="showModuleName">
		<label for="templateName">Name:</label>
		<?php echo @form_input('templateName',set_value('templateName', $data['templateName']), 'id="templateName" class="formelement"'); ?>
		<br class="clear" />
	</div>

	<label for="moduleSelect">Module:</label>
	<?php 
		$values = array();
		$values[''] = 'Not a module template';
		$values['!'] = '---------------------------';
		if (@in_array('blog', $this->permission->permissions)) $values['!blog'] = 'Blog';
		if (@in_array('blog', $this->permission->permissions)) $values['blog'] = '-- View Posts';		
		if (@in_array('blog', $this->permission->permissions)) $values['blog_single'] = '-- Single Post';		
		if (@in_array('blog', $this->permission->permissions)) $values['blog_search'] = '-- Blog Search Results';
		if (@in_array('community', $this->permission->permissions)) $values['!community'] = 'Community';
		if (@in_array('community', $this->permission->permissions)) $values['community_account'] = '-- Account';
		if (@in_array('community', $this->permission->permissions)) $values['community_create_account'] = '-- Create Account';
		if (@in_array('community', $this->permission->permissions)) $values['community_forgotten'] = '-- Forgotten Password';
		if (@in_array('community', $this->permission->permissions)) $values['community_home'] = '-- Home (My Profile)';
		if (@in_array('community', $this->permission->permissions)) $values['community_login'] = '-- Login';
		if (@in_array('community', $this->permission->permissions)) $values['community_members'] = '-- Members';
		if (@in_array('community', $this->permission->permissions)) $values['community_messages'] = '-- Messages';
		if (@in_array('community', $this->permission->permissions)) $values['community_messages_form'] = '-- Messages Form';
		if (@in_array('community', $this->permission->permissions)) $values['community_messages_popup'] = '-- Messages Popup';
		if (@in_array('community', $this->permission->permissions)) $values['community_messages_read'] = '-- Messages Read';
		if (@in_array('community', $this->permission->permissions)) $values['community_reset'] = '-- Reset Password';
		if (@in_array('community', $this->permission->permissions)) $values['community_view_profile'] = '-- View Profile';
		if (@in_array('community', $this->permission->permissions)) $values['community_view_profile_private'] = '-- View Private Profile';
		if (@in_array('events', $this->permission->permissions)) $values['!events'] = 'Events';
		if (@in_array('events', $this->permission->permissions)) $values['events'] = '-- View Events';		
		if (@in_array('events', $this->permission->permissions)) $values['events_single'] = '-- Single Event';
		if (@in_array('events', $this->permission->permissions)) $values['events_featured'] = '-- Featured Events';
		if (@in_array('events', $this->permission->permissions)) $values['events_search'] = '-- Events Search Results';
		if (@in_array('forums', $this->permission->permissions)) $values['!forums'] = 'Forums';
		if (@in_array('forums', $this->permission->permissions)) $values['forums'] = '-- Forums List';
		if (@in_array('forums', $this->permission->permissions)) $values['forums_delete'] = '-- Delete Forum';
		if (@in_array('forums', $this->permission->permissions)) $values['forums_forum'] = '-- View Forum';
		if (@in_array('forums', $this->permission->permissions)) $values['forums_post_reply'] = '-- Post Reply';
		if (@in_array('forums', $this->permission->permissions)) $values['forums_edit_post'] = '-- Edit Post';
		if (@in_array('forums', $this->permission->permissions)) $values['forums_post_topic'] = '-- Post Topic';
		if (@in_array('forums', $this->permission->permissions)) $values['forums_search'] = '-- Forums Search Results';
		if (@in_array('forums', $this->permission->permissions)) $values['forums_topic'] = '-- View Topic';
		if (@in_array('forums', $this->permission->permissions)) $values['forums_edit_topic'] = '-- Edit Topic';
		if (@in_array('shop', $this->permission->permissions)) $values['!shop'] = 'Shop';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_account'] = '-- Account (Shop)';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_browse'] = '-- Browse Products';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_cancel'] = '-- Cancel Purchase';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_cart'] = '-- Shopping Cart';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_checkout'] = '-- Checkout';		
		if (@in_array('shop', $this->permission->permissions)) $values['shop_create_account'] = '-- Create Account (Shop)';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_donation'] = '-- Successful Donation';		
		if (@in_array('shop', $this->permission->permissions)) $values['shop_featured'] = '-- Featured Products';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_forgotten'] = '-- Forgotten Password (Shop)';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_login'] = '-- Login (Shop)';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_orders'] = '-- Orders';		
		if (@in_array('shop', $this->permission->permissions)) $values['shop_prelogin'] = '-- Pre-login';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_product'] = '-- View Product';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_recommend'] = '-- Recommend Product';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_reset'] = '-- Reset Password (Shop)';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_review'] = '-- Review Product';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_subscriptions'] = '-- Subscriptions';		
		if (@in_array('shop', $this->permission->permissions)) $values['shop_success'] = '-- Successful Transaction';
		if (@in_array('shop', $this->permission->permissions)) $values['shop_view_order'] = '-- View Order';
		if (@in_array('wiki', $this->permission->permissions)) $values['!wiki'] = 'Wiki';
		if (@in_array('wiki', $this->permission->permissions)) $values['wiki'] = '-- Browse Pages';
		if (@in_array('wiki', $this->permission->permissions)) $values['wiki_form'] = '-- Edit Page';
		if (@in_array('wiki', $this->permission->permissions)) $values['wiki_page'] = '-- View Page';		
		if (@in_array('wiki', $this->permission->permissions)) $values['wiki_search'] = '-- Wiki Search Results';

		$values['custom'] = 'Custom Module';

		echo @form_dropdown('moduleSelect',$values, (($data['templateName'] == 'custom') ? 'custom' : $data['modulePath']), 'id="moduleSelect" class="formelement" rel="'.site_url('/admin/pages/module').'"'); 
	?>
	<span class="help">
	<a href="#" class="btn helpbutton" data-toggle="popover" data-original-title="Module Help" data-content="To make a module template (e.g., for the blog), select the module here."><i class="icon-question-sign" title="Module Help"></i></a>
	</span>
	<br class="clear" />

	<div class="showModulePath">
		<label for="modulePath">Module Reference:</label>
		<?php echo @form_input('modulePath',set_value('modulePath', $data['modulePath']), 'id="modulePath" class="formelement"'); ?>
		<br class="clear" />
	</div>

	<label for="header">Header:</label>
<?php
	$headers = array();
	$headers[0] = 'No header selected';
	foreach ($includes as $include):
		$headers[$include['includeID']] = $include['includeRef'];
	endforeach;

	echo @form_dropdown('header', $headers, 0, 'id="header" class="formelement"');
?>
	<br class="clear" />

	<label for="body">Markup:</label>
	<?php echo @form_textarea('body', set_value('body', $data['body']), 'id="body" class="code editor"'); ?>
	<br class="clear" />

	<label for="footer">Footer:</label>
<?php
	$footers = array();
	$footers[0] = 'No footer selected';
	foreach ($includes as $include):
		$footers[$include['includeID']] = $include['includeRef'];
	endforeach;

	echo @form_dropdown('footer', $footers, 0, 'id="footer" class="formelement"');
?>
	<br class="clear" />

	<h2>Versions</h2>	

	<ul>
	<?php if ($versions): ?>
		<?php foreach($versions as $version): ?>
			<li>
				<?php if ($data['versionID'] == $version['versionID']): ?>
					<strong><?php echo dateFmt($version['dateCreated'], '', '', TRUE).(($user = $this->core->lookup_user($version['userID'], TRUE)) ? ' <em>(by '.$user.')</em>' : ''); ?></strong>
				<?php else: ?>
					<?php echo dateFmt($version['dateCreated'], '', '', TRUE).(($user = $this->core->lookup_user($version['userID'], TRUE)) ? ' <em>(by '.$user.')</em>' : ''); ?> - <?php echo anchor(site_url('/admin/pages/revert_template/'.$version['objectID'].'/'.$version['versionID']), 'Revert', 'onclick="return confirm(\'You will lose unsaved changes. Continue?\');"'); ?>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
	</ul>

<br class="clear" />
<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>