<html>
<head>
<script src="/sitequota/styles/tabcontent/tabcontent.js" type="text/javascript"></script>
<link href="/sitequota/styles/tabcontent/template4/tabcontent.css" rel="stylesheet" type="text/css" />
<style>
	a, u {
    text-decoration: none;
}
</style>
</head>

<body>
	
	<?php
		if($appList != null){
			echo '<div align=center>';
			echo '<table cellpadding=20px cellspacing=0px>';
			$i = 0;
			foreach($appList as $row){
				if($i == 0){
					echo '<tr>';
					$i++;
				}
				echo '<td><img style="position:relative; top:10px;" width=30px; height=30px; src="/sitequota/styles/app_icon/'.$row->logo_url.'"/>&nbsp&nbsp';
				echo '<font class="myFont">'.anchor_popup('/aiw/showAppInfo/'.$row->id,$row->app_name).'</td>';
				
				if($i % 6 == 0 && $i != 0){
					echo '</tr><tr>';
					
				}
				$i++;
			}
			
			echo '</table>';
			echo '</div>';
		}
	?>
</body>
</html>