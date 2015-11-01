<html>
<head>
<title><?php echo $title;?></title>
<meta http-equiv="refresh" content="10800"/>
<link rel="stylesheet" href="/sitequota/styles/general.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="/sitequota/styles/fonts/stylesheet.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<script src="/sitequota/styles/chartmaster/Chart.js" type="text/javascript"></script>

<script>
function drawChart(cockpit){
	
	var storageUsed = document.getElementById(cockpit+'storageUsed').value;
	var storageCap = document.getElementById(cockpit+'storageCap').value;
	storageUsed = parseInt(storageUsed);
	storageCap = parseInt(storageCap);
	//Normalize
	storageUsed = (storageUsed/storageCap)*100;
	storageCap = 100-storageUsed;
	var pieData = [
		{	//normalize
			value: storageUsed,
			color:"#C0C0C0"
		},
		{
			value : storageCap,
			color : "#0096d5"//"#"
		}
	];

	new Chart(document.getElementById(cockpit).getContext("2d")).Pie(pieData);
}

</script>

<style>
.myH3{
   font: 25px 'RobotoLight', Arial, sans-serif;
   
}

.myFont{
	font: 15px 'RobotoLight', Arial, sans-serif;
	
}
</style>
</head>

<body>
<div align=center><h3 class="myH3"><b/>PG Cockpits Site Quota Dashboard</h3>
<div><a href="/reportmodule">
<img src="/sitequota/styles/img/learnmore/reports.png" width=50 height=50/>
</a>
</div>
</div><hr class="carved"/>
<font class="myFont"><i/>Site Storage with more than the ADVANCED THRESHOLD (<= <?php echo ADVANCED_THRESHOLD;?>) MB.</font><br/><br/>

<?php

if($cockpitsArr != null){
	$lastUpdateDate;
	$lastUpdateTime;
	echo '<table align=center class="myTable">';
	$i = 0;
	$tempIndex = '';
	foreach($cockpitsArr as $row){
		if(strtolower($tempIndex) != strtolower($row->cockpit)){
			if($row->free <= ADVANCED_THRESHOLD){
				$currCockpit = $row->cockpit;
				$storageUsed = $row->used;
				$storageCap  = $row->capacity;
				$idUsed = $currCockpit.'storageUsed';
				$idCap = $currCockpit.'storageCap';
				
				echo "<input type=hidden id='".$idUsed."' value='".$storageUsed."'/>";
				echo "<input type=hidden id='".$idCap."' value='".$storageCap."'/>";
				
				if($i == 0){
					$lastUpdateDate = $row->DATE;
					$lastUpdateTime = $row->TIME;
					echo '<tr>';
					$i++;
				}
			
				
				echo '<td>';
					echo '<div align=center>';
					echo '<table>';
					$cockpitLink = "http://dcsp.pg.com/bu/".$currCockpit."/_layouts/usage.aspx";
					$cockpitScaBinLink = "http://dcsp.pg.com/bu/".$currCockpit."/_layouts/AdminRecycleBin.aspx";
					echo '<tr><td colspan=2 align=center><b/>'.anchor_popup($cockpitLink,strtoupper($currCockpit));
					echo '&nbsp&nbsp<a href="'.$cockpitScaBinLink.'" target="_blank"><img src="/sitequota/styles/img/recycle_bin.png" width=15 height=15 href=""/></a>';
					echo '</td></tr>';
					echo '<tr><td>Free:</td>';
					if($row->free <= TRUE_THRESHOLD){
						echo '<td style="background-color:red;"><font color=white>'.$row->free.' MB ('.round($row->percent, 2).'%)</font></td></tr>';
					}
					else{
						echo '<td style="background-color:yellow;"><font color=black>'.$row->free.' MB ('.round($row->percent, 2).'%)</font></td></tr>';
					}
					echo '<tr><td>Used:</td><td>'.$storageUsed.' MB</td></tr>';
					echo '<tr><td>Capacity:</td><td>'.$storageCap.' MB</td></tr>';
					echo '</table>';
					echo "<canvas id='".$currCockpit."' height='150' width='150'></canvas>";
					echo '</div>';
				echo '</td>';
				
				if($i % 6 == 0 && $i != 0){
					echo '</tr><tr>';
					
				}
				$i++;
				echo "<script>drawChart('".$currCockpit."');</script>";
			}
		}
		$tempIndex = $row->cockpit;
	}
	
	echo '</table>';
	?><hr class="carved"/>
	<font class="myFont">Access <?php echo anchor_popup(EFORM_URL, 'eForm Link');?> to increase storage.</font><br/><br/>
	<font class="myFont">Last Synched: <?php echo '<b>'.$lastUpdateDate.'</b>  |  <b>'.$lastUpdateTime.'</b>';?> SGT</font><br/><br/>
	<font class="myFont"><i/>This is based on the job in the server that runs every 3 hours. Refreshing this page does not necessarily mean that you are getting the real-time data. Refer to <b/>Last Synched.</font>
	<?php
}
else echo 'No Data Found.<br/>';
?>

</body>
</html>