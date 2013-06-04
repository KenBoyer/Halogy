<script type="text/javascript">
	var days = <?php echo $days; ?>;
</script>
<script type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.flot.js"></script>
<!--[if IE]>
	<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/excanvas.js"></script>
<![endif]-->
<script type="text/javascript">
$(function(){
	$.getJSON('<?php echo $this->config->item('base_url'); ?>admin/stats/'+days, function(data){
		// helper for returning the weekends in a period
		function weekendAreas(axes) {
			var markings = [];
			var d = new Date(axes.xaxis.min);
			// go to the first Saturday
			d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
			d.setUTCSeconds(0);
			d.setUTCMinutes(0);
			d.setUTCHours(0);
			var i = d.getTime();
			do {
				// when we don't set yaxis the rectangle automatically
				// extends to infinity upwards and downwards
				markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 } });
				i += 7 * 24 * 60 * 60 * 1000;
			} while (i < axes.xaxis.max);

			return markings;
		}

		var d = [];
		var s = [];
		$.each(data.visits, function(i,item){
			d.push([item[0],item[1]]);
		});
		$.each(data.signups, function(i,item){
			s.push([item[0],item[1]]);
		});

		for (var i = 0; i < d.length; ++i)
			d[i][0] += 60 * 60 * 1000;

		for (var i = 0; i < s.length; ++i)
			s[i][0] += 60 * 60 * 1000;				

		var plot = $.plot($("#placeholder"),
			[ { data: d, label: "Visitations"} , { data: s, label: "Signups" } ],
			{ lines: { show: true, fill: true },
			points: { show: true },
			grid: { hoverable: true, clickable: false, markings: weekendAreas },
			yaxis: { min: 0, tickDecimals: 0 },
			xaxis: { mode: 'time' }
		});

		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
		var previousPoint = null;
		$("#placeholder").bind("plothover", function (event, pos, item) {
		$("#x").text(pos.x.toFixed(2));
		$("#y").text(pos.y.toFixed(2));

		if (item) {
				if (previousPoint != item.datapoint) {
					previousPoint = item.datapoint;
					$("#tooltip").remove();
					var x = item.datapoint[0],
					y = item.datapoint[1];
					showTooltip(item.pageX, item.pageY,
					y + " " + item.series.label);
				}
			} else {
				$("#tooltip").remove();
				previousPoint = null;
			}
		});		
	});
});
</script>
<script type="text/javascript">
function refresh(){
	$('div.loader').load('<?php echo site_url('/admin/activity_ajax'); ?>');
	timeoutID = setTimeout(refresh, 5000);
}
$(function(){
	timeoutID = setTimeout(refresh, 5000);
});
</script>

