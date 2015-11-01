<html>
<head>

<link rel="stylesheet" href="/sitequota/styles/general.css" type="text/css" media="screen"></link>
<link rel="stylesheet" href="/sitequota/styles/fonts/stylesheet.css" type="text/css" media="screen"></link>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="/sitequota/styles/chartmaster/Chart.js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
function drawBar(name){
	var swt = document.getElementById(name+"Swt").value;
	swt = parseInt(swt);
	var cwt = document.getElementById(name+"Cwt").value;
	cwt = parseInt(cwt);
	
	var barChartData = {
			labels : ["SWT%","CWT%"],
			datasets : [
				{
					fillColor : "#0096d5",
					strokeColor : "rgba(220,220,220,1)",
					data : [0,swt,cwt]
				}
			],
		}

	new Chart(document.getElementById(name).getContext("2d")).Bar(barChartData);	
}
</script>


<h3 class="myH3"><b/>Ticket Analysis closed on <?php
	$monthArr = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	$monthName = $monthArr[$this->session->userdata('reportMonth')-1];
	echo $monthName.' ';
	echo $this->session->userdata('reportYear');
?></h3>
<div align=left>

<?php
	$monthList =  $this->report_model->getImReportMonths();
	if($monthList != null){
		$selectedMonth = $this->session->userdata('reportMonth'); 
		$selectedYear = $this->session->userdata('reportYear');  
		echo form_open($form);
		echo '<font class="myFont">Select Month:</font>';
		echo '<select name="reportDate" class="mySelect" onChange="this.form.submit()">';
		foreach($monthList as $row){
			if($row->month == $selectedMonth && $row->year == $selectedYear)
				echo '<option selected value="'.$row->month.'|'.$row->year.'">'.$row->monthname.' '.$row->year.'</option>';
			else
				echo '<option value="'.$row->month.'|'.$row->year.'">'.$row->monthname.' '.$row->year.'</option>';
		}
		echo '</select>';
		echo form_close();
	}
	else{
		echo 'No reports available.';
	}
?>
</div><br/>
<?php
		//Initialize Month and Year
		if($this->session->userdata('reportMonth') == null || $this->session->userdata('reportMonth') == ''){
			$month = date('m');
		}
		else{
			$month = $this->session->userdata('reportMonth');
		}
		
		if($this->session->userdata('reportYear') == null || $this->session->userdata('reportYear') == ''){
			$year = date('Y');
		}
		else{
			$year = $this->session->userdata('reportYear');
		}
		
		$daysLimit = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		
		echo '<input type=hidden id="daysLimit" value="'.$daysLimit.'"/>';
		echo '<input type=hidden id="month" value="'.$month.'/"/>';
		echo '<input type=hidden id="monthWord" value="'.date('F').'"/>';
		echo '<input type=hidden id="totalIm" value="'.count($this->sitequota_model->getImListQueue()).'"/>';
		echo '<input type=hidden id="totalFr" value="'.count($this->sitequota_model->getFrListQueue()).'"/>';
		for($i=1; $i<=$daysLimit; $i++){
			//IM Details
			$closed = $this->sitequota_model->getClosedIncidents($month, $i, $year);
			$swt = $this->sitequota_model->getSwtIncidents($month, $i, $year);
			$cwt = $this->sitequota_model->getCwtIncidents($month, $i, $year);
			//echo $closed.' | '.$swt.' | '.$cwt.'<br/>';
			echo '<input type=hidden id="imClosed'.$i.'" value="'.$closed.'"/>';
			echo '<input type=hidden id="imSwt'.$i.'" value="'.$swt.'"/>';
			echo '<input type=hidden id="imCwt'.$i.'" value="'.$cwt.'"/>';
			
			//FR Details
			$closed = $this->sitequota_model->getClosedFulfillment($month, $i, $year);
			$swt = $this->sitequota_model->getSwtFulfillment($month, $i, $year);
			$cwt = $this->sitequota_model->getCwtFulfillment($month, $i, $year);
			echo '<input type=hidden id="frClosed'.$i.'" value="'.$closed.'"/>';
			echo '<input type=hidden id="frSwt'.$i.'" value="'.$swt.'"/>';
			echo '<input type=hidden id="frCwt'.$i.'" value="'.$cwt.'"/>';
			
		}
		//fill in 0 for 31 if current month doesn't have 31st
		if($daysLimit == 30){
			echo '<input type=hidden id="imClosed31" value="0"/>';
			echo '<input type=hidden id="imSwt31" value="0"/>';
			echo '<input type=hidden id="imCwt31" value="0"/>';
			
			echo '<input type=hidden id="frClosed31" value="0"/>';
			echo '<input type=hidden id="frSwt31" value="0"/>';
			echo '<input type=hidden id="frCwt31" value="0"/>';
		}
		
		//fill in 29,30, 31 for February Case
		if($daysLimit == 28){
			echo '<input type=hidden id="imClosed29" value="0"/>';
			echo '<input type=hidden id="imSwt29" value="0"/>';
			echo '<input type=hidden id="imCwt29" value="0"/>';
			
			echo '<input type=hidden id="imClosed30" value="0"/>';
			echo '<input type=hidden id="imSwt30" value="0"/>';
			echo '<input type=hidden id="imCwt30" value="0"/>';
			
			echo '<input type=hidden id="imClosed31" value="0"/>';
			echo '<input type=hidden id="imSwt31" value="0"/>';
			echo '<input type=hidden id="imCwt31" value="0"/>';
			
			echo '<input type=hidden id="frClosed29" value="0"/>';
			echo '<input type=hidden id="frSwt29" value="0"/>';
			echo '<input type=hidden id="frCwt29" value="0"/>';
			
			echo '<input type=hidden id="frClosed30" value="0"/>';
			echo '<input type=hidden id="frSwt30" value="0"/>';
			echo '<input type=hidden id="frCwt30" value="0"/>';
			
			echo '<input type=hidden id="frClosed31" value="0"/>';
			echo '<input type=hidden id="frSwt31" value="0"/>';
			echo '<input type=hidden id="frCwt31" value="0"/>';
		}
		// for February Leap Year
		if($daysLimit == 29){
			echo '<input type=hidden id="imClosed30" value="0"/>';
			echo '<input type=hidden id="imSwt30" value="0"/>';
			echo '<input type=hidden id="imCwt30" value="0"/>';
			
			echo '<input type=hidden id="imClosed31" value="0"/>';
			echo '<input type=hidden id="imSwt31" value="0"/>';
			echo '<input type=hidden id="imCwt31" value="0"/>';
			
			echo '<input type=hidden id="frClosed30" value="0"/>';
			echo '<input type=hidden id="frSwt30" value="0"/>';
			echo '<input type=hidden id="frCwt30" value="0"/>';
			
			echo '<input type=hidden id="frClosed31" value="0"/>';
			echo '<input type=hidden id="frSwt31" value="0"/>';
			echo '<input type=hidden id="frCwt31" value="0"/>';
		}
		
		
		echo '<input type=hidden id="imSwtMonth" value="'.$this->sitequota_model->getSwtIncidentsMonth($month, $year).'">';
		echo '<input type=hidden id="imCwtMonth" value="'.$this->sitequota_model->getCwtIncidentsMonth($month, $year).'">';
		echo '<input type=hidden id="frSwtMonth" value="'.$this->sitequota_model->getSwtFulfillmentMonth($month, $year).'">';
		echo '<input type=hidden id="frCwtMonth" value="'.$this->sitequota_model->getCwtFulfillmentMonth($month, $year).'">';
		
	
		
		
		
	?>

<font class="myFont"><b/>Ticket Breakdown</font>
<table class="myTable">
<th>Impact</th>
<th>Total #</th>
<th># of SWT</th>
<th># of CWT</th>
<th>SWT Score</th>
<th>CWT Score</th>
	<?php 
		$totalTickets = 0;
		$totalSwtCount = 0;
		$totalCwtCount = 0;
		$totalSwtScore = 0.0;
		$totalCwtScore = 0.0;
	?>
<tr>
	<td>Critical</td>
	<td><?php 
			$imCritCount = $this->report_model->getClosedImPerImpact($month, $year, 'Critical');
			echo $imCritCount;
			$totalTickets+=$imCritCount;
		?>
	</td>
	<td><?php 
			$imCritSwtCount = $this->report_model->getSwtCountPerImpactIm($month, $year, 'Critical');
			echo $imCritSwtCount;
			$totalSwtCount+=$imCritSwtCount;
		?>
	</td>
	<td><?php 
			$imCritCwtCount = $this->report_model->getCwtCountPerImpactIm($month, $year, 'Critical');
			echo $imCritCwtCount;
			$totalCwtCount+=$imCritCwtCount;
		?>
	</td>
	<td><?php 
			if($imCritCount > 0)
				$imCritSwtScore = ($imCritSwtCount / $imCritCount) * 100;
			else
				$imCritSwtScore = 0;
			echo round($imCritSwtScore,2).'%';
			$totalSwtScore += $imCritSwtScore;
		?>
	</td>
	<td><?php 
			if($imCritCount > 0)
				$imCritCwtScore = ($imCritCwtCount / $imCritCount) * 100;
			else
				$imCritCwtScore = 0;
			echo round($imCritCwtScore,2).'%';
			$totalCwtScore += $imCritCwtScore;
		?>
	</td>
</tr>
<tr>
	<td>High</td>
	<td><?php 
			$imHighCount = $this->report_model->getClosedImPerImpact($month, $year, 'High');
			echo $imHighCount;
			$totalTickets+=$imHighCount;
		?>
	</td>
	<td><?php 
			$imHighSwtCount = $this->report_model->getSwtCountPerImpactIm($month, $year, 'High');
			echo $imHighSwtCount;
			$totalSwtCount+=$imHighSwtCount;
		?>
	</td>
	<td><?php 
			$imHighCwtCount = $this->report_model->getCwtCountPerImpactIm($month, $year, 'High');
			echo $imHighCwtCount;
			$totalCwtCount+=$imHighCwtCount;
		?>
	</td>
	<td><?php 
			if($imHighCount >0)
				$imHighSwtScore = ($imHighSwtCount / $imHighCount) * 100;
			else
				$imHighSwtScore = 0;
			echo round($imHighSwtScore,2).'%';
			$totalSwtScore += $imHighSwtScore;
		?>
	</td>
	<td><?php 
			if($imHighCount >0)
				$imHighCwtScore = ($imHighCwtCount / $imHighCount) * 100;
			else
				$imHighCwtScore = 0;
			echo round($imHighCwtScore,2).'%';
			$totalCwtScore += $imHighCwtScore;
		?>
	</td>
</tr>
<tr>
	<td>Average</td>
	<td><?php 
			$imAverageCount = $this->report_model->getClosedImPerImpact($month, $year, 'Average');
			echo $imAverageCount;
			$totalTickets+=$imAverageCount;
		?>
	</td>
	<td><?php 
			$imAverageSwtCount = $this->report_model->getSwtCountPerImpactIm($month, $year, 'Average');
			echo $imAverageSwtCount;
			$totalSwtCount+=$imAverageSwtCount;
		?>
	</td>
	<td><?php 
			$imAverageCwtCount = $this->report_model->getCwtCountPerImpactIm($month, $year, 'Average');
			echo $imAverageCwtCount;
			$totalCwtCount+=$imAverageCwtCount;
		?>
	</td>
	<td><?php 
			if($imAverageCount > 0)
				$imAverageSwtScore = ($imAverageSwtCount / $imAverageCount) * 100;
			else
				$imAverageSwtScore = 0;
			echo round($imAverageSwtScore,2).'%';
			$totalSwtScore += $imAverageSwtScore;
		?>
	</td>
	<td><?php 
			if($imAverageCount > 0)
				$imAverageCwtScore = ($imAverageCwtCount / $imAverageCount) * 100;
			else
				$imAverageCwtScore = 0;
			echo round($imAverageCwtScore,2).'%';
			$totalCwtScore += $imAverageCwtScore;
		?>
	</td>
</tr>
<tr>
	<td>Low</td>
	<td><?php 
			$imLowCount = $this->report_model->getClosedImPerImpact($month, $year, 'Low');
			echo $imLowCount;
			$totalTickets+=$imLowCount;
		?>
	</td>
	<td><?php 
			$imLowSwtCount = $this->report_model->getSwtCountPerImpactIm($month, $year, 'Low');
			echo $imLowSwtCount;
			$totalSwtCount+=$imLowSwtCount;
		?>
	</td>
	<td><?php 
			$imLowCwtCount = $this->report_model->getCwtCountPerImpactIm($month, $year, 'Low');
			echo $imLowCwtCount;
			$totalCwtCount+=$imLowCwtCount;
		?>
	</td>
	<td><?php 
			if($imLowCount >0)
				$imLowSwtScore = ($imLowSwtCount / $imLowCount) * 100;
			else
				$imLowSwtScore = 0;
			echo round($imLowSwtScore,2).'%';
			$totalSwtScore += $imLowSwtScore;
		?>
	</td>
	<td><?php 
			if($imLowCount >0)
				$imLowCwtScore = ($imLowCwtCount / $imLowCount) * 100;
			else
				$imLowCwtScore = 0;
			echo round($imLowCwtScore,2).'%';
			$totalCwtScore += $imLowCwtScore;
		?>
	</td>
</tr>
<tr>
	<td>Service (FR)</td>
	<td><?php 
			$frServiceCount = $this->report_model->getClosedFrPerRequestType($month, $year, 'SERVICE');
			echo $frServiceCount;
			$totalTickets+=$frServiceCount;	
		?>
	</td>
	<td><?php 
			$frServiceSwtCount = $this->report_model->getSwtCountPerRequestTypeFr($month, $year, 'SERVICE');
			echo $frServiceSwtCount;
			$totalSwtCount+=$frServiceSwtCount;	
		?>
	</td>
	<td><?php 
			$frServiceCwtCount = $this->report_model->getCwtCountPerRequestTypeFr($month, $year, 'SERVICE');
			echo $frServiceCwtCount;
			$totalCwtCount+=$frServiceCwtCount;	
		?>
	</td>
	<td><?php 
			if($frServiceCount>0)
				$frServiceSwtScore = ($frServiceSwtCount / $frServiceCount) * 100;
			else
				$frServiceSwtScore = 0;
			echo round($frServiceSwtScore,2).'%';
			$totalSwtScore += $frServiceSwtScore;
		?>
	</td>
	<td><?php 
			if($frServiceCount >0)
				$frServiceCwtScore = ($frServiceCwtCount / $frServiceCount) * 100;
			else
				$frServiceCwtScore = 0;
			echo round($frServiceCwtScore,2).'%';
			$totalCwtScore += $frServiceCwtScore;
		?>
	</td>
</tr>
<tr>
	<td>Information (FR)</td>
	<td><?php 
			$frInfoCount = $this->report_model->getClosedFrPerRequestType($month, $year, 'INFORMATION');
			echo $frInfoCount;
			$totalTickets+=$frInfoCount;
		?>
	</td>
	<td><?php 
			$frInfoSwtCount = $this->report_model->getSwtCountPerRequestTypeFr($month, $year, 'INFORMATION');
			echo $frInfoSwtCount;
			$totalSwtCount+=$frInfoSwtCount;	
		?>
	</td>
	<td><?php 
			$frInfoCwtCount = $this->report_model->getCwtCountPerRequestTypeFr($month, $year, 'INFORMATION');
			echo $frInfoCwtCount;
			$totalCwtCount+=$frInfoCwtCount;	
		?>
	</td>
	<td><?php 
			if($frInfoCount >0)
				$frInfoSwtScore = ($frInfoSwtCount / $frInfoCount) * 100;
			else
				$frInfoSwtScore=0;
			echo round($frInfoSwtScore,2).'%';
			$totalSwtScore += $frInfoSwtScore;
		?>
	</td>
	<td><?php 
			if($frInfoCount>0)
				$frInfoCwtScore = ($frInfoCwtCount / $frInfoCount) * 100;
			else
				$frInfoCwtScore = 0;
			echo round($frInfoCwtScore,2).'%';
			$totalCwtScore += $frInfoCwtScore;
		?>
	</td>
</tr>
<tr>
	<td>ADMIN (FR)</td>
	<td><?php 
			$frAdminCount = $this->report_model->getClosedFrPerRequestType($month, $year, 'ADMIN');
			echo $frAdminCount;
			$totalTickets+=$frAdminCount;
		?>
	</td>
	<td><?php 
			$frAdminSwtCount = $this->report_model->getSwtCountPerRequestTypeFr($month, $year, 'ADMIN');
			echo $frAdminSwtCount;
			$totalSwtCount+=$frAdminSwtCount;	
		?>
	</td>
	<td><?php 
			$frAdminCwtCount = $this->report_model->getCwtCountPerRequestTypeFr($month, $year, 'ADMIN');
			echo $frAdminCwtCount;
			$totalCwtCount+=$frAdminCwtCount;	
		?>
	</td>
	<td><?php 
			if($frAdminCount>0)
				$frAdminSwtScore = ($frAdminSwtCount / $frAdminCount) * 100;
			else
				$frAdminSwtScore = 0;
			echo round($frAdminSwtScore,2).'%';
			$totalSwtScore += $frAdminSwtScore;
		?>
	</td>
	<td><?php 
			if($frAdminCount>0)
				$frAdminCwtScore = ($frAdminCwtCount / $frAdminCount) * 100;
			else
				$frAdminCwtScore=0;
			echo round($frAdminCwtScore,2).'%';
			$totalCwtScore += $frAdminCwtScore;
		?>
	</td>
</tr>
<tr>
	<td>Total</td>
	<td><?php echo $totalTickets;?></td>
	<td><?php echo $totalSwtCount;?></td>
	<td><?php echo $totalCwtCount;?></td>
	<?php
		$totalSwtScore = round($totalSwtScore/7,2);
		if($totalSwtScore >= 95)
			echo '<td style="background:green;">'.$totalSwtScore.'%</td>';
		else if($totalSwtScore < 95 && $totalSwtScore >= 85)
			echo '<td style="background:yellow;">'.$totalSwtScore.'%</td>';
		else
			echo '<td style="background:red;"><font color=white>'.$totalSwtScore.'%</font></td>';
	?>
	<?php
		$totalCwtScore = round($totalCwtScore/7,2);
		if($totalCwtScore >= 95)
			echo '<td style="background:green;">'.$totalCwtScore.'%</td>';
		else if($totalCwtScore < 95 && $totalCwtScore >= 85)
			echo '<td style="background:yellow;">'.$totalCwtScore.'%</td>';
		else
			echo '<td style="background:red;"><font color=white>'.$totalCwtScore.'%</font></td>';
	?>
</tr>
</table>
<hr class="carved"/>

<h3 class="myH3"><b/>Daily Ticket Report</h3>
<font class="myFont"><i>
	Closed = Grey<br/>
	SWT = Light Blue<br/>
	CWT = Dark Blue <br/><br/>
</i></font>
<font id="panelSmallFont"><i>If you see Dark Blue only, it means SWT and CWT are equal for that day.</i></font><br/><br/>
<canvas  id="dailyreport" height="400" width=1300></canvas>

