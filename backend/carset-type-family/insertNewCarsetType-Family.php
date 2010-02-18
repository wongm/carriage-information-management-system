<?php
include_once("../common/dbConnection.php");

	// Retreiving Form Elements from Form
	$thisFamily = addslashes($_REQUEST['thisFamilyField']);
	$thiscarset_type = addslashes($_REQUEST['thiscarset_typeField']);

	$sqlQuery = "INSERT INTO carset_type_family (family , carset_type ) VALUES ('$thisFamily' , '$thiscarset_type' )";
	$result = MYSQL_QUERY($sqlQuery);
	
	header("Location: listCarsetType-Family.php?inserted=true",TRUE,302);
?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Family : </b></td>
	<td><? echo $thisFamily; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>carset_type : </b></td>
	<td><? echo $thiscarset_type; ?></td>
</tr>
</table>

<?php
include_once("../common/footer.php");
?>