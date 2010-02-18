<?php
include_once("../common/dbConnection.php");

	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisRailcar_type = addslashes($_REQUEST['thisRailcarTypeField']);
	$thisDate = addslashes($_REQUEST['thisDateField']);
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	$thisNote = addslashes($_REQUEST['thisNoteField']);

	$sql = "UPDATE railcar_type_event SET railcar_type = '$thisRailcar_type' , date = '$thisDate' , why = '$thisWhy' , note = '$thisNote'  WHERE id = '$thisId'";
	$result = MYSQL_QUERY($sql);
	
	header("Location: editRailcarType.php?id=$thisRailcar_type#railcar_typeevents",TRUE,302);
?>
Record  has been updated in the database. Here is the updated information :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Railcar_type : </b></td>
	<td><? echo $thisRailcar_type; ?></td>
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
<br><br><a href="listRailcar_type_event.php">Go Back to List All Records</a>

<?php
include_once("../common/footer.php");
?>