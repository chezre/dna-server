<?php 
	
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	require('class.pdo.php');
	require('class.functions.php');
	
	#DAO
	$files = glob('inc/DAO/class.*.php');
	if (!empty($files)) foreach ($files as $f) require($f);
	
	#email
	require('class.phpmailer.php');
	require('class.phpmailer.extension.php');
	
	$config = simplexml_load_file("inc/conf.xml");
	$GLOBALS['config'] = $config;
	
	$dbconnection = simplexml_load_file("inc/DAO/dbconnection.xml");
	$m = new pdo_functions;
	$m->host = (string)$dbconnection->host;
	$m->user = (string)$dbconnection->username;
	$m->password = (string)$dbconnection->password;
	$m->database = (string)$dbconnection->database;
	if (!empty($m->password)) $m->connect();
	
	$GLOBALS['db'] = $m;
	$GLOBALS['fn'] = new functions();
	$GLOBALS['domain'] = $_SERVER['SERVER_NAME'];
	
	$GLOBALS['captcha.publickey']  = $config->recaptchaPublicKey;
	$GLOBALS['captcha.privatekey']  = $config->recaptchaPrivateKey;
	
	#custom:   civicrm bootstrap
	foreach ($config->civicrm->children() as $i) require_once $i['path'];
	$config = CRM_Core_Config::singleton();