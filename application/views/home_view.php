<html>
<head>


<link rel="stylesheet" href="/sitequota/styles/simpsons.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="/sitequota/styles/twisty/twisty.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="/sitequota/styles/twisty/twisty-print.css" type="text/css" media="print"></link>
<link href="/sitequota/styles/tabcontent/template4/tabcontent.css" rel="stylesheet" type="text/css" ></link>


<script src="/sitequota/styles/tabcontent/tabcontent.js" type="text/javascript"></script>
<script src="/sitequota/styles/twisty/twisty.js" type="text/javascript"></script>
<!-- COMMENTING this out since it's causing an error with jquery autocomplete
<script src="/sitequota/styles/twisty/prototype.js" type="text/javascript"></script>
-->
<script src="/sitequota/styles/twisty/scriptaculous.js?load=effects" type="text/javascript"></script>


<style>
.myH3{
   font: 18px/27px 'RobotoLight', Arial, sans-serif;
}
.myH3Bigger{
   font: 25px 'RobotoLight-Bold', Arial, sans-serif;
}

.myFont{
	font: 18px/27px 'RobotoLight', Arial, sans-serif;
}

.myHugeFont{
	font: 30px/35px 'RobotoLight', Arial, sans-serif;
}


 
</style>

<style>
#panelSmallFont{
	font: 13px/15px 'RobotoLight', Arial, sans-serif;
}
</style>



<body>
<br/>
	

<!--
<div align=center>
<img src="/sitequota/styles/img/logo/browser_icon.png" width="150" height="150"/><br/>

</div>
<hr class="carved"/>
-->
<div align=center>
<font class="myFont" color=red> <?php echo validation_errors(); ?></font>
<table cellpadding="20px">
<tr>
<td>
	<h3 class="myH3"><b/>Add Ticket</h3>
	<?php echo form_open('nagger/processAddIm'); ?>
	
	<table class='myTable'>
		<tr>
			<td>
				Enter Ticket#:
			</td>
			<td>
				<input type=text size=16 name='im' value="<?php echo set_value('im');?>"/>
				<input type=submit class="myButton" value="Extract" name="submit"/>
			</td>
			
		</tr>
	</table>
	
	
</td>
<td>
	<img src="/sitequota/styles/img/back_forth_icon.png" width="60px" height="30px"/>
</td>
<td>
	
	<h3 class="myH3"><b/>Add from Queue</h3>
	<table class='myTable'>
		<tr>
			<td>
				Enter SM Queue:
			</td>
			<td>
				<input type=text size=16 name='queue' value="<?php echo set_value('queue');?>"/>
				<input type=submit class="myButton" value="Get IM" name="submit"/>
				<input type=submit class="myButton" value="Get FR" name="submit"/>
			</td>
			
		</tr>
	</table><br/>
	<font id="panelSmallFont"><i/>Loading time may vary - 1 ticket : 3 seconds</font><br/>
	
</td>
</tr>

</table>
</div><br/>

<div align=center>
	<img src="/sitequota/styles/img/about.png" height=30 width=30/><br/><br/>
	<table id = "panelSmallFont">
	<tr><td>All tickets are automatically added based on your registered queue in Nagger. </td></tr>
	<tr><td>All tickets added are tracked wherever it goes, until they are closed.</td></tr>
	<tr><td><br/><b>Registered queue:</b> 
	<?php 
		$list  = $this->sitequota_model->getOwningTeamQueueList($this->session->userdata('teamId'));
		foreach($list as $row){
			echo '<b>'.$row->queue.'</b> ';
		}
	?>
	</td></tr>
	</table>
	</div>
	
	

<!--
<div align=center style="position:relative; left:-50px;">
	<h3 class="myH3"><b/>Bulk Add</h3>
	<table class='myTable'>
		<tr>
			<td>
				Enter Tickets:
			</td>
			<td>
				<textarea cols=30 rows=7></textarea><br/>
				<div align=center>
					<input type=submit class="myButton" value="Bulk Add IM" name="submit"/>
					<input type=submit class="myButton" value="Bulk Add FR" name="submit"/>
				</div>
			</td>
			
		</tr>
	</table>
</div>
-->

<div align=center>
<?php if($msg !='' || $msg != null) echo '<hr class="carved"/>'.$msg; ?><br/>

<?php 
//To make Add button display when a single ticket addition operation is initiated.
if($msg != '' && strpos($msg, '(s)')===false) 
	echo '<input type=submit class="myButton" value="Add" name="submit"/>';
