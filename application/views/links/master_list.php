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

				<div style="float:right;">
					<span style="float:left; padding-right: 20px; line-height:30px; font-weight: bold;">Category:</span>
					<div style="float:right;">
					<span id="current_master_list_category" style="display:none"><?php echo $current_category_id; ?></span>
					<select id="select_master_list_category" class="styledselect_form_1">
<?php foreach ($categories AS $category_id => $category): ?>
						<option value="<?php echo $category_id; ?>"<?php if ($category_id == $current_category_id) echo ' selected="selected"'; ?>><?php echo $category; ?></option>
<?php endforeach; ?>
					</select>
					</div>
				</div>
				
				<br/><br/><br/>

				<form id="mainform" action="<?php echo base_url() . 'links/delete_multi'; ?>" method="POST">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Domain</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Name</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Email</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Category</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Type</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Price</a></th>
				</tr>
<?php foreach ($links AS $index => $row): ?>
				<tr class="<?php echo ($index % 2 == 1) ? 'alternate-row' : ''; ?>">
					<td><?php echo $row->location; ?></td>
					<td><?php echo $row->contact_name; ?></td>
					<td><?php echo $row->contact_email; ?></td>
					<td><?php echo $row->category; ?></td>
					<td><?php echo $row->type; ?></td>
					<td><?php echo ($row->price) ? "\${$row->price} ({$row->period})" : ''; ?></td>
				</tr>
<?php endforeach; ?>
				</table>
				</form>
				<!--  end product-table................................... --> 
			</div>
			<!--  end content-table  -->

			<!--  start actions-box ............................................... -->
			<!--
			<div id="actions-box">
				<a href="" class="action-slider"></a>
				<div id="actions-box-slider">
					<?php echo anchor('links/add', 'Add', array('class' => 'action-edit')); ?>
					<?php echo anchor('javascript://', 'Delete', array('class' => 'action-delete', 'onclick' => '$(\'#mainform\').submit();')); ?>
				</div>
				<div class="clear"></div>
			</div>
			!-->
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