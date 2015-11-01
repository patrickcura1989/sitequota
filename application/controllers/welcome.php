<style type="text/css">
.tableClass a:link {
	color: #666;
	font-weight: bold;
	text-decoration:none;
}
.tableClass a:visited {
	color: #999999;
	font-weight:bold;
	text-decoration:none;
}
.tableClass a:active,
.tableClass a:hover {
	color: #bd5a35;
	text-decoration:underline;
}
.tableClass{
	font-family:Arial, Helvetica, sans-serif;
	color:#666;
	font-size:12px;
	text-shadow: 1px 1px 0px #fff;
	background:#eaebec;
	margin:20px;
	border:#ccc 1px solid;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;
}
.tableClass th {
	padding:21px 25px 22px 25px;
	border-top:1px solid #fafafa;
	border-bottom:1px solid #e0e0e0;

	background: #ededed;
	background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
	background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
}
.tableClass th:first-child {
	text-align: left;
	padding-left:20px;
}
.tableClass tr:first-child th:first-child {
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
.tableClass tr:first-child th:last-child {
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
.tableClass tr {
	text-align: center;
	padding-left:20px;
}
.tableClass td:first-child {
	text-align: left;
	padding-left:20px;
	border-left: 0;
}
.tableClass td {
	padding:18px;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;

	background: #fafafa;
	background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
	background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
}
.tableClass tr.even td {
	background: #f6f6f6;
	background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
	background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
}
.tableClass tr:last-child td {
	border-bottom:0;
}
.tableClass tr:last-child td:first-child {
	-moz-border-radius-bottomleft:3px;
	-webkit-border-bottom-left-radius:3px;
	border-bottom-left-radius:3px;
}
.tableClass tr:last-child td:last-child {
	-moz-border-radius-bottomright:3px;
	-webkit-border-bottom-right-radius:3px;
	border-bottom-right-radius:3px;
}
.tableClass tr:hover td {
	background: #f2f2f2;
	background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
	background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);	
}

.myFont {
color: #333333;
font-family: Century Gothic, sans-serif;
font-size: 15px
}

</style>
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
			color:"#0096d5"
		},
		{
			value : storageCap,
			color : "white"//"#0096d5"
		}
	];

	new Chart(document.getElementById(cockpit).getContext("2d")).Pie(pieData);
}

function drawBar(cockpit){
	var storageUsed = document.getElementById(cockpit+'storageUsed').value;
	var storageCap = document.getElementById(cockpit+'storageCap').value;
	storageUsed = parseInt(storageUsed);
	storageCap = parseInt(storageCap);
	
	var barChartData = {
			labels : ["Used","Capacity"],
			datasets : [
				{
					fillColor : "#0096d5",
					strokeColor : "rgba(220,220,220,1)",
					data : [storageUsed,storageCap]
				}
			],
			
			
		}

	new Chart(document.getElementById(cockpit).getContext("2d")).Bar(barChartData);	
}
</script>
<?php 
class Welcome extends CI_Controller {
	
	function index(){
		
		$this->load->helper('form_helper');
		$this->load->helper('url');
		
		$this->load->library('email');
		
		
		$config['protocol'] = 'smtp';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['smtp_host'] = 'smtp3.hp.com';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		include("lib/simplehtmldom/simple_html_dom.php");
		//display only PHP Error Messages
		//error_reporting(E_ERROR);
		ini_set('max_execution_time', 600);
		$this->showHomePage('');
		
	}
	
	
	function getCockpitList(){
		//return array("tcmdo");
		return array(
			"asiamdoasean",
			"asiamdoindia",
			"femcareaaijk",
			"femcareemea",
			"femcaregc",
			"femcareglobal",
			"femcarela",
			"femcarena",
			"gbsasia",
			"gbsbcs",
			"gbsglobal",
			"mexicomdo",
			"oralcareaaijk",
			"oralcareemea",
			"oralcaregc",
			"oralcareglobal",
			"oralcarela",
			"oralcarena",
			"petcareasia",
			"petcareemea",
			"petcareglobal",
			"petcarenala",
			"shavecareaaijk",
			"shavecaregc",
			"shavecareglobal",
			"shavecarela",
			"shavecarena",
			//"shavecarewe",
			"wehq",
			//"wemdobenelux",
			"anzmdo",
			//Cycle 2
			"asiamdo",
			"balkansmdo",
			"braunglobal",
			"cemdo",
			"cmk",
			"colombiamdo",
			"er",
			"fabriccareaaijk",
			//ERROR: "fabriccareceemea",
			"fabriccareglobal",
			"fabriccarela",
			"fabriccarena",
			//ERROR: "fabriccarewe",
			//"francemdo",
			"gbsclt",
			"gbsdelivery",
			"gbsitdo",
			"gbsla",
			"homecareasia",
			"homecareglobal",
			"homecarela",
			"homecarena",
			//ERROR: "homecarewe",
			"iberiamdo",
			//"idcgenerictestsite",
			"israelmdo",
			"italymdo",
			"japanmdo",
			"ladmarmdo",
			//"marketing",
			"neareastmdo",
			"nwamdo",
			"personalpowerasia",
			"personalpoweremea",
			"personalpowerglobal",
			"personalpowerna",
			"perumdo",
			"pgpasia",
			"pgpemea",
			"pgpglobal",
			"pgpna",
			"pgtglobal",
			"phcglobal",
			"phcna",
			"philippinesmdo",
			//August 12, 2014
			//"ras",
			"rd",
			"seafricamdo",
			"ukimdo",
			"venezuelamdo"

		);
		
		
	}
	
