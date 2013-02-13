<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Article's Park</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" type="text/css">
<!-- Le styles -->
<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/bootstrap-responsive.css" rel="stylesheet">
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
<script>
	var site_url = '<?php echo base_url();?>';
	var curent_date = '<?php echo date('Y-m-d');?>';
	var curent_date_time = '<?php echo date('Y-m-d H:i:s');?>';
</script>
</head>
<body>
<div id="wrapper">
  <div id="header" class="container-fluid" >
    <div class="row-fluid">
      <div id="logo"><a href="#">Project name</a></div>
      <div class="menu">
        <ul class="nav">
          <li class="active"><a href="<?php echo base_url();?>editor/dashboard"><?php echo _("Dashboard");?></a></li>
          <li> <a href="<?php echo base_url();?>editor/articles"><?php echo _("Articles");?></a>
            <ul class="submenu">
              <?php //foreach($added_articles as $values){?>
              <li><a href="<?php echo base_url();?>editor/published"><?php echo _("Published");?></a></li>
              <li><a href="<?php echo base_url();?>editor/approved"><?php echo _("Approved");?></a></li>
              <li><a href="<?php echo base_url();?>editor/submitted"><?php echo _("Submitted");?></a></li>
              <li><a href="<?php echo base_url();?>editor/rejected"><?php echo _("Rejected");?></a></li>
              <!-- <li><a href="<?php echo base_url();?>editor/available"><?php echo _("Available");?></a></li> -->
              <?php //}?>              
            </ul>
          </li>
          <!-- <li><a href="keywords.html"><?php echo _("Keywords");?></a></li> -->
          <li> <a href="<?php echo base_url();?>editor/writers"><?php echo _("Writers");?></a>
          	<ul class="submenu">
              <li><a href="<?php echo base_url();?>editor/writers"><?php echo _("Manage Writers");?></a></li>
              <li><a href="<?php echo base_url();?>editor/addWriter"><?php echo _("Add Writers");?></a></li>              
            </ul>
          </li>
          <li><a href="<?php echo base_url();?>editor/settings"><?php echo _("Settings");?></a></li>
          <li><a href="<?php echo base_url();?>editor/reports"><?php echo _("Reports");?></a></li>
          <li class="last"><a href="<?php echo base_url();?>editor/logout"><?php echo _("Logout");?></a></li>
          <li class="last"><a href="<?php echo base_url();?>editor/profile"><?php echo $this->session->userdata('username');?></a></li>
          <li class="last"><span><?php echo _("Hello");?>,</span></li>
        </ul>
        <div class="clear">&nbsp;</div>
        <!-- <div class="links"> <a href="<?php echo base_url();?>editor/logout"><?php echo _("Logout");?></a>
           <div class="clear">&nbsp;</div>
        </div> -->
      </div>
    </div>
  </div>