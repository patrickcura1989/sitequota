<html>
<head>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="/siren/styles/jquery.pttime/src/jquery.ptTimeSelect.css" />
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/redmond/jquery-ui.css" />

<!--All other imports of script using JQUERY should come AFTER! the script import of jquery itself-->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="/siren/styles/jquery.pttime/src/jquery.ptTimeSelect.js"></script>

<style>
.myH3{
   font: 18px/27px 'RobotoLight', Arial, sans-serif;
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
	font: 13px/15px 'RobotoLight', Arial, sans-serif;
}
</style>



</head>

<body>
<h3>Tickets in <?php echo $queue;?></h3><br/>
<?php 
	$ch = curl_init();
	$url = "http://smtracker.pg.com/pls/smtracker/pg_tracker.inc_groups?i_group=".$queue;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	//ERROR_HANDLING
	if ($output === false) {
		trigger_error('Failed to execute cURL session: ' . curl_error($ch), E_USER_ERROR);
	}
	
	$html = str_get_html($output);
	$spanArray = $html->find('table');
	//echo '<table class="myTable">';
	for ($i=0; $i<count($spanArray); $i++){
		
		echo $spanArray[$i];
	}
	//echo '</table>';
	/*
	$emailContent = '';
	$emailContent .= "<tr><td>".$incidentList[$cIndex]."</td>";
		for($i=0; $i<count($spanArray); $i++){
			if (strpos($spanArray[$i], 'Current Status:') !== FALSE){
				$i++;
				$currentStatus = $spanArray[$i];
				$emailContent .= "<td>".$currentStatus."</td>";
			}
			if (strpos($spanArray[$i], 'Impact:') !== FALSE){
				$i++;
				$impact = $spanArray[$i];
				$emailContent .= "<td>".$impact."</td>";
			}
			if (strpos($spanArray[$i], 'Urgency:') !== FALSE){
				$i++;
				$urgency = $spanArray[$i];
				$emailContent .= "<td>".$urgency."</td>";
			}
			if (strpos($spanArray[$i], 'Reported:') !== FALSE){
				$i++;
				$reported = $spanArray[$i];
				$emailContent .= "<td>".$reported."</td>";
			}
			
		}
		$emailContent .= "</tr>";
	*/
	curl_close($ch);




?>
</body>
</html>
