<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'WebTest.php';

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
		include("lib/simplehtmldom/simple_html_dom.php");
		
		$db = new WebTest();
		$db->setUp(); 
		$db->setUptestTitle();
		
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
			
			echo exec('java -jar checkPermWeb.jar ' . $command, $output);
		}

		$fields = array(
						'submitFRsArea' => urlencode("FR03081904")
				);

		//url-ify the data for the POST
		$fields_string = "";
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
		
		$ch = curl_init();
		
		$url = "http://pgone.pg.com/_layouts/chkperm.aspx";
		$username = "ap\cura.p";
		$password = "patrick4";
		curl_setopt($ch, CURLOPT_URL, $url);curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		
		//$url = "http://16.178.45.0:82/sitequota/index.php/pgtube";
		//curl_setopt($ch, CURLOPT_URL, $url);
		
		curl_setopt($ch,CURLOPT_POST, 33);
		curl_setopt($ch,CURLOPT_POSTFIELDS, "MSOWebPartPage_PostbackSource=&MSOTlPn_SelectedWpId=&MSOTlPn_View=0&MSOTlPn_ShowSettings=False&MSOGallery_SelectedLibrary=&MSOGallery_FilterString=&MSOTlPn_Button=none&MSOSPWebPartManager_DisplayModeName=Browse&MSOSPWebPartManager_ExitingDesignMode=false&__EVENTTARGET=ctl00%24PlaceHolderMain%24btnCheckPerm&__EVENTARGUMENT=&MSOWebPartPage_Shared=&MSOLayout_LayoutChanges=&MSOLayout_InDesignMode=&MSOSPWebPartManager_OldDisplayModeName=Browse&MSOSPWebPartManager_StartWebPartEditingName=false&MSOSPWebPartManager_EndWebPartEditing=false&_maintainWorkspaceScrollPosition=0&__spPickerHasReturnValue=&__spPickerReturnValueHolder=&__REQUESTDIGEST=0x1AFC4ABBB72B1FD7609E16B14E6E6457BF8B08EA6A5F1C1A08AE8849B0EFD118DBE558E96C6A3D8F7D789165B047C0A773558FA47A7FE9E739D4B59FA1AB4B2D%2C27+Nov+2014+15%3A19%3A57+-0000&__VIEWSTATE=%2FwEPDwULLTE4NTczNTc2MTYPZBYCZg9kFgICAQ9kFgICBQ9kFgwCEQ9kFgRmD2QWBAIBD2QWAmYPZBYEAgIPZBYKAgEPFgIeB1Zpc2libGVoZAIDDxYIHhNDbGllbnRPbkNsaWNrU2NyaXB0BWdqYXZhU2NyaXB0OkNvcmVJbnZva2UoJ1Rha2VPZmZsaW5lVG9DbGllbnRSZWFsJywxLCA1NCwgJ2h0dHA6XHUwMDJmXHUwMDJmcGdvbmUucGcuY29tJywgLTEsIC0xLCAnJywgJycpHhhDbGllbnRPbkNsaWNrTmF2aWdhdGVVcmxkHihDbGllbnRPbkNsaWNrU2NyaXB0Q29udGFpbmluZ1ByZWZpeGVkVXJsZB4MSGlkZGVuU2NyaXB0BSJUYWtlT2ZmbGluZURpc2FibGVkKDEsIDU0LCAtMSwgLTEpZAIFDxYCHwBoZAIVDxYCHwBoZAIXD2QWAmYPDxYGHhxQcmV2aW91c0F1dGhvcmluZ0l0ZW1WZXJzaW9uZR4aUHJldmlvdXNBdXRob3JpbmdJdGVtT3duZXJlHhxQcmV2aW91c0F1dGhvcmluZ0NvbnRyb2xNb2RlCymIAU1pY3Jvc29mdC5TaGFyZVBvaW50LldlYkNvbnRyb2xzLlNQQ29udHJvbE1vZGUsIE1pY3Jvc29mdC5TaGFyZVBvaW50LCBWZXJzaW9uPTE0LjAuMC4wLCBDdWx0dXJlPW5ldXRyYWwsIFB1YmxpY0tleVRva2VuPTcxZTliY2UxMTFlOTQyOWMAZGQCAw8PFgoeCUFjY2Vzc0tleQUBLx4PQXJyb3dJbWFnZVdpZHRoAgUeEEFycm93SW1hZ2VIZWlnaHQCAx4RQXJyb3dJbWFnZU9mZnNldFhmHhFBcnJvd0ltYWdlT2Zmc2V0WQLrA2RkAgMPZBYCAgEPZBYCAgMPZBYCAgMPZBYCAgEPPCsABQEADxYCHg9TaXRlTWFwUHJvdmlkZXIFEVNQU2l0ZU1hcFByb3ZpZGVyZGQCAQ9kFgICAw9kFgJmD2QWAmYPFCsAA2QFImh0dHA6Ly9wZ29uZS5wZy5jb206ODAvUGVyc29uLmFzcHgFF2h0dHA6Ly9wZ29uZS5wZy5jb206ODAvZAIZD2QWAgIBDxAWAh8AaGQUKwEAZAIfD2QWAmYPZBYCAgEPD2QWBh4FY2xhc3MFIm1zLXNidGFibGUgbXMtc2J0YWJsZS1leCBzNC1zZWFyY2geC2NlbGxwYWRkaW5nBQEwHgtjZWxsc3BhY2luZwUBMGQCKQ9kFgICBw9kFgICAQ9kFgICAw8WAh8AaBYCZg9kFgQCAg9kFgICBw9kFgJmDw8WBh8FZR8GZR8HCysEAGRkAgMPDxYKHwgFAS8fCQIFHwoCAx8LZh8MAusDZGQCNQ9kFgICCQ9kFgICAQ8PFgIfAGhkFgICAw9kFgICAw9kFgICAQ88KwAJAQAPFgIeDU5ldmVyRXhwYW5kZWRnZGQCSQ9kFgICAQ9kFgwCAQ9kFgQCAQ9kFgJmDxYCHgRUZXh0BRFDaGVjayBQZXJtaXNzaW9uc2QCBA9kFgICAQ9kFgZmD2QWAmYPDxYCHxIFC1VzZXIvR3JvdXA6ZGQCAQ9kFgICAQ8PFgYeC0RpYWxvZ1RpdGxlBRhTZWxlY3QgUGVvcGxlIGFuZCBHcm91cHMeCUlTQ0hBTkdFRGgeB0lTVkFMSURnFhYeDmVkaXRvck9sZFZhbHVlZR4KUmVtb3ZlVGV4dAUGUmVtb3ZlHg1Ob01hdGNoZXNUZXh0BRM8Tm8gTWF0Y2hpbmcgTmFtZXM%2BHg1Nb3JlSXRlbXNUZXh0BQ1Nb3JlIE5hbWVzLi4uHhhwcmVmZXJDb250ZW50RWRpdGFibGVEaXYFBHRydWUeHXNob3dEYXRhVmFsaWRhdGlvbkVycm9yQm9yZGVyBQVmYWxzZR4bRUVBZnRlckNhbGxiYWNrQ2xpZW50U2NyaXB0ZR4KaW5WYWxpZGF0ZQUFZmFsc2UeBXZhbHVlBQR0cnVlHgthbGxvd1R5cGVJbgUEdHJ1ZR4eU2hvd0VudGl0eURpc3BsYXlUZXh0SW5UZXh0Qm94BQEwFgICBA8PFgYeBVdpZHRoHB4IQ3NzQ2xhc3MFDW1zLXVzZXJlZGl0b3IeBF8hU0ICggJkFgZmDw8WBB4NVmVydGljYWxBbGlnbgsqJ1N5c3RlbS5XZWIuVUkuV2ViQ29udHJvbHMuVmVydGljYWxBbGlnbgMfIwKAgAhkFgRmDw8WBB8hGwAAAAAAAFZABwAAAB8jAoACZBYCZg9kFgJmD2QWAmYPZBYEZg8WKB4IdGFiaW5kZXgFATAeB29uZm9jdXMFflN0b3JlT2xkVmFsdWUoJ2N0bDAwX1BsYWNlSG9sZGVyTWFpbl9jdGwwMF9jdGwwMV91c2VyUGlja2VyJyk7c2F2ZU9sZEVudGl0aWVzKCdjdGwwMF9QbGFjZUhvbGRlck1haW5fY3RsMDBfY3RsMDFfdXNlclBpY2tlcicpOx4Hb25jbGljawVLb25DbGlja1J3KHRydWUsIHRydWUsZXZlbnQsJ2N0bDAwX1BsYWNlSG9sZGVyTWFpbl9jdGwwMF9jdGwwMV91c2VyUGlja2VyJyk7HghvbmNoYW5nZQVDdXBkYXRlQ29udHJvbFZhbHVlKCdjdGwwMF9QbGFjZUhvbGRlck1haW5fY3RsMDBfY3RsMDFfdXNlclBpY2tlcicpOx4Fc3R5bGUFVndvcmQtd3JhcDogYnJlYWstd29yZDtvdmVyZmxvdy14OiBoaWRkZW47IGJhY2tncm91bmQtY29sb3I6IHdpbmRvdzsgY29sb3I6IHdpbmRvd3RleHQ7HgdvblBhc3RlBT5kb3Bhc3RlKCdjdGwwMF9QbGFjZUhvbGRlck1haW5fY3RsMDBfY3RsMDFfdXNlclBpY2tlcicsZXZlbnQpOx4MQXV0b1Bvc3RCYWNrBQEwHgRyb3dzBQExHgtvbkRyYWdTdGFydAUOY2FuRXZ0KGV2ZW50KTseB29ua2V5dXAFQXJldHVybiBvbktleVVwUncoJ2N0bDAwX1BsYWNlSG9sZGVyTWFpbl9jdGwwMF9jdGwwMV91c2VyUGlja2VyJyk7HgZvbkNvcHkFPWRvY29weSgnY3RsMDBfUGxhY2VIb2xkZXJNYWluX2N0bDAwX2N0bDAxX3VzZXJQaWNrZXInLGV2ZW50KTseBm9uYmx1cgXQAmlmKHR5cGVvZihFeHRlcm5hbEN1c3RvbUNvbnRyb2xDYWxsYmFjayk9PSdmdW5jdGlvbicpeyBpZihTaG91bGRDYWxsQ3VzdG9tQ2FsbEJhY2soJ2N0bDAwX1BsYWNlSG9sZGVyTWFpbl9jdGwwMF9jdGwwMV91c2VyUGlja2VyJyxldmVudCkpe2lmKCFWYWxpZGF0ZVBpY2tlckNvbnRyb2woJ2N0bDAwX1BsYWNlSG9sZGVyTWFpbl9jdGwwMF9jdGwwMV91c2VyUGlja2VyJykpe1Nob3dWYWxpZGF0aW9uRXJyb3IoKTtyZXR1cm4gZmFsc2U7fWVsc2Uge0V4dGVybmFsQ3VzdG9tQ29udHJvbENhbGxiYWNrKCdjdGwwMF9QbGFjZUhvbGRlck1haW5fY3RsMDBfY3RsMDFfdXNlclBpY2tlcicpO319fR4FdGl0bGUFC1VzZXIvR3JvdXA6HglvbmtleWRvd24FU3JldHVybiBvbktleURvd25SdygnY3RsMDBfUGxhY2VIb2xkZXJNYWluX2N0bDAwX2N0bDAxX3VzZXJQaWNrZXInLCAzLCB0cnVlLCBldmVudCk7Hg9jb250ZW50RWRpdGFibGUFBHRydWUeDWFyaWEtaGFzcG9wdXAFBHRydWUeDmFyaWEtbXVsdGlsaW5lBQR0cnVlHxoFBHRydWUeCWlubmVyaHRtbGUeBHJvbGUFB3RleHRib3hkAgEPDxYKHghUYWJJbmRleAEAAB8hGwAAAAAAAFlABwAAAB4EUm93cwIBHytoHyMCgAIWEh8rBQEwHy4FQXJldHVybiBvbktleVVwUncoJ2N0bDAwX1BsYWNlSG9sZGVyTWFpbl9jdGwwMF9jdGwwMV91c2VyUGlja2VyJyk7HzEFC1VzZXIvR3JvdXA6HzIFU3JldHVybiBvbktleURvd25SdygnY3RsMDBfUGxhY2VIb2xkZXJNYWluX2N0bDAwX2N0bDAxX3VzZXJQaWNrZXInLCAzLCB0cnVlLCBldmVudCk7HzAF0AJpZih0eXBlb2YoRXh0ZXJuYWxDdXN0b21Db250cm9sQ2FsbGJhY2spPT0nZnVuY3Rpb24nKXsgaWYoU2hvdWxkQ2FsbEN1c3RvbUNhbGxCYWNrKCdjdGwwMF9QbGFjZUhvbGRlck1haW5fY3RsMDBfY3RsMDFfdXNlclBpY2tlcicsZXZlbnQpKXtpZighVmFsaWRhdGVQaWNrZXJDb250cm9sKCdjdGwwMF9QbGFjZUhvbGRlck1haW5fY3RsMDBfY3RsMDFfdXNlclBpY2tlcicpKXtTaG93VmFsaWRhdGlvbkVycm9yKCk7cmV0dXJuIGZhbHNlO31lbHNlIHtFeHRlcm5hbEN1c3RvbUNvbnRyb2xDYWxsYmFjaygnY3RsMDBfUGxhY2VIb2xkZXJNYWluX2N0bDAwX2N0bDAxX3VzZXJQaWNrZXInKTt9fX0fKQUiZGlzcGxheTogbm9uZTtwb3NpdGlvbjogYWJzb2x1dGU7IB8mBX5TdG9yZU9sZFZhbHVlKCdjdGwwMF9QbGFjZUhvbGRlck1haW5fY3RsMDBfY3RsMDFfdXNlclBpY2tlcicpO3NhdmVPbGRFbnRpdGllcygnY3RsMDBfUGxhY2VIb2xkZXJNYWluX2N0bDAwX2N0bDAxX3VzZXJQaWNrZXInKTseGnJlbmRlckFzQ29udGVudEVkaXRhYmxlRGl2BQR0cnVlHygFQ3VwZGF0ZUNvbnRyb2xWYWx1ZSgnY3RsMDBfUGxhY2VIb2xkZXJNYWluX2N0bDAwX2N0bDAxX3VzZXJQaWNrZXInKTtkAgEPDxYEHg9Ib3Jpem9udGFsQWxpZ24LKilTeXN0ZW0uV2ViLlVJLldlYkNvbnRyb2xzLkhvcml6b250YWxBbGlnbgIfIwKAgARkFgZmDw8WCh4LTmF2aWdhdGVVcmwFC2phdmFzY3JpcHQ6HgdUb29sVGlwBQtDaGVjayBOYW1lcx8SBQtDaGVjayBOYW1lcx4ISW1hZ2VVcmwFHy9fbGF5b3V0cy9pbWFnZXMvY2hlY2tuYW1lcy5wbmcfOAEAABYCHycFrQMgaWYoIVZhbGlkYXRlUGlja2VyQ29udHJvbCgnY3RsMDBfUGxhY2VIb2xkZXJNYWluX2N0bDAwX2N0bDAxX3VzZXJQaWNrZXInKSl7IFNob3dWYWxpZGF0aW9uRXJyb3IoKTsgcmV0dXJuIGZhbHNlO30gdmFyIGFyZz1nZXRVcGxldmVsKCdjdGwwMF9QbGFjZUhvbGRlck1haW5fY3RsMDBfY3RsMDFfdXNlclBpY2tlcicpOyB2YXIgY3R4PSdjdGwwMF9QbGFjZUhvbGRlck1haW5fY3RsMDBfY3RsMDFfdXNlclBpY2tlcic7RW50aXR5RWRpdG9yU2V0V2FpdEN1cnNvcihjdHgpO1dlYkZvcm1fRG9DYWxsYmFjaygnY3RsMDAkUGxhY2VIb2xkZXJNYWluJGN0bDAwJGN0bDAxJHVzZXJQaWNrZXInLGFyZyxFbnRpdHlFZGl0b3JIYW5kbGVDaGVja05hbWVSZXN1bHQsY3R4LEVudGl0eUVkaXRvckhhbmRsZUNoZWNrTmFtZUVycm9yLHRydWUpO3JldHVybiBmYWxzZTtkAgIPDxYKHz0FBkJyb3dzZR8SBQZCcm93c2UfPAULamF2YXNjcmlwdDofPgUgL19sYXlvdXRzL2ltYWdlcy9hZGRyZXNzYm9vay5naWYfOAEAABYCHycFR19fRGlhbG9nX19jdGwwMF9QbGFjZUhvbGRlck1haW5fY3RsMDBfY3RsMDFfdXNlclBpY2tlcigpOyByZXR1cm4gZmFsc2U7ZAIEDxYEHx4FCUNyZWF0ZS4uLh8AaGQCAQ9kFgJmDw8WAh4KQ29sdW1uU3BhbgIDZGQCAg8PFgIfAGhkZAICDxYCHwBoZAIJDxYCHwBnFgJmD2QWAgIBDw8WBB8SBUBQZXJtaXNzaW9uIGxldmVscyBnaXZlbiB0byBQYXRyaWNrSWFuIEN1cmEgLSBOb24tRW1wIChBUFxjdXJhLnApHwBnZGQCCw88KwANAgAPFgYeC18hRGF0YUJvdW5kZx4LXyFJdGVtQ291bnQCAh8AZ2QBEBYCZgIBFgI8KwAFAQEWBB8iBQZtcy12YjIfIwICPCsABQEBFgQfIgUGbXMtdmIyHyMCAhYCAgYCBhYCZg9kFghmDw8WAh8AaGRkAgEPZBYEZg9kFgJmDxUBBFJlYWRkAgEPZBYCZg8VAWhHaXZlbiB0aHJvdWdoIHRoZSAmcXVvdDtOVCBBVVRIT1JJVFlcYXV0aGVudGljYXRlZCB1c2VycyAoTlQgQVVUSE9SSVRZXGF1dGhlbnRpY2F0ZWQgdXNlcnMpJnF1b3Q7IGdyb3VwLmQCAg9kFgRmD2QWAmYPFQEOTGltaXRlZCBBY2Nlc3NkAgEPZBYCZg8VATtHaXZlbiB0aHJvdWdoIHRoZSAmcXVvdDtTdHlsZSBSZXNvdXJjZSBSZWFkZXJzJnF1b3Q7IGdyb3VwLmQCAw8PFgIfAGhkZAINDw8WAh8SBRRObyByb2xlIGFzc2lnbm1lbnRzLmRkAg8PFgIfAGcWAmYPZBYCAgEPDxYEHxIFX1RoZSBmb2xsb3dpbmcgZmFjdG9ycyBhbHNvIGFmZmVjdCB0aGUgbGV2ZWwgb2YgYWNjZXNzIGZvciBQYXRyaWNrSWFuIEN1cmEgLSBOb24tRW1wIChBUFxjdXJhLnApHwBnZGQCEQ88KwANAgAPFgYfQGcfQQIWHwBnZAEQFgNmAgECAhYDPCsABQEBFgQfIgUGbXMtdmIyHyMCAjwrAAUBARYEHyIFBm1zLXZiMh8jAgI8KwAFAQEWBB8iBQZtcy12YjIfIwICFgMCBgIGAgYWAmYPZBYwZg8PFgIfAGhkZAIBD2QWBmYPZBYCZg8VAQVBbGxvd2QCAQ9kFgJmDxUBEk1hbmFnZSBQZXJtaXNzaW9uc2QCAg9kFgJmDxUBX0NyZWF0ZSBhbmQgY2hhbmdlIHBlcm1pc3Npb24gbGV2ZWxzIG9uIHRoZSBXZWIgc2l0ZSBhbmQgYXNzaWduIHBlcm1pc3Npb25zIHRvIHVzZXJzIGFuZCBncm91cHMuZAICD2QWBmYPZBYCZg8VAQVBbGxvd2QCAQ9kFgJmDxUBF1ZpZXcgV2ViIEFuYWx5dGljcyBEYXRhZAICD2QWAmYPFQEfVmlldyByZXBvcnRzIG9uIFdlYiBzaXRlIHVzYWdlLmQCAw9kFgZmD2QWAmYPFQEFQWxsb3dkAgEPZBYCZg8VAQ9DcmVhdGUgU3Vic2l0ZXNkAgIPZBYCZg8VAVpDcmVhdGUgc3Vic2l0ZXMgc3VjaCBhcyB0ZWFtIHNpdGVzLCBNZWV0aW5nIFdvcmtzcGFjZSBzaXRlcywgYW5kIERvY3VtZW50IFdvcmtzcGFjZSBzaXRlcy5kAgQPZBYGZg9kFgJmDxUBBUFsbG93ZAIBD2QWAmYPFQEPTWFuYWdlIFdlYiBTaXRlZAICD2QWAmYPFQFiR3JhbnRzIHRoZSBhYmlsaXR5IHRvIHBlcmZvcm0gYWxsIGFkbWluaXN0cmF0aW9uIHRhc2tzIGZvciB0aGUgV2ViIHNpdGUgYXMgd2VsbCBhcyBtYW5hZ2UgY29udGVudC5kAgUPZBYGZg9kFgJmDxUBBUFsbG93ZAIBD2QWAmYPFQEXQWRkIGFuZCBDdXN0b21pemUgUGFnZXNkAgIPZBYCZg8VAYUBQWRkLCBjaGFuZ2UsIG9yIGRlbGV0ZSBIVE1MIHBhZ2VzIG9yIFdlYiBQYXJ0IFBhZ2VzLCBhbmQgZWRpdCB0aGUgV2ViIHNpdGUgdXNpbmcgYSBNaWNyb3NvZnQgU2hhcmVQb2ludCBGb3VuZGF0aW9uLWNvbXBhdGlibGUgZWRpdG9yLmQCBg9kFgZmD2QWAmYPFQEFQWxsb3dkAgEPZBYCZg8VAQxNYW5hZ2UgTGlzdHNkAgIPZBYCZg8VAWNDcmVhdGUgYW5kIGRlbGV0ZSBsaXN0cywgYWRkIG9yIHJlbW92ZSBjb2x1bW5zIGluIGEgbGlzdCwgYW5kIGFkZCBvciByZW1vdmUgcHVibGljIHZpZXdzIG9mIGEgbGlzdC5kAgcPZBYGZg9kFgJmDxUBBUFsbG93ZAIBD2QWAmYPFQEYQXBwbHkgVGhlbWVzIGFuZCBCb3JkZXJzZAICD2QWAmYPFQEwQXBwbHkgYSB0aGVtZSBvciBib3JkZXJzIHRvIHRoZSBlbnRpcmUgV2ViIHNpdGUuZAIID2QWBmYPZBYCZg8VAQVBbGxvd2QCAQ9kFgJmDxUBEkFwcGx5IFN0eWxlIFNoZWV0c2QCAg9kFgJmDxUBMEFwcGx5IGEgc3R5bGUgc2hlZXQgKC5DU1MgZmlsZSkgdG8gdGhlIFdlYiBzaXRlLmQCCQ9kFgZmD2QWAmYPFQEFQWxsb3dkAgEPZBYCZg8VARJPdmVycmlkZSBDaGVjayBPdXRkAgIPZBYCZg8VAUREaXNjYXJkIG9yIGNoZWNrIGluIGEgZG9jdW1lbnQgd2hpY2ggaXMgY2hlY2tlZCBvdXQgdG8gYW5vdGhlciB1c2VyLmQCCg9kFgZmD2QWAmYPFQEFQWxsb3dkAgEPZBYCZg8VARVNYW5hZ2UgUGVyc29uYWwgVmlld3NkAgIPZBYCZg8VATNDcmVhdGUsIGNoYW5nZSwgYW5kIGRlbGV0ZSBwZXJzb25hbCB2aWV3cyBvZiBsaXN0cy5kAgsPZBYGZg9kFgJmDxUBBUFsbG93ZAIBD2QWAmYPFQEdQWRkL1JlbW92ZSBQZXJzb25hbCBXZWIgUGFydHNkAgIPZBYCZg8VATRBZGQgb3IgcmVtb3ZlIHBlcnNvbmFsIFdlYiBQYXJ0cyBvbiBhIFdlYiBQYXJ0IFBhZ2UuZAIMD2QWBmYPZBYCZg8VAQVBbGxvd2QCAQ9kFgJmDxUBGVVwZGF0ZSBQZXJzb25hbCBXZWIgUGFydHNkAgIPZBYCZg8VATVVcGRhdGUgV2ViIFBhcnRzIHRvIGRpc3BsYXkgcGVyc29uYWxpemVkIGluZm9ybWF0aW9uLmQCDQ9kFgZmD2QWAmYPFQEFQWxsb3dkAgEPZBYCZg8VAQlBZGQgSXRlbXNkAgIPZBYCZg8VATtBZGQgaXRlbXMgdG8gbGlzdHMgYW5kIGFkZCBkb2N1bWVudHMgdG8gZG9jdW1lbnQgbGlicmFyaWVzLmQCDg9kFgZmD2QWAmYPFQEFQWxsb3dkAgEPZBYCZg8VAQpFZGl0IEl0ZW1zZAICD2QWAmYPFQFuRWRpdCBpdGVtcyBpbiBsaXN0cywgZWRpdCBkb2N1bWVudHMgaW4gZG9jdW1lbnQgbGlicmFyaWVzLCBhbmQgY3VzdG9taXplIFdlYiBQYXJ0IFBhZ2VzIGluIGRvY3VtZW50IGxpYnJhcmllcy5kAg8PZBYGZg9kFgJmDxUBBUFsbG93ZAIBD2QWAmYPFQEMRGVsZXRlIEl0ZW1zZAICD2QWAmYPFQE%2FRGVsZXRlIGl0ZW1zIGZyb20gYSBsaXN0IGFuZCBkb2N1bWVudHMgZnJvbSBhIGRvY3VtZW50IGxpYnJhcnkuZAIQD2QWBmYPZBYCZg8VAQVBbGxvd2QCAQ9kFgJmDxUBDUNyZWF0ZSBHcm91cHNkAgIPZBYCZg8VAU1DcmVhdGUgYSBncm91cCBvZiB1c2VycyB0aGF0IGNhbiBiZSB1c2VkIGFueXdoZXJlIHdpdGhpbiB0aGUgc2l0ZSBjb2xsZWN0aW9uLmQCEQ9kFgZmD2QWAmYPFQEFQWxsb3dkAgEPZBYCZg8VARJCcm93c2UgRGlyZWN0b3JpZXNkAgIPZBYCZg8VAVtFbnVtZXJhdGUgZmlsZXMgYW5kIGZvbGRlcnMgaW4gYSBXZWIgc2l0ZSB1c2luZyBTaGFyZVBvaW50IERlc2lnbmVyIGFuZCBXZWIgREFWIGludGVyZmFjZXMuZAISD2QWBmYPZBYCZg8VAQVBbGxvd2QCAQ9kFgJmDxUBDUFwcHJvdmUgSXRlbXNkAgIPZBYCZg8VATNBcHByb3ZlIGEgbWlub3IgdmVyc2lvbiBvZiBhIGxpc3QgaXRlbSBvciBkb2N1bWVudC5kAhMPZBYGZg9kFgJmDxUBBUFsbG93ZAIBD2QWAmYPFQEVRW51bWVyYXRlIFBlcm1pc3Npb25zZAICD2QWAmYPFQFMRW51bWVyYXRlIHBlcm1pc3Npb25zIG9uIHRoZSBXZWIgc2l0ZSwgbGlzdCwgZm9sZGVyLCBkb2N1bWVudCwgb3IgbGlzdCBpdGVtLmQCFA9kFgZmD2QWAmYPFQEFQWxsb3dkAgEPZBYCZg8VAQ9EZWxldGUgVmVyc2lvbnNkAgIPZBYCZg8VATBEZWxldGUgcGFzdCB2ZXJzaW9ucyBvZiBhIGxpc3QgaXRlbSBvciBkb2N1bWVudC5kAhUPZBYGZg9kFgJmDxUBBUFsbG93ZAIBD2QWAmYPFQENTWFuYWdlIEFsZXJ0c2QCAg9kFgJmDxUBLE1hbmFnZSBhbGVydHMgZm9yIGFsbCB1c2VycyBvZiB0aGUgV2ViIHNpdGUuZAIWD2QWBmYPZBYCZg8VAQVBbGxvd2QCAQ9kFgJmDxUBHkVkaXQgUGVyc29uYWwgVXNlciBJbmZvcm1hdGlvbmQCAg9kFgJmDxUBUkFsbG93cyBhIHVzZXIgdG8gY2hhbmdlIGhpcyBvciBoZXIgb3duIHVzZXIgaW5mb3JtYXRpb24sIHN1Y2ggYXMgYWRkaW5nIGEgcGljdHVyZS5kAhcPDxYCHwBoZGQYAwUkY3RsMDAkUGxhY2VIb2xkZXJNYWluJHJwdHJPdGhlclBlcm1zDxQrAAM8KwAKAQgCAWYCFWQFHl9fQ29udHJvbHNSZXF1aXJlUG9zdEJhY2tLZXlfXxYBBSxjdGwwMCRQbGFjZUhvbGRlck1haW4kY3RsMDAkY3RsMDEkdXNlclBpY2tlcgUkY3RsMDAkUGxhY2VIb2xkZXJNYWluJHJwdHJHaXZlblBlcm1zDxQrAAM8KwAKAQgCAWYCAWQgEQS0MV1F4BVCc9EuBUltThxoHA%3D%3D&__EVENTVALIDATION=%2FwEWCwLE9aKfBAKB8LVnAq27%2BcMFAv3vtWcCtbOX5wgC7cv%2FvA4C2busmg0C%2BaWTqQsC1ury9QsC%2FanT2QoCvNy6%2FAll15c3Ml0QLP0HYUeCoaD7jk%2Bvuw%3D%3D&ctl00%24ctl32%24ctl00=http%3A%2F%2Fpgone.pg.com&InputKeywords=Search+this+site...&ctl00%24ctl32%24ctl04=0&ctl00%24PlaceHolderMain%24ctl00%24ctl01%24userPicker%24hiddenSpanData=%26nbsp%3B%3Cspan+id%3D%22spanAP%5Cdacumos.r%22+iscontenttype%3D%22true%22+tabindex%3D%22-1%22+class%3D%22ms-entity-resolved%22+contenteditable%3D%22false%22+title%3D%22AP%5Ccura.p%22%3E%3Cdiv+style%3D%22display%3Anone%3B%22+id%3D%22divEntityData%22+key%3D%22AP%5Ccura.p%22+displaytext%3D%22PatrickIan+Cura+-+Non-Emp%22+isresolved%3D%22True%22+description%3D%22AP%5Ccura.p%22%3E%3Cdiv+data%3D%22%3CArrayOfDictionaryEntry+xmlns%3Axsi%3D%26quot%3Bhttp%3A%2F%2Fwww.w3.org%2F2001%2FXMLSchema-instance%26quot%3B+xmlns%3Axsd%3D%26quot%3Bhttp%3A%2F%2Fwww.w3.org%2F2001%2FXMLSchema%26quot%3B%3E%3CDictionaryEntry%3E%3CKey+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%3ESPUserID%3C%2FKey%3E%3CValue+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%3E9091%3C%2FValue%3E%3C%2FDictionaryEntry%3E%3CDictionaryEntry%3E%3CKey+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%3EAccountName%3C%2FKey%3E%3CValue+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%3EAP%5Ccura.p%3C%2FValue%3E%3C%2FDictionaryEntry%3E%3CDictionaryEntry%3E%3CKey+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%3EEmail%3C%2FKey%3E%3CValue+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%3Epatrick-ian.cura%40hp.com%3C%2FValue%3E%3C%2FDictionaryEntry%3E%3CDictionaryEntry%3E%3CKey+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%3EDepartment%3C%2FKey%3E%3CValue+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%3EHEWLETT-PACKARD+CO+-+AP%3C%2FValue%3E%3C%2FDictionaryEntry%3E%3CDictionaryEntry%3E%3CKey+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%3EPrincipalType%3C%2FKey%3E%3CValue+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%3EUser%3C%2FValue%3E%3C%2FDictionaryEntry%3E%3C%2FArrayOfDictionaryEntry%3E%22%3E%3C%2Fdiv%3E%3C%2Fdiv%3E%3Cspan+id%3D%22content%22+tabindex%3D%22-1%22+contenteditable%3D%22false%22+onmousedown%3D%22onMouseDownRw%28event%29%3B%22+oncontextmenu%3D%22onContextMenuSpnRw%28event%2C%26quot%3Bctl00_PlaceHolderMain_ctl00_ctl01_userPicker%26quot%3B%29%3B%22%3EPatrickIan+Cura+-+Non-Emp%3C%2Fspan%3E%3C%2Fspan%3E%3B+&ctl00%24PlaceHolderMain%24ctl00%24ctl01%24userPicker%24OriginalEntities=%3CEntities%3E%3CEntity+Key%3D%22AP%5Ccura.p%22+DisplayText%3D%22PatrickIan+Cura+-+Non-Emp%22+IsResolved%3D%22True%22+Description%3D%22AP%5Ccura.p%22%3E%3CExtraData%3E%3CArrayOfDictionaryEntry+xmlns%3Axsi%3D%22http%3A%2F%2Fwww.w3.org%2F2001%2FXMLSchema-instance%22+xmlns%3Axsd%3D%22http%3A%2F%2Fwww.w3.org%2F2001%2FXMLSchema%22%3E%3CDictionaryEntry%3E%3CKey+xsi%3Atype%3D%22xsd%3Astring%22%3ESPUserID%3C%2FKey%3E%3CValue+xsi%3Atype%3D%22xsd%3Astring%22%3E9091%3C%2FValue%3E%3C%2FDictionaryEntry%3E%3CDictionaryEntry%3E%3CKey+xsi%3Atype%3D%22xsd%3Astring%22%3EAccountName%3C%2FKey%3E%3CValue+xsi%3Atype%3D%22xsd%3Astring%22%3EAP%5Ccura.p%3C%2FValue%3E%3C%2FDictionaryEntry%3E%3CDictionaryEntry%3E%3CKey+xsi%3Atype%3D%22xsd%3Astring%22%3EEmail%3C%2FKey%3E%3CValue+xsi%3Atype%3D%22xsd%3Astring%22%3Epatrick-ian.cura%40hp.com%3C%2FValue%3E%3C%2FDictionaryEntry%3E%3CDictionaryEntry%3E%3CKey+xsi%3Atype%3D%22xsd%3Astring%22%3EDepartment%3C%2FKey%3E%3CValue+xsi%3Atype%3D%22xsd%3Astring%22%3EHEWLETT-PACKARD+CO+-+AP%3C%2FValue%3E%3C%2FDictionaryEntry%3E%3CDictionaryEntry%3E%3CKey+xsi%3Atype%3D%22xsd%3Astring%22%3EPrincipalType%3C%2FKey%3E%3CValue+xsi%3Atype%3D%22xsd%3Astring%22%3EUser%3C%2FValue%3E%3C%2FDictionaryEntry%3E%3C%2FArrayOfDictionaryEntry%3E%3C%2FExtraData%3E%3C%2FEntity%3E%3C%2FEntities%3E&ctl00%24PlaceHolderMain%24ctl00%24ctl01%24userPicker%24HiddenEntityKey=AP%5Ccura.p&ctl00%24PlaceHolderMain%24ctl00%24ctl01%24userPicker%24HiddenEntityDisplayText=PatrickIan+Cura+-+Non-Emp&ctl00%24PlaceHolderMain%24ctl00%24ctl01%24userPicker%24downlevelTextBox=%26%23160%3B%3Cspan+id%3D%27spanAP%5Ccura.p%27+isContentType%3D%27true%27+tabindex%3D%27-1%27+class%3D%27ms-entity-resolved%27+contentEditable%3D%27false%27+title%3D%27AP%5Ccura.p%27%3E%3Cdiv+style%3D%27display%3Anone%3B%27+id%3D%27divEntityData%27+key%3D%27AP%5Ccura.p%27+displaytext%3D%27PatrickIan+Cura+-+Non-Emp%27+isresolved%3D%27True%27+description%3D%27AP%5Ccura.p%27%3E%3Cdiv+data%3D%27%26lt%3BArrayOfDictionaryEntry+xmlns%3Axsi%3D%26quot%3Bhttp%3A%2F%2Fwww.w3.org%2F2001%2FXMLSchema-instance%26quot%3B+xmlns%3Axsd%3D%26quot%3Bhttp%3A%2F%2Fwww.w3.org%2F2001%2FXMLSchema%26quot%3B%26gt%3B%26lt%3BDictionaryEntry%26gt%3B%26lt%3BKey+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%26gt%3BSPUserID%26lt%3B%2FKey%26gt%3B%26lt%3BValue+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%26gt%3B9091%26lt%3B%2FValue%26gt%3B%26lt%3B%2FDictionaryEntry%26gt%3B%26lt%3BDictionaryEntry%26gt%3B%26lt%3BKey+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%26gt%3BAccountName%26lt%3B%2FKey%26gt%3B%26lt%3BValue+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%26gt%3BAP%5Ccura.p%26lt%3B%2FValue%26gt%3B%26lt%3B%2FDictionaryEntry%26gt%3B%26lt%3BDictionaryEntry%26gt%3B%26lt%3BKey+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%26gt%3BEmail%26lt%3B%2FKey%26gt%3B%26lt%3BValue+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%26gt%3Bpatrick-ian.cura%40hp.com%26lt%3B%2FValue%26gt%3B%26lt%3B%2FDictionaryEntry%26gt%3B%26lt%3BDictionaryEntry%26gt%3B%26lt%3BKey+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%26gt%3BDepartment%26lt%3B%2FKey%26gt%3B%26lt%3BValue+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%26gt%3BHEWLETT-PACKARD+CO+-+AP%26lt%3B%2FValue%26gt%3B%26lt%3B%2FDictionaryEntry%26gt%3B%26lt%3BDictionaryEntry%26gt%3B%26lt%3BKey+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%26gt%3BPrincipalType%26lt%3B%2FKey%26gt%3B%26lt%3BValue+xsi%3Atype%3D%26quot%3Bxsd%3Astring%26quot%3B%26gt%3BUser%26lt%3B%2FValue%26gt%3B%26lt%3B%2FDictionaryEntry%26gt%3B%26lt%3B%2FArrayOfDictionaryEntry%26gt%3B%27%3E%3C%2Fdiv%3E%3C%2Fdiv%3E%3Cspan+id%3D%27content%27+tabindex%3D%27-1%27+contenteditable%3D%27false%27++onmousedown%3D%27onMouseDownRw%28event%29%3B%27+onContextMenu%3D%27onContextMenuSpnRw%28event%2C%22ctl00_PlaceHolderMain_ctl00_ctl01_userPicker%22%29%3B%27+%3EPatrickIan+Cura+-+Non-Emp%3C%2Fspan%3E%3C%2Fspan%3E%3B+&__spText1=&__spText2
		");
		
		
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		echo $url.' - '.$http_status.'<br/>';
		
		//ERROR_HANDLING
		if ($output === false) {
			trigger_error('Failed to execute cURL session: ' . curl_error($ch), E_USER_ERROR);
		}
	
		$html = str_get_html($output);		
		
		echo $html;
		
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */