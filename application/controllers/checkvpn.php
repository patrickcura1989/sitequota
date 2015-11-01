<?php 

class checkvpn extends CI_Controller {
	
	function index(){
	/*
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
		
		//include("lib/simplehtmldom/simple_html_dom.php");
		//display only PHP Error Messages
		error_reporting(E_ERROR);
		ini_set('max_execution_time', 600);
		$this->showHomePage('');
	*/
	}

	
	function showHomePage($server){
	
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
		
		//include("lib/simplehtmldom/simple_html_dom.php");
		//display only PHP Error Messages
		error_reporting(E_ERROR);
		ini_set('max_execution_time', 600);
	
		/*	This needs to pass as there is a vpn checker as well in both the servers. This folder hosts two applications
			-> Site Quota Tool and ->Nagger
			
			Server 1: 16.188.100.58
			Server 2: 16.178.63.137
		*/
	
	
		echo "<title>Check VPN</title>";
		echo '<h3>VPN Checker</h3>';
		//START RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		//START RECORDING LOAD TIME
		
		$username = PGUSERNAME;
		$password = PGPASSWORD;
		$ch = curl_init();
		
		$url = "http://dcsp.pg.com";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$emailContent = '';
		if($http_status == 0){
			echo 'VPN DISCONNECTED.<br/>';
			$emailContent = 'VPN DISCONNECTED.<br/>';
		}
		else if($http_status == 200 || $http_status == 302){
			echo 'VPN CONNECTED!<br/>I\'m trying the following link: '.$url.'.<br/><br/>';
		}
		else if($http_status == 401){
			echo 'Unauthorized. Please check the configured credentials in the constants file.';
			$emailContent = 'Unauthorized. Please check the configured credentials in the constants (C:/xampp/htdocs/sitequota/application/config/constants.php) file.';
		}
		else{
			echo 'I got a wonky HTTP Status returned: "'.$http_status.'". Please contact support('.PGUSERNAME.').';
		}
		//ERROR_HANDLING
		if ($output === false) {
			trigger_error('Failed to execute cURL session: ' . curl_error($ch), E_USER_ERROR);
		}
			
			
		
		curl_close($ch);
	
		
		//END RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		echo "<font class='myFont'>Page generated in ".$total_time.' seconds.</font><br/><br/>';
		
		if($emailContent != ''){
			if($server == 1 || $server == '1'){
			
				$this->email->from('gdpc.webint.bea-l2@hp.com', 'BEA Operations');
				$this->email->to('gdpc.webint.bea-l2@hp.com'); 
				$this->email->cc('adrian-lester.tan@hp.com'); 
				$this->email->bcc('leoherrerajr@hp.com'); 
				$this->email->subject('Server VPN Disconnected');
				$header = '';
				if($http_status != 401){
					$header = "
						Hi.<br/><br/>
						This is to notify you that the VPN connection of 16.188.100.58 has been disconnected. <br/><br/>
						Please use RDC, then your VPN account and PIN to restore the connection.<br/>
						Username: Administrator<br/>
						Password: Nostradamus01<br/><br/>
						
						Impacted application(s):<br/>
						- Nostradamus <br/>
						- Cockpits Site Quota Tool <br/>
						- Communities Site Quota Tool <br/>
					
					";
				}
				else{
					//Wrong password
					$header = $emailContent.'<br/>Currently used account is: '.PGUSERNAME.'.';
				}
				
				$this->email->message($header);	

				$this->email->send();

				echo $this->email->print_debugger();
			}
			else if($server == 2 || $server == '2'){
			
				$this->email->from('gdpc.webint.bea-l2@hp.com', 'BEA Operations');
				$this->email->to('kristin-aimee.gan@hp.com, jestine-bernice.tomas@hp.com, gdpc.webint.bea-l2@hp.com, carlos-luigi-r.dela-cruz@hp.com'); 
				$this->email->cc('adrian-lester.tan@hp.com'); 
				$this->email->subject('Server VPN Disconnected');
				$header = '';
				if($http_status != 401){
					$header = "
						Hi.<br/><br/>
						This is to notify you that the VPN connection of 16.178.46.166 has been disconnected. <br/><br/>
						Please visit the server in the WEBFast Area (or contact BEA Operations) and use your VPN account and PIN to restore the connection.<br/>
						Username: smbouser<br/>
						Password: Discovery001<br/><br/>
						
						Impacted application(s):<br/>
						- Siren v2 <br/>
						- Nagger <br/>
						- DM Assistant Tool <br/>
					";
				}
				else{
					//Wrong password
					//$header = $emailContent.'<br/>Currently used account is: '.PGUSERNAME.'.';
				}
				
				$this->email->message($header);	

				$this->email->send();

				echo $this->email->print_debugger();
				
				
			}
			
			else if($server == 3 || $server == '3'){
			
				$this->email->from('gdpc.webint.bea-l2@hp.com', 'Adrian Tan');
				$this->email->to('kristin-aimee.gan@hp.com, jestine-bernice.tomas@hp.com, gdpc.webint.bea-l2@hp.com, carlos-luigi-r.dela-cruz@hp.com'); 
				$this->email->cc('adrian-lester.tan@hp.com'); 
				$this->email->subject('Server VPN Disconnected');
				$header = '';
				if($http_status != 401){
					$header = "
						Hi.<br/><br/>
						This is to notify you that the VPN connection of 16.178.45.0 has been disconnected. <br/><br/>
						Please connect to the  server via Remote Desktop  Connection<br/>
						Username: LAGMANR7\hpadmin<br/>
						Password: \$picOPSmcc001<br/><br/>
						
						Impacted application(s):<br/>
						- Siren v2 <br/>
						- Nagger <br/>
						- DM Assistant Tool <br/>
					";
				
					$this->email->message($header);	

					$this->email->send();

					echo $this->email->print_debugger();
				}
				else{
					//Wrong password
					//$header = $emailContent.'<br/>Currently used account is: '.PGUSERNAME.'.';
				}
				
				
				
				
			}
		}
		
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>