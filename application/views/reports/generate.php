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
<script type=�text/javascript� language=�javascript�>
	$(window).load(function(){
		$('#start_date').datepicker({
			beforeShow: function(){
				$(this).datepicker('option', 'maxDate', $('#end_date').val() );
			}
		});
		$('#end_date').datepicker({
			beforeShow: function(){
				$(this).datepicker('option','minDate', $('#start_date').val() );
			}
		});
	})
</script>
			<form action="<?php echo current_url(); ?>" method="POST">
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
			<tr>
				<th valign="top">Start Date:</th>
				<td>
					<input name="start_date" type="text" value="<?php echo set_value('start_date', date('Y-m-d', strtotime('today - 30 days'))); ?>" class="<?php echo (form_error('start_date')) ? 'inp-form-error' : 'inp-form'; ?>" />
					<?php echo anchor('', image_asset('forms/icon_calendar.jpg'), array('id' => 'start_date', 'class' => 'date-pick')); ?>
					<script type="text/javascript">
					$(document).ready(function() {
						var d = new Date(
							$('input[name="start_date"]').val().substr(0,4),
							$('input[name="start_date"]').val().substr(5,2)-1,
							$('input[name="start_date"]').val().substr(8,2)
						);
						$('#start_date').dpSetSelected(d.asString());
					});
					</script>
				</td>
				<td><?php echo form_error('start_date'); ?></td>
			</tr>
			<tr>
				<th valign="top">End Date:</th>
				<td>
					<input name="end_date" type="text" value="<?php echo set_value('end_date', date('Y-m-d')); ?>" class="<?php echo (form_error('end_date')) ? 'inp-form-error' : 'inp-form'; ?>" />
					<?php echo anchor('', image_asset('forms/icon_calendar.jpg'), array('id' => 'end_date', 'class' => 'date-pick')); ?>
					<script type="text/javascript">
					$(document).ready(function() {
						var d = new Date(
							$('input[name="end_date"]').val().substr(0,4),
							$('input[name="end_date"]').val().substr(5,2)-1,
							$('input[name="end_date"]').val().substr(8,2)
						);
						$('#end_date').dpSetSelected(d.asString());
					});
					</script>
				</td>
				<td><?php echo form_error('end_date'); ?></td>
			</tr>
			<tr>
				<th valign="top">Report Summary:</th>
				<td><textarea name="summary" rows="20" style="width:700px;"><?php echo set_value('summary'); ?></textarea></td>
				<td><?php echo form_error('summary'); ?></td>
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