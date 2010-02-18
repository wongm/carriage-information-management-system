<?php
include_once("../common/dbConnection.php");

	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisCarriage = addslashes($_REQUEST['thisCarriageField']);
	$thisCarriageType = addslashes($_REQUEST['thisCarriageTypeField']);
	$thisDate = addslashes($_REQUEST['thisDateField']);
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	$thisNote = addslashes($_REQUEST['thisNoteField']);
	
$sql = "UPDATE carriage_converted SET carriage = '$thisCarriage' , carriage_type = '$thisCarriageType' , date = '$thisDate' , why = '$thisWhy' , note = '$thisNote'  WHERE id = '$thisId'";
$result = MYSQL_QUERY($sql);

header("Location: ".$_REQUEST['referer']."#carriageconversions",TRUE,302);

?>
Record  has been updated in the database. Here is the updated information :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Carriage : </b></td>
	<td><? echo $thisCarriage; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Carriage type : </b></td>
	<td><? echo $thisCarriageType; ?></td>
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
<br><br><a href="listCarriage_converted.php">Go Back to List All Records</a>

<?php
include_once("../common/footer.php");
?>