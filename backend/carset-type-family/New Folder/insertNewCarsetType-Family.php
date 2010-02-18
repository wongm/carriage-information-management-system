<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?php
	// Retreiving Form Elements from Form
	$thisFamily = addslashes($_REQUEST['thisFamilyField']);
	$thisCarset_type = addslashes($_REQUEST['thisCarset_typeField']);

?>
<?
$sqlQuery = "INSERT INTO carset_type_family (family , carset_type ) VALUES ('$thisFamily' , '$thisCarset_type' )";
$result = MYSQL_QUERY($sqlQuery);

?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Family : </b></td>
	<td><? echo $thisFamily; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Carset_type : </b></td>
	<td><? echo $thisCarset_type; ?></td>
</tr>
</table>

<?php
include_once("../common/footer.php");
?>