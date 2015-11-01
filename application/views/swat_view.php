<html>
<head>

<style>
.wrap {
width: 100%;
}

.floatleft, .floatright {
    float:left;
    width: 40%;
    height: 400px;
}

.floatright {
    width: 60%;
}
</style>

<script>

window.setInterval("reloadIFrame();", 15000);

function reloadIFrame() {
 document.frames["smtracker"].location.reload();
}

</script>

</head>

<body>
<div align=center>
	<font style="font:12px 'Tahoma', 'Bitstream Vera Sans', Verdana, Helvetica, sans-serif;">
		<i>This page reloads every 15 seconds.</i>
	</font>
</div>
<div align=center>
<iframe border=0 align=center name="smtracker" width="700px" height="200px" src="http://16.188.100.58/sitequota/index.php/queueloader/showSmTracker"/>
</div>


<iframe align=center height="100%" width="100%" src="http://bac.pg.com/topaz/topview.do" />

<!--<iframe align=center  height="300px" width="1000px" src="http://bac.pg.com/topaz/dash/view360Hierarchy.do"/>-->

</body>
</html>