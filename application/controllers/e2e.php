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
<script src="styles/chartmaster/Chart.js" type="text/javascript"></script>

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
class e2e extends CI_Controller {
	
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
	
	
	function http_auth_get($url,$username,$password){
		$cred = sprintf('Authorization: Basic %s',
		base64_encode("$username:$password") );
		$opts = array(
		'http'=>array(
		'method'=>'GET',
		'header'=>$cred)
		);
		$ctx = stream_context_create($opts);
		$handle = fopen ( $url, 'r', false,$ctx);

		return stream_get_contents($handle);

	}
	
	function getCockpitList(){
	   return array("WEMDOBenelux");
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
			"shavecareceemea",
			"shavecaregc",
			"shavecareglobal",
			"shavecarela",
			"shavecarena",
			"shavecarewe",
			"wehq",
			"wemdobenelux",
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
			"fabriccareceemea",
			"fabriccareglobal",
			"fabriccarela",
			"fabriccarena",
			"fabriccarewe",
			"francemdo",
			"gbsclt",
			"gbsdelivery",
			"gbsitdo",
			"gbsla",
			"homecareasia",
			"homecareglobal",
			"homecarela",
			"homecarena",
			"homecarewe",
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
			"ras",
			"rd",
			"seafricamdo",
			"ukimdo",
			"venezuelamdo"

		);
		
		
	}
	
	
	
	function showHomePage(){
		echo "<title>E2E for PGOne Cockpits</title>";
		echo '<h3>PGOne Cockpits E2E Test</h3>';
		//START RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		//START RECORDING LOAD TIME
		
		$username = PGUSERNAME;
		$password = PGPASSWORD;
		$emailContent = "";
		$cockpitList = $this->getCockpitList();
		$cockpitSubject = array();
		$ch = curl_init();
		
		$ch2 = curl_init();
		curl_setopt($ch2, CURLOPT_URL, "http://pgone.pg.com");
		curl_setopt($ch2, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($ch2, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch2);
		
		for($cIndex = 0; $cIndex<count($cockpitList); $cIndex++){
			
			$url = "http://dcsp.pg.com/bu/".$cockpitList[$cIndex]."/Pages/default.aspx";
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			$output = curl_exec($ch);
			echo $output;
			$info = curl_getinfo($ch);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			//ERROR_HANDLING
			if ($output === false) {
				trigger_error('Failed to execute cURL session: ' . curl_error($ch), E_USER_ERROR);
			}
			
			
		curl_close($ch);
		curl_close($ch2);
	}
	
		//END RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		echo "<font class='myFont'>Page generated in ".$total_time.' seconds.</font><br/><br/>';
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>