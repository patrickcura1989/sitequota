<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class capacityreport extends CI_Controller {

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
		redirect('/capacityreport/', 'refresh');
	}
	
	function showLoginPage($msg){
		if($msg=='Array')
			$msg='';
			
		$template['title'] = 'Cockpits Capacity Report';
		$template['navbar'] = '';
		//$template['msg'] = $msg;
		
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
		$template['content'] = $this->load->view('login_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
	
	function showFrArchive(){
		//check user session here
		if($this->session->userdata('email')== null && $this->session->userdata('email')== ''){
			$this->logout();
		}
		$template['title'] = 'FR Archive';
		$template['frArr'] = $this->sitequota_model->getFrArchive();
		$template['content'] = $this->load->view('fr_archive_view', $template,true);
		$this->load->view('template_main', $template);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */