<html>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="/sitequota/styles/twisty/twisty.js" type="text/javascript"></script>
<script src="/sitequota/styles/twisty/prototype.js" type="text/javascript"></script>



<link rel="stylesheet" href="/sitequota/styles/cards.css" type="text/css"></link>
<link rel="stylesheet" href="/sitequota/styles/twisty/twisty.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="/sitequota/styles/twisty/twisty-print.css" type="text/css" media="print"></link>


<style>
.myH3{
   font: 18px/27px 'RobotoLight-Bold', Arial, sans-serif;
}
.myH3Bigger{
   font: 35px 'RobotoLight-Bold', Arial, sans-serif;
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
<font class="myH3Bigger"><?php echo $teamName;?></font><br/><br/>
<font id="panelSmallFont"><?php echo count($teamMembers);?> members</font>
</div><hr class="carved"/>
<table cellspacing=20px cellpadding=40px>
<?php
	if(count($teamMembers)>0){
		$i = 0;
		
		$pagination = 4;
		foreach($teamMembers as $member){
			if($i == 0){
				echo '<tr>';
				$i++;
			}
			
			echo '<td style="background-color:#EFECE5;border-radius:30px;">';
			
			//Construct Profile Picture
			$domain = 'ap'; //Currently supporting ASIAPACIFIC domain as of the moment
			$domainName = $member->domain_name;
			$employeeNumber = substr($member->emp_id, -4);
			$profileImgSrc = 'http://pictures.core.hp.com/images/medium_'.$domain.'_'.$domainName.'_'.$employeeNumber.'.jpg';
			$profileImgDiv = '<div class="circleBig" style="background-image:url(\''.$profileImgSrc.'\');"></div>';
			//Construct Profile Picture
			
			echo $profileImgDiv.'<br/>';
			
			$imListMember = $this->sitequota_model->getImListMember($member->emp_id);
			$frListMember = $this->sitequota_model->getFrListMember($member->emp_id);
			
			//Display Profile Data////////////////////////////////////////////
			
					echo '<table align=center style="font-family:RobotoLight; font-size:13px;">';
						echo '<tr>';
							echo '<td>Emp #: </td>';
							echo '<td>'.$member->emp_id.'</td>';
						echo '</tr>';
						
						echo  '<tr>';
							echo '<td>Name: </td>';
						if($member->email == null || $member->email == ''){
							echo '<td>No data</td>';
						}
						else{
							echo '<td style="white-space:nowrap;">'.$member->first_name.' '.$member->last_name;
							echo '  <a href="sip:'.$member->email.'"><img src="/sitequota/styles/img/chat.png" height=15px width=15px /></a>';
							echo '</td>';
						}
						echo  '</tr>';
						
						echo '<tr>';
							echo '<td>IM Owned: </td>';
							echo '<td>'.count($imListMember).'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>FR Owned: </td>';
							echo '<td>'.count($frListMember).'</td>';
						echo '</tr>';
					echo '</table><br/>';
				
						
						echo '<div align=center><a href="javascript:toggleTwisty('."'IM".$member->emp_id."'".');" class="myButtonHeader" style="width:100px;">';
						echo 'View IM</a></div>';
						
						echo '<div align=center><a href="javascript:toggleTwisty('."'FR".$member->emp_id."'".');" class="myButtonHeader" style="width:100px;">';
						echo 'View FR</a></div><br/>';
					echo '<div id="IM'.$member->emp_id.'" style="max-height:300px; overflow:scroll;">';
						if(count($imListMember)>0){
							echo '<table class="memberTicketsTable">';
							echo '<th>IM#</th>';
							echo '<th>Title</th>';
							echo '<th>Priority</th>';
							echo '<th>Last Update</th>';
							foreach($imListMember as $im){
								echo '<tr>';
								echo '<td>'.anchor_popup('/nagger/showTicketReport/'.$im->incident_number, $im->incident_number).'</td>';
								echo '<td>'.$im->title.'</td>';
								echo '<td>'.$im->priority.'</td>';
								$update = $this->sitequota_model->getTicketUpdate($im->incident_number);
								if($update != null){
									echo '<td width="500px"><br/>'.$update->update_text.'<br/><br/>';
									echo '<font id="panelSmallFont"><i>Updated on: '.$update->date.' '.$update->time.'</i></font>';
									echo '</td>';
								}
								else{
									echo '<td style="white-space:nowrap;">No updates</td>';
								}
								echo '</tr>';
							}
							echo '</table>';
						}
						else
							echo '<div align=center style="min-height:70px; min-width:100px;"><font align=center class="myFont"><br/>No tickets found.</font></div>';
					echo '</div>';
					
					echo '<div id="FR'.$member->emp_id.'" style="max-height:300px; overflow:scroll;">';
						if(count($frListMember)>0){
							echo '<table class="memberTicketsTable">';
							echo '<th>FR#</th>';
							echo '<th>Title</th>';
							echo '<th>Priority</th>';
							echo '<th>Last Update</th>';
							foreach($frListMember as $fr){
								echo '<tr>';
								echo '<td>'.anchor_popup('/nagger/showTicketReport/'.$fr->fulfillment_number, $fr->fulfillment_number).'</td>';
								echo '<td>'.$fr->title.'</td>';
								echo '<td>'.$fr->request_priority.'</td>';
								$update = $this->sitequota_model->getTicketUpdate($fr->fulfillment_number);
								if($update != null){
									echo '<td width="500px"><br/>'.$update->update_text.'<br/><br/>';
									echo '<font id="panelSmallFont"><i>Updated on: '.$update->date.' '.$update->time.'</i></font>';
									echo '</td>';
								}
								else{
									echo '<td style="white-space:nowrap;">No updates</td>';
								}
								echo '</tr>';
							}
							echo '</table>';
						}
						else
							echo '<div align=center style="min-height:70px; min-width:100px;"><font align=center class="myFont"><br/>No tickets found.</font></div>';
					echo '</div>';
					?>
					<script>
						hideTwisty('IM<?php echo $member->emp_id;?>');
						hideTwisty('FR<?php echo $member->emp_id;?>');
					</script>
					<?php
				
			//Display Profile Data////////////////////////////////////////////
			
			echo '</td>';
			if($i % $pagination == 0 && $i != 0){
				echo '</tr><tr>';
				
			}
			$i++;
		}
	}
	else{
		echo '<font class="myFont">No members found.</font>';
	}
	
	
?>	
</table>



</body>
</html>
