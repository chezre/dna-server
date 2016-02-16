<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
    <title>Code Creator</title>
    <style type="text/css">
        table {
            float: left;
            margin-left: 20px;
        }
    </style>
	
</head>
<body>
<table>
<form action="create.class.php" method="post">
    <tr><td><label for="table">Table</label></td><td><input type="text" name="table" id="table" /></td></tr>
    <tr><td><label for="prefix">Table Prefix</label></td><td><input type="text" name="prefix" id="prefix" /></td></tr>
    <tr><td><label for="pk_field">Primary key Field</label></td><td><input type="text" name="pk_field" id="pk_field" /></td></tr>
    <tr><td>&nbsp;</td><td><input type="submit" value="Create Class" /></td></tr>
</form>
</table>
</body>
</html>