<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class queueloader extends CI_Controller {

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
	
		/*check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		*/
		
		$this->load->library('email');
		$config['protocol'] = 'smtp';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['smtp_host'] = 'smtp3.hp.com';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		include("lib/simplehtmldom/simple_html_dom.php");
		ini_set('max_execution_time', 600);
		//$this->showHome('');
		$this->showMainPage();
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('../', 'refresh');
	}
	
	function getQueueList(){
		return array(
			"N.AID"
			
		);
	}
	
	function showMainPage(){
		
		$this->load->view("swat_view");
		
	}
	
	function showSmTracker(){
		//START RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		//START RECORDING LOAD TIME
		
		
		$url = "http://smtracker.pg.com/pls/smtracker/pg_tracker.inc_groups";
		$queueArr = $this->getQueueList();
		for($i=0; $i<count($queueArr); $i++){
			$datatopost = array (
				"i_group" => $queueArr[$i]
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
			echo "<br/>";
			
			
			/*
			$html = str_get_html($output);
			$anchorArray = $html->find('a');
			echo "Tickets in Queue of ".$queue.":<br/>";
			echo "<ul>";
			for($i=0; $i<count($anchorArray); $i++){
				if(strpos($anchorArray[$i], "IM")){
					$pos = strpos($anchorArray[$i], "IM");
					$string = substr($anchorArray[$i], $pos, 10);
					echo "<li>".$string."</li>";
				}
			}
			echo "</ul>";
			*/
		}
		curl_close($ch);
		echo $output;
		
		
		//END RECORDING LOAD TIME
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */