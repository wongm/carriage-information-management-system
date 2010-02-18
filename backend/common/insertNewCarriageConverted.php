<?php
include_once("../common/dbConnection.php");

// Retreiving Form Elements from Form
$thisDate = addslashes($_REQUEST['thisDateField']);
	
if ($thisDate != '')
{	
	$thisCarriage = addslashes($_REQUEST['thisCarriageField']);
	$thisCarriage_type = addslashes($_REQUEST['thisCarriageTypeField']);
	
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	$thisNote = addslashes($_REQUEST['thisNoteField']);

	if ($thisWhy == 'built' AND $thisDate == '')
	{
		$thisDate = '0001-01-01';
	}

	$sqlQuery = "INSERT INTO carriage_converted (carriage , carriage_type , date , why , note ) VALUES ('$thisCarriage' , '$thisCarriage_type' , '$thisDate' , '$thisWhy' , '$thisNote' )";
	$result = MYSQL_QUERY($sqlQuery);
	
	header("Location: ".$_SERVER['HTTP_REFERER']."#carriageconversions",TRUE,302);
?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Carriage : </b></td>
	<td><? echo $thisCarriage; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Carriage_type : </b></td>
	<td><? echo $thisCarriage_type; ?></td>
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