<?php //$cap=$capt; $class=""; $mess="";?>
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
<script type='text/javascript' src="http://code.jquery.com/jquery-1.7.2.js"></script>
<script type='text/javascript'>
			$(document).ready(function(){
					$('#refresh').click(function(){
							$.ajax({
									url:'<?php echo base_url('mybook/change_captcha');?>', 
									type:'POST',
									dataType: 'json', 
									data:{}, 
									success: function(data){
											alert(data.toSource());
											$("#cap").html(data['image']);
											$("#word").val(data['word']);
										}
							});
						});
	
				});
		</script>
<style>
.error {
	border:1px solid;
	border-color:red;
}
</style>
</head>
<body class="page_bg">
<div id="main" class="container-fluid">
  
  <?php //echo validation_errors(); ?>
  <?php if(isset($error)){
			$class='class="error"';
			$mess=$error;				
		}
?>
  <div class="register_form">
    <div class="head_wrap">
      <h2>Create New Account</h2>
      <div class="clear"> </div>
    </div>
    <form action="<?php echo base_url().'writer/registration';?>" method="post" class="form-horizontal">
      <div class="control-group">
        <label for="name" class="control-label">Name: </label>
         <div class="controls">
          <input type="text" value="<?php echo set_value('name');?>" id="name" name="name" <?php if(form_error('name')){echo 'class="error"';}?> class="input-large"/>
        <?php echo form_error('name');?> 
        </div>
      </div>
      
      <div class="control-group">
        <label for="username" class="control-label">User Name: </label>
        <div class="controls">
          <input type="text" value="<?php echo set_value('username');?>" id="username" name="username" <?php if(form_error('username')){echo 'class="error"';}?> class="input-large"/>
          <?php echo form_error('username');?> 
        </div>
      </div>
      
      <div class="control-group">
        <label for="password" class="control-label">Password:</label>
        <div class="controls">
          <input type="password" value="<?php echo set_value('password');?>" id="password" name="password" <?php if(form_error('password')){echo 'class="error"';}?> class="input-large"/>
          <?php echo form_error('password');?> </div>
      </div>
      
      <div class="control-group">
        <label for="repassword" class="control-label">Retype Password:</label>
        <div class="controls">
          <input type="password" value="" id="repassword" name="repassword" <?php if(form_error('repassword')){echo 'class="error"';}?> class="input-large"/>
          <?php echo form_error('repassword');?> </div>
      </div>
      
      <div class="control-group">
        <label for="email" class="control-label">Email:</label>
        <div class="controls">
          <input type="text" value="<?php echo set_value('email');?>" id="email" name="email" <?php if(form_error('email')){echo 'class="error"';}?> class="input-large"/>
          <?php echo form_error('email');?> </div>
      </div>
      
      <div class="control-group">
        <label for="phone" class="control-label">Phone:</label>
        <div class="controls">
          <input type="text" value="<?php echo set_value('phone');?>" id="phone" name="phone" <?php if(form_error('phone')){echo 'class="error"';}?> class="input-large"/>
          <?php echo form_error('phone');?> </div>
      </div>
      
      <div class="control-group">
        <label for="sex" class="control-label">Sex:</label>
        <div class="controls">
          <select id="sex" name="sex">
            <option value="-1">--Select--</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <!-- <input type="text" value="<?php echo set_value('sex');?>" id="sex" name="sex" <?php if(form_error('sex')){echo 'class="error"';}?>/> -->
        <?php echo form_error('sex');?>
      </div>
      
      <div class="control-group">
      <label for="role" class="control-label">Role:</label>
      <div class="controls">
        <select id="role" name="role">
          <option value="writer">Writer</option>
          <option value="editor">Editor</option>
        </select>
      </div>
      <!-- <input type="text" value="<?php echo set_value('sex');?>" id="sex" name="sex" <?php if(form_error('sex')){echo 'class="error"';}?>/> -->
       <?php echo form_error('sex');?>
      </div>
     
      <?php
	/*echo 'Submit the word you see below:';                    		
	echo '<input type="text" name="captcha" value="" '.$class.'/>';
	echo $mess;
	echo '</br>';*/
  ?>
      <!-- <div id="cap"><?php echo $cap['image'];?></div>	
	<?php echo form_button(array('id'=>'refresh','name'=>'refresh'),'Refresh');?>	
    </fieldset>
    <p>
    <input type="hidden" id="word" value="<?php echo $cap['word']?>" name="word"> 
   -->
     <div class="control-group">
        <div class="controls">
           <input type="submit" value="Create New Account" tabindex="6" name="submit" class="newAccountButton btn" />
         </div>  
      </div>  
    
    </form>
  </div>
  <?php echo anchor(base_url(),'Back To Login')?> </div>
</body>
</html>
