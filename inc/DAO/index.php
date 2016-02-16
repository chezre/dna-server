<?php

$config = simplexml_load_file('dbconnection.xml');
$rows = '';
foreach ($config->children() as $key => $value) {
	$rows .= '<tr>
				<td><label for="'.$key.'">'.$key.'</label></td>
				<td><input type="text" name="'.$key.'" id="'.$key.'" value="'.$value.'" /></td>
				</tr>';
}


?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>DB Config</title>
	<!-- Ninja CSS -->
	<link rel="stylesheet" href="../../css/ninja.index.css" />
	<link rel="stylesheet" href="../../css/ninja.config.css" />
	<!-- Ninja JS Files -->
	<script src="../../js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../../js/ninja.config.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#cfgSaveBtn").click(function(){
				$("#cfgSaveResult").empty().append('saving...').show();
				$.post('save.config.php',$("#frmConfig").serialize()).done(function(data){
					var json = $.parseJSON(data);
					$("#cfgSaveResult").empty().append(json.result);
				});
			});
		});
	</script>
</head>

<body>
	<div id="cfgMainWrapper">
		<h1 style="margin-top:0px;">DB Connection Settings</h1>
		<form method="POST" action="save.config.php" name="frmConfig" id="frmConfig">
		<table width="100%" cellspacing="0" cellpadding="5" style="margin-bottom: 20px">
			<?php echo $rows; ?>
		</table>
		</form>
		<div id="cfgSaveBtn">Save</div>
		<div id="cfgSaveResult"></div>
	</div>
</body>
</html>