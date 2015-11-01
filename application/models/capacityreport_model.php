<?php
class capacityreport_model extends CI_Model {
	

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
	
	function getCockpitsThreshold(){
		$timezone = "Asia/Singapore";
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($timezone);
		}
		$month = date('m');
		$year = date('Y');
		$day = date('d');
		$sql ="
			SELECT id, cockpit, ((used/capacity)*100) AS percent, used, free, capacity, DATE, TIME
			FROM capacity_log
			WHERE MONTH(DATE)=  $month
			AND DAY(DATE)=  $day
			AND YEAR(DATE)=  $year
			GROUP BY id, cockpit, percent, used, free, capacity, DATE, TIME
			ORDER BY cockpit,TIME DESC;
		";
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return null;
		}
	}

}
?>