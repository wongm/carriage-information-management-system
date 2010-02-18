<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$thisId = $_REQUEST['id'];

$sql = "SELECT   * FROM carriage_type WHERE id = '$thisId'";
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
	$thisDescription = stripslashes(MYSQL_RESULT($result,$i,"description"));
	

	echo "<h3>Update Carriage Types</h3><hr/>";
	
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
		echo "<a href=\"listCarriageType.php\">Return without changes!</a>";
		echo "<hr>";
	}
	basicEditObjectForm('carriage_type', 'CarriageType', $result);
	editAddObjectEventsForm('carriage_type', 'CarriageType', $thisId); 
	editCarriageRecodesForm('', $thisId);
}

include_once("../common/footer.php");
?>