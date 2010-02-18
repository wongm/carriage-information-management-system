<?php
include_once("../common/dbConnection.php");

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
	$thisLivery = addslashes($_REQUEST['thisLiveryField']);
	
	if ($thisLivery != '')
	{
		$sql = " , livery = '$thisLivery' ";
	}

	$sql = "UPDATE ".$object."_event SET type = '$thisType' , $object = '$thisObject' , date = '$thisDate' , why = '$thisWhy' , note = '$thisNote' $sql WHERE id = '$thisId'";
	$result = MYSQL_QUERY($sql);

	header("Location: ../".$objectFolder."/edit".$objectFile.".php?id=".$thisObject."#".$object."events",TRUE,302);
	echo mysql_error()."<BR>";
	echo $sql."<BR>";

?>
Record  has been updated in the database. Here is the updated information :- <br><br>

<table>
<tr height="30">
	<td align="right"><b>Id : </b></td>
	<td><? echo $thisId; ?></td>
</tr>
<tr height="30">
	<td align="right"><b><?=$object?> : </b></td>
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
</table>
<br><br><a href="listCarriage_event.php">Go Back to List All Records</a>

<?php
include_once("../common/footer.php");
?>