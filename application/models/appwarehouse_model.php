<?php
class appwarehouse_model extends CI_Model {
	

	function storeData($cockpit, $used, $capacity, $free){
	
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$date = date('Y-m-d');
		$time = date('H:i');
		$sql = "
		INSERT INTO capacity_log(
			cockpit, used, capacity, free, date, time
		)
		VALUES(
			'$cockpit', $used, $capacity, $free, '$date', '$time'
		);
		
		";
		$this->db->query($sql);
	}
	
	function getDB(){
		return $this->load->database('appwarehouse_db', TRUE);;
	}
	
	
	
	function getAppList(){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM application_table;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->result();
		}
		else{
			$aiw_db->close();
			return null;
		}
		
	}
	
	function getAppInfo($id){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM application_table WHERE id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->first_row();
		}
		else{
			$aiw_db->close();
			return null;
		}
	}
	

	
	function getSlmList($id){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM slm_table WHERE app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->result();
		}
		else{
			$aiw_db->close();
			return null;
		}
	}
	
	function getXomList($id){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM xom_table WHERE app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->result();
		}
		else{
			$aiw_db->close();
			return null;
		}
	}
	
	function getCiList($id){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT b.ci as ci_name FROM app_ci a, ci_table b where a.app_id = $id and a.ci_id=b.id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->result();
		}
		else{
			$aiw_db->close();
			return null;
		}
	}
	
	function getServiceNameList($id){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT b.service as service FROM app_service a, service b 
		WHERE a.app_id = $id
		AND a.serv_id = b.id ;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->result_array();
		}
		else{
			$aiw_db->close();
			return null;
		}
	}
	
	function getImProcessList($id){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM im_process_table where app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->first_row();
		}
		else{
			$aiw_db->close();
			return null;
		}
	}
	
	//added by pey
	
	function getChmProcessList($id){
	$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM chm_process_table where app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->first_row();
		}
		else{
			$aiw_db->close();
			return null;
		}
	
	
	}
	
	function getCpmProcessList($id){
	$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM cpm_process_table where app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->first_row();
		}
		else{
			$aiw_db->close();
			return null;
		}
	
	
	}
	
	function getSecuProcessList($id){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM security_process_table where app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->first_row();
		}
		else{
			$aiw_db->close();
			return null;
		}
	
	
	}
	
	function getEventProcessList($id){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM events_process_table where app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->first_row();
		}
		else{
			$aiw_db->close();
			return null;
		}
	
	
	}
	
	function getAcceptanceProcessList($id){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM acceptance_process_table where app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->first_row();
		}
		else{
			$aiw_db->close();
			return null;
		}
	
	
	}
	
	function getPmProcessList_2($id){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM pm_process_table where app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->first_row();
		}
		else{
			$aiw_db->close();
			return null;
		}
	
	
	}
	
	
	// end of amendments 
	
	function getPmProcessList($id){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM pm_process_table where app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->result();
		}
		else{
			$aiw_db->close();
			return null;
		}
	}
	
	function getConfigMProcessList($id){
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM pm_process_table where app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->result();
		}
		else{
			$aiw_db->close();
			return null;
		}
	}
	
	function getIncidentsMapCi($appId){
		$sql = "
			SELECT * FROM sitequota.incidents
			WHERE affected_ci IN(
				SELECT b.ci FROM appwarehouse.app_ci a, appwarehouse.ci_table b, appwarehouse.application_table c
				WHERE a.app_id = c.id
				AND a.ci_id = b.id
				AND b.VISIBILITY = 'VISIBLE'
				AND a.app_id = $appId
			)
			AND current_status != 'Closed'
			GROUP BY incident_number;
		";
		
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getIncidentsMapService($service){
		$sql = "
			SELECT * FROM sitequota.incidents
			WHERE service = '$service'
			AND current_status != 'Closed'
			GROUP BY incident_number;
		";
		// We group by to get the distinct incident_number because there may be multiple IMs due to multiple teams
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	//changes by pey :)
	
	public function updateApp($id,$name,$des,$logo,$sdde){
		/* Updates the details of a specific application
		 */
		
		$queryStr = "UPDATE appwarehouse.application_table SET app_name='$name',description='$des',logo_url='$logo',SDDE_URL='$sdde' WHERE id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
		
		
	}
	
	
	
	public function updateXom($id,$xom_name,$email){
		/* Updates the details of a specific application
		 */
		
		$queryStr = "UPDATE appwarehouse.xom_table SET xOM_name='$xom_name',email='$email' WHERE id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function updateSupportSched($id,$group,$sched){
		/* Updates the details of a specific application
		 */
		
		$queryStr = "UPDATE appwarehouse.support_schedule_table SET support_group='$group',support_schedule='$sched' WHERE id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function updateOla($id,$team,$link){
		/* Updates the details of a specific application
		 */
		
		$queryStr = "UPDATE appwarehouse.ola_process_table SET team_relation_field='$team',ola_link='$link' WHERE id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	public function deleteSS($id){
		/* Updates the details of a specific application
		 */
		
		$queryStr = "DELETE from appwarehouse.support_schedule_table where id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function deleteOla($id){
		/* Updates the details of a specific application
		 */
		
		$queryStr = "DELETE from appwarehouse.ola_process_table where id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function deleteSlm($id){
		/* Updates the details of a specific application
		 */
		
		$queryStr = "DELETE from appwarehouse.slm_table where id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function deleteXom($id){
		/* Updates the details of a specific application
		 */
		
		$queryStr = "DELETE from appwarehouse.xom_table where id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	public function updateImInfo($id,$team,$email,$doc,$comms){
		/* Updates the details of Problem Information
		 */
		
		$queryStr = "UPDATE appwarehouse.im_process_table SET team_spoc='$team',team_spoc_email='$email',process_doc_link='$doc',comms_template='$comms' WHERE id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function updateProbInfo($id,$team,$email,$doc,$comms){
		/* Updates the details of Problem Information
		 */
		
		$queryStr = "UPDATE appwarehouse.pm_process_table SET team_spoc='$team',team_spoc_email='$email',process_doc_link='$doc',comms_template='$comms' WHERE id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}


	public function updateChangeInfo($id,$mgr,$app,$platform,$entcab,$cab,$doc){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "UPDATE appwarehouse.chm_process_table SET change_manager='$mgr',app_change_window='$app',platform_change_window='$platform',entcab_schedule='$entcab',cab_schedule='$cab',process_doc_link='$doc' WHERE id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	
	public function updateCapacityInfo($id,$team,$doc){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "UPDATE appwarehouse.cpm_process_table SET team_spoc='$team',process_doc_link='$doc'  WHERE id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function updateSecurityInfo($id,$team,$doc){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "UPDATE appwarehouse.security_process_table SET team_spoc='$team',process_doc_link='$doc'  WHERE id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function updateEventInfo($id,$team,$doc){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "UPDATE appwarehouse.events_process_table SET team_spoc='$team',process_doc_link='$doc'  WHERE id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function updateAcceptanceInfo($id,$team,$doc,$req,$tab){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "UPDATE appwarehouse.acceptance_process_table SET team_spoc='$team',process_doc_link='$doc',request_template='$req',tab_template='$tab'  WHERE id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function insertProbInfo($id,$team,$email,$doc,$comms){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "INSERT INTO appwarehouse.pm_process_table(app_id,team_spoc,team_spoc_email,process_doc_link,comms_template) VALUES('$id','$team','$email','$doc','$comms');";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	
	public function insertChangeInfo($id,$mgr,$app,$platform,$entcab,$cab,$doc){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "INSERT INTO appwarehouse.chm_process_table(app_id,change_manager,app_change_window,platform_change_window,entcab_schedule,cab_schedule,process_doc_link) VALUES('$id','$mgr','$app','$platform','$entcab','$cab','$doc');";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function insertCapacityInfo($id,$team,$doc){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "INSERT INTO appwarehouse.cpm_process_table(app_id,team_spoc,process_doc_link) VALUES('$id','$team','$doc');";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	
	public function insertSecurityInfo($id,$team,$doc){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "INSERT INTO appwarehouse.security_process_table(app_id,team_spoc,process_doc_link) VALUES('$id','$team','$doc');";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	
	public function insertEventInfo($id,$team,$doc){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "INSERT INTO appwarehouse.events_process_table(app_id,team_spoc,process_doc_link) VALUES('$id','$team','$doc');";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function insertAcceptanceInfo($id,$team,$doc,$req,$tab){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "INSERT INTO appwarehouse.acceptance_process_table(app_id,team_spoc,process_doc_link,request_template,tab_template) VALUES('$id','$team','$doc','$req','$tab');";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function insertImInfo($id,$team,$email,$doc,$comms){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "INSERT INTO appwarehouse.im_process_table(app_id,team_spoc,team_spoc_email,process_doc_link,comms_template) VALUES('$id','$team','$email','$doc','$comms');";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function insertOlaInfo($id,$team,$link){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "INSERT INTO appwarehouse.ola_process_table(app_id,team_relation_field,ola_link) VALUES('$id','$team','$link');";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	
	public function insertSupportSchedule($id,$group,$sched){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "INSERT INTO appwarehouse.support_schedule_table(app_id,support_group,support_schedule) VALUES('$id','$group','$sched');";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function insertSlm($id,$slm,$email){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "INSERT INTO appwarehouse.slm_table(app_id,slm_name,email) VALUES('$id','$slm','$email');";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function updateSlm($id,$slm_name,$email){
		
		
		$queryStr = "UPDATE appwarehouse.slm_table SET slm_name='$slm_name',email='$email'  WHERE id='$id';";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	
	public function insertXom($id,$xom,$email){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "INSERT INTO appwarehouse.xom_table(app_id,xom_name,email) VALUES('$id','$xom','$email');";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	public function mapCi($id,$ci){
		/* Updates the details of Change Information
		 */
		
		$queryStr = "INSERT INTO appwarehouse.app_ci(app_id,ci_id) VALUES('$id','$ci');";
		$query = $this->db->query($queryStr);
		return true;
		
	}
	public function getOlaProcessList($id){
		
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM ola_process_table where app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->result();
		}
		else{
			$aiw_db->close();
			return null;
		}
		
	}
	
	public function getSupportSchedule($id){
		
		$aiw_db = $this->getDB();
		
		$sql = "SELECT * FROM support_schedule_table where app_id = $id;";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->result();
		}
		else{
			$aiw_db->close();
			return null;
		}
		
	}
	
	public function getCi($id){
		
		$aiw_db = $this->getDB();
		//SELECT * FROM appwarehouse.service WHERE id NOT IN (SELECT serv_id FROM appwarehouse.app_service)
		$sql = "select ci_table.id, ci from ci_table
					where ci not in (select ci from app_ci
					inner join ci_table
					on ci_table.id = app_ci.ci_id
					where app_id = '$id')";
		$query = $aiw_db->query($sql);
		
		if($query->num_rows()>0){
			$aiw_db->close();
			return $query->result();
		}
		else{
			$aiw_db->close();
			return null;
		}
		
	}
}
?>