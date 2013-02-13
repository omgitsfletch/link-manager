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

				<form id="mainform" action="<?php echo base_url() . 'links/delete_multi'; ?>" method="POST">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<thead>
					<th class="table-header-check"><a id="toggle-all" ></a> </th>
					<th class="table-header-repeat line-left minwidth-1" style="width:85px;"><a href="#">Date</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">URL</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Text</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Location</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Type</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Status</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Category</a></th>
					<th class="table-header-options line-left"><a href="#">Options</a></th>
				</thead>
<?php foreach ($links AS $index => $row): ?>
				<tr>
					<td><input type="checkbox" name="items[<?php echo $row->id; ?>]" /></td>
					<td><?php echo anchor_popup("links/view_details/{$row->id}", date('m-d-Y', strtotime($row->date)), $view_details_attribs); ?></td>
					<td><?php echo $row->url; ?></td>
					<td><?php echo $row->text; ?></td>
					<td><?php echo $row->location; ?></td>
					<td><?php echo $row->type; ?></td>
					<td><?php echo $row->status; ?></td>
					<td><?php echo $row->category; ?></td>
					<td class="options-width">
						<?php echo anchor("links/edit/{$row->id}", ' ', array('title' => 'Edit', 'class' => 'icon-1 info-tooltip')); ?>
						<?php echo anchor("links/delete/{$row->id}", ' ', array('title' => 'Delete', 'class' => 'icon-2 info-tooltip', 'onclick' => 'return confirm_delete(\'link\')')); ?>
						<?php echo anchor_popup("links/view_details/{$row->id}", ' ', array_merge($view_details_attribs, array('title' => 'View Details', 'class' => 'icon-3 info-tooltip'))); ?>
						<?php echo anchor("links/add/{$row->id}", ' ', array('title' => 'Copy', 'class' => 'icon-5 info-tooltip')); ?>

					</td>
				</tr>
<?php endforeach; ?>
				</table>
				</form>
				<!--  end product-table................................... --> 
			</div>
			<!--  end content-table  -->

			<!--  start actions-box ............................................... -->
			<div id="actions-box">
				<a href="" class="action-slider"></a>
				<div id="actions-box-slider">
					<?php echo anchor('links/add', 'Add', array('class' => 'action-edit')); ?>
					<?php echo anchor('javascript://', 'Delete', array('class' => 'action-delete', 'onclick' => '$(\'#mainform\').submit();')); ?>
				</div>
				<div class="clear"></div>
			</div>
			<!-- end actions-box........... -->
			
			<!--  start paging..................................................... -->
			<!--
			<table border="0" cellpadding="0" cellspacing="0" id="paging-table">
			<tr>
			<td>
				<a href="" class="page-far-left"></a>
				<a href="" class="page-left"></a>
				<div id="page-info">Page <strong>1</strong> / 15</div>
				<a href="" class="page-right"></a>
				<a href="" class="page-far-right"></a>
			</td>
			<td>
			<select  class="styledselect_pages">
				<option value="">Number of rows</option>
				<option value="">1</option>
				<option value="">2</option>
				<option value="">3</option>
			</select>
			</td>
			</tr>
			</table>
			!-->
			<!--  end paging................ -->
			
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