	function showHomePage(){
		echo "<title>Site Storage Monitor</title>";
		echo '<h3>PGCockpits Site Storage Monitor</h3>';
		//START RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		//START RECORDING LOAD TIME
		
		$username = PGUSERNAME;
		$password = PGPASSWORD;
		$emailContent = '';
		$cockpitList = $this->getCockpitList();
		$cockpitSubject = array();
		
		echo 'Sites Loaded and HTTP Status (should be 200):<br/>';
		echo "<table class='tableClass'>";
		for($cIndex = 0; $cIndex<count($cockpitList); $cIndex++){
			$ch = curl_init();
			$url = "http://dcsp.pg.com/bu/".$cockpitList[$cIndex]."/_layouts/usage.aspx";
			$adminRecycleBin = "http://dcsp.pg.com/bu/".$cockpitList[$cIndex]."/_layouts/adminrecyclebin.aspx";
			curl_setopt($ch, CURLOPT_URL, $url);curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			$info = curl_getinfo($ch);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			
			echo $url.' - '.$http_status.'<br/>';
			//ERROR_HANDLING
			if ($output === false) {
				trigger_error('Failed to execute cURL session: ' . curl_error($ch), E_USER_ERROR);
			}
			
			$html = str_get_html($output);
			$spanArray = $html->find('span');
			$usedIndex = null;
			$capIndex = null;
			for($i=0; $i<count($spanArray); $i++){
				if (strpos($spanArray[$i], 'Current storage used:') !== FALSE){
					$usedIndex = $i;
				}
				if (strpos($spanArray[$i], 'Maximum storage allowed:') !== FALSE){
					$capIndex = $i;
					break;
				}
			}
			echo "<tr>";
			echo "<td colspan=2 align=center><table><tr><td>".$cockpitList[$cIndex]."&nbsp&nbsp&nbsp<a href='$url' target='_blank'>Verify</a></td></tr></table></b></td>";
			echo "</tr><tr>";
			/*
			if($usedIndex != null)
				echo "<tr><td>Current Storage Used</td><td>".$spanArray[$usedIndex+1]."</td></tr>";
			else
				echo "<td>Ooops.. Something went wrong. I can't find the index of Current Storage Used.</td>";
			if($capIndex != null)
				echo "<tr><td>Maximum Storage Allowed Used</td><td>".$spanArray[$capIndex+1]."</td></tr>";
			else
				echo "<td>Ooops.. Something went wrong. I can't find the index of Maximum storage allowed.</td>";
			*/
			$storageUsed = (string)$spanArray[$usedIndex+1];
			$storageCap = (string)$spanArray[$capIndex+1];
			//Transforms <span>10 MB</span> to 10
			$storageUsed = filter_var(strip_tags($storageUsed), FILTER_SANITIZE_NUMBER_INT);
			$storageCap = filter_var(strip_tags($storageCap), FILTER_SANITIZE_NUMBER_INT);
			
			$currCockpit = $cockpitList[$cIndex];
			$idUsed = $currCockpit.'storageUsed';
			$idCap = $currCockpit.'storageCap';
			echo "<input type=hidden id='".$idUsed."' value='".$storageUsed."'/>";
			echo "<input type=hidden id='".$idCap."' value='".$storageCap."'/>";
			echo "<td>";
				echo "<table><tr>";
				echo "<td>";
				echo "<canvas id='".$currCockpit."' height='150' width='150'></canvas>";
				echo "</td><td>";
					echo "<table>";
					echo "<tr><td>Legend:</td></tr>";
					echo "<tr><td>Used: </td><td><font color='#0096d5'>".number_format($storageUsed)."MB</font></td></tr>";
					if($storageCap == 0 || $storageCap == 'Not applicable'){
						echo "<tr><td>Capacity: </td><td><font>Not applicable.</font></td></tr>";
						$storageCap = 0;
					}
					else
						echo "<tr><td>Capacity: </td><td><font>".number_format($storageCap)."MB</font></td></tr>";
					$storageFree = $storageCap-$storageUsed;
					if($storageFree <= TRUE_THRESHOLD){
						//Array below - to be used in the subject later
						$cockpitSubject[] = strtoupper($currCockpit); 
						echo "<tr><td>Free Space: </td><td><font color=red>".number_format($storageFree)."MB</font></td></tr>";
						$emailContent .= '<tr>';
						$emailContent .= '<td>'.$currCockpit.'</td><td>'.$storageUsed.'</td><td>'.$storageCap.'</td><td>'.$storageFree.'</td><td><a href="'.$url.'" target="_blank">Verify in PGCockpits</a><br><a href="'.$adminRecycleBin.'" target="_blank">Clear Admin Recycle Bin</a></td>';
						$emailContent .= '</tr>';
					}
					else
						echo "<tr><td>Free Space: </td><td><font color='#32CD32'>".number_format($storageFree)."MB</font></td></tr>";
					echo "</table>";
				echo "</td></tr></table>";
			echo "<script>drawChart('".$currCockpit."');</script>";
			echo "</td>";
			echo "</tr>";
		
			//LOG THE DATA
			$this->sitequota_model->storeData($currCockpit, $storageUsed, $storageCap, $storageFree);
		
			curl_close($ch);
		}
		
		echo "</table>";
		
		//END RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		echo "<font class='myFont'>Page generated in ".$total_time.' seconds.</font><br/><br/>';
		
		if($emailContent != ''){
			$this->email->from('gdpc.webint.bea-l2@hp.com', 'BEA Operations');
			$this->email->to(SITEQUOTA_RECIPIENTS); 
			$this->email->cc('jayr.arenas@hp.com, ronna-may.dimapilis@hp.com'); 
			//$this->email->bcc('them@their-example.com'); 
			$emailSubject = "[WARNING] PGCOCKPITS Site Quota Alert Job 1 - ";
			if(count($cockpitSubject)>0 && count($cockpitSubject)<8){
				//Limiting cockpitSubject count to make sure we don't hit the Subject Limit
				for ($i = 0; $i < count($cockpitSubject); $i++){
					//look ahead to avoid appending comma (,)
					if($i+1 == count($cockpitSubject))
						$emailSubject .= $cockpitSubject[$i];
					else
						$emailSubject .= $cockpitSubject[$i].'|';
				}
			}
			else{
				$emailSubject .= "Multiple Cockpits";
			}
			$this->email->subject($emailSubject);
			$header = "
				Hi.<br/>
				This is to notify you that the following cockpit(s) have reached their Site Quota Limit having <= 5GB of free space: <br/><br/>
			";
			date_default_timezone_set('Asia/Manila');
			$footer = "Please raise an eForm through this <a href='".EFORM_URL."' target='_blank'>link.</a>.<br/>".
			"Run date: ".date("F j, Y, g:i a");
			$tableHeader = "<th>Cockpit</th><th>Used</th><th>Capacity</th><th>Free</th><th>Action</th>";
			$this->email->message($header.'<table border=1>'.$tableHeader.$emailContent.'</table><br/>'.$footer."<br/><i>Total Execution Time: ".$total_time." seconds.</i>");	
			$this->email->send();
			echo $this->email->print_debugger();
			
			
		}
		//RUN OK Email
		else{
			$this->email->from('gdpc.webint.bea-l2@hp.com', 'BEA Operations');
			$this->email->to(SITEQUOTA_RECIPIENTS); 	
			$this->email->cc('jayr.arenas@hp.com, ronna-may.dimapilis@hp.com'); 
			//$this->email->bcc('them@their-example.com'); 
			$this->email->subject("[FYI] PGCOCKPITS Site Quota Run Check - Job ve");
			date_default_timezone_set('Asia/Manila');
			$this->email->message("All Site Quota OK.<br/>This is to notify you of a successful run at: ".date("F j, Y, g:i a")." SGT<br/><i>Total Execution Time: ".$total_time." seconds.</i>");	
			$this->email->send();
			echo $this->email->print_debugger();
		}
		
		
		//END RECORDING LOAD TIME
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>