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

				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<thead>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Field</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="#">Data</a></th>
				</thead>
				<tr>
					<td class="alternate-row">Name</td>
					<td class="alternate-row"><?php echo $profile->name; ?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td><?php echo $profile->address; ?></td>
				</tr>
				<tr>
					<td class="alternate-row">Phone</td>
					<td class="alternate-row"><?php echo $profile->phone; ?></td>
				</tr>
				<tr>
					<td>URL(s)</td>
					<td><?php echo nl2br($profile->urls); ?></td>
				</tr>
				</table>
				
			<div>

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
<?php foreach ($notes AS $note): ?>
				<div>
					<div style="float:right;"><h3><?php echo anchor("profiles/delete_note/{$profile->id}/{$note->id}", ' ', array('title' => 'Delete', 'class' => 'icon-2 info-tooltip', 'onclick' => 'return confirm_delete(\'note\')')); ?><h3></div>
					<h3><?php echo anchor("profiles/edit_note/{$note->id}", date('l, F jS, Y', strtotime($note->date))); ?></h3>
					<!--<h3>Local Heading</h3>!-->

					<?php echo nl2br($note->note); ?>
				</div>
				<br/><br/>
<?php endforeach; ?>
			</div>
			<!--  end table-content  -->
			
			<!--  start actions-box ............................................... -->
			<div id="actions-box">
				<a href="" class="action-slider"></a>
				<div id="actions-box-slider">
					<?php echo anchor("profiles/add_note/{$profile->id}", 'Add Note', array('class' => 'action-edit')); ?>
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

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>