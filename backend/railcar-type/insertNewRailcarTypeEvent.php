<?php
include_once("../common/dbConnection.php");

	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisRailcar_type = addslashes($_REQUEST['thisRailcarTypeField']);
	$thisDate = addslashes($_REQUEST['thisDateField']);
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	$thisNote = addslashes($_REQUEST['thisNoteField']);
	
	$sqlQuery = "INSERT INTO railcar_type_event (id , railcar_type , date , why , note ) VALUES ('$thisId' , '$thisRailcar_type' , '$thisDate' , '$thisWhy' , '$thisNote' )";
	$result = MYSQL_QUERY($sqlQuery);
	
	header("Location: editRailcarType.php?id=$thisRailcar_type#railcar_typeevents",TRUE,302);

?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

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

<?php
include_once("../common/footer.php");
?>