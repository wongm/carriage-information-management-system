<?php
include_once("../common/dbConnection.php");

$thisDate = addslashes($_REQUEST['thisDateField']);
	
if ($thisDate != '')
{
	// Retreiving Form Elements from Form
	$thisSet = addslashes($_REQUEST['thisCarsetField']);
	$thisCarsetType = addslashes($_REQUEST['thisCarsetTypeField']);
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	$thisNote = addslashes($_REQUEST['thisNoteField']);
	
	if ($thisWhy == 'current')
	{
		$thisDate = '9999-01-01';
	}
	
	$sqlQuery = "INSERT INTO carset_recoded (`carset` , carset_type , date , why , note ) VALUES ( '$thisSet' , '$thisCarsetType' , '$thisDate' , '$thisWhy' , '$thisNote' )";
	$result = MYSQL_QUERY($sqlQuery);
	
	header("Location: ".$_SERVER['HTTP_REFERER']."#carsetrecoding",TRUE,302);

?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Set : </b></td>
	<td><? echo $thisSet; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Set type : </b></td>
	<td><? echo $thisCarsetType; ?></td>
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