<script type="text/javascript">
$(function(){
	$('.helpbutton').popover({placement: 'right', html: 'true'});

	$('#site-tabs a:first').tab('show');

	$('div.permissions input[type="checkbox"]').each(function(){
		if ($(this).attr('checked')) {
			$(this).parent('div').prev('div').children('input[type="checkbox"]').attr('checked', true);
		}
	});	
	$('input.selectall').click(function(){
		$el = $(this).parent('div').next('div').children('input[type="checkbox"]');
		$flag = $(this).attr('checked');
		if ($flag) {
			$($el).attr('checked', true);
		}
		else {
			$($el).attr('checked', false);
		}
	});
	$('.seemore').click(function(){
		$el = $(this).parent('div').next('div');
		$($el).toggle('400');
	});
	$('#siteDomain').change(function(){
		var domainVal = $(this).val();
		domainVal = domainVal.replace(/^(http)s?:\/+((w+)\.)?|^www\.|\/+/i, '');
		$(this).val(domainVal);
		$('#siteURL').val('http://www.'+domainVal);
	});
	$('#adminEmail').change(function(){
		$('#username').val($(this).val());
	});
	// $('#siteDomain').change(function(){
		// var domainVal = $(this).val();
		// var tld = '';
		// domainVal = domainVal.replace(/^(http)s?:\/+((w+)\.)?|^www\.|\/|\/(.+)/ig, '');
		// if (tld = domainVal.match(/\.[a-z]{2,3}\.[a-z]{2}$/i)){
			// domainVal = domainVal.replace(/\.[a-z]{2,3}\.[a-z]{2}$/i, '');
			// domainVal = domainVal.replace(/^(.+)\./ig, '');
			// domainVal = domainVal+tld;
		// }
		// else if (tld = domainVal.match(/\.[a-z]{2,4}$/i)){
			// domainVal = domainVal.replace(/\.[a-z]{2,4}$/i, '');
			// domainVal = domainVal.replace(/(.+)\./ig, '');
			// domainVal = domainVal+tld;
		// }
		// $(this).val(domainVal);
		// $('#siteURL').val('http://www.'+domainVal);
		// $('#siteEmail').val('info@'+domainVal);
	// });
	$('form').submit(function(){
		$('div.permissions input').each(function(){
			if($(this).attr('checked') != true){
				$(this).closest('form').submit();
			};
		});
		alert('You do not have any permissions set for this site.');
		return false;
	});
	$('a.selectall').click(function(event){
		event.preventDefault();
		$('input[type="checkbox"]').attr('checked', true);
	});
	$('a.deselectall').click(function(event){
		event.preventDefault();
		$('input[type="checkbox"]').attr('checked', false);
	});
});
</script>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">

<div class="headingleft">
	<h1 class="headingleft">Add Site</h1>
	<a href="<?php echo site_url('/halogy/sites'); ?>" class="btn">Back to Sites <i class="icon-arrow-up"></i></a>
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

<div class="clear"></div>

<ul class="nav nav-tabs" id="site-tabs">
	<li class="selected"><a href="#tab1" data-toggle="tab" class="showtab">Details</a></li>
	<li><a href="#tab2" data-toggle="tab" class="showtab">Administrator</a></li>	
	<li><a href="#tab3" data-toggle="tab" class="showtab">Permissions</a></li>
</ul>

<br class="clear" />
<div class="tab-content">
<div id="tab1" class="tab-pane active">

	<h2>Domains</h2>

	<label for="siteDomain">Domain:</label>
	<?php echo @form_input('siteDomain', set_value('siteDomain', $data['siteDomain']), 'id="siteDomain" class="formelement"'); ?>
	<span class="tip">For example 'mysite.com' (no sub-domains, www or trailing slashes)</span><br class="clear" />
	
	<label for="altDomain">Staging Domain:</label>
	<?php echo @form_input('altDomain', set_value('altDomain', $data['altDomain']), 'id="altDomain" class="formelement"'); ?>
	<span class="tip">Optional alternative domain for staging sites.</span><br class="clear" /><br />

	<h2>Site Details</h2>

	<label for="siteName">Name of Site:</label>
	<?php echo @form_input('siteName', set_value('siteName', $data['siteName']), 'id="siteName" class="formelement"'); ?>
	<span class="tip">The name of the site</span><br class="clear" />

	<label for="siteURL">URL:</label>
	<?php echo @form_input('siteURL', set_value('siteURL', $data['siteURL']), 'id="siteURL" class="formelement"'); ?>
	<span class="tip">The full URL to the site</span><br class="clear" />

	<label for="siteEmail">Email:</label>
	<?php echo @form_input('siteEmail', set_value('siteEmail', $data['siteEmail']), 'id="siteEmail" class="formelement"'); ?>
	<span class="tip">The site contact email</span><br class="clear" />

	<label for="siteTel">Telephone:</label>
	<?php echo @form_input('siteTel', set_value('siteTel', $data['siteTel']), 'id="siteTel" class="formelement"'); ?>
	<span class="tip">The site contact telephone number</span><br class="clear" />
	<br class="clear" />

</div>

<div id="tab2" class="tab-pane">

	<h2>Administrator Details</h2>

	<label for="adminEmail">Email:</label>
	<?php echo @form_input('adminEmail', set_value('adminEmail', $data['adminEmail']), 'id="adminEmail" class="formelement"'); ?>
	<span class="tip">The email / username for the main administrator</span>
	<br class="clear" />

	<label for="username">Username:</label>
	<?php echo @form_input('username', set_value('username', $data['username']), 'id="username" class="formelement"'); ?>
	<br class="clear" />

	<label for="password">Password:</label>
	<?php echo @form_password('password', set_value('password', $data['password']), 'id="password" class="formelement"'); ?>
	<br class="clear" />

	<label for="confirmPassword">Confirm Password:</label>
	<?php echo @form_password('confirmPassword', set_value('confirmPassword', $data['confirmPassword']), 'id="confirmPassword" class="formelement"'); ?>
	<br class="clear" />

	<label for="firstName">First Name:</label>
	<?php echo @form_input('firstName',set_value('firstName', $data['firstName']), 'id="firstName" class="formelement"'); ?>
	<br class="clear" />

	<label for="lastName">Last Name:</label>
	<?php echo @form_input('lastName',set_value('lastName', $data['lastName']), 'id="lastName" class="formelement"'); ?>
	<br class="clear" /><br />

</div>

<div id="tab3" class="tab-pane">

	<h2>Permissions</h2>

	<p><a href="#" class="selectall button small nolabel grey">Select All</a> <a href="#" class="deselectall button small nolabel grey">De-Select All</a></p>

	<?php if ($permissions): ?>
	<?php foreach ($permissions as $cat => $perms): ?>

		<div class="perm-heading">
			<label for="<?php echo strtolower($cat); ?>_all" class="radio"><?php echo $cat; ?></label>
			<input type="checkbox" class="selectall checkbox" id="<?php echo strtolower($cat); ?>_all" />
			<input type="button" value="See more" class="seemore small-button" />
		</div>

		<div class="permissions">

		<?php foreach ($perms as $perm): ?>

			<label for="<?php echo 'perm_'.$perm['key']; ?>" class="radio"><?php echo $perm['permission']; ?></label>
			<?php echo @form_checkbox('perm'.$perm['permissionID'], 1, set_value('perm'.$perm['permissionID'], $data['perm'.$perm['permissionID']]), 'id="'.'perm_'.$perm['key'].'" class="checkbox"'); ?>
			<br class="clear" />

		<?php endforeach; ?>

		</div>

	<?php endforeach; ?>
	<?php endif; ?>
	
</div>
</div>

<?php
	// Vizlogix CSRF protection:
	echo '<input style="display: none;" type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
?>
</form>

<br class="clear" />
<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
