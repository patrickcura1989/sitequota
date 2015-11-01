<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class siteQuotaSender extends CI_Controller {

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
			
			<p>Site Quota Sender</p>
			Sample Input: <br>
			&nbsp;&nbsp;&nbsp;&nbsp; FR Number: patrick-ian.cura@hp.com <br>
			&nbsp;&nbsp;&nbsp;&nbsp; CCSW URL: http://dcsp.pg.com/bu/GBSBCS/GBS_BCS_CS_LT_TC <br>
			&nbsp;&nbsp;&nbsp;&nbsp; Users whose permissions will be checked: <br>
			&nbsp;&nbsp;&nbsp;&nbsp; abrell.v@pg.com <br>
			&nbsp;&nbsp;&nbsp;&nbsp; acquaah.ma@pg.com <br>
			&nbsp;&nbsp;&nbsp;&nbsp; butler.tc@pg.com <br>

			<form id="submitForm" method="post" target="_self">
				<br>
				FR Number: <input type="text" name="frNumber"><br>
				CCSW URL:  <input type="text" name="url"> <br>
				Users whose permissions will be checked: <br>
				<textarea name="usersArea" style="margin: 2px; width: 500px; height: 150px;"></textarea> <br>
				<input name="checkPermBtn" type="submit" class="btn"/>
			</form>
		';
		
		echo $checkPermPage;
		
		if ( isset($_POST["url"]) )
		{				
			$body = '

<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 14">
<meta name=Originator content="Microsoft Word 14">
<link rel=File-List href="SEAL2%20Operations%20Team_files/filelist.xml">
<link rel=Edit-Time-Data href="SEAL2%20Operations%20Team_files/editdata.mso">
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>Patrick Ian E Cura</o:Author>
  <o:LastAuthor>Patrick Ian E Cura</o:LastAuthor>
  <o:Revision>2</o:Revision>
  <o:TotalTime>1</o:TotalTime>
  <o:Created>2014-10-17T22:45:00Z</o:Created>
  <o:LastSaved>2014-10-17T22:45:00Z</o:LastSaved>
  <o:Pages>1</o:Pages>
  <o:Words>276</o:Words>
  <o:Characters>1575</o:Characters>
  <o:Company>HP</o:Company>
  <o:Lines>13</o:Lines>
  <o:Paragraphs>3</o:Paragraphs>
  <o:CharactersWithSpaces>1848</o:CharactersWithSpaces>
  <o:Version>14.00</o:Version>
 </o:DocumentProperties>
</xml><![endif]-->
<link rel=themeData href="SEAL2%20Operations%20Team_files/themedata.thmx">
<link rel=colorSchemeMapping
href="SEAL2%20Operations%20Team_files/colorschememapping.xml">
<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:SpellingState>Clean</w:SpellingState>
  <w:GrammarState>Clean</w:GrammarState>
  <w:TrackMoves>false</w:TrackMoves>
  <w:TrackFormatting/>
  <w:PunctuationKerning/>
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
   <w:SnapToGridInCell/>
   <w:WrapTextWithPunct/>
   <w:UseAsianBreakRules/>
   <w:DontGrowAutofit/>
   <w:SplitPgBreakAndParaMark/>
   <w:EnableOpenTypeKerning/>
   <w:DontFlipMirrorIndents/>
   <w:OverrideTableStyleHps/>
  </w:Compatibility>
  <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>
  <m:mathPr>
   <m:mathFont m:val="Cambria Math"/>
   <m:brkBin m:val="before"/>
   <m:brkBinSub m:val="&#45;-"/>
   <m:smallFrac m:val="off"/>
   <m:dispDef/>
   <m:lMargin m:val="0"/>
   <m:rMargin m:val="0"/>
   <m:defJc m:val="centerGroup"/>
   <m:wrapIndent m:val="1440"/>
   <m:intLim m:val="subSup"/>
   <m:naryLim m:val="undOvr"/>
  </m:mathPr></w:WordDocument>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="true"
  DefSemiHidden="true" DefQFormat="false" DefPriority="99"
  LatentStyleCount="267">
  <w:LsdException Locked="false" Priority="0" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Normal"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="heading 1"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 2"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 3"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 4"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 5"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 6"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 7"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 8"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 9"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 1"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 2"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 3"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 4"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 5"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 6"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 7"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 8"/>
  <w:LsdException Locked="false" Priority="39" Name="toc 9"/>
  <w:LsdException Locked="false" Priority="35" QFormat="true" Name="caption"/>
  <w:LsdException Locked="false" Priority="10" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Title"/>
  <w:LsdException Locked="false" Priority="1" Name="Default Paragraph Font"/>
  <w:LsdException Locked="false" Priority="11" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Subtitle"/>
  <w:LsdException Locked="false" Priority="22" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Strong"/>
  <w:LsdException Locked="false" Priority="20" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Emphasis"/>
  <w:LsdException Locked="false" Priority="59" SemiHidden="false"
   UnhideWhenUsed="false" Name="Table Grid"/>
  <w:LsdException Locked="false" UnhideWhenUsed="false" Name="Placeholder Text"/>
  <w:LsdException Locked="false" Priority="1" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="No Spacing"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading Accent 1"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List Accent 1"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid Accent 1"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1 Accent 1"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1 Accent 1"/>
  <w:LsdException Locked="false" UnhideWhenUsed="false" Name="Revision"/>
  <w:LsdException Locked="false" Priority="34" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="List Paragraph"/>
  <w:LsdException Locked="false" Priority="29" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Quote"/>
  <w:LsdException Locked="false" Priority="30" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Intense Quote"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1 Accent 1"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3 Accent 1"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List Accent 1"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading Accent 1"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List Accent 1"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid Accent 1"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading Accent 2"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List Accent 2"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid Accent 2"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3 Accent 2"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List Accent 2"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading Accent 2"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List Accent 2"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid Accent 2"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading Accent 3"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List Accent 3"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid Accent 3"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3 Accent 3"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List Accent 3"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading Accent 3"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List Accent 3"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid Accent 3"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading Accent 4"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List Accent 4"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid Accent 4"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3 Accent 4"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List Accent 4"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading Accent 4"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List Accent 4"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid Accent 4"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading Accent 5"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List Accent 5"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid Accent 5"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3 Accent 5"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List Accent 5"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading Accent 5"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List Accent 5"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid Accent 5"/>
  <w:LsdException Locked="false" Priority="60" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Shading Accent 6"/>
  <w:LsdException Locked="false" Priority="61" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light List Accent 6"/>
  <w:LsdException Locked="false" Priority="62" SemiHidden="false"
   UnhideWhenUsed="false" Name="Light Grid Accent 6"/>
  <w:LsdException Locked="false" Priority="63" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="64" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Shading 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="65" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="66" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium List 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="67" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="68" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="69" SemiHidden="false"
   UnhideWhenUsed="false" Name="Medium Grid 3 Accent 6"/>
  <w:LsdException Locked="false" Priority="70" SemiHidden="false"
   UnhideWhenUsed="false" Name="Dark List Accent 6"/>
  <w:LsdException Locked="false" Priority="71" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Shading Accent 6"/>
  <w:LsdException Locked="false" Priority="72" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful List Accent 6"/>
  <w:LsdException Locked="false" Priority="73" SemiHidden="false"
   UnhideWhenUsed="false" Name="Colorful Grid Accent 6"/>
  <w:LsdException Locked="false" Priority="19" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Subtle Emphasis"/>
  <w:LsdException Locked="false" Priority="21" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Intense Emphasis"/>
  <w:LsdException Locked="false" Priority="31" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Subtle Reference"/>
  <w:LsdException Locked="false" Priority="32" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Intense Reference"/>
  <w:LsdException Locked="false" Priority="33" SemiHidden="false"
   UnhideWhenUsed="false" QFormat="true" Name="Book Title"/>
  <w:LsdException Locked="false" Priority="37" Name="Bibliography"/>
  <w:LsdException Locked="false" Priority="39" QFormat="true" Name="TOC Heading"/>
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
	mso-style-parent:"";
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-fareast-language:KO;}
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
	mso-themecolor:followedhyperlink;
	text-decoration:underline;
	text-underline:single;}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-link:"Balloon Text Char";
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-fareast-language:KO;}
span.BalloonTextChar
	{mso-style-name:"Balloon Text Char";
	mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-link:"Balloon Text";
	mso-ansi-font-size:8.0pt;
	mso-bidi-font-size:8.0pt;
	font-family:"Tahoma","sans-serif";
	mso-ascii-font-family:Tahoma;
	mso-hansi-font-family:Tahoma;
	mso-bidi-font-family:Tahoma;
	mso-fareast-language:KO;}
span.SpellE
	{mso-style-name:"";
	mso-spl-e:yes;}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	font-size:10.0pt;
	mso-ansi-font-size:10.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri","sans-serif";
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;}
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
	{mso-style-name:"Table Normal";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-parent:"";
	mso-padding-alt:0in 5.4pt 0in 5.4pt;
	mso-para-margin:0in;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Calibri","sans-serif";
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext="edit" spidmax="1026"/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
</head>

<body lang=EN-US link=blue vlink=purple style="tab-interval:.5in">

<div class=WordSection1>

<p class=MsoNormal><o:p>&nbsp;</o:p></p>

<p class=MsoNormal><span style="font-size:10.0pt;font-family:"Arial","sans-serif""><o:p>&nbsp;</o:p></span></p>

<div align=center>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=864
 style="width:9.0in;border-collapse:collapse;mso-yfti-tbllook:1184;mso-padding-alt:
 0in 0in 0in 0in">
 <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes">
  <td width=432 valign=top style="width:4.5in;padding:0in 5.4pt 0in 5.4pt">
  <p class=MsoNormal><b><span style="font-size:20.0pt;font-family:"Arial","sans-serif";
  color:#00B0F0">SEAL2 Operations Team <o:p></o:p></span></b></p>
  <p class=MsoNormal><b><span style="font-size:20.0pt;font-family:"Arial","sans-serif";
  color:#00B0F0">Approaching SharePoint Web site storage limit<o:p></o:p></span></b></p>
  <p class=MsoNormal><b><span style="font-size:10.0pt;font-family:"Arial","sans-serif";
  color:#0099FF"><o:p>&nbsp;</o:p></span></b></p>
  <p class=MsoNormal><b><span style="font-size:10.0pt;font-family:"Arial","sans-serif";
  color:#0099FF"><o:p>&nbsp;</o:p></span></b></p>
  <p class=MsoNormal><b><span style="font-size:10.0pt;font-family:"Arial","sans-serif"">October
  18, 2014 5:2<span style="color:black">6</span> PM EST<o:p></o:p></span></b></p>
  </td>
  <td width=432 valign=top style="width:4.5in;padding:0in 5.4pt 0in 5.4pt">
  <p class=MsoNormal align=right style="text-align:right"><span
  style="font-size:10.0pt;font-family:"Arial","sans-serif";mso-fareast-language:
  EN-US;mso-no-proof:yes"><!--[if gte vml 1]><v:shapetype id="_x0000_t75"
   coordsize="21600,21600" o:spt="75" o:preferrelative="t" path="m@4@5l@4@11@9@11@9@5xe"
   filled="f" stroked="f">
   <v:stroke joinstyle="miter"/>
   <v:formulas>
    <v:f eqn="if lineDrawn pixelLineWidth 0"/>
    <v:f eqn="sum @0 1 0"/>
    <v:f eqn="sum 0 0 @1"/>
    <v:f eqn="prod @2 1 2"/>
    <v:f eqn="prod @3 21600 pixelWidth"/>
    <v:f eqn="prod @3 21600 pixelHeight"/>
    <v:f eqn="sum @0 0 1"/>
    <v:f eqn="prod @6 1 2"/>
    <v:f eqn="prod @7 21600 pixelWidth"/>
    <v:f eqn="sum @8 21600 0"/>
    <v:f eqn="prod @7 21600 pixelHeight"/>
    <v:f eqn="sum @10 21600 0"/>
   </v:formulas>
   <v:path o:extrusionok="f" gradientshapeok="t" o:connecttype="rect"/>
   <o:lock v:ext="edit" aspectratio="t"/>
  </v:shapetype><v:shape id="_x0000_i1026" type="#_x0000_t75" style="width:108pt;
   height:59.25pt;visibility:visible">
   <v:imagedata src="SEAL2%20Operations%20Team_files/image001.jpg" o:href="cid:image003.jpg@01CE4D00.A4AF1740"/>
  </v:shape><![endif]--><![if !vml]><img width=144 height=79
  src="SEAL2%20Operations%20Team_files/image001.jpg" v:shapes="_x0000_i1026"><![endif]></span><span
  style="font-size:10.0pt;font-family:"Arial","sans-serif""><o:p></o:p></span></p>
  </td>
 </tr>
</table>

</div>

<p class=MsoNormal align=center style="text-align:center"><span
style="font-size:10.0pt;font-family:"Arial","sans-serif""><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><span style="font-size:10.0pt;font-family:"Arial","sans-serif""><o:p>&nbsp;</o:p></span></p>

<div align=center>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
 style="border-collapse:collapse;mso-yfti-tbllook:1184;mso-padding-alt:0in 0in 0in 0in">
 <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
  <td width=864 colspan=2 valign=top style="width:9.0in;border:none;border-bottom:
  solid #D9D9D9 1.0pt;padding:0in 5.4pt 0in 5.4pt"></td>
 </tr>
 <tr style="mso-yfti-irow:1">
  <td width=192 valign=top style="width:2.0in;border:solid #D9D9D9 1.0pt;
  border-top:none;background:#0099FF;padding:0in 5.4pt 0in 5.4pt">
  <p class=MsoNormal align=right style="text-align:right"><b><span
  style="font-size:10.0pt;font-family:"Arial","sans-serif";color:white">MESSAGE<o:p></o:p></span></b></p>
  </td>
  <td width=672 valign=top style="width:7.0in;border-top:none;border-left:none;
  border-bottom:solid #D9D9D9 1.0pt;border-right:solid #D9D9D9 1.0pt;
  background:white;padding:0in 5.4pt 0in 5.4pt">
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:"Arial","sans-serif"">Hi
  <span class=SpellE><b>Ayan</b></span>,<o:p></o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:"Arial","sans-serif""><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:"Arial","sans-serif"">Good
  day! The following SharePoint Web site has exceeded the warning level for
  storage: <o:p></o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:"Arial","sans-serif""><a
  href="http://dcsp.pg.com/bu/italymdo/Pages/default.aspx">http://dcsp.pg.com/bu/italymdo/Pages/default.aspx</a><o:p></o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:"Arial","sans-serif""><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:"Arial","sans-serif"">The
  admin recycle bin of the site has been emptied to free up additional space,
  but the free site quota is still less <b>5 GB</b>.<o:p></o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:"Arial","sans-serif""><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:"Arial","sans-serif"">Please
  be informed that the storage would be extended by <b>5 GB</b> (default
  storage extension).<o:p></o:p></span></p>
  <p class=MsoNormal><b><span style="font-size:10.0pt;font-family:"Arial","sans-serif"">FR03525199
  </span></b><span style="font-size:10.0pt;font-family:"Arial","sans-serif"">has
  been raised for this request. <o:p></o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:"Arial","sans-serif""><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><span style="font-size:10.0pt;font-family:"Arial","sans-serif"">You
  may contact us thru MS Lync&nbsp;SEAL2OPS, ION account (<a
  href="mailto:seal2ops.im@pg.com">seal2ops.im@pg.com</a>) or you can send us
  an email thru <a href="mailto:seal2ops@hp.com">seal2ops@hp.com</a>.Have a
  nice day!<o:p></o:p></span></p>
  <p class=MsoNormal><span style="font-family:"Arial","sans-serif""><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal><span style="font-family:"Arial","sans-serif""><o:p>&nbsp;</o:p></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:2;height:77.75pt">
  <td width=192 valign=top style="width:2.0in;border:solid #D9D9D9 1.0pt;
  border-top:none;background:#0099FF;padding:0in 5.4pt 0in 5.4pt;height:77.75pt">
  <p class=MsoNormal align=right style="text-align:right"><b><span
  style="font-size:10.0pt;font-family:"Arial","sans-serif";color:white">SCREENSHOT<o:p></o:p></span></b></p>
  </td>
  <td width=672 valign=top style="width:7.0in;border-top:none;border-left:none;
  border-bottom:solid #D9D9D9 1.0pt;border-right:solid #D9D9D9 1.0pt;
  background:white;padding:0in 5.4pt 0in 5.4pt;height:77.75pt">
  <p class=MsoNormal><span style="mso-fareast-language:EN-US;mso-no-proof:yes"><!--[if gte vml 1]><v:shape
   id="_x0000_i1025" type="#_x0000_t75" style="width:906pt;height:462pt;
   visibility:visible">
   <v:imagedata src="SEAL2%20Operations%20Team_files/image002.jpg" o:href="cid:image001.jpg@01CFEA93.6E681240"/>
  </v:shape><![endif]--><![if !vml]><img border=0 width=1208 height=616
  src="SEAL2%20Operations%20Team_files/image002.jpg" v:shapes="_x0000_i1025"><![endif]></span><span
  style="font-size:10.0pt;font-family:"Arial","sans-serif""><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:3">
  <td width=192 valign=top style="width:2.0in;border:solid #D9D9D9 1.0pt;
  border-top:none;background:#0099FF;padding:0in 5.4pt 0in 5.4pt">
  <p class=MsoNormal align=right style="text-align:right"><b><span
  style="font-size:10.0pt;font-family:"Arial","sans-serif";color:white">CONTACTS<o:p></o:p></span></b></p>
  </td>
  <td width=672 valign=top style="width:7.0in;border-top:none;border-left:none;
  border-bottom:solid #D9D9D9 1.0pt;border-right:solid #D9D9D9 1.0pt;
  background:white;padding:0in 5.4pt 0in 5.4pt">
  <p class=MsoNormal><b><span style="font-family:"Arial","sans-serif";
  letter-spacing:1.0pt">John Henry M. Boco</span></b><span class=MsoHyperlink><span
  style="font-size:8.0pt;font-family:"Arial","sans-serif""> <a
  href="mailto:john-henry.mes.boco@hp.com">john-henry.mes.boco@hp.com</a></span></span><b><span
  style="font-family:"Arial","sans-serif";letter-spacing:1.0pt"><o:p></o:p></span></b></p>
  <p class=MsoNormal><b><span style="font-family:"Arial","sans-serif";
  letter-spacing:1.0pt">SEAL2 Operations Team</span></b><b><span
  style="font-size:12.0pt;font-family:"Arial","sans-serif";letter-spacing:1.0pt">
  </span></b><span style="font-size:8.0pt;font-family:"Arial","sans-serif"">(email:
  <a href="mailto:seal2ops@hp.com">seal2ops@hp.com</a>&nbsp; /MOC:<span
  style="letter-spacing:1.0pt"> </span><span class=MsoHyperlink><a
  href="mailto:seal2ops.im@pg.com">seal2ops.im@pg.com</a></span><span
  style="letter-spacing:1.0pt">)<o:p></o:p></span></span></p>
  <p class=MsoNormal><span style="font-size:8.0pt;font-family:"Arial","sans-serif"">Web
  Front-end Application Support Team (<span class=SpellE>WebFAST</span>)<br>
  HP Application Services Global Delivery Philippines (ASGD PH)<o:p></o:p></span></p>
  <p class=MsoNormal><span style="font-size:8.0pt;font-family:"Arial","sans-serif"">Hewlett-Packard
  Company</span><span style="font-size:10.0pt;font-family:"Arial","sans-serif""><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:4;mso-yfti-lastrow:yes">
  <td width=864 colspan=2 valign=top style="width:9.0in;border:solid #D9D9D9 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt">
  <p class=MsoNormal><span style="font-size:7.5pt;font-family:"Arial","sans-serif";
  color:#999999">The information transmitted is intended solely for the individual
  or entity to which it is addressed and may contain Hewlett Packard Company
  confidential and/or privileged material. Any review, retransmission,
  dissemination or other use of or taking action in reliance upon this
  information by persons or entities other than the intended recipient is
  prohibited. If you have received this email in error please contact the
  sender and delete the material from any computer.</span><span
  style="font-size:7.5pt;font-family:"Arial","sans-serif";color:#1F497D"><o:p></o:p></span></p>
  </td>
 </tr>
</table>

</div>

<p class=MsoNormal><span style="font-family:"Arial","sans-serif""><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><o:p>&nbsp;</o:p></p>

<p class=MsoNormal><span style="mso-fareast-language:EN-US"><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><span style="mso-fareast-language:EN-US"><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><o:p>&nbsp;</o:p></p>

</div>

</body>

</html>



			'; 
			
			// Uncomment before sending to Adrian
			//$name = $this->session->userdata('employeeName');
			//$email = $this->session->userdata('email');
		
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
			
			// Uncomment  before sending to Adrian
			//$this->email->cc('michael-jarreth-b.lanon@hp.com, patrick-ian.cura@hp.com, adrian-lester.tan@hp.com'); 
		
			$this->email->subject
			('[FYI] [FR03525199] [Southern Europe Cluster] Approaching SharePoint Web site storage limit');
		
			$this->email->message($body);
			$this->email->send();
		}

	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */