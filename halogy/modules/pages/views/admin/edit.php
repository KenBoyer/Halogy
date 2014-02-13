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
<script src="<?php echo $this->config->item('staticPath'); ?>/js/to-markdown.js"></script>

<?php if (!$templates): ?>

<h1>Add Page</h1>

<br />

<div class="alert alert-error">
	<p>You have not yet set up any templates and you will need a template in order to create a page. You can add and import templates <a href="<?php echo site_url('/admin/pages/templates'); ?>">here</a>.</p>
</div>

<?php else: ?>

	<!-- Encoded URI (useful for redirecting in modules)
		<?php echo $this->core->encode($data['uri']); ?>
	-->

	<script type="text/javascript">
	var published = <?php echo $data['active']; ?>;
	var newPage = <?php echo $data['deleted']; ?>;
	var changePath = false;
	var changingPath = false;
		
	function changeTemplate() {
		var templateID = ($('#templateID').val());
		$('#preview').attr('src', '<?php echo site_url('/admin/pages/view_template'); ?>/'+templateID+'/<?php echo $data['pageID']; ?>');
		window.frames['preview.src'] = '<?php echo site_url('/admin/pages/view_template'); ?>/'+templateID+'/<?php echo $data['pageID']; ?>';
		return true;
	}
	
	function saveall(el, postform){
		var requiredFields = 'input#pageName, input#uri';	
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
		if (!success) return false;
		
		$('#target').val($(el).attr('name'));
		var blocks = ($('#preview').contents().find('a.halogycms_savebutton').length);
		var updated = 0;	
		$('#preview').contents().find('a.halogycms_savebutton').each(function(){
			var blockElement = $(this).parent().siblings('div.halogycms_blockelement');
			var blockForm = $(blockElement).siblings('div.halogycms_editblock');	
			var body = $(blockForm).find('textarea').val();
			$.post(this.href,{body: body}, function(data){
				$(blockElement).html(data);
				updated++;
				if (updated == blocks && postform){
					$('#editpage').submit();
				}				
			});
		});
		if (blocks){
			return false;
		} else {
			return true;
		}
	}

	function setUri(){		
		if (!changingPath){
			changingPath = true;			
			var uri = $('#uri').val();
			var pageName = $('#pageName').val();
			var parentID = $('#parentID option:selected').val();
			if (!newPage && !changePath){
				if (confirm('This page is published. Do you also want to change the path to this page? NOTE: Changing the path may change the behavior of associated modules!')){
					changePath = 'yes';
				} else {
					changePath = 'no';
				}
			}
			if (changePath == 'yes' || newPage){
				var newUri = $.post('<?php echo site_url('/admin/pages/generate_uri'); ?>', { uri: pageName, parentID: parentID }, function(data){
					$('#uri').val(data);
					// NOTE: The following was removed to prevent page titles from being overwritten whenever the page name is changed
//					$('#title').val(pageName);
				});
			}
			changingPath = false;
		}
	}
	
	$(function(){		
		$('.clean_block_contents').click(function(e) {
			e.preventDefault();
			editor.save();
			var num = $(this).attr('id');
			var contents = $('#body' + num).val();
			var edStart = contents.indexOf('<!-- InstanceBeginEditable name="content" -->');
			var rest = contents.substr(edStart);
			var edEnd = rest.indexOf('<!-- InstanceEndEditable -->');
			var body = rest.substring(0, edEnd);
			body = body.replace(/\s+/g, " ");
			// invoke conversion from HTML to MarkDown
			body = toMarkdown(body);
			editor.setValue(body);
		});

		$('.helpbutton').popover({placement: 'right', html: 'true'});

		$('#page-tabs a:first').tab('show');

		$('select#modulePage').change(function(){
//			saveall(null, false);
			var modulePage = $('#modulePage').val();
			if (modulePage == 'na') {
				modulePage = '';
				var pageName = $('#pageName').val();
				var parentID = $('#parentID option:selected').val();
				var newUri = $.post('<?php echo site_url('/admin/pages/generate_uri'); ?>', { uri: pageName, parentID: parentID }, function(data){
					$('#uri').val(data);
					// NOTE: The following was removed to prevent page titles from being overwritten whenever the page name is changed
//					$('#title').val(pageName);
				});
				$('.showTemplate').show();
			}
			else if (modulePage.match('!')) {
				modulePage = '';
				alert('Please select module functionality within the module.');
				$('select#modulePage').attr('value', 'na');
				$('.showTemplate').show();
			}
			else {
				$('#uri').val(modulePage);
				$('.showTemplate').hide();		
			}
		});

		$('select#templateID').change(function(){
			saveall(null, false);
			changeTemplate();
		});		
		
		$('input.save').click(function(){
			return saveall(this, true);
		});
	
		$('#pageName').blur(function(){
			setUri();
		});
		$('#parentID').change(function(){
			setUri();
		});
	
		changeTemplate();
		$('div.panes').scrollTo(
			0, { duration: 400, axis: 'x'}
		);

		// Define an extended mixed-mode that understands vbscript and
		// leaves mustache/handlebars embedded templates in html mode
		var mixedMode = {
			name: "htmlmixed",
			scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
				mode: null},
				{matches: /(text|application)\/(x-)?vb(a|script)/i,
				mode: "vbscript"}]
		};

		var editor = CodeMirror.fromTextArea(document.getElementById("body1"), {
			autoCloseTags: true,
			lineNumbers: true,
			mode: mixedMode,
			tabMode: "indent",
			lineWrapping: true,
			extraKeys: {"Ctrl-Space": "autocomplete"}
		});
	});
	</script>
	
	<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default" id="editpage">
	
		<input type="hidden" name="target" id="target" value="" />

		<div class="headingleft">
			<h1 class="headingleft">Edit Page</h1>
			<a href="<?php echo site_url('/admin/pages/viewall'); ?>" class="btn">Back to Page List <i class="icon-arrow-up"></i></a>
		</div>

		<div class="headingright">
			<input type="submit" name="view" value="View Page" class="btn btn-info save" />	
			<input type="submit" id="save" name="save" value="Save Changes" class="btn btn-success save" />
			<input type="submit" name="publish" value="Publish Page" class="btn btn-warning save" />
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

		<div class="row">
			<div class="col-lg-6">

			<h2 class="underline">Basic Information</h2>

			<label for="pageName">Page Name:</label>
			<?php echo @form_input('pageName',$data['pageName'], 'id="pageName" class="form-control"'); ?>
			<span class="help">
			<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="This is the name of the page."><i class="icon-question-sign" title="Help"></i></a>
			</span>
			<br class="clear" />

			<label for="parentID">Parent:</label>
			<?php
				$options = array();
				$options[0] = 'Top Level';
				if ($parents):
					foreach ($parents as $parent):
						if ($parent['pageID'] != @$data['pageID']):
							$options[$parent['pageID']] = '== '.$parent['pageName'].' ('.$parent['uri'].')';
							if (isset($children[$parent['pageID']]) && $children[$parent['pageID']]):
								foreach ($children[$parent['pageID']] as $child):
									$options[$child['pageID']] = '++ '.$child['pageName'].' ('.$child['uri'].')';
								endforeach;
							endif;
						endif;
					endforeach;
				endif;
				echo @form_dropdown('parentID',$options,$data['parentID'],'id="parentID" class="form-control"');
			?>
			<span class="help">
			<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="You can optionally nest this page under other pages."><i class="icon-question-sign" title="Help"></i></a>
			</span>
			<br class="clear" />

			<label for="moduleSelect">Module Page:</label>
			<?php
				$values = array();
				$values['na'] = 'Not a module page';
				$values['!'] = '---------------------------';
				if (@in_array('blog', $this->permission->permissions)) $values['!blog_module'] = 'Blog Module:';
				if (@in_array('blog', $this->permission->permissions)) $values['/blog_main'] = '-- View Blog Posts';		
				if (@in_array('blog', $this->permission->permissions)) $values['/blog'] = '-- View Single Blog Post';		
				if (@in_array('blog', $this->permission->permissions)) $values['/blog/search'] = '-- Blog Search Results';

				if (@in_array('community', $this->permission->permissions)) $values['!community_module'] = 'Community Module:';
				if (@in_array('community', $this->permission->permissions)) $values['/users/account'] = '-- User Account';
				if (@in_array('community', $this->permission->permissions)) $values['/users/create_account'] = '-- Create User Account';
				if (@in_array('community', $this->permission->permissions)) $values['/users/forgotten'] = '-- Forgotten User Password';
				if (@in_array('community', $this->permission->permissions)) $values['/users/profile'] = '-- User Home (My Profile)';
				if (@in_array('community', $this->permission->permissions)) $values['/users/login'] = '-- User Login';
				if (@in_array('community', $this->permission->permissions)) $values['/community'] = '-- Community Members';
				if (@in_array('community', $this->permission->permissions)) $values['/messages'] = '-- Messages';
				if (@in_array('community', $this->permission->permissions)) $values['/messages/sendmessage'] = '-- Messages Form';
				if (@in_array('community', $this->permission->permissions)) $values['/messages/popup'] = '-- Messages Popup';
				if (@in_array('community', $this->permission->permissions)) $values['/messages/read'] = '-- Messages Read';
				if (@in_array('community', $this->permission->permissions)) $values['/users'] = '-- Reset User Password';
				if (@in_array('community', $this->permission->permissions)) $values['/users/profile'] = '-- View User Profile';
//						if (@in_array('community', $this->permission->permissions)) $values['/users/profile'] = '-- View User Private Profile';

				if (@in_array('events', $this->permission->permissions)) $values['!events_module'] = 'Events Module:';
				if (@in_array('events', $this->permission->permissions)) $values['/events'] = '-- View Events';		
				if (@in_array('events', $this->permission->permissions)) $values['/events/viewevent'] = '-- View Single Event';
				if (@in_array('events', $this->permission->permissions)) $values['/events/featured'] = '-- View Featured Events';
				if (@in_array('events', $this->permission->permissions)) $values['/events/search'] = '-- Events Search Results';

				if (@in_array('forums', $this->permission->permissions)) $values['!forums_module'] = 'Forums Module';
				if (@in_array('forums', $this->permission->permissions)) $values['/forums'] = '-- Forums List';
				if (@in_array('forums', $this->permission->permissions)) $values['/forums/deletepost'] = '-- Delete Forum Post';
				if (@in_array('forums', $this->permission->permissions)) $values['/forums/viewforum'] = '-- View Forum';
				if (@in_array('forums', $this->permission->permissions)) $values['/forums/addreply'] = '-- Forum Post Reply';
				if (@in_array('forums', $this->permission->permissions)) $values['/forums/addtopic'] = '-- Forum Post Topic';
				if (@in_array('forums', $this->permission->permissions)) $values['/forums/search'] = '-- Forums Search Results';
				if (@in_array('forums', $this->permission->permissions)) $values['/forums/viewtopic'] = '-- View Forum Topic';

				if (@in_array('shop', $this->permission->permissions)) $values['!shop_module'] = 'Shop Module:';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/account'] = '-- Shopping Account';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop'] = '-- Browse Products';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/cancel'] = '-- Cancel Purchase';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/cart'] = '-- Shopping Cart';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/checkout'] = '-- Checkout';
//						if (@in_array('shop', $this->permission->permissions)) $values['/shop'] = '-- Create Shopping Account';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/donation'] = '-- Successful Donation';		
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/featured'] = '-- Featured Products';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/forgotten'] = '-- Forgotten Shopping Password';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/login'] = '-- Shopping Login';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/orders'] = '-- Shopping Orders';
//						if (@in_array('shop', $this->permission->permissions)) $values['/shop'] = '-- Pre-login';
//						if (@in_array('shop', $this->permission->permissions)) $values['/shop'] = '-- View Product';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/recommend'] = '-- Recommend Product';
//						if (@in_array('shop', $this->permission->permissions)) $values['/shop'] = '-- Reset Shopping Password';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/review'] = '-- Review Product';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/subscriptions'] = '-- Subscriptions';		
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/success'] = '-- Successful Transaction';
				if (@in_array('shop', $this->permission->permissions)) $values['/shop/order'] = '-- View Order';

				if (@in_array('wiki', $this->permission->permissions)) $values['!wiki_module'] = 'Wiki Module:';
				if (@in_array('wiki', $this->permission->permissions)) $values['/wiki'] = '-- Browse Wiki Pages';
				if (@in_array('wiki', $this->permission->permissions)) $values['/wiki/edit'] = '-- Edit Wiki Page';
				if (@in_array('wiki', $this->permission->permissions)) $values['/wiki/pages'] = '-- View Wiki Page';		
				if (@in_array('wiki', $this->permission->permissions)) $values['/wiki/search'] = '-- Wiki Search Results';

