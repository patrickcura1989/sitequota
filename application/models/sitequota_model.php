<?php
class sitequota_model extends CI_Model {
	

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
	
	function getImList(){
		$sql = "SELECT * FROM incidents WHERE current_status != 'Closed' ORDER BY queue ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	
	}
	
	function getImListOwningTeam($owningTeam){
		$sql = "SELECT * FROM incidents WHERE current_status != 'Closed' 
		AND owning_team = $owningTeam ORDER BY queue ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getImLimit10(){
		$sql = "SELECT * 
				FROM incidents WHERE current_status != 'Closed'
				ORDER BY sync_date ASC, sync_time ASC
				LIMIT 10;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getImArchive(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM incidents WHERE owning_team = $team ORDER BY current_status DESC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getImArchiveOutOfScope(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM incidents_outofscope WHERE owning_team = $team ORDER BY current_status DESC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	
	function getImListQueue(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM incidents 
		WHERE current_status != 'Closed'
		AND owning_team =  $team
		ORDER BY queue ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	
	}
	
	function getImListQueuePriority(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM incidents 
		WHERE current_status != 'Closed'
		AND owning_team =  $team
		AND prioritize = 0
		ORDER BY queue ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	
	}
	
	function getImListUser(){
		$empNum = $this->session->userdata('empNum');
		$sql = "SELECT * FROM incidents 
		WHERE current_status != 'Closed'
		AND owner =  '$empNum'
		ORDER BY queue ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	
	}
	
	function getImListMember($empNum){
		
		$sql = "SELECT * FROM incidents 
		WHERE current_status != 'Closed'
		AND owner =  '$empNum'
		ORDER BY queue ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	
	}
	
	
	function getTeamName($teamId){
		$sql = "
			SELECT * FROM owning_team WHERE id = $teamId;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->owning_team;
		}
		else{
			return null;
		}
	}
	
	function getUserData($empId){
		$sql = "
			SELECT * FROM user WHERE emp_id = '$empId';
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row();
		}
		else{
			return null;
		}
	}
	
	function getTeamId($empNumber){
		$sql = "
			SELECT * FROM user WHERE emp_id = '$empNumber';
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->team;
		}
		else{
			return null;
		}
	}
	
	function getImDanger(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM incidents WHERE current_status != 'Closed' 
		AND owning_team = $team
		AND (sla_percent+0.0 >= 80.0 AND sla_percent+0.0 < 100.0);";
		$query = $this->db->query($sql);
		
		return $query->num_rows();
	}
	
	function getImDangerUser(){
		$empNum = $this->session->userdata('empNum');
		$sql = "SELECT * FROM incidents WHERE current_status != 'Closed' 
		AND owner = '$empNum'
		AND (sla_percent+0.0 >= 80.0 AND sla_percent+0.0 < 100.0);";
		$query = $this->db->query($sql);
		
		return $query->num_rows();
	}
	
	function getImMissed(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM incidents WHERE current_status != 'Closed' 
		AND owning_team = $team
		AND (sla_percent+0.0 >= 100.0);";
		$query = $this->db->query($sql);
		
		return $query->num_rows();
	}
	
	function getImMissedUser(){
		$empNum = $this->session->userdata('empNum');
		$sql = "SELECT * FROM incidents WHERE current_status != 'Closed' 
		AND owner = '$empNum'
		AND (sla_percent+0.0 >= 100.0);";
		$query = $this->db->query($sql);
		
		return $query->num_rows();
	}
	
	function getFrDanger(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM fulfillment WHERE status != 'Closed' 
		AND owning_team = $team
		AND (sla_percent+0.0 >= 80.0 AND sla_percent+0.0 < 100.0);";
		$query = $this->db->query($sql);
		
		return $query->num_rows();
	}
	
	function getFrDangerUser(){
		$empNum = $this->session->userdata('empNum');
		$sql = "SELECT * FROM fulfillment WHERE status != 'Closed' 
		AND owner = '$empNum'
		AND (sla_percent+0.0 >= 80.0 AND sla_percent+0.0 < 100.0);";
		$query = $this->db->query($sql);
		
		return $query->num_rows();
	}
	
	function getFrMissed(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM fulfillment WHERE status != 'Closed' 
		AND owning_team = $team
		AND (sla_percent+0.0 >= 100.0);";
		$query = $this->db->query($sql);
		
		return $query->num_rows();
	}
	
	function getFrMissedUser(){
		$empNum = $this->session->userdata('empNum');
		$sql = "SELECT * FROM fulfillment WHERE status != 'Closed' 
		AND owner = '$empNum'
		AND (sla_percent+0.0 >= 100.0);";
		$query = $this->db->query($sql);
		
		return $query->num_rows();
	}
	
	function getFrList(){
		$sql = "SELECT * FROM fulfillment WHERE status != 'Closed' ORDER BY assignment_group ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	
	}
	
	function getFrListOwningTeam($owningTeam){
		$sql = "SELECT * FROM fulfillment WHERE status != 'Closed' AND owning_team = $owningTeam ORDER BY assignment_group ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getFrLimit10(){
		$sql = "SELECT *
				FROM fulfillment WHERE STATUS != 'Closed'
				ORDER BY sync_date ASC, sync_time ASC
				LIMIT 10;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	
	function getFrArchive(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM fulfillment WHERE owning_team = $team ORDER BY status DESC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getFrArchiveOutOfScope(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM fulfillment_outofscope WHERE owning_team = $team ORDER BY status DESC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getFrListQueue(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM fulfillment 
		WHERE status != 'Closed' 
		AND owning_team = $team
		ORDER BY assignment_group ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	
	}
	
	function getFrListQueuePriority(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM fulfillment 
		WHERE status != 'Closed' 
		AND owning_team = $team
		AND prioritize = 0
		ORDER BY assignment_group ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	
	}
	
	
	function getFrListUser(){
		$empNum = $this->session->userdata('empNum');
		$sql = "SELECT * FROM fulfillment 
		WHERE status != 'Closed' 
		AND owner = '$empNum'
		ORDER BY assignment_group ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	
	}
	
	function getFrListMember($empNum){
		
		$sql = "SELECT * FROM fulfillment 
		WHERE status != 'Closed' 
		AND owner = '$empNum'
		ORDER BY assignment_group ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	
	}
	
	function getClosedIncidents($month, $day, $year){
		$team = $this->session->userdata('teamId');
		$sqlTotal = "SELECT *  FROM incidents
		WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month 
		AND DAY(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $day
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND owning_team = $team;";
		
		$queryTotal = $this->db->query($sqlTotal);
		return $queryTotal->num_rows();
	}
	
	function getCwtIncidents($month, $day, $year){
		$team = $this->session->userdata('teamId');
		$sqlCwt = "
		SELECT * FROM incidents
		WHERE (MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))=  $month
		AND DAY(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $day
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year)
		AND STR_TO_DATE(CONCAT(cwt_date,' ',cwt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(target_date, '%d-%b-%y %H:%i:%s')
		AND owning_team = $team;
		;";
		
		$queryCwt = $this->db->query($sqlCwt);
		return $queryCwt->num_rows();
	}
	
	function getCwtIncidentsMonth($month, $year){
		$team = $this->session->userdata('teamId');
		$sql = "
			SELECT * FROM incidents
			WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))=  $month
			AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
			AND STR_TO_DATE(CONCAT(cwt_date,' ',cwt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(target_date, '%d-%b-%y %H:%i:%s')
			AND owning_team = $team;
		";
		$cwtCount = $this->db->query($sql);
		$cwtCount = $cwtCount->num_rows();
		
		$sql = "
			SELECT * FROM incidents
			WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month
			AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
			AND owning_team = $team
			AND cwt_date IS NOT NULL;
		";
		$cwtTotal = $this->db->query($sql);
		$cwtTotal = $cwtTotal->num_rows();
		
		if($cwtTotal == 0)
			return 0;
		else
			return round(($cwtCount / $cwtTotal)*100, 2);
	}	
	
	function getSwtIncidents($month, $day, $year){
		$team = $this->session->userdata('teamId');
		$sqlSwt = "
		SELECT * FROM incidents
		WHERE (MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month
		AND DAY(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $day
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year)
		AND STR_TO_DATE(CONCAT(swt_date,' ',swt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(target_date, '%d-%b-%y %H:%i:%s')
		AND owning_team = $team;";
		
		$querySwt = $this->db->query($sqlSwt);
		return $querySwt->num_rows();
	}	
	
	function getSwtIncidentsMonth($month, $year){
		$team = $this->session->userdata('teamId');
		$sql = "
		SELECT * FROM incidents
		WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND STR_TO_DATE(CONCAT(swt_date,' ',swt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(target_date, '%d-%b-%y %H:%i:%s')
		AND owning_team = $team;";
		
		$swtCount = $this->db->query($sql);
		$swtCount = $swtCount->num_rows();
		
		$sql = "
		SELECT * FROM incidents
		WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND owning_team = $team
		AND cwt_date IS NOT null;";
		
		$swtTotal = $this->db->query($sql);
		$swtTotal = $swtTotal->num_rows();
		
		if($swtTotal == 0)
			return 0;
		else
			return round(($swtCount / $swtTotal)*100, 2);
	}
	
	
	function getClosedFulfillment($month, $day, $year){
		$team = $this->session->userdata('teamId');
		$sqlTotal = "SELECT *  FROM fulfillment
		WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month 
		AND DAY(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $day
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND owning_team = $team;";
		
		$queryTotal = $this->db->query($sqlTotal);
		return $queryTotal->num_rows();
	}
	
	function getCwtFulfillment($month, $day, $year){
		$team = $this->session->userdata('teamId');
		$sqlCwt = "
		SELECT * FROM fulfillment
		WHERE (MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))=  $month
		AND DAY(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $day
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year)
		AND STR_TO_DATE(CONCAT(cwt_date,' ',cwt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(sla, '%d-%b-%y %H:%i:%s')
		AND owning_team = $team;";
		
		$queryCwt = $this->db->query($sqlCwt);
		return $queryCwt->num_rows();
	}
	
	function getCwtFulfillmentMonth($month, $year){
		$team = $this->session->userdata('teamId');
		$sql = "
			SELECT * FROM fulfillment
			WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))=  $month
			AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
			AND STR_TO_DATE(CONCAT(cwt_date,' ',cwt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(sla, '%d-%b-%y %H:%i:%s')
			AND owning_team = $team;
		";
		$cwtCount = $this->db->query($sql);
		$cwtCount = $cwtCount->num_rows();
		
		$sql = "
			SELECT * FROM fulfillment
			WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month
			AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
			AND owning_team = $team;
		";
		$cwtTotal = $this->db->query($sql);
		$cwtTotal = $cwtTotal->num_rows();
		
		if($cwtTotal == 0)
			return 0;
		else
			return round(($cwtCount / $cwtTotal)*100, 2);
	}	
	
	function getSwtFulfillment($month, $day, $year){
		$team = $this->session->userdata('teamId');
		$sqlSwt = "
		SELECT * FROM fulfillment
		WHERE (MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month
		AND DAY(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $day
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year)
		AND STR_TO_DATE(CONCAT(swt_date,' ',swt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(sla, '%d-%b-%y %H:%i:%s')
		AND owning_team = $team;";
		
		$querySwt = $this->db->query($sqlSwt);
		return $querySwt->num_rows();
	}

	function getSwtFulfillmentMonth($month, $year){
		$team = $this->session->userdata('teamId');
		$sql = "
		SELECT * FROM fulfillment
		WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND STR_TO_DATE(CONCAT(swt_date,' ',swt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(sla, '%d-%b-%y %H:%i:%s')
		AND owning_team = $team;";
		
		$swtCount = $this->db->query($sql);
		$swtCount = $swtCount->num_rows();
		
		$sql = "
		SELECT * FROM fulfillment
		WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND owning_team = $team
		AND cwt_date IS NOT NULL;";
		
		$swtTotal = $this->db->query($sql);
		$swtTotal = $swtTotal->num_rows();
		
		if($swtTotal == 0)
			return 0;
		else
			return round(($swtCount / $swtTotal)*100, 2);
	}	
	
	function doesImExist($im){
		return $this->doesImExistAuto($im, $this->session->userdata('teamId'));
	}
	
	function doesImExistAuto($im, $team){
		
		$sql = "SELECT * FROM incidents WHERE incident_number ='$im' AND owning_team = $team ;";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function doesFrExist($fr){
		return $this->doesFrExistAuto($fr,$this->session->userdata('teamId') );
	}
	
	function doesFrExistAuto($fr, $team){
		
		$sql = "SELECT * FROM fulfillment WHERE fulfillment_number ='$fr' AND owning_team = $team;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function getDistinctQueueIm(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT distinct(queue) as queue 
		FROM incidents
		WHERE owning_team = $team
		AND current_status != 'Closed';";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getDistinctQueueFr(){
		
		$team = $this->session->userdata('teamId');
		$sql = "SELECT distinct(assignment_group) as queue 
		FROM fulfillment
		WHERE owning_team = $team
		AND status != 'Closed';";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getDistinctQueueUserIm(){
		
		$empNum = $this->session->userdata('empNum');
		$sql = "SELECT distinct(queue) as queue 
		FROM incidents
		WHERE owner = '$empNum'
		AND current_status != 'Closed';";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getDistinctQueueUserFr(){
		
		$empNum = $this->session->userdata('empNum');
		$sql = "SELECT distinct(assignment_group) as queue 
		FROM fulfillment
		WHERE owner = '$empNum'
		AND status != 'Closed';";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getImInQueue($queue){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM incidents WHERE queue ='$queue' 
		AND owning_team = $team
		AND current_status != 'Closed'
		AND prioritize = 0
		ORDER BY sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getFrInQueue($queue){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM fulfillment WHERE assignment_group ='$queue' 
		AND owning_team = $team
		AND status != 'Closed'
		AND prioritize = 0
		ORDER BY sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getImInQueueUser($queue){
		$empNum = $this->session->userdata('empNum');
		$sql = "SELECT * FROM incidents WHERE queue ='$queue' 
		AND owner = '$empNum'
		AND current_status != 'Closed';";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getFrInQueueUser($queue){
		$empNum = $this->session->userdata('empNum');
		$sql = "SELECT * FROM fulfillment WHERE assignment_group ='$queue' 
		AND owner = '$empNum'
		AND status != 'Closed';";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function insertIm($data){
		$this->insertImAuto($data, $this->session->userdata('teamId'), $this->session->userdata('empNum'));
	}

	function insertImAuto($data, $owningTeam, $owner){
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
			20 - SLA%
			21 - Description
			
			22 - Category
			23 - Area
			24 - Sub Area
			
		*/
		$incident_number = $data[0];
		$reported = $data[1];
		$impact = $data[2];
		$urgency = $data[3];
		$priority = $data[4];
		$current_status = $data[5];
		$title = $data[6];
		$target_date = $data[7];
		$affected_ci = $data[8];
		$service = $data[11];
		$queue = $data[13];
		$assignee = $data[14];
		$service_impact = $data[16];
		$closure_code = $data[18];
		$sla_percent = $data[20];
		$description = $data[21];
		$category = $data[22];
		$area = $data[23];
		$subArea = $data[24];
		$owning_team = $owningTeam;
		
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$date = date('Y-m-d');
		$time = date('H:i');
		
		
		//Fix special characters in the Title
		$title = str_replace('\\', '', $title);
		
		$sql = "
		INSERT INTO incidents(
			incident_number, reported, impact, urgency, priority, current_status, title, target_date,
			affected_ci, service, queue, assignee, service_impact, closure_code, owning_team, owner, sla_percent,
			added_date, added_time, description, category, area, sub_area
		)
		VALUES(
			'$incident_number', 
			'$reported', 
			'$impact', 
			'$urgency', 
			'$priority', 
			'$current_status', 
			'$title', 
			'$target_date',
			'$affected_ci',
			'$service', 
			'$queue', 
			'$assignee', 
			'$service_impact', 
			'$closure_code',
			$owning_team,
			'$owner',
			'$sla_percent',
			'$date',
			'$time',
			'$description',
			'$category',
			'$area',
			'$subArea'
		);
		
		";
		$this->db->query($sql);
		
		//TRACK TICKET QUEUE CHANGE////////////////////////////////////////////////////////
		$currTicketId = $this->getTicketIdByImOwner($incident_number, $owning_team);
		$sql = "
			INSERT INTO queue_change_im
				(ticket_id, owning_team, start_date, start_time)
			VALUES
				($currTicketId, '$queue', '$date', '$time');
		";
		$this->db->query($sql);
		
		//TRACK TICKET QUEUE CHANGE////////////////////////////////////////////////////////
	
	}
	
	
	function insertFr($data){
		$this->insertFrAuto($data, $this->session->userdata('teamId'), $this->session->userdata('empNum'));
	}
	
	
	function insertFrAuto($data, $owningTeam, $owner){
		
		$fulfillment_number = $data[0];
		$category = $data[1];
		$status = $data[2];
		$title = $data[3];
		$request_priority = $data[4];
		$request_type = $data[5];
		$service = $data[6];
		$service_type = $data[7];
		$ci = $data[8];
		$reported = $data[9];
		$sla = $data[10];
		$closed_date = $data[11];
		$assignment_group = $data[12];
		$assignee = $data[13];
		$closure_code = $data[14];
		$sla_perc = $data[15];
		$description = $data[16];
		$owning_team = $owningTeam;
		
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$date = date('Y-m-d');
		$time = date('H:i');
		
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
			16 - description
		*/
		
		
		
		$sql = "
		INSERT INTO fulfillment(
			fulfillment_number, category, status, title, request_priority, request_type, service, service_type, ci, reported, 
			sla, closed_date, assignment_group, assignee, closure_code, sla_percent, owning_team, owner, added_date, added_time, description
		)
		VALUES(
			'$fulfillment_number',
			'$category',
			'$status',
			'$title',
			'$request_priority',
			'$request_type',
			'$service',
			'$service_type',
			'$ci',
			'$reported',
			'$sla',
			'$closed_date',
			'$assignment_group',
			'$assignee',
			'$closure_code',
			'$sla_perc',
			$owning_team,
			'$owner',
			'$date',
			'$time',
			'$description'
		);
		
		";
		$this->db->query($sql);
		
		//TRACK TICKET QUEUE CHANGE////////////////////////////////////////////////////////
		$currTicketId = $this->getTicketIdByFrOwner($fulfillment_number, $owning_team);
		
		$sql = "
			INSERT INTO queue_change_fr
				(ticket_id, owning_team, start_date, start_time)
			VALUES
				($currTicketId, '$assignment_group', '$date', '$time');
		";
		$this->db->query($sql);
		
		//TRACK TICKET QUEUE CHANGE////////////////////////////////////////////////////////
	}
	
	function getQueueImId($imId){
		$sql = "
			SELECT * FROM incidents WHERE id = $imId;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->queue;
		}
		else{
			return null;
		}
	}
	
	function getQueueFrId($frId){
		$sql = "
			SELECT * FROM fulfillment WHERE id = $frId;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->assignment_group;
		}
		else{
			return null;
		}
	}
	
	function isImQueueLogged($ticketId){
		$sql = "
			SELECT * FROM queue_change_im WHERE ticket_id = $ticketId;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
	
	}
	
	function isFrQueueLogged($ticketId){
		$sql = "
			SELECT * FROM queue_change_fr WHERE ticket_id = $ticketId;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
	
	}
	
	function updateIm($im, $data){
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
			20 - SLA %
			21 - Description
			
			22 - Category
			23 - Area
			24 - Sub Area
		*/
		
		$incident_number = $data[0];
		$reported = $data[1];
		$impact = $data[2];
		$urgency = $data[3];
		$priority = $data[4];
		$current_status = $data[5];
		$title = $data[6];
		$target_date = $data[7];
		$affected_ci = $data[8];
		$service = $data[11];
		$queue = $data[13];
		$assignee = $data[14];
		$service_impact = $data[16];
		$closure_code = $data[18];
		$sla_percent = $data[20];
		$description = $data[21];
		$category = $data[22];
		$area = $data[23];
		$subArea = $data[24];
		$owning_team = $this->session->userdata('teamId');
		$owner = $this->session->userdata('empNum');
		
		
		//Fix special characters in the Title
		$title = str_replace('\\', '', $title);
		
		
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$date = date('Y-m-d');
		$time = date('H:i');
		
		//TRACK TICKET QUEUE CHANGE -  ALGORITHM////////////////////////////////////////////////////////
		$currTicketId = $this->getTicketIdByImOwner($incident_number, $owning_team);
		$currTicketQueue = $this->getQueueImId($currTicketId);
			//IF DELTA QUEUE
		if($currTicketQueue !== $queue){
			$sql = "
				INSERT INTO queue_change_im
					(ticket_id, owning_team, start_date, start_time)
				VALUES
					($currTicketId, '$queue', '$date', '$time');
			";
			$this->db->query($sql);
		}
		
		//Do INSERT also if the ticket is existing in the Master List but isn't logged yet.
		//Should be a rare case, but this is to fix those tickets not logged
		//which is caused when this functionality was deployed and the ticket is already in the master list.
		
		if($this->isImQueueLogged($currTicketId) == false){
			$sql = "
				INSERT INTO queue_change_im
					(ticket_id, owning_team, start_date, start_time)
				VALUES
					($currTicketId, '$queue', '$date', '$time');
			";
			$this->db->query($sql);
		}
		
		//TRACK TICKET QUEUE CHANGE -  ALGORITHM////////////////////////////////////////////////////////
		
		$sql = "
			UPDATE incidents
			SET incident_number = '$incident_number', 
			reported = '$reported', 
			impact = '$impact',
			urgency = '$urgency',
			priority = '$priority',
			current_status = '$current_status',
			title = '$title',
			target_date = '$target_date',
			affected_ci = '$affected_ci',
			service = '$service', 
			queue = '$queue',
			assignee = '$assignee',
			service_impact = '$service_impact', 
			closure_code = '$closure_code',
			sla_percent = '$sla_percent',
			sync_date = '$date',
			sync_time = '$time',
			description = '$description',
			category = '$category',
			area = '$area',
			sub_area = '$subArea'
			WHERE incident_number = '$im';
		";
		$this->db->query($sql);
		
		if($current_status == 'Resolved'){
			//If upon updating, the status turned to resolved, get the current sysdate and it will be used for SWT
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('d-M-y');
			$time = date('H:i:s');
			$sql="
				UPDATE incidents
				SET swt_date = '$date',
				swt_time = '$time'
				WHERE incident_number = '$im';
			";
			$this->db->query($sql);
		}
		
		if($current_status == 'Closed'){
			//If upon updating, the status turned to resolved, get the current sysdate and it will be used for SWT
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('d-M-y');
			$time = date('H:i:s');
			$sql="
				UPDATE incidents
				SET cwt_date = '$date',
				cwt_time = '$time'
				WHERE incident_number = '$im';
			";
			$this->db->query($sql);
			
			//Check also if ticket is Closed but SWT is still null. SWT should take CWT in this case
			$sql = "SELECT * FROM incidents WHERE incident_number = '$im';";
			$query = $this->db->query($sql);
			$row = $query->first_row();
			if(($row->swt_date == '' || $row->swt_date == null) && ($row->swt_time == '' || $row->swt_time == null)){
				$date = $row->cwt_date;
				$time = $row->cwt_time;
				$sql="
				UPDATE incidents
				SET swt_date = '$date',
				swt_time = '$time'
				WHERE incident_number = '$im';
				";
				
				$this->db->query($sql);
			}
			
		}
		
	}
	
	function getOwningTeamOfIm($im){
		$sql = "
			SELECT owning_team FROM incidents WHERE incident_number = '$im';
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->owning_team;
		}
		else{
			return null;
		}
	}
	
	function updateImNew($im, $data){
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
			20 - SLA %
			21 - Description
			
			22 - Category
			23 - Area
			24 - Sub Area
		*/
		
		$incident_number = $data[0];
		$reported = $data[1];
		$impact = $data[2];
		$urgency = $data[3];
		$priority = $data[4];
		$current_status = $data[5];
		$title = $data[6];
		$target_date = $data[7];
		$affected_ci = $data[8];
		$service = $data[11];
		$queue = $data[13];
		$assignee = $data[14];
		$service_impact = $data[16];
		$closure_code = $data[18];
		$sla_percent = $data[20];
		$description = $data[21];
		$category = $data[22];
		$area = $data[23];
		$subArea = $data[24];
		//WARNING HERE.
		$owning_team = $this->getOwningTeamOfIm($incident_number);
		//$owner = $this->session->userdata('empNum');
		
		
		//Fix special characters in the Title
		$title = str_replace('\\', '', $title);
		
		
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$date = date('Y-m-d');
		$time = date('H:i');
		
		//TRACK TICKET QUEUE CHANGE -  ALGORITHM////////////////////////////////////////////////////////
		$currTicketId = $this->getTicketIdByImOwner($incident_number, $owning_team);
		$currTicketQueue = $this->getQueueImId($currTicketId);
			//IF DELTA QUEUE
		if($currTicketQueue !== $queue){
			$sql = "
				INSERT INTO queue_change_im
					(ticket_id, owning_team, start_date, start_time)
				VALUES
					($currTicketId, '$queue', '$date', '$time');
			";
			$this->db->query($sql);
		}
		
		//Do INSERT also if the ticket is existing in the Master List but isn't logged yet.
		//Should be a rare case, but this is to fix those tickets not logged
		//which is caused when this functionality was deployed and the ticket is already in the master list.
		
		if($this->isImQueueLogged($currTicketId) == false){
			$sql = "
				INSERT INTO queue_change_im
					(ticket_id, owning_team, start_date, start_time)
				VALUES
					($currTicketId, '$queue', '$date', '$time');
			";
			$this->db->query($sql);
		}
		
		//TRACK TICKET QUEUE CHANGE -  ALGORITHM////////////////////////////////////////////////////////
		
		$sql = "
			UPDATE incidents
			SET incident_number = '$incident_number', 
			reported = '$reported', 
			impact = '$impact',
			urgency = '$urgency',
			priority = '$priority',
			current_status = '$current_status',
			title = '$title',
			target_date = '$target_date',
			affected_ci = '$affected_ci',
			service = '$service', 
			queue = '$queue',
			assignee = '$assignee',
			service_impact = '$service_impact', 
			closure_code = '$closure_code',
			sla_percent = '$sla_percent',
			sync_date = '$date',
			sync_time = '$time',
			description = '$description',
			category = '$category',
			area = '$area',
			sub_area = '$subArea'
			WHERE incident_number = '$im';
		";
		$this->db->query($sql);
		
		if($current_status == 'Resolved'){
			//If upon updating, the status turned to resolved, get the current sysdate and it will be used for SWT
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('d-M-y');
			$time = date('H:i:s');
			$sql="
				UPDATE incidents
				SET swt_date = '$date',
				swt_time = '$time'
				WHERE incident_number = '$im';
			";
			$this->db->query($sql);
		}
		
		if($current_status == 'Closed'){
			//If upon updating, the status turned to resolved, get the current sysdate and it will be used for SWT
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('d-M-y');
			$time = date('H:i:s');
			$sql="
				UPDATE incidents
				SET cwt_date = '$date',
				cwt_time = '$time'
				WHERE incident_number = '$im';
			";
			$this->db->query($sql);
			
			//Check also if ticket is Closed but SWT is still null. SWT should take CWT in this case
			$sql = "SELECT * FROM incidents WHERE incident_number = '$im';";
			$query = $this->db->query($sql);
			$row = $query->first_row();
			if(($row->swt_date == '' || $row->swt_date == null) && ($row->swt_time == '' || $row->swt_time == null)){
				$date = $row->cwt_date;
				$time = $row->cwt_time;
				$sql="
				UPDATE incidents
				SET swt_date = '$date',
				swt_time = '$time'
				WHERE incident_number = '$im';
				";
				
				$this->db->query($sql);
			}
			
		}
		
	}
	
	function updateImFromJob($im, $data, $owningTeam){
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
			20 - SLA %
			21 - Description
			
			22 - Category
			23 - Area
			24 - Sub Area
			
		*/
		
		$incident_number = $data[0];
		$reported = $data[1];
		$impact = $data[2];
		$urgency = $data[3];
		$priority = $data[4];
		$current_status = $data[5];
		$title = $data[6];
		$target_date = $data[7];
		$affected_ci = $data[8];
		$service = $data[11];
		$queue = $data[13];
		$assignee = $data[14];
		$service_impact = $data[16];
		$closure_code = $data[18];
		$sla_percent = $data[20];
		$description = $data[21];
		$category = $data[22];
		$area = $data[23];
		$subArea = $data[24];
		$owning_team = $owningTeam;
		$owner = $this->session->userdata('empNum');
		
		
		//Fix special characters in the Title
		$title = str_replace('\\', '', $title);
		
		
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$date = date('Y-m-d');
		$time = date('H:i');
		
		//TRACK TICKET QUEUE CHANGE -  ALGORITHM////////////////////////////////////////////////////////
		$currTicketId = $this->getTicketIdByImOwner($incident_number, $owning_team);
		$currTicketQueue = $this->getQueueImId($currTicketId);
			//IF DELTA QUEUE
		if($currTicketQueue !== $queue){
			$sql = "
				INSERT INTO queue_change_im
					(ticket_id, owning_team, start_date, start_time)
				VALUES
					($currTicketId, '$queue', '$date', '$time');
			";
			$this->db->query($sql);
		}
		
		//Do INSERT also if the ticket is existing in the Master List but isn't logged yet.
		//Should be a rare case, but this is to fix those tickets not logged
		//which is caused when this functionality was deployed and the ticket is already in the master list.
		
		if($this->isImQueueLogged($currTicketId) == false){
			$sql = "
				INSERT INTO queue_change_im
					(ticket_id, owning_team, start_date, start_time)
				VALUES
					($currTicketId, '$queue', '$date', '$time');
			";
			$this->db->query($sql);
		}
		
		//TRACK TICKET QUEUE CHANGE -  ALGORITHM////////////////////////////////////////////////////////
		
		$sql = "
			UPDATE incidents
			SET incident_number = '$incident_number', 
			reported = '$reported', 
			impact = '$impact',
			urgency = '$urgency',
			priority = '$priority',
			current_status = '$current_status',
			title = '$title',
			target_date = '$target_date',
			affected_ci = '$affected_ci',
			service = '$service', 
			queue = '$queue',
			assignee = '$assignee',
			service_impact = '$service_impact', 
			closure_code = '$closure_code',
			sla_percent = '$sla_percent',
			sync_date = '$date',
			sync_time = '$time',
			description  = '$description',
			category = '$category',
			area = '$area',
			sub_area = '$subArea'
			WHERE incident_number = '$im';
		";
		$this->db->query($sql);
		
		if($current_status == 'Resolved'){
			//If upon updating, the status turned to resolved, get the current sysdate and it will be used for SWT
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('d-M-y');
			$time = date('H:i:s');
			$sql="
				UPDATE incidents
				SET swt_date = '$date',
				swt_time = '$time'
				WHERE incident_number = '$im';
			";
			$this->db->query($sql);
		}
		
		if($current_status == 'Closed'){
			//If upon updating, the status turned to resolved, get the current sysdate and it will be used for SWT
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('d-M-y');
			$time = date('H:i:s');
			$sql="
				UPDATE incidents
				SET cwt_date = '$date',
				cwt_time = '$time'
				WHERE incident_number = '$im';
			";
			$this->db->query($sql);
			
			//Check also if ticket is Closed but SWT is still null. SWT should take CWT in this case
			$sql = "SELECT * FROM incidents WHERE incident_number = '$im';";
			$query = $this->db->query($sql);
			$row = $query->first_row();
			if(($row->swt_date == '' || $row->swt_date == null) && ($row->swt_time == '' || $row->swt_time == null)){
				$date = $row->cwt_date;
				$time = $row->cwt_time;
				$sql="
				UPDATE incidents
				SET swt_date = '$date',
				swt_time = '$time'
				WHERE incident_number = '$im';
				";
				
				$this->db->query($sql);
			}
			
		}
		
	}
	
	
	
	function updateFr($fr, $data){
		
		$category = $data[1];
		$status = $data[2];
		$title = $data[3];
		$request_priority = $data[4];
		$request_type = $data[5];
		$service = $data[6];
		$service_type = $data[7];
		$ci = $data[8];
		$reported = $data[9];
		$sla = $data[10];
		$closed_date = $data[11];
		$assignment_group = $data[12];
		$assignee = $data[13];
		$closure_code = $data[14];
		$sla_perc = $data[15];
		$description = $data[16];
		$owning_team = $this->session->userdata('teamId');
		$owner = $this->session->userdata('empNum');
		
		//Fix special characters in the Title
		$title = str_replace('\\', '', $title);
		
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$date = date('Y-m-d');
		$time = date('H:i');
		
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
		
		
		//TRACK TICKET QUEUE CHANGE////////////////////////////////////////////////////////
		$currTicketId = $this->getTicketIdByFrOwner($fr, $owning_team);
		$currTicketQueue = $this->getQueueFrId($currTicketId);
			//IF DELTA QUEUE
		if($currTicketQueue !== $assignment_group){
			$sql = "
				INSERT INTO queue_change_fr
					(ticket_id, owning_team, start_date, start_time)
				VALUES
					($currTicketId, '$assignment_group', '$date', '$time');
			";
			$this->db->query($sql);
		}
		//TRACK TICKET QUEUE CHANGE////////////////////////////////////////////////////////
		
		//Do INSERT also if the ticket is existing in the Master List but isn't logged yet.
		//Should be a rare case, but this is to fix those tickets not logged
		//which is caused when this functionality was deployed and the ticket is already in the master list.
		
		if($this->isFrQueueLogged($currTicketId) == false){
			$sql = "
				INSERT INTO queue_change_fr
					(ticket_id, owning_team, start_date, start_time)
				VALUES
					($currTicketId, '$queue', '$date', '$time');
			";
			$this->db->query($sql);
		}
		
		$sql = "
		UPDATE fulfillment 
			SET
				category = '$category', 
				status = '$status', 
				title = '$title', 
				request_priority = '$request_priority', 
				request_type = '$request_type', 
				service = '$service', 
				service_type = '$service_type', 
				ci = '$ci', 
				reported = '$reported', 
				sla = '$sla', 
				closed_date = '$closed_date', 
				assignment_group = '$assignment_group', 
				assignee = '$assignee', 
				closure_code = '$closure_code', 
				sla_percent = '$sla_perc',
				sync_date = '$date',
				sync_time = '$time',
				description = '$description'
			WHERE 
				fulfillment_number = '$fr';
		";	
		$this->db->query($sql);
		
		if($status == 'Fulfilled'){
			//If upon updating, the status turned to resolved, get the current sysdate and it will be used for SWT
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('d-M-y');
			$time = date('H:i:s');
			$sql="
				UPDATE fulfillment
				SET swt_date = '$date',
				swt_time = '$time'
				WHERE fulfillment_number = '$fr';
			";
			$this->db->query($sql);
		}
		
		if($status == 'Closed'){
			//If upon updating, the status turned to resolved, get the current sysdate and it will be used for SWT
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('d-M-y');
			$time = date('H:i:s');
			$sql="
				UPDATE fulfillment
				SET cwt_date = '$date',
				cwt_time = '$time'
				WHERE fulfillment_number = '$fr';
			";
			$this->db->query($sql);
			
			//Check also if ticket is Closed but SWT is still null. SWT should take CWT in this case
			$sql = "SELECT * FROM fulfillment WHERE fulfillment_number = '$fr';";
			$query = $this->db->query($sql);
			$row = $query->first_row();
			if(($row->swt_date == '' || $row->swt_date == null) && ($row->swt_time == '' || $row->swt_time == null)){
				$date = $row->cwt_date;
				$time = $row->cwt_time;
				$sql="
				UPDATE fulfillment
				SET swt_date = '$date',
				swt_time = '$time'
				WHERE fulfillment_number = '$fr';
				";
				//echo $sql.'<br/>';
				$this->db->query($sql);
			}
		}
		
	}
	
	function getOwningTeamOfFr($fr){
		$sql = "
			SELECT owning_team FROM fulfillment WHERE fulfillment_number = '$fr';
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->owning_team;
		}
		else{
			return null;
		}
	}
	
	function updateFrNew($fr, $data){
		
		$category = $data[1];
		$status = $data[2];
		$title = $data[3];
		$request_priority = $data[4];
		$request_type = $data[5];
		$service = $data[6];
		$service_type = $data[7];
		$ci = $data[8];
		$reported = $data[9];
		$sla = $data[10];
		$closed_date = $data[11];
		$assignment_group = $data[12];
		$assignee = $data[13];
		$closure_code = $data[14];
		$sla_perc = $data[15];
		$description = $data[16];
		$owning_team = $this->getOwningTeamOfFr($fr);
		//$owner = $this->session->userdata('empNum');
		
		//Fix special characters in the Title
		$title = str_replace('\\', '', $title);
		
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$date = date('Y-m-d');
		$time = date('H:i');
		
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
		
		
		//TRACK TICKET QUEUE CHANGE////////////////////////////////////////////////////////
		$currTicketId = $this->getTicketIdByFrOwner($fr, $owning_team);
		$currTicketQueue = $this->getQueueFrId($currTicketId);
			//IF DELTA QUEUE
		if($currTicketQueue !== $assignment_group){
			$sql = "
				INSERT INTO queue_change_fr
					(ticket_id, owning_team, start_date, start_time)
				VALUES
					($currTicketId, '$assignment_group', '$date', '$time');
			";
			$this->db->query($sql);
		}
		//TRACK TICKET QUEUE CHANGE////////////////////////////////////////////////////////
		
		//Do INSERT also if the ticket is existing in the Master List but isn't logged yet.
		//Should be a rare case, but this is to fix those tickets not logged
		//which is caused when this functionality was deployed and the ticket is already in the master list.
		
		if($this->isFrQueueLogged($currTicketId) == false){
			$sql = "
				INSERT INTO queue_change_fr
					(ticket_id, owning_team, start_date, start_time)
				VALUES
					($currTicketId, '$queue', '$date', '$time');
			";
			$this->db->query($sql);
		}
		
		$sql = "
		UPDATE fulfillment 
			SET
				category = '$category', 
				status = '$status', 
				title = '$title', 
				request_priority = '$request_priority', 
				request_type = '$request_type', 
				service = '$service', 
				service_type = '$service_type', 
				ci = '$ci', 
				reported = '$reported', 
				sla = '$sla', 
				closed_date = '$closed_date', 
				assignment_group = '$assignment_group', 
				assignee = '$assignee', 
				closure_code = '$closure_code', 
				sla_percent = '$sla_perc',
				sync_date = '$date',
				sync_time = '$time',
				description = '$description'
			WHERE 
				fulfillment_number = '$fr';
		";	
		$this->db->query($sql);
		
		if($status == 'Fulfilled'){
			//If upon updating, the status turned to resolved, get the current sysdate and it will be used for SWT
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('d-M-y');
			$time = date('H:i:s');
			$sql="
				UPDATE fulfillment
				SET swt_date = '$date',
				swt_time = '$time'
				WHERE fulfillment_number = '$fr';
			";
			$this->db->query($sql);
		}
		
		if($status == 'Closed'){
			//If upon updating, the status turned to resolved, get the current sysdate and it will be used for SWT
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('d-M-y');
			$time = date('H:i:s');
			$sql="
				UPDATE fulfillment
				SET cwt_date = '$date',
				cwt_time = '$time'
				WHERE fulfillment_number = '$fr';
			";
			$this->db->query($sql);
			
			//Check also if ticket is Closed but SWT is still null. SWT should take CWT in this case
			$sql = "SELECT * FROM fulfillment WHERE fulfillment_number = '$fr';";
			$query = $this->db->query($sql);
			$row = $query->first_row();
			if(($row->swt_date == '' || $row->swt_date == null) && ($row->swt_time == '' || $row->swt_time == null)){
				$date = $row->cwt_date;
				$time = $row->cwt_time;
				$sql="
				UPDATE fulfillment
				SET swt_date = '$date',
				swt_time = '$time'
				WHERE fulfillment_number = '$fr';
				";
				//echo $sql.'<br/>';
				$this->db->query($sql);
			}
		}
		
	}
	
	
	function updateFrFromJob($fr, $data, $owningTeam){
		
		$category = $data[1];
		$status = $data[2];
		$title = $data[3];
		$request_priority = $data[4];
		$request_type = $data[5];
		$service = $data[6];
		$service_type = $data[7];
		$ci = $data[8];
		$reported = $data[9];
		$sla = $data[10];
		$closed_date = $data[11];
		$assignment_group = $data[12];
		$assignee = $data[13];
		$closure_code = $data[14];
		$sla_perc = $data[15];
		$description = $data[16];
		$owning_team = $owningTeam;
		$owner = $this->session->userdata('empNum');
		
		//Fix special characters in the Title
		$title = str_replace('\\', '', $title);
		
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$date = date('Y-m-d');
		$time = date('H:i');
		
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
		
		
		//TRACK TICKET QUEUE CHANGE////////////////////////////////////////////////////////
		$currTicketId = $this->getTicketIdByFrOwner($fr, $owning_team);
		$currTicketQueue = $this->getQueueFrId($currTicketId);
			//IF DELTA QUEUE
		if($currTicketQueue !== $assignment_group){
			$sql = "
				INSERT INTO queue_change_fr
					(ticket_id, owning_team, start_date, start_time)
				VALUES
					($currTicketId, '$assignment_group', '$date', '$time');
			";
			$this->db->query($sql);
		}
		//TRACK TICKET QUEUE CHANGE////////////////////////////////////////////////////////
		
		//Do INSERT also if the ticket is existing in the Master List but isn't logged yet.
		//Should be a rare case, but this is to fix those tickets not logged
		//which is caused when this functionality was deployed and the ticket is already in the master list.
		
		if($this->isFrQueueLogged($currTicketId) == false){
			$sql = "
				INSERT INTO queue_change_fr
					(ticket_id, owning_team, start_date, start_time)
				VALUES
					($currTicketId, '$queue', '$date', '$time');
			";
			$this->db->query($sql);
		}
		
		$sql = "
		UPDATE fulfillment 
			SET
				category = '$category', 
				status = '$status', 
				title = '$title', 
				request_priority = '$request_priority', 
				request_type = '$request_type', 
				service = '$service', 
				service_type = '$service_type', 
				ci = '$ci', 
				reported = '$reported', 
				sla = '$sla', 
				closed_date = '$closed_date', 
				assignment_group = '$assignment_group', 
				assignee = '$assignee', 
				closure_code = '$closure_code', 
				sla_percent = '$sla_perc',
				sync_date = '$date',
				sync_time = '$time',
				description =  '$description'
				
			WHERE 
				fulfillment_number = '$fr';
		";	
		$this->db->query($sql);
		
		if($status == 'Fulfilled'){
			//If upon updating, the status turned to resolved, get the current sysdate and it will be used for SWT
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('d-M-y');
			$time = date('H:i:s');
			$sql="
				UPDATE fulfillment
				SET swt_date = '$date',
				swt_time = '$time'
				WHERE fulfillment_number = '$fr';
			";
			$this->db->query($sql);
		}
		
		if($status == 'Closed'){
			//If upon updating, the status turned to resolved, get the current sysdate and it will be used for SWT
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('d-M-y');
			$time = date('H:i:s');
			$sql="
				UPDATE fulfillment
				SET cwt_date = '$date',
				cwt_time = '$time'
				WHERE fulfillment_number = '$fr';
			";
			$this->db->query($sql);
			
			//Check also if ticket is Closed but SWT is still null. SWT should take CWT in this case
			$sql = "SELECT * FROM fulfillment WHERE fulfillment_number = '$fr';";
			$query = $this->db->query($sql);
			$row = $query->first_row();
			if(($row->swt_date == '' || $row->swt_date == null) && ($row->swt_time == '' || $row->swt_time == null)){
				$date = $row->cwt_date;
				$time = $row->cwt_time;
				$sql="
				UPDATE fulfillment
				SET swt_date = '$date',
				swt_time = '$time'
				WHERE fulfillment_number = '$fr';
				";
				//echo $sql.'<br/>';
				$this->db->query($sql);
			}
		}
		
	}
	
	function getTicketUpdate($ticketNumber){
		$team = $this->session->userdata('teamId');
		$ticketId = null;
		if($ticketNumber[0] == 'I'){
			$ticketId = $this->getTicketIdByImOwner($ticketNumber, $team);
		}
		else if($ticketNumber[0] == 'F'){
			$ticketId = $this->getTicketIdByFrOwner($ticketNumber, $team);
		}
		if($ticketId == null)
			return null;
		$sql = "
			SELECT *
			FROM handover_updates
			WHERE ticket_id = $ticketId
			AND ticket_number = '$ticketNumber'
			ORDER BY DATE DESC, TIME DESC;
		";
		
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			
			return $query->first_row();
		}
		else{
			return null;
		}
	
	}
	
	function getRecipient($teamId){
		$sql = "
			SELECT * FROM owning_team WHERE id = $teamId;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row();
		}
		else{
			return null;
		}
	}
	
	function getTicketIdByImOwner($im, $team){
		$sql = "
			SELECT id FROM incidents WHERE incident_number = '$im' and owning_team = $team;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->id;
		}
		else{
			return null;
		}
	}
	
	function getTicketIdByFrOwner($fr, $team){
		$sql = "
			SELECT id FROM fulfillment WHERE fulfillment_number = '$fr' and owning_team = $team;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->id;
		}
		else{
			return null;
		}
	}
	
	function getTicketUpdateList($ticketNumber){
		$team = $this->session->userdata('teamId');
		$ticketId = null; 
		$flag = 0;
		if($ticketNumber[0] == 'I'){
			$ticketId = $this->getTicketIdByImOwner($ticketNumber, $team);
		}
		else if($ticketNumber[0] == 'F'){
			$ticketId = $this->getTicketIdByFrOwner($ticketNumber, $team);
			$flag = 1;
		}
		if($ticketId == null)
			return null;
		
		//Make sure that we only get ticket_ids in particular to an IM or FR as there could be a tendency that
		//ticket_ids of IM and FR are the some thus resulting to misleading team updates.
		if($flag == 0)
			$sql = "
				SELECT *
				FROM handover_updates
				WHERE ticket_id = $ticketId
				AND ticket_number LIKE 'I%'
				ORDER BY DATE DESC, TIME DESC;
			";
		else
			$sql = "
				SELECT *
				FROM handover_updates
				WHERE ticket_id = $ticketId
				AND ticket_number LIKE 'F%'
				ORDER BY DATE DESC, TIME DESC;
			";
		
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function updateTicket($ticketNumber, $updateText){
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$date = date('Y-m-d');
		$time = date('H:i');
		
		/**Get Ticket ID but check if it is an FR or IM**/
		
		$owning_team = $this->session->userdata('teamId');
		if($ticketNumber[0] == 'I'){
			$sql = "
				SELECT * FROM incidents
				WHERE incident_number = '$ticketNumber'
				AND owning_team = $owning_team;
			";
		}
		else if($ticketNumber[0] == 'F'){
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
		}
		else{
			$row = null;
		}
		/**Get Ticket ID but check if it is an FR or IM**/
		
		if($row != null)
			$ticketId = $row->id;
		else
			$ticketId = null;
			
		$updated_by = $this->session->userdata('email');
		
		$sql = "
		INSERT INTO handover_updates(
			ticket_number, update_text, date, time, ticket_id, updated_by
		)
		VALUES(
			'$ticketNumber', '$updateText', '$date', '$time', $ticketId, '$updated_by'
		);
		
		";
		$this->db->query($sql);
	}
	
	function updateUserInfo($email, $firstName, $lastName, $empNumber, $domainName){
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$date = date('Y-m-d');
		$time = date('H:i');
		
		$sql = "
			UPDATE user
			SET email = '$email',
			first_name = '$firstName',
			last_name = '$lastName',
			domain_name = '$domainName',
			last_logged_date = '$date',
			last_logged_time = '$time'
			WHERE emp_id = '$empNumber';
		";
		$this->db->query($sql);
		
	}
	
	function getImDetailsById($id){
		$sql = "
			SELECT * FROM incidents
			WHERE id = $id;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row();
		}
		else{
			return null;
		}
	}
	
	function getImDetailsByNum($ticketNum){
		$team = $this->session->userdata('teamId');
		$sql = "
			SELECT * FROM incidents
			WHERE incident_number = '$ticketNum'
			AND owning_team=$team;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row();
		}
		else{
			return null;
		}
	}
	
	function getImDetailsByIdOutOfScope($id){
		$sql = "
			SELECT * FROM incidents_outofscope
			WHERE id = $id;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row();
		}
		else{
			return null;
		}
	}
	
	function getFrDetailsById($id){
		$sql = "
			SELECT * FROM fulfillment
			WHERE id = $id;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row();
		}
		else{
			return null;
		}
	}
	
	function getFrDetailsByNum($ticketNum){
		$team = $this->session->userdata('teamId');
		$sql = "
			SELECT * FROM fulfillment
			WHERE fulfillment_number = '$ticketNum'
			AND owning_team=$team;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row();
		}
		else{
			return null;
		}
	}
	
	function getFrDetailsByIdOutOfScope($id){
		$sql = "
			SELECT * FROM fulfillment_outofscope
			WHERE id = $id;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row();
		}
		else{
			return null;
		}
	}
	
	function getImTicketBounces($ticketId){
		$sql = "
			SELECT * FROM queue_change_im
			WHERE ticket_id = $ticketId;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getFrTicketBounces($ticketId){
		$sql = "
			SELECT * FROM queue_change_fr
			WHERE ticket_id = $ticketId;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getImTicketDistinctBounces($ticketId){
		$sql = "
			SELECT distinct(owning_team) FROM queue_change_im
			WHERE ticket_id = $ticketId;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getFrTicketDistinctBounces($ticketId){
		$sql = "
			SELECT distinct(owning_team) FROM queue_change_fr
			WHERE ticket_id = $ticketId;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function computeImQueueTime($ticketId, $queue){
		
		$sql = "
			SELECT * FROM queue_change_im
			WHERE ticket_id = $ticketId;
		";
		$query = $this->db->query($sql);
		$arrData = null;
		if($query->num_rows()>0){
			$arrData = $query->row_array();
		}
		else{
			return 0;
		}
		
		$currDate = '';
		$currTime = '';
		$nextDate = '';
		$nextTime = '';
		$totalTime = 0;
		$counter = 0;
		
		for($i = 0; $i < $query->num_rows(); $i++){
			$row = $query->row_array($i);
			if($row['owning_team'] == $queue){
				//Do Here
				$currDate = $row['start_date'];
				$currTime = $row['start_time'];
				
				$i++;
				$row = $query->row_array($i);
				$nextDate = $row['start_date'];
				$nextTime = $row['start_time'];
				
				//The Date/Time formate is 2014/12/02 23:23:00
				$temp1 = strtotime($currDate.' '.$currTime);
				$temp2 = strtotime($nextDate.' '.$nextTime);
				$totalTime += ($temp2 - $temp1) / 60;
				
				
				
			}
		}
		//Observation: You reach end if Curr == Next
		//If this happens, and ticket is still open, Next = Sysdate, then add the difference
		if($nextDate == $currDate && $nextTime == $currTime /*&& ticket is not yet closed*/){
			//Need to do this because for some reason, the web servers default timezone was set to Europe timezone
			$temp= new DateTime();
			$temp->setDate(date('Y'), date('m'), date('d'));
			$temp->setTime(date('H'), date('i'));
			$temp->setTimeZone(new DateTimeZone('Asia/Singapore'));
			$sysdate = strtotime($temp->format('Y/m/d H:i'));
			
			//echo 'SYS: '.'('.date('Y-m-d H:i',$sysdate).')'.'<br/>'.'Next: '.'('.date('Y/m/d H:i',$temp2).')'.'<br/>';
			
			$totalTime += (($sysdate - $temp2) / 60);
			return "$totalTime"." (on-going)";
		}
	
		
		
		return $totalTime;
	
	}
	
	
	function computeFrQueueTime($ticketId, $queue){
		
		$sql = "
			SELECT * FROM queue_change_fr
			WHERE ticket_id = $ticketId;
		";
		$query = $this->db->query($sql);
		$arrData = null;
		if($query->num_rows()>0){
			$arrData = $query->row_array();
		}
		else{
			return 0;
		}
		
		$currDate = '';
		$currTime = '';
		$nextDate = '';
		$nextTime = '';
		$totalTime = 0;
		$counter = 0;
		
		for($i = 0; $i < $query->num_rows(); $i++){
			$row = $query->row_array($i);
			if($row['owning_team'] == $queue){
				//Do Here
				$currDate = $row['start_date'];
				$currTime = $row['start_time'];
				
				$i++;
				$row = $query->row_array($i);
				$nextDate = $row['start_date'];
				$nextTime = $row['start_time'];
				
				//The Date/Time formate is 2014/12/02 23:23:00
				$temp1 = strtotime($currDate.' '.$currTime);
				$temp2 = strtotime($nextDate.' '.$nextTime);
				$totalTime += ($temp2 - $temp1) / 60;
				
				
				
			}
		}
		//Observation: You reach end if Curr == Next
		//If this happens, and ticket is still open, Next = Sysdate, then add the difference
		if($nextDate == $currDate && $nextTime == $currTime /*&& ticket is not yet closed*/){
			//Need to do this because for some reason, the web servers default timezone was set to Europe timezone
			$temp= new DateTime();
			$temp->setDate(date('Y'), date('m'), date('d'));
			$temp->setTime(date('H'), date('i'));
			$temp->setTimeZone(new DateTimeZone('Asia/Singapore'));
			$sysdate = strtotime($temp->format('Y/m/d H:i'));
			
			//echo 'SYS: '.'('.date('Y-m-d H:i',$sysdate).')'.'<br/>'.'Next: '.'('.date('Y/m/d H:i',$temp2).')'.'<br/>';
			
			$totalTime += (($sysdate - $temp2) / 60);
			return "$totalTime"." (on-going)";
		}
	
		
		
		return $totalTime;
	
	}
	
	function getOwningTeamName($id){
		$sql = "
			SELECT owning_team FROM owning_team
			WHERE id = $id;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->owning_team;
		}
		else{
			return null;
		}
	}
	
	function isImManager(){
		$empNum = $this->session->userdata('empNum');
		$sql = "
			SELECT is_im_manager 
			FROM user
			WHERE emp_id = '$empNum';
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->is_im_manager;
		}
		else{
			return 0;
		}
	}
	
	function isImInOutOfScope($ticketId){
		$team = $this->session->userdata('teamId');
		$sql ="
			SELECT * FROM incidents_outofscope
			WHERE id = $ticketId
			AND owning_team = $team;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function isFrInOutOfScope($ticketId){
		$team = $this->session->userdata('teamId');
		$sql ="
			SELECT * FROM fulfillment_outofscope
			WHERE id = $ticketId
			AND owning_team = $team;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
		
	}
	
	function insertOutOfScope($ticketId, $flag){
		//flag 0 == IM; flag 1 == FR
		if($flag == 0){
			$sql = "
				INSERT INTO incidents_outofscope
				SELECT * FROM incidents
				WHERE id = $ticketId;
			";
			$this->db->query($sql);
			$sql = "
				DELETE FROM incidents
				WHERE id = $ticketId;
			";
			$this->db->query($sql);
		}
		else{
			$sql = "
				INSERT INTO fulfillment_outofscope
				SELECT * FROM fulfillment
				WHERE id = $ticketId;
			";
			$this->db->query($sql);
			$sql = "
				DELETE FROM fulfillment
				WHERE id = $ticketId;
			";
			$this->db->query($sql);
		}
	}
	
	function insertToScope($ticketId, $flag){
		//flag 0 == IM; flag 1 == FR
		if($flag == 0){
			$sql = "
				INSERT INTO incidents
				SELECT * FROM incidents_outofscope
				WHERE id = $ticketId;
			";
			$this->db->query($sql);
			$sql = "
				DELETE FROM incidents_outofscope
				WHERE id = $ticketId;
			";
			$this->db->query($sql);
		}
		else{
			$sql = "
				INSERT INTO fulfillment
				SELECT * FROM fulfillment_outofscope
				WHERE id = $ticketId;
			";
			$this->db->query($sql);
			$sql = "
				DELETE FROM fulfillment_outofscope
				WHERE id = $ticketId;
			";
			$this->db->query($sql);
		}
	}
	
	function getIncidentsMapCi($ci){
		$sql = "
			SELECT * FROM incidents
			WHERE affected_ci = $ci
			AND current_status != 'Closed'
			GROUP BY incident_number;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->owning_team;
		}
		else{
			return null;
		}
	}
	
	function getActiveUserCount(){
		$sql = "
			SELECT * FROM user
			WHERE email IS NOT NULL;
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->num_rows;
		}
		else{
			return 0;
		}
	}
	
	function getTeamCount(){
		$sql = "
			SELECT * FROM owning_team;
			
		";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->num_rows;
		}
		else{
			return 0;
		}
	}
	
	function prioritizeIm($ticket){
		$teamId = $this->session->userdata('teamId');
		$sql = "
			UPDATE incidents
			SET prioritize = 1
			WHERE incident_number = '$ticket'
			AND owning_team = $teamId;
		";
		$this->db->query($sql);
	}
	function prioritizeFr($ticket){
		$teamId = $this->session->userdata('teamId');
		$sql = "
			UPDATE fulfillment
			SET prioritize = 1
			WHERE fulfillment_number = '$ticket'
			AND owning_team = $teamId;
		";
		$this->db->query($sql);
	}
	
	function unprioritizeIm($ticket){
		$teamId = $this->session->userdata('teamId');
		$sql = "
			UPDATE incidents
			SET prioritize = 0
			WHERE incident_number = '$ticket'
			AND owning_team = $teamId;
		";
		$this->db->query($sql);
	}
	function unprioritizeFr($ticket){
		$teamId = $this->session->userdata('teamId');
		$sql = "
			UPDATE fulfillment
			SET prioritize = 0
			WHERE fulfillment_number = '$ticket'
			AND owning_team = $teamId;
		";
		$this->db->query($sql);
	}
	
	
	
	function getPriorityIm(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM incidents 
		WHERE current_status != 'Closed'
		AND owning_team =  $team
		AND prioritize = 1
		ORDER BY priority_num asc, queue ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	
	}
	
	function getPriorityFr(){
		$team = $this->session->userdata('teamId');
		$sql = "SELECT * FROM fulfillment 
		WHERE status != 'Closed' 
		AND owning_team = $team
		AND prioritize = 1
		ORDER BY priority_num asc, assignment_group ASC, sla_percent+0.0 DESC;";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	
	}
	
	function getMyTeammates(){
		$team = $this->session->userdata('teamId');
		$sql = "
			SELECT * 
			FROM user
			WHERE team = $team;
			";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function updateImOwner($ticketNumber, $ownerEmpId, $scopeFlag){
		$team = $this->session->userdata('teamId');
		//0 = In Scope; 1 = Out Of Scope;
		if($scopeFlag == 0)
			$sql = "
				UPDATE incidents
				SET owner = '$ownerEmpId'
				WHERE incident_number = '$ticketNumber'
				AND owning_team = $team;
			";
		else
			$sql = "
				UPDATE incidents_outofscope
				SET owner = '$ownerEmpId'
				WHERE incident_number = '$ticketNumber'
				AND owning_team = $team;
			";
		$this->db->query($sql);
	}
	
	function updateFrOwner($ticketNumber, $ownerEmpId, $scopeFlag){
		$team = $this->session->userdata('teamId');
		//0 = In Scope; 1 = Out Of Scope;
		if($scopeFlag == 0)
			$sql = "
				UPDATE fulfillment
				SET owner = '$ownerEmpId'
				WHERE fulfillment_number = '$ticketNumber'
				AND owning_team = $team;
			";
		else
			$sql = "
				UPDATE fulfillment_outofscope
				SET owner = '$ownerEmpId'
				WHERE fulfillment_number = '$ticketNumber'
				AND owning_team = $team;
			";
		$this->db->query($sql);
	}
	
	function updateImPiorityNumber($ticketId, $priorityNumber){
		$team = $this->session->userdata('teamId');
		$sql = "
			UPDATE incidents
			SET priority_num = $priorityNumber
			WHERE id = $ticketId
			AND owning_team = $team;
		";
		$this->db->query($sql);
	}
	
	function updateFrPiorityNumber($ticketId, $priorityNumber){
		$team = $this->session->userdata('teamId');
		$sql = "
			UPDATE fulfillment
			SET priority_num = $priorityNumber
			WHERE id = $ticketId
			AND owning_team = $team;
		";
		$this->db->query($sql);
	}
	
	function getOwningTeamQueueList($owningTeam){
		$sql = "
			SELECT * 
			FROM owning_team_queue
			WHERE owning_team = $owningTeam;
			";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getCandidateOwner($owningTeam){
		//order by IM Manager to ensure we first try to get the candidate owner as the IM SPOC
		$sql = "
			SELECT * 
			FROM user
			WHERE team = $owningTeam
			ORDER BY is_im_manager DESC;
			";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->emp_id;
		}
		else{
			return null;
		}
	}
	
	function getDailyUsers(){
		$sql = "
			SELECT CONCAT(a.first_name, ' ', a.last_name) AS NAME,
			TIMEDIFF(TIME(SYSDATE()), a.last_logged_time) AS temp,
			b.owning_team
			FROM USER a, owning_team b
			WHERE DATE(a.last_logged_date)= DATE(SYSDATE())
			AND DAY(a.last_logged_date) = DAY(SYSDATE())
			AND YEAR(a.last_logged_date) = YEAR(SYSDATE())
			AND a.team = b.id
			ORDER BY temp ASC;
			";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}
	
	function getImSyncInterval(){
		$sql = "
			SELECT TIMEDIFF(TIME(SYSDATE()), sync_time) AS temp FROM incidents WHERE current_status !=  'Closed'
			ORDER BY temp DESC
			LIMIT 1;
			";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->temp;
		}
		else{
			return null;
		}
	}
	
	function getFrSyncInterval(){
		$sql = "
			SELECT TIMEDIFF(TIME(SYSDATE()), sync_time) AS temp FROM fulfillment WHERE status !=  'Closed'
			ORDER BY temp DESC
			LIMIT 1;
			";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->first_row()->temp;
		}
		else{
			return null;
		}
	}
	
	function searchTickets($searchString){
		$team = $this->session->userdata('teamId');
		
		//Perform Search in Incidents first
		$sql = "SELECT CONCAT(incident_number, ' - ', title) as result_string
					FROM incidents 
					WHERE (incident_number like '%$searchString%'
					OR title like '%$searchString%')
					AND current_status != 'Closed'
					AND owning_team = $team;";
		
		$query = $this->db->query($sql);
		$arr = array();
		if($query->num_rows()>0){
			$temp = $query->result();
			//Transform to simple PHP array for later json pass to JAVASCRIPT
			
			foreach($temp as $row){
				$arr[] = $row->result_string;
			}
			
		}
		else{
			//do none as of now;
		}
		
		//Perform search in FRs
		$sql = "SELECT CONCAT(fulfillment_number, ' - ', title) as result_string
					FROM fulfillment 
					WHERE (fulfillment_number like '%$searchString%'
					OR title like '%$searchString%')
					AND status != 'Closed'
					AND owning_team = $team;";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			$temp = $query->result();
			//Transform to simple PHP array for later json pass to JAVASCRIPT
			
			foreach($temp as $row){
				$arr[] = $row->result_string;
			}
			
		}
		else{
			//do none as of now;
		}
		return $arr;
	}
	
	function searchTicketsArchive($searchString){
		$team = $this->session->userdata('teamId');
		
		//Perform Search in Incidents first
		$sql = "SELECT CONCAT(incident_number, ' - ', title) as result_string
					FROM incidents 
					WHERE (incident_number like '%$searchString%'
					OR title like '%$searchString%')
					AND owning_team = $team;";
		
		$query = $this->db->query($sql);
		$arr = array();
		if($query->num_rows()>0){
			$temp = $query->result();
			//Transform to simple PHP array for later json pass to JAVASCRIPT
			
			foreach($temp as $row){
				$arr[] = $row->result_string;
			}
			
		}
		else{
			//do none as of now;
		}
		
		//Perform search in FRs
		$sql = "SELECT CONCAT(fulfillment_number, ' - ', title) as result_string
					FROM fulfillment 
					WHERE (fulfillment_number like '%$searchString%'
					OR title like '%$searchString%')
					AND owning_team = $team;";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			$temp = $query->result();
			//Transform to simple PHP array for later json pass to JAVASCRIPT
			
			foreach($temp as $row){
				$arr[] = $row->result_string;
			}
			
		}
		else{
			//do none as of now;
		}
		return $arr;
	}
	
	
}
?>