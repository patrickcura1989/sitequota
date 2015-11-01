<!DOCTYPE html>
<html lang="en">
<head>
<style>
	.myH3{
   font: 18px/27px 'RobotoLight', Arial, sans-serif;
}
</style>
	<link rel="stylesheet" type="text/css" href="/sitequota/styles/foursquare-profile-source/global.css" />
</head>

<body>	
	
	
	<div  id="content2" class="clearfix" >
		<section id="leftcontent">
			<div id="userStats" class="clearfix">
				<div class="pic">
					<div class='circleBig' style='background-image:url("<?php echo $this->session->userdata('profileImgSrc');?>");display:inline-block; position:relative; top:4px;'></div>
				</div>
				
				<div class="data"><br/><br/><br/>
					<h3 class="myH3"><b>Email:  </b><?php echo $this->session->userdata('email');?></h3><br/><br/>
					<h3 class="myH3"><b>Team:  </b><?php echo $this->sitequota_model->getTeamName($this->session->userdata('teamId'));?></h3>
					<!--
					<div class="socialMediaLinks">
						<a href="http://twitter.com/jakerocheleau" rel="me" target="_blank"><img src="/sitequota/styles/foursquare-profile-source/img/twitter.png" alt="@jakerocheleau" /></a>
						<a href="http://gowalla.com/users/JakeRocheleau" rel="me" target="_blank"><img src="/sitequota/styles/foursquare-profile-source/img/gowalla.png" /></a>
					</div>
					-->
					<div class="sep"></div>
					<ul class="numbers clearfix">
						<li>Total Tickets<strong>185</strong></li>
						<li>SWT%<strong>90%</strong></li>
						<li class="nobrdr">CWT%<strong>90%</strong></li>
					</ul>
				</div>
			</section>
			
			<section id="rightcontent">
			<div class="gcontent">
				<div class="head"><h1>Badges(1)</h1></div>
				<div class="boxy">
					<p>Keep working to unlock badges!</p>
					
					<div class="badgeCount">
						<a href="#"><img src="/sitequota/styles/foursquare-profile-source/img/foursquare-badge.png" /></a>
						
					</div>
					
					
				</div>
			</div>
			</section>
	</div>
	
</body>
</html>