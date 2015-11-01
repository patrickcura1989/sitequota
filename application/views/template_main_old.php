<html>
<head>
<link rel="stylesheet" href="/sitequota/styles/general.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="/sitequota/styles/fonts/stylesheet.css" type="text/css" media="screen"></link>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet"  href="css/themes/default/jquery.mobile-1.3.0-beta.1.css" />

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
#trans-nav li ul { opacity: 0; position: absolute; left: 0; width: 12em; background: #33b5e5; list-style-type: none; padding: 0; margin: 0; }
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

</style>

<style>
.circle {
  width: 30px;
  height: 30px;
  margin: 0.5px auto;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  -webkit-border-radius: 99em;
  -moz-border-radius: 99em;
  border-radius: 99em;
  border: 0 solid #eee;
  box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);  
}

.circleBig {
  width: 100px;
  height: 100px;
  margin: 0.5px auto;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  -webkit-border-radius: 99em;
  -moz-border-radius: 99em;
  border-radius: 99em;
  border: 0 solid #eee;
  box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);  
}
</style>

<title><?php echo $title;?></title>
</head>

<body>
	
	<?php 
		//$_SERVER['HTTP_HOST'] returns localhost:82
		//$_SERVER['REQUEST_URI'] returns the remaining after hostname /siren/index.php/welcome
		$site_url = $_SERVER['REQUEST_URI'];
		if($site_url == '/sitequota/index.php/nagger'){
			$this->session->sess_destroy();
		}
		
	if($this->session->userdata('email') == '' || $this->session->userdata('email') == null){
	
	}
	else{
		
	?>

	<div id = "navigation" style="background: #33b5e5; position:absolute; top:0px; width:100%; left:-10px;"> 
		
		<ul id="trans-nav">

				<li><?php echo anchor('/nagger/showHome/Array', 'Home');?></li>
				<li><?php echo anchor('/nagger/showMyTickets/Array', 'My Tickets');?></li>
				<li><?php echo anchor('/nagger/showHandover/Array', 'Handover');?></li>
				<li><?php echo anchor('/nagger/showFollowup/Array', 'Follow-Up');?></li>
				<li><a href="#">Sync</a>
					<ul>

					   <li><?php echo anchor('/nagger/manualSyncIm', 'Sync My IM');?></li>
					   <li><?php echo anchor('/nagger/manualSyncFr', 'Sync My FR');?></li>
					</ul>
				</li>
				<li><?php echo anchor('/nagger/showReports', 'Reports');?></li>
				<!--
				<li><a href="#">Set Timezone</a>
					<ul>

					   <li><a href="#">SGT</a></li>
					   <li><a href="#">EST</a></li>
						<li><a href="#">CET</a></li>

					</ul>
				</li>
				-->
				<li><a href="#">Archive</a>
					<ul>
					   <li><?php echo anchor('/nagger/showImArchive', 'IM List');?></li>
					   <li><?php echo anchor('/nagger/showFrArchive', 'FR List');?></li>
					   
					</ul>
				</li>
				
				<li><a href="#">About</a></li>
				
			</ul>
	
		
	</div>
	
	<div style="background: #33b5e5; width:30%; position:absolute; top:0; right:0px;">
		<ul id="trans-nav">
			<li><a href="#">Welcome:
				
				<div class='circle' style='background-image:url("<?php echo $this->session->userdata('profileImgSrc');?>");display:inline-block; position:relative; top:4px;'></div>
				<?php echo $this->session->userdata('email');?></a>
				<ul>
					<li><?php echo anchor('/nagger/showMyProfile', 'My Profile');?></li>
					<li><?php echo anchor('/nagger/logout', 'Logout');?></li>
				</ul>
			</li>
		</ul>
	</div>
	
	</div>
	
	<?php
	
		}
	?>
	<br/><br/><br/>
	<div id = "content">
		
		<?php echo $content; ?>
	</div>

	
	<?php 
	
	if($this->session->userdata('email') == '' || $this->session->userdata('email') == null){
	
	}
	else{
	?>
	<hr class="carved"/>
	 
		<div align=center>
			
			<table>
			<tr>
			<td>
			<img src="/sitequota/styles/img/analytics.png" width="50" height="50" /><br/>
			</td>
			<td>
			<?php echo '<font id="panelSmallFont"><b/>Users: '.$this->sitequota_model->getActiveUserCount().'</font>';
					echo '<br/>';
					echo '<font id="panelSmallFont"><b/>Teams: '.$this->sitequota_model->getTeamCount().'</font>';
			?>
			</td>
			</tr></table>
		</div>
		<!--
		<div style="float:right;">
			<a class="myButton" href="mailto:adrian-lester.tan@hp.com?Subject=Nagger%20Issue%20Report&Body=Describe%20your%20issue:">Get Help</a>
			
		</div>
		-->
	 
	 <?php
		}
	?>
	<br/><br/><br/><br/>

</body>
</html>
