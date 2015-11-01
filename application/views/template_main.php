<html>
<head>
<link rel="stylesheet" href="/sitequota/styles/general.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="/sitequota/styles/fonts/stylesheet.css" type="text/css" media="screen"></link>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="/sitequota/styles/slider/jquery.pageslide.css" />


<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>

<script src="/sitequota/styles/chartmaster/Chart.js" type="text/javascript"></script>
<script type="text/javascript">
//Global Initialisation for Autocomplete highlighting*******************************************
$.ui.autocomplete.prototype._renderItem = function( ul, item){
  var term = this.term.split(' ').join('|');
  var re = new RegExp("(" + term + ")", "gi") ;
  var t = item.label.replace(re,"<b>$1</b>");
  return $( "<li></li>" )
     .data( "item.autocomplete", item )
     .append( "<a>" + t + "</a>" )
     .appendTo( ul );
};

//Global initialization for search*******************************************
$(function () {
	$("#searchText").autocomplete({
		source: '/sitequota/index.php/nagger/search',
		minLength: 3,
		position: {
			my : "right top",
			at: "right bottom"
		},
		//action here to dictate where to go once an entry has been selected
		select: function(event, ui) {
			var split = ui.item.value.split(' - ');
			var ticketNumber = split[0];
			if(ticketNumber != '#') {
				window.open('/sitequota/index.php/nagger/showTicketReport/' + ticketNumber, "_blank");
			}
		},
		
	})
	
});

$(function () {
	$("#searchTextArchive").autocomplete({
		source: '/sitequota/index.php/nagger/searchArchive',
		minLength: 3,
		position: {
			my : "left top",
			at: "left bottom"
		},
		//action here to dictate where to go once an entry has been selected
		select: function(event, ui) {
			var split = ui.item.value.split(' - ');
			var ticketNumber = split[0];
			if(ticketNumber != '#') {
				window.open('/sitequota/index.php/nagger/showTicketReport/' + ticketNumber, "_blank");
			}
		},
		
	})
	
});

</script>

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
	font: 13px 'RobotoLight', Arial, sans-serif;
}

</style>

<style>
.circle {
  width: 50px;
  height: 50px;
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
  width: 80px;
  height: 80px;
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
	<div id = "content">
    
	<br/>
	
	<div id = "navigation" style="background: #33b5e5; position:absolute; top:0px; left:0px; right:0px; width:100%;"> 
		<div style="float:left;">
		<ul id="trans-nav">

				<li><?php echo anchor('/nagger/showHome/Array', 'Home');?></li>
				<li><?php echo anchor('/nagger/showHandover/Array', 'Handover');?></li>
				<li><?php echo anchor('/nagger/showMyTeam/Array', 'My Team');?></li>
				
				<li><a href="#">Archive</a>
					<ul>

					   <li><?php echo anchor('/nagger/showImArchive', 'IM Archive');?></li>
					   <li><?php echo anchor('/nagger/showFrArchive', 'FR Archive');?></li>
					</ul>
				</li>
				<li><?php echo anchor('/nagger/showImReport', 'Reports');?>
					<!--<ul>
					   <li><?php echo anchor('/nagger/showImReport', 'Incidents Report');?></li>
					   <li><?php echo anchor('/nagger/showFrReport', 'Fulfillments Report');?></li>
					</ul>
					-->
				</li>
				<li><?php echo anchor('/aiw', 'Application Warehouse');?></li>
				<!--
				<li><a href="#">Set Timezone</a>
					<ul>

					   <li><a href="#">SGT</a></li>
					   <li><a href="#">EST</a></li>
						<li><a href="#">CET</a></li>

					</ul>
				</li>
				-->
				
				
				
				
			</ul>
			</div>
			
			<div style="float:right; position:absolute; top:-5px; right:10px;"><br/>
				<a href="#modal" class="right"><img src="/sitequota/styles/img/app_menu.png" width=20 height=20/></a>
			</div>
		
	</div>
	
	</div>
	
	
	
	<script src="/sitequota/styles/slider/jquery.pageslide.min.js"></script>
    <script>
        /* Slide to the left, and make it model (you'll have to call $.pageslide.close() to close) */
		/* If modal is false, clicking anywhere will make the modal (panel) hidden again,*/
        $(".right").pageslide({ direction: "left", modal: false });
    </script>
	<div id="modal">
		<div align=center class='circle' style='background-image:url("<?php echo $this->session->userdata('profileImgSrc');?>");'></div><br/>
		<div align=center>
		<font class="myFont"><?php echo $this->session->userdata('email');?>
		<br/>Team: <?php echo $this->sitequota_model->getTeamName($this->session->userdata('teamId'));?>
		</font>
		</div>
		
		<div align=center>
		<?php echo anchor('/nagger/showMyProfile', 'View Profile', array('class'=>'sidebarAnchor'));?>
		<br/>
		<?php echo anchor('/nagger/logout', 'Logout', array('class'=>'sidebarAnchor'));?>
		</div>
		
		<hr class="carved"/>
		
		<table class="sidebarTable"> 
			<tr>
			<td valign=top>
				<img src="/sitequota/styles/img/home.png" width="20" height="20"/>
				<?php echo anchor('/nagger/showHome/Array', 'Home', array('class'=>'sidebarAnchor'));?>
			</td>
			</tr>
			<tr>
			<td valign=top>
				<img src="/sitequota/styles/img/myticket_icon.png" width="20" height="20"/>
				<?php echo anchor('/nagger/showMyTickets/Array', 'My Tickets', array('class'=>'sidebarAnchor'));?>
			</td>
			</tr>
			<tr>
			<td valign=top>
				<img src="/sitequota/styles/img/followup_icon.png" width="25" height="17"/>
				<?php echo anchor('/nagger/showFollowup/Array', 'Follow-Up (coming soon)', array('class'=>'sidebarAnchor'));?>
			</td>
			</tr>
			
		</table>
		
		<hr class="carved"/>
		<table class="sidebarTable"> 
			<tr>
			<td valign=top>
				<img src="/sitequota/styles/img/labs.png" width="20" height="20"/>
				<?php echo anchor('/nagger/labs', 'Labs', array('class'=>'sidebarAnchor'));?>
			</td>
			</tr>
			<tr>
			<td valign=top>
				<img src="/sitequota/styles/img/about.png" width="20" height="20"/>
				<?php echo anchor('/nagger/admin', 'Admin', array('class'=>'sidebarAnchor'));?>
			</td>
			</tr>
		</table>
		<hr class="carved"/>
		<div  align=center>
			<table>
			<tr>
			<td>
			<img src="/sitequota/styles/img/analytics.png" width="30" height="30" /><br/>
			</td>
			<td>
			<?php echo '<font id="panelSmallFont">Users: '.$this->sitequota_model->getActiveUserCount().'</font>';
					echo '<br/>';
					echo '<font id="panelSmallFont">Teams: '.$this->sitequota_model->getTeamCount().'</font>';
			?>
			</td>
			</tr></table>
		</div>
	</div>
	
	<?php
		
		}
	?>
	
			
			
	

	<?php echo $content;?>
	<?php 
	
	if($this->session->userdata('email') == '' || $this->session->userdata('email') == null){
	
	}
	else{
		
	?>
	<hr class="carved"/>
	 <font class="myFont">Brought to you by WebFAST Labs. <a href="/webfastlabs">See other works</a>.</font>
	
		
		<!--
		<div style="float:right;">
			<a class="myButton" href="mailto:adrian-lester.tan@hp.com?Subject=Nagger%20Issue%20Report&Body=Describe%20your%20issue:">Get Help</a>
			
		</div>
		-->
	 
	 <?php
		}
	?>
	
	
</body>
</html>
