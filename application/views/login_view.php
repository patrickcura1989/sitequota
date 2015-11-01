<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<!--META-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nagger Login Form</title>

<!--STYLESHEETS-->
<link href="/sitequota/styles/loginform/css/style.css" rel="stylesheet" type="text/css" />

<!--SCRIPTS-->

<!--Slider-in icons-->
<script type="text/javascript">
$(document).ready(function() {
	$(".username").focus(function() {
		$(".user-icon").css("left","-48px");
	});
	$(".username").blur(function() {
		$(".user-icon").css("left","0px");
	});
	
	$(".password").focus(function() {
		$(".pass-icon").css("left","-48px");
	});
	$(".password").blur(function() {
		$(".pass-icon").css("left","0px");
	});
});


</script>

</head>
<body>

<!--WRAPPER-->
<div id="wrapper">

	<!--SLIDE-IN ICONS-->
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
    <!--END SLIDE-IN ICONS-->

<!--LOGIN FORM-->
<form method="post" action="<?php echo $form;?>" class="login-form">

	<!--HEADER-->
    <div class="header" align=center>
	
		<img style="position:relative; left:-10px" src="/sitequota/styles/img/logo/login_icon.png" width="200" height="200"/>
	<br/>
	
    
    <!--DESCRIPTION--><span><font class="myFont" style="font-size:13px;">Enter your HP Email and Password</font></span><!--END DESCRIPTION-->
    </div>
    <!--END HEADER-->
	
	<!--CONTENT-->
    <div class="content" align=center>
	
	<!--USERNAME--><input name="email" type="text" class="input username" style="font-family:'RobotoLight';" value="HP Email" onfocus="this.value=''" /><!--END USERNAME-->
    <!--PASSWORD--><input name="password" type="password" class="input password" style="font-family:'RobotoLight';" value="Password" onfocus="this.value=''" /><!--END PASSWORD-->
    </div>
    <!--END CONTENT-->
    
    <!--FOOTER-->
    <div class="footer" align=center>
    <!--LOGIN BUTTON--><input type="submit" name="submit" value="Login" style=" font-size:13px; font-family:'RobotoLight';" class="button" /><br/><br/><!--END LOGIN BUTTON-->
	<a href="nagger/learnMore" class="button" style="font-size:13px; font-family:'RobotoLight'; text-decoration: none !important;">Learn More</a>
	<br/>
	<!--END FOOTER-->

</form>
<!--END LOGIN FORM-->

</div>
<!--END WRAPPER-->

<!--GRADIENT--><div class="gradient"></div><!--END GRADIENT-->

</body>
</html>