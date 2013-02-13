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

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table" style="height: 200px !important;">
	<tr>
		<th rowspan="3" class="sized"><?php echo image_asset('shared/side_shadowleft.jpg', NULL, array('width' => 20, 'height' => 200)); ?></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><?php echo image_asset('shared/side_shadowright.jpg', NULL, array('width' => 20, 'height' => 200)); ?></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content" style="min-height: 0px !important;">	

				<!--  start product-table ..................................................................................... -->
				<script type="text/javascript">
				$(document).ready(function() {
					var sorter = new ttable('product-table'); 

					sorter.style.num = false;
					sorter.style.stripped = true;
					sorter.style.odd_row = 'alternate-row';

					sorter.sorting.sortascstyle = 'column-active-up';
					sorter.sorting.sortdescstyle = 'column-active-down';

					sorter.rendertable();
				});
				</script>

				<form id="mainform" action="<?php echo base_url() . 'profiles/delete_profile_multi'; ?>" method="POST">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<thead>
					<th class="table-header-check"></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Name</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Address</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Phone</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">URL(s)</a></th>
					<th class="table-header-options-small line-left"><a href="#">Options</a></th>
				</thead>
<?php foreach ($profiles AS $index => $row): ?>
				<tr>
					<td><input type="checkbox" name="items[<?php echo $row->id; ?>]" /></td>
					<td><?php echo $row->name; ?></td>
					<td><?php echo $row->address; ?></td>
					<td><?php echo $row->phone; ?></td>
					<td><?php echo nl2br($row->urls); ?></td>
					<td class="options-width-small">
						<?php echo anchor("profiles/edit_profile/{$row->id}", ' ', array('title' => 'Edit', 'class' => 'icon-1 info-tooltip')); ?>
						<?php echo anchor("profiles/delete_profile/{$row->id}", ' ', array('title' => 'Delete', 'class' => 'icon-2 info-tooltip', 'onclick' => 'return confirm_delete(\'profile\')')); ?>
					</td>
				</tr>
<?php endforeach; ?>
				</table>
				</form>
				<!--  end product-table................................... -->

				<br/><br/>

<?php if (count($tasks)): ?>
				<h2>Tasks</h2>
<?php endif; ?>

<?php foreach ($tasks AS $task): 
	if ($task->status == 'Pending')
		$style = 'font-style: italic';
	else if ($task->status == 'Completed')
		$style = 'text-decoration: line-through';
	else
		$style = 'none';
?>
				<div>
					<div style="float:right;">
						<h3>
							<?php echo anchor("profiles/delete_task/{$task->id}", ' ', array('title' => 'Delete', 'class' => 'icon-2 info-tooltip', 'onclick' => 'return confirm_delete(\'note\')')); ?>
							<?php if ($task->status != 'Not Started') { echo anchor("profiles/mark_not_started/{$task->id}", ' ', array('title' => 'Mark Not Started', 'class' => 'icon-3 info-tooltip')); } ?>
							<?php if ($task->status != 'Pending') { echo anchor("profiles/mark_pending/{$task->id}", ' ', array('title' => 'Mark Pending', 'class' => 'icon-1 info-tooltip')); } ?>
							<?php if ($task->status != 'Completed') { echo anchor("profiles/mark_completed/{$task->id}", ' ', array('title' => 'Mark Completed', 'class' => 'icon-5 info-tooltip')); } ?>
						<h3>
					</div>
					<h3 style="<?php echo $style; ?>"><?php echo anchor("profiles/edit_task/{$task->id}", date('l, F jS, Y', strtotime($task->due_date))); ?></h3>

					<span style="<?php echo $style; ?>"><?php echo nl2br($task->note); ?></span>
				</div>
				<br/><br/>
<?php endforeach; ?>

				<br/>

<?php if (count($notes)): ?>
				<h2>Notes</h2>
<?php endif; ?>

<?php foreach ($notes AS $note): ?>
				<div>
					<div style="float:right;"><h3><?php echo anchor("profiles/delete_note/{$note->id}", ' ', array('title' => 'Delete', 'class' => 'icon-2 info-tooltip', 'onclick' => 'return confirm_delete(\'note\')')); ?><h3></div>
					<h3><?php echo anchor("profiles/edit_note/{$note->id}", date('l, F jS, Y', strtotime($note->date))); ?></h3>

					<?php echo nl2br($note->note); ?>
				</div>
				<br/><br/>
<?php endforeach; ?>
			</div>
			<!--  end content-table  -->
			
			<!--  start actions-box ............................................... -->
			<div id="actions-box">
				<a href="" class="action-slider"></a>
				<div id="actions-box-slider">
					<?php echo anchor("profiles/add_profile", 'Add Profile', array('class' => 'action-edit')); ?>
					<?php echo anchor('javascript://', 'Delete Pro.', array('class' => 'action-delete', 'onclick' => '$(\'#mainform\').submit();')); ?>
					<?php echo anchor("profiles/add_task", 'Add Task', array('class' => 'action-edit')); ?>
					<?php echo anchor("profiles/add_note", 'Add Note', array('class' => 'action-edit')); ?>
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
	<div class="clear">&nbsp;</div>