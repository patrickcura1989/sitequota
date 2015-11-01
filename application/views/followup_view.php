<html>
<head>
<script src="/sitequota/styles/tabcontent/tabcontent.js" type="text/javascript"></script>
<script src="/sitequota/styles/twisty/twisty.js" type="text/javascript"></script>
<script src="/sitequota/styles/twisty/prototype.js" type="text/javascript"></script>
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
<div align=center>
<img src="/sitequota/styles/img/followup_icon.png" width="200" height="70"/>
<h3 class="myH3Bigger">Follow-Up</h3>
</div>
<hr class="carved"/>
<div align=center>
<table cellpadding="15px">
<tr>
	<td align=center>
		<?php
		echo anchor('#',
			'<img src="/sitequota/styles/img/email_followup.png" width="50" height="50"/>');
		?>
		<br/><br/>
		<font class="myH3">via Email</font>
		
	</td>
	<td align=center>
		<img src="/sitequota/styles/img/back_forth_icon.png" width="50" height="30"/>
	</td>
	<td align=center>
		<?php
		echo anchor('#',
			'<img src="/sitequota/styles/img/sms_icon.png" width="60" height="50"/>');
		?>
		<br/><br/>
		<font class="myFont">via SMS</font>
	
</tr>
</table>
</div>
<hr class="carved"/>
<a href="javascript:expandAll();" class="buttonExpandCollapse" name="expand1" id="expand1">Expand All</a>
<a href="javascript:collapseAll();" class="buttonExpandCollapse" name="expand2" id="expand2">Collapse All</a><br/><br/>
<ul class="tabs" persist="true">
	<li><a href="#" rel="im">Incidents</a></li>
	<li><a href="#" rel="fr">Fulfillments</a></li>
	
</ul>

<div class="tabcontents">
<div id="im" class="tabcontent" align="left">
<h3 class="myH3"><b>IM Master List</b></h3>

<table class="myTable">
<tr><td>Danger (SLA >= 80%):</td><td><?php echo $this->sitequota_model->getImDanger();?></td></tr>
<tr><td bgcolor=red>Missed (SLA >= 100%):</td><td><?php echo $this->sitequota_model->getImMissed();?></td></tr>
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
				echo '<tr ><td colspan="10" class="headerTable"><br/><b/><div align=center><a href="javascript:toggleTwisty('."'".$twistyId."'".');" class="myButtonHeader">'.$queue->queue.'('. count($imArr).')</a><br/><br/>';
				
				echo '<img src="/sitequota/styles/img/email_followup.png" width="30" height="30"/>'.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
				echo '<img src="/sitequota/styles/img/sms_icon.png" width="30" height="30"/>';
				echo '</div><br/><br/>';
				
				echo '<div id="'.$twistyId.'">';
				echo '<table class="myTable">';
				echo '<th>Action</th>';
				echo '<th>IM#</th>';
				echo '<th>Title</th>';
				echo '<th>Last Update</th>';
				echo '<th>Status</th>';
				echo '<th>SLA%</th>';
				echo '<th>Assignee</th>';
				echo '<th>Assignment Group</th>';
				//echo '<th>Opened</th>';
				echo '<th>SLA</th>';
				echo '<th>Priority</th>';
				
				foreach($imArr as $row){
					echo '<tr>';
					echo '<td><input type=checkbox /></td>';
					echo '<td>'.$row->incident_number.'</td>';
					echo '<td width="300px">'.$row->title.'</td>';
					
					$update = $this->sitequota_model->getTicketUpdate($row->incident_number);
					if($update != null){
						echo '<td width="300px">'.$update->update_text.'<br/><br/>';
						echo '</td>';
					}
					else{
						echo '<td>No updates<br/><br/>';
						echo '</td>';
					}
					
					
					echo '<td>'.$row->current_status.'</td>';
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
					echo '<td>'.$row->target_date.'</td>';
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
		hideTwisty('<?php echo $twistyId;?>');
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
	<tr><td>Danger (SLA >= 80%):</td><td><?php echo $this->sitequota_model->getFrDanger();?></td></tr>
	<tr><td>Missed (SLA >= 100%):</td><td><?php echo $this->sitequota_model->getFrMissed();?></td></tr>
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
				echo '<tr><td colspan="10" class="headerTable"><br/><div align=center><a href="javascript:toggleTwisty('."'".$twistyId."'".');" class="myButtonHeader">'.$queue->queue.'('. count($frArr).')</a><br/><br/>';
				
				echo '<img src="/sitequota/styles/img/email_followup.png" width="30" height="30"/>'.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
				echo '<img src="/sitequota/styles/img/sms_icon.png" width="30" height="30"/>';
				echo '</div><br/><br/>';
				
				echo '<div id="'.$twistyId.'">';
				echo '<table class="myTable">';
				echo '<th>FR#</th>';
				echo '<th>Action</th>';
				echo '<th>Title</th>';
				echo '<th>Last Update</th>';
				echo '<th>Status</th>';
				echo '<th>SLA%</th>';
				echo '<th>Assignee</th>';
				echo '<th>Assignment Group</th>';
				//echo '<th>Opened</th>';
				echo '<th>SLA</th>';
				echo '<th>Priority</th>';
				foreach($frArr as $row){
					echo '<tr>';
					echo '<td><input type=checkbox /></td>';
					echo '<td>'.$row->fulfillment_number.'</td>';
					echo '<td width="300px">'.$row->title.'</td>';
					
					$update = $this->sitequota_model->getTicketUpdate($row->fulfillment_number);
					if($update != null)
						echo '<td width="300px">'.$update->update_text.'</td>';
					else
						echo '<td>No updates.</td>';
					
					
					echo '<td>'.$row->status.'</td>';
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
					echo '<td>'.$row->sla.'</td>';
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
		hideTwisty('<?php echo $twistyId;?>');
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
