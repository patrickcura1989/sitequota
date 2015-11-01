<html>
<head>
<link rel="stylesheet" href="/sitequota/styles/general.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="/sitequota/styles/fonts/stylesheet.css" type="text/css" media="screen"></link>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="/sitequota/styles/chartmaster/Chart.js" type="text/javascript"></script>

<link rel="icon" type="image/png" href="/sitequota/styles/img/logo/browser_icon.png">

<!-- CSS Codes for the NAV BAR -->
<style>
#trans-nav { list-style-type: none; height: 52px; padding: 0; margin: 0;}
#trans-nav li { float: left; position: relative; padding: 0; line-height: 50px; background: #33b5e5 url(nav-bg.png) repeat-x 0 0; }
#trans-nav li:hover { background-position: 0 -40px; }
#trans-nav li a { display: block; padding: 0 15px; color: #fff; text-decoration: none; font: 18px/50px 'RobotoLight', Arial, sans-serif;}
#trans-nav li a:hover { color: #a3f1d7; }
#trans-nav li ul { opacity: 0; position: absolute; left: 0; width: 20em; background: #33b5e5; list-style-type: none; padding: 0; margin: 0; }
#trans-nav li:hover ul { opacity: 1; }
#trans-nav li ul li { float: none; position: static; height: 0; line-height: 0; background: none; }
#trans-nav li:hover ul li { height: 30px; line-height: 30px; }
#trans-nav li ul li a { background: #33b5e5;}
#trans-nav li ul li a:hover { background: #33b5e5; }
#trans-nav li { -webkit-transition: all 0.2s; }
#trans-nav li a { -webkit-transition: all 0.5s; }
#trans-nav li ul { -webkit-transition: all 1s; }
#trans-nav li ul li { -webkit-transition: height 0.5s; }
</style>

<style>
#left {
position: absolute;
left: 0px;
width: 220px;
color: #564b47;
margin: 0px; 
padding: 0px;
font: 18px/27px 'RobotoLight', Arial, sans-serif;

}

#content {

margin: 0 50px 50px;
}

#panelBigFont{
	font: 15px/15px 'RobotoLight', Arial, sans-serif;
}
#panelSmallFont{
	font: 12px/15px 'RobotoLight', Arial, sans-serif;
}

.myFont{
	font: 15px/15px 'RobotoLight', Arial, sans-serif;
}
</style>


<title><?php echo $title;?></title>
</head>

<body>
	
	

	<div id = "navigation" style="background: #33b5e5; position:absolute; left:0px; top:0px; width:110%;"> 
		
		<ul id="trans-nav">

				<li><?php echo anchor('/aiw/showHomePage/Array', 'Home');?></li>
				
				
				<li><a href="/appmapping" target="_blank">Manage Applications</a></li>
				
			</ul>
	
		
	</div>
	
	
	<!--
	<div style="background: #33b5e5; width:30%; position:absolute; top:0; right:0px;">
		<ul id="trans-nav">
			<li><a href="#">Welcome:
				
				<div class='circle' style='background-image:url("<?php //echo $this->session->userdata('profileImgSrc');?>");display:inline-block; position:relative; top:4px;'></div>
				<?php //echo $this->session->userdata('email');?></a>
				<ul>
					<li><?php //echo anchor('/nagger/showMyProfile', 'My Profile');?></li>
					<li><?php //echo anchor('/nagger/logout', 'Logout');?></li>
				</ul>
			</li>
		</ul>
	</div>
	
	-->
	
	
	<br/><br/><br/>
	<div align=center>
	<h3 class="myH3"><b>Application Information Warehouse</b></h3>
	</div>
	<hr class="carved"/>
	<div id = "content">
		
		<?php echo $content; ?>
	</div>

		<hr class="carved"/>
	 <font class="myFont">Brought to you by WebFAST Labs. <a href="/webfastlabs">See other works</a>.</font>


</body>
</html>
