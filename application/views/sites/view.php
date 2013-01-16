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
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Name</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">URL</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Default on Login</a></th>
					<th class="table-header-options line-left"><a href="#">Options</a></th>
				</tr>
<?php foreach ($sites AS $index => $row): ?>
				<tr class="<?php echo ($index % 2 == 1) ? 'alternate-row' : ''; ?>">
					<td><?php echo $row->name; ?></td>
					<td><?php echo $row->url; ?></td>
					<td><?php echo ($row->default == 1) ? 'Yes' : 'No'; ?></td>
					<td class="options-width">
						<?php echo anchor("sites/edit/{$row->id}", ' ', array('title' => 'Edit', 'class' => 'icon-1 info-tooltip')); ?>
						<?php if (count($sites) > 1) { echo anchor("sites/delete/{$row->id}", ' ', array('title' => 'Delete', 'class' => 'icon-2 info-tooltip', 'onclick' => 'return confirm_delete(\'site\')')); } ?>
						<?php if ($row->default != 1) { echo anchor("sites/make_default/{$row->id}", ' ', array('title' => 'Make Default', 'class' => 'icon-3 info-tooltip')); } ?>
						<?php if ($this->session->userdata('site_id') != $row->id) { echo anchor("sites/switch_site/{$row->id}", ' ', array('title' => 'Switch Site', 'class' => 'icon-5 info-tooltip')); } ?>
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
					<?php echo anchor('sites/add', 'Add Site', array('class' => 'action-edit')); ?>
					<?php //echo anchor('javascript://', 'Delete', array('class' => 'action-delete', 'onclick' => '$(\'#mainform\').submit();')); ?>
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
	
	<!--  start page-heading -->
	<div id="page-heading">
		<h1><?php echo $title2; ?></h1>
	</div>
	<!-- end page-heading -->

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
			<div id="table-content" style="min-height:150px;"	>
				<?php echo anchor('categories/view', 'View/Edit Categories'); ?><br/><br/>
				<?php echo anchor('types/view', 'View/Edit Link Types'); ?><br/><br/>
				<?php echo anchor('statuses/view', 'View/Edit Statuses'); ?>
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