<?php
include_once("../common/dbConnection.php");

	// Retreiving Form Elements from Form
	$thisFamily = addslashes($_REQUEST['thisFamilyField']);
	$thiscarriage_type = addslashes($_REQUEST['thiscarriage_typeField']);

	$sqlQuery = "INSERT INTO carriage_type_family (family , carriage_type ) VALUES ('$thisFamily' , '$thiscarriage_type' )";
	$result = MYSQL_QUERY($sqlQuery);
	
	header("Location: listCarriageType-Family.php?inserted=true",TRUE,302);
?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Family : </b></td>
	<td><? echo $thisFamily; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>carriage_type : </b></td>
	<td><? echo $thiscarriage_type; ?></td>
</tr>
</table>

<?php
include_once("../common/footer.php");
?>