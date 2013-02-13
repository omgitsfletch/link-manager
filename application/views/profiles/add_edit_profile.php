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
		
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr valign="top">
		<td>

			<!--  start step-holder -->
			<div id="step-holder">
				<div class="step-no">1</div>
				<div class="step-dark-left"><?php echo $title; ?></div>
				<div class="step-dark-round">&nbsp;</div>
				<div class="clear"></div>
			</div>
			<!--  end step-holder -->

			<!-- start id-form -->
			<form action="<?php echo current_url(); ?>" method="POST">
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
			<tr>
				<th valign="top">Client Name:</th>
				<td><input name="name" type="text" value="<?php echo set_value('location', (isset($profile->name) ? $profile->name : '')); ?>" class="<?php echo (form_error('name')) ? 'inp-form-error' : 'inp-form'; ?>" /></td>
				<td><?php echo form_error('name'); ?></td>
			</tr>
			<tr>
				<th valign="top">Client Address:</th>
				<td><input name="address" type="text" value="<?php echo set_value('location', (isset($profile->address) ? $profile->address : '')); ?>" class="<?php echo (form_error('address')) ? 'inp-form-error' : 'inp-form'; ?>" /></td>
				<td><?php echo form_error('address'); ?></td>
			</tr>
			<tr>
				<th valign="top">Client Phone:</th>
				<td><input name="phone" type="text" value="<?php echo set_value('location', (isset($profile->phone) ? $profile->phone : '')); ?>" class="<?php echo (form_error('phone')) ? 'inp-form-error' : 'inp-form'; ?>" /></td>
				<td><?php echo form_error('phone'); ?></td>
			</tr>
			<tr>
				<th valign="top">URL(s):</th>
				<td><textarea name="urls" rows="" class="<?php echo (form_error('urls')) ? 'form-textarea-error' : 'form-textarea'; ?>" style="width:250px;"><?php echo set_value('urls', (isset($profile->urls) ? $profile->urls : '')); ?></textarea></td>
				<td><?php echo form_error('urls'); ?></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td valign="top">
					<input type="submit" value="" class="form-submit" />
					<?php if (!isset($link)) echo "<input type=\"reset\" value=\"\" class=\"form-reset\"  />"; ?>
				</td>
				<td></td>
			</tr>
			</table>
			</form>
			<!-- end id-form  -->

		</td>
		</tr>
		<tr>
		<td><img src="images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
		<td></td>
		</tr>
		</table>

		<div class="clear"></div>


		</div>
		<!--  end content-table-inner  -->
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
<!--  end content-outer -->

<div class="clear">&nbsp;</div>