<hr class="carved"/>
<!-- CSS Codes for the NAV BAR -->
	
	<?php
		//Displays Google Charts Version
		echo '<div style="position:relative;left:-150px; width:1500px; height: 600px;" id="chart_div_im"></div><br/><hr class="carved"/><br/>';
		echo '<div style="position:relative;left:-150px; width:1500px; height: 600px;" id="chart_div_fr"></div>';
	?>
	
	<script>
	
	var lineChartData = {
		labels : [
		document.getElementById('month').value+'1', document.getElementById('month').value+'2',
		document.getElementById('month').value+'3', document.getElementById('month').value+'4',
		document.getElementById('month').value+'5', document.getElementById('month').value+'6',
		document.getElementById('month').value+'7', document.getElementById('month').value+'8',
		document.getElementById('month').value+'9', document.getElementById('month').value+'10',
		document.getElementById('month').value+'11', document.getElementById('month').value+'12',
		document.getElementById('month').value+'13', document.getElementById('month').value+'14',
		document.getElementById('month').value+'15', document.getElementById('month').value+'16',
		document.getElementById('month').value+'17', document.getElementById('month').value+'18',
		document.getElementById('month').value+'19', document.getElementById('month').value+'20',
		document.getElementById('month').value+'21', document.getElementById('month').value+'22',
		document.getElementById('month').value+'23', document.getElementById('month').value+'24',
		document.getElementById('month').value+'25', document.getElementById('month').value+'26',
		document.getElementById('month').value+'27', document.getElementById('month').value+'28',
		document.getElementById('month').value+'29', document.getElementById('month').value+'30',
		document.getElementById('month').value+'31'
		],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				data : [
				parseInt(document.getElementById("imClosed1").value), parseInt(document.getElementById("imClosed2").value),
				parseInt(document.getElementById("imClosed3").value), parseInt(document.getElementById("imClosed4").value),
				parseInt(document.getElementById("imClosed5").value), parseInt(document.getElementById("imClosed6").value),
				parseInt(document.getElementById("imClosed7").value), parseInt(document.getElementById("imClosed8").value),
				parseInt(document.getElementById("imClosed9").value), parseInt(document.getElementById("imClosed10").value),
				parseInt(document.getElementById("imClosed11").value), parseInt(document.getElementById("imClosed12").value),
				parseInt(document.getElementById("imClosed13").value), parseInt(document.getElementById("imClosed14").value),
				parseInt(document.getElementById("imClosed15").value), parseInt(document.getElementById("imClosed16").value),
				parseInt(document.getElementById("imClosed17").value), parseInt(document.getElementById("imClosed18").value),
				parseInt(document.getElementById("imClosed19").value), parseInt(document.getElementById("imClosed20").value),
				parseInt(document.getElementById("imClosed21").value), parseInt(document.getElementById("imClosed22").value),
				parseInt(document.getElementById("imClosed23").value), parseInt(document.getElementById("imClosed24").value),
				parseInt(document.getElementById("imClosed25").value), parseInt(document.getElementById("imClosed26").value),
				parseInt(document.getElementById("imClosed27").value), parseInt(document.getElementById("imClosed28").value),
				parseInt(document.getElementById("imClosed29").value), parseInt(document.getElementById("imClosed30").value),
				parseInt(document.getElementById("imClosed31").value)
				]
			},
			{
				fillColor : "#33b5e5",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				data : [
				parseInt(document.getElementById("imSwt1").value), parseInt(document.getElementById("imSwt2").value),
				parseInt(document.getElementById("imSwt3").value), parseInt(document.getElementById("imSwt4").value),
				parseInt(document.getElementById("imSwt5").value), parseInt(document.getElementById("imSwt6").value),
				parseInt(document.getElementById("imSwt7").value), parseInt(document.getElementById("imSwt8").value),
				parseInt(document.getElementById("imSwt9").value), parseInt(document.getElementById("imSwt10").value),
				parseInt(document.getElementById("imSwt11").value), parseInt(document.getElementById("imSwt12").value),
				parseInt(document.getElementById("imSwt13").value), parseInt(document.getElementById("imSwt14").value),
				parseInt(document.getElementById("imSwt15").value), parseInt(document.getElementById("imSwt16").value),
				parseInt(document.getElementById("imSwt17").value), parseInt(document.getElementById("imSwt18").value),
				parseInt(document.getElementById("imSwt19").value), parseInt(document.getElementById("imSwt20").value),
				parseInt(document.getElementById("imSwt21").value), parseInt(document.getElementById("imSwt22").value),
				parseInt(document.getElementById("imSwt23").value), parseInt(document.getElementById("imSwt24").value),
				parseInt(document.getElementById("imSwt25").value), parseInt(document.getElementById("imSwt26").value),
				parseInt(document.getElementById("imSwt27").value), parseInt(document.getElementById("imSwt28").value),
				parseInt(document.getElementById("imSwt29").value), parseInt(document.getElementById("imSwt30").value),
				parseInt(document.getElementById("imSwt31").value)
				]
			},
			{
				fillColor : "#0099cc",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				data : [
				parseInt(document.getElementById("imCwt1").value), parseInt(document.getElementById("imCwt2").value),
				parseInt(document.getElementById("imCwt3").value), parseInt(document.getElementById("imCwt4").value),
				parseInt(document.getElementById("imCwt5").value), parseInt(document.getElementById("imCwt6").value),
				parseInt(document.getElementById("imCwt7").value), parseInt(document.getElementById("imCwt8").value),
				parseInt(document.getElementById("imCwt9").value), parseInt(document.getElementById("imCwt10").value),
				parseInt(document.getElementById("imCwt11").value), parseInt(document.getElementById("imCwt12").value),
				parseInt(document.getElementById("imCwt13").value), parseInt(document.getElementById("imCwt14").value),
				parseInt(document.getElementById("imCwt15").value), parseInt(document.getElementById("imCwt16").value),
				parseInt(document.getElementById("imCwt17").value), parseInt(document.getElementById("imCwt18").value),
				parseInt(document.getElementById("imCwt19").value), parseInt(document.getElementById("imCwt20").value),
				parseInt(document.getElementById("imCwt21").value), parseInt(document.getElementById("imCwt22").value),
				parseInt(document.getElementById("imCwt23").value), parseInt(document.getElementById("imCwt24").value),
				parseInt(document.getElementById("imCwt25").value), parseInt(document.getElementById("imCwt26").value),
				parseInt(document.getElementById("imCwt27").value), parseInt(document.getElementById("imCwt28").value),
				parseInt(document.getElementById("imCwt29").value), parseInt(document.getElementById("imCwt30").value),
				parseInt(document.getElementById("imCwt31").value)
				]
			}
		]
	}
	new Chart(document.getElementById("dailyreport").getContext("2d")).Line(lineChartData);
	</script>
	
	
	 <script type="text/javascript">
		  google.load("visualization", "1", {packages:["corechart"]});
		  google.setOnLoadCallback(drawChart);
		  function drawChart() {
			
			var data = google.visualization.arrayToDataTable([
			  ['Day','Closed', 'SWT', 'CWT'],
				[document.getElementById('month').value+'1'  ,parseInt(document.getElementById("imClosed1").value), parseInt(document.getElementById("imSwt1").value), parseInt(document.getElementById("imCwt1").value)],
				
				[document.getElementById('month').value+'2',  parseInt(document.getElementById("imClosed2").value), parseInt(document.getElementById("imSwt2").value), parseInt(document.getElementById("imCwt2").value)],
				
				[document.getElementById('month').value+'3',  parseInt(document.getElementById("imClosed3").value), parseInt(document.getElementById("imSwt3").value), parseInt(document.getElementById("imCwt3").value)],
				
				[document.getElementById('month').value+'4',  parseInt(document.getElementById("imClosed4").value), parseInt(document.getElementById("imSwt4").value), parseInt(document.getElementById("imCwt4").value)],
				
				[document.getElementById('month').value+'5',  parseInt(document.getElementById("imClosed5").value), parseInt(document.getElementById("imSwt5").value), parseInt(document.getElementById("imCwt5").value)],
				
				[document.getElementById('month').value+'6',  parseInt(document.getElementById("imClosed6").value), parseInt(document.getElementById("imSwt6").value), parseInt(document.getElementById("imCwt6").value)],
				
				[document.getElementById('month').value+'7',  parseInt(document.getElementById("imClosed7").value), parseInt(document.getElementById("imSwt7").value), parseInt(document.getElementById("imCwt7").value)],
				
				[document.getElementById('month').value+'8',  parseInt(document.getElementById("imClosed8").value), parseInt(document.getElementById("imSwt8").value), parseInt(document.getElementById("imCwt8").value)],
				
				[document.getElementById('month').value+'9',  parseInt(document.getElementById("imClosed9").value), parseInt(document.getElementById("imSwt9").value), parseInt(document.getElementById("imCwt9").value)],
				
				[document.getElementById('month').value+'10',  parseInt(document.getElementById("imClosed10").value), parseInt(document.getElementById("imSwt10").value), parseInt(document.getElementById("imCwt10").value)],
				
				[document.getElementById('month').value+'11',  parseInt(document.getElementById("imClosed11").value), parseInt(document.getElementById("imSwt11").value), parseInt(document.getElementById("imCwt11").value)],
				
				[document.getElementById('month').value+'12',  parseInt(document.getElementById("imClosed12").value), parseInt(document.getElementById("imSwt12").value), parseInt(document.getElementById("imCwt12").value)],
				
				[document.getElementById('month').value+'13',  parseInt(document.getElementById("imClosed13").value), parseInt(document.getElementById("imSwt13").value), parseInt(document.getElementById("imCwt13").value)],
				
				[document.getElementById('month').value+'14',  parseInt(document.getElementById("imClosed14").value), parseInt(document.getElementById("imSwt14").value), parseInt(document.getElementById("imCwt14").value)],
				
				[document.getElementById('month').value+'15',  parseInt(document.getElementById("imClosed15").value), parseInt(document.getElementById("imSwt15").value), parseInt(document.getElementById("imCwt15").value)],
				
				[document.getElementById('month').value+'16',  parseInt(document.getElementById("imClosed16").value), parseInt(document.getElementById("imSwt16").value), parseInt(document.getElementById("imCwt16").value)],
				
				[document.getElementById('month').value+'17',  parseInt(document.getElementById("imClosed17").value), parseInt(document.getElementById("imSwt17").value), parseInt(document.getElementById("imCwt17").value)],
				
				[document.getElementById('month').value+'18',  parseInt(document.getElementById("imClosed18").value), parseInt(document.getElementById("imSwt18").value), parseInt(document.getElementById("imCwt18").value)],
				
				[document.getElementById('month').value+'19',  parseInt(document.getElementById("imClosed19").value), parseInt(document.getElementById("imSwt19").value), parseInt(document.getElementById("imCwt19").value)],
				
				[document.getElementById('month').value+'20',  parseInt(document.getElementById("imClosed20").value), parseInt(document.getElementById("imSwt20").value), parseInt(document.getElementById("imCwt20").value)],
				
				[document.getElementById('month').value+'21',  parseInt(document.getElementById("imClosed21").value), parseInt(document.getElementById("imSwt21").value), parseInt(document.getElementById("imCwt21").value)],
				
				[document.getElementById('month').value+'22',  parseInt(document.getElementById("imClosed22").value), parseInt(document.getElementById("imSwt22").value), parseInt(document.getElementById("imCwt22").value)],
				
				[document.getElementById('month').value+'23',  parseInt(document.getElementById("imClosed23").value), parseInt(document.getElementById("imSwt23").value), parseInt(document.getElementById("imCwt23").value)],
				
				[document.getElementById('month').value+'24',  parseInt(document.getElementById("imClosed24").value), parseInt(document.getElementById("imSwt24").value), parseInt(document.getElementById("imCwt24").value)],
				
				[document.getElementById('month').value+'25',  parseInt(document.getElementById("imClosed25").value), parseInt(document.getElementById("imSwt25").value), parseInt(document.getElementById("imCwt25").value)],
				
				[document.getElementById('month').value+'26',  parseInt(document.getElementById("imClosed26").value), parseInt(document.getElementById("imSwt26").value), parseInt(document.getElementById("imCwt26").value)],
				[document.getElementById('month').value+'27',  parseInt(document.getElementById("imClosed27").value), parseInt(document.getElementById("imSwt27").value), parseInt(document.getElementById("imCwt27").value)],
				
				[document.getElementById('month').value+'28',  parseInt(document.getElementById("imClosed28").value), parseInt(document.getElementById("imSwt28").value), parseInt(document.getElementById("imCwt28").value)],
				
				[document.getElementById('month').value+'29',  parseInt(document.getElementById("imClosed29").value), parseInt(document.getElementById("imSwt29").value), parseInt(document.getElementById("imCwt29").value)],
				
				[document.getElementById('month').value+'30',  parseInt(document.getElementById("imClosed30").value), parseInt(document.getElementById("imSwt30").value), parseInt(document.getElementById("imCwt30").value)],
				
				[document.getElementById('month').value+'31',  parseInt(document.getElementById("imClosed31").value), parseInt(document.getElementById("imSwt31").value), parseInt(document.getElementById("imCwt31").value)]
			]);
				
				
			var options = {
			  title: 'Bar Graph View',
			  hAxis: {
				 
				titleTextStyle: {color: 'black'},
				slantedText: false
				},
			  animation: {
				duration: 500000,
				easing: 'linear'
			  },
			};

			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_im'));
			chart.draw(data, options);
		  }
	</script>
	
	
	
</body>
</html>
