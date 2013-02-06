<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

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

<?php if ($this->session->flashdata('message_success')): ?>
				<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left"><?php echo $this->session->flashdata('message_success'); ?></td>
					<td class="green-right"><?php echo anchor('javascript://', image_asset('table/icon_close_green.gif'), array('class' => 'close-green', 'onclick' => '$(#message-green).fade(600).remove()')); ?></a></td>
				</tr>
				</table>
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
				</div>
<?php endif; ?>

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
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Location</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Last Checked</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Status</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Nofollowed?</a></th>
				</thead>
<?php foreach ($links AS $index => $row): ?>
				<tr>
					<td><?php echo $row->url; ?></td>
					<td><?php echo $row->text; ?></td>
					<td><?php echo $row->location; ?></td>
					<td><?php echo ($row->date) ? $row->date : '--'; ?></td>
					<td><?php echo ($row->status) ? $row->status : '--'; ?></td>
					<td><?php echo ($row->status == 'Found') ? (($row->nofollow == 1) ? 'X' : '') : '--'; ?></td>
				</tr>
<?php endforeach; ?>
				</table>
				<!--  end product-table................................... --> 
			</div>
			<!--  end content-table  -->
			
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
	<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>