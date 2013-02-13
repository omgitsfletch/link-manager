<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Article's Park</title>
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
      
    </div>
  </div>
  <?php $method_from = $this->router->fetch_method();?>
  <div class="menu container-fluid">
      <div class="row-fluid">
        <ul class="nav">
          <li <?php if($method_from == 'dashboard'){?>class="active"<?php }?> ><a href="<?php echo base_url();?>admin/dashboard"><?php echo _("Dashboard");?></a></li>
          <li <?php if($method_from == 'articles' || $method_from == 'published' || $method_from == 'approved' || $method_from == 'submitted' || $method_from == 'rejected'){?>class="active"<?php }?> ><a href="<?php echo base_url();?>admin/articles"><?php echo _("Articles");?></a>
            <ul class="submenu" <?php if($method_from == 'articles' || $method_from == 'published' || $method_from == 'approved' || $method_from == 'submitted' || $method_from == 'rejected'){?>style="display: block;"<?php }?>>
              <li <?php if($method_from == 'published'){?>class="sub_show"<?php }?> ><a href="<?php echo base_url();?>admin/published"><?php echo _("Published");?></a></li>
              <li <?php if($method_from == 'approved'){?>class="sub_show"<?php }?> ><a href="<?php echo base_url();?>admin/approved"><?php echo _("Approved");?></a></li>
              <li <?php if($method_from == 'submitted'){?>class="sub_show"<?php }?> ><a href="<?php echo base_url();?>admin/submitted"><?php echo _("Submitted");?></a></li>
              <li <?php if($method_from == 'rejected'){?>class="sub_show"<?php }?> ><a href="<?php echo base_url();?>admin/rejected"><?php echo _("Rejected");?></a></li>
            </ul>
          </li>
          <li <?php if($method_from == 'writers' || $method_from == 'addWriter'){?>class="active"<?php }?> > <a href="<?php echo base_url();?>admin/writers"><?php echo _("Writers");?></a>
          	<ul class="submenu" <?php if($method_from == 'writers' || $method_from == 'addWriter'){?>style="display: block;"<?php }?>>
              <li <?php if($method_from == 'writers'){?>class="sub_show"<?php }?> ><a href="<?php echo base_url();?>admin/writers"><?php echo _("Manage Writers");?></a></li>
              <li <?php if($method_from == 'addWriter'){?>class="sub_show"<?php }?> ><a href="<?php echo base_url();?>admin/addWriter"><?php echo _("Add Writers");?></a></li>              
            </ul>
          </li>
          <li <?php if($method_from == 'settings'){?>class="active"<?php }?> ><a href="<?php echo base_url();?>admin/settings"><?php echo _("Settings");?></a></li>
          <li <?php if($method_from == 'reports' || $method_from == 'detail_reports'){?>class="active"<?php }?> ><a href="<?php echo base_url();?>admin/reports"><?php echo _("Reports");?></a></li>
          <li><a href="<?php echo base_url();?>links/view"><?php echo _("Back");?></a></li>
          
          <li class="last"><a href="<?php echo base_url();?>admin/logout"><?php echo _("Logout");?></a></li>
          <li <?php if($method_from == 'profile'){?>class="last active"<?php }else{?>class="last"<?php }?>><a href="<?php echo base_url();?>admin/profile"><?php echo $this->session->userdata('username');?></a></li>
          <li class="last"><span><?php echo _("Hello");?>,</span></li>
        </ul>
        <div class="clear">&nbsp;</div>
        <!-- <div class="links"> <a href="<?php echo base_url();?>admin/logout"><?php echo _("Logout");?></a>
           <div class="clear">&nbsp;</div>
        </div> -->
        </div>
      </div>