?>
</div>
<div align=center>



</div>
<hr class="carved"/>

<?php echo form_close(); ?>


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

<div>
<div style="float:left;">
<a href="javascript:expandAll();" class="buttonExpandCollapse" name="expand1" id="expand1">Expand All</a>
<a href="javascript:collapseAll();" class="buttonExpandCollapse" name="expand2" id="expand2">Collapse All</a><br/><br/>
</div>


<div style="float:right;">
	<table>
	<tr>
	<td><img src="/sitequota/styles/img/search.png" height=20px width=20px/>
	</td>
	<td>
	<input type="text" name="searchText" id="searchText" class="searchText" placeholder="Search for opened tickets via number or title" style="height:30px;" size=60px/>
	</td>
	</tr>
	</table>
</div>	
</div><br/><br/><br/>
<ul class="tabs" persist="true">
	<li><a href="#" rel="im">Incidents</a></li>
	<li><a href="#" rel="fr">Fulfillments</a></li>
	<li><a href="#" rel="pt"><img src="/sitequota/styles/img/red_flag.png" width=20 height=20/>Team Priorities</a></li>
</ul>



<div class="tabcontents">
<div id="im" class="tabcontent" align="left">
<h3 class="myH3"><b>Incidents Master List</b></h3>
<?php
	$month = date('m');
	$year = date('Y');
?>
<table>
<tr>
<td width="78%">
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
</table>
</td>
<td valign=top>
<table class="myTable"  align=right>
<tr>
	
	<td align=center><font class="myFont">Incidents SWT</font><br/>
		<font class="myHugeFont"><?php echo $this->sitequota_model->getSwtIncidentsMonth($month, $year);?>%</font>
	</td>
	<td align=center><font class="myFont">Incidents CWT</font><br/>
		<font class="myHugeFont"><?php echo $this->sitequota_model->getCwtIncidentsMonth($month, $year);?>%</font>
	</td>
</tr>
</table>
</td>
</tr>
</table>
<div align=right>

<a href="../../nagger/downloadTeamIncidents"><img src="/sitequota/styles/img/download_icon.png" width=40 height=40/></a>
<br/>
<font id="panelSmallFont">Export to Excel</font>

</div><br/>

