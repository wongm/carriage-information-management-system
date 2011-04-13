<?php
include_once("../common/dbConnection.php");

$thisId = addslashes($_REQUEST['thisIdField']);
	
if ($thisId != '')
{
	// Retreiving Form Elements from Form
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisFamily = addslashes($_REQUEST['thisFamilyField']);

	$sqlQuery = "INSERT INTO carriage_type (id , description ) VALUES ('$thisId' , '$thisDescription' )";
	$result = MYSQL_QUERY($sqlQuery);
	
	header("Location: editCarriageType.php?id=".$thisId,TRUE,302);
}	// end if
else
{
	invalidupdate();
}
include_once("../common/footer.php");
?>