<div class="row-fluid" id="tpl-2col">
	
	<div class="span8" style="min-width:660px;">

		<div class="headingleft">
		<h1><strong><?php echo ($this->session->userdata('firstName')) ? ucfirst($this->session->userdata('firstName')) : $this->session->userdata('username'); ?>'s</strong> Dashboard</h1>
		</div>
		<br class="clear" />

		<?php if ($errors = validation_errors()): ?>
			<div class="alert alert-error">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>

		<?php if ($message): ?>
			<div class="alert">
				<?php echo $message; ?>
			</div>
		<?php endif; ?>

		<div class="dashboardnav btn-group">
			<a href="<?php echo site_url('/admin/dashboard/90'); ?>" class="btn btn-small <?php echo ($days == 90) ? 'active' : ''; ?>">Last 90 days</a>
			<a href="<?php echo site_url('/admin/dashboard/60'); ?>" class="btn btn-small <?php echo ($days == 60) ? 'active' : ''; ?>">Last 60 Days</a>
			<a href="<?php echo site_url('/admin'); ?>" class="btn btn-small <?php echo ($days == 30) ? 'active' : ''; ?>">Last 30 Days</a>
			<a href="<?php echo site_url('/admin/dashboard/7'); ?>" class="btn btn-small <?php echo ($days == 7) ? 'active' : ''; ?>">Last 7 Days</a>
			<a href="<?php echo site_url('/admin/tracking'); ?>" class="btn btn-small">Most Recent Visits</a>
		</div>

		<div id="placeholder"></div>
		
		<div id="activity" class="loader">
			<?php echo $activity; ?>
		</div>

		<?php if (@in_array('pages', $this->permission->permissions)): ?>

			<div class="module">
			
				<h2><strong>Manage Your Pages</strong></h2>
			
				<p>You can set up a new page or edit other pages on your website easily.</p>
			
				<p><a href="<?php echo site_url('/admin/pages'); ?>" class="btn btn-success">Manage Pages <i class="icon-file-alt"></i></a></p>
				
			</div>

		<?php endif; ?>

		
		<?php if (@in_array('pages_templates', $this->permission->permissions)): ?>

			<div class="module last">
			
				<h2><strong>Build Templates</strong></h2>
			
				<p>Gain full control over templates for pages and modules (such as the Blog).</p>
	
				<p><a href="<?php echo site_url('/admin/pages/templates'); ?>" class="btn btn-success">Manage Templates <i class="icon-file"></i></a></p>
				
			</div>
			
		<?php endif; ?>
		
		<?php if (@in_array('images', $this->permission->permissions)): ?>

			<div class="module">
			
				<h2><strong>Upload Images</strong></h2>
			
				<p>Upload images to your website, either individually or with a ZIP file.</p>
	
				<p><a href="<?php echo site_url('/admin/images'); ?>" class="btn btn-success">Manage Images <i class="icon-picture"></i></a></p>
				
			</div>
			
		<?php endif; ?>
		
		<?php if (@in_array('users', $this->permission->permissions)): ?>
		
			<div class="module last">
			
				<h2><strong>Manage Your Users</strong></h2>
			
				<p>See who's using your site or add administrators to help you run it.</p>
	
				<p><a href="<?php echo site_url('/admin/users'); ?>" class="btn btn-success">Manage Users <i class="icon-user"></i></a></p>
				
			</div>

		<?php endif; ?>

		<?php if (@in_array('blog', $this->permission->permissions)): ?>

			<div class="module">
			
				<h2><strong>Get Busy Blogging</strong></h2>
			
				<p>Add posts to your blog and view comments made by others.</p>
	
				<p><a href="<?php echo site_url('/admin/blog'); ?>" class="btn btn-success">Manage Blog <i class="icon-list"></i></a></p>
				
			</div>
			
		<?php endif; ?>

		<?php if (@in_array('shop', $this->permission->permissions)): ?>
			<div class="module last">
			
				<h2><strong>Build Your Online Store</strong></h2>
			
				<p>Set up categories, add products, and sell online through the store.</p>
			
				<p><a href="<?php echo site_url('/admin/shop'); ?>" class="btn btn-success">Manage Store <i class="icon-shopping-cart"></i></a></p>
				
			</div>
		<?php endif; ?>

		<br class="clear" /><br />

		<?php if ($this->site->config['plan'] > 0 && $this->site->config['plan'] < 6): ?>		

			<div class="quota">
				<div class="<?php echo ($quota > $this->site->plans['storage']) ? 'over' : 'used'; ?>" style="width: <?php echo ($quota > 0) ? (floor($quota / $this->site->plans['storage'] * 100)) : 0; ?>%"><?php echo floor($quota / $this->site->plans['storage'] * 100); ?>%</div>
			</div>
			
			<p><small>You have used <strong><?php echo number_format($quota); ?>kb</strong> out of your <strong><?php echo number_format($this->site->plans['storage']); ?> KB</strong> quota.</small></p>

		<?php endif; ?>

		<br />
	
	</div>
	
	<div class="span4">

		<h3>Site Info</h3>
		
		<table class="default">
			<tr>
				<th class="narrow">Site name:</th>
				<td><?php echo $this->site->config['siteName']; ?></td>
			</tr>
			<tr>
				<th class="narrow">Site URL:</th>
				<td><small><a href="<?php echo $this->site->config['siteURL']; ?>"><?php echo $this->site->config['siteURL']; ?></a></small></td>
			</tr>
			<tr>
				<th class="narrow">Site email:</th>
				<td><small><a href="mailto:<?php echo $this->site->config['siteEmail']; ?>"><?php echo $this->site->config['siteEmail']; ?></a></small></td>
			</tr>
		</table>

		<h3>Site Stats</h3>
		
		<table class="default">
			<tr>
				<th class="narrow">Disk space used:</th>
				<td><?php echo number_format($quota); ?> <small>KB</small></td>
			</tr>
			<tr>
				<th class="narrow">Total page views:</th>
				<td><?php echo number_format($numPageViews); ?> <small>views</small></td>
			</tr>
			<tr>
				<th class="narrow">Pages:</th>
				<td><?php echo $numPages; ?> <small>page<?php echo ($numPages != 1) ? 's' : ''; ?></small></td>
			</tr>
			<?php if (@in_array('blog', $this->permission->permissions)): ?>
				<tr>
					<th class="narrow">Blog posts:</th>
					<td><?php echo $numBlogPosts ?> <small>post<?php echo ($numBlogPosts != 1) ? 's' : ''; ?></small></td>
				</tr>
			<?php endif; ?>
		</table>

		<h3>User Stats</h3>
		
		<table class="default">
			<tr>
				<th class="narrow">Total users:</th>
				<td colspan="2"><?php echo number_format($numUsers); ?> <small>user<?php echo ($numUsers != 1) ? 's' : ''; ?></small></td>
			</tr>
			<tr>
				<th class="narrow">New today:</th>
				<td>			
					<?php echo number_format($numUsersToday); ?> <small>user<?php echo ($numUsersToday != 1) ? 's' : ''; ?></small>
				</td>
				<td>
					<?php
						$difference = @round(100 / $numUsersYesterday * ($numUsersToday - $numUsersYesterday), 2);
						$polarity = ($difference < 0) ? '' : '+';
					?>						
					<?php if ($difference != 0): ?>
						<small>(<span style="color:<?php echo ($polarity == '+') ? 'green' : 'red'; ?>"><?php echo $polarity.$difference; ?>%</span>)</small>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th class="narrow">New yesterday:</th>
				<td colspan="2"><?php echo number_format($numUsersYesterday); ?> <small>user<?php echo ($numUsersYesterday != 1) ? 's' : ''; ?></small></td>
			</tr>
			<tr>
				<th class="narrow">New this week:</th>
				<td>
					<?php echo number_format($numUsersWeek); ?> <small>user<?php echo ($numUsersWeek != 1) ? 's' : ''; ?></small>
				</td>
				<td>
					<?php
						$difference = @round(100 / $numUsersLastWeek * ($numUsersWeek - $numUsersLastWeek), 2);
						$polarity = ($difference < 0) ? '' : '+';
					?>				
					<?php if ($difference != 0): ?>
						<small>(<span style="color:<?php echo ($polarity == '+') ? 'green' : 'red'; ?>"><?php echo $polarity.$difference; ?>%</span>)</small>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th class="narrow">New last week:</th>
				<td colspan="2"><?php echo number_format($numUsersLastWeek); ?> <small>user<?php echo ($numUsersLastWeek != 1) ? 's' : ''; ?></small></td>
			</tr>
		</table>	

		<h3>Most popular pages</h3>

		<?php if ($popularPages): ?>
			<ol>		
				<?php foreach ($popularPages as $page): ?>
					<li><?php echo anchor(site_url('/admin/pages/edit/'.$page['pageID']), $page['pageName']); ?></li>
				<?php endforeach; ?>
			</ol>
		<?php else: ?>
			<p><small>We don't have this information yet.</small></p>
		<?php endif; ?>

<?php if (@in_array('blog', $this->permission->sitePermissions)): ?>

		<h3>Most popular blog posts</h3>

		<?php if ($popularBlogPosts): ?>
			<ol>		
				<?php foreach ($popularBlogPosts as $post): ?>
					<li><?php echo anchor(site_url('/admin/blog/edit_post/'.$post['postID']), $post['postTitle']); ?></li>
				<?php endforeach; ?>
			</ol>
		<?php else: ?>
			<p><small>We don't have this information yet.</small></p>
		<?php endif; ?>

<?php endif; ?>

<?php if (@in_array('shop', $this->permission->sitePermissions)): ?>		

		<h3>Most popular shop products</h3>

		<?php if ($popularShopProducts): ?>
			<ol>		
				<?php foreach ($popularShopProducts as $product): ?>
					<li><?php echo anchor(site_url('/admin/shop/edit_product/'.$product['productID']), $product['productName']); ?></li>
				<?php endforeach; ?>
			</ol>
		<?php else: ?>
			<p><small>We don't have this information yet.</small></p>
		<?php endif; ?>

<?php endif; ?>
		
	</div>
	
	<br class="clear" />

</div>
