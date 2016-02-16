<?php $config = simplexml_load_file("../inc/conf.xml"); ?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Configuration</title>
	
	<link rel="stylesheet" href="../css/ninja.config.css" />
	
	<script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../js/ninja.config.js"></script> 
</head>
<body>
	<div id="cfgMainWrapper">
		<h1>Configuration (<?php echo $_SERVER['SERVER_NAME']; ?>)<div id="btnFormExample">Form Example</div></h1>
		<form method="POST" action="save.config.php" name="frmConfig" id="frmConfig">
			<div id="frmConfigDiv"></div>
			<div id="cfgSaveBtn">Save</div>
			<?php if (empty($config->registration->registrationKey)) { ?><div id="cfgRegisterBtn">Register</div><div id="cfgSaveResult"></div>
			<?php } else { ?><div id="cfgSaveResult"></div><div id="cfgDivRegistered">Registered with the ninja on <?php echo $config->registration->registrationDate.' </div>'; } ?>
		</form>
	</div>
	<div style="display:none">
		<div class="cfgInputDiv" id="toAddressTmpl">
			<div class="cfgLabel"><label for="">To Email Address</label></div>
			<div class="cfgInput">
				<input type="text" class="email" name="toEmail[]" value="" placeholder="To Email Address" />
				<input type="text" class="email" name="toName[]" value="" placeholder="To Email Name" />
			</div>
			<div class="addBtn" type="to">+</div>
		</div>
		<div class="cfgInputDiv" id="ccAddressTmpl">
			<div class="cfgLabel"><label for="">CC Email Address</label></div>
			<div class="cfgInput">
				<input type="text" class="email" name="ccEmail[]" value="" placeholder="CC Email Address" />
				<input type="text" class="email" name="ccName[]" value="" placeholder="CC Email Name" />
			</div>
			<div class="addBtn" type="cc">+</div>
		</div>
		<div class="cfgInputDiv" id="bccAddressTmpl">
			<div class="cfgLabel"><label for="">BCC Email Address</label></div>
			<div class="cfgInput">
				<input type="text" class="email" name="bccEmail[]" value="" placeholder="BCC Email Address" />
				<input type="text" class="email" name="bccName[]" value="" placeholder="BCC Email Name" />
			</div>
			<div class="addBtn" type="bcc">+</div>
		</div>
	</div>
</body>
</html>