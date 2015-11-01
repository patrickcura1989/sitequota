<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class nagger extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
	
		//check user session here
		///if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
		//	$this->logout();
		//}
		
		
		$this->load->library('email');
		$config['protocol'] = 'smtp';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['smtp_host'] = 'smtp3.hp.com';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		
		
		ini_set('max_execution_time', 600);
		$this->showLoginPage('');
		//$this->showTicketQueue("G.ABEA2LVL");
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('/nagger/', 'refresh');
	}
	
	
	
	function showLoginPage($msg){
		if($msg=='Array')
			$msg='';
			
		$template['title'] = 'Nagger Login Page';
		$template['navbar'] = '';
		$template['msg'] = $msg;
		
		//$_SERVER['HTTP_HOST'] returns localhost:82
		//$_SERVER['REQUEST_URI'] returns the remaining after hostname /siren/index.php/welcome
		$site_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		if(strpos($site_url, 'index.php')){
			$form = 'nagger/processLoginLdap'; 
		}
		else{
			$form = 'index.php/nagger/processLoginLdap/';
		}
			
		$template['form'] = $form;
		$template['content'] = $this->load->view('learnmore_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	function processLoginLdap(){
	
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		if($email == "adrian-lester.tan@hp.com" && $password == "12345"){
		
			$this->session->set_userdata('profileImgSrc', 'http://pictures.core.hp.com/images/medium_ap_tanad_6748.jpg');
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('employeeName', 'Adrian Tan');
			$this->session->set_userdata('empNum', '21666748');
			$this->session->set_userdata('teamId', 1);
			redirect("nagger/showHome/Array");
		}
		else{
			
			
				$soapurl = SOAP_CONSTANT;
				$client = new SoapClient($soapurl);
				$params = array(
					'Email' => $email,
					'Password' => $password
				);
				$result = $client->Authenticate($params);
				
				//ADMIN LDAP Bypass login
				
				if($result->Status == 'AUTHENTICATED'){
					$params = array(
						'Hash' => $result->Hash,
						'Email' => $email,
						'Properties' => array(
							'employeeNumber', 'ntUserDomainId', 'managerEmployeeNumber', 'givenName', 'sn'
							)
						);
					
						$result =  $client->GetInfo($params);
						$employeeNumber = $result->Data->employeeNumber;
						$empNumber = $result->Data->employeeNumber;
						$domainName = $result->Data->ntUserDomainId;
						$employeeName = $result->Data->givenName.' '.$result->Data->sn;
						$firstName = $result->Data->givenName;
						$lastName = $result->Data->sn;
						
					//check if user is already registered
					$teamId = $this->sitequota_model->getTeamId($empNumber);	
					if($teamId != null){
						//Construct Profile Image URL////////////////////////////////////////////////////////
						//Get the last 4 digit as based on the naming convention:
						
						//http://pictures.core.hp.com/images/medium_ap_tanad_6748.jpg
						$employeeNumber = substr($employeeNumber, -4);
						
						//DomainIndex is the limit to substring from 0, to ':' based on ASIAPACIFIC:tanad
						$domainIndex = (strlen($domainName)- strpos($domainName, ':'))*-1;
						$domain = substr($domainName, 0, $domainIndex);
						
						//Get tanad from ASIAPACIFIC:tanad
						$domainName = substr($domainName, strpos($domainName,':')+1);
							
						if($domain == 'ASIAPACIFIC')
							$domain = 'ap';
						else if($domain == 'EMEA')
							$domain = 'eu';
						else
							$domain = 'ap';
						
						$profileImgSrc = 'http://pictures.core.hp.com/images/medium_'.$domain.'_'.$domainName.'_'.$employeeNumber.'.jpg';
						
						//Set Session data
						$this->session->set_userdata('profileImgSrc', $profileImgSrc);
						$this->session->set_userdata('email', $email);
						$this->session->set_userdata('employeeName', $employeeName);
						$this->session->set_userdata('empNum', $empNumber);
						$this->session->set_userdata('teamId', $teamId);
						
						
						//Update user info in case use still doesn't have any name or email in the DB
						$this->sitequota_model->updateUserInfo($email, $firstName, $lastName, $empNumber, $domainName);
						
						redirect("nagger/showHome/Array");
					}
					else{
						echo '<font class="myFont">Sorry! You are not yet allowed to view this site. Please contact adrian-lester.tan@hp.com.</font>';
					}
				}
				else{
					echo "Login failed.";
				}
			
			
		}
	}
	
	function api($ticketNumber){
		if($ticketNumber[0] == 'I'){
			
		}
		else if($ticketNumber[0] == 'F'){
			/* Index of data[] Guide
			//Basic Info
			0 - FR#
			1 - Category
			2 - Status
			3 - Title
			4 - Request Priority
			5 - Request Type
			6 - Service
			7 - Service Type
			8 - Configuration Item
			9 - Open Date
			10 - SLA
			11 - Closed Date
			12 - Assignment Group
			13 - Assignee
			14 - Closure Code
			15 - SLA %
			16 - Description
		*/	
			$data = $this->getFulfillmentDetails($ticketNumber);
			echo '<table>';
			echo '<tr><td>'.$data[0].'</td></tr>';
			echo '<tr><td>'.$data[1].'</td></tr>';
			echo '<tr><td>'.$data[2].'</td></tr>';
			echo '<tr><td>'.$data[3].'</td></tr>';
			echo '<tr><td>'.$data[4].'</td></tr>';
			echo '<tr><td>'.$data[5].'</td></tr>';
			echo '<tr><td>'.$data[6].'</td></tr>';
			echo '<tr><td>'.$data[7].'</td></tr>';
			echo '<tr><td>'.$data[8].'</td></tr>';
			echo '<tr><td>'.$data[9].'</td></tr>';
			echo '<tr><td>'.$data[10].'</td></tr>';
			echo '<tr><td>'.$data[11].'</td></tr>';
			echo '<tr><td>'.$data[12].'</td></tr>';
			echo '<tr><td>'.$data[13].'</td></tr>';
			echo '<tr><td>'.$data[14].'</td></tr>';
			echo '<tr><td>'.$data[15].'</td></tr>';
			echo '<tr><td>'.$data[16].'</td></tr>';
			echo '</table>';
			
		}
	}
	
	function getIncidentDetails($im){
		include_once "lib/simplehtmldom/simple_html_dom.php";
		/* Index of data[] Guide
			//Basic Info
			0 - IM#
			1 - Reported
			2 - Impact
			3 - Urgency
			4 - Priority
			5 - Current Status
			
			// Technical Details
			6 - Title
			7 - Target Date
			8 - Affected CI
			9 - CI SLA Def
			10 - CI Max Outage
			11 - Service
			12 - Caller Phone#
			13 - Assignment Group
			14 - Assignee
			15 - Medium Code
			16 - Service Impact
			17 - Priority
			18 - Closure Code
			19 - Relations (related tickets)
			20 - SLA%
			21 - Description
			
			//Latest Additional Fields (Triplets) - 7/2/2014
			22 - Category
			23 - Area
			24 - Sub-Area
			
		*/
	
		$data = array();
		$data[] = $im;
		$ch = curl_init();
		$url = "http://smtracker.pg.com/pls/smtracker/pg_tracker.sm_details?i_id=".$im;
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
		$spanArray = $html->find('span');
		$tripCategory = '';
		$tripArea = '';
		$tripSubArea = '';
		
		for($i=0; $i<count($spanArray); $i++){
		
			if (strpos($spanArray[$i], 'Current Status:') !== FALSE){
				$i++;
				$currentStatus = $spanArray[$i];
				$data[] = trim(strip_tags($currentStatus));
			}
			if (strpos($spanArray[$i], 'Impact:') !== FALSE){
				$i++;
				$impact = $spanArray[$i];
				$data[] = trim(strip_tags($impact));
			}
			if (strpos($spanArray[$i], 'Urgency:') !== FALSE){
				$i++;
				$urgency = $spanArray[$i];
				$data[] = trim(strip_tags($urgency));
			}
			if (strpos($spanArray[$i], 'Priority:') !== FALSE){
				$i++;
				$priority = $spanArray[$i];
				$data[] = trim(strip_tags($priority));
			}
			if (strpos($spanArray[$i], 'Reported:') !== FALSE){
				$i++;
				$reported = $spanArray[$i];
				$data[] = trim(strip_tags($reported));
			}
			if (strpos($spanArray[$i], 'Client Problem/Request') !== FALSE){
				$i++;
				$description = $spanArray[$i];
				
			}
			if (strpos($spanArray[$i], 'Category:') !== FALSE){
				$i++;
				$currentStatus = $spanArray[$i];
				$tripCategory = trim(strip_tags($currentStatus));
			}
			
			if (strpos($spanArray[$i], 'Area:') !== FALSE){
				$i++;
				$currentStatus = $spanArray[$i];
				$tripArea = trim(strip_tags($currentStatus));
			}
			
			if (strpos($spanArray[$i], 'Sub-Area') !== FALSE){
				$i++;
				$currentStatus = $spanArray[$i];
				$tripSubArea = trim(strip_tags($currentStatus));
			}
			
		}
		
		//First, get the <table></table> content within the script tag xtraSection
		$html2 = str_get_html($output);
		$scriptArray = $html2->find('script');
		$technicalDetails = '';
		for($j=0; $j<count($scriptArray); $j++){
			//We can further play around here if we want to get other data being displayed by certain JS,
			//but for now, we only get the technical details part
			if(strpos($scriptArray[$j], 'var xtraSection') != 0){
				$startIndex = strpos($scriptArray[$j], '<table');
				$endIndex = strpos($scriptArray[$j], '</table>');
				$technicalDetails = substr($scriptArray[$j], $startIndex, $endIndex);
				break;
			}
			
		}
		
		
		$html2 = str_get_html($technicalDetails);
		$scriptArray = $html2->find('table');
		$technicalDetails = $scriptArray[0];
		$html2 = str_get_html($technicalDetails);
		$rowArray = $html2->find('tr');
		//since each row would contain two cell data
		
		for($k=0; $k<count($rowArray); $k++){
			$html2 = str_get_html($rowArray[$k]);
			$cellData = $html2->find('td');
			$data[] = trim(strip_tags($cellData[1]));
			
		}
		//FIX for those issues wherein document.write keeps on getting included in the Array
		if($data[6] == 'document.write(openTwistie(xtraSection.label));'){
			unset($data[6]);
			$data = array_values($data);
		}
		curl_close($ch);
		
		
		
		//Compute for SLA %
		//Format is 03-JUL-13 17:00:00
		date_default_timezone_set('America/Danmarkshavn');
		$sla = $data[7];
		
		$tempMonth = $sla[3].$sla[4].$sla[5];
		$sla = $sla[7].$sla[8].'-'.$this->getMonth($tempMonth).'-'.$sla[0].$sla[1].' '.$sla[10].$sla[11].':'.$sla[13].$sla[14].':'.$sla[16].$sla[17];
		//SET SGT
		$slaSGT = date('Y/m/d H:i:s', strtotime($sla));
		$sla = strtotime(date('Y/m/d H:i:s', strtotime($sla)));
		
		
		//Convert SLA to SGT. Store it first in a variable, then override data[7]
		$temp= new DateTime();
		$yr = $slaSGT[0].$slaSGT[1].$slaSGT[2].$slaSGT[3];
		$month = $slaSGT[5].$slaSGT[6]; 
		$day = $slaSGT[8].$slaSGT[9];
		$hr = $slaSGT[11].$slaSGT[12];
		$min = $slaSGT[14].$slaSGT[15];
		$sec = $slaSGT[17].$slaSGT[18];
		$temp->setDate($yr, $month, $day);
		$temp->setTime($hr, $min, $sec);
		//$temp->setTimeZone(new DateTimeZone('Asia/Singapore'));
		$temp->add(new DateInterval('PT8H'));
		$slaSGT = $temp->format('d-M-y H:i:s');
		
		
		$opened = $data[1];
		$tempMonth = $opened[3].$opened[4].$opened[5];
		$opened = $opened[7].$opened[8].'-'.$this->getMonth($tempMonth).'-'.$opened[0].$opened[1].' '.$opened[10].$opened[11].':'.$opened[13].$opened[14].':'.$opened[16].$opened[17];
		//SET SGT
		$openedSGT = date('Y/m/d H:i:s', strtotime($opened));
		$opened = strtotime(date('Y/m/d H:i:s', strtotime($opened)));
		
		//Convert Open to SGT. Store it first in a variable, then override data[7]
		$temp= new DateTime();
		$yr = $openedSGT[0].$openedSGT[1].$openedSGT[2].$openedSGT[3];
		$month = $openedSGT[5].$openedSGT[6]; 
		$day = $openedSGT[8].$openedSGT[9];
		$hr = $openedSGT[11].$openedSGT[12];
		$min = $openedSGT[14].$openedSGT[15];
		$sec = $openedSGT[17].$openedSGT[18];
		$temp->setDate($yr, $month, $day);
		$temp->setTime($hr, $min, $sec);
		//$temp->setTimeZone(new DateTimeZone('Asia/Singapore'));
		$temp->add(new DateInterval('PT8H'));
		$openedSGT = $temp->format('d-M-y H:i:s');
		
		
		
		//Get GMT Timezone
		date_default_timezone_set('Asia/Singapore');
		$sysdate = strtotime(date('Y/m/d H:i:s'));
		//echo 'Sysdate: '.$sysdate.'<br/><br/>';
		
		
		$min1 = ($sysdate - $opened)/60;
		$min2 = ($sla - $opened)/60;
		//echo 'SLA-Sysdate (MIN1): '.$min1.' minutes. ('.$sla.'-'.$sysdate.')<br/>';
		//echo 'SLA-Opened (MIN2): '.$min2.' minutes. ('.$sla.'-'.$opened.')<br/>';
		
		$sla_perc = round(abs(($min1/$min2)*100),2);
		$data[20] = $sla_perc;
		
		
		//convert and set all timezones stored in the DB for SLA and OPENED from GMT to SGT:
		$data[1] = $openedSGT;
		$data[7] = $slaSGT;
		
		//Replace ' for the title
		$data[6] = str_replace("'","",$data[6]);
		$data[6] = str_replace("\xBF","",$data[6]);
		$data[6] = str_replace("\xA0","",$data[6]);
		
		$data[] = str_replace("'", "", trim(strip_tags($description, "<br>")));
		
		$data[] = $tripCategory;
		$data[] = $tripArea;
		$data[] = $tripSubArea;
		
		return $data;
	}
	
	function getFulfillmentDetails($fr){
		include_once "lib/simplehtmldom/simple_html_dom.php";
		$data = array();
		
		$ch = curl_init();
		$url = "http://smtracker.pg.com/pls/smtracker/pg_tracker.fulfillment_details?i_id=".$fr;
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
		$spanArray = $html->find('td');
		
		
		/* Index of data[] Guide
			//Basic Info
			0 - FR#
			1 - Category
			2 - Status
			3 - Title
			4 - Request Priority
			5 - Request Type
			6 - Service
			7 - Service Type
			8 - Configuration Item
			9 - Open Date
			10 - SLA
			11 - Closed Date
			12 - Assignment Group
			13 - Assignee
			14 - Closure Code
			15 - SLA %
			16 - Description
		*/
		
		
		$data[] = $fr;
		$data[] = trim(strip_tags($spanArray[1]));
		$data[] = trim(strip_tags($spanArray[3]));
		$data[] = trim(strip_tags($spanArray[5]));
		$data[] = trim(strip_tags($spanArray[13]));
		$data[] = trim(strip_tags($spanArray[15]));
		$data[] = trim(strip_tags($spanArray[17]));
		$data[] = trim(strip_tags($spanArray[19]));
		$data[] = trim(strip_tags($spanArray[21]));
		$data[] = trim(strip_tags($spanArray[27]));
		$data[] = trim(strip_tags($spanArray[29]));
		$data[] = trim(strip_tags($spanArray[31]));
		$data[] = trim(strip_tags($spanArray[33]));
		$data[] = trim(strip_tags($spanArray[35]));
		$data[] = trim(strip_tags($spanArray[39]));
		//I don't know why I need to store this twice. :( Index problems
		$data[] = str_replace("'","", trim(strip_tags($spanArray[7])));
		$data[] = str_replace("'","", trim(strip_tags($spanArray[7])));
		
		curl_close($ch);
		//////////////////////////////////////////////////////////////////////////
		//Compute for SLA %
		//Format is 03-JUL-13 17:00:00
		date_default_timezone_set('America/Danmarkshavn');
		$sla = $data[10];
		$tempMonth = $sla[3].$sla[4].$sla[5];
		$sla = $sla[7].$sla[8].'-'.$this->getMonth($tempMonth).'-'.$sla[0].$sla[1].' '.$sla[10].$sla[11].':'.$sla[13].$sla[14].':'.$sla[16].$sla[17];
		//SET SGT
		$slaSGT = date('Y/m/d H:i:s', strtotime($sla));
		
		$sla = strtotime(date('Y/m/d H:i:s', strtotime($sla)));
		
		//Convert SLA to SGT. Store it first in a variable, then override data[]
		$temp= new DateTime();
		$yr = $slaSGT[0].$slaSGT[1].$slaSGT[2].$slaSGT[3];
		$month = $slaSGT[5].$slaSGT[6]; 
		$day = $slaSGT[8].$slaSGT[9];
		$hr = $slaSGT[11].$slaSGT[12];
		$min = $slaSGT[14].$slaSGT[15];
		$sec = $slaSGT[17].$slaSGT[18];
		$temp->setDate($yr, $month, $day);
		$temp->setTime($hr, $min, $sec);
		//$temp->setTimeZone(new DateTimeZone('Asia/Singapore'));
		$temp->add(new DateInterval('PT8H'));
		$slaSGT = $temp->format('d-M-y H:i:s');
		
		$opened = $data[9];
		$tempMonth = $opened[3].$opened[4].$opened[5];
		$opened = $opened[7].$opened[8].'-'.$this->getMonth($tempMonth).'-'.$opened[0].$opened[1].' '.$opened[10].$opened[11].':'.$opened[13].$opened[14].':'.$opened[16].$opened[17];
		//SET SGT
		$openedSGT = date('Y/m/d H:i:s', strtotime($opened));
		$opened = strtotime(date('Y/m/d H:i:s', strtotime($opened)));
		
		//Convert SLA to SGT. Store it first in a variable, then override data[]
		$temp= new DateTime();
		$yr = $openedSGT[0].$openedSGT[1].$openedSGT[2].$openedSGT[3];
		$month = $openedSGT[5].$openedSGT[6]; 
		$day = $openedSGT[8].$openedSGT[9];
		$hr = $openedSGT[11].$openedSGT[12];
		$min = $openedSGT[14].$openedSGT[15];
		$sec = $openedSGT[17].$openedSGT[18];
		$temp->setDate($yr, $month, $day);
		$temp->setTime($hr, $min, $sec);
		//$temp->setTimeZone(new DateTimeZone('Asia/Singapore'));
		$temp->add(new DateInterval('PT8H'));
		$openedSGT = $temp->format('d-M-y H:i:s');
		
		
		
		//Get GMT Timezone
		date_default_timezone_set('Asia/Singapore');
		$sysdate = strtotime(date('Y/m/d H:i:s'));
		//echo 'Sysdate: '.$sysdate.'<br/><br/>';
		
		
		$min1 = ($sysdate - $opened)/60;
		$min2 = ($sla - $opened)/60;
		//echo 'SLA-Sysdate (MIN1): '.$min1.' minutes. ('.$sla.'-'.$sysdate.')<br/>';
		//echo 'SLA-Opened (MIN2): '.$min2.' minutes. ('.$sla.'-'.$opened.')<br/>';
		
		$sla_perc = round(abs(($min1/$min2)*100),2);
		//echo $sla_perc.'<br/>';
		
		$data[15] = $sla_perc;
		//convert and set all timezones stored in the DB for SLA and OPENED from GMT to SGT:
		$data[9] = $openedSGT;
		$data[10] = $slaSGT;
		
		//Remove ' in title to prevent any SQL error
		$data[3] = str_replace("'","",$data[3]);
		$data[3] = str_replace("\xBF","",$data[3]);
		$data[3] = str_replace("\xA0","",$data[3]);
		
		return $data;
	}
	
	function getProblemDetails($fr){
		include_once "lib/simplehtmldom/simple_html_dom.php";
		$data = array();
		$data[] = $fr;
		$ch = curl_init();
		$url = "http://smtracker.pg.com/pls/smtracker/pg_tracker.problem_details?i_id=".$fr;
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
		$spanArray = $html->find('td');
		
		
		/* Index of data[] Guide
			//Basic Info
			0 - FR#
			1 - Category
			2 - Status
			3 - Title
			4 - Request Priority
			5 - Request Type
			6 - Service
			7 - Service Type
			8 - Configuration Item
			9 - Open Date
			10 - SLA
			11 - Closed Date
			12 - Assignment Group
			13 - Assignee
			14 - Closure Code
			15 - SLA %
		*/
		
		
		
		$data[] = trim(strip_tags($spanArray[1]));
		$data[] = trim(strip_tags($spanArray[3]));
		$data[] = trim(strip_tags($spanArray[5]));
		$data[] = trim(strip_tags($spanArray[13]));
		$data[] = trim(strip_tags($spanArray[15]));
		$data[] = trim(strip_tags($spanArray[17]));
		$data[] = trim(strip_tags($spanArray[19]));
		$data[] = trim(strip_tags($spanArray[21]));
		$data[] = trim(strip_tags($spanArray[27]));
		$data[] = trim(strip_tags($spanArray[29]));
		$data[] = trim(strip_tags($spanArray[31]));
		$data[] = trim(strip_tags($spanArray[33]));
		$data[] = trim(strip_tags($spanArray[35]));
		$data[] = trim(strip_tags($spanArray[39]));
		
		curl_close($ch);
		//////////////////////////////////////////////////////////////////////////
		//Compute for SLA %
		//Format is 03-JUL-13 17:00:00
		date_default_timezone_set('America/Danmarkshavn');
		$sla = $data[10];
		$tempMonth = $sla[3].$sla[4].$sla[5];
		$sla = $sla[7].$sla[8].'-'.$this->getMonth($tempMonth).'-'.$sla[0].$sla[1].' '.$sla[10].$sla[11].':'.$sla[13].$sla[14].':'.$sla[16].$sla[17];
		//SET SGT
		$slaSGT = date('Y/m/d H:i:s', strtotime($sla));
		
		$sla = strtotime(date('Y/m/d H:i:s', strtotime($sla)));
		
		//Convert SLA to SGT. Store it first in a variable, then override data[]
		$temp= new DateTime();
		$yr = $slaSGT[0].$slaSGT[1].$slaSGT[2].$slaSGT[3];
		$month = $slaSGT[5].$slaSGT[6]; 
		$day = $slaSGT[8].$slaSGT[9];
		$hr = $slaSGT[11].$slaSGT[12];
		$min = $slaSGT[14].$slaSGT[15];
		$sec = $slaSGT[17].$slaSGT[18];
		$temp->setDate($yr, $month, $day);
		$temp->setTime($hr, $min, $sec);
		//$temp->setTimeZone(new DateTimeZone('Asia/Singapore'));
		$temp->add(new DateInterval('PT8H'));
		$slaSGT = $temp->format('d-M-y H:i:s');
		
		$opened = $data[9];
		$tempMonth = $opened[3].$opened[4].$opened[5];
		$opened = $opened[7].$opened[8].'-'.$this->getMonth($tempMonth).'-'.$opened[0].$opened[1].' '.$opened[10].$opened[11].':'.$opened[13].$opened[14].':'.$opened[16].$opened[17];
		//SET SGT
		$openedSGT = date('Y/m/d H:i:s', strtotime($opened));
		$opened = strtotime(date('Y/m/d H:i:s', strtotime($opened)));
		
		//Convert SLA to SGT. Store it first in a variable, then override data[]
		$temp= new DateTime();
		$yr = $openedSGT[0].$openedSGT[1].$openedSGT[2].$openedSGT[3];
		$month = $openedSGT[5].$openedSGT[6]; 
		$day = $openedSGT[8].$openedSGT[9];
		$hr = $openedSGT[11].$openedSGT[12];
		$min = $openedSGT[14].$openedSGT[15];
		$sec = $openedSGT[17].$openedSGT[18];
		$temp->setDate($yr, $month, $day);
		$temp->setTime($hr, $min, $sec);
		//$temp->setTimeZone(new DateTimeZone('Asia/Singapore'));
		$temp->add(new DateInterval('PT8H'));
		$openedSGT = $temp->format('d-M-y H:i:s');
		
		
		
		//Get GMT Timezone
		date_default_timezone_set('Asia/Singapore');
		$sysdate = strtotime(date('Y/m/d H:i:s'));
		//echo 'Sysdate: '.$sysdate.'<br/><br/>';
		
		
		$min1 = ($sysdate - $opened)/60;
		$min2 = ($sla - $opened)/60;
		//echo 'SLA-Sysdate (MIN1): '.$min1.' minutes. ('.$sla.'-'.$sysdate.')<br/>';
		//echo 'SLA-Opened (MIN2): '.$min2.' minutes. ('.$sla.'-'.$opened.')<br/>';
		
		$sla_perc = round(abs(($min1/$min2)*100),2);
		//echo $sla_perc.'<br/>';
		
		
		
		$data[15] = $sla_perc;
		//convert and set all timezones stored in the DB for SLA and OPENED from GMT to SGT:
		$data[9] = $openedSGT;
		$data[10] = $slaSGT;
		
		//Remove ' in title to prevent any SQL error
		$data[3] = str_replace("'","",$data[3]);
		
		return $data;
	}
	
	function getMonth($string){
		if($string == 'Jan')
			return '01';
		else if($string == 'Feb')
			return '02';
		else if($string == 'Mar')
			return '03';
		else if($string == 'Apr')
			return '04';
		else if($string == 'May')
			return '05';
		else if($string == 'Jun')
			return '06';	
		else if($string == 'Jul')
			return '07';	
		else if($string == 'Aug')
			return '08';
		else if($string == 'Sep')
			return '09';
		else if($string == 'Oct')
			return '10';
		else if($string == 'Nov')
			return '11';
		else if($string == 'Dec')
			return '12';
	}
	
	function getImInSm($queue){
		include_once "lib/simplehtmldom/simple_html_dom.php";
		//submit form in smtracker
		$url = "http://smtracker.pg.com/pls/smtracker/pg_tracker.inc_groups";
		
		$datatopost = array (
			"i_group" => $queue
		);
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//echo $output;
		//ERROR_HANDLING
		if ($output === false) {
			trigger_error('Failed to execute cURL session: ' . curl_error($ch), E_USER_ERROR);
		}
		
		$html = str_get_html($output);
		$anchorArray = $html->find('a');
		//echo "Tickets in Queue of ".$queue.":<br/>";
		//echo "<ul>";
		$arr = array();
		for($i=0; $i<count($anchorArray); $i++){
			if(strpos($anchorArray[$i], "IM")){
				$pos = strpos($anchorArray[$i], "IM");
				$string = substr($anchorArray[$i], $pos, 10);
				$arr[] = $string;
				//echo "<li>".$string."</li>";
			}
		}
		//echo "</ul>";
			
		
		curl_close($ch);
		//echo $output;
		return $arr;
	}
	
	function getFrInSm($queue){
		include_once "lib/simplehtmldom/simple_html_dom.php";
		//submit form in smtracker
		$url = "http://smtracker.pg.com/pls/smtracker/pg_tracker.ful_groups";
		
		$datatopost = array (
			"i_group" => $queue
		);
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//echo $output;
		//ERROR_HANDLING
		if ($output === false) {
			trigger_error('Failed to execute cURL session: ' . curl_error($ch), E_USER_ERROR);
		}
		
		$html = str_get_html($output);
		$anchorArray = $html->find('a');
		//echo "Tickets in Queue of ".$queue.":<br/>";
		//echo "<ul>";
		$arr = array();
		for($i=0; $i<count($anchorArray); $i++){
			if(strpos($anchorArray[$i], "FR")){
				$pos = strpos($anchorArray[$i], "FR");
				$string = substr($anchorArray[$i], $pos, 10);
				$arr[] = $string;
				//echo "<li>".$string."</li>";
			}
		}
		//echo "</ul>";
			
		
		curl_close($ch);
		//echo $output;
		return $arr;
	}
	
	function labs(){
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		$template['title'] = 'Nagger - Labs';
		$template['content'] = $this->load->view('labs_view',$template,true);
		$this->load->view('template_main', $template);
	}
	
	
	function showHome($msg){
		
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		
		if($msg == 'Array'){
			$msg = '';
		}
		//START RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		//START RECORDING LOAD TIME
		
				
		$template['title'] = 'Nagger Home Page';
		$template['navbar'] = '';
		$template['msg'] = $msg;
		
		//$template['tableData'] = $header.$emailContent.$footer;
		
		//$_SERVER['HTTP_HOST'] returns localhost:82
		//$_SERVER['REQUEST_URI'] returns the remaining after hostname /siren/index.php/welcome
		$site_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		if(strpos($site_url, 'index.php/nagger')){
			$form = 'nagger/processAddIm'; 
		}
		else{
			$form = 'index.php/nagger/processAddIm';
		}
		
		//SYNC IMs
		//$this->syncAllIm();
		
		$template['imArr'] = $this->sitequota_model->getImListQueue();
		$template['frArr'] = $this->sitequota_model->getFrListQueue();
		$template['queueListIm'] = $this->sitequota_model->getDistinctQueueIm();
		$template['queueListFr'] = $this->sitequota_model->getDistinctQueueFr();
		
		//END RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		$template['page_load_time'] = $total_time;
		$template2['queue'] = 'G.ABEA2LVL';
		//$template['queueloader'] = $this->load->view('showqueue_view', $template2, true);
		$template['content'] = $this->load->view('home_view', $template, true);
		$this->load->view('template_main', $template);
		
		
	}
	
	function showMyTickets($msg){
		
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		
		if($msg == 'Array'){
			$msg = '';
		}
		//START RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		//START RECORDING LOAD TIME
		
				
		$template['title'] = 'Nagger My Tickets Page';
		$template['navbar'] = '';
		$template['msg'] = $msg;
		
		//$template['tableData'] = $header.$emailContent.$footer;
		
		//$_SERVER['HTTP_HOST'] returns localhost:82
		//$_SERVER['REQUEST_URI'] returns the remaining after hostname /siren/index.php/welcome
		$site_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		if(strpos($site_url, 'index.php/nagger')){
			$form = 'nagger/processAddIm'; 
		}
		else{
			$form = 'index.php/nagger/processAddIm';
		}
		
		//SYNC IMs
		//$this->syncAllIm();
		
		
		$template['imArr'] = $this->sitequota_model->getImListUser();
		$template['frArr'] = $this->sitequota_model->getFrListUser();
		$template['queueListIm'] = $this->sitequota_model->getDistinctQueueUserIm();
		$template['queueListFr'] = $this->sitequota_model->getDistinctQueueUserFr();
		
		//END RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		$template['page_load_time'] = $total_time;
		$template2['queue'] = 'G.ABEA2LVL';
		//$template['queueloader'] = $this->load->view('showqueue_view', $template2, true);
		$template['content'] = $this->load->view('mytickets_view', $template,true);
		$this->load->view('template_main', $template);
		
		
	}
	
	
	function syncAllCpgtIMfromSMtoDB($owningTeam){
		$arr = $this->getImInSm('G.ACPGTSM');
		
		for($i=0; $i<count($arr); $i++){
			if(!$this->sitequota_model->doesImExistAuto($arr[$i], $owningTeam)){
				$data = $this->getIncidentDetails($arr[$i]);
				$this->sitequota_model->insertImAuto($data, $owningTeam, '21963640');
				echo 'Inserted: '.$data[0].'<br/>';
				
			}
		}
	}
	
	function autoAddIm($owningTeam){
		$owningTeamQueueList = $this->sitequota_model->getOwningTeamQueueList($owningTeam);
		if($owningTeamQueueList != null){
			//get random (first result) member in the team to temporarily assign the ticket.
			//order by IM Manager to ensure we first try to get the candidate owner as the IM SPOC
			$candidateOwner = $this->sitequota_model->getCandidateOwner($owningTeam);
			foreach($owningTeamQueueList as $row){
				$arr = $this->getImInSm($row->queue);
				for($i=0; $i<count($arr); $i++){
					if(!$this->sitequota_model->doesImExistAuto($arr[$i], $owningTeam)){
						$data = $this->getIncidentDetails($arr[$i]);
						$this->sitequota_model->insertImAuto($data, $owningTeam, $candidateOwner);
						echo 'Inserted: '.$data[0].'<br/>';
						
					}
				}
			}
		}
	}
	
	function autoAddFr($owningTeam){
		$owningTeamQueueList = $this->sitequota_model->getOwningTeamQueueList($owningTeam);
		if($owningTeamQueueList != null){
			//get random (first result) member in the team to temporarily assign the ticket.
			//order by IM Manager to ensure we first try to get the candidate owner as the IM SPOC
			$candidateOwner = $this->sitequota_model->getCandidateOwner($owningTeam);
			foreach($owningTeamQueueList as $row){
				$arr = $this->getFrInSm($row->queue);
				for($i=0; $i<count($arr); $i++){
					if(!$this->sitequota_model->doesFrExistAuto($arr[$i], $owningTeam)){
						$data = $this->getFulfillmentDetails($arr[$i]);
						$this->sitequota_model->insertFrAuto($data, $owningTeam, $candidateOwner);
						echo 'Inserted: '.$data[0].'<br/>';
						
					}
				}
			}
		}
	}
	
	
	
	function processAddIm(){
		
			$submit = $this->input->post('submit');
			
			if($submit == 'Extract'){
				$this->form_validation->set_rules('im', 'Incident #', 'required');
				if ($this->form_validation->run() == FALSE){
					$this->showHome('');
				}
				else{
				$ticket = $this->input->post('im');
				
				if($ticket[0] == 'I'){
					
					$data = $this->getIncidentDetails($ticket);
					$imData = '<br/><font class="myFont">Extracted Details:</font><br/>';
					$imData .=  '<table class="myTable">';
					$imData .=  "<tr><td colspan=2><b>Basic Info</b></td></tr>";
					$imData .=  "<tr><td><b>IM#</b></td><td>".$data[0]."</td></tr>";
					$imData .=  "<tr><td><b>Title</b></td><td>".$data[6]."</td></tr>";
					$imData .=  "<tr><td><b>Current Status</b></td><td>".$data[5]."</td></tr>";
					$imData .=  "<tr><td><b>Opened Date</b></td><td>".$data[1]."</td></tr>";
					$imData .=  "<tr><td><b>Target Date</b></td><td>".$data[7]."</td></tr>";
					$imData .=  "<tr><td><b>Affected CI</b></td><td>".$data[8]."</td></tr>";
					$imData .=  "<tr><td><b>Assignment Group</b></td><td>".$data[13]."</td></tr>";
					$imData .=  "<tr><td><b>Assignee</b></td><td>".$data[14]."</td></tr>";
					$imData .=  "<tr><td><b>Impact</b></td><td>".$data[2]."</td></tr>";
					$imData .=  "<tr><td><b>Urgency</b></td><td>".$data[3]."</td></tr>";
					$imData .=  "<tr><td><b>Priority</b></td><td>".$data[4]."</td></tr>";
					$imData .=  "<tr><td><b>SLA%</b></td><td>".$data[20]."</td></tr>";
					$imData .= "</table>";
					$this->showHome($imData);
				}
				else if($ticket[0] == 'F'){
					$data = $this->getFulfillmentDetails($ticket);
					/*
					//Basic Info
						0 - FR#
						1 - Category
						2 - Status
						3 - Title
						4 - Request Priority
						5 - Request Type
						6 - Service
						7 - Service Type
						8 - Configuration Item
						9 - Open Date
						10 - SLA
						11 - Closed Date
						12 - Assignment Group
						13 - Assignee
						14 - Closure Code
						15 - SLA %
					*/
					$imData = '<br/><font class="myFont">Extracted Details:</font><br/>';
					$imData .=  '<table class="myTable">';
					$imData .=  "<tr><td colspan=2><b>Basic Info</b></td></tr>";
					$imData .=  "<tr><td><b>FR#</b></td><td>".$data[0]."</td></tr>";
					$imData .=  "<tr><td><b>Title</b></td><td>".$data[3]."</td></tr>";
					$imData .=  "<tr><td><b>Current Status</b></td><td>".$data[2]."</td></tr>";
					$imData .=  "<tr><td><b>Opened Date</b></td><td>".$data[9]."</td></tr>";
					$imData .=  "<tr><td><b>Target Date</b></td><td>".$data[10]."</td></tr>";
					$imData .=  "<tr><td><b>Affected CI</b></td><td>".$data[8]."</td></tr>";
					$imData .=  "<tr><td><b>Assignment Group</b></td><td>".$data[12]."</td></tr>";
					$imData .=  "<tr><td><b>Assignee</b></td><td>".$data[13]."</td></tr>";
					$imData .=  "<tr><td><b>Priority</b></td><td>".$data[4]."</td></tr>";
					$imData .=  "<tr><td><b>Service</b></td><td>".$data[6]."</td></tr>";
					$imData .=  "<tr><td><b>Service Type</b></td><td>".$data[7]."</td></tr>";
					$imData .=  "<tr><td><b>SLA%</b></td><td>".$data[15]."</td></tr>";
					$imData .= "</table>";
					$this->showHome($imData);
				}
				else if($ticket[0] == 'P'){
					$data = $this->getProblemDetails($ticket);
					/*
					//Basic Info
						0 - FR#
						1 - Category
						2 - Status
						3 - Title
						4 - Request Priority
						5 - Request Type
						6 - Service
						7 - Service Type
						8 - Configuration Item
						9 - Open Date
						10 - SLA
						11 - Closed Date
						12 - Assignment Group
						13 - Assignee
						14 - Closure Code
						15 - SLA %
					*/
					$imData = '<br/><font class="myFont">Extracted Details:</font><br/>';
					$imData .=  '<table class="myTable">';
					$imData .=  "<tr><td colspan=2><b>Basic Info</b></td></tr>";
					$imData .=  "<tr><td><b>FR#</b></td><td>".$data[0]."</td></tr>";
					$imData .=  "<tr><td><b>Title</b></td><td>".$data[3]."</td></tr>";
					$imData .=  "<tr><td><b>Current Status</b></td><td>".$data[2]."</td></tr>";
					$imData .=  "<tr><td><b>Opened Date</b></td><td>".$data[9]."</td></tr>";
					$imData .=  "<tr><td><b>Target Date</b></td><td>".$data[10]."</td></tr>";
					$imData .=  "<tr><td><b>Affected CI</b></td><td>".$data[8]."</td></tr>";
					$imData .=  "<tr><td><b>Assignment Group</b></td><td>".$data[12]."</td></tr>";
					$imData .=  "<tr><td><b>Assignee</b></td><td>".$data[13]."</td></tr>";
					$imData .=  "<tr><td><b>Priority</b></td><td>".$data[4]."</td></tr>";
					$imData .=  "<tr><td><b>Service</b></td><td>".$data[6]."</td></tr>";
					$imData .=  "<tr><td><b>Service Type</b></td><td>".$data[7]."</td></tr>";
					$imData .=  "<tr><td><b>SLA%</b></td><td>".$data[15]."</td></tr>";
					$imData .= "</table>";
					$this->showHome($imData);
				}
			}
			}
			else if($submit == 'Add'){
				//check if IM already exist in the master list
				$ticket = $this->input->post('im');
				if($ticket[0] == 'I'){
					
					if(!$this->sitequota_model->doesImExist($ticket)){
						$data = $this->getIncidentDetails($ticket);
						$this->sitequota_model->insertIm($data);
						redirect("nagger/showHome/Array");
					}
					else{
						$this->showHome('<font class="myFont" color=red>'.$this->input->post('im').' already exists in the master list! </font>');
					}
				}
				else if($ticket[0] == 'F'){
					if(!$this->sitequota_model->doesFrExist($ticket)){
						$data = $this->getFulfillmentDetails($ticket);
						$this->sitequota_model->insertFr($data);
						redirect("nagger/showHome/Array");
					}
					else{
						$this->showHome('<font class="myFont" color=red>'.$ticket.' already exists in the master list! </font>');
					}
				}
			}
			
			else if($submit == 'Get IM'){
				$this->form_validation->set_rules('queue', 'Queue', 'required');
				if ($this->form_validation->run() == FALSE){
					$this->showHome('');
				}
				else{
					$arr = $this->getImInSm($this->input->post('queue'));
					$newCount = 0;
					$ticketString = '';
					for($i=0; $i<count($arr); $i++){
						if(!$this->sitequota_model->doesImExist($arr[$i])){
							$data = $this->getIncidentDetails($arr[$i]);
							$ticketString .= '<tr><td><font id="panelSmallFont">'.$data[0].' - '.$data[6].'</font></td></tr>';
							$this->sitequota_model->insertIm($data);
							$newCount++;
						}
					}
					$msg = '<font class="myFont" color="#66CC66">'.$newCount.' ticket(s) newly added.</font><br/><br/>';
					$msg .= '<table>';
					$msg .= $ticketString;
					$msg .= '</table>';
					$this->showHome($msg);
					
				}
			}
			
			else if($submit == 'Get FR'){
				$this->form_validation->set_rules('queue', 'Queue', 'required');
				if ($this->form_validation->run() == FALSE){
					$this->showHome('');
				}
				else{
					$arr = $this->getFrInSm($this->input->post('queue'));
					$newCount = 0;
					$ticketString = '';
					for($i=0; $i<count($arr); $i++){
						if(!$this->sitequota_model->doesFrExist($arr[$i])){
							$data = $this->getFulfillmentDetails($arr[$i]);
							$ticketString .= '<tr><td><font id="panelSmallFont">'.$data[0].' - '.$data[3].'</font></td></tr>';
							$this->sitequota_model->insertFr($data);
							$newCount++;
						}
					}
					$msg = '<font class="myFont" color="#66CC66">'.$newCount.' ticket(s) newly added.</font><br/><br/>';
					$msg .= '<table>';
					$msg .= $ticketString;
					$msg .= '</table>';
					$this->showHome($msg);
				}
			}
			
			else if($submit == 'Bulk Add'){
			
			
			}
			
		
	}
	
	function syncAllIm(){
		$imArr = $this->sitequota_model->getImList();
		
		foreach($imArr as $row){
			$data = $this->getIncidentDetails($row->incident_number);
			
			/* Index of data[] Guide
			//Basic Info
			0 - IM#
			1 - Reported
			2 - Impact
			3 - Urgency
			4 - Priority
			5 - Current Status
			
			// Technical Details
			6 - Title
			7 - Target Date
			8 - Affected CI
			9 - CI SLA Def
			10- CI Max Outage
			11 - Service
			12 - Caller Phone#
			13 - Assignment Group
			14 - Assignee
			15 - Medium Code
			16 - Service Impact
			17 - Priority
			18 - Closure Code
			19 - Relations (related tickets)
			*/
			
			//UPDATE the DB
			$this->sitequota_model->updateIm($data[0], $data);
		}
		
	}
	
	function syncImLimit10(){
		$imArr = $this->sitequota_model->getImLimit10();
		
		foreach($imArr as $row){
			$data = $this->getIncidentDetails($row->incident_number);
			
			/* Index of data[] Guide
			//Basic Info
			0 - IM#
			1 - Reported
			2 - Impact
			3 - Urgency
			4 - Priority
			5 - Current Status
			
			// Technical Details
			6 - Title
			7 - Target Date
			8 - Affected CI
			9 - CI SLA Def
			10- CI Max Outage
			11 - Service
			12 - Caller Phone#
			13 - Assignment Group
			14 - Assignee
			15 - Medium Code
			16 - Service Impact
			17 - Priority
			18 - Closure Code
			19 - Relations (related tickets)
			*/
			
			//UPDATE the DB
			$this->sitequota_model->updateImNew($data[0], $data);
			
		}
		
	}
	
	
	function syncOwningTeamIm($owningTeam){
		$imArr = $this->sitequota_model->getImListOwningTeam($owningTeam);
		
		foreach($imArr as $row){
			$data = $this->getIncidentDetails($row->incident_number);
			
			/* Index of data[] Guide
			//Basic Info
			0 - IM#
			1 - Reported
			2 - Impact
			3 - Urgency
			4 - Priority
			5 - Current Status
			
			// Technical Details
			6 - Title
			7 - Target Date
			8 - Affected CI
			9 - CI SLA Def
			10- CI Max Outage
			11 - Service
			12 - Caller Phone#
			13 - Assignment Group
			14 - Assignee
			15 - Medium Code
			16 - Service Impact
			17 - Priority
			18 - Closure Code
			19 - Relations (related tickets)
			*/
			
			//UPDATE the DB
			$this->sitequota_model->updateImFromJob($data[0], $data, $owningTeam);
			
		}
		
	}
	
	function syncQueueIm(){
		//used in Manual Syncing of tickets when the user is logged in
		$imArr = $this->sitequota_model->getImListQueue();
		
		foreach($imArr as $row){
			
			$data = $this->getIncidentDetails($row->incident_number);
			
			/* Index of data[] Guide
			//Basic Info
			0 - IM#
			1 - Reported
			2 - Impact
			3 - Urgency
			4 - Priority
			5 - Current Status
			
			// Technical Details
			6 - Title
			7 - Target Date
			8 - Affected CI
			9 - CI SLA Def
			10- CI Max Outage
			11 - Service
			12 - Caller Phone#
			13 - Assignment Group
			14 - Assignee
			15 - Medium Code
			16 - Service Impact
			17 - Priority
			18 - Closure Code
			19 - Relations (related tickets)
			*/
			
			//UPDATE the DB
			$this->sitequota_model->updateIm($data[0], $data);
		}
		
	}
	
	function syncAllFr(){
		$frArr = $this->sitequota_model->getFrList();
		
		foreach($frArr as $row){
			$data = $this->getFulfillmentDetails($row->fulfillment_number);
			
			/* Index of data[] Guide
			//Basic Info
			0 - FR#
			1 - Category
			2 - Status
			3 - Title
			4 - Request Priority
			5 - Request Type
			6 - Service
			7 - Service Type
			8 - Configuration Item
			9 - Open Date
			10 - SLA
			11 - Closed Date
			12 - Assignment Group
			13 - Assignee
			14 - Closure Code
			15 - SLA %
			*/
			
			//UPDATE the DB
			$this->sitequota_model->updateFr($data[0], $data);
		}
	}
	
	function syncFrLimit10(){
		$frArr = $this->sitequota_model->getFrLimit10();
		
		foreach($frArr as $row){
			$data = $this->getFulfillmentDetails($row->fulfillment_number);
			
			/* Index of data[] Guide
			//Basic Info
			0 - FR#
			1 - Category
			2 - Status
			3 - Title
			4 - Request Priority
			5 - Request Type
			6 - Service
			7 - Service Type
			8 - Configuration Item
			9 - Open Date
			10 - SLA
			11 - Closed Date
			12 - Assignment Group
			13 - Assignee
			14 - Closure Code
			15 - SLA %
			*/
			
			//UPDATE the DB
			$this->sitequota_model->updateFrNew($data[0], $data);
		}
	}
	
	function syncOwningTeamFr($owningTeam){
		$frArr = $this->sitequota_model->getFrListOwningTeam($owningTeam);
		
		foreach($frArr as $row){
			$data = $this->getFulfillmentDetails($row->fulfillment_number);
			
			/* Index of data[] Guide
			//Basic Info
			0 - FR#
			1 - Category
			2 - Status
			3 - Title
			4 - Request Priority
			5 - Request Type
			6 - Service
			7 - Service Type
			8 - Configuration Item
			9 - Open Date
			10 - SLA
			11 - Closed Date
			12 - Assignment Group
			13 - Assignee
			14 - Closure Code
			15 - SLA %
			*/
			
			//UPDATE the DB
			$this->sitequota_model->updateFrFromJob($data[0], $data, $owningTeam);
		}
	}
	
	function syncQueueFr(){
		//used in Manual Syncing of tickets when the user is logged in
		$frArr = $this->sitequota_model->getFrListQueue();
		
		foreach($frArr as $row){
			$data = $this->getFulfillmentDetails($row->fulfillment_number);
			
			/* Index of data[] Guide
			//Basic Info
			0 - FR#
			1 - Category
			2 - Status
			3 - Title
			4 - Request Priority
			5 - Request Type
			6 - Service
			7 - Service Type
			8 - Configuration Item
			9 - Open Date
			10 - SLA
			11 - Closed Date
			12 - Assignment Group
			13 - Assignee
			14 - Closure Code
			15 - SLA %
			*/
			
			//UPDATE the DB
			$this->sitequota_model->updateFr($data[0], $data);
		}
	}
	
	function manualSyncIm(){
		$this->syncQueueIm();
		redirect("nagger/showHome/Array");
	}
	
	function manualSyncFr(){
		$this->syncQueueFr();
		redirect("nagger/showHome/Array");
	}
	
	function batchRun(){
		$this->syncAllFr();
		$this->syncAllIm();
	}
	
	function showHandover($msg){
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		
		if($msg == 'Array'){
			$msg = '';
		}
		
		//START RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		//START RECORDING LOAD TIME
		
		//Perform a Resync First from SM to Master List
		//$this->syncAllIm();
		
		$template['queueListIm'] = $this->sitequota_model->getDistinctQueueIm();
		$template['queueListFr'] = $this->sitequota_model->getDistinctQueueFr();
		
		//END RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		$template['page_load_time'] = $total_time;
		
		$this->session->set_userdata("teamPriorityFlag", false);
		
		$template['title'] = 'Nagger Handover Page';
		$template['imArr'] = $this->sitequota_model->getImListQueue();
		$template['frArr'] = $this->sitequota_model->getFrListQueue();
		$template['content'] = $this->load->view('handover_view', $template,true);
		$this->load->view('template_main', $template);
		
	}
	
	function showMyTeam($msg){
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		
		if($msg == 'Array'){
			$msg = '';
		}
		
		$template['title'] = 'Nagger My Team Page';
		$template['teamMembers'] = $this->sitequota_model->getMyTeammates();
		$template['teamName'] = $this->sitequota_model->getTeamName($this->session->userdata('teamId'));
		$template['content'] = $this->load->view('myteam_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	function showFollowup($msg){
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		if($msg == 'Array'){
			$msg = '';
		}
		
		//START RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		//START RECORDING LOAD TIME
		
		//Perform a Resync First from SM to Master List
		//$this->syncAllIm();
		
		$template['queueListIm'] = $this->sitequota_model->getDistinctQueueIm();
		$template['queueListFr'] = $this->sitequota_model->getDistinctQueueFr();
		$template['imArr'] = $this->sitequota_model->getImListQueue();
		$template['frArr'] = $this->sitequota_model->getFrListQueue();
		
		//END RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		$template['page_load_time'] = $total_time;
		$template['title'] = 'Nagger Follow-up Page';
		
		$template['content'] = $this->load->view('followup_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	
	function showUpdateTicket($ticket){
		
		//No checking of access here to give everyone access in viewing the ticket update list
		
		//$flag will be used to track the corresponding redirect page after updating ticket
		//$flag = 0; previous URL came from Handover
		//$flag = 1; previous URL came from My Tickets
		
		
		$template['page_load_time'] = null;
		$template['title'] = 'Nagger Follow-up Page';
		
		//$_SERVER['HTTP_HOST'] returns localhost:82
		//$_SERVER['REQUEST_URI'] returns the remaining after hostname /siren/index.php/welcome
		$site_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		if(strpos($site_url, 'index.php/nagger/showUpdateTicket')){
			$form = '../processUpdateTicket'; 
		}
		else{
			$form = '../nagger/processUpdateTicket';
		}
		$template['form'] = $form;
		$template['ticket'] = $ticket;
		$template['updateList'] = $this->sitequota_model->getTicketUpdateList($ticket);
		$template['content'] = $this->load->view('updateticket_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	function showMyUpdateTicket($ticket){
		
		//No checking of access here to give everyone access in viewing the ticket update list
		
		//$flag will be used to track the corresponding redirect page after updating ticket
		//$flag = 0; previous URL came from Handover
		//$flag = 1; previous URL came from My Tickets
		
		
		$template['page_load_time'] = null;
		$template['title'] = 'Nagger Follow-up Page';
		
		//$_SERVER['HTTP_HOST'] returns localhost:82
		//$_SERVER['REQUEST_URI'] returns the remaining after hostname /siren/index.php/welcome
		$site_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		if(strpos($site_url, 'index.php/nagger/showMyUpdateTicket')){
			$form = '../processMyUpdateTicket'; 
		}
		else{
			$form = '../nagger/processMyUpdateTicket';
		}
		$template['form'] = $form;
		$template['ticket'] = $ticket;
		$template['updateList'] = $this->sitequota_model->getTicketUpdateList($ticket);
		$template['content'] = $this->load->view('myupdateticket_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	function showMyProfile(){
	
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		
		$template['title'] = 'Nagger - My Profile';
		$template['content'] = $this->load->view('myprofile_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	function processUpdateTicket(){
		$this->form_validation->set_rules('updateText', 'Update', 'required');
		
		if ($this->form_validation->run() == FALSE){
			$this->showUpdateTicket($this->input->post('ticket'));
		}
		
		else{
			$updateText = $this->input->post('updateText');
			
			$updateText = str_replace("'","\'",$updateText);
			
			$updateText = nl2br($updateText);
			$updateText = str_replace("[","<b>[",$updateText);
			$updateText = str_replace("]","]</b>",$updateText);
			$this->sitequota_model->updateTicket($this->input->post('ticket'),$updateText);
			
			redirect("nagger/showHandover/Array");
		
		}
	}
	
	function processMyUpdateTicket(){
		$this->form_validation->set_rules('updateText', 'Update', 'required');
		
		if ($this->form_validation->run() == FALSE){
			$this->showUpdateTicket($this->input->post('ticket'));
		}
		
		else{
			$updateText = $this->input->post('updateText');
			$updateText = str_replace("'","\'",$updateText);
			$updateText = nl2br($updateText);
			$updateText = str_replace("[","<b>[",$updateText);
			$updateText = str_replace("]","]</b>",$updateText);
			$updateText = str_replace("'","\'",$updateText);
			$this->sitequota_model->updateTicket($this->input->post('ticket'),$updateText);
			
			redirect("nagger/showMyTickets/Array");
		
		}
	}
	
	function processUpdateImManager(){
		$action = $this->input->post('ticketAction');
		
		if($action == 'outOfScope'){
			//check if ticket exist in outofscope table
			$ticketId = $this->input->post('ticketId');
			$ticketNumber = $this->input->post('ticketNumber');
			
			if($ticketNumber[0] == 'I'){
				if(!$this->sitequota_model->isImInOutOfScope($ticketId)){
					$this->sitequota_model->insertOutOfScope($ticketId, 0);
				}
				redirect("nagger/showImArchive");
			}
			else if($ticketNumber[0] == 'F'){
				if(!$this->sitequota_model->isFrInOutOfScope($ticketId)){
					$this->sitequota_model->insertOutOfScope($ticketId, 1);
				}
				else{
				
				}
				redirect("nagger/showFrArchive");
			}
			
		}
		else if($action == 'inScope'){
			//check if ticket exist in outofscope table
			$ticketId = $this->input->post('ticketId');
			$ticketNumber = $this->input->post('ticketNumber');
			
			if($ticketNumber[0] == 'I'){
				if($this->sitequota_model->isImInOutOfScope($ticketId)){
					$this->sitequota_model->insertToScope($ticketId, 0);
				}
				redirect("nagger/showImArchive");
			}
			else if($ticketNumber[0] == 'F'){
				if($this->sitequota_model->isFrInOutOfScope($ticketId)){
					$this->sitequota_model->insertToScope($ticketId, 1);
				}
				else{
				
				}
				redirect("nagger/showFrArchive");
			}
		}
		
		else if($action == 'incentive'){
		
		}
	}
	
	function generateEmail(){
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		$template['title'] = 'Nagger Generate Email Page';
		//$_SERVER['HTTP_HOST'] returns localhost:82
		//$_SERVER['REQUEST_URI'] returns the remaining after hostname /siren/index.php/welcome
		$site_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		if(strpos($site_url, 'index.php/nagger/generateEmail')){
			$form = 'sendEmail'; 
		}
		else{
			$form = '../nagger/sendEmail';
		}
		//$template['form'] = $form;
		//$template['imArr'] = $this->sitequota_model->getImListQueue();
		//$template['frArr'] = $this->sitequota_model->getFrListQueue();
		//$template['teamName'] = $this->sitequota_model->getTeamName($this->session->userdata('teamId'));
		//$row = $this->sitequota_model->getRecipient($this->session->userdata('teamId'));
		$this->sendEmail();
		//$template['recipient'] = $row->team_email;
		$template['content'] = $this->load->view('generateemail2_view', $template,true);
		$this->load->view('template_main', $template);
		
	}
	
	function setPrioritySession($flag){
	
		if($flag == 1){
			$this->session->set_userdata('teamPriorityFlag', true);
		}
		else{
			$this->session->set_userdata('teamPriorityFlag', false);
		}
	}
	
	function updateImPiorityNumber($ticketId, $priorityNumber){
		$this->sitequota_model->updateImPiorityNumber($ticketId, $priorityNumber);
	}
	
	function updateFrPiorityNumber($ticketId, $priorityNumber){
		$this->sitequota_model->updateFrPiorityNumber($ticketId, $priorityNumber);
	}
	
	function sendEmail(){
		//$subject = $this->input->post('subject').' - '.$this->input->post('shift');;
		
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$date = date('m-d-Y');
		$teamName = $this->sitequota_model->getTeamName($this->session->userdata('teamId'));
		
		$subject = '[SHIFT] '.$teamName.' Handover Report - '.$date;
		
		$recipient = $this->session->userdata('email');
		$imArr = $this->sitequota_model->getImListQueuePriority();
		$emailContent = '<font> Ticket Summary prepared by: '.anchor('/nagger','Nagger Application').'</font><br/><br/>';
		
		
		$imArrPriority = $this->sitequota_model->getPriorityIm();
		$frArrPriority = $this->sitequota_model->getPriorityFr();
		if($imArrPriority  == null && $frArrPriority == null){
			
		}
		else{
		$emailContent .= '<div align=center><h3>Team Priorities</h3></div><br/>';
		//Display Team Priority Tickets first
		if($imArrPriority != null){
			$emailContent .= '<div align=center><table>';
			$emailContent .= '<tr>';
			$emailContent .= '<td><b/>Priority #</td>';
			$emailContent .= '<td><b/>IM#</td>';
			$emailContent .= '<td><b/>Title</td>';
			$emailContent .= '<td><b/>Last Update</td>';
			$emailContent .= '<td><b/>Service</td>';
			$emailContent .= '<td><b/>SLA%</td>';
			$emailContent .= '<td><b/>SLA</td>';
			$emailContent .= '<td><b/>Priority</td>';
			
			$emailContent .= '</tr>';
			foreach($imArrPriority as $row){
				$emailContent .= '<tr>';
				if($row->priority_num == 1)
					$emailContent .= '<td align=center id="priority1">';
				else if($row->priority_num == 2)
					$emailContent .= '<td align=center id="priority2">';
				else if($row->priority_num == 3)
					$emailContent .= '<td align=center id="priority3">';
				else if($row->priority_num == 4)
					$emailContent .= '<td align=center id="priority4">';
				$emailContent .= $row->priority_num.'</td>';
				$emailContent .= '<td>'.$row->incident_number.'</td>';
				$emailContent .= '<td width=200>'.$row->title.'</td>';
				$update = $this->sitequota_model->getTicketUpdate($row->incident_number);
				if($update != null){
					$emailContent .= '<td>'.anchor('/nagger/showUpdateTicket/'.$row->incident_number,$update->update_text).'</td>';
				}
				else
					$emailContent .= '<td>No updates.</td>';
				$emailContent .= '<td>'.$row->service.'</td>';
				if($row->sla_percent >= 100){ 
					$emailContent .= '<td style="white-space: nowrap; background:#ff0000;">';
					$emailContent .= '<font>'.$row->sla_percent.' %</font><br/>
						
					</td>';
				}
				else if($row->sla_percent >= 80 && $row->sla_percent < 100){ 
					$emailContent .= '<td style="white-space: nowrap; background:#ffff00;">';
					$emailContent .= '<font>'.$row->sla_percent.' %</font><br/>
						
					</td>';
				}
				else{ 
					$emailContent .= '<td style="white-space: nowrap; background:#66CD00"><font>'.$row->sla_percent.' %</font></td>';
				}
				
				$emailContent .= '<td>'.$row->target_date.'</td>';
				if(strpos($row->priority, 'Critical')){
					$emailContent .= '<td style="white-space: nowrap; background:#ff0000;">'.$row->priority.'</td>';
				}
				else if(strpos($row->priority, 'High')){
					$emailContent .= '<td style="white-space: nowrap; background:#ffa500;">'.$row->priority.'</td>';
				}
				
				else{
					$emailContent .= '<td>'.$row->priority.'</td>';
				}
				
				
				$emailContent .= '</tr>';
				}
				$emailContent .= '</table></div><br/>';
		}
		
		if($frArrPriority != null){
			$emailContent .= '<div align=center><table>';
			$emailContent .= '<tr><td><b/>Priority #</td>';
			$emailContent .= '<td><b/>FR#</td>';
			$emailContent .= '<td><b/>Title</td>';
			$emailContent .= '<td><b/>Last Update</td>';
			$emailContent .= '<td><b/>Service</td>';
			$emailContent .= '<td><b/>SLA%</td>';
			$emailContent .= '<td><b/>SLA</td>';
			$emailContent .= '<td><b/>Priority</td>';
			$emailContent .= '</tr>';
			foreach($frArrPriority as $row){
				$emailContent .= '<tr>';
				if($row->priority_num == 1)
					$emailContent .= '<td align=center id="priority1">';
				else if($row->priority_num == 2)
					$emailContent .= '<td align=center id="priority2">';
				else if($row->priority_num == 3)
					$emailContent .= '<td align=center id="priority3">';
				else if($row->priority_num == 4)
					$emailContent .= '<td align=center id="priority4">';
				$emailContent .= $row->priority_num.'</td>';
				$emailContent .= '<td>'.$row->fulfillment_number.'</td>';
				$emailContent .= '<td width=200>'.$row->title.'</td>';
				$update = $this->sitequota_model->getTicketUpdate($row->fulfillment_number);
				if($update != null){
					$emailContent .= '<td>'.anchor('/nagger/showUpdateTicket/'.$row->fulfillment_number,$update->update_text).'</td>';
				}
				else
					$emailContent .= '<td>No updates.</td>';
				$emailContent .= '<td>'.$row->service.'</td>';
				if($row->sla_percent >= 100){ 
					$emailContent .= '<td style="white-space: nowrap; background:#ff0000;">';
					$emailContent .= '<font>'.$row->sla_percent.' %</font><br/>
						
					</td>';
				}
				else if($row->sla_percent >= 80 && $row->sla_percent < 100){ 
					$emailContent .= '<td style="white-space: nowrap; background:#ffff00;">';
					$emailContent .= '<font>'.$row->sla_percent.' %</font><br/>
						
					</td>';
				}
				else{ 
					$emailContent .= '<td style="white-space: nowrap; background:#66CD00"><font>'.$row->sla_percent.' %</font></td>';
				}
				
				
				$emailContent .= '<td>'.$row->sla.'</td>';
				if(strpos($row->request_priority, 'Critical')){
					$emailContent .= '<td style="white-space: nowrap; background:#ff0000;">'.$row->request_priority.'</td>';
				}
				else if(strpos($row->request_priority, 'High')){
					$emailContent .= '<td style="white-space: nowrap; background:#ffa500;">'.$row->request_priority.'</td>';
				}
				else{
					$emailContent .= '<td>'.$row->request_priority.'</td>';
				}
				$update = $this->sitequota_model->getTicketUpdate($row->fulfillment_number);
				
				$emailContent .= '</tr>';
			}
			$emailContent .= '</table></div><br/>';
		}
			$emailContent .= '<hr/>';
		}
		
		if($this->session->userdata('teamPriorityFlag') == false){
		
			$emailContent .= '<div align=center><h3>Master List</h3></div><br/>';
			$dangerCount = $this->sitequota_model->getImDanger();
			$missedCount = $this->sitequota_model->getImMissed();
			$greenCount = count($this->sitequota_model->getImListQueue()) - ($dangerCount + $missedCount);
			
			$emailContent .= '<table>';
			$emailContent .= '<tr><td>Within SLA:</td><td>'.$greenCount.'</td></tr>';
			$emailContent .= '<tr><td>Danger (SLA >= 80%):</td><td>'.$dangerCount.'</td></tr>';
			$emailContent .= '<tr><td>Missed (SLA >= 100%):</td><td>'.$missedCount.'</td></tr>';
			$emailContent .= '<tr><td>Total:</td><td>'.count($imArr).'</td></tr>';
			$emailContent .= '</table><br/><br/>';
			
			if(count($imArr) > 0){
				$emailContent .= '<table>';
				$emailContent .= '<tr>';
				$emailContent .= '<td><b/>IM#</td>';
				$emailContent .= '<td><b/>Title</td>';
				$emailContent .= '<td><b/>Last Update</td>';
				$emailContent .= '<td><b/>Service</td>';
				$emailContent .= '<td><b/>SLA%</td>';
				$emailContent .= '<td><b/>SLA</td>';
				$emailContent .= '<td><b/>Priority</td>';
				
				$emailContent .= '</tr>';
				foreach($imArr as $row){
					$emailContent .= '<tr>';
					$emailContent .= '<td>'.$row->incident_number.'</td>';
					$emailContent .= '<td>'.$row->title.'</td>';
					$update = $this->sitequota_model->getTicketUpdate($row->incident_number);
					if($update != null){
						$emailContent .= '<td>'.anchor('/nagger/showUpdateTicket/'.$row->incident_number,$update->update_text).'</td>';
					}
					else
						$emailContent .= '<td>No updates.</td>';
					$emailContent .= '<td>'.$row->service.'</td>';
					if($row->sla_percent >= 100){ 
						$emailContent .= '<td style="white-space: nowrap; background:#ff0000;">';
						$emailContent .= '<font>'.$row->sla_percent.' %</font><br/>
							
						</td>';
					}
					else if($row->sla_percent >= 80 && $row->sla_percent < 100){ 
						$emailContent .= '<td style="white-space: nowrap; background:#ffff00;">';
						$emailContent .= '<font>'.$row->sla_percent.' %</font><br/>
							
						</td>';
					}
					else{ 
						$emailContent .= '<td style="white-space: nowrap; background:#66CD00"><font>'.$row->sla_percent.' %</font></td>';
					}
					
					$emailContent .= '<td>'.$row->target_date.'</td>';
					if(strpos($row->priority, 'Critical')){
						$emailContent .= '<td style="white-space: nowrap; background:#ff0000;">'.$row->priority.'</td>';
					}
					else if(strpos($row->priority, 'High')){
						$emailContent .= '<td style="white-space: nowrap; background:#ffa500;">'.$row->priority.'</td>';
					}
					
					else{
						$emailContent .= '<td>'.$row->priority.'</td>';
					}
					
					
					$emailContent .= '</tr>';
				}
				$emailContent .= '</table><br/>';
		
			}
			else{
				$emailContent .= 'No IMs found.';
			}
			
			$frArr = $this->sitequota_model->getFrListQueuePriority();
			$emailContent .= '<hr/><br/>';
			
			$dangerCount = $this->sitequota_model->getFrDanger();
			$missedCount = $this->sitequota_model->getFrMissed();
			$greenCount = count($this->sitequota_model->getFrListQueue()) - ($dangerCount + $missedCount);
			
			$emailContent .= '<table>';
			$emailContent .= '<tr><td>Within SLA:</td><td>'.$greenCount.'</td></tr>';
			$emailContent .= '<tr><td>Danger (SLA >= 80%):</td><td>'.$dangerCount.'</td></tr>';
			$emailContent .= '<tr><td>Missed (SLA >= 100%):</td><td>'.$missedCount.'</td></tr>';
			$emailContent .= '<tr><td>Total:</td><td>'.count($frArr).'</td></tr>';
			$emailContent .= '</table><br/><br/>';
			
			if(count($frArr) > 0){
			
				$emailContent .= '<table>';
				$emailContent .= '<tr><td><b/>FR#</td>';
				$emailContent .= '<td><b/>Title</td>';
				$emailContent .= '<td><b/>Last Update</td>';
				$emailContent .= '<td><b/>Service</td>';
				$emailContent .= '<td><b/>SLA%</td>';
				$emailContent .= '<td><b/>SLA</td>';
				$emailContent .= '<td><b/>Priority</td>';
				$emailContent .= '</tr>';
				foreach($frArr as $row){
					$emailContent .= '<tr>';
					$emailContent .= '<td>'.$row->fulfillment_number.'</td>';
					$emailContent .= '<td>'.$row->title.'</td>';
					$update = $this->sitequota_model->getTicketUpdate($row->fulfillment_number);
					if($update != null){
						$emailContent .= '<td>'.anchor('/nagger/showUpdateTicket/'.$row->fulfillment_number,$update->update_text).'</td>';
					}
					else
						$emailContent .= '<td>No updates.</td>';
					$emailContent .= '<td>'.$row->service.'</td>';
					if($row->sla_percent >= 100){ 
						$emailContent .= '<td style="white-space: nowrap; background:#ff0000;">';
						$emailContent .= '<font>'.$row->sla_percent.' %</font><br/>
							
						</td>';
					}
					else if($row->sla_percent >= 80 && $row->sla_percent < 100){ 
						$emailContent .= '<td style="white-space: nowrap; background:#ffff00;">';
						$emailContent .= '<font>'.$row->sla_percent.' %</font><br/>
							
						</td>';
					}
					else{ 
						$emailContent .= '<td style="white-space: nowrap; background:#66CD00"><font>'.$row->sla_percent.' %</font></td>';
					}
					
					
					$emailContent .= '<td>'.$row->sla.'</td>';
					if(strpos($row->request_priority, 'Critical')){
						$emailContent .= '<td style="white-space: nowrap; background:#ff0000;">'.$row->request_priority.'</td>';
					}
					else if(strpos($row->request_priority, 'High')){
						$emailContent .= '<td style="white-space: nowrap; background:#ffa500;">'.$row->request_priority.'</td>';
					}
					else{
						$emailContent .= '<td>'.$row->request_priority.'</td>';
					}
					$update = $this->sitequota_model->getTicketUpdate($row->fulfillment_number);
					
					$emailContent .= '</tr>';
				}
				$emailContent .= '</table><br/>';
			
			}
			else{
				$emailContent .= 'No FRs found.';
			}
		
		}
		
		$this->load->library('email');
		$config['protocol'] = 'smtp';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['smtp_host'] = 'smtp3.hp.com';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		//$this->email->from('gdpc.webint.bea-l2@hp.com', 'Handover Report');
		$this->email->from($this->session->userdata('email'), 'Handover Report');
		$this->email->to($recipient); 
		$this->email->cc('adrian-lester.tan@hp.com'); 
		$this->email->subject($subject);
		$this->email->message(TABLE_CSS.$emailContent);
		$this->email->send();
		
		//redirect("nagger/showHandover/Array");
		
	}
	
	function showReports(){
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		$this->session->set_userdata('reportMonth', date('m'));
		$template['title'] = 'Nagger Report Page';
		$template['content'] = $this->load->view('report_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	function showImReport(){
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		
		$site_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		if(strpos($site_url, 'index.php')){
			$form = 'nagger/showImReportRedirect'; 
		}
		else{
			$form = 'index.php/nagger/showImReportRedirect/';
		}
			
		$template['form'] = $form;
		
		if($this->session->userdata('reportMonth') == null || $this->session->userdata('reportMonth') == ''){
			$this->session->set_userdata('reportMonth', date('m'));
		}
		
		if($this->session->userdata('reportYear') == null || $this->session->userdata('reportYear') == ''){
			$this->session->set_userdata('reportYear', date('Y'));
		}
		$template['title'] = 'Nagger Report Page';
		$template['content'] = $this->load->view('imreport_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	function showImReportRedirect(){
		$selectedDate = $this->input->post('reportDate');
		$seperator = strpos($selectedDate, '|');
		$selectedMonth = substr($selectedDate, 0, $seperator);
		$selectedYear = substr($selectedDate, $seperator+1, 4);
		
		$this->session->set_userdata('reportMonth', $selectedMonth);
		$this->session->set_userdata('reportYear', $selectedYear);
		
		redirect('nagger/showImReport');
	}
	
	function showFrReport(){
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		$this->session->set_userdata('reportMonth', date('m'));
		$template['title'] = 'Nagger Report Page';
		$template['content'] = $this->load->view('frreport_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	
	function showImArchive(){
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		$template['title'] = 'IM Archive';
		$template['imArr'] = $this->sitequota_model->getImArchive();
		$template['imArrOutOfScope'] = $this->sitequota_model->getImArchiveOutOfScope();
		$template['content'] = $this->load->view('im_archive_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	function showFrArchive(){
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		$template['title'] = 'FR Archive';
		$template['frArr'] = $this->sitequota_model->getFrArchive();
		$template['frArrOutOfScope'] = $this->sitequota_model->getFrArchiveOutOfScope();
		$template['content'] = $this->load->view('fr_archive_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	
	function showTicketReport($ticketNumber){
	
		$owning_team = $this->session->userdata('teamId');
		//Get Ticket ID of the given IM/FR//////////////////////////////
		$flag = 0;  //0 = IM; 1 = FR;
		$scopeFlag = 0; //0 = In Scope; 1 = Out Of Scope;
		$ticketDetails = null;
		if($ticketNumber[0] == 'I'){
			$sql = "
				SELECT * FROM incidents
				WHERE incident_number = '$ticketNumber'
				AND owning_team = $owning_team;
			";
		}
		else if($ticketNumber[0] == 'F'){
			$flag = 1;
			$sql = "
				SELECT * FROM fulfillment
				WHERE fulfillment_number = '$ticketNumber'
				AND owning_team = $owning_team;
			";
		}
		$query = $this->db->query($sql);
		$row = '';
		if($query->num_rows()>0){
			$row = $query->first_row();
			if($flag == 0)
				$ticketDetails = $this->sitequota_model->getImDetailsById($row->id);
			else
				$ticketDetails = $this->sitequota_model->getFrDetailsById($row->id);
		}
		else{
			//If it wasn't found in the in scope tables, then search OUT OF SCOPE tables.
			if($ticketNumber[0] == 'I'){
				$sql = "
					SELECT * FROM incidents_outofscope
					WHERE incident_number = '$ticketNumber'
					AND owning_team = $owning_team;
				";
			}
			else if($ticketNumber[0] == 'F'){
				$flag = 1;
				$sql = "
					SELECT * FROM fulfillment_outofscope
					WHERE fulfillment_number = '$ticketNumber'
					AND owning_team = $owning_team;
				";
			}
			$query = $this->db->query($sql);
			$row = '';
			if($query->num_rows()>0){
				$row = $query->first_row();
				if($flag == 0)
					$ticketDetails = $this->sitequota_model->getImDetailsByIdOutOfScope($row->id);
				else
					$ticketDetails = $this->sitequota_model->getFrDetailsByIdOutOfScope($row->id);
					
				$scopeFlag = 1;
			}
			else{
				$row = null;
			}
		}
		/**Get Ticket ID but check if it is an FR or IM**/
		
		if($row != null)
			$ticketId = $row->id;
		else
			$ticketId = null;
		//Get Ticket ID of the given IM/FR//////////////////////////////
		
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		
		if($ticketDetails !== null){
			$template['title'] = 'Ticket Details Page';
			$template['ticketId'] = $ticketId;
			$template['ticketDetails'] = $ticketDetails;
			$template['scopeFlag'] = $scopeFlag;
			
			$site_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			
			if(strpos($site_url, 'index.php')){
				$form = 'nagger/processChangeTicketOwner'; 
			}
			else{
				$form = 'index.php/nagger/processChangeTicketOwner/';
			}
			
			$template['form'] = $form;
			
			if($flag == 0)
				$template['content'] = $this->load->view('imticket_view', $template,true);
			else
				$template['content'] = $this->load->view('frticket_view', $template,true);
			$this->load->view('template_main', $template);
		}
		else{
			echo 'Unauthorized Access. You accessed a ticket that doesn\'t belong to your team.';
		}
	}
	
	function processChangeTicketOwner(){
		$ticketNumber = $this->input->post('ticketNumber');
		$ownerEmpId = $this->input->post('assignOwner');
		$scopeFlag  = $this->input->post('scopeFlag');
		
		
		if($ticketNumber[0] == 'I'){
			$this->sitequota_model->updateImOwner($ticketNumber, $ownerEmpId, $scopeFlag);
			$ticketDetails = $this->sitequota_model->getImDetailsByNum($ticketNumber);
		}
		else if($ticketNumber[0] == 'F'){
			$this->sitequota_model->updateFrOwner($ticketNumber, $ownerEmpId, $scopeFlag);
			$ticketDetails = $this->sitequota_model->getFrDetailsByNum($ticketNumber);
		}
		
		
		$sender = $this->sitequota_model->getUserData($this->session->userdata('empNum'));
		$receiver = $this->sitequota_model->getUserData($ownerEmpId);
		
		if(($sender->email == null || $sender->email == '')&&
			($receiver->email==null || $receiver->email=='')){
			
		}
		else{
		
			if($ticketNumber[0] == 'I'){
				$update = $this->sitequota_model->getTicketUpdate($ticketDetails->incident_number);
				if($update == null){
					$emailContent = '
					<font>The ticket: '.$ticketDetails->incident_number.' - '.$ticketDetails->title.' has been assigned to you by '.$sender->first_name.' '.$sender->last_name.'.
					<br/><br/>Last Update: No Updates. <br/><br/><hr/>
					Visit <a href="16.178.46.166/sitequota/index.php/nagger">Nagger</a> to view the ticket.
					</font>
					';	
				}
				else{
					$emailContent = '
					<font>The ticket: '.$ticketDetails->incident_number.' - '.$ticketDetails->title.' has been assigned to you by '.$sender->first_name.' '.$sender->last_name.'.
					<br/><br/>Last Update by '.$update->updated_by.' ('.$update->date.' '.$update->time.'):<br/><br/>'.$update->update_text.'<br/><br/><hr/>
					Visit <a href="16.178.46.166/sitequota/index.php/nagger">Nagger</a> to view the ticket.
					</font>
					';
				}
				$subject = 'NAGGER Ticket Assignment - '.$ticketDetails->incident_number.' '.$ticketDetails->title;
				
			}
			else if($ticketNumber[0] == 'F'){
				$update = $this->sitequota_model->getTicketUpdate($ticketDetails->fulfillment_number);
				if($update == null){
					$emailContent = '
					<font>The ticket: '.$ticketDetails->fulfillment_number.' - '.$ticketDetails->title.' has been assigned to you by '.$sender->first_name.' '.$sender->last_name.'.
					<br/><br/>Last Update: No Updates. <br/><br/><hr/>
					Visit <a href="16.178.46.166/sitequota/index.php/nagger">Nagger</a> to view the ticket.
					</font>
					';	
				}
				else{
					$emailContent = '
					<font>The ticket: '.$ticketDetails->fulfillment_number.' - '.$ticketDetails->title.' has been assigned to you by '.$sender->first_name.' '.$sender->last_name.'.
					<br/><br/>Last Update by '.$update->updated_by.' ('.$update->date.' '.$update->time.'):<br/><br/>'.$update->update_text.'<br/><br/><hr/>
					Visit <a href="16.178.46.166/sitequota/index.php/nagger">Nagger</a> to view the ticket.
					</font>
					';
				}
				$subject = 'NAGGER Ticket Assignment - '.$ticketDetails->fulfillment_number.' - '.$ticketDetails->title;
				
			}
			$this->load->library('email');
			$config['protocol'] = 'smtp';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['smtp_host'] = 'smtp3.hp.com';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			
			$this->email->from($sender->email, $sender->first_name.' '.$sender->last_name);
			$this->email->to($receiver->email); 
			$this->email->bcc('adrian-lester.tan@hp.com'); 
			
			$this->email->subject($subject);
			$this->email->message(TABLE_CSS.$emailContent);
			$this->email->send();
		}
		redirect("nagger/showTicketReport/".$ticketNumber);
		
	}
	
	function downloadTeamIncidentsArchive(){
		include 'lib/phpexcel/Classes/PHPExcel.php';
		include 'lib/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';
		
		
		$imList = $this->sitequota_model->getImArchive();
		
		
		if($imList != null){
			$objPHPExcel = new PHPExcel();
			// Set properties
			
			$objPHPExcel->getProperties()->setCreator("NAGGER");
			$objPHPExcel->getProperties()->setLastModifiedBy($this->session->userdata('empNum'));
			$objPHPExcel->getProperties()->setTitle("NAGGER Incident Tickets Archive");
			$objPHPExcel->getProperties()->setSubject("NAGGER Incident Tickets Archive");
			$objPHPExcel->getProperties()->setDescription("NAGGER Incident Tickets Archive");
			
			/*****Gather In Scope Tickets*******************************************/
			
			$objPHPExcel->setActiveSheetIndex(0);
			$rowCtr = 1;
			
			$dataArray = array(
				'Incident Number',
				'Reported',
				'SWT Date',
				'SWT Time',
				'CWT Date',
				'CWT Time',
				'Impact',
				'Urgency',
				'Priority',
				'Category',
				'Area',
				'Sub Area',
				'Current Status',
				'Title',
				'Target Date',
				'CI',
				'Service',
				'Queue',
				'Assignee',
				'Service Impact',
				'Closure Code',
				'SLA Percent'
			);
			$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			foreach($imList as $row){
				$dataArray = array(
					$row->incident_number,
					$row->reported,
					$row->swt_date,
					$row->swt_time,
					$row->cwt_date,
					$row->cwt_time,
					$row->impact,
					$row->urgency,
					$row->priority,
					$row->category,
					$row->area,
					$row->sub_area,
					$row->current_status,
					$row->title,
					$row->target_date,
					$row->affected_ci,
					$row->service,
					$row->queue,
					$row->assignee,
					$row->service_impact,
					$row->closure_code,
					$row->sla_percent
				);
				$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			}
			$objPHPExcel->getActiveSheet()->setTitle('In Scope');
			
			
			/*****Gather Out Of Scope Tickets*******************************************/
			$imListOutOfScope = $this->sitequota_model->getImArchiveOutOfScope();
				//Check if there are Out Of Scope tickets
				$objPHPExcel->createSheet(1);
				$objPHPExcel->setActiveSheetIndex(1);
				$objPHPExcel->getActiveSheet()->setTitle('Out Of Scope');
			if($imListOutOfScope != null){
				$rowCtr = 1;
				$dataArray = array(
					'Incident Number',
					'Reported',
					'SWT Date',
					'SWT Time',
					'CWT Date',
					'CWT Time',
					'Impact',
					'Urgency',
					'Priority',
					'Category',
					'Area',
					'Sub Area',
					'Current Status',
					'Title',
					'Target Date',
					'CI',
					'Service',
					'Queue',
					'Assignee',
					'Service Impact',
					'Closure Code',
					'SLA Percent'
				);
				$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
				foreach($imListOutOfScope as $row){
					$dataArray = array(
						$row->incident_number,
						$row->reported,
						$row->swt_date,
						$row->swt_time,
						$row->cwt_date,
						$row->cwt_time,
						$row->impact,
						$row->urgency,
						$row->priority,
						$row->category,
						$row->area,
						$row->sub_area,
						$row->current_status,
						$row->title,
						$row->target_date,
						$row->affected_ci,
						$row->service,
						$row->queue,
						$row->assignee,
						$row->service_impact,
						$row->closure_code,
						$row->sla_percent
					);
					$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
				}
				
			}
			
			//Get the Focused/Active sheet back to In Scope.
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			
			// We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');

			// It will be called file.xls
			header('Content-Disposition: attachment; filename="NAGGER Incident Tickets Archive.xlsx"');

			// Write file to the browser
			$objWriter->save('php://output');
		}
	}
	
	function downloadTeamFulfillmentsArchive(){
		include 'lib/phpexcel/Classes/PHPExcel.php';
		include 'lib/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';
		
		
		$frList = $this->sitequota_model->getFrArchive();
		
		
		if($frList != null){
			$objPHPExcel = new PHPExcel();
			// Set properties
			
			$objPHPExcel->getProperties()->setCreator("NAGGER");
			$objPHPExcel->getProperties()->setLastModifiedBy($this->session->userdata('empNum'));
			$objPHPExcel->getProperties()->setTitle("NAGGER Fulfillment Tickets Archive");
			$objPHPExcel->getProperties()->setSubject("NAGGER Fulfillment Tickets Archive");
			$objPHPExcel->getProperties()->setDescription("NAGGER Fulfillment Tickets Archive");
			
			/*****Gather In Scope Tickets*******************************************/
			
			$objPHPExcel->setActiveSheetIndex(0);
			$rowCtr = 1;
			
			$dataArray = array(
				'Fulfillment Number',
				'SWT Date',
				'SWT Time',
				'CWT Date',
				'CWT Time',
				'Category',
				'Request Type',
				'Service',
				'Service Type',
				'Configuration Item',
				'Reported Date',
				'SLA', 
				'Closed Date',
				'Assignment Group',
				'Assignee',
				'Closure Code',
				'SLA Percentage',
				'Status', 
				'Title',
				'Request Piority'
				
			);
			$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			
			foreach($frList as $row){
				$dataArray = array(
					$row->fulfillment_number,
					$row->swt_date,
					$row->swt_time,
					$row->cwt_date,
					$row->cwt_time,
					$row->category,
					$row->request_type,
					$row->service,
					$row->service_type,
					$row->ci,
					$row->reported,
					$row->sla,
					$row->closed_date,
					$row->assignment_group,
					$row->assignee,
					$row->closure_code,
					$row->sla_percent,
					$row->status,
					$row->title,
					$row->request_priority
				);
				$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			}
			$objPHPExcel->getActiveSheet()->setTitle('In Scope');
			
			
			/*****Gather Out Of Scope Tickets*******************************************/
			$frListOutOfScope = $this->sitequota_model->getFrArchiveOutOfScope();
				//Check if there are Out Of Scope tickets
				$objPHPExcel->createSheet(1);
				$objPHPExcel->setActiveSheetIndex(1);
				$objPHPExcel->getActiveSheet()->setTitle('Out Of Scope');
			if($frListOutOfScope != null){
				$rowCtr = 1;
				
				$dataArray = array(
					'Fulfillment Number',
					'SWT Date',
					'SWT Time',
					'CWT Date',
					'CWT Time',
					'Category',
					'Request Type',
					'Service',
					'Service Type',
					'Configuration Item',
					'Reported Date',
					'SLA', 
					'Closed Date',
					'Assignment Group',
					'Assignee',
					'Closure Code',
					'SLA Percentage',
					'Status', 
					'Title',
					'Request Piority'
				
				);
				$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
				
				foreach($frListOutOfScope as $row){
					$dataArray = array(
						$row->fulfillment_number,
						$row->swt_date,
						$row->swt_time,
						$row->cwt_date,
						$row->cwt_time,
						$row->category,
						$row->request_type,
						$row->service,
						$row->service_type,
						$row->ci,
						$row->reported,
						$row->sla,
						$row->closed_date,
						$row->assignment_group,
						$row->assignee,
						$row->closure_code,
						$row->sla_percent,
						$row->status,
						$row->title,
						$row->request_priority
					);
					$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
				}
				
			}
			
			//Get the Focused/Active sheet back to In Scope.
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			
			// We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');

			// It will be called file.xls
			header('Content-Disposition: attachment; filename="NAGGER Fulfillment Tickets Archive.xlsx"');

			// Write file to the browser
			$objWriter->save('php://output');
		}
	}
	
	function downloadTeamIncidents(){
		include 'lib/phpexcel/Classes/PHPExcel.php';
		include 'lib/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';
		
		
		$imList = $this->sitequota_model->getImListQueue();
		
		
		if($imList != null){
			$objPHPExcel = new PHPExcel();
			// Set properties
			
			$objPHPExcel->getProperties()->setCreator("NAGGER");
			$objPHPExcel->getProperties()->setLastModifiedBy($this->session->userdata('empNum'));
			$objPHPExcel->getProperties()->setTitle("NAGGER Incident Tickets");
			$objPHPExcel->getProperties()->setSubject("NAGGER Incident Tickets");
			$objPHPExcel->getProperties()->setDescription("NAGGER Incident Tickets");
			
			/*****Gather In Scope Tickets*******************************************/
			
			$objPHPExcel->setActiveSheetIndex(0);
			$rowCtr = 1;
			
			
			$dataArray = array(
				'Incident Number',
				'Reported',
				'SWT Date',
				'SWT Time',
				'CWT Date',
				'CWT Time',
				'Impact',
				'Urgency',
				'Priority',
				'Category',
				'Area',
				'Sub Area',
				'Current Status',
				'Title',
				'Target Date',
				'CI',
				'Service',
				'Queue',
				'Assignee',
				'Service Impact',
				'Closure Code',
				'SLA Percent'
			);
			
			$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			foreach($imList as $row){
				$dataArray = array(
					$row->incident_number,
					$row->reported,
					$row->swt_date,
					$row->swt_time,
					$row->cwt_date,
					$row->cwt_time,
					$row->impact,
					$row->urgency,
					$row->priority,
					$row->category,
					$row->area,
					$row->sub_area,
					$row->current_status,
					$row->title,
					$row->target_date,
					$row->affected_ci,
					$row->service,
					$row->queue,
					$row->assignee,
					$row->service_impact,
					$row->closure_code,
					$row->sla_percent
				);
				$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			}
			$objPHPExcel->getActiveSheet()->setTitle('On-Going Tickets');
			
			
			
			//Get the Focused/Active sheet back to In Scope.
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			
			// We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');

			// It will be called file.xls
			header('Content-Disposition: attachment; filename="NAGGER Incident Tickets Archive.xlsx"');

			// Write file to the browser
			$objWriter->save('php://output');
		}
	}
	
	function downloadTeamFulfillments(){
		include 'lib/phpexcel/Classes/PHPExcel.php';
		include 'lib/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';
		
		
		$frList = $this->sitequota_model->getFrListQueue();
		
		
		if($frList != null){
			$objPHPExcel = new PHPExcel();
			// Set properties
			
			$objPHPExcel->getProperties()->setCreator("NAGGER");
			$objPHPExcel->getProperties()->setLastModifiedBy($this->session->userdata('empNum'));
			$objPHPExcel->getProperties()->setTitle("NAGGER Fulfillment Tickets");
			$objPHPExcel->getProperties()->setSubject("NAGGER Fulfillment Tickets");
			$objPHPExcel->getProperties()->setDescription("NAGGER Fulfillment Tickets");
			
			/*****Gather In Scope Tickets*******************************************/
			
			$objPHPExcel->setActiveSheetIndex(0);
			$rowCtr = 1;
			
			$dataArray = array(
				'Fulfillment Number',
				'SWT Date',
				'SWT Time',
				'CWT Date',
				'CWT Time',
				'Category',
				'Request Type',
				'Service',
				'Service Type',
				'Configuration Item',
				'Reported Date',
				'SLA', 
				'Closed Date',
				'Assignment Group',
				'Assignee',
				'Closure Code',
				'SLA Percentage',
				'Status', 
				'Title',
				'Request Piority'
				
			);
			$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			foreach($frList as $row){
				$dataArray = array(
					$row->fulfillment_number,
					$row->swt_date,
					$row->swt_time,
					$row->cwt_date,
					$row->cwt_time,
					$row->category,
					$row->request_type,
					$row->service,
					$row->service_type,
					$row->ci,
					$row->reported,
					$row->sla,
					$row->closed_date,
					$row->assignment_group,
					$row->assignee,
					$row->closure_code,
					$row->sla_percent,
					$row->status,
					$row->title,
					$row->request_priority
					
				);
				$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			}
			$objPHPExcel->getActiveSheet()->setTitle('On-Going Tickets');
			
			
			
			//Get the Focused/Active sheet back to In Scope.
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			
			// We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');

			// It will be called file.xls
			header('Content-Disposition: attachment; filename="NAGGER Fulfillment Tickets.xlsx"');

			// Write file to the browser
			$objWriter->save('php://output');
		}
	}
	
	function prioritizeTicket($ticket){
		if($ticket[0] == 'I'){
			$this->sitequota_model->prioritizeIm($ticket);
		}
		else if($ticket[0] == 'F'){
			$this->sitequota_model->prioritizeFr($ticket);
		}
		redirect('/nagger/showHome/Array');
	}
	
	function unprioritizeTicket($ticket){
		if($ticket[0] == 'I'){
			$this->sitequota_model->unprioritizeIm($ticket);
		}
		else if($ticket[0] == 'F'){
			$this->sitequota_model->unprioritizeFr($ticket);
		}
		redirect('/nagger/showHome/Array');
	}
	
	function learnMore(){
		$this->load->view('learnmore_view');
	}
	
	function admin(){
		$data['dailyUsers'] = $this->sitequota_model->getDailyUsers();
		$data['imSyncInterval'] = $this->sitequota_model->getImSyncInterval();
		$data['frSyncInterval'] = $this->sitequota_model->getFrSyncInterval();
		$this->load->view('admin_view', $data);
	}
	
	function search(){
		if (isset($_GET['term'])){
			echo json_encode($this->sitequota_model->searchTickets($_GET['term']));
		}
	}
	
	function searchArchive(){
		if (isset($_GET['term'])){
			echo json_encode($this->sitequota_model->searchTicketsArchive($_GET['term']));
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
