<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $page_title;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link href="<?php echo base_url();?>assets/writer_css/style.css" rel="stylesheet" type="text/css">
<!-- Le styles -->
<link href="<?php echo base_url();?>assets/writer_css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/writer_css/bootstrap-responsive.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="<?php echo base_url();?>assets/imgage/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url();?>assets/imgage/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url();?>assets/imgage/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url();?>assets/imgage/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>assets/imgage/ico/apple-touch-icon-57-precomposed.png">
<script type='text/javascript' src="<?php echo base_url();?>assets/scripts/jquery-1.7.1.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/bootstrap.js"></script>
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
				<?php echo anchor('writer/logout', image_asset('shared/nav/nav_logout.gif', NULL, array('width' => 64, 'height' => 14)), array('id' => 'logout')); ?>
				<div class="clear">&nbsp;</div>
			</div>
			
			<div id="nav-right">
				<div class="nav-divider">&nbsp;</div>
				<div class="nav">
					<ul class="<?php echo ($this->uri->segment(1) == 'writer' && $this->uri->segment(2) == 'profile') ? 'current' : 'select'; ?>">
						<li>
							<a href="<?php echo base_url();?>writer/profile" id="profile"><b><?php echo $this->session->userdata('username');?></b></a>
							<?php //echo anchor('writer/profile',$this->session->userdata('username'),array('id' => 'profile')); ?>
						</li>
					</ul>
				</div>
				<div class="clear">&nbsp;</div>
			</div>
			<!-- end nav-right -->

			<!--  start nav -->
			<div class="nav">
			<div class="table">
			<ul class="<?php echo ($this->uri->segment(1) == 'writer' && $this->uri->segment(2) == 'dashboard') ? 'current' : 'select'; ?>"><li><?php echo anchor('writer/dashboard', '<b>Dashboard</b>'); ?></li>
			</ul>
			<div class="nav-divider">&nbsp;</div>
		<!-- ---------------------------------------------------------Edited by CEDCOSS-------------------------------------------------------------------- -->
			<ul class="<?php echo ($this->uri->segment(1) == 'writer' && ($this->uri->segment(2) == 'articles' || $this->uri->segment(2) == 'submitted' || $this->uri->segment(2) == 'declined')) ? 'current' : 'select'; ?>"><li><?php echo anchor('writer/articles', '<b>Content</b>'); ?>
			<!--[if lte IE 6]><table><tr><td><![endif]-->
			<div class="<?php if($this->uri->segment(1) == 'writer' && ($this->uri->segment(2) == 'articles' || $this->uri->segment(2) == 'submitted' || $this->uri->segment(2) == 'declined')){ echo 'select_sub show'; }else{ echo 'select_sub';} ?>">
				<ul class="sub">
					<li class="<?php echo ($this->uri->segment(2) == 'articles') ? 'sub_show' : ''; ?>"><?php echo anchor('writer/articles', 'Articles'); ?></li>
					<li class="<?php echo ($this->uri->segment(2) == 'submitted') ? 'sub_show' : ''; ?>"><?php echo anchor('writer/submitted', 'Submitted'); ?></li>
					<li class="<?php echo ($this->uri->segment(2) == 'declined') ? 'sub_show' : ''; ?>"><?php echo anchor('writer/declined', 'Rejected'); ?></li>
				</ul>
			</div>
			<!--[if lte IE 6]></td></tr></table></a><![endif]-->
			</li>
			</ul>
		<!-- ---------------------------------------------------------------------------------------------------------------------------------------------- -->
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