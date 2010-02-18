<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$thisId = addslashes($_REQUEST['thisIdField']);
	
if ($thisId != '')
{
	// Retreiving Form Elements from Form
	$thisFamily = addslashes($_REQUEST['thisFamilyField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);
	$thisCars = addslashes($_REQUEST['thisCarsField']);

	$sqlQuery = "INSERT INTO carset_type (id , family , description , cars ) VALUES ('$thisId' , '$thisFamily' , '$thisDescription' , '$thisCars' )";
	$result = MYSQL_QUERY($sqlQuery);

?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Family : </b></td>
	<td><? echo $thisFamily; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Description : </b></td>
	<td><? echo $thisDescription; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Cars : </b></td>
	<td><? echo $thisCars; ?></td>
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