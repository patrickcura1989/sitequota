<html>
<head>
<link href="/sitequota/styles/tabcontent/template4/tabcontent.css" rel="stylesheet" type="text/css" />
<script src="/sitequota/styles/tabcontent/tabcontent.js" type="text/javascript"></script>
<style>
#panelSmallFont{
	font: 15px 'RobotoLight', Arial, sans-serif;
}
.myH3Bigger{
   font: 25px 'RobotoLight-Bold', Arial, sans-serif;
}
</style>
</head>
<body>
<div align=center><h3 class="myH3Bigger">Archive</h3></div>
<div align=center><img src="/sitequota/styles/img/archive.png" width=50 height=50/></div>
<hr class='carved'/>
<div style="float:left;">
	<table>
	<tr>
	<td><img src="/sitequota/styles/img/search.png" height=20px width=20px/>
	</td>
	<td>
		<!--Script initialisations are in template_main-->
	<input type="text" name="searchTextArchive" id="searchTextArchive" class="searchTextArchive" placeholder="Search for all tickets via number or title" style="height:30px;" size=60px/>
	</td>
	</tr>
	</table>
</div>
<div align=right>

<a href="../nagger/downloadTeamFulfillmentsArchive"><img src="/sitequota/styles/img/download_icon.png" width=40 height=40/></a>
<br/>
<font id="panelSmallFont">Export to Excel</font>

</div>
<br/>
<ul class="tabs" persist="true">
	<li><a href="#" rel="inscope">In Scope</a></li>
	<li><a href="#" rel="outofscope">Out Of Scope</a></li>
	
</ul>
<div class="tabcontents" >
<div id="inscope" class="tabcontent" align="left">
<?php
	if(count($frArr)>0){
	echo '<h3 class="myH3">FR Total Count: '.count($frArr).'</h3>';
	echo '<hr class="carved"/>';
	echo '<table class="myTable">';
				echo '<th>FR#</th>';
				echo '<th>Title</th>';
				echo '<th>Status</th>';
				echo '<th>SLA%</th>';
				echo '<th>Priority</th>';
				foreach($frArr as $row){
					echo '<tr>';
					echo '<td>'.anchor_popup('nagger/showTicketReport/'.$row->fulfillment_number, $row->fulfillment_number).'</td>';
					echo '<td width="30%">'.$row->title.'</td>';
					
					if($row->status == 'Closed')
						echo '<td><div style="background-color:green;" align=center><font color="white"/>'.$row->status.'</div></td>';
					else
						echo '<td><div align=center>'.$row->status.'</div></td>';
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
					
					
					echo '<td>'.$row->request_priority.'</td>';
					echo '</tr>';
				}
				echo '</table>';
	}
	else{
		echo '<font id="panelSmallFont">No data found.</font>';
	}

?>
</div>

<div id="outofscope" class="tabcontent" align="left">
<?php
		if(count($frArrOutOfScope)>0){
		echo '<h3 class="myH3">FR Total Count (Out Of Scope): '.count($frArrOutOfScope).'</h3>';
		echo '<hr class="carved"/>';
		echo '<table class="myTable">';
				echo '<th>FR#</th>';
				echo '<th>Title</th>';
				echo '<th>Status</th>';
				echo '<th>SLA%</th>';
				echo '<th>Priority</th>';
				foreach($frArrOutOfScope as $row){
					echo '<tr>';
					echo '<td>'.anchor_popup('nagger/showTicketReport/'.$row->fulfillment_number, $row->fulfillment_number).'</td>';
					echo '<td width="30%">'.$row->title.'</td>';
					
					if($row->status == 'Closed')
						echo '<td><div style="background-color:green;" align=center><font color="white"/>'.$row->status.'</div></td>';
					else
						echo '<td><div align=center>'.$row->status.'</div></td>';
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
					
					echo '<td>'.$row->request_priority.'</td>';
					
					echo '</tr>';
				}
				echo '</table>';
		}
		else{
			echo '<font id="panelSmallFont">No data found.</font>';
		}

?>
</div>

</div>
</body>
</html>