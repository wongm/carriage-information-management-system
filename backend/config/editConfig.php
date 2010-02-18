<?php
$pageTitle = 'Update Config Variable';
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$thisName = addslashes($_REQUEST['thisNameField']);
$thisNameRequest = $_REQUEST['id'];

// do update info instead
if ($thisName != '')
{
	$thisValue = addslashes($_REQUEST['thisValueField']);
	$sql = "UPDATE config SET name = '$thisName' , value = '$thisValue'  WHERE name = '$thisName'";
	$result = MYSQL_QUERY($sql);
	$updated = "<p class=\"updated\">Updated!<p>";
}

$sql = "SELECT   * FROM config WHERE name = '$thisNameRequest'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

if ($numberOfRows>0) 
{

	$i=0;
	$thisNameRequest = MYSQL_RESULT($result,$i,"name");
	$thisValue = stripslashes(MYSQL_RESULT($result,$i,"value"));
	$thisDescription = stripslashes(MYSQL_RESULT($result,$i,"description"));
?>
<h3><? echo $thisDescription; ?></h3>
<?=$updated?>
<hr><a href="listConfig.php">Return without changes!</a>
<hr>
<form name="configUpdateForm" method="POST" action="<?=$_SERVER['REQUEST_URI']?>">
<input type="hidden" name="thisNameField" value="<?=$thisNameRequest; ?>" />
<textarea name="thisValueField" id="thisValueField" wrap="VIRTUAL" cols="100" rows="30"><? echo $thisValue; ?></textarea>
<br><br>
<input type="submit" name="submitUpdateConfigForm" value="Update Config" />

</form>
<?
}	// end zero result if
?>
<hr><a href="listConfig.php">Return without changes!</a>
<?php
include_once("../common/footer.php");
?>