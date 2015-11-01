<html>
<head>
<style>
.myH3{
   font: 19px/20px 'RobotoLight', Arial, sans-serif;
}

.myFont{
	font: 18px/27px 'RobotoLight', Arial, sans-serif;
}


.emailTable{
	width:100%;
	border               : 1px solid #CCC;
	border-collapse      : collapse;
	background            : #EFECE5;
    color                 : #666;
	font				: 15px 'RobotoLight';
	border-right		:1px solid #CCC; 
	border-bottom		:1px solid #CCC;
	border-left			:1px solid #CCC; 
	border-top			:1px solid #CCC;
	
	
}

.emailTable th{
	border-right		:1px solid #CCC; 
	border-bottom		:1px solid #CCC;
	border-left			:1px solid #CCC; 
	border-top			:1px solid #CCC;
}

.emailTable td{
	padding-top			:5px;
	padding-bottom		:5px;
	padding-right		:3px;
	padding-left		:3px;
}

.ticketLegend{
	border               : 1px solid #CCC;
	border-collapse      : collapse;
	
	background            : #EFECE5;
    
	
	color                 : #666;
	
}
.ticketLegend td{
	padding             :10px 10px 10px 10px;
	font				: 15px 'RobotoLight';
	border-right		:1px solid #CCC; 
	border-bottom		:1px solid #CCC;
	border-left		:1px solid #CCC; 
	border-top		:1px solid #CCC;
	
}

.emailTableMainBody{
	border               : 1px solid #CCC;
	border-collapse      : collapse;
	
	/*background            : #EFECE5;*/
    color                 : #666;
	
	
}
.emailTableMainBody td{
	
	font				: 15px 'RobotoLight';
	border-right		:1px solid #CCC; 
	border-bottom		:1px solid #CCC;
	border-left		:1px solid #CCC; 
	border-top		:1px solid #CCC;
	
}
</style>
<style>
.myH3{
   font: 18px/27px 'RobotoLight-Bold', Arial, sans-serif;
}
.myH3Bigger{
   font: 25px 'RobotoLight-Bold', Arial, sans-serif;
}

.myFont{
	font: 18px/27px 'RobotoLight', Arial, sans-serif;
}

font{
	font-size:12px;
}
</style>

<style>
#panelSmallFont{
	font: 13px/15px 'RobotoLight', Arial, sans-serif;
}
</style>

</head>

<body>
<div align=center>
<img src="/sitequota/styles/img/handover_icon.png" width="100" height="100"/>
<h3 class="myH3Bigger">Handover</h3>
</div>
<hr class="carved"/>
<div align=center>
<table cellpadding="15px">
<tr>
	<td align=center>
		<?php
		echo anchor('nagger/showHandover/Array',
			'<img src="/sitequota/styles/img/update_icon.png" width="50" height="50"/>');
		?>
		<br/><br/>
		<font class="myFont">1. Update Tickets</font>
		
	</td>
	<td align=center>
		<img src="/sitequota/styles/img/forward_icon.png" width="50" height="30"/>
	</td>
	<td align=center>
		<?php
		echo anchor('/nagger/generateEmail',
			'<img src="/sitequota/styles/img/generateemail_icon.png" width="60" height="50"/>');
		?>
		<br/><br/>
		<font  class="myH3">2. Generate Email</font>
	</td>
	<td>
		<img src="/sitequota/styles/img/forward_icon.png" width="50" height="30"/>
	</td>
	<form method="post" action="<?php echo $form;?>">
	<td align=center>
		<img src="/sitequota/styles/img/email_icon.png" width="50" height="50"/><br/><br/>
		<font class="myFont">3. <input type=submit value="Send Email" class="myButton"/></font>
	</td>
</tr>
</table>
</div>
<hr class="carved"/>




<div align=center>

</div><br/><br/>
<table class="emailTableMainBody" cellpadding=10 width="100%">
<tr>
	<td>
		<b/>Recipient:
		
	</td>
	<td>
		<?php echo $recipient;?>
		<input type=hidden value="<?php echo $recipient;?>" name="recipient"/>
	</td>
</tr>
<tr>
	<td>
		<b/>Subject:
		
	</td>
	<td>
		<?php
			$timezone = "Asia/Singapore";
			if(function_exists('date_default_timezone_set')) {
				date_default_timezone_set($timezone);
			}
			$date = date('m-d-Y');
		?>
		<?php echo $teamName;?> Handover Report - <?php echo $date;?>
		<input type=hidden value="<?php echo $teamName;?> Handover Report <?php echo $date;?>" name="subject"/>
	</td>
</tr>
<tr>
	<td>
		<b/>Shift:
		
	</td>
	<td>
		<select name="shift" style="font: 15px Arial;">
			<option>ASIA</option>
			<option>EMEA</option>
			<option>NALA</option>
		</select>
		
	</td>
</tr>
<tr>
	<td valign=top>
		<b/>Body:
	</td>
	<td><br/>
	<h3 class="myH3"/><b/>IM Master List<br/><br/>
		
