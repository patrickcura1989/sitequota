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


<!-- CSS Codes for the NAV BAR -->
	<?php
		if($this->session->userdata('reportMonth') == null)
			$month = date('m');
		else{
			$month = $this->session->userdata('reportMonth');
		}
		//$month = date('m',strtotime("-1 month"));
		$year = date('Y');
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
		
		
		echo '<h3 class="myH3">SWT/CWT Meter</h3>';
		echo '<div height=400px width=600px id="gauge"></div><hr class="carved">';
		
		
		echo '<div style="position:relative;left:-150px; width:1500px; height: 600px;" id="chart_div_im"></div><br/><hr class="carved"/><br/>';
		echo '<div style="position:relative;left:-150px; width:1500px; height: 600px;" id="chart_div_fr"></div>';
	?>
	
	<script type='text/javascript'>
      google.load('visualization', '1', {packages:['gauge']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['IM SWT', parseInt(document.getElementById("imSwtMonth").value)],
          ['IM CWT', parseInt(document.getElementById("imCwtMonth").value)],
		  ['FM SWT', parseInt(document.getElementById("frSwtMonth").value)],
          ['FM CWT', parseInt(document.getElementById("frCwtMonth").value)],
          
        ]);

        var options = {
		  width: 600, height: 180,
          redFrom: 0, redTo: 79,
		  greenFrom:95, greenTo:100,
          yellowFrom:80, yellowTo: 94,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('gauge'));
        chart.draw(data, options);
      }
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
			  title: 'Daily Incident SWT/CWT Report for '+document.getElementById('monthWord').value+' (Total:'+document.getElementById("totalIm").value+')',
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
	
	
	<script type="text/javascript">
		  google.load("visualization", "1", {packages:["corechart"]});
		  google.setOnLoadCallback(drawChart);
		  function drawChart() {
			
			var data = google.visualization.arrayToDataTable([
			  ['Day','Closed', 'SWT', 'CWT'],
				[document.getElementById('month').value+'1'  ,parseInt(document.getElementById("frClosed1").value), parseInt(document.getElementById("frSwt1").value), parseInt(document.getElementById("frCwt1").value)],
				
				[document.getElementById('month').value+'2',  parseInt(document.getElementById("frClosed2").value), parseInt(document.getElementById("frSwt2").value), parseInt(document.getElementById("frCwt2").value)],
				
				[document.getElementById('month').value+'3',  parseInt(document.getElementById("frClosed3").value), parseInt(document.getElementById("frSwt3").value), parseInt(document.getElementById("frCwt3").value)],
				
				[document.getElementById('month').value+'4',  parseInt(document.getElementById("frClosed4").value), parseInt(document.getElementById("frSwt4").value), parseInt(document.getElementById("frCwt4").value)],
				
				[document.getElementById('month').value+'5',  parseInt(document.getElementById("frClosed5").value), parseInt(document.getElementById("frSwt5").value), parseInt(document.getElementById("frCwt5").value)],
				
				[document.getElementById('month').value+'6',  parseInt(document.getElementById("frClosed6").value), parseInt(document.getElementById("frSwt6").value), parseInt(document.getElementById("frCwt6").value)],
				
				[document.getElementById('month').value+'7',  parseInt(document.getElementById("frClosed7").value), parseInt(document.getElementById("frSwt7").value), parseInt(document.getElementById("frCwt7").value)],
				
				[document.getElementById('month').value+'8',  parseInt(document.getElementById("frClosed8").value), parseInt(document.getElementById("frSwt8").value), parseInt(document.getElementById("frCwt8").value)],
				
				[document.getElementById('month').value+'9',  parseInt(document.getElementById("frClosed9").value), parseInt(document.getElementById("frSwt9").value), parseInt(document.getElementById("frCwt9").value)],
				
				[document.getElementById('month').value+'10',  parseInt(document.getElementById("frClosed10").value), parseInt(document.getElementById("frSwt10").value), parseInt(document.getElementById("frCwt10").value)],
				
				[document.getElementById('month').value+'11',  parseInt(document.getElementById("frClosed11").value), parseInt(document.getElementById("frSwt11").value), parseInt(document.getElementById("frCwt11").value)],
				
				[document.getElementById('month').value+'12',  parseInt(document.getElementById("frClosed12").value), parseInt(document.getElementById("frSwt12").value), parseInt(document.getElementById("frCwt12").value)],
				
				[document.getElementById('month').value+'13',  parseInt(document.getElementById("frClosed13").value), parseInt(document.getElementById("frSwt13").value), parseInt(document.getElementById("frCwt13").value)],
				
				[document.getElementById('month').value+'14',  parseInt(document.getElementById("frClosed14").value), parseInt(document.getElementById("frSwt14").value), parseInt(document.getElementById("frCwt14").value)],
				
				[document.getElementById('month').value+'15',  parseInt(document.getElementById("frClosed15").value), parseInt(document.getElementById("frSwt15").value), parseInt(document.getElementById("frCwt15").value)],
				
				[document.getElementById('month').value+'16',  parseInt(document.getElementById("frClosed16").value), parseInt(document.getElementById("frSwt16").value), parseInt(document.getElementById("frCwt16").value)],
				
				[document.getElementById('month').value+'17',  parseInt(document.getElementById("frClosed17").value), parseInt(document.getElementById("frSwt17").value), parseInt(document.getElementById("frCwt17").value)],
				
				[document.getElementById('month').value+'18',  parseInt(document.getElementById("frClosed18").value), parseInt(document.getElementById("frSwt18").value), parseInt(document.getElementById("frCwt18").value)],
				
				[document.getElementById('month').value+'19',  parseInt(document.getElementById("frClosed19").value), parseInt(document.getElementById("frSwt19").value), parseInt(document.getElementById("frCwt19").value)],
				
				[document.getElementById('month').value+'20',  parseInt(document.getElementById("frClosed20").value), parseInt(document.getElementById("frSwt20").value), parseInt(document.getElementById("frCwt20").value)],
				
				[document.getElementById('month').value+'21',  parseInt(document.getElementById("frClosed21").value), parseInt(document.getElementById("frSwt21").value), parseInt(document.getElementById("frCwt21").value)],
				
				[document.getElementById('month').value+'22',  parseInt(document.getElementById("frClosed22").value), parseInt(document.getElementById("frSwt22").value), parseInt(document.getElementById("frCwt22").value)],
				
				[document.getElementById('month').value+'23',  parseInt(document.getElementById("frClosed23").value), parseInt(document.getElementById("frSwt23").value), parseInt(document.getElementById("frCwt23").value)],
				
				[document.getElementById('month').value+'24',  parseInt(document.getElementById("frClosed24").value), parseInt(document.getElementById("frSwt24").value), parseInt(document.getElementById("frCwt24").value)],
				
				[document.getElementById('month').value+'25',  parseInt(document.getElementById("frClosed25").value), parseInt(document.getElementById("frSwt25").value), parseInt(document.getElementById("frCwt25").value)],
				
				[document.getElementById('month').value+'26',  parseInt(document.getElementById("frClosed26").value), parseInt(document.getElementById("frSwt26").value), parseInt(document.getElementById("frCwt26").value)],
				[document.getElementById('month').value+'27',  parseInt(document.getElementById("frClosed27").value), parseInt(document.getElementById("frSwt27").value), parseInt(document.getElementById("frCwt27").value)],
				
				[document.getElementById('month').value+'28',  parseInt(document.getElementById("frClosed28").value), parseInt(document.getElementById("frSwt28").value), parseInt(document.getElementById("frCwt28").value)],
				
				[document.getElementById('month').value+'29',  parseInt(document.getElementById("frClosed29").value), parseInt(document.getElementById("frSwt29").value), parseInt(document.getElementById("frCwt29").value)],
				
				[document.getElementById('month').value+'30',  parseInt(document.getElementById("frClosed30").value), parseInt(document.getElementById("frSwt30").value), parseInt(document.getElementById("frCwt30").value)],
				
				[document.getElementById('month').value+'31',  parseInt(document.getElementById("frClosed31").value), parseInt(document.getElementById("frSwt31").value), parseInt(document.getElementById("frCwt31").value)]
			]);
				
				
			var options = {
			  title: 'Daily Fulfillment SWT/CWT Report for '+document.getElementById('monthWord').value+' (Total:'+document.getElementById("totalFr").value+')',
			  hAxis: {
				 
				titleTextStyle: {color: 'black'},
				slantedText: false
				},
			  animation: {
				duration: 500000,
				easing: 'linear'
			  },
			};

			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_fr'));
			chart.draw(data, options);
		  }
	</script>
	
</body>
</html>
