<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$thisId = $_REQUEST['id'];

$sql = "SELECT   * FROM railcar_type WHERE id = '$thisId'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows==0) {  
?>

Sorry. No records found !!

<?php
}
else if ($numberOfRows>0) {

	$i=0;
	$thisId = MYSQL_RESULT($result,$i,"id");
	$thisDescription = MYSQL_RESULT($result,$i,"description");
	$thisContent = MYSQL_RESULT($result,$i,"content");
	
	if ($_REQUEST['inserted'])
	{
		echo "<p class=\"updated\">Inserted!<p>";
	}
	elseif ($_REQUEST['updated'])
	{
		echo "<p class=\"updated\">Updated!<p>";
	}
	else
	{
		echo "<a href=\"listRailcarType.php\">Return without changes!</a>";
		echo "<hr>";
	}	
	editObject('railcar_type', 'Railcar Type', $result); 
	editAddObjectEventsForm('railcar_type', 'Railcar Type', $thisId); 
}
include_once("../common/footer.php");
?>