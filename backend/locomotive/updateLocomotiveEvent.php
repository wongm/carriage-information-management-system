<?php
include_once("../common/dbConnection.php");

	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisLocomotive = addslashes($_REQUEST['thisLocomotiveField']);
	$thisDate = addslashes($_REQUEST['thisDateField']);
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	$thisNote = addslashes($_REQUEST['thisNoteField']);
	$thisType = addslashes($_REQUEST['thisTypeField']);

	$sql = "UPDATE locomotive_event SET id = '$thisId' , locomotive = '$thisLocomotive' , date = '$thisDate' , why = '$thisWhy' , note = '$thisNote' , type = '$thisType'  WHERE id = '$thisId'";
	$result = MYSQL_QUERY($sql);
	
	header("Location: editLocomotive.php?id=$thisLocomotive#locomotiveevents",TRUE,302);
?>
Record  has been updated in the database. Here is the updated information :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Locomotive : </b></td>
	<td><? echo $thisLocomotive; ?></td>
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
<tr height="30">
	<td align="right"><b>Type : </b></td>
	<td><? echo $thisType; ?></td>
</tr>
</table>
<br><br><a href="listlocomotive_event.php">Go Back to List All Records</a>

<?php
include_once("../common/footer.php");
?>