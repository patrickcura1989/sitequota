<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pgtube extends CI_Controller {

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
		$name = 'Patrick Ian E. Cura';
		$email = 'patrick-ian.cura@hp.com';
		
		echo "<br><br><br>";
		echo 'NAME: '.$name.'<br/>';
		echo 'EMAIL: '.$email.'<br/>';
		
		$this->load->view('header.php');
		
		$submitFRsPage = '
                                    <br>
                                    <p>FR Numbers Only</p>
                                    Sample Input: <br>
                                    FR03081904 <br>
                                    FR03081913 <br>
                                    <form id="submitFRsForm" method="post" target="_self">
                                                
                                                <p>
                                                            <textarea name="submitFRsArea" style="margin: 2px; width: 268px; height: 71px;"></textarea></p>
                                                <p>
                                                            <input name="submitFRsBtn" type="submit" class="btn"/></p>
                                    </form>
                                    
                                    <br>
                                    
                                    <p>FR Numbers and PGTube Links</p>
                                    Sample Input: <br>
                                    FR03233756 <br>
                                    http://pgtube.pg.com/pgtube/play.php?id=59043-a668e61a3ebfe1bd <br>
                                    http://pgtube.pg.com/pgtube/play.php?id=59316-093d4c9ab25ac388 <br>
                                    FR03233757 <br>
                                    http://pgtube.pg.com/pgtube/play.php?id=59043-a668e61a3ebfe1bd <br>
                                    <form id="submitFRsForm2" method="post" target="_self">
                                    
                                                <p>
                                                            <textarea name="submitFRsArea2" style="margin: 2px; width: 1000px; height: 150px;"></textarea></p>
                                                <p>
                                                            <input name="submitFRsBtn2" type="submit" class="btn"/></p>
                                    </form>
                        ';

		
		echo $submitFRsPage;
		
		if (isset($_POST["submitFRsArea"]))
		{				
			$token = strtok($_POST["submitFRsArea"], "\r\n");
			
			while ($token != false)
			{
				echo $token.'<br>';
				$this->runPGTubeFR($token);
				$token = strtok("\r\n");
				echo '<br>';
			} 			
		}
		else if(isset($_POST["submitFRsArea2"]))
		{
			$token = strtok($_POST["submitFRsArea2"], "\r\n");
			
			$frNumber = "";
			$prefix = "http://pgtube.pg.com/pgtube/resource/";
			
			while ($token != false)
			{
				if (substr($token, 0, 2) == 'FR')
				{
					echo '<br>';
					$frNumber = $token;
					echo $frNumber.'<br>';
				}
				else if(substr($token, 0, 40) == 'http://pgtube.pg.com/pgtube/play.php?id=')
				{											
					$dLink = $prefix . substr($token, 40, 22) . '.flv';
					echo $dLink.'<br>';
					$dLinks[] = $dLink;					
				}
				
				$token = strtok("\r\n");
				
				if (substr($token, 0, 2) == 'FR' || $token == false)
				{
					$this->emailPGTubeFR($frNumber,$dLinks);
					$dLinks = array();
				}
			} 
			
		}
	
	}
	public function runPGTubeFR($frNumber)
	{
		
		include_once "lib/simplehtmldom/simple_html_dom.php";
		
		$ch = curl_init();
		
		// Uncomment before sending to Adrian
		//$url = "http://automationscoe-dev1.itcs.hp.com/sitequota/index.php/nagger/api/".$frNumber;
		$url = "http://localhost/sitequota/index.php/nagger/api/".$frNumber;
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		//ERROR_HANDLING
		if ($output === false) {
			trigger_error('Failed to execute cURL session: ' . curl_error($ch), E_USER_ERROR);
		}
		
		$html = str_get_html($output);
		$spanArray = $html->find('td');
		
		echo $html;
		
		$data[] = trim(strip_tags($spanArray[0]));
		$data[] = trim(strip_tags($spanArray[1]));
		$data[] = trim(strip_tags($spanArray[2]));
		$data[] = trim(strip_tags($spanArray[3]));
		$data[] = trim(strip_tags($spanArray[4]));
		$data[] = trim(strip_tags($spanArray[5]));
		$data[] = trim(strip_tags($spanArray[6]));
		$data[] = trim(strip_tags($spanArray[7]));
		$data[] = trim(strip_tags($spanArray[8]));
		$data[] = trim(strip_tags($spanArray[9]));
		$data[] = trim(strip_tags($spanArray[10]));
		$data[] = trim(strip_tags($spanArray[11]));
		$data[] = trim(strip_tags($spanArray[12]));
		$data[] = trim(strip_tags($spanArray[13]));
		$data[] = trim(strip_tags($spanArray[14]));
		$data[] = trim(strip_tags($spanArray[15]));
		$data[] = trim(strip_tags($spanArray[16]));
		
		
		/* Index of data[] Guide
			0 - FR#
			1 - Category
			2 - Status
			3 - Title
			4 - Request Priority
			5 - Request Type
			6 - Service
			7 - Service Type
			8 - Configuration Item
			9 - Open Date
			10 - SLA
			11 - Closed Date
			12 - Assignment Group
			13 - Assignee
			14 - Closure Code
			15 - SLA %
			16 - description
			*/
			
			
		echo $data[16];
		
		$mystring = $data[16];
		$findme   = 'http://pgtube.pg.com/pgtube/play.php?id=';
		$pos = strpos($mystring, $findme);

		if ($pos === false) 
		{
			echo "<br>";
			echo 'The string '.$findme.' was not found in the string ';
		} 
		else 
		{
			echo "<br>";
			echo 'The string '.$findme.' was found in the string ';
			echo ' and exists at position '.$pos;
		}
		
		echo "<br>";
		
		$origURL = substr($data[16],$pos-1, 63);
		
		$prefix = "http://pgtube.pg.com/pgtube/resource/";

		$dLinks[] = $prefix . substr($origURL, 41, 22) . '.flv';		
		//echo $dLink;
		
		$this->emailPGTubeFR($data[0],$dLinks);
	}
	
	
	public function emailPGTubeFR($frNumber,$dLinks)
	{
		// Uncomment before sending to Adrian
		$name = $this->session->userdata('employeeName');
		$email = $this->session->userdata('email');
		
		// Comment out before sending to Adrian
		$name = 'Patrick Ian E. Cura';
		$email = 'patrick-ian.cura@hp.com';
		
		$currentDate = date("F j, Y g:i a T"); 
		
		$this->load->library('email');
		$config['protocol'] = 'smtp';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['smtp_host'] = 'smtp3.hp.com';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		$this->email->from('gdpc.webint.bea-l2@hp.com','PGTube Support');
		
		$this->email->to($email); 
		//$this->email->to($this->session->userdata('email')); 
		
		// Uncomment  before sending to Adrian
		//$this->email->cc('john-henry.mes.boco@hp.com, patrick-ian.cura@hp.com, xavier.atienzav@hp.com'); 
		
		$this->email->subject
		('[FULFILLED][SEAL2 Ops Fulfillment Request Management] '.$frNumber.': [Team Collab] PGTube - Request for Offline Copy of Video');
		
$headerPart1 = 
'<html xmlns:v=urn:schemas-microsoft-com:vml
xmlns:o=urn:schemas-microsoft-com:office:office
xmlns:w=urn:schemas-microsoft-com:office:word
xmlns:m=http://schemas.microsoft.com/office/2004/12/omml
xmlns=http://www.w3.org/TR/REC-html40>

<head>
<meta http-equiv=Content-Type content=text/html; charset=windows-1252>
<meta name=ProgId content=Word.Document>
<meta name=Generator content=Microsoft Word 14>
<meta name=Originator content=Microsoft Word 14>
<link rel=File-List href=New%20Microsoft%20Word%20Document_files/filelist.xml>
<link rel=Edit-Time-Data
href=New%20Microsoft%20Word%20Document_files/editdata.mso>
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
<link rel=themeData
href=New%20Microsoft%20Word%20Document_files/themedata.thmx>
<link rel=colorSchemeMapping
href=New%20Microsoft%20Word%20Document_files/colorschememapping.xml>
<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:SpellingState>Clean</w:SpellingState>
  <w:GrammarState>Clean</w:GrammarState>
  <w:TrackMoves>false</w:TrackMoves>
  <w:TrackFormatting/>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:DoNotPromoteQF/>
  <w:LidThemeOther>EN-US</w:LidThemeOther>
  <w:LidThemeAsian>X-NONE</w:LidThemeAsian>
  <w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>
  <w:Compatibility>
   <w:BreakWrappedTables/>
   <w:SplitPgBreakAndParaMark/>
  </w:Compatibility>
  <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>
  <m:mathPr>
   <m:mathFont m:val=Cambria Math/>
   <m:brkBin m:val=before/>
   <m:brkBinSub m:val=&#45;-/>
   <m:smallFrac m:val=off/>
   <m:dispDef/>
   <m:lMargin m:val=0/>
   <m:rMargin m:val=0/>
   <m:defJc m:val=centerGroup/>
   <m:wrapIndent m:val=1440/>
   <m:intLim m:val=subSup/>
   <m:naryLim m:val=undOvr/>
  </m:mathPr></w:WordDocument>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <w:LatentStyles DefLockedState=false DefUnhideWhenUsed=true
  DefSemiHidden=true DefQFormat=false DefPriority=99
  LatentStyleCount=267>
  <w:LsdException Locked=false Priority=0 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=Normal/>
  <w:LsdException Locked=false Priority=9 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=heading 1/>
  <w:LsdException Locked=false Priority=9 QFormat=true Name=heading 2/>
  <w:LsdException Locked=false Priority=9 QFormat=true Name=heading 3/>
  <w:LsdException Locked=false Priority=9 QFormat=true Name=heading 4/>
  <w:LsdException Locked=false Priority=9 QFormat=true Name=heading 5/>
  <w:LsdException Locked=false Priority=9 QFormat=true Name=heading 6/>
  <w:LsdException Locked=false Priority=9 QFormat=true Name=heading 7/>
  <w:LsdException Locked=false Priority=9 QFormat=true Name=heading 8/>
  <w:LsdException Locked=false Priority=9 QFormat=true Name=heading 9/>
  <w:LsdException Locked=false Priority=39 Name=toc 1/>
  <w:LsdException Locked=false Priority=39 Name=toc 2/>
  <w:LsdException Locked=false Priority=39 Name=toc 3/>
  <w:LsdException Locked=false Priority=39 Name=toc 4/>
  <w:LsdException Locked=false Priority=39 Name=toc 5/>
  <w:LsdException Locked=false Priority=39 Name=toc 6/>
  <w:LsdException Locked=false Priority=39 Name=toc 7/>
  <w:LsdException Locked=false Priority=39 Name=toc 8/>
  <w:LsdException Locked=false Priority=39 Name=toc 9/>
  <w:LsdException Locked=false Priority=35 QFormat=true Name=caption/>
  <w:LsdException Locked=false Priority=10 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=Title/>
  <w:LsdException Locked=false Priority=1 Name=Default Paragraph Font/>
  <w:LsdException Locked=false Priority=11 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=Subtitle/>
  <w:LsdException Locked=false Priority=22 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=Strong/>
  <w:LsdException Locked=false Priority=20 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=Emphasis/>
  <w:LsdException Locked=false Priority=59 SemiHidden=false
   UnhideWhenUsed=false Name=Table Grid/>
  <w:LsdException Locked=false UnhideWhenUsed=false Name=Placeholder Text/>
  <w:LsdException Locked=false Priority=1 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=No Spacing/>
  <w:LsdException Locked=false Priority=60 SemiHidden=false
   UnhideWhenUsed=false Name=Light Shading/>
  <w:LsdException Locked=false Priority=61 SemiHidden=false
   UnhideWhenUsed=false Name=Light List/>
  <w:LsdException Locked=false Priority=62 SemiHidden=false
   UnhideWhenUsed=false Name=Light Grid/>
  <w:LsdException Locked=false Priority=63 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 1/>
  <w:LsdException Locked=false Priority=64 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 2/>
  <w:LsdException Locked=false Priority=65 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 1/>
  <w:LsdException Locked=false Priority=66 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 2/>
  <w:LsdException Locked=false Priority=67 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 1/>
  <w:LsdException Locked=false Priority=68 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 2/>
  <w:LsdException Locked=false Priority=69 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 3/>
  <w:LsdException Locked=false Priority=70 SemiHidden=false
   UnhideWhenUsed=false Name=Dark List/>
  <w:LsdException Locked=false Priority=71 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Shading/>
  <w:LsdException Locked=false Priority=72 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful List/>
  <w:LsdException Locked=false Priority=73 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Grid/>
  <w:LsdException Locked=false Priority=60 SemiHidden=false
   UnhideWhenUsed=false Name=Light Shading Accent 1/>
  <w:LsdException Locked=false Priority=61 SemiHidden=false
   UnhideWhenUsed=false Name=Light List Accent 1/>
  <w:LsdException Locked=false Priority=62 SemiHidden=false
   UnhideWhenUsed=false Name=Light Grid Accent 1/>
  <w:LsdException Locked=false Priority=63 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 1 Accent 1/>
  <w:LsdException Locked=false Priority=64 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 2 Accent 1/>
  <w:LsdException Locked=false Priority=65 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 1 Accent 1/>
  <w:LsdException Locked=false UnhideWhenUsed=false Name=Revision/>
  <w:LsdException Locked=false Priority=34 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=List Paragraph/>
  <w:LsdException Locked=false Priority=29 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=Quote/>
  <w:LsdException Locked=false Priority=30 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=Intense Quote/>
  <w:LsdException Locked=false Priority=66 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 2 Accent 1/>
  <w:LsdException Locked=false Priority=67 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 1 Accent 1/>
  <w:LsdException Locked=false Priority=68 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 2 Accent 1/>
  <w:LsdException Locked=false Priority=69 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 3 Accent 1/>
  <w:LsdException Locked=false Priority=70 SemiHidden=false
   UnhideWhenUsed=false Name=Dark List Accent 1/>
  <w:LsdException Locked=false Priority=71 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Shading Accent 1/>
  <w:LsdException Locked=false Priority=72 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful List Accent 1/>
  <w:LsdException Locked=false Priority=73 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Grid Accent 1/>
  <w:LsdException Locked=false Priority=60 SemiHidden=false
   UnhideWhenUsed=false Name=Light Shading Accent 2/>
  <w:LsdException Locked=false Priority=61 SemiHidden=false
   UnhideWhenUsed=false Name=Light List Accent 2/>
  <w:LsdException Locked=false Priority=62 SemiHidden=false
   UnhideWhenUsed=false Name=Light Grid Accent 2/>
  <w:LsdException Locked=false Priority=63 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 1 Accent 2/>
  <w:LsdException Locked=false Priority=64 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 2 Accent 2/>
  <w:LsdException Locked=false Priority=65 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 1 Accent 2/>
  <w:LsdException Locked=false Priority=66 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 2 Accent 2/>
  <w:LsdException Locked=false Priority=67 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 1 Accent 2/>
  <w:LsdException Locked=false Priority=68 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 2 Accent 2/>
  <w:LsdException Locked=false Priority=69 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 3 Accent 2/>
  <w:LsdException Locked=false Priority=70 SemiHidden=false
   UnhideWhenUsed=false Name=Dark List Accent 2/>
  <w:LsdException Locked=false Priority=71 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Shading Accent 2/>
  <w:LsdException Locked=false Priority=72 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful List Accent 2/>
  <w:LsdException Locked=false Priority=73 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Grid Accent 2/>
  <w:LsdException Locked=false Priority=60 SemiHidden=false
   UnhideWhenUsed=false Name=Light Shading Accent 3/>
  <w:LsdException Locked=false Priority=61 SemiHidden=false
   UnhideWhenUsed=false Name=Light List Accent 3/>
  <w:LsdException Locked=false Priority=62 SemiHidden=false
   UnhideWhenUsed=false Name=Light Grid Accent 3/>
  <w:LsdException Locked=false Priority=63 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 1 Accent 3/>
  <w:LsdException Locked=false Priority=64 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 2 Accent 3/>
  <w:LsdException Locked=false Priority=65 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 1 Accent 3/>
  <w:LsdException Locked=false Priority=66 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 2 Accent 3/>
  <w:LsdException Locked=false Priority=67 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 1 Accent 3/>
  <w:LsdException Locked=false Priority=68 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 2 Accent 3/>
  <w:LsdException Locked=false Priority=69 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 3 Accent 3/>
  <w:LsdException Locked=false Priority=70 SemiHidden=false
   UnhideWhenUsed=false Name=Dark List Accent 3/>
  <w:LsdException Locked=false Priority=71 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Shading Accent 3/>
  <w:LsdException Locked=false Priority=72 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful List Accent 3/>
  <w:LsdException Locked=false Priority=73 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Grid Accent 3/>
  <w:LsdException Locked=false Priority=60 SemiHidden=false
   UnhideWhenUsed=false Name=Light Shading Accent 4/>
  <w:LsdException Locked=false Priority=61 SemiHidden=false
   UnhideWhenUsed=false Name=Light List Accent 4/>
  <w:LsdException Locked=false Priority=62 SemiHidden=false
   UnhideWhenUsed=false Name=Light Grid Accent 4/>
  <w:LsdException Locked=false Priority=63 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 1 Accent 4/>
  <w:LsdException Locked=false Priority=64 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 2 Accent 4/>
  <w:LsdException Locked=false Priority=65 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 1 Accent 4/>
  <w:LsdException Locked=false Priority=66 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 2 Accent 4/>
  <w:LsdException Locked=false Priority=67 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 1 Accent 4/>
  <w:LsdException Locked=false Priority=68 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 2 Accent 4/>
  <w:LsdException Locked=false Priority=69 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 3 Accent 4/>
  <w:LsdException Locked=false Priority=70 SemiHidden=false
   UnhideWhenUsed=false Name=Dark List Accent 4/>
  <w:LsdException Locked=false Priority=71 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Shading Accent 4/>
  <w:LsdException Locked=false Priority=72 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful List Accent 4/>
  <w:LsdException Locked=false Priority=73 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Grid Accent 4/>
  <w:LsdException Locked=false Priority=60 SemiHidden=false
   UnhideWhenUsed=false Name=Light Shading Accent 5/>
  <w:LsdException Locked=false Priority=61 SemiHidden=false
   UnhideWhenUsed=false Name=Light List Accent 5/>
  <w:LsdException Locked=false Priority=62 SemiHidden=false
   UnhideWhenUsed=false Name=Light Grid Accent 5/>
  <w:LsdException Locked=false Priority=63 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 1 Accent 5/>
  <w:LsdException Locked=false Priority=64 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 2 Accent 5/>
  <w:LsdException Locked=false Priority=65 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 1 Accent 5/>
  <w:LsdException Locked=false Priority=66 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 2 Accent 5/>
  <w:LsdException Locked=false Priority=67 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 1 Accent 5/>
  <w:LsdException Locked=false Priority=68 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 2 Accent 5/>
  <w:LsdException Locked=false Priority=69 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 3 Accent 5/>
  <w:LsdException Locked=false Priority=70 SemiHidden=false
   UnhideWhenUsed=false Name=Dark List Accent 5/>
  <w:LsdException Locked=false Priority=71 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Shading Accent 5/>
  <w:LsdException Locked=false Priority=72 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful List Accent 5/>
  <w:LsdException Locked=false Priority=73 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Grid Accent 5/>
  <w:LsdException Locked=false Priority=60 SemiHidden=false
   UnhideWhenUsed=false Name=Light Shading Accent 6/>
  <w:LsdException Locked=false Priority=61 SemiHidden=false
   UnhideWhenUsed=false Name=Light List Accent 6/>
  <w:LsdException Locked=false Priority=62 SemiHidden=false
   UnhideWhenUsed=false Name=Light Grid Accent 6/>
  <w:LsdException Locked=false Priority=63 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 1 Accent 6/>
  <w:LsdException Locked=false Priority=64 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Shading 2 Accent 6/>
  <w:LsdException Locked=false Priority=65 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 1 Accent 6/>
  <w:LsdException Locked=false Priority=66 SemiHidden=false
   UnhideWhenUsed=false Name=Medium List 2 Accent 6/>
  <w:LsdException Locked=false Priority=67 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 1 Accent 6/>
  <w:LsdException Locked=false Priority=68 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 2 Accent 6/>
  <w:LsdException Locked=false Priority=69 SemiHidden=false
   UnhideWhenUsed=false Name=Medium Grid 3 Accent 6/>
  <w:LsdException Locked=false Priority=70 SemiHidden=false
   UnhideWhenUsed=false Name=Dark List Accent 6/>
  <w:LsdException Locked=false Priority=71 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Shading Accent 6/>
  <w:LsdException Locked=false Priority=72 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful List Accent 6/>
  <w:LsdException Locked=false Priority=73 SemiHidden=false
   UnhideWhenUsed=false Name=Colorful Grid Accent 6/>
  <w:LsdException Locked=false Priority=19 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=Subtle Emphasis/>
  <w:LsdException Locked=false Priority=21 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=Intense Emphasis/>
  <w:LsdException Locked=false Priority=31 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=Subtle Reference/>
  <w:LsdException Locked=false Priority=32 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=Intense Reference/>
  <w:LsdException Locked=false Priority=33 SemiHidden=false
   UnhideWhenUsed=false QFormat=true Name=Book Title/>
  <w:LsdException Locked=false Priority=37 Name=Bibliography/>
  <w:LsdException Locked=false Priority=39 QFormat=true Name=TOC Heading/>
 </w:LatentStyles>
</xml><![endif]-->
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-536870145 1073786111 1 0 415 0;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-520081665 -1073717157 41 0 66047 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:;
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	font-family:Calibri,sans-serif;
	mso-fareast-font-family:Times New Roman;
	mso-fareast-theme-font:minor-fareast;
	mso-bidi-font-family:Times New Roman;}
a:link, span.MsoHyperlink
	{mso-style-noshow:yes;
	mso-style-priority:99;
	color:blue;
	text-decoration:underline;
	text-underline:single;}
a:visited, span.MsoHyperlinkFollowed
	{mso-style-noshow:yes;
	mso-style-priority:99;
	color:purple;
	text-decoration:underline;
	text-underline:single;}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-link:Balloon Text Char;
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:8.0pt;
	font-family:Tahoma,sans-serif;
	mso-fareast-font-family:Times New Roman;
	mso-fareast-theme-font:minor-fareast;}
span.BalloonTextChar
	{mso-style-name:Balloon Text Char;
	mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-link:Balloon Text;
	font-family:Tahoma,sans-serif;
	mso-ascii-font-family:Tahoma;
	mso-hansi-font-family:Tahoma;
	mso-bidi-font-family:Tahoma;}
p.msochpdefault, li.msochpdefault, div.msochpdefault
	{mso-style-name:msochpdefault;
	mso-style-unhide:no;
	mso-margin-top-alt:auto;
	margin-right:0in;
	mso-margin-bottom-alt:auto;
	margin-left:0in;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:Calibri,sans-serif;
	mso-fareast-font-family:Times New Roman;
	mso-fareast-theme-font:minor-fareast;
	mso-bidi-font-family:Times New Roman;}
span.SpellE
	{mso-style-name:;
	mso-spl-e:yes;}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	font-size:10.0pt;
	mso-ansi-font-size:10.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:Calibri,sans-serif;
	mso-ascii-font-family:Calibri;
	mso-hansi-font-family:Calibri;}
@page WordSection1
	{size:8.5in 11.0in;
	margin:1.0in 1.0in 1.0in 1.0in;
	mso-header-margin:.5in;
	mso-footer-margin:.5in;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
-->
</style>
<!--[if gte mso 10]>
<style>
 /* Style Definitions */
 table.MsoNormalTable
	{mso-style-name:Table Normal;
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-parent:;
	mso-padding-alt:0in 5.4pt 0in 5.4pt;
	mso-para-margin:0in;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:Calibri,sans-serif;}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext=edit spidmax=1027/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext=edit>
  <o:idmap v:ext=edit data=1/>
 </o:shapelayout></xml><![endif]-->
</head>

<body lang=EN-US link=blue vlink=purple style="tab-interval:.5in">

<div class=WordSection1>

<p class=MsoNormal><o:p>&nbsp;</o:p></p>

<p class=MsoNormal><o:p>&nbsp;</o:p></p>

<p class=MsoNormal><o:p>&nbsp;</o:p></p>

<div align=center>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
 style="border-collapse:collapse;mso-yfti-tbllook:1184;mso-padding-alt:0in 0in 0in 0in">
 <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
  <td width=855 colspan=2 valign=top style="width:640.9pt;padding:0in 5.4pt 0in 5.4pt">
  <p class=MsoNormal><b><span style="font-size:22.0pt;font-family:Arial,sans-serif;
  color:#0099FF">SEAL2 Operations Team </span></b><b><span style="font-size:22.0pt;
  font-family:Arial,sans-serif;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
  minor-latin;color:#0099FF"><o:p></o:p></span></b></p>
  <p class=MsoNormal><b><span style="font-size:22.0pt;font-family:Arial,sans-serif;
  color:#0099FF">Fulfillment Request Management<o:p></o:p></span></b></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif"><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif;
  color:black"><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><b><span style="font-size:10.0pt;font-family:Arial,sans-serif;
  color:black">';

  
  
$headerPart2 = 
  '<o:p></o:p></span></b></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif;
  color:black"><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif;
  color:black">Hi,<o:p></o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif"><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif">Your
  request has been fulfilled. Please find the details below.<o:p></o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif"><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><i><span style="font-size:10.0pt;font-family:Arial,sans-serif">Kindly
  respond to this email as soon as possible within <b><u>24 hours</u></b> since
  this communication was sent. If we have not received any notification by the
  said timeline, the change will be considered validated and the fulfillment
  request will be considered closed<o:p></o:p></span></i></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif;
  mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin"><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=158 colspan=2 valign=top style="width:1.65in;padding:0in 5.4pt 0in 5.4pt">
  <p class=MsoNormal align=right style="text-align:right"><span
  style="font-size:10.0pt;font-family:Arial,sans-serif;mso-no-proof:yes"><!--[if gte vml 1]><v:shapetype
   id=_x0000_t75 coordsize=21600,21600 o:spt=75 o:preferrelative=t
   path=m@4@5l@4@11@9@11@9@5xe filled=f stroked=f>
   <v:stroke joinstyle=miter/>
   <v:formulas>
    <v:f eqn=if lineDrawn pixelLineWidth 0/>
    <v:f eqn=sum @0 1 0/>
    <v:f eqn=sum 0 0 @1/>
    <v:f eqn=prod @2 1 2/>
    <v:f eqn=prod @3 21600 pixelWidth/>
    <v:f eqn=prod @3 21600 pixelHeight/>
    <v:f eqn=sum @0 0 1/>
    <v:f eqn=prod @6 1 2/>
    <v:f eqn=prod @7 21600 pixelWidth/>
    <v:f eqn=sum @8 21600 0/>
    <v:f eqn=prod @7 21600 pixelHeight/>
    <v:f eqn=sum @10 21600 0/>
   </v:formulas>
   <v:path o:extrusionok=f gradientshapeok=t o:connecttype=rect/>
   <o:lock v:ext=edit aspectratio=t/>
  </v:shapetype><v:shape id=_x0000_i1025 type=#_x0000_t75 style="width:108pt;
   height:59.25pt;visibility:visible">
   <a href=http://tinypic.com?ref=2911bnq target=_blank><img src=http://i62.tinypic.com/2911bnq.jpg border=0 alt=Image and video hosting by TinyPic></a>
  </v:shape><![endif]--><![if !vml]><![endif]></span><span
  style="font-size:10.0pt;font-family:Arial,sans-serif;mso-fareast-font-family:
  Calibri;mso-fareast-theme-font:minor-latin"><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:1;mso-row-margin-right:55.5pt">
  <td width=173 valign=top style="width:130.0pt;border:solid #D9D9D9 1.0pt;
  background:#0099FF;padding:5.75pt 5.75pt 5.75pt 5.75pt">
  <p class=MsoNormal align=right style="text-align:right"><b><span
  style="font-size:10.0pt;font-family:Arial,sans-serif;color:white">Request
  Ticket ID:</span></b><b><span style="font-size:10.0pt;font-family:Arial,sans-serif;
  mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
  color:white"><o:p></o:p></span></b></p>
  </td>
  <td width=766 colspan=2 valign=top style="width:574.65pt;border:solid #D9D9D9 1.0pt;
  border-left:none;padding:5.75pt 5.75pt 5.75pt 5.75pt">
  <p class=MsoNormal><b><span style="font-size:10.0pt;font-family:Arial,sans-serif;
  color:black">';
  
  
  
$headerPart3 =
  '</span></b><b><span style="font-size:10.0pt;
  font-family:Arial,sans-serif;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
  minor-latin;color:#1F497D"><o:p></o:p></span></b></p>
  </td>
  <td style="mso-cell-special:placeholder;border:none;padding:0in 0in 0in 0in"
  width=74><p class="MsoNormal">&nbsp;</td>
 </tr>
 <tr style="mso-yfti-irow:2;mso-row-margin-right:55.5pt">
  <td width=173 valign=top style="width:130.0pt;border:solid #D9D9D9 1.0pt;
  border-top:none;background:#0099FF;padding:5.75pt 5.75pt 5.75pt 5.75pt">
  <p class=MsoNormal align=right style="text-align:right"><b><span
  style="font-size:10.0pt;font-family:Arial,sans-serif;color:white">Application
  Name:</span></b><b><span style="font-size:10.0pt;font-family:Arial,sans-serif;
  mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
  color:white"><o:p></o:p></span></b></p>
  </td>
  <td width=766 colspan=2 valign=top style="width:574.65pt;border-top:none;
  border-left:none;border-bottom:solid #D9D9D9 1.0pt;border-right:solid #D9D9D9 1.0pt;
  padding:5.75pt 5.75pt 5.75pt 5.75pt">
  <p class=MsoNormal><span class=SpellE><b><span style="font-size:10.0pt;
  font-family:Arial,sans-serif">PGTube</span></b></span><b><span
  style="font-size:10.0pt;font-family:Arial,sans-serif;mso-fareast-font-family:
  Calibri;mso-fareast-theme-font:minor-latin"><o:p></o:p></span></b></p>
  </td>
  <td style="mso-cell-special:placeholder;border:none;padding:0in 0in 0in 0in"
  width=74><p class="MsoNormal">&nbsp;</td>
 </tr>
 <tr style="mso-yfti-irow:3;mso-row-margin-right:55.5pt">
  <td width=173 valign=top style="width:130.0pt;border:solid #D9D9D9 1.0pt;
  border-top:none;background:#0099FF;padding:5.75pt 5.75pt 5.75pt 5.75pt">
  <p class=MsoNormal align=right style="text-align:right"><b><span
  style="font-size:10.0pt;font-family:Arial,sans-serif;color:white">Request
  Details:</span></b><b><span style="font-size:10.0pt;font-family:Arial,sans-serif;
  mso-fareast-font-family:Calibri;mso-fareast-theme-font:minor-latin;
  color:white"><o:p></o:p></span></b></p>
  </td>
  <td width=766 colspan=2 valign=top style="width:574.65pt;border-top:none;
  border-left:none;border-bottom:solid #D9D9D9 1.0pt;border-right:solid #D9D9D9 1.0pt;
  padding:5.75pt 5.75pt 5.75pt 5.75pt">
  <p class=MsoNormal>You can download the FLV format of the video from this
  link:<span style="mso-fareast-font-family:Calibri;mso-fareast-theme-font:
  minor-latin"><o:p></o:p></span></p>';

  $dLinksEmail = '';
  
  for ($i = 0; $i < count($dLinks); $i++)
  {
    $dLinksEmail .= '<p class=MsoNormal><span style="color:#1F497D"><a href='
    .$dLinks[$i].'>'.$dLinks[$i].
    '</a><o:p></o:p></span></p>';
  }
  
 
$headerPart4 =
  '<p class=MsoNormal><span style="color:#1F497D"><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal>In order to play the video, please use VLC Media Player or
  have the file converted to a compatible format.<o:p></o:p></p>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  <p class=MsoNormal>Please inform us if you have further inquiries, else we
  will proceed to close the ticket.<o:p></o:p></p>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  <p class=MsoNormal>Thank you.<span style="mso-fareast-font-family:Calibri;
  mso-fareast-theme-font:minor-latin"><o:p></o:p></span></p>
  </td>
  <td style="mso-cell-special:placeholder;border:none;padding:0in 0in 0in 0in"
  width=74><p class="MsoNormal">&nbsp;</td>
 </tr>
 <tr style="mso-yfti-irow:4;mso-row-margin-right:55.5pt">
  <td width=940 colspan=3 valign=top style="width:704.65pt;border:solid #D9D9D9 1.0pt;
  border-top:none;background:white;padding:5.75pt 5.75pt 5.75pt 5.75pt">
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif">Kindly
  confirm if there are still actions needed to be done by the SEAL2 Ops Team for
  this request, or if we can already have the ticket closed for you. You can
  contact us thru MS Communicator&nbsp;SEAL2, ION account (<a
  href=mailto:seal2ops.im@pg.com>seal2ops.im@pg.com</a>) or you can send us an email
  thru SEAL2 Operations (<a href=mailto:gdpc.webint.bea-l2@hp.com>gdpc.webint.bea-l2@hp.com</a>).</span><span
  style="font-size:10.0pt;font-family:Arial,sans-serif;mso-fareast-font-family:
  Calibri;mso-fareast-theme-font:minor-latin"><o:p></o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif"><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif">Thank
  you and have a nice day!<o:p></o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif"><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif"><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif"><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif">Regards,<o:p></o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif"><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal style="margin-left:60.2pt"><!--[if gte vml 1]><v:shape
   id=Picture_x0020_4 o:spid=_x0000_s1026 type=#_x0000_t75 alt=Description: Description: Description: Description: Description: Description: Description: Description: Description: Description: Description: Description: Description: Description: Description: Description: Description: Description: Description: HP_S_K_RGB_150_SM.png
   style="position:absolute;left:0;text-align:left;
   margin-top:4.15pt;width:35pt;height:37.5pt;z-index:251658240;visibility:visible;
   mso-wrap-style:square;mso-width-percent:0;mso-height-percent:0;
   mso-wrap-distance-top:0;
   mso-wrap-distance-right:12pt;mso-wrap-distance-bottom:0;
   mso-position-horizontal:absolute;mso-position-horizontal-relative:text;
   mso-position-vertical:absolute;mso-position-vertical-relative:line;
   mso-width-percent:0;mso-height-percent:0;mso-width-relative:page;
   mso-height-relative:page" o:allowoverlap=f>
   <a href="http://tinypic.com?ref=9k1bi0" target="_blank"><img src="http://i59.tinypic.com/9k1bi0.png" border="0" alt="Image and video hosting by TinyPic"></a>
   <w:wrap anchory=line/>
  </v:shape><![endif]--><![if !vml]><span style="mso-ignore:vglayout;
  position:absolute;z-index:251658240;left:0px;margin-left:10px;margin-top:6px;
  width:52px;height:50px"></span><![endif]><span class=SpellE><b><span
  style="font-family:Arial,sans-serif;color:black;letter-spacing:1.0pt">';
  
  
  
$headerPart5 =  
  '</span></b></span><b><span style="font-family:Arial,sans-serif;
  color:#1F497D;letter-spacing:1.0pt"><o:p></o:p></span></b></p>
  <p class=MsoNormal style="margin-left:60.2pt"><b><span style="font-family:
  Arial,sans-serif;letter-spacing:1.0pt">SEAL2 Operations Team</span></b><b><span
  style="font-size:12.0pt;font-family:Arial,sans-serif;letter-spacing:1.0pt"><o:p></o:p></span></b></p>
  <p class=MsoNormal style="margin-left:60.2pt"><span style="font-size:8.0pt;
  font-family:Arial,sans-serif">Web Front-end Application Support Team (<span
  class=SpellE>WebFAST</span>)
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp; <span style="color:#1F497D">| </span><span
  style="color:black">Email : </span><u><span style="color:#0070C0"><a
  href=mailto:';
  
  
  
$headerPart6 =  
  '</a></span></u><span
  style="color:black"> / <a href=mailto:gdpc.webint.bea-l2@hp.com>gdpc.webint.bea-l2@hp.com</a></span><span
  style="color:#1F497D"><br>
  </span>Application Services Global Delivery Philippines (ASGD PH<span
  style="color:black">)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
  style="color:#1F497D">| </span><span style="color:black">Lync : SEAL2OPS ION [<a
  href=mailto:seal2ops.im@pg.com>seal2ops.im@pg.com</a>]<o:p></o:p></span></span></p>
  <p class=MsoNormal style="margin-left:60.2pt"><span style="font-size:8.0pt;
  font-family:Arial,sans-serif">Hewlett-Packard Company</span><span
  style="font-size:10.0pt;font-family:Arial,sans-serif;mso-fareast-font-family:
  Calibri;mso-fareast-theme-font:minor-latin"><o:p></o:p></span></p>
  </td>
  <td style="mso-cell-special:placeholder;border:none;padding:0in 0in 0in 0in"
  width=74><p class="MsoNormal">&nbsp;</td>
 </tr>
 <tr style="mso-yfti-irow:5;mso-yfti-lastrow:yes;mso-row-margin-right:55.5pt">
  <td width=940 colspan=3 valign=top style="width:704.65pt;border:solid #D9D9D9 1.0pt;
  border-top:none;background:white;padding:5.75pt 5.75pt 5.75pt 5.75pt">
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:Arial,sans-serif">The
  information transmitted is intended solely for the individual or entity to
  which it is addressed and may contain Hewlett Packard Company confidential
  and/or privileged material. Any review, retransmission, dissemination or
  other use of or taking action in reliance upon this information by persons or
  entities other than the intended recipient is prohibited. If you have
  received this email in error please contact the sender and delete the
  material from any computer.</span><span style="font-size:10.0pt;font-family:
  Arial,sans-serif;mso-fareast-font-family:Calibri;mso-fareast-theme-font:
  minor-latin"><o:p></o:p></span></p>
  </td>
  <td style="mso-cell-special:placeholder;border:none;padding:0in 0in 0in 0in"
  width=74><p class="MsoNormal">&nbsp;</td>
 </tr>
 <![if !supportMisalignedColumns]>
 <tr height=0>
  <td width=149 style="border:none"></td>
  <td width=441 style="border:none"></td>
  <td width=85 style="border:none"></td>
  <td width=74 style="border:none"></td>
 </tr>
 <![endif]>
</table>

</div>

<p class=MsoNormal><o:p>&nbsp;</o:p></p>

</div>

</body>

</html>';

		$this->email->message
		(
		$headerPart1
		.$currentDate.
		$headerPart2
		.$frNumber.
		$headerPart3
		.$dLinksEmail.
		$headerPart4
		.$name.
		$headerPart5
		.$email.'>'.$email.
		$headerPart6
		);
		
		$this->email->send();
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>