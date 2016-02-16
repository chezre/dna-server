<?php
 
require_once('inc/bootstrap.php');
ob_start();
$html_custom = $txt_custom = '';

foreach ($_POST as $k=>$v) {
	if (strpos($k, 'custom')>-1 && strpos($k, '_desc') === false) {
		foreach ($v as $a=>$b) {
			$findStrings = array('/###desc###/','/###value###/');
			$replacements = array($_POST[$k.'_desc'][$a],$b);
			$type = (preg_match('/textarea/', $k)) ? 'textarea':'input';
			$html_custom .= preg_replace($findStrings, $replacements, file_get_contents('emails/custom.'.$type.'.htm'));
			$txt_custom .= preg_replace($findStrings, $replacements, file_get_contents('emails/custom.'.$type.'.txt'));
		}
	}
	
}

$mytokens = array('name','email','message','contactno');
$findStrings = $std_replacements = array();
foreach ($mytokens as $key) {
	$findStrings[] = "/###$key###/";
	$std_replacements[] = (!empty($_POST[$key])) ? $_POST[$key]:'';
}
$findStrings[] = "/###custom###/";

$html_replacements = array_merge($std_replacements,array($html_custom));
$txt_replacements = array_merge($std_replacements,array($txt_custom));
$bodyHtml = preg_replace($findStrings, $html_replacements, file_get_contents('emails/submit.contact.htm'));
$bodyTxt = preg_replace($findStrings, $txt_replacements, file_get_contents('emails/submit.contact.txt'));

$mail = new extendedPhpmailer();
$mail->SetFrom($GLOBALS['config']->fromEmailAddress, $GLOBALS['config']->fromEmailName);
$mail->AddReplyTo($_POST['email'], $_POST['name']);
$mail->Subject = "Website Query";
$mail->IsHTML();
$mail->AltBody = $bodyTxt;
$mail->MsgHTML($bodyHtml);

###  Add Contact Us addresses
if (empty($GLOBALS['config']->contactUs)) {
	$mail->AddAddress($GLOBALS['config']->fromEmailAddress, $GLOBALS['config']->fromEmailName);
} else {
	foreach ($GLOBALS['config']->contactUs->to->Children() as $cu) $mail->AddAddress($cu['email'], $cu['name']);
}

###  Add configured CCs and BCCs
if (!empty($GLOBALS['config']->contactUs->bcc)) foreach ($GLOBALS['config']->contactUs->bcc->Children() as $bcc) $mail->AddBCC($bcc['email'], $bcc['name']);
if (!empty($GLOBALS['config']->contactUs->cc)) foreach ($GLOBALS['config']->contactUs->cc->Children() as $cc) $mail->AddCC($cc['email'], $cc['name']);

$result['result'] = $mail->sendEmail();
$result['errors'] = ob_get_clean();
echo json_encode($result);