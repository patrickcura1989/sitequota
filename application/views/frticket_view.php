<script>
  $(function() {
	$( document ).tooltip();
  });
</script>



<style>
.ui-tooltip
{
    font-size:10pt;
    font-family:'RobotoLight';
}

.myH3{
   font: 18px/27px 'RobotoLight', Arial, sans-serif;
}
.myH3Bigger{
   font: 20px 'RobotoLight', Arial, sans-serif;
}

.myFont{
	font: 18px/27px 'RobotoLight', Arial, sans-serif;
}

.myHugeFont{
	font: 30px/35px 'RobotoLight', Arial, sans-serif;
}

</style>

<h3 class="myH3Bigger"><?php echo $ticketDetails->fulfillment_number.' - '.$ticketDetails->title;?></h3>
<hr class="carved"/>

<h3 class="myH3Bigger">Basic Ticket Info</h3>
<table>
<tr>
<td width = '350'>
	<table class="myTable">
	
	<tr>
		<td><b/>Request Priority</td>
		<td><?php echo $ticketDetails->request_priority;?></td>
	</tr>
	<tr>
		<td><b/>CI</td>
		<td><?php echo $ticketDetails->ci;?></td>
	</tr>
	<tr>
		<td><b/>Service</td>
		<td><?php echo $ticketDetails->service;?></td>
	</tr>
	<tr>
		<td><b/>Service Type</td>
		<td><?php echo $ticketDetails->service_type;?></td>
	</tr>
	<tr>
		<td><b/>Request Type</td>
		<td><?php echo $ticketDetails->request_priority;?></td>
	</tr>
	<tr>
		<td><b/>Queue</td>
		<td><?php echo $ticketDetails->assignment_group;?></td>
	</tr>
	<tr>
		<td><b/>Assignee</td>
		<td><?php echo $ticketDetails->assignee;?></td>
	</tr>
	<tr>
		<td><b/>RCV By</td>
		<td><?php echo $ticketDetails->rcv_by;?></td>
	</tr>
	<tr>
		<td><b/>Owning Team</td>
		<td><?php echo $this->sitequota_model->getOwningTeamName($ticketDetails->owning_team);?></td>
	</tr>
	</table>
</td>
<td valign=top width='350'>
	<table class="myTable">
		<tr>
			<td><b/>Status</td>
			<td><?php echo $ticketDetails->status;?></td>
		</tr>
		<tr>
			<td><b/>Opened (SGT)</td>
			<td><?php echo $ticketDetails->reported;?></td>
		</tr>
		<tr>
			 
			<td><b/>SWT (SGT) <img src="/sitequota/styles/img/about.png" 
			title = "<?php echo SWTCWT_TOOLTIP;?>"
			width=13 height=13/></td>
			<td><?php echo $ticketDetails->swt_date.' '.$ticketDetails->swt_time;?></td>
		</tr>
		<tr>
			<td><b/>CWT (SGT) <img src="/sitequota/styles/img/about.png" 
			title = "<?php echo SWTCWT_TOOLTIP;?>"
			width=13 height=13/></td>
			<td><?php echo $ticketDetails->cwt_date.' '.$ticketDetails->cwt_date;?></td>
		</tr>
		<tr>
			<td><b/>SLA (SGT)</td>
			<td><?php echo $ticketDetails->sla;?></td>
		</tr>
		<tr>
			<td><b/>SLA %</td>
			
				<?php
					if($ticketDetails->sla_percent >= 100){ 
						echo '<td style="white-space: nowrap;">';
						echo '<font>'.$ticketDetails->sla_percent.' %</font><br/>
							<div class="progressRed">
							<progress value="'.$ticketDetails->sla_percent.'" max="100">
							</div>
						</td>';
					}
					else if($ticketDetails->sla_percent >= 80 && $ticketDetails->sla_percent < 100){ 
						echo '<td style="white-space: nowrap;">';
						echo '<font>'.$ticketDetails->sla_percent.' %</font><br/>
							<div class="progressYellow">
							<progress value="'.$ticketDetails->sla_percent.'" max="100">
							</div>
						</td>';
					}
					else{ 
						echo '<td style="white-space: nowrap;"><font>'.$ticketDetails->sla_percent.' %</font><br/>
							<div class="progressGreen">
							<progress value="'.$ticketDetails->sla_percent.'" max="100">
							</div>
						</td>';
					}
				?>
			
		</tr>
	</table>
</td>
	<td valign=top width='300px'>
	<?php 
	if($this->sitequota_model->isImManager()){
		echo form_open('nagger/processUpdateImManager'); 
	
	?>
		<font class="myFont" style="font-size:13px;"><i/>For Incident Managers Only</font><br/><br/>
		<input type=radio name="ticketAction" value="outOfScope" <?php if($scopeFlag == 1) echo 'checked';?>/><font class="myFont" style="font-size:17px;">Out of Scope</font> <br/>
		<input type=radio name="ticketAction" value="inScope" <?php if($scopeFlag == 0) echo 'checked';?>/><font class="myFont" style="font-size:17px;">In Scope</font><br/>
		<input type=radio name="ticketAction" value="incentive"/><font class="myFont" style="font-size:17px;">Incentive SLA (in progress)</font><br/><br/>
		<input type=hidden name="ticketNumber" value="<?php echo $ticketDetails->fulfillment_number;?>"/>
		<input type=hidden name="ticketId" value="<?php echo $ticketId;?>"/>
		
		<input type=submit class="flatButton" value="Save"/>
	<?php 
		echo form_close();
	}
	else{
	
	}
	?>
	</td>
	<td valign=top>
		<?php 
			if($this->sitequota_model->isImManager()){
				echo '<font class="myFont">Assign Owner</font><br/><br/>';
				$myTeammates = $this->sitequota_model->getMyTeammates();
				if($myTeammates != null){
					echo '<font class="myFont" style="font-size:13px;">Team Members: '.count($myTeammates).'</font><br/>';
						//need to gather domain and domainname upon user login
						$ownerData = $this->sitequota_model->getUserData($ticketDetails->owner);
						$domain = 'ap'; //Currently supporting ASIAPACIFIC domain as of the moment
						$domainName = $ownerData->domain_name;
						$employeeNumber = substr($ticketDetails->owner, -4);
						$profileImgSrc = 'http://pictures.core.hp.com/images/medium_'.$domain.'_'.$domainName.'_'.$employeeNumber.'.jpg';
						$profileImgDiv = '<div class="circle" style="background-image:url(\''.$profileImgSrc.'\');"></div>';
					
					echo '<table>';
					echo '<tr><td width=80px><font class="myFont" style="font-size:13px;">Owner: </font></td><td>'.$profileImgDiv.'</td>';
					echo '</tr></table><br/>';
					echo form_open($form);
					echo '<input type="hidden" name="ticketNumber" value="'.$ticketDetails->fulfillment_number.'"/>';
					echo '<input type="hidden" name="scopeFlag" value="'.$scopeFlag.'"/>';
					echo '<select name="assignOwner" class="mySelect" onChange="this.form.submit()">';
					$ownerId = $ticketDetails->owner;
					foreach($myTeammates as $member){
						if($member->email == null || $member->email == ''){
							if($ownerId == $member->emp_id)
								echo '<option value = "'.$member->emp_id.'" selected>'.$member->emp_id.'</option>';
							else
								echo '<option value = "'.$member->emp_id.'">'.$member->emp_id.'</option>';
							
						}
						else{
							if($ownerId == $member->emp_id)
								echo '<option value = "'.$member->emp_id.'" selected>'.$member->email.'</option>';
							else
								echo '<option value = "'.$member->emp_id.'">'.$member->email.'</option>';
						}
					}
					echo '</select>';
					echo form_close();
				}
			}
		?>
	</td>
</tr>
</table>

<hr class="carved"/>

<table>
<tr>
<td width = '300' valign=top>
	<h3 class="myH3Bigger">Queue Bounces</h3>
	<table class="myTable">
	<th>Queue</th>
	<th>Total Time (mins)</th>
	<?php
		$queueBounces = $this->sitequota_model->getFrTicketDistinctBounces($ticketId);
		if($queueBounces != null)
		foreach($queueBounces as $row){
			echo '<tr>';
			echo '<td>'.$row->owning_team.'</td>';
			$computeTime = $this->sitequota_model->computeFrQueueTime($ticketId, $row->owning_team);
			if(strpos($computeTime, 'on-going') == true)
				echo '<td><div style="background-color:yellow;">'.$computeTime.'</div></td>';
			else
				echo '<td>'.$computeTime.'</td>';
			echo '</tr>';
		}
	?>
	</table>
</td>
<td valign=top width=400px>
	<h3 class="myH3Bigger">Bounces History</h3>
	<table class="myTable">
	<th>Queue</th>
	<th>Logged Date</th>
	<th>Logged Time</th>
	<?php
		$queueBounces = $this->sitequota_model->getFrTicketBounces($ticketId);
		if($queueBounces != null)
		foreach($queueBounces as $row){
			echo '<tr>';
			echo '<td>'.$row->owning_team.'</td>';
			echo '<td>'.$row->start_date.'</td>';
			echo '<td>'.$row->start_time.'</td>';
			echo '</tr>';
		}
	?>
	</table>
</td>

<td valign=top>
	<h3 class="myH3Bigger">Ticket Updates (Internal Only)</h3>
	<?php
		
		$updateList = $this->sitequota_model->getTicketUpdateList($ticketDetails->fulfillment_number);
		if(count($updateList) >0){
			echo '<div style="max-height:300px; overflow-y:scroll;">';
			echo '<table class="memberTicketsTable" >';
			echo '<th>Update</th>';
			echo '<th>Date</th>';
			echo '<th>Time</th>';
			echo '<th>Update By</th>';
			foreach($updateList as $row){
				echo '<tr>';
				$text = $row->update_text;
				$text = str_replace("[","<b>[",$text);
				$text = str_replace("]","]</b>",$text);
				echo '<td>'.$text.'</td>';
				echo '<td>'.$row->date.'</td>';
				echo '<td>'.$row->time.'</td>';
				echo '<td>'.$row->updated_by.'</td>';
				echo '</tr>';
			}	
			echo '</table>';
			echo '</div>';
		}
		else{
			echo '<font id="panelSmallFont">No updates yet.</font>';
		}
	?>
</td>
</tr>
</table>