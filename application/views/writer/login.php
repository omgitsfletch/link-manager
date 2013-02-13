<?php ?>
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
</head>
<body class="page_bg">
<div id="main" class="container-fluid">

<div class="login_form"> 
  <!--<div class="head_wrap">
     <h2>Login</h2>
     <div class="clear"> </div>
  </div> -->
    <?php if($name != ''){?>
	<div class="error_text"><?php echo _("Dear ").$name._(" please contact the person that hired you.");?></div>
	<?php }?>
	<?php if($error != ''){?>
	<div class="error_text"><?php echo $error;?></div>
	<?php }?>
  <form action="" method="post" class="form-horizontal">
    <div class="control-group">
      <label for="email2" class="control-label">User Name:</label>
      <div class="controls">
        <input type="text" tabindex="1" size="50" value="<?php echo set_value('username');?>" id="username" name="username" <?php if(form_error('username')){echo 'class="error"';}?> class="input-large" />
        <?php echo form_error('username');?>
      </div>
    </div>
    <div class="control-group">
      <label for="password2" class="control-label">Password:</label>
      <div class="controls">
        <input type="password" tabindex="2" size="22" value="" id="password" name="password" <?php if(form_error('password')){echo 'class="error"';}?> class="input-large"/>
        <?php echo form_error('password');?> </div>
    </div>
    <div>
       <label class="control-label">&nbsp;</label>
	   <div class="controls"><?php echo form_checkbox('remember','1')?> Remember Me</div>
    </div>
    <div class="control-group">      
      <div class="controls">
         <input type="submit" value="Login" tabindex="3" name="submit" class="userLogin btn btn-inverse" />
         <!--<span>New User: <a href="<?php echo base_url('writer/registration');?>" class="btn btn-inverse">Sign Up</a></span>-->
      </div>
    </div>
    <input type="hidden" value="30"/>
  </form>
      
</div>
</div>
</body>
</html>
