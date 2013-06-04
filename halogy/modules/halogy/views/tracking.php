<script type="text/javascript">
function refresh(){
	$('div.loader').load('<?php echo site_url('/admin/tracking_ajax'); ?>');
	timeoutID = setTimeout(refresh, 5000);
}

$(function(){
	timeoutID = setTimeout(refresh, 0);
});
</script>

<div class="headingleft">
<h1 class="headingleft">Most Recent Visits</h1>
<a href="<?php echo site_url('/admin'); ?>" class="btn">Back to Dashboard <i class="icon-arrow-up"></i></a>
</div>

<br />

<div class="loader"></div>

<br class="clear" />

<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>
