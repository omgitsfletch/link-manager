<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo $title; ?></title>
	<script type="text/javascript">
		// Set variable for use in JS redirects for dropdowns, etc.
		var base_url = '<?php echo base_url(); ?>';
	</script>
	<?php
	echo css_asset('screen.css', NULL, array('media' => 'screen', 'title' => 'default')) . "\n";
	echo css_asset('datePicker.css') . "\n";

	echo js_asset('jquery/jquery-1.4.1.min.js') . "\n";
	echo js_asset('jquery/ui.core.js') . "\n";
	echo js_asset('jquery/ui.checkbox.js') . "\n";
	echo js_asset('jquery/jquery.bind.js') . "\n";
	echo js_asset('jquery/custom_jquery.js') . "\n";
	echo js_asset('jquery/jquery.tooltip.js') . "\n";
	echo js_asset('jquery/jquery.dimensions.js') . "\n";
	echo js_asset('jquery/jquery.filestyle.js') . "\n";
	echo js_asset('jquery/jquery.selectbox-0.5_style_2.js') . "\n";
	echo js_asset('jquery/date.js') . "\n";
	echo js_asset('jquery/jquery.datePicker.js') . "\n";
	?>
	<script type="text/javascript">
	$(function(){
		$('input').checkBox();
		$('#toggle-all').click(function(){
		$('#toggle-all').toggleClass('toggle-checked');
		$('#mainform input[type=checkbox]').checkBox('toggle');
		return false;
		});
	});
	</script>  

	<![if !IE 7]>
	<!--  styled select box script version 1 -->
	<?php echo js_asset('jquery/jquery.selectbox-0.5.js') . "\n"; ?>
	<script type="text/javascript">
	$(document).ready(function() {
		$('.styledselect').selectbox({ inputClass: "selectbox_styled" });
	});
	</script>
	<![endif]>

	<!--  styled select box script version 2 --> 
	<script type="text/javascript">
	$(document).ready(function() {
		$('.styledselect_form_1').selectbox({ inputClass: "styledselect_form_1" });
		$('.styledselect_form_2').selectbox({ inputClass: "styledselect_form_2" });
	});
	</script>

	<!--  styled select box script version 3 --> 
	<script type="text/javascript">
	$(document).ready(function() {
		$('.styledselect_pages').selectbox({ inputClass: "styledselect_pages" });
	});
	</script>

	<!--  styled file upload script --> 
	<script type="text/javascript" charset="utf-8">
	$(function() {
		$("input.file_1").filestyle({ 
			image: "images/forms/choose-file.gif",
			imageheight : 21,
			imagewidth : 78,
			width : 310
		});
	});
	</script>

	<!-- Tooltips -->
	<script type="text/javascript">
	$(function() {
		$('a.info-tooltip ').tooltip({
			track: true,
			delay: 0,
			fixPNG: true, 
			showURL: false,
			showBody: " - ",
			top: -35,
			left: 5
		});
	});
	</script> 

	<!--  date picker script -->
	<script type="text/javascript" charset="utf-8">
	$(function() {
		$('.date-pick')
			.datePicker(
				{
					createButton:false,
					startDate:'01/01/2000'
				}
			).bind(
				'click',
				function() {
					$(this).dpDisplay();
					return false;
				}
			).bind(
				'dateSelected',
				function(e, selectedDate, $td, state) { updateDate(selectedDate, e.target.id); }
			).bind(
				'dpClosed',
				function(e, selected) { updateDate(selected[0]); }
			);
			
		var updateDate = function (selectedDate, input_id) {
			var selectedDate = new Date(selectedDate);

			var dateString = selectedDate.getFullYear() + '-' + ('0' + (selectedDate.getMonth()+1)).slice(-2) + '-' + ('0' + selectedDate.getDate()).slice(-2);
			$('input[name="'+input_id+'"]').val(dateString);
		}
	});
	</script>

	<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
	<?php echo js_asset('jquery/jquery.pngFix.pack.js'); ?></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$(document).pngFix( );
	});
	</script>