//						$values['custom'] = 'Custom Module';

				echo @form_dropdown('modulePage', $values, $data['uri'], 'id="modulePage" class="form-control"');
			?>
			<span class="help">
			<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="To make the page implement module functionality (e.g. Blog Posts), select the module here."><i class="icon-question-sign" title="Help"></i></a>
			</span>
			<br class="clear" />

			<div class="showTemplate">
			<label for="templateID">Template:</label>
			<?php
			if ($templates):
				$options = array();				
				foreach ($templates as $template):
					$options[$template['templateID']] = $template['templateName'];
				endforeach;
				
				echo @form_dropdown('templateID',$options,$data['templateID'],'id="templateID" class="form-control"');
			endif;
			?>
			<span class="help">
			<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="Templates control the layout of your page."><i class="icon-question-sign" title="Help"></i></a>
			</span>
			<br class="clear" />
			</div>

			<label for="uri">Path:</label>
			<?php echo @form_input('uri',$data['uri'], 'id="uri" class="form-control"'); ?>
			<span class="help">
			<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="Enter the web path for this page; e.g. `about-us` (no spaces)."><i class="icon-question-sign" title="Help"></i></a>
			</span>
			<br class="clear" />

			<label for="redirect">Redirect Path:</label>
			<?php echo @form_input('redirect',set_value('redirect', $data['redirect']), 'id="redirect" class="form-control"'); ?>
			<span class="help">
			<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="You can optionally use this page as a redirect to another page."><i class="icon-question-sign" title="Help"></i></a>
			</span>
			<br class="clear" />
			</div>

			<div class="col-lg-6">

			<h2 class="underline">Meta Data</h2>

			<label for="title">Page Title:</label>
			<?php echo @form_input('title',set_value('title', $data['title']), 'id="title" class="form-control"'); ?>
			<span class="help">
			<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="This will display in the title bar of browsers."><i class="icon-question-sign" title="Help"></i></a>
			</span>
			<br class="clear" />

			<label for="description">Meta Description:</label>
			<?php echo @form_input('description',set_value('description', $data['description']), 'id="description" class="form-control"'); ?>
			<span class="help">
			<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="Description of page for search engines."><i class="icon-question-sign" title="Help"></i></a>
			</span>
			<br class="clear" />
				
			<label for="keywords">Meta Keywords:</label>
			<?php echo @form_input('keywords',set_value('keywords', $data['keywords']), 'id="keywords" class="form-control"'); ?>
			<span class="help">
			<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="Meta tags for search engines."><i class="icon-question-sign" title="Help"></i></a>
			</span>
			<br class="clear" /><br />

			<h2 class="underline">Visibility and Access</h2>
	
			<label for="navigation">Show in Navigation:</label>
			<?php 
				$values = array(
					1 => 'Yes',
					0 => 'No (hidden page)',
				);
				echo @form_dropdown('navigation',$values,$data['navigation'], 'id="navigation" class="form-control"'); 
			?>
			<span class="help">
			<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="By default, your page will appear in the navigation menu."><i class="icon-question-sign" title="Help"></i></a>
			</span>
			<br class="clear" />				

			<label for="active">Publish Status:</label>
			<?php 
				$values = array(
					0 => 'Draft (visible only to administrators)',
					1 => 'Publish',
				);
				echo @form_dropdown('active',$values,$data['active'], 'id="active" class="form-control"'); 
			?>
			<span class="help">
			<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="Set this to 'Publish' to make the page visible on the web."><i class="icon-question-sign" title="Help"></i></a>
			</span>
			<br class="clear" />

			<label for="groupID">Edit Group:</label>
			<?php 
				$values = array(
					0 => 'Administrators only',
				);
				if ($groups)
				{
					foreach($groups as $group)
					{
						$values[$group['groupID']] = $group['groupName'];
					}
				}					
				echo @form_dropdown('groupID',$values,$data['groupID'], 'id="groupID" class="form-control"'); 
			?>
			<span class="help">
			<a href="javascript:void(0)" class="btn helpbutton" data-toggle="popover" data-original-title="Help" data-content="Set this to the group of users who may edit this page."><i class="icon-question-sign" title="Help"></i></a>
			</span>
			<br class="clear" /><br />
			</div>
		</div>
		<br class="clear" />

		<ul class="nav nav-tabs" id="page-tabs">
			<li id="tab1" class="selected"><a href="#pane1" data-toggle="tab">Versions</a></li>
			<li id="tab2"><a href="#pane2" data-toggle="tab">Block Content</a></li>
			<li id="tab3"><a href="#pane3" data-toggle="tab">View</a></li>
		</ul>

		<div class="tab-content">
			<div id="pane1" class="tab-pane active">
			<div class="row">
				<div class="col-lg-6">
					<?php if ($versions): ?>

						<h2 class="underline">Published Versions</h2>
							
						<ul>
						<?php foreach($versions as $version): ?>
							<li>
								<?php if ($data['versionID'] == $version['versionID']): ?>
									<strong><?php echo dateFmt($version['dateCreated'], '', '', TRUE).(($user = $this->core->lookup_user($version['userID'], TRUE)) ? ' <em>(by '.$user.')</em>' : ''); ?></strong>
								<?php else: ?>
									<?php echo dateFmt($version['dateCreated'], '', '', TRUE).(($user = $this->core->lookup_user($version['userID'], TRUE)) ? ' <em>(by '.$user.')</em>' : ''); ?> - <?php echo anchor(site_url('/admin/pages/revert_version/'.$data['pageID'].'/'.$version['versionID']), 'Revert', 'onclick="return confirm(\'You will lose unsaved changes. Continue?\');"'); ?>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
						</ul>

						<br />
	
					<?php endif; ?>				
				</div>

				<div class="col-lg-6">
					<?php if ($drafts): ?>
					
						<h2 class="underline">Drafts</h2>
					
						<ul>
						<?php foreach($drafts as $version): ?>
							<li>
								<?php if ($data['draftID'] == $version['versionID']): ?>
									<strong><?php echo dateFmt($version['dateCreated'], '', '', TRUE).(($user = $this->core->lookup_user($version['userID'], TRUE)) ? ' <em>(by '.$user.')</em>' : ''); ?></strong>
								<?php else: ?>
									<?php echo dateFmt($version['dateCreated'], '', '', TRUE).(($user = $this->core->lookup_user($version['userID'], TRUE)) ? ' <em>(by '.$user.')</em>' : ''); ?> - <?php echo anchor(site_url('/admin/pages/revert_draft/'.$data['pageID'].'/'.$version['versionID']), 'Revert', 'onclick="return confirm(\'You will lose unsaved changes. Continue?\');"'); ?>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
						</ul>

					<?php endif; ?>	
				</div>
			</div>
			</div>

			<div id="pane2" class="tab-pane">
				<?php
					if (isset($blocks))
					{
						$block_num = 1;
						foreach ($blocks as $block)
						{
							// Heading for each block (#1...)
							echo "<label for='body'>Block ".$block_num.":</label>";
							// TBD: create CodeMirror textarea instances for each block
							// also, allow for import of file "editable content"
							echo @form_textarea('body'.$block_num, set_value('body'.$block_num, $block), 'id="body'.$block_num.'" class="code editor"');
							?>
							<label for="clean_block_contents">Clean Content:</label>
							<input type="submit" name="clean_block_contents" id="<?php echo $block_num; ?>" value="Filter Block <?php echo $block_num; ?>" class="btn clean_block_contents" />
							<br class="clear" />
							<?php
							$block_num++;
						}
					}
				?>
			</div>

			<div id="pane3" class="tab-pane">
				<iframe name="preview" id="preview" src="about:blank" frameborder="0" marginheight="0" marginwidth="0"></iframe>
			</div>
		</div>
<?php
		// Vizlogix CSRF protection:
		echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
	</form>

	<br class="clear" />
	<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
	
<?php endif; ?>