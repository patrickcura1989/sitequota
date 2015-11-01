<html>
<head>

<script src="/sitequota/styles/tabcontent/tabcontent.js" type="text/javascript"></script>
<script src="/sitequota/styles/twisty/twisty.js" type="text/javascript"></script>
<script src="/sitequota/styles/twisty/prototype.js" type="text/javascript"></script>
<script src="/sitequota/styles/twisty/scriptaculous.js?load=effects" type="text/javascript"></script>
<link rel="stylesheet" href="/sitequota/styles/general.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="/sitequota/styles/fonts/stylesheet.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="/sitequota/styles/twisty/twisty.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="/sitequota/styles/twisty/twisty-print.css" type="text/css" media="print"></link>
<link href="/sitequota/styles/tabcontent/template4/tabcontent.css" rel="stylesheet" type="text/css" />

<style>
.myH3{
   font: 18px/27px 'RobotoLight';
}
.myH3Bigger{
   font: 25px 'RobotoLight';
}

.myFont{
	font: 18px/27px 'RobotoLight', Arial, sans-serif;
}

font{
	font-size:12px;
}
</style>

<style>
#panelSmallFont{
	font: 13px/15px 'RobotoLight';
}
</style>



</head>

<body>

<table>
<tr>
	<td valign=top width=500px>
		<h3 class="myH3">Daily User Analytics</h3><br/>
		<?php
			if($dailyUsers != null){
				echo '<table class="myTable">';
					echo '<th>User</th>';
					echo '<th>Team</th>';
					echo '<th>Logged Date</th>';
					foreach($dailyUsers as $row){
						echo '<tr>';
							echo '<td style="white-space:nowrap;">'.$row->NAME.'</td>';
							echo '<td style="white-space:nowrap;">'.$row->owning_team.'</td>';
							echo '<td style="white-space:nowrap;">'.$row->temp. ' minutes ago'.'</td>';
						echo '</tr>';
					}
				echo '</table>';
			}
			else{
			
			}
		?>
	</td>
	<td valign=top width=500px>
		<h3 class="myH3Bigger">IM Sync Interval</h3>
		<font id="panelSmallFont">This displays the highest possible sync interval for a ticket. </font><br/>
		<h3 class="myH3"><?php echo $imSyncInterval.' minutes ago.';?></h3>
	</td>
	
	<td valign=top>
		<h3 class="myH3Bigger">FR Sync Interval</h3>
		<font id="panelSmallFont">This displays the highest possible sync interval for a ticket. </font><br/>
		<h3 class="myH3"><?php echo $frSyncInterval.' minutes ago.';?></h3>
	</td>
</tr>

</table>

</body>
</html>