</head>

<body>
	<!-- Start: page-top-outer -->
	<div id="page-top-outer">    

	<!-- Start: page-top -->
	<div id="page-top">

		<!-- start logo -->
		<div id="logo">
			<a href=""><?php echo image_asset('shared/logo.gif', NULL, array('width' => 130, 'height' => 40)); ?></a>
		</div>
		<!-- end logo -->

		<!--  start top-search -->
		<div id="top-search" style="font-size:12px; font-weight:bold;">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr><td>Group:</td><td><?php echo $groups_dropdown; ?></td></tr>
				<tr><td>Website:&nbsp;&nbsp;&nbsp;</td><td><?php echo $sites_dropdown; ?></td></tr>
			</table>
		</div>
		<!--  end top-search -->
		<div class="clear"></div>

	</div>
	<!-- End: page-top -->

	</div>
	<!-- End: page-top-outer -->
		
	<div class="clear">&nbsp;</div>
	
	<!--  start nav-outer-repeat................................................................................................. START -->
	<div class="nav-outer-repeat"> 
	<!--  start nav-outer -->
	<div class="nav-outer"> 

			<!-- start nav-right -->
			<div id="nav-right">

				<!--
				<div class="nav-divider">&nbsp;</div>
				<div class="showhide-account"><?php echo image_asset('shared/nav/nav_myaccount.gif', NULL, array('width' => 93, 'height' => 14)); ?></div>
				!-->
				<div class="nav-divider">&nbsp;</div>
				<?php echo anchor('logout', image_asset('shared/nav/nav_logout.gif', NULL, array('width' => 64, 'height' => 14)), array('id' => 'logout')); ?>
				<div class="clear">&nbsp;</div>
			
				<!--  start account-content -->	
				<div class="account-content">
				<div class="account-drop-inner">
					<a href="" id="acc-settings">Settings</a>
					<div class="clear">&nbsp;</div>
					<div class="acc-line">&nbsp;</div>
					<a href="" id="acc-details">Personal details </a>
					<div class="clear">&nbsp;</div>
					<div class="acc-line">&nbsp;</div>
					<a href="" id="acc-project">Project details</a>
					<div class="clear">&nbsp;</div>
					<div class="acc-line">&nbsp;</div>
					<a href="" id="acc-inbox">Inbox</a>
					<div class="clear">&nbsp;</div>
					<div class="acc-line">&nbsp;</div>
					<a href="" id="acc-stats">Statistics</a> 
				</div>
				</div>
				<!--  end account-content -->
			
			</div>
			<!-- end nav-right -->


			<!--  start nav -->
			<div class="nav">
			<div class="table">
			<ul class="<?php echo ($this->uri->segment(1) == 'sites' || $this->uri->segment(1) == 'groups') ? 'current' : 'select'; ?>"><li><?php echo anchor('sites/view', '<b>Dashboard</b>'); ?>
			<div class="<?php echo ($this->uri->segment(1) == 'sites' || $this->uri->segment(1) == 'groups') ? 'select_sub show' : 'select_sub'; ?>">
				<ul class="sub">
					<li class="<?php echo ($this->uri->segment(1) == 'sites' && $this->uri->segment(2) == 'view') ? 'sub_show' : ''; ?>"><?php echo anchor('sites/view', 'View Sites'); ?></li>
					<li class="<?php echo ($this->uri->segment(1) == 'sites' && $this->uri->segment(2) == 'add') ? 'sub_show' : ''; ?>"><?php echo anchor('sites/add', 'Add Site'); ?></li>
					<li class="<?php echo ($this->uri->segment(1) == 'groups' && $this->uri->segment(2) == 'view') ? 'sub_show' : ''; ?>"><?php echo anchor('groups/view', 'View Groups'); ?></li>
				</ul>
			</div>
			</li>
			</ul>
			
			<div class="nav-divider">&nbsp;</div>
								
			<ul class="<?php echo ($this->uri->segment(1) == 'links') ? 'current' : 'select'; ?>"><li><?php echo anchor('links/view', '<b>Links</b>'); ?>
			<!--[if lte IE 6]><table><tr><td><![endif]-->
			<div class="<?php echo ($this->uri->segment(1) == 'links') ? 'select_sub show' : 'select_sub'; ?>">
				<ul class="sub">
					<li class="<?php echo ($this->uri->segment(2) == 'view') ? 'sub_show' : ''; ?>"><?php echo anchor('links/view', 'View Links'); ?></li>
					<li class="<?php echo ($this->uri->segment(2) == 'add') ? 'sub_show' : ''; ?>"><?php echo anchor('links/add', 'Add Link'); ?></li>
					<li class="<?php echo ($this->uri->segment(2) == 'master_list') ? 'sub_show' : ''; ?>"><?php echo anchor('links/master_list', 'Master List'); ?></li>
				</ul>
			</div>
			<!--[if lte IE 6]></td></tr></table></a><![endif]-->
			</li>
			</ul>
			
			<div class="nav-divider">&nbsp;</div>
			
			<ul class="<?php echo ($this->uri->segment(1) == 'goals') ? 'current' : 'select'; ?>"><li><?php echo anchor(current_url(), '<b>Goals</b>'); ?>
			<!--[if lte IE 6]><table><tr><td><![endif]-->
			<div class="<?php echo ($this->uri->segment(1) == 'goals') ? 'select_sub show' : 'select_sub'; ?>">
				<ul class="sub">
				</ul>
			</div>
			<!--[if lte IE 6]></td></tr></table></a><![endif]-->
			</li>
			</ul>
			
			<div class="nav-divider">&nbsp;</div>

			<ul class="<?php echo ($this->uri->segment(1) == 'reports') ? 'current' : 'select'; ?>"><li><?php echo anchor('reports/generate', '<b>Reports</b>'); ?>
			<!--[if lte IE 6]><table><tr><td><![endif]-->
			<div class="<?php echo ($this->uri->segment(1) == 'reports') ? 'select_sub show' : 'select_sub'; ?>">
				<ul class="sub">
				</ul>
			</div>
			<!--[if lte IE 6]></td></tr></table></a><![endif]-->
			</li>
			</ul>
			
			<div class="nav-divider">&nbsp;</div>
			
			<ul class="<?php echo ($this->uri->segment(1) == 'link_monitor') ? 'current' : 'select'; ?>"><li><?php echo anchor(current_url(), '<b>Link Monitoring</b>'); ?>
			<!--[if lte IE 6]><table><tr><td><![endif]-->
			<div class="<?php echo ($this->uri->segment(1) == 'link_monitor') ? 'select_sub show' : 'select_sub'; ?>">
				<ul class="sub">
				</ul>
			</div>
			<!--[if lte IE 6]></td></tr></table></a><![endif]-->
			</li>
			</ul>
			
			<div class="nav-divider">&nbsp;</div>
			
			<ul class="<?php echo ($this->uri->segment(1) == 'content') ? 'current' : 'select'; ?>"><li><?php echo anchor(current_url(), '<b>Content</b>'); ?>
			<!--[if lte IE 6]><table><tr><td><![endif]-->
			<div class="<?php echo ($this->uri->segment(1) == 'content') ? 'select_sub show' : 'select_sub'; ?>">
				<ul class="sub">
				</ul>
			</div>
			<!--[if lte IE 6]></td></tr></table></a><![endif]-->
			</li>
			</ul>
			
			<div class="clear"></div>
			</div>
			<div class="clear"></div>
			</div>
			<!--  start nav -->

	</div>
	<div class="clear"></div>
	<!--  start nav-outer -->
	</div>
	<!--  start nav-outer-repeat................................................... END -->

	 <div class="clear"></div>