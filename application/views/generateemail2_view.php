<html>
<head>
<style>
.myH3{
   font: 19px/20px 'RobotoLight', Arial, sans-serif;
}

.myFont{
	font: 18px/27px 'RobotoLight', Arial, sans-serif;
}


.emailTable{
	width:100%;
	border               : 1px solid #CCC;
	border-collapse      : collapse;
	background            : #EFECE5;
    color                 : #666;
	font				: 15px 'RobotoLight';
	border-right		:1px solid #CCC; 
	border-bottom		:1px solid #CCC;
	border-left			:1px solid #CCC; 
	border-top			:1px solid #CCC;
	
	
}

.emailTable th{
	border-right		:1px solid #CCC; 
	border-bottom		:1px solid #CCC;
	border-left			:1px solid #CCC; 
	border-top			:1px solid #CCC;
}

.emailTable td{
	padding-top			:5px;
	padding-bottom		:5px;
	padding-right		:3px;
	padding-left		:3px;
}

.ticketLegend{
	border               : 1px solid #CCC;
	border-collapse      : collapse;
	
	background            : #EFECE5;
    
	
	color                 : #666;
	
}
.ticketLegend td{
	padding             :10px 10px 10px 10px;
	font				: 15px 'RobotoLight';
	border-right		:1px solid #CCC; 
	border-bottom		:1px solid #CCC;
	border-left		:1px solid #CCC; 
	border-top		:1px solid #CCC;
	
}

.emailTableMainBody{
	border               : 1px solid #CCC;
	border-collapse      : collapse;
	
	/*background            : #EFECE5;*/
    color                 : #666;
	
	
}
.emailTableMainBody td{
	
	font				: 15px 'RobotoLight';
	border-right		:1px solid #CCC; 
	border-bottom		:1px solid #CCC;
	border-left		:1px solid #CCC; 
	border-top		:1px solid #CCC;
	
}
</style>
<style>
.myH3{
   font: 18px/27px 'RobotoLight-Bold', Arial, sans-serif;
}
.myH3Bigger{
   font: 25px 'RobotoLight-Bold', Arial, sans-serif;
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
<img src="/sitequota/styles/img/handover_icon.png" width="100" height="100"/>
<h3 class="myH3Bigger">Handover</h3>
</div>
<hr class="carved"/>
<div align=center>
<table cellpadding="15px">
<tr>
	<td align=center>
		<?php
		echo anchor('nagger/showHandover/Array',
			'<img src="/sitequota/styles/img/update_icon.png" width="50" height="50"/>');
		?>
		<br/><br/>
		<font class="myFont"><u/>Step 1. Update Tickets</font>
		
	</td>
	<td align=center>
		<img src="/sitequota/styles/img/forward_icon.png" width="50" height="30"/>
	</td>
	<td align=center>
		<?php
		echo anchor('/nagger/generateEmail',
			'<img src="/sitequota/styles/img/generateemail_icon.png" width="60" height="50"/>');
		?>
		<br/><br/>
		<font  class="myH3"><u/>Step 2. Generate Email</font>
	</td>
	<!--
	<td>
		<img src="/sitequota/styles/img/forward_icon.png" width="50" height="30"/>
	</td>
	<form method="post" action="<?php //echo $form;?>">
	<td align=center>
		<img src="/sitequota/styles/img/email_icon.png" width="50" height="50"/><br/><br/>
		<font class="myFont">3. <input type=submit value="Send Email" class="myButton"/></font>
	</td>
	-->
</tr>
</table>
</div>
<hr class="carved"/>




<div align=center>
<font class="myFont">An email has been sent to <?php echo $this->session->userdata('email');?>.</font><br/>
<font class="myFont">You can now edit the <b>Ticket Handover Summary</b> to finalize before sending to your <b>PDL</b>.</font>
</div>

</body>
</html>
