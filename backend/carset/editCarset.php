<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?php
$thisId = $_REQUEST['id']
?>
<?php
$sql = "SELECT   * FROM carset WHERE id = '$thisId'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows==0) {  
?>

Sorry. No records found !!

<?php
}
else if ($numberOfRows>0) 
{
	$i=0;
	$thisId = MYSQL_RESULT($result,$i,"id");
	$thisDescription = MYSQL_RESULT($result,$i,"description");
	$thisStatus= MYSQL_RESULT($result,$i,"status");
	
	echo "<h3>Update Carset</h3><hr/>";
	
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
		echo "<a href=\"listCarset.php\">Return without changes!</a>";
		echo "<hr>";
	}
	editObject('carset', 'Carset', $result); 
	editAddObjectEventsForm('carset', 'Carset', $thisId); 
	editCarriageMovesForm('', $thisId); 
	editCarsetRecodesForm($thisId, '');
}
	
include_once("../common/footer.php");
?>