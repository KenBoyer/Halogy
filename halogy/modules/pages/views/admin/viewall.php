<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/pages/order/page'); ?>',$(this).sortable('serialize'),function(data){ });
};
function initOrder(el){
	$('ol.order').height($('ol.order').height());
	$(el).sortable({ 
		axis: 'y',
	    revert: false, 
	    delay: '80',
		distance: '10',
	    opacity: '0.5',
	    update: setOrder
	});
};
$(function(){
	$('#collapse').change(function(){
		if ($(this).val() == 'collapse'){
			$('.subpage').slideUp();
		} else if ($(this).val() == 'hidden'){
			$('.hiddenpage').slideUp();
		} else if ($(this).val() == 'drafts'){
			$('.draft').slideUp();
		} else {
			$('.hiddenpage, .subpage, .draft').slideDown();
		}
	});
	$('a.showform').live('click', function(event){showForm(this,event);});
	$('input#cancel').live('click', function(event){hideForm(this,event);});
	initOrder('ol.order, ol.order ol');
});
</script>

<div class="headingleft">
<h1 class="headingleft">Pages</h1>
</div>

<div class="headingright">

	<label for="collapse">Filter:</label> 
	<select id="collapse">
		<option value="all">Show all</option>		
		<option value="hidden">Hide hidden pages</option>
		<option value="collapse">Hide sub-pages</option>		
		<option value="drafts">Hide drafts</option>		
	</select>
	
	<?php if (in_array('pages_edit', $this->permission->permissions)): ?>	
		<a href="<?php echo site_url('/admin/pages/add'); ?>" class="btn btn-success">Add Page <i class="icon-plus-sign"></i></a>
	<?php endif; ?>
</div>

<div class="clear"></div>

<?php if ($parents): ?>

	<hr />

	<ol class="order">
		<?php foreach ($parents as $page): ?>
		<li id="pages-<?php echo $page['pageID']; ?>" class="<?php echo (!$page['navigation']) ? 'hiddenpage' : ''; ?><?php echo (!$page['active']) ? ' draft' : ''; ?><?php echo (@$children[$page['pageID']]) ? ' haschildren' : ''; ?><?php echo ($page['active'] && $page['datePublished'] > 0 && ($page['newBlocks'] > 0 || $page['newVersions'] > 0)) ? ' draft' : ''; ?>">
		
			<div class="col1">
				<strong><?php echo (in_array('pages_edit', $this->permission->permissions)) ? anchor(site_url('/admin/pages/edit/'.$page['pageID']), $page['pageName'], 'class="pagelink"') : $page['pageName']; ?></strong><br />
				<small>/<?php echo $page['uri'].$this->config->item('url_suffix'); ?></small>
			</div>
			<div class="col2">	
				<?php if ($page['active']): ?>
					<span style="color:green">
						<?php if ($page['redirect']): ?>
							<span class="label label-important">Redirect <i class="icon-circle-arrow-right"></i></span> <?php echo $page['redirect']; ?>
						<?php else: ?>
							<?php if ($page['active'] && $page['datePublished'] > 0 && ($page['newBlocks'] > 0 || $page['newVersions'] > 0)): ?>
								<span class="label label-warning">Published but modified</span>
							<?php else: ?>
								<span class="label label-success">Published</span>
							<?php endif; ?>
							<?php echo (!$page['navigation']) ? ' <span class="label label-inverse">Hidden</span>' : ''; ?>
						<?php endif; ?>						
					</span>
				<?php else: ?>
					<span class="label">Draft</span>
					<?php echo (!$page['navigation']) ? ' <span class="label label-inverse">Hidden</span>' : ''; ?>
				<?php endif; ?>
				<br />
				<?php if ($page['active'] && (!$page['newBlocks'] && !$page['newVersions'])): ?>
					<small>Published: <strong><?php echo dateFmt($page['datePublished'], '', '', TRUE); ?></strong> 
				<?php else: ?>
					<small>Modified: <strong><?php echo dateFmt($page['dateModified'], '', '', TRUE); ?></strong> 
				<?php endif; ?>
				<em>by <?php echo $this->core->lookup_user($page['userID'], TRUE); ?></em></small>
			</div>
			<div class="buttons">
				<?php echo anchor($page['uri'], 'View <i class="icon-eye-open"></i>', 'class="btn btn-warning"'); ?>
				<?php if (in_array('pages_edit', $this->permission->permissions)): ?>
					<?php echo anchor('/admin/pages/edit/'.$page['pageID'], 'Edit <i class="icon-edit"></i>', 'class="btn btn-info"'); ?>
				<?php endif; ?>
				<?php if (in_array('pages_delete', $this->permission->permissions)): ?>
					<?php echo anchor('/admin/pages/delete/'.$page['pageID'], 'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this?\')', 'class' => 'btn btn-danger')); ?>
				<?php endif; ?>
			</div>
			<div class="clear"></div>

			<?php if (isset($children[$page['pageID']]) && $children[$page['pageID']]): ?>
			
				<ol class="subpage">
					<?php foreach ($children[$page['pageID']] as $child): ?>
					<li id="pages-<?php echo $child['pageID']; ?>" class="<?php echo (!$child['navigation']) ? 'hiddenpage' : ''; ?><?php echo (!$child['active']) ? ' draft' : ''; ?><?php echo ($child['active'] && $child['datePublished'] > 0 && ($child['newBlocks'] > 0 || $child['newVersions'] > 0)) ? ' draft' : ''; ?>">
						<div class="col1">
							<span class="padded"><img src="<?php echo $this->config->item('staticPath'); ?>/images/arrow_child.gif" alt="Arrow" /></span> <strong><?php echo (in_array('pages_edit', $this->permission->permissions)) ? anchor('/admin/pages/edit/'.$child['pageID'], $child['pageName'], 'class="pagelink"') : $child['pageName']; ?></strong><br />
							<small>/<?php echo $child['uri'].$this->config->item('url_suffix'); ?></small>
						</div>
						<div class="col2">	
							<?php if ($child['active']): ?>
								<span style="color:green">
									<?php if ($child['redirect']): ?>
										<span class="label label-important">Redirect <i class="icon-circle-arrow-right"></i></span> <?php echo $child['redirect']; ?>
									<?php else: ?>
									<?php if ($child['active'] && $child['datePublished'] > 0 && ($child['newBlocks'] > 0 || $child['newVersions'] > 0)): ?>
										<span class="label label-warning">Published but modified</span>
									<?php else: ?>
										<span class="label label-success">Published</span>
									<?php endif; ?>
										<?php echo (!$child['navigation']) ? ' <span class="label label-inverse">Hidden</span>' : ''; ?>
									<?php endif; ?>						
								</span>
							<?php else: ?>
								<span class="label">Draft</span>
								<?php echo (!$child['navigation']) ? ' <span class="label label-inverse">Hidden</span>' : ''; ?>
							<?php endif; ?>
							<br />
							<?php if ($child['active'] && (!$child['newBlocks'] && !$child['newVersions'])): ?>
								<small>Published: <strong><?php echo dateFmt($child['datePublished'], '', '', TRUE); ?></strong> 
							<?php else: ?>
								<small>Modified: <strong><?php echo dateFmt($child['dateModified'], '', '', TRUE); ?></strong> 
							<?php endif; ?>
							<em>by <?php echo $this->core->lookup_user($child['userID'], TRUE); ?></em></small>
						</div>
						<div class="buttons">
							<?php echo anchor($child['uri'], 'View <i class="icon-eye-open"></i>', 'class="btn btn-warning"'); ?>
							<?php if (in_array('pages_edit', $this->permission->permissions)): ?>
								<?php echo anchor('/admin/pages/edit/'.$child['pageID'], 'Edit <i class="icon-edit"></i>', 'class="btn btn-info"'); ?>
							<?php endif; ?>
							<?php if (in_array('pages_delete', $this->permission->permissions)): ?>
								<?php echo anchor('/admin/pages/delete/'.$child['pageID'], 'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this?\')', 'class' => 'btn btn-danger')); ?>
							<?php endif; ?>
						</div>
						<div class="clear"></div>
						
						<?php if (isset($subchildren[$child['pageID']]) && $subchildren[$child['pageID']]): ?>
						
							<ol class="subpage">
								<?php foreach ($subchildren[$child['pageID']] as $subchild): ?>
								<li id="pages-<?php echo $subchild['pageID']; ?>" class="<?php echo (!$subchild['navigation']) ? 'hiddenpage' : ''; ?><?php echo (!$subchild['active']) ? ' draft' : ''; ?><?php echo ($subchild['active'] && $subchild['datePublished'] > 0 && ($subchild['newBlocks'] > 0 || $subchild['newVersions'] > 0)) ? ' draft' : ''; ?>">
									<div class="col1">
										<span class="padded"><img src="<?php echo $this->config->item('staticPath'); ?>/images/arrow_subchild.gif" alt="Arrow" /></span> <strong><?php echo (in_array('pages_edit', $this->permission->permissions)) ? anchor('/admin/pages/edit/'.$subchild['pageID'], $subchild['pageName'], 'class="pagelink"') : $subchild['pageName']; ?></strong><br />
									<small>/<?php echo $subchild['uri'].$this->config->item('url_suffix'); ?></small>
									</div>
									<div class="col2">	
										<?php if ($subchild['active']): ?>
											<span style="color:green">
												<?php if ($subchild['redirect']): ?>
													<span class="label label-important">Redirect <i class="icon-circle-arrow-right"></i></span> <?php echo $subchild['redirect']; ?>
												<?php else: ?>
												<?php if ($subchild['active'] && $subchild['datePublished'] > 0 && ($subchild['newBlocks'] > 0 || $subchild['newVersions'] > 0)): ?>
													<span class="label label-warning">Published but modified</span>
												<?php else: ?>
													<span class="label label-success">Published</span>
												<?php endif; ?>
													<?php echo (!$subchild['navigation']) ? ' <span class="label label-inverse">Hidden</span>' : ''; ?>
												<?php endif; ?>						
											</span>
										<?php else: ?>
											<span class="label">Draft</span>
											<?php echo (!$subchild['navigation']) ? ' <span class="label label-inverse">Hidden</span>' : ''; ?>
										<?php endif; ?>
										<br />
										<?php if ($subchild['active'] && (!$subchild['newBlocks'] && !$subchild['newVersions'])): ?>
											<small>Published: <strong><?php echo dateFmt($subchild['datePublished'], '', '', TRUE); ?></strong> 
										<?php else: ?>
											<small>Modified: <strong><?php echo dateFmt($subchild['dateModified'], '', '', TRUE); ?></strong> 
										<?php endif; ?>
										<em>by <?php echo $this->core->lookup_user($subchild['userID'], TRUE); ?></em></small>
									</div>
									<div class="buttons">
										<?php echo anchor($subchild['uri'], 'View <i class="icon-eye-open"></i>', 'class="btn btn-warning"'); ?>
										<?php if (in_array('pages_edit', $this->permission->permissions)): ?>
											<?php echo anchor('/admin/pages/edit/'.$subchild['pageID'], 'Edit <i class="icon-edit"></i>', 'class="btn btn-info"'); ?>
										<?php endif; ?>
										<?php if (in_array('pages_delete', $this->permission->permissions)): ?>
											<?php echo anchor('/admin/pages/delete/'.$subchild['pageID'], 'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this?\')', 'class' => 'btn btn-danger')); ?>
										<?php endif; ?>
									</div>
									<div class="clear"></div>

									<?php if (isset($subchildren[$subchild['pageID']]) && $subchildren[$subchild['pageID']]): ?>
									
										<ol class="subpage">
											<?php foreach ($subchildren[$subchild['pageID']] as $subsubchild): ?>
											<li id="pages-<?php echo $subsubchild['pageID']; ?>" class="<?php echo (!$subsubchild['navigation']) ? 'hiddenpage' : ''; ?><?php echo (!$subsubchild['active']) ? ' draft' : ''; ?><?php echo ($subsubchild['active'] && $subsubchild['datePublished'] > 0 && ($subsubchild['newBlocks'] > 0 || $subsubchild['newVersions'] > 0)) ? ' draft' : ''; ?>">
												<div class="col1">
													<span class="padded"><img src="<?php echo $this->config->item('staticPath'); ?>/images/arrow_subchild.gif" alt="Arrow" /></span> <strong><?php echo (in_array('pages_edit', $this->permission->permissions)) ? anchor('/admin/pages/edit/'.$subsubchild['pageID'], $subsubchild['pageName'], 'class="pagelink"') : $subsubchild['pageName']; ?></strong><br />
												<small>/<?php echo $subsubchild['uri'].$this->config->item('url_suffix'); ?></small>
												</div>
												<div class="col2">	
													<?php if ($subsubchild['active']): ?>
														<span style="color:green">
															<?php if ($subsubchild['redirect']): ?>
																<span class="label label-important">Redirect <i class="icon-circle-arrow-right"></i></span> <?php echo $subsubchild['redirect']; ?>
															<?php else: ?>
															<?php if ($subsubchild['active'] && $subsubchild['datePublished'] > 0 && ($subsubchild['newBlocks'] > 0 || $subsubchild['newVersions'] > 0)): ?>
																<span class="label label-warning">Published but modified</span>
															<?php else: ?>
																<span class="label label-success">Published</span>
															<?php endif; ?>
																<?php echo (!$subsubchild['navigation']) ? ' <span class="label label-inverse">Hidden</span>' : ''; ?>
															<?php endif; ?>						
														</span>
													<?php else: ?>
														<span class="label">Draft</span>
														<?php echo (!$subsubchild['navigation']) ? ' <span class="label label-inverse">Hidden</span>' : ''; ?>
													<?php endif; ?>
													<br />
													<?php if ($subsubchild['active'] && (!$subsubchild['newBlocks'] && !$subsubchild['newVersions'])): ?>
														<small>Published: <strong><?php echo dateFmt($subsubchild['datePublished'], '', '', TRUE); ?></strong> 
													<?php else: ?>
														<small>Modified: <strong><?php echo dateFmt($subsubchild['dateModified'], '', '', TRUE); ?></strong> 
													<?php endif; ?>
													<em>by <?php echo $this->core->lookup_user($subsubchild['userID'], TRUE); ?></em></small>
												</div>
												<div class="buttons">
													<?php echo anchor($subsubchild['uri'], 'View <i class="icon-eye-open"></i>', 'class="btn btn-warning"'); ?>
													<?php if (in_array('pages_edit', $this->permission->permissions)): ?>
														<?php echo anchor('/admin/pages/edit/'.$subsubchild['pageID'], 'Edit <i class="icon-edit"></i>', 'class="btn btn-info"'); ?>
													<?php endif; ?>
													<?php if (in_array('pages_delete', $this->permission->permissions)): ?>
														<?php echo anchor('/admin/pages/delete/'.$subsubchild['pageID'], 'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this?\')', 'class' => 'btn btn-danger')); ?>
													<?php endif; ?>
												</div>
												<div class="clear"></div>
											</li>
											<?php endforeach; ?>
										</ol>
											
									<?php endif; ?>	
								</li>
								<?php endforeach; ?>
							</ol>
								
						<?php endif; ?>	

						
					</li>
					<?php endforeach; ?>
				</ol>
					
			<?php endif; ?>	
						
		</li>
		<?php endforeach; ?>
	</ol>
	
	<br />
	
	<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

<p class="clear">No pages were found.</p>

<?php endif; ?>
