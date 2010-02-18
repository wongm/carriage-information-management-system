<?php
include_once("../common/dbConnection.php");
?>
<?php

// Retreiving Form Elements from Form
$thisDate = addslashes($_REQUEST['thisDateField']);
	
if ($thisDate != '')
{
	
	$thisCarriage = addslashes($_REQUEST['thisCarriageField']);
	$thisSet = addslashes($_REQUEST['thisCarsetField']);
	$thisDate = addslashes($_REQUEST['thisDateField']);
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	
	if ($thisWhy == 'built' AND $thisDate == '')
	{
		$thisDate = '0001-01-01';
	}
		
	$thisNote = addslashes($_REQUEST['thisNoteField']);
	$thisPosition = addslashes($_REQUEST['thisPositionField']);

	$sqlQuery = "INSERT INTO carriage_carset (`carriage` , `position` , `carset` , `date` , `why` , `note` ) VALUES ('$thisCarriage' , '$thisPosition' , '$thisSet' , '$thisDate' , '$thisWhy' , '$thisNote' )";
	$result = MYSQL_QUERY($sqlQuery);
	
	header("Location: ".$_SERVER['HTTP_REFERER']."#carriagemoves",TRUE,302);
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
} //end if
else
{
	invalidupdate();
}
?>