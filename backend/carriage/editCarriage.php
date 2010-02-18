<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$thisId = $_REQUEST['id'];
$sql = "SELECT * FROM carriage WHERE id = '$thisId'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);

if ($numberOfRows == 0)
{  
	echo 'Sorry. No records found!';
}
else
{
	$i=0;
	$thisId = MYSQL_RESULT($result,$i,"id");
	$thisDescription = MYSQL_RESULT($result,$i,"description");
	$thisStatus= MYSQL_RESULT($result,$i,"status");
	
	echo "<h3>Update Carriage</h3><hr/>";
	
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
		echo "<a href=\"listCarriage.php\">Return without changes!</a>";
		echo "<hr>";
	}
	editObject('carriage', 'Carriage', $result); 
	editAddObjectEventsForm('carriage', 'Carriage', $thisId); 
	editCarriageMovesForm($thisId, ''); 
	editCarriageRecodesForm($thisId, '');
}
include_once("../common/footer.php");
?>