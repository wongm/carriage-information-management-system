<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$thisDate = addslashes($_REQUEST['thisDateField']);
	
if ($thisDate != '')
{
	// Retreiving Form Elements from Form
	$thisCarriage = addslashes($_REQUEST['thisCarriageField']);
	$thisSet = addslashes($_REQUEST['thisCarsetField']);
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	$thisNote = addslashes($_REQUEST['thisNoteField']);
	$thisPosition = addslashes($_REQUEST['thisPositionField']);

	$sqlQuery = "INSERT INTO carriage_carset (`carriage` , `position` , `carset` , `date` , `why` , `note` ) VALUES ('$thisCarriage' , '$thisPosition' , '$thisSet' , '$thisDate' , '$thisWhy' , '$thisNote' )";
	$result = MYSQL_QUERY($sqlQuery);
	echo $sqlQuery;

?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Carriage : </b></td>
	<td><? echo $thisCarriage; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Set : </b></td>
	<td><? echo $thisSet; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Date : </b></td>
	<td><? echo $thisDate; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Why : </b></td>
	<td><? echo $thisWhy; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Note : </b></td>
	<td><? echo $thisNote; ?></td>
</tr>
</table>

<?php
}	// end if
else
{
	invalidupdate();
}
include_once("../common/footer.php");
?>