<?php 
	$twistyId = null;
	if($queueListIm != null){
		echo '<font id="panelSmallFont">Click <img src="/sitequota/styles/img/red_flag.png" width=20 height=20/> to prioritize.</font>';
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
				echo '<th>Status</th>';
				echo '<th>SLA%</th>';
				echo '<th>Assignee</th>';
				echo '<th>Assignment Group</th>';
				echo '<th>Opened</th>';
				echo '<th>SLA</th>';
				echo '<th>Priority</th>';
				foreach($imArr as $row){
					echo '<tr>';
					echo '<td align=center>'.anchor('/nagger/prioritizeTicket/'.$row->incident_number, '<img src="/sitequota/styles/img/red_flag.png" width=20 height=20/>').'</td>';
					echo '<td>'.anchor_popup('nagger/showTicketReport/'.$row->incident_number, $row->incident_number).'</td>';
					echo '<td>'.$row->title.'</td>';
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
					echo '<td style="white-space:nowrap">'.$row->reported.'</td>';
					echo '<td style="white-space:nowrap">'.$row->target_date.'</td>';
					echo '<td style="white-space:nowrap">'.$row->priority.'</td>';
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
<h3 class="myH3"><b>Fulfillments Master List</b></h3>
<table>
<tr>
<td width="74.5%">
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
</table>
</td>
<td valign=top>
<table align=right>
<table class="myTable" align=right>
<tr>
	
	<td align=center><font class="myFont">Fulfillments SWT</font><br/>
		<font class="myHugeFont"><?php echo $this->sitequota_model->getSwtFulfillmentMonth($month, $year);?>%</font>
	</td>
	<td align=center><font class="myFont">Fulfillments CWT</font><br/>
		<font class="myHugeFont"><?php echo $this->sitequota_model->getCwtFulfillmentMonth($month, $year);?>%</font>
	</td>
</tr>
</table>
</table>
</td>
</tr>
</table>
<div align=right>

<a href="../../nagger/downloadTeamFulfillments"><img src="/sitequota/styles/img/download_icon.png" width=40 height=40/></a>
<br/>
<font id="panelSmallFont">Export to Excel</font>

</div><br/>


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
				echo '<th>Status</th>';
				echo '<th>SLA%</th>';
				echo '<th>Assignee</th>';
				echo '<th>Assignment Group</th>';
				echo '<th>Opened</th>';
				echo '<th>SLA</th>';
				echo '<th>Priority</th>';
				foreach($frArr as $row){
					echo '<tr>';
					echo '<td align=center>'.anchor('/nagger/prioritizeTicket/'.$row->fulfillment_number, '<img src="/sitequota/styles/img/red_flag.png" width=20 height=20/>').'</td>';
					echo '<td>'.anchor_popup('nagger/showTicketReport/'.$row->fulfillment_number, $row->fulfillment_number).'</td>';
					echo '<td>'.$row->title.'</td>';
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
					echo '<td style="white-space:nowrap">'.$row->reported.'</td>';
					echo '<td style="white-space:nowrap">'.$row->sla.'</td>';
					echo '<td style="white-space:nowrap">'.$row->request_priority.'</td>';
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

<div id="pt" class="tabcontent" align="left">

<?php
		echo '<h3 class="myH3"><b/>Incidents</h3>';
		$imArr = $this->sitequota_model->getPriorityIm();
		if($imArr != null){
		echo '<font id="panelSmallFont">Click <img src="/sitequota/styles/img/left_arrow.png" width=20 height=20/> to unprioritize.</font><br/>';
		echo '<table class="myTable">';
		echo '<th>Action</th>';
		echo '<th>Priority</th>';
		echo '<th>IM#</th>';
		echo '<th>Title</th>';
		echo '<th>Status</th>';
		echo '<th>SLA%</th>';
		echo '<th>Assignee</th>';
		echo '<th>Assignment Group</th>';
		echo '<th>Opened</th>';
		echo '<th>SLA</th>';
		echo '<th>Priority</th>';
		foreach($imArr as $row){
			echo '<tr>';
			echo '<td align=center>'.anchor('/nagger/unprioritizeTicket/'.$row->incident_number, '<img src="/sitequota/styles/img/left_arrow.png" width=20 height=20/>').'</td>';
				if($row->priority_num == 1)
					echo '<td align=center id="priority1">';
				else if($row->priority_num == 2)
					echo '<td align=center id="priority2">';
				else if($row->priority_num == 3)
					echo '<td align=center id="priority3">';
				else if($row->priority_num == 4)
					echo '<td align=center id="priority4">';
				
			echo $row->priority_num.'</td>';
				
			echo '<td>'.anchor_popup('nagger/showTicketReport/'.$row->incident_number, $row->incident_number).'</td>';
			echo '<td width=70%>'.$row->title.'</td>';
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
			echo '<td style="white-space:nowrap">'.$row->reported.'</td>';
			echo '<td style="white-space:nowrap">'.$row->target_date.'</td>';
			echo '<td style="white-space:nowrap">'.$row->priority.'</td>';
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
		echo '<font id="panelSmallFont">Click <img src="/sitequota/styles/img/left_arrow.png" width=20 height=20/> to unprioritize.</font>';
		echo '<table class="myTable">';
				echo '<th>Action</th>';
				echo '<th>Priority</th>';
				echo '<th>FR#</th>';
				echo '<th>Title</th>';
				echo '<th>Status</th>';
				echo '<th>SLA%</th>';
				echo '<th>Assignee</th>';
				echo '<th>Assignment Group</th>';
				echo '<th>Opened</th>';
				echo '<th>SLA</th>';
				echo '<th>Priority</th>';
				foreach($frArr as $row){
					echo '<tr>';
					echo '<td align=center>'.anchor('/nagger/unprioritizeTicket/'.$row->fulfillment_number, '<img src="/sitequota/styles/img/left_arrow.png" width=20 height=20/>').'</td>';
						if($row->priority_num == 1)
							echo '<td align=center id="priority1">';
						else if($row->priority_num == 2)
							echo '<td align=center id="priority2">';
						else if($row->priority_num == 3)
							echo '<td align=center id="priority3">';
						else if($row->priority_num == 4)
							echo '<td align=center id="priority4">';
						
					echo $row->priority_num.'</td>';
					echo '<td>'.anchor_popup('nagger/showTicketReport/'.$row->fulfillment_number, $row->fulfillment_number).'</td>';
					echo '<td width=70%>'.$row->title.'</td>';
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
					echo '<td style="white-space:nowrap">'.$row->reported.'</td>';
					echo '<td style="white-space:nowrap">'.$row->sla.'</td>';
					echo '<td style="white-space:nowrap">'.$row->request_priority.'</td>';
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
<br/><br/><br/><br/>


</body>
</html>