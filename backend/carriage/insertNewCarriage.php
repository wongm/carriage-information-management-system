<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$thisId = addslashes($_REQUEST['thisIdField']);
	
if ($thisId != '')
{
	// Retreiving Form Elements from Form
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$sqlQuery = "INSERT INTO carriage (id , description ) VALUES ('$thisId' , '$thisDescription' )";
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
</table>

<?php
}	// end if
else
{
	invalidupdate();
}
include_once("../common/footer.php");
?>