<?php 

	if(count($imArr) > 0){
		
		$dangerCount = $this->sitequota_model->getImDanger();
		$missedCount = $this->sitequota_model->getImMissed();
		$greenCount = count($imArr) - ($dangerCount + $missedCount);
		
		echo '<table class="ticketLegend">';
		echo '<tr><td>Within SLA</td><td>'.$greenCount.'</td></tr>';
		echo '<tr><td>Danger (SLA >= 80%):</td><td>'.$dangerCount.'</td></tr>';
		echo '<tr><td>Missed (SLA >= 100%):</td><td>'.$missedCount.'</td></tr>';
		echo '<tr><td>Total:</td><td>'.count($imArr).'</td></tr>';
		echo '</table><br/><br/>';
		echo '<table class="emailTable">';
		echo '<tr>';
		echo '<th><b/>IM#</th>';
		echo '<th width=10%><b/>Title</th>';
		echo '<th><b/>Last Update</th>';
		echo '<th><b/>Status</th>';
		echo '<th><b/>Assignee</th>';
		echo '<th><b/>Assignment Group</th>';
		echo '<th><b/>SLA%</th>';
		echo '<th><b/>SLA</th>';
		echo '<th><b/>Impact</th>';
		echo '<th><b/>Urgency</th>';
		echo '<th><b/>Priority</th>';
		
		echo  '</tr>';
		foreach($imArr as $row){
			echo '<tr>';
			echo '<td>'.$row->incident_number.'</td>';
			echo '<td width="100px">'.$row->title.'</td>';
			$update = $this->sitequota_model->getTicketUpdate($row->incident_number);
			if($update != null)
				echo '<td>'.$update->update_text.'</td>';
			else
				echo '<td>No updates.</td>';
			echo '<td>'.$row->current_status.'</td>';
			echo '<td>'.$row->assignee.'</td>';
			echo '<td>'.$row->queue.'</td>';
			if($row->sla_percent >= 60){ 
				echo '<td style="white-space: nowrap;">';
				echo '<font>'.$row->sla_percent.' %</font><br/>
					
				</td>';
			}
			else{ 
				echo '<td style="white-space: nowrap;"><font>'.$row->sla_percent.' %</font></td>';
			}
			
			echo '<td>'.$row->target_date.'</td>';
			echo '<td>'.$row->impact.'</td>';
			echo '<td>'.$row->urgency.'</td>';
			echo '<td>'.$row->priority.'</td>';
			
			echo '</tr>';
		}
		echo '</table><br/>';
	
	}
?>
	<hr class="carved"/>
	<h3 class="myH3"/><b/>FR Master List<br/><br/>
<?php
	if(count($frArr) > 0){
		
		
		$dangerCount = $this->sitequota_model->getFrDanger();
		$missedCount = $this->sitequota_model->getFrMissed();
		$greenCount = count($frArr) - ($dangerCount + $missedCount);
		
		echo '<table class="ticketLegend">';
		echo '<tr><td>Within SLA</td><td>'.$greenCount.'</td></tr>';
		echo '<tr><td>Danger (SLA >= 80%):</td><td>'.$dangerCount.'</td></tr>';
		echo '<tr><td>Missed (SLA >= 100%):</td><td>'.$missedCount.'</td></tr>';
		echo '<tr><td>Total:</td><td>'.count($frArr).'</td></tr>';
		echo '</table><br/><br/>';
		echo '<table class="emailTable">';
		echo '<tr><td><b/>FR#</td>';
		echo '<td><b/>Title</td>';
		echo '<td><b/>Last Update</td></tr>';
		echo '<td><b/>Status</td>';
		echo '<td><b/>Assignee</td>';
		echo '<td><b/>Assignment Group</td>';
		echo '<td><b/>SLA%</td>';
		echo '<td><b/>SLA</td>';
		echo '<td><b/>Priority</td>';
		
		foreach($frArr as $row){
			echo '<tr>';
			echo '<td>'.$row->fulfillment_number.'</td>';
			echo '<td width="100px">'.$row->title.'</td>';
			$update = $this->sitequota_model->getTicketUpdate($row->fulfillment_number);
			if($update != null)
				echo '<td>'.$update->update_text.'</td>';
			else
				echo '<td>No updates.</td>';
			echo '<td>'.$row->status.'</td>';
			echo '<td>'.$row->assignee.'</td>';
			echo '<td>'.$row->assignment_group.'</td>';
			if($row->sla_percent >= 60){ 
				echo '<td style="white-space: nowrap;">';
				echo '<font>'.$row->sla_percent.' %</font></td>';
			}
			else{ 
				echo '<td style="white-space: nowrap;"><font>'.$row->sla_percent.' %</font><br/></td>';
			}
			
			
			echo '<td>'.$row->sla.'</td>';
			echo '<td>'.$row->request_priority.'</td>';
			
			echo '</tr>';
		}
		echo '</table><br/>';
	}

	//echo "<br/><font id='panelSmallFont'>Page generated in ".$page_load_time.' seconds.</font>';
?>

</td></tr>
</table><br/>


</form>

</body>
</html>
