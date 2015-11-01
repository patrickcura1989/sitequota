<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dashboard extends CI_Controller {

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
		
		ini_set('max_execution_time', 600);
		$this->showDashboard('');
		
	}
	
	
	function showDashboard($msg){
		if($msg=='Array')
			$msg='';
			
		$template['title'] = 'Cockpits Site Quota Dashboard';
		$template['cockpitsArr'] = $this->capacityreport_model->getCockpitsThreshold();
		$this->load->view('dashboard_view', $template);	
	}
	
	
	
	
}
