<?php

	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	try {
		$cfgFile = "../inc/conf.xml";
		$config = simplexml_load_file($cfgFile);
		
		$exclude = array('toEmail','toName','ccEmail','ccName','bccEmail','bccName');
		foreach ($_POST as $k=>$v) {
			if (!in_array($k, $exclude)) $config->$k = $v;
		}
		
		#contact us settings
		$addressTypes = array('to','cc','bcc');
		foreach ($addressTypes as $t) {
			unset($config->contactUs->$t);
			$config->contactUs->addChild($t);
			foreach ($_POST[$t.'Email'] as $k=>$v) {
				if (!empty($v)) {
					$address = $config->contactUs->$t->addChild('address');
					$address->addAttribute('email', $v);
					$address->addAttribute('name', $_POST[$t.'Name'][$k]);
				}  
			}
		}
		
		
		$save = file_put_contents($cfgFile, $config->asXml());
		$result['result'] = ($save===false) ? 'failed...':'Saved Successfully !!!';
	} catch (exception $ex) {
		$result['result'] = $ex->getMessage();
	}
	
	echo json_encode($result);