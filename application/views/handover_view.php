<html>
<head>

<script src="/sitequota/styles/tabcontent/tabcontent.js" type="text/javascript"></script>
<script src="/sitequota/styles/twisty/twisty.js" type="text/javascript"></script>

<script src="/sitequota/styles/twisty/scriptaculous.js?load=effects" type="text/javascript"></script>

<link rel="stylesheet" href="/sitequota/styles/twisty/twisty.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="/sitequota/styles/twisty/twisty-print.css" type="text/css" media="print"></link>
<link href="/sitequota/styles/tabcontent/template4/tabcontent.css" rel="stylesheet" type="text/css" />

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

<?php //echo $queueloader;?>
<br/>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#teampriority").click(function(){
		if(document.getElementById('teampriority').checked == true){
			//To get PHP Variables back to AJAX, use JSON_ENCONDE
			$.ajax({
				url:"/sitequota/index.php/nagger/setPrioritySession/1",
				success: function(){}
			});
		}
		else{
			$.ajax({
				url:"/sitequota/index.php/nagger/setPrioritySession/0",
				success: function(){}
			});
		}
		
		
	});
	
	
});
</script>

<script>
function expandAll(){
	var twistyId = parseInt(document.getElementById("twistyId").value);
	
	for(var i=1; i<twistyId; i++){
		
		toggleTwisty(String(i));
	}
	
}

function collapseAll(){
	var twistyId = parseInt(document.getElementById("twistyId").value);
	
	for(var i=1; i<twistyId; i++){
		
		hideTwisty(String(i));
	}
	
}




</script>
<!--
<div align=center>
<img src="/sitequota/styles/img/logo/browser_icon.png" width="150" height="150"/>
<h3 class="myH3Bigger">Handover</h3>
</div>
<hr class="carved"/>
-->
<div align=center>
<table cellpadding="15px">
<tr>
	<td align=center>
		<?php
		echo anchor('nagger/showHandover/Array',
			'<img src="/sitequota/styles/img/update_icon.png" width="50" height="50"/>');
		?>
		<br/><br/>
		<font class="myH3"><u>Step 1. Update Tickets</u></font>
		
	</td>
	<td align=center>
		<img src="/sitequota/styles/img/forward_icon.png" width="50" height="30"/>
	</td>
	<td align=center><br/>
		<?php
		echo anchor('/nagger/generateEmail',
			'<img src="/sitequota/styles/img/generateemail_icon.png" width="60" height="50"/>');
		?>
		<br/><br/>
		<font class="myFont">Step 2. Generate Email</font><br/>
		<input type="checkbox" id="teampriority" name="teampriority" value="teampriority">
		<font class="myFont" style="font-size:13px;" >Team Priority only</font>
	</td>
	<!--
	<td>
		<img src="/sitequota/styles/img/forward_icon.png" width="50" height="30"/>
	</td>
	
	<td align=center>
		<img src="/sitequota/styles/img/email_icon.png" width="50" height="50"/><br/><br/>
		<font class="myFont">3. Send Email</font>
	</td>
	-->
</tr>
</table>
</div>
<hr class="carved"/>
<a href="javascript:expandAll();" class="buttonExpandCollapse" name="expand1" id="expand1">Expand All</a>
<a href="javascript:collapseAll();" class="buttonExpandCollapse" name="expand2" id="expand2">Collapse All</a><br/><br/>
<div align=center><font class="myFont" style="font-size:13px;"><i/>To add  an update, simply click &nbsp;&nbsp; </font>

<img src="/sitequota/styles/img/add_icon.png" width="12px" height="12px"/>
</div><br/>
<ul class="tabs" persist="true">
	<li><a href="#" rel="im">Incidents</a></li>
	<li><a href="#" rel="fr">Fulfillments</a></li>
	<li><a href="#" rel="pt"><img src="/sitequota/styles/img/red_flag.png" width=20 height=20/>Team Priorities</a></li>
</ul>

<div class="tabcontents">
<div id="im" class="tabcontent" align="left">
<h3 class="myH3"><b>IM Master List</b></h3>

<table class="myTable">
<?php 
		$dangerCount = $this->sitequota_model->getImDanger();
		$missedCount = $this->sitequota_model->getImMissed();
		$greenCount = count($imArr) - ($dangerCount + $missedCount);
	?>
	<tr><td>Within SLA</td><td><?php echo $greenCount;?></td></tr>
	<tr><td>Danger (SLA >= 80%):</td><td><?php echo $dangerCount;?></td></tr>
	<tr><td>Missed (SLA >= 100%):</td><td><?php echo $missedCount;?></td></tr>
	<tr><td>Total:</td><td><?php echo count($imArr);?></td></tr>
</table><br/>

<?php 
	$twistyId = null;
	if($queueListIm != null){
		echo '<font id="panelSmallFont"><i/>Click the button(s) below to expand.</font>';
		echo '<table>';
		echo '<div class="collapsible">';
		
		foreach($queueListIm as $queue){
			
			$imArr = $this->sitequota_model->getImInQueue($queue->queue);
			if(count($imArr)>0){
				$twistyId++;
				//Twisty Content START
				echo '<tr ><td colspan="10" class="headerTable"><br/><b/><div align=center><a href="javascript:toggleTwisty('."'".$twistyId."'".');" class="myButtonHeader">'.$queue->queue.'('. count($imArr).')</a></div><br/><br/>';
				
				echo '<div id="'.$twistyId.'">';
				echo '<table class="myTable">';
				echo '<th>Action</th>';
				echo '<th>IM#</th>';
				echo '<th>Title</th>';
				echo '<th>Last Update</th>';
				
				//echo '<th>Status</th>';
				echo '<th>SLA%</th>';
				echo '<th>Assignee</th>';
				echo '<th>Assignment Group</th>';
				//echo '<th>Opened</th>';
				//echo '<th>SLA</th>';
				echo '<th>Priority</th>';
				
				foreach($imArr as $row){
					echo '<tr>';
					echo '<td>'.'<div align=center>'.anchor('nagger/showUpdateTicket/'.$row->incident_number, 
						'<img src="/sitequota/styles/img/add_icon.png" width="12px" height="12px"/>').'</div>'.'</td>';
					echo '<td>'.anchor_popup('nagger/showTicketReport/'.$row->incident_number, $row->incident_number).'</td>';
					echo '<td width="300px">'.$row->title.'</td>';
					
					$update = $this->sitequota_model->getTicketUpdate($row->incident_number);
					
					if($update != null){
						$text = $update->update_text;
						$text = str_replace("[","<b>[",$text);
						$text = str_replace("]","]</b>",$text);
						echo '<td width="500px"><br/>'.$text.'<br/><br/>';
						echo '<font id="panelSmallFont"><i>Updated on: '.$update->date.' '.$update->time.'</i></font>';
						echo '</td>';
					}
					else{
						echo '<td>No updates<br/><br/>';
						echo '</td>';
					}
					
					
					//echo '<td>'.$row->current_status.'</td>';
					if($row->sla_percent >= 100){ 
						echo '<td style="white-space: nowrap;">';
						echo '<font>'.$row->sla_percent.' %</font><br/>
							<div class="progressRed">
							<progress value="'.$row->sla_percent.'" max="100">
							</div>
						</td>';
					}
					else if($row->sla_percent >= 80 && $row->sla_percent < 100){ 
						echo '<td style="white-space: nowrap;">';
						echo '<font>'.$row->sla_percent.' %</font><br/>
							<div class="progressYellow">
							<progress value="'.$row->sla_percent.'" max="100">
							</div>
						</td>';
					}
					else{ 
						echo '<td style="white-space: nowrap;"><font>'.$row->sla_percent.' %</font><br/>
							<div class="progressGreen">
							<progress value="'.$row->sla_percent.'" max="100">
							</div>
						</td>';
					}
					echo '<td>'.$row->assignee.'</td>';
					echo '<td>'.$row->queue.'</td>';
					//echo '<td>'.$row->reported.'</td>';
					//echo '<td>'.$row->target_date.'</td>';
					echo '<td>'.$row->priority.'</td>';
					echo '</tr>';
				}
				echo '</table>';
				echo '</div>';
				echo '</td></tr>';
				//Twisty Content END
			}
?>
	<script>
		//hideTwisty('<?php echo $twistyId;?>');
	</script>
<?php
		}
		echo '</div>';
		echo '</table>';
	}
	else{
			echo '<font class="myFont">No incidents found. All issues must\'ve been closed. Good job! :)</font>';
		}
?>
</div>

<div id="fr" class="tabcontent" align="left">
<h3 class="myH3"><b>FR Master List</b></h3>
<table class="myTable">
	<?php 
		$dangerCount = $this->sitequota_model->getFrDanger();
		$missedCount = $this->sitequota_model->getFrMissed();
		$greenCount = count($frArr) - ($dangerCount + $missedCount);
	?>
	<tr><td>Within SLA</td><td><?php echo $greenCount;?></td></tr>
	<tr><td>Danger (SLA >= 80%):</td><td><?php echo $dangerCount;?></td></tr>
	<tr><td>Missed (SLA >= 100%):</td><td><?php echo $missedCount;?></td></tr>
	<tr><td>Total:</td><td><?php echo count($frArr);?></td></tr>
</table><br/>
<?php
	if($queueListFr != null){
		echo '<font id="panelSmallFont"><i/>Click the button(s) below to expand.</font>';
		echo '<table>';
		echo '<div class="collapsible">';
		
		foreach($queueListFr as $queue){
			
			$frArr = $this->sitequota_model->getFrInQueue($queue->queue);
			if(count($frArr) >0){
				$twistyId++;
				//Twisty Content START
				echo '<tr><td colspan="10" class="headerTable"><br/><div align=center><a href="javascript:toggleTwisty('."'".$twistyId."'".');" class="myButtonHeader">'.$queue->queue.'('. count($frArr).')</a></div><br/><br/>';
				
				echo '<div id="'.$twistyId.'">';
				echo '<table class="myTable">';
				echo '<th>Action</th>';
				echo '<th>FR#</th>';
				echo '<th>Title</th>';
				echo '<th>Last Update</th>';
				
				//echo '<th>Status</th>';
				echo '<th>SLA%</th>';
				echo '<th>Assignee</th>';
				echo '<th>Assignment Group</th>';
				//echo '<th>Opened</th>';
				//echo '<th>SLA</th>';
				echo '<th>Priority</th>';
				foreach($frArr as $row){
					echo '<tr>';
					echo '<td>'.'<div align=center>'.anchor('nagger/showUpdateTicket/'.$row->fulfillment_number, 
						'<img src="/sitequota/styles/img/add_icon.png" width="12px" height="12px"/>').'</div>'.'</td>';
					
					echo '<td>'.anchor_popup('nagger/showTicketReport/'.$row->fulfillment_number, $row->fulfillment_number).'</td>';
					echo '<td width="300px">'.$row->title.'</td>';
					
					$update = $this->sitequota_model->getTicketUpdate($row->fulfillment_number);
					if($update != null){
						$text = $update->update_text;
						$text = str_replace("[","<b>[",$text);
						$text = str_replace("]","]</b>",$text);
						echo '<td width="500px"><br/>'.$text.'<br/><br/>';
						echo '<font id="panelSmallFont"><i>Updated on: '.$update->date.' '.$update->time.'</i></font>';
						echo '</td>';
					}
					else
						echo '<td>No updates.</td>';
					
					
					//echo '<td>'.$row->status.'</td>';
					if($row->sla_percent >= 100){ 
						echo '<td style="white-space: nowrap;">';
						echo '<font>'.$row->sla_percent.' %</font><br/>
							<div class="progressRed">
							<progress value="'.$row->sla_percent.'" max="100">
							</div>
						</td>';
					}
					else if($row->sla_percent >= 80 && $row->sla_percent < 100){ 
						echo '<td style="white-space: nowrap;">';
						echo '<font>'.$row->sla_percent.' %</font><br/>
							<div class="progressYellow">
							<progress value="'.$row->sla_percent.'" max="100">
							</div>
						</td>';
					}
					else{ 
						echo '<td style="white-space: nowrap;"><font>'.$row->sla_percent.' %</font><br/>
							<div class="progressGreen">
							<progress value="'.$row->sla_percent.'" max="100">
							</div>
						</td>';
					}
					echo '<td>'.$row->assignee.'</td>';
					echo '<td>'.$row->assignment_group.'</td>';
					//echo '<td>'.$row->reported.'</td>';
					//echo '<td>'.$row->sla.'</td>';
					echo '<td>'.$row->request_priority.'</td>';
					echo '</tr>';
				}
				echo '</table>';
				echo '</div>';
				echo '</td></tr>';
				//Twisty Content END
				
			}
?>
	<script>
		//hideTwisty('<?php echo $twistyId;?>');
	</script>
<?php
		}
		echo '</table>';
	}
	else{
		echo '<font class="myFont">No fulfillment request(s) found. All issues must\'ve been closed. Good job! :)</font>';
	}
	
	
?>
</div>


<div id="pt" class="tabcontent" align="left">

