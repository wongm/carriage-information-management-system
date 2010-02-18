<?php
include_once("../common/dbConnection.php");

$thisDate = addslashes($_REQUEST['thisDateField']);

if ($thisDate != '')
{
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
	$thisType = addslashes($_REQUEST['thisTypeField']);
	
	$sqlQuery = "INSERT INTO ".$object."_event ($object , type , date , why , note ) VALUES ('$thisObject' , '$thisType' , '$thisDate' , '$thisWhy' , '$thisNote' )";
	$result = MYSQL_QUERY($sqlQuery);
	
	header("Location: ../".$objectFolder."/edit".$objectFile.".php?id=".$thisObject."#".$object."events",TRUE,302);

?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

<table>
<tr height="30">
	<td align="right"><b><?=$objectNice?> : </b></td>
	<td><? echo $thisObject; ?></td>
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
<tr height="30">
	<td align="right"><b>Type : </b></td>
	<td><? echo $thisType; ?></td>
</tr>
</table>

<?php
}
else
{
	invalidupdate();
}

?>