<?php

	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	try {
		$cfgFile = 'dbconnection.xml';
		$config = simplexml_load_file($cfgFile);
		
		$exclude = array();
		foreach ($_POST as $k=>$v) {
			if (!in_array($k, $exclude)) $config->$k = $v;
		}
		
		$save = file_put_contents($cfgFile, $config->asXml());
		$result['result'] = ($save===false) ? 'failed...':'Saved Successfully !!!';
	} catch (exception $ex) {
		$result['result'] = $ex->getMessage();
	}
	
	echo json_encode($result);