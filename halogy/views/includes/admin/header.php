<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo $this->config->item('staticPath'); ?>/images/favicon.ico" type="image/x-icon" />

	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('staticPath'); ?>/css/bootstrap.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('staticPath'); ?>/css/bootstrap-image-gallery.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('staticPath'); ?>/css/bootstrap-responsive.min.css" media="all" />
	<link rel="stylesheet" href="<?php echo $this->config->item('staticPath'); ?>/css/font-awesome.min.css">

	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="<?php echo $this->config->item('staticPath'); ?>/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('staticPath'); ?>/css/admin.css" media="all" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('staticPath'); ?>/css/datepicker.css" media="screen" />

	<!-- Vizlogix code to enable AJAX form submission with CSRF protection -->
	<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.cookie.js"></script>
	<script language="javascript" type="text/javascript">
	$(function($) {
		$.ajaxSetup({
			data: {
				csrf_test_name: $.cookie('csrf_cookie_name')
			}
			});
		});
	</script>

	<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.scrollTo.min.js"></script>

	<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/admin.js"></script>

	<script language="javascript" type="text/javascript" src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery-ui-timepicker-addon.js"></script>

	<title><?php echo (isset($this->site->config['siteName'])) ? $this->site->config['siteName'] : 'Login to'; ?> Admin - Halogy</title>
	
</head>
<body>

<div class="bg">
	
	<div class="container">

		<div class="row-fluid" style="background-color: #f4f4f4;">
		<div class="span4">
		<div id="header">

			<div id="logo">
			
				<?php
					// set logo
					if ($this->config->item('logoPath')) $logo = $this->config->item('logoPath');
					elseif ($image = $this->uploads->load_image('admin-logo')) $logo = $image['src'];
					else $logo = $this->config->item('staticPath').'/images/halogy_logo.jpg';
				?>

				<h1><a href="<?php echo site_url('/admin'); ?>"><?php echo (isset($this->site->config['siteName'])) ? $this->site->config['siteName'] : 'Login to'; ?> Admin</a></h1>
				<a href="<?php echo site_url('/admin'); ?>"><img src="<?php echo $logo; ?>" alt="Logo" /></a>

			</div>
		</div>
		</div>

		<div class="span8">
			<div id="siteinfo">
				<ul id="toolbar">
					<li><a href="<?php echo site_url('/home'); ?>" class="btn">View Site <i class="icon-eye-open"></i></a></li>				
					<?php if ($this->session->userdata('session_admin')): ?>				
						<li><a href="<?php echo site_url('/admin/dashboard'); ?>" class="btn">Dashboard <i class="icon-dashboard"></i></a></li>
						<li><a href="<?php echo site_url('/admin/users/edit/'.$this->session->userdata('userID')); ?>" class="btn">My Account <i class="icon-table"></i></a></li>
						<?php if ($this->session->userdata('groupID') == $this->site->config['groupID'] || $this->session->userdata('groupID') < 0): ?>
							<li><a href="<?php echo site_url('/admin/site/'); ?>" class="btn">My Site <i class="icon-cog"></i></a></li>
						<?php endif; ?>
						<?php if ($this->session->userdata('groupID') < 0 && @file_exists(APPPATH.'modules/halogy/controllers/halogy.php')): ?>
							<li class="noborder"><a href="<?php echo site_url('/admin/logout'); ?>" class="btn">Logout <i class="icon-signout"></i></a></li>
							<li class="superuser"><a href="<?php echo site_url('/halogy/sites'); ?>" class="btn btn-warning">Sites <i class="icon-cogs"></i></a></li>
						<?php else: ?>
							<li class="last"><a href="<?php echo site_url('/admin/logout'); ?>" class="btn">Logout <i class="icon-signout"></i></a></li>
						<?php endif; ?>						
					<?php else: ?>
						<li class="last"><a href="<?php echo site_url('/admin'); ?>" class="btn">Login <i class="icon-signin"></i></a></li>
					<?php endif; ?>
				</ul>

				<?php if ($this->session->userdata('session_admin')): ?>	
					<h2 class="clear"><strong><?php echo $this->site->config['siteName']; ?> Admin</strong></h2>
					<h3>Logged in as: <strong><?php echo $this->session->userdata('username'); ?></strong></h3>
				<?php endif; ?>	
			</div>

		</div>
		</div>
	</div>

    <div class="container">
    <div class="navbar navbar-static-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <i class="icon-reorder"></i> MENU
          </a>
<!--          <a class="brand" href="#">Online Store Demo</a> -->
          <div class="nav-collapse collapse">
            <ul class="nav">
			<?php if($this->session->userdata('session_admin')): ?>
				<?php if (in_array('pages', $this->permission->permissions)): ?>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages<i class="icon-caret-down"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo site_url('/admin/pages/viewall'); ?>">All Pages</a></li>
							<?php if (in_array('pages_edit', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/pages/add'); ?>">Add Page</a></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>
				<?php if (in_array('pages_templates', $this->permission->permissions)): ?>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Templates<i class="icon-caret-down"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo site_url('/admin/pages/templates'); ?>">All Templates</a></li>
							<li><a href="<?php echo site_url('/admin/pages/includes'); ?>">Includes</a></li>
							<li><a href="<?php echo site_url('/admin/pages/includes/css'); ?>">CSS</a></li>
							<li><a href="<?php echo site_url('/admin/pages/includes/js'); ?>">Javascript</a></li>
						</ul>
					</li>
				<?php endif; ?>	
				<?php if (in_array('images', $this->permission->permissions)): ?>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Uploads<i class="icon-caret-down"></i></a>
						<ul class="dropdown-menu">				
							<li><a href="<?php echo site_url('/admin/images/viewall'); ?>">Images</a></li>
							<?php if (in_array('images_all', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/images/folders'); ?>">Image Folders</a></li>
							<?php endif; ?>
							<?php if (in_array('files', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/files/viewall'); ?>">Files</a></li>
								<?php if (in_array('files_all', $this->permission->permissions)): ?>								
									<li><a href="<?php echo site_url('/admin/files/folders'); ?>">File Folders</a></li>						
								<?php endif; ?>
							<?php endif; ?>								
						</ul>
					</li>
				<?php endif; ?>
				<?php if (in_array('webforms', $this->permission->permissions)): ?>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Web Forms<i class="icon-caret-down"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo site_url('/admin/webforms/tickets'); ?>">Tickets</a></li>
							<?php if (in_array('webforms_edit', $this->permission->permissions)): ?>							
								<li><a href="<?php echo site_url('/admin/webforms/viewall'); ?>">All Web Forms</a></li>
								<li><a href="<?php echo site_url('/admin/webforms/add_form'); ?>">Add Web Form</a></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>
				<?php if (in_array('blog', $this->permission->permissions)): ?>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Blog<i class="icon-caret-down"></i></a>
						<ul class="dropdown-menu">
							<?php if (in_array('blog', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/blog/viewall'); ?>">All Posts</a></li>
							<?php endif; ?>
							<?php if (in_array('blog_edit', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/blog/add_post'); ?>">Add Post</a></li>
							<?php endif; ?>
							<?php if (in_array('blog_cats', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/blog/categories'); ?>">Categories</a></li>
							<?php endif; ?>							
							<li><a href="<?php echo site_url('/admin/blog/comments'); ?>">Comments</a></li>
						</ul>
					</li>
				<?php endif; ?>
				<?php if (in_array('shop', $this->permission->permissions)): ?>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Shop<i class="icon-caret-down"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo site_url('/admin/shop/products'); ?>">All Products</a></li>
							<?php if (in_array('shop_edit', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/add_product'); ?>">Add Product</a></li>
							<?php endif; ?>
							<?php if (in_array('shop_cats', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/categories'); ?>">Categories</a></li>
							<?php endif; ?>
							<?php if (in_array('shop_orders', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/orders'); ?>">View Orders</a></li>
							<?php endif; ?>
							<?php if (in_array('shop_shipping', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/bands'); ?>">Shipping Bands</a></li>
								<li><a href="<?php echo site_url('/admin/shop/postages'); ?>">Shipping Costs</a></li>
								<li><a href="<?php echo site_url('/admin/shop/modifiers'); ?>">Shipping Modifiers</a></li>								
							<?php endif; ?>
							<?php if (in_array('shop_discounts', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/discounts'); ?>">Discount Codes</a></li>
							<?php endif; ?>
							<?php if (in_array('shop_reviews', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/reviews'); ?>">Reviews</a></li>
							<?php endif; ?>
							<?php if (in_array('shop_upsells', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/upsells'); ?>">Upsells</a></li>
							<?php endif; ?>			
						</ul>
					</li>
				<?php endif ?>				
				<?php if (in_array('events', $this->permission->permissions)): ?>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Events<i class="icon-caret-down"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo site_url('/admin/events/viewall'); ?>">All Events</a></li>
						<?php if (in_array('events_edit', $this->permission->permissions)): ?>
							<li><a href="<?php echo site_url('/admin/events/add_event'); ?>">Add Event</a></li>
						<?php endif; ?>	
						</ul>
					</li>
				<?php endif; ?>	
				<?php if (in_array('forums', $this->permission->permissions)): ?>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Forums<i class="icon-caret-down"></i></a>
						<ul class="dropdown-menu">
							<?php if (in_array('forums', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/forums/forums'); ?>">Forums</a></li>
							<?php endif; ?>
							<?php if (in_array('forums_cats', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/forums/categories'); ?>">Forum Categories</a></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>
				<?php if (in_array('wiki', $this->permission->permissions)): ?>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Wiki<i class="icon-caret-down"></i></a>
						<ul class="dropdown-menu">
							<?php if (in_array('wiki_edit', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/wiki/viewall'); ?>">All Wiki Pages</a></li>
							<?php endif; ?>
							<?php if (in_array('wiki_cats', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/wiki/categories'); ?>">Wiki Categories</a></li>
							<?php endif; ?>
							<li><a href="<?php echo site_url('/admin/wiki/changes'); ?>">Recent Changes</a></li>							
						</ul>
					</li>
				<?php endif; ?>
				<?php if (in_array('users', $this->permission->permissions)): ?>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Users<i class="icon-caret-down"></i></a>
					<?php if (in_array('users_groups', $this->permission->permissions)): ?>
						<ul class="dropdown-menu">				
							<li><a href="<?php echo site_url('/admin/users/viewall'); ?>">All Users</a></li>
							<li><a href="<?php echo site_url('/admin/users/groups'); ?>">User Groups</a></li>
						</ul>
					<?php endif; ?>						
					</li>
				<?php endif; ?>
				<?php else: ?>
					<li><a href="<?php echo site_url('/admin'); ?>">Login</a></li>
				<?php endif; ?>					
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    </div>

	<div id="content" class="content container">
