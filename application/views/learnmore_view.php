<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="icon" type="image/png" href="/sitequota/styles/img/logo/browser_icon.png">
    <title>Nagger - Learn More</title>

    <!-- Bootstrap core CSS -->
    <link href="/sitequota/styles/bootstrap-3.1.1/dist/css/bootstrap.min.css" rel="stylesheet"/>
	
	<link href="/sitequota/styles/fonts/stylesheet.css" rel="stylesheet"/>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="/sitequota/styles/bootstrap-3.1.1/docs/examples/carousel/carousel.css" rel="stylesheet">
  </head>
<!-- NAVBAR
================================================== -->
  <body style="font-family:'RobotoLight';">
  
  <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
		<li data-target="#myCarousel" data-slide-to="3"></li>
		<li data-target="#myCarousel" data-slide-to="4"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          
          <div class="container">
            <div class="carousel-caption">
              <h1>NAGGER</h1><br/><br/><br/>
			  
              <p>Made for HP Operations <br/>by <a style="color:white;" href="/webfastlabs" target="_blank">WebFAST Labs</a></p><br/><br/>
              
            </div>
          </div>
        </div>
		<div class="item">
          <div class="container">
            <div class="carousel-caption">
              <h1>Centralized Master List</h1><br/><br/><br/>
			  <p>Nagger automatically collects all tickets in your SM queue and tracks it wherever it goes until closed.</p>
              <br/><br/><br/>
            </div>
          </div>
        </div>
		<div class="item">
          <div class="container">
            <div class="carousel-caption">
              <h1>Real-time. Synchronized.</h1><br/><br/><br/><br/><br/>
			  <p>Nagger synchronizes all your tickets with Service Manager on the most optimal intervals as possible.</p>
              
            </div>
          </div>
        </div>
        <div class="item">
          <div class="container">
            <div class="carousel-caption">
              <h1>Community</h1><br/><br/>
              <p>We are rolling out to more and more teams!<br/>We have <?php echo $this->sitequota_model->getTeamCount();?> teams, and a total of <?php echo $this->sitequota_model->getActiveUserCount();?> users.
			  <br/><br/><br/>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="container">
            <div class="carousel-caption">
              <h1>Want to Join?</h1><br/><br/>
              <p>Simply send the requirements to adrian-lester.tan@hp.com.
			  <br/><br/>
			  <div align=left>
			  <font size=3px>Requirements:<br/>
			  <ul>
			  <li>Team Name and members (Employee ID only)</li>
			  <li>Team Members(Employee ID only) and IM SPOCS/Shift Leads</li>
			  <li>Team's SM Queue(s)</li>
			  <li>Perks (not required): Application-Service-CI mapping for Application-level reporting.</li>
			  </font>
			  </ul>
			  </div>
			  <br/>
			  </p>
				
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->



    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
       
         <div align=center class="col-lg-4"><!--
          <img src="/sitequota/styles/img/learnmore/mission.png" width=50 height=70/>
          <h2>Mission</h2>
          <p></p>
          -->
        </div>
		 <div align=center class="col-lg-4">
		 <table>
		<tr>
			<td width=100px valign=top><img src="/sitequota/styles/img/hp_icon.png" width=70 height=70/></td>
		<td width=250px>
          
		  <form method="post" action="<?php echo $form;?>" class="login-form">
          <table align=center>
			<tr>
				<td><input type=text name="email" style="font-size:16px;font-family:'RobotoLight';" placeholder="HP Email">
				<br/><br/>
				<input type=password name="password" style="font-size:16px;font-family:'RobotoLight';"  placeholder="HP Password">
				</td>
				
			</tr>
			
		  </table><br/>
		  </td>
		  
		  <td valign=top><br/>
			<input type=submit class="btn btn-lg btn-primary" style="font-size:16px;" value="Sign In"  role="button"/>
          </form>
		  </td>
		  </tr>
		  </table>
		 
        </div><!-- /.col-lg-4 -->
		<div align=center class="col-lg-4">
			<!--
          <img src="/sitequota/styles/img/learnmore/vision.png" width=50 height=70/>
          <h2>Vision</h2>
          <p></p>
          -->
        </div>
		 </div><!-- /.col-lg-4 -->
         
      </div><!-- /.row -->


      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
           <h2 class="featurette-heading">Snapshot</h2><br/>
          <p class="lead">
			<ul style="font-size:20px;">
				<li>Real-time analysis.</li>
				<li>Display all non-closed tickets.</li>
				<li>Promotes end-to-end ownership of tickets (esp. for L2).</li>
				<li>Visually appealing. SLA graphs.</li>
				<li>Mark Team Priority Tickets.</li>
				<li>Ticket Breakdown.</li>
				<li>SWT/CWT progress for the month.</li>
			</ul>
		  </p>
        </div>
        <div class="col-md-5">
         <img src="/sitequota/styles/img/learnmore/snapshot.png" width=500 height=500/>
        </div>
      </div>

      <hr class="featurette-divider">
	<div class="row featurette">
		<div class="col-md-5">
         &nbsp&nbsp&nbsp&nbsp <img src="/sitequota/styles/img/learnmore/ticketdetails.png" width=350 height=400/>
        </div>
        <div class="col-md-7">
         <h2 class="featurette-heading"> Ticket Details. More stuff.</h2><br/>
          <p class="lead">
			<ul style="font-size:20px;">
				<li>See all ticket details page. WYSIWYG on SM Tracker.</li>
				<li>Mark tickets as In/Out of Scope</li>
				<li>Ticket Bounces. See how much a ticket stayed in a queue.</li>
			</ul>
		  </p>
        </div>
        
      </div>
	   <hr class="featurette-divider">
	   <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Collaborate</h2><br/>
          <p class="lead">
			<ul style="font-size:20px;">
				<li>Assign Tickets to your members accordingly.</li>
				<li>Notify the assignee.</li>
				<li>Access your tickets in My Tickets page. Update them!</li>
			</ul>
		  </p>
        </div>
        <div class="col-md-5">
          <img src="/sitequota/styles/img/learnmore/collaborate.png" width=400 height=400/>
        </div>
      </div>
	  
	  <hr class="featurette-divider">
	  
	   <div class="row featurette">
	    <div class="col-md-5">
          <img src="/sitequota/styles/img/learnmore/myteam.png" width=400 height=400/>
        </div>
        <div class="col-md-7">
          <h2 class="featurette-heading">My Team.</h2><br/>
          <p class="lead">
			<ul style="font-size:20px;">
				<li>Assess your Duty Managers. Balance out.</li>
				<li>Notify the assignee.</li>
				
			</ul>
		  </p>
        </div>
       
      </div>
	  
	  <hr class="featurette-divider">
	  
	  <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Archive</h2><br/>
          <p class="lead">
			<ul style="font-size:20px;">
				<li>View all tickets even those closed.</li>
				<li>Export to Excel. Say bye-bye to SSRS?</li>
				
			</ul>
		  </p>
        </div>
        <div class="col-md-5">
         <img src="/sitequota/styles/img/learnmore/archive.png" width=350 height=350/>
        </div>
      </div>
	  <hr class="featurette-divider">
	  
	  <div class="row featurette">
	  <div class="col-md-5">
          <img src="/sitequota/styles/img/learnmore/reports.png" width=350 height=350/>
        </div>
        <div class="col-md-7">
          <h2 class="featurette-heading">Reports</h2><br/>
          <p class="lead">
			<ul style="font-size:20px;">
				<li>Ticket priority breakdown.</li>
				<li>Monthly SWT/CWT on the selected Month.</li>
				<li>Daily Closed/SWT/CWT tickets. Animated graphs. Dashboard material.</li>
			</ul>
		  </p>
        </div>
        
      </div>
	  
	  <hr class="featurette-divider">
	  <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Handover</h2><br/>
          <p class="lead">
			<ul style="font-size:20px;">
				<li>Centralized. No more collecting ticket owners' updates.</li>
				<li>Latest. Handover the latest ticket data.</li>
				<li>Flexibility. Option to send Team Priority tickets only.</li>
				<li>Option to select queue - coming soon!</li>
			</ul>
		  </p>
        </div>
        <div class="col-md-5">
          <img src="/sitequota/styles/img/learnmore/handover.png" width=400 height=350/>
        </div>
      </div>
	  
	  <hr class="featurette-divider">
	  
	  <div class="row featurette">
	  <div class="col-md-5">
         &nbsp&nbsp&nbsp&nbsp <img src="/sitequota/styles/img/learnmore/followup.png" width=350 height=350/>
        </div>
        <div class="col-md-7">
          <h2 class="featurette-heading">Follow Up (coming soon).</h2><br/>
          <p class="lead">
			<ul style="font-size:20px;">
				<li>Send notifications to the queue.</li>
				<li>Email or SMS(?)</li>
				
			</ul>
		  </p>
        </div>
        
      </div>
	  
	  <hr class="featurette-divider">

	  <div class="row featurette">
		<div class="col-md-7">
          <h2 class="featurette-heading">Push to SM (coming soon).</h2><br/>
          <p class="lead">
			<ul style="font-size:20px;">
				<li>Send your handover updates directly to Service Manager.</li>
				
				
			</ul>
		  </p>
        </div>
        <div class="col-md-5">
          <img src="/sitequota/styles/img/learnmore/pushtosm.png" width=250 height=300/>
        </div>
      </div>
	  
	  <hr class="featurette-divider">
	  
	  <div class="row featurette">
		<div class="col-md-5">
          &nbsp&nbsp&nbsp&nbsp<img src="/sitequota/styles/img/learnmore/content-aware.png" width=250 height=300/>
        </div>
		<div class="col-md-7">
          <h2 class="featurette-heading">Content-aware.</h2><br/>
          <p class="lead">
			<ul style="font-size:20px;">
				<li>Application-specific ticket reporting.</li>
				<li>Improved ticket breakdown.</li>
				<li><a href="/sitequota/index.php/aiw" target="_blank">Visit Application Warehouse</a></li>
			</ul>
		  </p>
        </div>
        
      </div>
	  
	  <hr class="featurette-divider">
	  
	  <div class="row featurette">
		<div class="col-md-7">
          <h2 class="featurette-heading">Gamification(coming soon).</h2><br/>
          <p class="lead">
			<ul style="font-size:20px;">
				<li>Tie-up with R&R</li>
				<li>Badge system</li>
			</ul>
		  </p>
        </div>
        <div class="col-md-5">
          <img src="/sitequota/styles/img/learnmore/gamification.png" width=300 height=350/>
        </div>
      </div>
	  
	  <hr class="featurette-divider">
	  
      <!-- /END THE FEATURETTES -->


      <!-- FOOTER -->
      <footer >
      <p  class="pull-right"><a href="#">Back to top</a></p>
       
      </footer>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/sitequota/styles/bootstrap-3.1.1/dist/js/bootstrap.min.js"></script>
    <script src="/sitequota/styles/bootstrap-3.1.1/docs/assets/js/docs.min.js"></script>
  </body>
</html>

