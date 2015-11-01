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
<div align=center><img src="/sitequota/styles/img/archive.png" width=60 height=60/></div>


		
	
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

<a href="../nagger/downloadTeamIncidentsArchive"><img src="/sitequota/styles/img/download_icon.png" width=40 height=40/></a>
<br/>
<font id="panelSmallFont">Export to Excel</font>

</div>
<br/>
<ul class="tabs" persist="true">
	<li><a href="#" rel="inscope">In Scope</a></li>
	<li><a href="#" rel="outofscope">Out Of Scope</a></li>
	
</ul>

<div class="tabcontents">
<div id="inscope" class="tabcontent" align="left">
<?php
	if(count($imArr)>0){
	echo '<h3 class="myH3">IM Total Count (In Scope): '.count($imArr).'</h3>';
	echo '<hr class="carved"/>';
	echo '<table class="myTable">';
	echo '<th>IM#</th>';
	echo '<th>Title</th>';
	echo '<th>Status</th>';
	echo '<th>SLA%</th>';
	echo '<th>Priority</th>';
	foreach($imArr as $row){
		echo '<tr>';
		echo '<td>'.anchor_popup('nagger/showTicketReport/'.$row->incident_number, $row->incident_number).'</td>';
		echo '<td width="50%">'.$row->title.'</td>';
		if($row->current_status == 'Closed')
			echo '<td width="10%"><div style="background-color:green;" align=center><font color="white"/>'.$row->current_status.'</div></td>';
		else
			echo '<td width="10%">'.$row->current_status.'</td>';
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
		
		echo '<td>'.$row->priority.'</td>';
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
	if(count($imArrOutOfScope) > 0){
	echo '<h3 class="myH3">IM Total Count (Out of Scope): '.count($imArrOutOfScope).'</h3>';
	echo '<hr class="carved"/>';
	echo '<table class="myTable">';
	echo '<th>IM#</th>';
	echo '<th>Title</th>';
	echo '<th>Status</th>';
	echo '<th>SLA%</th>';
	echo '<th>Priority</th>';
	
	foreach($imArrOutOfScope as $row){
		echo '<tr>';
		echo '<td>'.anchor_popup('nagger/showTicketReport/'.$row->incident_number, $row->incident_number).'</td>';
		echo '<td width="50%">'.$row->title.'</td>';
		if($row->current_status == 'Closed')
			echo '<td width="10%"><div style="background-color:green;" align=center><font color="white"/>'.$row->current_status.'</div></td>';
		else
			echo '<td width="10%">'.$row->current_status.'</td>';
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
		
		echo '<td>'.$row->priority.'</td>';
		
		echo '</tr>';
	}
	echo '</table>';
	}
	else{
		echo '<font id="panelSmallFont">No data found.</font>';
	}
?>

</div>
</body>
</html>