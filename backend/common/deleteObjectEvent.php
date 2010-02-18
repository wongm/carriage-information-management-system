<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");

	// Retreiving Form Elements from Form
	$object = addslashes($_REQUEST['object']);
	$objectNice = getNiceName($object);
	$objectFile = str_replace(' ','',$objectNice);
	$objectFolder = str_replace('_','-',$object);
	
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisObject = addslashes($_REQUEST['this'.$objectFile.'Field']);
	$thisDate = addslashes($_REQUEST['thisDateField']);
	$thisWhy = addslashes($_REQUEST['thisWhyField']);
	$thisNote = addslashes($_REQUEST['thisNoteField']);

	$sql = "DELETE FROM ".$object."_event WHERE id = '$thisId'";
	$result = MYSQL_QUERY($sql);

?>
Record  has been deleted from database. Here is the deleted record :-<br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b>Carriage : </b></td>
	<td><? echo $thisCarriage; ?></td>
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