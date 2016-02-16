<?php

Class extendedPhpmailer extends PHPMailer { 
 	function sendEmail() {
 		$isSiteRegistered = (!empty($GLOBALS['config']->registration->registrationKey));
 		if (!$isSiteRegistered) return 'Website not registered with the Ninja';
 		
 		$currentlyTesting = (string)$GLOBALS['config']->testing;
 		if ($currentlyTesting=='N') {
 			$result = $this->Send();
 			return ($result) ? 'Message Sent':'Message Failed';
 		} else {
 			return 'Website is in test mode, message not sent';
 		}
 	}
}

?>