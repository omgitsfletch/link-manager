<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Link Manager</title>
	<?php
	echo css_asset('screen.css', NULL, array('media' => 'screen', 'title' => 'default')) . "\n";
	echo js_asset('jquery/jquery-1.4.1.min.js') . "\n";
	echo js_asset('jquery/custom_jquery.js') . "\n";
	?>
	<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
	<?php echo js_asset('jquery/jquery.pngFix.pack.js'); ?></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$(document).pngFix( );
	});
	</script>
</head>
<body id="login-bg"> 

	<!-- Start: login-holder -->
	<div id="login-holder">

		<!-- start logo -->
		<div id="logo-login">&nbsp;</div>
		<!-- end logo -->
		
		<div class="clear"></div>
		
		<!--  start loginbox ................................................................................. -->
		<div id="loginbox">
		
			<!--  start login-inner -->
			<div id="login-inner">
				<form action="<?php echo current_url(); ?>" method="POST">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<th>Username</th>
					<td><input type="text" name="username" class="login-inp" /></td>
				</tr>
				<tr>
					<th>Password</th>
					<td><input type="password" name="password" value="" class="login-inp" /></td>
				</tr>
				<!--
				<tr>
					<th></th>
					<td valign="top"><input type="checkbox" class="checkbox-size" id="login-check" /><label for="login-check">Remember me</label></td>
				</tr>
				!-->
				<tr>
					<th></th>
					<td><input type="submit" class="submit-login"  /></td>
				</tr>
				</table>
				</form>
			</div>
			<!--  end login-inner -->
			<div class="clear"></div>

		</div>
		<!--  end loginbox -->

	</div>
	<!-- End: login-holder -->
</body>
</html>