<?php
		echo '<h3 class="myH3"><b/>Incidents</h3>';
		$imArr = $this->sitequota_model->getPriorityIm();
		if($imArr != null){
			echo '<table class="myTable">';
				echo '<th>Action</th>';
				echo '<th>Priority #</th>';
				echo '<th>IM#</th>';
				echo '<th>Title</th>';
				echo '<th>Last Update</th>';
				
				//echo '<th>Status</th>';
				echo '<th>SLA%</th>';
				echo '<th>Assignee</th>';
				echo '<th>Assignment Group</th>';
				//echo '<th>Opened</th>';
				//echo '<th>SLA</th>';
				echo '<th>Priority</th>';
				
				foreach($imArr as $row){
					echo '<tr>';
					echo '<td>'.'<div align=center>'.anchor('nagger/showUpdateTicket/'.$row->incident_number, 
						'<img src="/sitequota/styles/img/add_icon.png" width="12px" height="12px"/>').'</div>'.'</td>';
					echo '<td align=center>';
						?>
						<script>
							$(document).ready(function(){
								$("#priorityNumIm"+<?php echo $row->id;?>).change(function(){
									var temp = document.getElementById("priorityNumIm"+<?php echo $row->id;?>).value;
									var priorityNumber = temp.substr(temp.length-1,temp.length);
									var ticketId = temp.substr(0, temp.length-2);
									$.ajax({
										url:"/sitequota/index.php/nagger/updateImPiorityNumber/"+ticketId+"/"+priorityNumber,
										success:function(){}
									});
									
								});
							});
						</script>
						<?php
						echo '<select id="priorityNumIm'.$row->id.'">';
						if($row->priority_num == 1)
							echo '<option value="'.$row->id.'|1" selected>1</option>';
						else
							echo '<option value="'.$row->id.'|1">1</option>';
						if($row->priority_num == 2)
							echo '<option value="'.$row->id.'|2" selected>2</option>';
						else
							echo '<option value="'.$row->id.'|2">2</option>';
						if($row->priority_num == 3)
							echo '<option value="'.$row->id.'|3" selected>3</option>';
						else
							echo '<option value="'.$row->id.'|3">3</option>';
						if($row->priority_num == 4)
							echo '<option value="'.$row->id.'|4" selected>4</option>';
						else
							echo '<option value="'.$row->id.'|4">4</option>';
						echo '</select>';
					echo '</td>';
					echo '<td>'.$row->incident_number.'</td>';
					echo '<td width="300px">'.$row->title.'</td>';
					
					$update = $this->sitequota_model->getTicketUpdate($row->incident_number);
					
					if($update != null){
						$text = $update->update_text;
						$text = str_replace("[","<b>[",$text);
						$text = str_replace("]","]</b>",$text);
						echo '<td width="500px"><br/>'.$text.'<br/><br/>';
						echo '<font id="panelSmallFont"><i>Updated on: '.$update->date.' '.$update->time.'</i></font>';
						echo '</td>';
					}
					else{
						echo '<td>No updates<br/><br/>';
						echo '</td>';
					}
					
					
					//echo '<td>'.$row->current_status.'</td>';
					if($row->sla_percent >= 100){ 
						echo '<td style="white-space: nowrap;">';
						echo '<font>'.$row->sla_percent.' %</font><br/>
							<div class="progressRed">
							<progress value="'.$row->sla_percent.'" max="100">
							</div>
						</td>';
					}
					else if($row->sla_percent >= 80 && $row->sla_percent < 100){ 
						echo '<td style="white-space: nowrap;">';
						echo '<font>'.$row->sla_percent.' %</font><br/>
							<div class="progressYellow">
							<progress value="'.$row->sla_percent.'" max="100">
							</div>
						</td>';
					}
					else{ 
						echo '<td style="white-space: nowrap;"><font>'.$row->sla_percent.' %</font><br/>
							<div class="progressGreen">
							<progress value="'.$row->sla_percent.'" max="100">
							</div>
						</td>';
					}
					echo '<td>'.$row->assignee.'</td>';
					echo '<td>'.$row->queue.'</td>';
					//echo '<td>'.$row->reported.'</td>';
					//echo '<td>'.$row->target_date.'</td>';
					echo '<td>'.$row->priority.'</td>';
					echo '</tr>';
				}
				echo '</table>';
		}
		else{
			echo '<font class="myFont">No Prioritized IM.</font>';
		}
		
		echo '<hr class="carved"/>';
		
		
		echo '<h3 class="myH3"><b/>Fulfillment Requests</h3>';
		$frArr = $this->sitequota_model->getPriorityFr();
		if($frArr != null){
			echo '<table class="myTable">';
				echo '<th>Action</th>';
				echo '<th style="white-space:nowrap;">Priority #</th>';
				echo '<th>FR#</th>';
				echo '<th>Title</th>';
				echo '<th>Last Update</th>';
				
				//echo '<th>Status</th>';
				echo '<th>SLA%</th>';
				echo '<th>Assignee</th>';
				echo '<th>Assignment Group</th>';
				//echo '<th>Opened</th>';
				//echo '<th>SLA</th>';
				echo '<th>Priority</th>';
				foreach($frArr as $row){
					echo '<tr>';
					echo '<td>'.'<div align=center>'.anchor('nagger/showUpdateTicket/'.$row->fulfillment_number, 
						'<img src="/sitequota/styles/img/add_icon.png" width="12px" height="12px"/>').'</div>'.'</td>';
					echo '<td align=center>';
					?>
						<script>
							$(document).ready(function(){
								$("#priorityNumFr"+<?php echo $row->id;?>).change(function(){
									var temp = document.getElementById("priorityNumFr"+<?php echo $row->id;?>).value;
									var priorityNumber = temp.substr(temp.length-1,temp.length);
									var ticketId = temp.substr(0, temp.length-2);
									$.ajax({
										url:"/sitequota/index.php/nagger/updateFrPiorityNumber/"+ticketId+"/"+priorityNumber,
										success:function(){}
									});
									
								});
							});
						</script>
					<?php
						echo '<select id="priorityNumFr'.$row->id.'">';
						if($row->priority_num == 1)
							echo '<option value="'.$row->id.'|1" selected>1</option>';
						else
							echo '<option value="'.$row->id.'|1">1</option>';
						if($row->priority_num == 2)
							echo '<option value="'.$row->id.'|2" selected>2</option>';
						else
							echo '<option value="'.$row->id.'|2">2</option>';
						if($row->priority_num == 3)
							echo '<option value="'.$row->id.'|3" selected>3</option>';
						else
							echo '<option value="'.$row->id.'|3">3</option>';
						if($row->priority_num == 4)
							echo '<option value="'.$row->id.'|4" selected>4</option>';
						else
							echo '<option value="'.$row->id.'|4">4</option>';
						
						echo '</select>';
					echo '</td>';
					echo '<td>'.$row->fulfillment_number.'</td>';
					echo '<td width="300px">'.$row->title.'</td>';
					
					$update = $this->sitequota_model->getTicketUpdate($row->fulfillment_number);
					if($update != null){
						$text = $update->update_text;
						$text = str_replace("[","<b>[",$text);
						$text = str_replace("]","]</b>",$text);
						echo '<td width="500px"><br/>'.$text.'<br/><br/>';
						echo '<font id="panelSmallFont"><i>Updated on: '.$update->date.' '.$update->time.'</i></font>';
						echo '</td>';
					}
					else
						echo '<td>No updates.</td>';
					
					
					//echo '<td>'.$row->status.'</td>';
					if($row->sla_percent >= 100){ 
						echo '<td style="white-space: nowrap;">';
						echo '<font>'.$row->sla_percent.' %</font><br/>
							<div class="progressRed">
							<progress value="'.$row->sla_percent.'" max="100">
							</div>
						</td>';
					}
					else if($row->sla_percent >= 80 && $row->sla_percent < 100){ 
						echo '<td style="white-space: nowrap;">';
						echo '<font>'.$row->sla_percent.' %</font><br/>
							<div class="progressYellow">
							<progress value="'.$row->sla_percent.'" max="100">
							</div>
						</td>';
					}
					else{ 
						echo '<td style="white-space: nowrap;"><font>'.$row->sla_percent.' %</font><br/>
							<div class="progressGreen">
							<progress value="'.$row->sla_percent.'" max="100">
							</div>
						</td>';
					}
					echo '<td>'.$row->assignee.'</td>';
					echo '<td>'.$row->assignment_group.'</td>';
					//echo '<td>'.$row->reported.'</td>';
					//echo '<td>'.$row->sla.'</td>';
					echo '<td>'.$row->request_priority.'</td>';
					echo '</tr>';
				}
				echo '</table>';
		}
		else{
			echo '<font class="myFont">No Prioritized FR.</font>';
		}
?>

</div>



</div>
<input type=hidden id="twistyId" value="<?php 
if($twistyId != null)
	echo $twistyId;
else
	echo 0;
?>"/>

<?php echo "<br/><br/><font id='panelSmallFont'>Page generated in ".$page_load_time.' seconds.</font>';?>

</body>
</html>
