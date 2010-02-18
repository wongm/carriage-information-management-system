<?php
include_once("../common/dbConnection.php");
?>
<?php
	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisCarriage = addslashes($_REQUEST['thisCarriageField']);
	$thisSet = addslashes($_REQUEST['thisSetField']);
	$thisDate = addslashes($_REQUEST['thisDateField']);
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	$thisNote = addslashes($_REQUEST['thisNoteField']);
	$thisPosition = addslashes($_REQUEST['thisPositionField']);
	$referer = addslashes($_REQUEST['referer']);

?>
<?
$sql = "UPDATE carriage_carset SET carriage = '$thisCarriage' , `carset` = '$thisSet' , date = '$thisDate' , position = '$thisPosition' , why = '$thisWhy' , note = '$thisNote'  WHERE id = '$thisId'";
$result = MYSQL_QUERY($sql);

header("Location: ".$referer."#carriagemoves",TRUE,302);
?>
Record  has been updated in the database. Here is the updated information :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
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
<br><br><a href="listCarriage_set.php">Go Back to List All Records</a>

<?php
include_once("../common/footer.php");
?>