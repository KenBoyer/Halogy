<link rel="stylesheet" href="<?php echo $this->config->item('staticPath'); ?>/dt/media/css/jquery.dataTables.css">
<style>
table.dataTable td {
  font-size: .8em;
  line-height: 1em;
}
</style>
<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/dt/media/js/jquery.dataTables.js"></script>
<script language="javascript" type="text/javascript">
$(function(){
	$('select#filter').change(function(){
		var status = ($(this).val());
		window.location.href = '<?php echo site_url('/admin/webforms/tickets'); ?>/'+status;
	});

	$('#view_tickets').click(function() {
		$.ajax({
		   type: 'GET',
		   url: '<?php echo site_url('/admin/webforms/display_tickets/'.$status); ?>',
		   data: null,
		   success: function(text) {
			   var fields = text.split(/(",\n)/);
			   fields.pop(fields.length);
			   var headers = fields[0].split(','), html = '<table id="csv" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">';
			   html += '<thead><tr>';
			   // remove the "Notes" column
			   for (var i = 0; i < headers.length - 1; i++) {
				  headers[i] = headers[i].replace(/"/gi, '');
				  html += '<th>' + headers[i] + '</th>';
			   }
			   html += '</tr></thead><tbody>';
			   var data = fields.slice(1, fields.length);
//			   alert(data);
			   for (var j = 0; j < data.length; j++) {
			      data[j] = data[j].replace(/(",\n)/gi, '');
				  if (data[j].length > 0) {
//					  alert("data " + j + ": " + data[j]);
					  var dataFields = data[j].split(/(",")/);
					  html += '<tr>';
					  for (var i = 0; i < dataFields.length; i++) {
						dataFields[i] = dataFields[i].replace(/(",")/gi, '');
						if (dataFields[i].length > 0) {
//							alert("field " + i + ": " + dataFields[i]);
							dataFields[i] = dataFields[i].replace(/"/gi, '');
							html += '<td>';
							var lines = dataFields[i].split(/\n/);
							if (lines.length > 1) {
								for (var l = 0; l < lines.length; l++) {
									if (lines[l].search("NONE") == -1 && lines[l].length > 0) {
										html += (lines[l] + '<br />');
									}
								}
							} else {
								html += dataFields[i];
							}
							html += '</td>';
						}
					  }
					  html += '</tr>';
				  }
			   }
			   html += '</tbody></table>';
			   $('div#viewer').html(html);
			   $('div#viewer:hidden').toggle('400');
			   $('#csv').dataTable(
			   // {
					// "sDom": "<'row'<'span8'l><'span8'f>r>t<'row'<'span8'i><'span8'p>>",
					// "sScrollX": "100%",
					// "bJQueryUI": true,
					// "oLanguage": {
						// "sSearch": "Search all columns:",
						// "oPaginate": {
							// "sFirst": "",
							// "sLast": "",
							// "sNext": "",
							// "sPrevious": ""
						// }
					// }
				// }
				);
		   }
		});
	});

	// $.extend( $.fn.dataTableExt.oStdClasses, {
    // "sSortAsc": "header headerSortDown",
    // "sSortDesc": "header headerSortUp",
    // "sSortable": "header"
	// });
});
</script>

<div class="headingleft">
<h1 class="headingleft">Tickets <small><?php if ($status) echo '('.$status.')'?></small></h1>
</div>

<div class="headingright">

	<label for="filter">Filter:</label>
	<?php
		$options[''] = 'View All';
		$options['open'] = 'Open';
		$options['closed'] = 'Closed';

		$options['-'] = '--------------------';

		if ($webforms)
		{
			foreach($webforms as $form)
			{
				$options[$form['formID']] = $form['formName'];
			}
		}

		echo form_dropdown('filter', $options, $this->uri->segment(4), 'id="filter"');
	?>

	<a href="#" id="view_tickets" class="btn btn-info">View Tickets Table <i class="icon-eye-open"></i></a>
	<a href="<?php echo site_url('/admin/webforms/export_tickets/'.$status); ?>" class="btn btn-info">Export Tickets as CSV <i class="icon-download-alt"></i></a>

	<a href="<?php echo site_url('/admin/webforms/viewall'); ?>" class="btn btn-info">Web Forms</a>

</div>

<div id="viewer" class="clear"></div>

<br class="clear" />

<?php if ($tickets): ?>

<?php echo $this->pagination->create_links(); ?>

<table class="default">
	<tr>
		<th><?php echo order_link('admin/webforms/tickets','subject','[Ticket ID]: Subject'); ?></th>
		<th><?php echo order_link('admin/webforms/tickets','dateCreated','Date'); ?></th>
		<th><?php echo order_link('admin/webforms/tickets','formName','Web Form'); ?></th>
		<th><?php echo order_link('admin/webforms/tickets','closed','Status'); ?></th>
		<th><?php echo order_link('admin/webforms/tickets','fullName','From'); ?></th>
		<th><?php echo order_link('admin/webforms/tickets','email','Email'); ?></th>
		<th class="tiny">&nbsp;</th>
		<th class="tiny">&nbsp;</th>
	</tr>
<?php
	$i=0;
	foreach ($tickets as $ticket):
	$class = ($i % 2) ? ' class="alt"' : '';
	$style = (!$ticket['viewed']) ? ' style="font-weight: bold;"' : '';
	$i++;
?>
	<tr>
		<td <?php echo $class; ?><?php echo $style; ?>><?php echo anchor('/admin/webforms/view_ticket/'.$ticket['ticketID'], '[#'.$ticket['ticketID'].']: '.$ticket['subject']); ?></td>
		<td><?php echo dateFmt($ticket['dateCreated'], '', '', TRUE); ?></td>
		<td><small><?php echo ($ticket['formName']) ? anchor('/admin/webforms/viewall', $ticket['formName']) : ''; ?></small></td>
		<td><?php echo ($ticket['closed']) ? '<span class="label">Closed</span>' : '<span class="label label-warning">Open</span>'; ?></td>
		<td><?php echo $ticket['fullName']; ?></td>
		<td><small><?php echo $ticket['email']; ?></small></td>
		<td class="tiny">
			<?php echo anchor('/admin/webforms/view_ticket/'.$ticket['ticketID'], 'Edit <i class="icon-edit"></i>', 'class="btn btn-info"'); ?>
		</td>
		<td class="tiny">
			<?php if (in_array('webforms_tickets', $this->permission->permissions)): ?>
				<?php echo anchor('/admin/webforms/delete_ticket/'.$ticket['ticketID'], 'Delete <i class="icon-trash"></i>', array('onclick' => 'return confirm(\'Are you sure you want to delete this?\')', 'class' => 'btn btn-danger')); ?>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->pagination->create_links(); ?>

<p style="text-align: right;"><a href="#" class="btn" id="totop">Back to top <i class="icon-circle-arrow-up"></i></a></p>

<?php else: ?>

<p class="clear">There are no tickets here yet.</p>

<?php endif; ?>

