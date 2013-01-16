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
				<th valign="top">Link Location:</th>
				<td><input name="location" type="text" value="<?php echo set_value('location', (isset($link->location) ? $link->location : '')); ?>" class="<?php echo (form_error('location')) ? 'inp-form-error' : 'inp-form'; ?>" /></td>
				<td><?php echo form_error('location'); ?></td>
				<th valign="top">Contact E-mail:</th>
				<td><input name="contact_email" type="text" value="<?php echo set_value('contact_email', (isset($link->contact_email) ? $link->contact_email : '')); ?>" class="<?php echo (form_error('contact_email')) ? 'inp-form-error' : 'inp-form'; ?>" /></td>
				<td><?php echo form_error('contact_email'); ?></td>
			</tr>
			<tr>
				<th valign="top">Anchor Text:</th>
				<td><input name="text" type="text" value="<?php echo set_value('text', (isset($link->text) ? $link->text : '')); ?>" class="<?php echo (form_error('text')) ? 'inp-form-error' : 'inp-form'; ?>" /></td>
				<td><?php echo form_error('text'); ?></td>
				<th valign="top">Contact Name:</th>
				<td><input name="contact_name" type="text" value="<?php echo set_value('contact_name', (isset($link->contact_name) ? $link->contact_name : '')); ?>" class="<?php echo (form_error('contact_name')) ? 'inp-form-error' : 'inp-form'; ?>" /></td>
				<td><?php echo form_error('contact_name'); ?></td>
			</tr>
			<tr>
				<th valign="top">URL:</th>
				<td><input name="url" type="text" value="<?php echo set_value('url', (isset($link->url) ? $link->url : $this->session->userdata('site_url'))); ?>" class="<?php echo (form_error('url')) ? 'inp-form-error' : 'inp-form'; ?>" /></td>
				<td><?php echo form_error('url'); ?></td>
				<th valign="top">Category:</th>
				<td>	
					<select name="category_id" class="styledselect_form_1">
<?php
	if (is_array($categories) && count($categories) > 0) {
		echo "<option value=\"\">** Select a category! **</option>";
		foreach ($categories AS $category) {
			$selected = ( (isset($link->category_id)) && ($link->category_id == $category->category_id) ) ? 'selected="selected"' : '';
			echo "<option value=\"{$category->category_id}\" {$selected}>{$category->category}</option>";
		}
	} else {
		echo '<option value="">** No categories found! **</option>';
	}
?>
					</select>
				</td>
				<td><?php echo form_error('category_id'); ?></td>
			</tr>
			<tr>
				<th valign="top">Date:</th>
				<td>
					<input name="date" type="text" value="<?php echo set_value('date', (isset($link->date) ? $link->date : date('Y-m-d'))); ?>" class="<?php echo (form_error('date')) ? 'inp-form-error' : 'inp-form'; ?>" />
					<?php echo anchor('', image_asset('forms/icon_calendar.jpg'), array('id' => 'date', 'class' => 'date-pick')); ?>
					<script type="text/javascript">
					$(document).ready(function() {
						var d = new Date(
							$('input[name="date"]').val().substr(0,4),
							$('input[name="date"]').val().substr(5,2)-1,
							$('input[name="date"]').val().substr(8,2)
						);
						$('#date-pick').dpSetSelected(d.asString());
					});
					</script>
				</td>
				<td><?php echo form_error('date'); ?></td>
			</tr>
			<tr>
				<th valign="top">Status:</th>
				<td>	
					<select name="status_id" class="styledselect_form_1">
<?php
	if (is_array($statuses) && count($statuses) > 0) {
		echo "<option value=\"\">** Select a status! **</option>";
		foreach ($statuses AS $status) {
			$selected = ( (isset($link->status_id)) && ($link->status_id == $status->status_id) ) ? 'selected="selected"' : '';
			echo "<option value=\"{$status->status_id}\" {$selected}>{$status->status}</option>";
		}
	} else {
		echo '<option value="">** No statuses found! **</option>';
	}
?>
					</select>
				</td>
				<td><?php echo form_error('status_id'); ?></td>
			</tr>
			<tr>
				<th valign="top">Type:</th>
				<td>	
					<select name="type_id" class="styledselect_form_1">
<?php
	if (is_array($types) && count($types) > 0) {
		echo "<option value=\"\">** Select a type! **</option>";
		foreach ($types AS $type) {
			$selected = ( (isset($link->type_id)) && ($link->type_id == $type->type_id) ) ? 'selected="selected"' : '';
			echo "<option value=\"{$type->type_id}\" {$selected}>{$type->type}</option>";
		}
	} else {
		echo '<option value="">** No types found! **</option>';
	}
?>
					</select>
				</td>
				<td><?php echo form_error('type_id'); ?></td>
			</tr>
			<tr>
				<th valign="top">Notes:</th>
				<td><textarea name="notes" rows="" class="<?php echo (form_error('notes')) ? 'form-textarea-error' : 'form-textarea'; ?>" style="width:250px;"><?php echo set_value('notes', (isset($link->notes) ? $link->notes : '')); ?></textarea></td>
				<td><?php echo form_error('notes'); ?></td>
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