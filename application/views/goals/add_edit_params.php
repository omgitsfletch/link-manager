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
				<th valign="top">Links Needed:</th>
				<td><input name="links_needed" type="text" value="<?php echo set_value('links_needed', (isset($params->links_needed) ? $params->links_needed : '')); ?>" class="<?php echo (form_error('links_needed')) ? 'inp-form-error' : 'inp-form'; ?>" /></td>
				<td><?php echo form_error('links_needed'); ?></td>
			</tr>
			<tr>
				<th valign="top">Due Date:</th>
				<td>	
					<select name="due_date" class="styledselect_form_1">
<?php
	echo "<option value=\"\">** Select a due date! **</option>";
	for ($i = 1; $i <= 31; $i++) {
		$selected = ( (isset($params->day_of_month)) && ($params->day_of_month == $i) ) ? 'selected="selected"' : '';
		echo "<option value=\"{$i}\" {$selected}>$i</option>";
	}
?>
					</select>
				</td>
				<td><?php echo form_error('due_date'); ?></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td valign="top">
					<input type="submit" value="" class="form-submit" />
					<input type="reset" value="" class="form-reset"  />
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