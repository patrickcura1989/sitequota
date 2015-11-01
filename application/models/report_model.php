<?php
class report_model extends CI_Model {
	

	function getImReportMonths(){
		$teamId = $this->session->userdata('teamId');
		$sql = "
			SELECT DISTINCT(MONTHNAME(STR_TO_DATE(cwt_date, '%d-%b-%y'))) AS 'monthname', 
			MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y')) AS 'month',
			YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) AS 'year'
			FROM incidents
			WHERE cwt_date IS NOT NULL
			AND owning_team = $teamId
			ORDER BY (STR_TO_DATE(cwt_date, '%d-%b-%y')) DESC;

		";
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
	/********Ticket Breakdown - Impact Counts *******************************************************************************/
	function getClosedImPerImpact($month, $year, $priority){
		$team = $this->session->userdata('teamId');
		$sqlTotal = "SELECT *  FROM incidents
		WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month 
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND priority LIKE '%$priority%'
		AND owning_team = $team;";
		
		$queryTotal = $this->db->query($sqlTotal);
		return $queryTotal->num_rows();
	}
	
	function getClosedFrPerRequestType($month, $year, $requestType){
		$team = $this->session->userdata('teamId');
		$sqlTotal = "SELECT *  FROM fulfillment
		WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month 
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND request_type LIKE '%$requestType%'
		AND owning_team = $team;";
		
		$queryTotal = $this->db->query($sqlTotal);
		return $queryTotal->num_rows();
	}
	
	/********Ticket Breakdown - Impact Counts *******************************************************/
	
	/********Ticket Breakdown - Impact SWT/CWT Counts *******************************************************/
	
	function getSwtCountPerImpactIm($month, $year, $priority){
		$team = $this->session->userdata('teamId');
		$sqlSwt = "
		SELECT * FROM incidents
		WHERE (MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))=  $month
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND priority LIKE '%$priority%')
		AND STR_TO_DATE(CONCAT(swt_date,' ',swt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(target_date, '%d-%b-%y %H:%i:%s')
		AND owning_team = $team;
		;";
		
		$querySwt = $this->db->query($sqlSwt);
		return $querySwt->num_rows();
	}
	
	function getSwtCountPerRequestTypeFr($month, $year, $requestType){
		$team = $this->session->userdata('teamId');
		$sqlSwt = "
		SELECT * FROM fulfillment
		WHERE (MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))=  $month
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND request_type LIKE '%$requestType%')
		AND STR_TO_DATE(CONCAT(swt_date,' ',swt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(sla, '%d-%b-%y %H:%i:%s')
		AND owning_team = $team;
		;";
		
		$querySwt = $this->db->query($sqlSwt);
		return $querySwt->num_rows();
	}
	
	
	function getCwtCountPerImpactIm($month, $year, $priority){
		$team = $this->session->userdata('teamId');
		$sqlCwt = "
		SELECT * FROM incidents
		WHERE (MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))=  $month
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND priority LIKE '%$priority%')
		AND STR_TO_DATE(CONCAT(cwt_date,' ',cwt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(target_date, '%d-%b-%y %H:%i:%s')
		AND owning_team = $team;
		;";
		
		$queryCwt = $this->db->query($sqlCwt);
		return $queryCwt->num_rows();
	}
	
	function getCwtCountPerRequestTypeFr($month, $year, $requestType){
		$team = $this->session->userdata('teamId');
		$sqlCwt = "
		SELECT * FROM fulfillment
		WHERE (MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))=  $month
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND request_type LIKE '%$requestType%')
		AND STR_TO_DATE(CONCAT(cwt_date,' ',cwt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(sla, '%d-%b-%y %H:%i:%s')
		AND owning_team = $team;
		;";
		
		$queryCwt = $this->db->query($sqlCwt);
		return $queryCwt->num_rows();
	}
	/********Ticket Breakdown - Impact SWT/CWT Counts *******************************************************/
	
	/********Ticket Breakdown - Impact SWT/CWT SCORE *******************************************************/
	function getSwtScorePerImpactIm($month, $year, $priority){
		$team = $this->session->userdata('teamId');
		$sql = "
		SELECT * FROM incidents
		WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND priority like '%$priority%'
		AND STR_TO_DATE(CONCAT(swt_date,' ',swt_time), '%d-%b-%y %H:%i:%s') < STR_TO_DATE(target_date, '%d-%b-%y %H:%i:%s')
		AND owning_team = $team;";
		
		$swtCount = $this->db->query($sql);
		$swtCount = $swtCount->num_rows();
		
		$sql = "
		SELECT * FROM incidents
		WHERE MONTH(STR_TO_DATE(cwt_date, '%d-%b-%y'))= $month
		AND YEAR(STR_TO_DATE(cwt_date, '%d-%b-%y')) = $year
		AND priority like '%$priority%'
		AND owning_team = $team
		AND cwt_date IS NOT null;";
		
		$swtTotal = $this->db->query($sql);
		$swtTotal = $swtTotal->num_rows();
		
		if($swtTotal == 0)
			return 0;
		else
			return round(($swtCount / $swtTotal)*100, 2);
	}
	/********Ticket Breakdown - Impact SWT/CWT SCORE *******************************************************/
	
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
}
?>