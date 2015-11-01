<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<script src="/sitequota/styles/tabcontent/tabcontent.js" type="text/javascript"></script>
<link href="/sitequota/styles/tabcontent/template4/tabcontent.css" rel="stylesheet" type="text/css" />

<!-- CSS FILE -->
<style>

input[type=text] {
	border:none;
	background-color:transparent;
   
}

.btn {
  -webkit-border-radius: 4;
  -moz-border-radius: 4;
  border-radius: 4px;
  font-family: Arial;
  color: #ffffff;
  font-size: 12px;
  background: #33b5e5;
  padding: 8px 16px 8px 16px;
  text-decoration: none;
  border: none;
    outline: none;
}

.btn:hover {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  
  text-decoration: none;
}

.ui-widget {
    font-family: Hp Simplified;
    font-size: 14px;
	 
	
}

.ui-widget-content {
    background: white;
    border: 1px solid#33b5e5;
   
	color: #666666;
	min-width:380px;
}


.ui-dialog .ui-dialog-content {
    background: none repeat scroll 0 0 transparent;
    border: 0 none;
    overflow: auto;
    position: relative;
    padding: 0 !important;
}

.ui-widget-header {
    background:#33b5e5;
    border: 0;
    color: white;
    font-weight: bold;
}

.ui-dialog .ui-dialog-titlebar {
    padding: 0.1em .5em;
    position: relative;
        font-size: 14px;
}

</style>

<!-- ADD SLM -->
<script>
  $(function() {
    $( "#dialog_slm_add" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#opener_slm_add" ).click(function() {
      $( "#dialog_slm_add" ).dialog( "open" );
    });
  });
  </script>

<!-- ADD XOM -->
<script>
  $(function() {
    $( "#dialog_xom_add" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#opener_xom_add" ).click(function() {
      $( "#dialog_xom_add" ).dialog( "open" );
    });
  });
  </script>


</head>
<body>
<div>
<!-- ADD SLM Dialog box -->
				<div id="dialog_slm_add" title="Fill out fields">
				  <p> 
					<form action='/sitequota/index.php/aiw/insertSlm' method='post'>
						<input type="hidden" name="id" value="<?php echo $id;?>">
						<center>
							<table>
							
								<tr><td>SLM name:</td><td><input type="textarea" name="slm"></td></tr><br>
								<tr><td>E-mail: </td><td><input type="textarea" name="email"></td></tr>
							
							</table>
						<input type="submit" value="submit" class="btn">
					</form>
					</center>
				  </p>
				</div>
				
<!-- ADD XOM Dialog box -->
				<div id="dialog_xom_add" title="Fill out fields">
				  <p> 
					<form action='/sitequota/index.php/aiw/insertXom' method='post'>
						<input type="hidden" name="id" value="<?php echo $id;?>">
						<center>
							<table>
							
								<tr><td>XOM name:</td><td><input type="textarea" name="xom"></td></tr><br>
								<tr><td>E-mail: </td><td><input type="textarea" name="email"></td></tr>
							
							</table>
						<input type="submit" value="submit" class="btn">
					</form>
					</center>
				  </p>
				</div>				
				
				
				
				
				
				

<!-- First Div -->
	<div style="float:left;width:33%">
		<form action='/sitequota/index.php/aiw/editApp' method='post'>
			<table class="myTable">
				<h3 class="myH3">Application Information: </h3>
					
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<tr><td>Application Name: </td><td><input type="text" name="name" value="<?php echo $appInfo->app_name ?>"></td></tr>
					<tr><td>Description: </td><td><input type="text" name="des" value="<?php echo $appInfo->description ?>"></td></tr>
					<tr><td>Logo URL: </td><td><input type="text" name="logo" value="<?php echo $appInfo->logo_url ?>"></td></tr>
					<tr><td>SDDE URL: </td><td><input type="text" name="sdde" value="<?php echo $appInfo->sdde_url ?>"></td></tr>
			</table>		
					<input type="submit" class="btn" value="save">
			
			
		</form>	
	</div>

<!-- Second div -->
	<div style="float:right;width:33%">
		
			<table class="myTable">
				<h3 class="myH3">HP SLM Information: </h3>
					
					<input type="hidden" name="id" value="<?php echo $id;?>">
				
					<?php 
					
					if($appSlmList != null){
						echo "<table class='myTable'>";
						echo "<th></th>";
						echo "<th>SLM name</th>";
						echo "<th>Email</th>";
						echo "<th></th>";
						
						foreach($appSlmList as $row){
						
						echo "<tr><td>";
					
						echo "<form action='/sitequota/index.php/aiw/deleteSlm' method='post'>";
						echo "<input type='hidden' name='id' value='".$row->id."'>";
						echo "<input type='hidden' name='id_page' value='".$id."'>";
						echo "<input type='image' src='/sitequota/styles/img/hideButton.png' width=17 height=17 onclick='return confirm(\"Are you sure you want to delete this item?\")')'>";
						echo "</form>";
						
						
						
						echo "<form action='/sitequota/index.php/aiw/editSlm' method='post'>";
						echo "<input type='hidden' name='id_page' value='".$id."'>";
						echo "<input type='hidden' name='id' value='".$row->id."'>";
						echo "</td><td>";
						echo "<input type='text' name='slm_name' value='".$row->slm_name."'>";
						echo "</td><td>";
						echo "<input type='text' name='email' value='".$row->email."'>";
						echo "</td></td>";
						echo "<td><input type='submit' value='Save' class='btn'></form>";
						
						}
				
					}
					
					else
					echo "<font class='myFont'>No HP SLM Configured</font></br>";
					?>
					 
				
				</table>
					
									
					<button id="opener_slm_add" class="btn">Add</button>
			
			
		
	</div>
	
<!-- Third div -->
	<div style="float:right;width:33%">
		
			<table class="myTable">
				<h3 class="myH3">P&G XOM Information: </h3>
					
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<?php 
					
					if($appXomList != null){
						echo "<table class='myTable'>";
						echo "<th></th>";
						echo "<th>XOM name</th>";
						echo "<th>Email</th>";
						echo "<th></th>";
						foreach($appXomList as $row){
						
						echo "<tr><td>";
					
						echo "<form action='/sitequota/index.php/aiw/deleteXom' method='post'>";
						echo "<input type='hidden' name='id' value='".$row->id."'>";
						echo "<input type='hidden' name='id_page' value='".$id."'>";
						echo "<input type='image' src='/sitequota/hideButton.png' width=17 height=17 onclick='return confirm(\"Are you sure you want to delete this item?\")')'>";
						echo "</form>";
						
						
						echo "<form action='/sitequota/index.php/aiw/editXom' method='post'>";
						echo "<input type='hidden' name='id_page' value='".$id."'>";
						echo "<input type='hidden' name='id' value='".$row->id."'>";
						echo "</td><td>";
						echo "<input type='text' name='xom_name' value='".$row->xOM_name."'>";
						echo "</td><td>";
						echo "<input type='text' name='email' value='".$row->email."'>";
						echo "</td></td>";
						echo "<td><input type='submit' value='Save' class='btn'></form>";
						
						}
		
					}
					
					else
					echo "<font class='myFont'>No P&G XOM Configured</font></br>";
					?>

				</table>		
					<button id="opener_xom_add" class="btn">Add</button>
			
			
		
	</div>
	</div>
	
		<div style="float:left;width:100%">
			<center>
			
			<hr class=curved>
			<h3 class="myH3">To Map Services: 
			<a href='/appmapping/'><img src='/sitequota/map.png' width=17 height=17/></a>
			<a href='/appmapping/'>AppMapper</a><br></h3>	
			
			</center>
		</div>
</body>
</html>