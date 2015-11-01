<html>
<head>


<style>
.myH3{
   font: 18px/27px 'RobotoLight', Arial, sans-serif;
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
<h3 class="myH3">Updating <?php echo $ticket;?></h3><br/>
<form method="post" action="<?php echo $form;?>">
	<?php
		if(count($updateList) >0){
			echo '<table class="myTable">';
			echo '<th>Update</th>';
			echo '<th>Date</th>';
			echo '<th>Time</th>';
			echo '<th>Update By</th>';
			foreach($updateList as $row){
				echo '<tr>';
				echo '<td>'.$row->update_text.'</td>';
				echo '<td>'.$row->date.'</td>';
				echo '<td>'.$row->time.'</td>';
				echo '<td>'.$row->updated_by.'</td>';
				echo '</tr>';
			}	
			echo '</table>';
		}
		else{
			echo '<font id="panelSmallFont">No updates yet.</font>';
		}
	?>
	<br/>
	<div align=center>
	<font id="panelSmallFont"><i/>
		Tip: Use shift tags for better visibility in the mails.<br/>
		Ex: [ASIA 1/9] This is my update.<br/>
	</font>
	</div>
<table class="myTable">
	<tr>
		<td>Add your update:<br/><i>(Limit of 1000 characters)</i><br/><br/>
		
		<font color=red class="myFont"> <?php echo validation_errors(); ?></font></td>
		<td><textarea name="updateText" rows="6" cols="50"></textarea></td>
	</tr>
</table>
<br/>
</div>
<input type=hidden name="ticket" value="<?php echo $ticket;?>"/>
<div align=center>
<input type=submit value="Update" class="myButton"/>
<?php echo anchor('/nagger/showMyTickets/Array','Cancel',array("class"=>"myButton"));?>
</div>

</form>
</body>
</html>
