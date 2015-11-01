<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);
define('SOAP_CONSTANT','http://agarcia51:8000/ldap/ldap.svc?wsdl');
define('ADVANCED_THRESHOLD', 6000);
define('TRUE_THRESHOLD', 5000);
define('EXCEPTION_THRESHOLD', 10000);
define('SITEQUOTA_RECIPIENTS', 'gdpc.webint.bea-l2@hp.com');
define('SWTCWT_TOOLTIP','SWT and CWT are taken from the job that runs in the server and not entirely extracted in SM.');
define('PGUSERNAME', 'ap\seal2ops.im');
define('PGPASSWORD', 'beat53');
define('EFORM_URL', 'http://gbs.pg.com/ws/content/PROD/Secured-001/D6A73A643A5F36E5852575FC006BDA30English.html?opener=BusinessManagementhttp://gbs.pg.com/ws/content/PROD/Secured-001/D6A73A643A5F36E5852575FC006BDA30English.html?opener=BusinessManagement');


define('TABLE_CSS', '<style>'.
'
font{
	font                 : 12px Arial;
}
h3{
	font                 : 15px Arial;
}
#priority1{
	background: #ff4c4c;
}
#priority2{
	background: #ffff32;
}
#priority3{
	background: #ffb732;
}
#priority4{
	background: #e59400;
}
table,td
{
	border               : 1px solid #CCC;
	border-collapse      : collapse;
    font                 : 12px Arial;
	padding-top			:7px;
	padding-bottom		:7x;
	padding-right		:5px;
	padding-left		:5px;
}
table
{
	border                :none;
}
table th
{
	
    color                 : #666;  
	padding               : 5px 10px;
    border-left           : 1px solid #CCC;
	border-top            : 1px solid #CCC;
	border-right          : 1px solid #CCC;
	border-bottom          : 1px solid #CCC;
}

tbody tr td
{
	padding               : 5px 10px;
  
}
tfoot td,
tfoot th
{
  border-left           : none;
  border-top            : 1px solid #CCC;
  padding               : 4px;
  
  color                 : #666;
}
caption
{
	text-align            : left;
	font-size             : 120%;
	padding               : 10px 0;
	color                 : #666;
}
table a:link
{
	color                 : #666;
}
table a:visited
{
	color                 : #666;
}
table a:hover
{
	color                 : #003366;
	text-decoration       : none;
}
table a:active
{
	color                 : #003366;
}'.'</style>');

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */