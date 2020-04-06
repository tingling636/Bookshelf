<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	Email Preferences
*/

/* $email = array(
	'protocol'			=>	'smtp',
	'mailpath'			=> 	'/usr/sbin/sendmail',
	'smtp_host'			=> 	'mail.bayesthinks.com',
	'smtp_user'			=> 	'no-reply@bayesthinks.com',
	'smtp_pass'			=> 	'zTEST123#',
	'smtp_port'			=>	25,
	'smtp_timeout'		=>	5,
	'mailtype'			=>	'html',
	'validate'			=>	'FALSE',
	'priority'			=>	2,
	'newline'			=>	'\n',
	'bcc_batch_mode'	=>	'TRUE',
	'bcc_batch_size'	=>	10,
	'dsn'				=> 'FALSE'
); */

$config['protocol'] 	= 'smtp';
$config['smtp_host'] 	= 'mail.bayesthinks.com';  
$config['smtp_user']	= 'no-reply@bayesthinks.com';
$config['smtp_pass']	= 'zTEST123#';
$config['smtp_port'] 	= '25';  
$config['smtp_timeout'] = '30';  
$config['charset'] 		= 'utf-8';
$config['mailtype']		= 'html';
$config['wordwrap']		= TRUE;
$config['newline']	 	= "\r\n";