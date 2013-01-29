<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

<?php if ($this->session->flashdata('message_success')): ?>
				<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left"><?php echo $this->session->flashdata('message_success'); ?></td>
					<td class="green-right"><?php echo anchor('javascript://', image_asset('table/icon_close_green.gif'), array('class' => 'close-green', 'onclick' => '$(#message-green).fade(600).remove()')); ?></a></td>
				</tr>
				</table>
				<br/>
				</div>
<?php endif; ?>
<?php if ($this->session->flashdata('message_failure')): ?>
				<div id="message-red">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="red-left"><?php echo $this->session->flashdata('message_failure'); ?></td>
					<td class="red-right"><?php echo anchor('javascript://', image_asset('table/icon_close_red.gif'), array('class' => 'close-red', 'onclick' => '$(#message-red).fade(600).remove()')); ?></a></td>
				</tr>
				</table>
				<br/>
				</div>
<?php endif; ?>
<?php if ($this->session->flashdata('message_notification')): ?>
				<div id="message-yellow">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="yellow-left"><?php echo $this->session->flashdata('message_notification'); ?></td>
					<td class="yellow-right"><?php echo anchor('javascript://', image_asset('table/icon_close_yellow.gif'), array('class' => 'close-yellow', 'onclick' => '$(#message-yellow).fade(600).remove()')); ?></a></td>
				</tr>
				</table>
				<br/>
				</div>
<?php endif; ?>

	<!--  start page-heading -->
	<div id="page-heading">
		<h1><?php echo $title; ?></h1>
	</div>
	<!-- end page-heading -->

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><?php echo image_asset('shared/side_shadowleft.jpg', NULL, array('width' => 20, 'height' => 300)); ?></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><?php echo image_asset('shared/side_shadowright.jpg', NULL, array('width' => 20, 'height' => 300)); ?></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">	

				<h2>Due Date: <?php echo $print_due_date; ?></h2>
<script type="text/javascript">
$(document).ready(function(){
	var cosPoints = []; 
	cosPoints.push([1, 1]);
	cosPoints.push([4, 2]); 
	cosPoints.push([6, 3]); 
	cosPoints.push([19, 5]);
	
	var plot2 = $.jqplot('chart2', [cosPoints], {  
		series:[{showMarker:false}],
		axes:{
			xaxis:{
				label:'Date',
				labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
				showTicks: false
			},
			yaxis:{
				rendererOptions: { forceTickAt0: true, forceTickAt100: true },
				label:'Links',
				labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
				min: 0,
				max: 20
			}
		},
		canvasOverlay: {
			show: true,
			objects: [
				{dashedHorizontalLine: {
					name: 'bam-bam',
					y: 15,
					lineWidth: 4,
					dashPattern: [8, 16],
					lineCap: 'round',
					xOffset: 0,
					color: 'rgb(66, 98, 144)',
					shadow: false
				}}
			]
		}
	});
});
</script>
<div id="chart2" style="width:80%;margin-left:10%;"></div></div>
			<div>

			<!--  start actions-box ............................................... -->
			<div id="actions-box">
				<a href="" class="action-slider"></a>
				<div id="actions-box-slider">
					<?php echo anchor("goals/due_date/{$this->session->userdata('site_id')}", 'Edit Date', array('class' => 'action-edit')); ?>
				</div>
				<div class="clear"></div>
			</div>
			<!-- end actions-box........... -->
			
			<div class="clear"></div>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
	<div class="clear">&nbsp;</div><br/>

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><?php echo image_asset('shared/side_shadowleft.jpg', NULL, array('width' => 20, 'height' => 150)); ?></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><?php echo image_asset('shared/side_shadowright.jpg', NULL, array('width' => 20, 'height' => 150)); ?></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">	

				<!--  start product-table ..................................................................................... -->
				<script type="text/javascript">
				$(document).ready(function() {
					var sorter = new ttable('product-table'); 
					sorter.search.enabled = true;
					sorter.search.inputID = 'searchinput';
					sorter.search.casesensitive = false;

					sorter.style.num = false;
					sorter.style.stripped = true;
					sorter.style.odd_row = 'alternate-row';

					sorter.sorting.sortascstyle = 'column-active-up';
					sorter.sorting.sortdescstyle = 'column-active-down';

					sorter.rendertable();
				});
				</script>
				
				<div style="float:right;">
					<b>Filter:</b>&nbsp;&nbsp;&nbsp;<input id="searchinput" class="inp-form"/>
				</div>
				
				<br/><br/><br/>

				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<thead>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">URL</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Text</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Status</a></th>
					<th class="table-header-options line-left"><a href="#">Options</a></th>
				</thead>
<?php foreach ($needed_links AS $index => $row): ?>
				<tr class="<?php echo ($row->status == 'Requested') ? 'inactive' : ''; ?>">
					<td><?php echo $row->url; ?></td>
					<td><?php echo $row->text; ?></td>
					<td><?php echo $row->status; ?></td>
					<td class="options-width">
						<?php if ($row->status == 'Needed') { echo anchor("goals/mark_link_requested/{$row->id}", ' ', array('title' => 'Mark Requested', 'class' => 'icon-3 info-tooltip')); } ?>
						<?php if ($row->status == 'Requested') { echo anchor("goals/mark_link_needed/{$row->id}", ' ', array('title' => 'Mark Needed', 'class' => 'icon-1 info-tooltip')); } ?>
						<?php echo anchor("goals/mark_link_active/{$row->id}", ' ', array('title' => 'Mark Active', 'class' => 'icon-5 info-tooltip', 'onclick' => 'return confirm_delete(\'mark_link_active\')')); ?>

					</td>
				</tr>
<?php endforeach; ?>
				</table>
				<!--  end product-table................................... --> 
			</div>
			<!--  end content-table  -->
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
	<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>