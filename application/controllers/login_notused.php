<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
		if($this->session->userdata('email')!=null && $this->session->userdata('email')!=''){
			$this->logout();
		}
		
		$this->showLoginPage('');
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('/login/', 'refresh');
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
			$form = 'login/processLoginLdap'; 
		}
		else{
			$form = 'index.php/login/processLoginLdap/';
		}
			
		$template['form'] = $form;
		$template['content'] = $this->load->view('login_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	function processLoginLdap(){
	
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		if($email == "adrian-lester.tan@hp.com" && $password == "12345"){
		
			$this->session->set_userdata('profileImgSrc', 'http://pictures.core.hp.com/images/medium_ap_tanad_6748.jpg');
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('employeeName', 'Adrian Tan');
			$this->showHome();
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
					$domainName = $result->Data->ntUserDomainId;
					$employeeName = $result->Data->givenName.' '.$result->Data->sn;
					
				
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
				
				$this->showHome();
			}
			else{
				echo "Login failed.";
			}	
		}
	}
	
	function showHome(){
		redirect('/nagger/', 'refresh');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */