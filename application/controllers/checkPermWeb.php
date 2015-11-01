<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class checkPermWeb extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{	
		// Uncomment before sending to Adrian
		//$name = $this->session->userdata('employeeName');
		//$email = $this->session->userdata('email');
		
		// Comment out before sending to Adrian
		//$name = 'Patrick Ian E. Cura';
		//$email = 'patrick-ian.cura@hp.com';
		
		echo "<br><br><br>";
		//echo 'NAME: '.$name.'<br/>';
		//echo 'EMAIL: '.$email.'<br/>';
		
		//echo "<br><br><br>";
		//echo getcwd();
		//echo exec('java -jar checkPermWeb.jar patrick-ian.cura@hp.com http://dcsp.pg.com/bu/GBSBCS/GBS_BCS_CS_LT_TC abrell.v@pg.com acquaah.ma@pg.com butler.tc@pg.com');
		//echo "<br><br><br>";
		
		$this->load->view('header.php');
		
		$checkPermPage = '
			<br>
			
			<p>PGOne Check Permissions</p>
			Sample Input: <br>
			&nbsp;&nbsp;&nbsp;&nbsp; Email address: patrick-ian.cura@hp.com <br>
			&nbsp;&nbsp;&nbsp;&nbsp; CCSW URL: http://dcsp.pg.com/bu/GBSBCS/GBS_BCS_CS_LT_TC <br>
			&nbsp;&nbsp;&nbsp;&nbsp; Users whose permissions will be checked: <br>
			&nbsp;&nbsp;&nbsp;&nbsp; abrell.v@pg.com <br>
			&nbsp;&nbsp;&nbsp;&nbsp; acquaah.ma@pg.com <br>
			&nbsp;&nbsp;&nbsp;&nbsp; butler.tc@pg.com <br>

			<form id="submitForm" method="post" target="_self">
				<br>
				Email address: <input type="text" name="emailAddress"><br>
				CCSW URL:  <input type="text" name="url"> <br>
				Users whose permissions will be checked: <br>
				<textarea name="usersArea" style="margin: 2px; width: 500px; height: 150px;"></textarea> <br>
				<input name="checkPermBtn" type="submit" class="btn"/>
			</form>
		';
		
		echo $checkPermPage;
		
		if (isset($_POST["usersArea"]) && isset($_POST["emailAddress"]) && isset($_POST["url"]))
		{				
			$command = " " . $_POST["emailAddress"] . " " . $_POST["url"];
		
			$token = strtok($_POST["usersArea"], "\r\n");
			
			while ($token != false)
			{	
				$command .= " " . $token;							
				$token = strtok("\r\n");				
			} 			
			
			echo "Below query sent to the server for processing. Please check your email for the results." . "<br>";
			echo $command;
			echo "<br>It will take around 5 minutes per user checked.<br>";
			
			//echo exec('java -jar checkPermWeb.jar ' . $command, $output);
			//echo system('java -jar checkPermWeb.jar ' . $command);
			$this->execInBackground('java -jar checkPermWeb.jar ' . $command);
		}
		
	}
	
	function execInBackground($cmd) { 
		if (substr(php_uname(), 0, 7) == "Windows"){ 
			pclose(popen("start /B ". $cmd, "r"));  
		} 
		else { 
			exec($cmd . " > /dev/null &");   
		} 
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */