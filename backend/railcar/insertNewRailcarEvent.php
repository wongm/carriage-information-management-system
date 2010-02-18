<?php
include_once("../common/dbConnection.php");

$thisDate = addslashes($_REQUEST['thisDateField']);
	
if ($thisDate != '')
{
	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisRailcar = addslashes($_REQUEST['thisRailcarField']);
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	$thisNote = addslashes($_REQUEST['thisNoteField']);

	$sqlQuery = "INSERT INTO railcar_event (id , railcar , date , why , note ) VALUES ('$thisId' , '$thisRailcar' , '$thisDate' , '$thisWhy' , '$thisNote' )";
	$result = MYSQL_QUERY($sqlQuery);
	
	header("Location: editRailcar.php?id=$thisRailcar#railcarevents",TRUE,302);

?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Railcar : </b></td>
	<td><? echo $thisRailcar; ?></td>
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