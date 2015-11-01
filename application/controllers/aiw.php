<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class aiw extends CI_Controller {

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
		
		/*
		$this->load->library('email');
		$config['protocol'] = 'smtp';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['smtp_host'] = 'smtp3.hp.com';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		
		ini_set('max_execution_time', 600);
		*/
		$this->showHomePage('');
		//$this->showTicketQueue("G.ABEA2LVL");
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('/nagger/', 'refresh');
	}
	
	function showHomePage($msg){
		if($msg=='Array')
			$msg='';
			
		$template['title'] = 'Application Information Warehosue';
		$template['navbar'] = '';
		$template['msg'] = $msg;
		
		$template['appList'] = $this->appwarehouse_model->getAppList();
		$template['content'] = $this->load->view('appwarehouse_view/home_view', $template,true);
		$this->load->view('appwarehouse_view/template_main', $template);
	}
	
	function showAppInfo($id){
	
	
		$template['title'] = 'Application Information Warehouse';
		$template['navbar'] = '';
		
		
		$appInfo = $this->appwarehouse_model->getAppInfo($id);
		$appSlmList = $this->appwarehouse_model->getSlmList($id);
		$appXomList = $this->appwarehouse_model->getXomList($id);
		$appCiList = $this->appwarehouse_model->getCiList($id);
		$appIncidentsPerCi = $this->appwarehouse_model->getIncidentsMapCi($id);
		$appServiceNameList = $this->appwarehouse_model->getServiceNameList($id);
		
		
		
		//Process Data
		$imProcessList = $this->appwarehouse_model->getImProcessList($id);
		$pmProcessList = $this->appwarehouse_model->getPmProcessList($id);
		$configMProcessList = $this->appwarehouse_model->getConfigMProcessList($id);
		
		//new
		$chmProcessList = $this->appwarehouse_model->getChmProcessList($id);
		$cpmProcessList = $this->appwarehouse_model->getCpmProcessList($id);
		$securityProcessList = $this->appwarehouse_model->getSecuProcessList($id);
		$eventProcessList = $this->appwarehouse_model->getEventProcessList($id);
		$acceptanceProcessList = $this->appwarehouse_model->getAcceptanceProcessList($id);
		$pm2ProcessList = $this->appwarehouse_model->getPmProcessList_2($id);
		$olaProcessList = $this->appwarehouse_model->getOlaProcessList($id);
		$supportSchedule = $this->appwarehouse_model->getSupportSchedule($id);
		$ciList = $this->appwarehouse_model->getCi($id);
		
		$template['appInfo'] = $appInfo;
		$template['appSlmList'] = $appSlmList;
		$template['appXomList'] = $appXomList;
		$template['appCiList'] = $appCiList;
		$template['appIncidentsPerCi'] = $appIncidentsPerCi;
		$template['appServiceNameList'] = $appServiceNameList;
		
		//Process Data
		$template['imProcessList'] = $imProcessList;
		$template['pmProcessList'] = $pmProcessList;
		$template['configMProcessList'] = $chmProcessList;
		
		
		//new
		$template['chmProcessList'] = $chmProcessList;
		$template['cpmProcessList'] = $cpmProcessList;
		$template['securityProcessList'] = $securityProcessList;
		$template['eventProcessList'] = $eventProcessList;
		$template['acceptanceProcessList'] = $acceptanceProcessList;
		$template['pm2ProcessList'] = $pm2ProcessList;
		$template['olaProcessList'] = $olaProcessList;
		$template['supportSchedule'] = $supportSchedule;
		$template['ciList'] = $ciList;
		
		
		$template['id'] = $id;
		
		$template['content'] = $this->load->view('appwarehouse_view/appinfo_view', $template,true);
		$this->load->view('appwarehouse_view/template_main', $template);
	}
	function editPage(){
	
	
		$template['title'] = 'Application Information Warehouse';
		$template['navbar'] = '';
		
		$id = $this->input->post('id');
		
		//application details
		$appInfo = $this->appwarehouse_model->getAppInfo($id);
		$template['appInfo'] = $appInfo;
		
		//end of application details
		
		//slm details
		$appSlmList = $this->appwarehouse_model->getSlmList($id);
		$template['appSlmList'] = $appSlmList;
		
		//end of slm details
		
		//xom information
		$appXomList = $this->appwarehouse_model->getXomList($id);
		$template['appXomList'] = $appXomList;
		//end of xom
		
		$template['id'] = $id;
		
		$template['content'] = $this->load->view('appwarehouse_view/editPage', $template,true);
		$this->load->view('appwarehouse_view/template_main', $template);
	}
	
	
	/* function update(){
		/* for updating details in the application
		 
		
			$id = $this->input->post('id');
			$des = $this->input->post('des');
			$sdde = $this->input->post('sdde'); 
			
			$slm_id = $this->input->post('slm_id'); 
			$slm_n = $this->input->post('slm_name'); 
			$slm_e = $this->input->post('slm_email'); 
			
			$xom_id = $this->input->post('xom_id'); 
			$xom_n = $this->input->post('xom_name'); 
			$xom_e = $this->input->post('xom_email'); 
			
			
			$this->appwarehouse_model->updateSlm($slm_id,$slm_n,$slm_e);
			$this->appwarehouse_model->updateXom($xom_id,$xom_n,$xom_e);
			$success = $this->appwarehouse_model->updateApp($id,$des,$sdde);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);

	} */
	
	function editApp(){
		
			$id = $this->input->post('id');
			$name = $this->input->post('name');
			$des = $this->input->post('des');
			$logo = $this->input->post('logo'); 
			$sdde = $this->input->post('sdde'); 
			
			$success = $this->appwarehouse_model->updateApp($id,$name,$des,$logo,$sdde);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
	}
	
	function editSlm(){
			$id_page = $this->input->post('id_page');
			$id = $this->input->post('id');
			$slm_name = $this->input->post('slm_name');
			$email = $this->input->post('email');
			
			
			$success = $this->appwarehouse_model->updateSlm($id,$slm_name,$email);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id_page);
	}
	
	function editXom(){
			$id_page = $this->input->post('id_page');
			$id = $this->input->post('id');
			$xom_name = $this->input->post('xom_name');
			$email = $this->input->post('email');
			
			
			$success = $this->appwarehouse_model->updateXom($id,$xom_name,$email);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id_page);
	}
	
	function updateSupportSched(){
			$id_page = $this->input->post('id_page');
			$id = $this->input->post('id');
			$group = $this->input->post('group');
			$sched = $this->input->post('sched');
			
			
			$success = $this->appwarehouse_model->updateSupportSched($id,$group,$sched);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id_page);
	}
	
	function updateOla(){
			$id_page = $this->input->post('id_page');
			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$link = $this->input->post('link');
			
			
			$success = $this->appwarehouse_model->updateOla($id,$team,$link);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id_page);
	}
	
	function deleteSupportSched(){
			$id_page = $this->input->post('id_page');
			$id = $this->input->post('id');
			
			
			
			$success = $this->appwarehouse_model->deleteSS($id);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id_page);
	}
	
	function deleteOla(){
			$id_page = $this->input->post('id_page');
			$id = $this->input->post('id');
			
			
			
			$success = $this->appwarehouse_model->deleteOla($id);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id_page);
	}
	
	function deleteSlm(){
			$id_page = $this->input->post('id_page');
			$id = $this->input->post('id');
			
			
			
			$success = $this->appwarehouse_model->deleteSlm($id);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id_page);
	}
	function deleteXom(){
			$id_page = $this->input->post('id_page');
			$id = $this->input->post('id');
			
			
			
			$success = $this->appwarehouse_model->deleteXom($id);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id_page);
	}
	function insertSlm(){
		
			
			$id = $this->input->post('id');
			$slm = $this->input->post('slm');
			$email = $this->input->post('email'); 
			
			
			
			
			$success = $this->appwarehouse_model->insertSlm($id,$slm,$email);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
			
			
		
	} 
	
	function insertXom(){
		
			
			$id = $this->input->post('id');
			$xom = $this->input->post('xom');
			$email = $this->input->post('email'); 
			
			
			
			
			$success = $this->appwarehouse_model->insertXom($id,$xom,$email);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
			
			
		
	} 
	function update_im(){
		/* for updating details in the application
		 */
		
			$app_id = $this->input->post('app_id');
			
			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$email = $this->input->post('email'); 
			$doc = $this->input->post('doc'); 
			$comms = $this->input->post('comms'); 
			
			
			
			$success = $this->appwarehouse_model->updateImInfo($id,$team,$email,$doc,$comms);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$app_id);
			
			
		
	} 
	
	function insert_im(){
		/* for updating details in the application
		 */
		
			//$app_id = $this->input->post('app_id');
			
			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$email = $this->input->post('email'); 
			$doc = $this->input->post('doc'); 
			$comms = $this->input->post('comms'); 
			
			
			
			$success = $this->appwarehouse_model->insertImInfo($id,$team,$email,$doc,$comms);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
			
			
		
	} 
	
	 function update_prob(){
		/* for updating details in the application
		 */
		
			$app_id = $this->input->post('app_id');
			
			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$email = $this->input->post('email'); 
			$doc = $this->input->post('doc'); 
			$comms = $this->input->post('comms'); 
			
			
			
			$success = $this->appwarehouse_model->updateProbInfo($id,$team,$email,$doc,$comms);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$app_id);
			
			
		
	} 
	
	function insert_prob(){
		/* for updating details in the application
		 */
		
			//$app_id = $this->input->post('app_id');
			
			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$email = $this->input->post('email'); 
			$doc = $this->input->post('doc'); 
			$comms = $this->input->post('comms'); 
			
			
			
			$success = $this->appwarehouse_model->insertProbInfo($id,$team,$email,$doc,$comms);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
			
			
		
	} 
	 function update_change(){
		/* for updating details in the application
		 */
		
			$app_id = $this->input->post('app_id');
			
			$id = $this->input->post('id');
			$mgr = $this->input->post('mgr');
			$app = $this->input->post('app'); 
			$platform = $this->input->post('platform'); 
			$entcab = $this->input->post('entcab'); 
			$cab = $this->input->post('cab'); 
			$doc = $this->input->post('doc'); 
			
			
			
			$success = $this->appwarehouse_model->updateChangeInfo($id,$mgr,$app,$platform,$entcab,$cab,$doc);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$app_id);
			
			
		
	} 
	
	function insert_change(){
		/* for updating details in the application
		 */
		
			
			$id = $this->input->post('id');
			$mgr = $this->input->post('mgr');
			$app = $this->input->post('app'); 
			$platform = $this->input->post('platform'); 
			$entcab = $this->input->post('entcab'); 
			$cab = $this->input->post('cab'); 
			$doc = $this->input->post('doc'); 
			
			
			
			$success = $this->appwarehouse_model->insertChangeInfo($id,$mgr,$app,$platform,$entcab,$cab,$doc);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
			
			
		
	} 
	
	function update_capacity(){
		/* for updating details in the application
		 */
		
			$app_id = $this->input->post('app_id');
			
			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$doc = $this->input->post('doc'); 

			$success = $this->appwarehouse_model->updateCapacityInfo($id,$team,$doc);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$app_id);
			
			
		
	} 
	
	function insert_capacity(){
		/* for updating details in the application
		 */
		
			
			
			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$doc = $this->input->post('doc'); 

			$success = $this->appwarehouse_model->insertCapacityInfo($id,$team,$doc);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
			
			
		
	} 
	
	function update_security(){
		/* for updating details in the application
		 */
		
			$app_id = $this->input->post('app_id');
			
			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$doc = $this->input->post('doc'); 

			$success = $this->appwarehouse_model->updateSecurityInfo($id,$team,$doc);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$app_id);
			
			
		
	} 
	
	function insert_security(){
		/* for updating details in the application
		 */
		
			
			
			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$doc = $this->input->post('doc'); 

			$success = $this->appwarehouse_model->insertSecurityInfo($id,$team,$doc);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
			
			
		
	} 
	
	function update_event(){
		/* for updating details in the application
		 */
		
			$app_id = $this->input->post('app_id');
			
			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$doc = $this->input->post('doc'); 

			$success = $this->appwarehouse_model->updateEventInfo($id,$team,$doc);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$app_id);
			
			
		
	} 
	
	function insert_event(){
		/* for updating details in the application
		 */
		

			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$doc = $this->input->post('doc'); 

			$success = $this->appwarehouse_model->insertEventInfo($id,$team,$doc);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
			
			
		
	} 
	
	function update_acceptance(){
		/* for updating details in the application
		 */
		
			$app_id = $this->input->post('app_id');
			
			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$doc = $this->input->post('doc');
			$req = $this->input->post('req');
			$tab = $this->input->post('tab');			

			$success = $this->appwarehouse_model->updateAcceptanceInfo($id,$team,$doc,$req,$tab);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$app_id);
			
			
		
	} 
	
	function insert_acceptance(){
		/* for updating details in the application
		 */
		
			
			
			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$doc = $this->input->post('doc');
			$req = $this->input->post('req');
			$tab = $this->input->post('tab');			

			$success = $this->appwarehouse_model->insertAcceptanceInfo($id,$team,$doc,$req,$tab);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
			
			
		
	} 
	
	function insert_ola(){
		/* for updating details in the application
		 */

			$id = $this->input->post('id');
			$team = $this->input->post('team');
			$link = $this->input->post('link');
					

			$success = $this->appwarehouse_model->insertOlaInfo($id,$team,$link);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
			
			
		
	} 
	
	function insert_ss(){
		/* for updating details in the application
		 */

			$id = $this->input->post('id');
			$group = $this->input->post('group');
			$sched = $this->input->post('sched');
					

			$success = $this->appwarehouse_model->insertSupportSchedule($id,$group,$sched);
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
			
			
		
	} 
	
	function map_ci(){
		/* 
		 */

			$id = $this->input->post('id');
			$ci = $this->input->post('ci');
			
			foreach($ci as $key=>$value)
			{
			$success = $this->appwarehouse_model->mapCi($id,$ci[$key]);
			}
			
			if($success == TRUE)
				redirect('aiw/showAppInfo/'.$id);
			
			
		
	} 
	
	// EDIT PAGE ITEY
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */