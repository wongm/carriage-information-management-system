<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?php
	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisContent = addslashes($_REQUEST['thisContentField']);

?>
<?
$sqlQuery = "INSERT INTO railcar_type (id , description , content ) VALUES ('$thisId' , '$thisDescription' , '$thisContent' )";
$result = MYSQL_QUERY($sqlQuery);

?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Description : </b></td>
	<td><? echo $thisDescription; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Content : </b></td>
	<td><? echo $thisContent; ?></td>
</tr>
</table>

<?php
include_once("../common/footer.php");
?>