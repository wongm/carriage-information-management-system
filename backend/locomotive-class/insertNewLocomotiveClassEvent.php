<?php
include_once("../common/dbConnection.php");

$thisDate = addslashes($_REQUEST['thisDateField']);
	
if ($thisDate != '')
{
	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisClass = addslashes($_REQUEST['thisLocomotiveClassField']);
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	$thisNote = addslashes($_REQUEST['thisNoteField']);
	$thisType = addslashes($_REQUEST['thisTypeField']);

	$sqlQuery = "INSERT INTO locomotive_class_event (id , locomotive_class , date , why , note , type ) VALUES ('$thisId' , '$thisClass' , '$thisDate' , '$thisWhy' , '$thisNote' , '$thisType' )";
	$result = MYSQL_QUERY($sqlQuery);
	
	header("Location: editLocomotiveClass.php?id=$thisClass#locomotiveevents",TRUE,302);

?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Class : </b></td>
	<td><? echo $thisClass; ?></td>
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

<?php
}	// end if
else
{
	invalidupdate();
}
include_once("../common/footer.php");
?>