<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<?
$thisIdFromForm = $_REQUEST['thisIdField'];
$thisAction = $_REQUEST['action'];
if ($thisAction=="Update")
{
	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);

	$sqlUpdate = "UPDATE family SET id = '$thisId' , description = '$thisDescription'  WHERE id = '$thisId'";
	$resultUpdate = MYSQL_QUERY($sqlUpdate);
	echo "<b>Record with Id ".$thisIdFromForm." has been Updated<br></b>";
	$thisIdFromForm = "";
}

if ($thisAction=="Insert")
{
	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);

	$sqlInsert = "INSERT INTO family (id , description ) VALUES ('$thisId' , '$thisDescription' )";
	$resultInsert = MYSQL_QUERY($sqlInsert);
	echo "<b>Record has been inserted in Database<br></b>";
	$thisIdFromForm = "";
}

if ($thisAction=="Delete")
{
	// Retreiving Form Elements from Form
	$thisId = addslashes($_REQUEST['thisIdField']);
	$thisDescription = addslashes($_REQUEST['thisDescriptionField']);

	$sqlDelete = "DELETE FROM family WHERE id = '$thisId'";
	$resultDelete = MYSQL_QUERY($sqlDelete);

	echo "<b>Record with Id ".$thisIdFromForm." has been Deleted<br></b>";
	$thisIdFromForm = "";
}

$initStartLimit = 0;
$limitPerPage = 10;

$startLimit = $_REQUEST['startLimit'];
$numberOfRows = $_REQUEST['rows'];
$sortBy = $_REQUEST['sortBy'];
$sortOrder = $_REQUEST['sortOrder'];

if ($startLimit=="")
{
		$startLimit = $initStartLimit;
}

if ($numberOfRows=="")
{
		$numberOfRows = $limitPerPage;
}

if ($sortOrder=="")
{
		$sortOrder  = "DESC";
}
if ($sortOrder == "DESC") { $newSortOrder = "ASC"; } else  { $newSortOrder = "DESC"; }
$limitQuery = " LIMIT ".$startLimit.",".$numberOfRows;
$nextStartLimit = $startLimit + $limitPerPage;
$previousStartLimit = $startLimit - $limitPerPage;

if ($sortBy!="")
{
		$orderByQuery = " ORDER BY ".$sortBy." ".$sortOrder;
}


$sql = "SELECT   * FROM family".$orderByQuery.$limitQuery;
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUM_ROWS($result);


?>
<?
if ($numberOfRows==0) {  
?>

Sorry. No records found !!

<?
}
else if ($numberOfRows>0) {

	$i=0;
?>


<br>
<?
if ($_REQUEST['startLimit'] != "")
{
?>

<a href="<? echo  $_SERVER['PHP_SELF']; ?>?startLimit=<? echo $previousStartLimit; ?>&limitPerPage=<? echo $limitPerPage; ?>&sortBy=<? echo $sortBy; ?>&sortOrder=<? echo $sortOrder; ?>">Previous <? echo $limitPerPage; ?> Results</a>....
<? } ?>
<?
if ($numberOfRows == $limitPerPage)
{
?>
<a href="<? echo $_SERVER['PHP_SELF']; ?>?startLimit=<? echo $nextStartLimit; ?>&limitPerPage=<? echo $limitPerPage; ?>&sortBy=<? echo $sortBy; ?>&sortOrder=<? echo $sortOrder; ?>">Next <? echo $limitPerPage; ?> Results</a>
<? } ?>

<br><br>
<TABLE CELLSPACING="0" CELLPADDING="3" BORDER="0" WIDTH="100%">
	<TR>
		<TD>
			<a href="<? echo $PHP_SELF; ?>?sortBy=id&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
				<B>Id</B>
			</a>
</TD>
		<TD>
			<a href="<? echo $PHP_SELF; ?>?sortBy=description&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
				<B>Description</B>
			</a>
</TD>
	</TR>
<?
if ($thisAction=="EnterNew")
{
?>
<FORM NAME="insertForm" METHOD="post" ACTION="<? echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="action" value="Insert">
<input type="hidden" name="thisIdField" value="<? echo $thisId; ?>">
	<TR BGCOLOR="#FF6666">
		<TD><input type"text" name="thisIdField" value=""></TD>
		<TD><input type"text" name="thisDescriptionField" value=""></TD>
	<TD COLSPAN=2><input type="submit" name="Insert" Value="Insert Record"> </TD>
	</TR>
</FORM>

<?
 } 
?>
<?
	while ($i<$numberOfRows)
	{

		if (($i%2)==0) { $bgColor = "#FFFFFF"; } else { $bgColor = "#C0C0C0"; }

	$thisId = MYSQL_RESULT($result,$i,"id");
	$thisDescription = MYSQL_RESULT($result,$i,"description");
if ($thisIdFromForm == $thisId)
{

?>
<FORM NAME="editForm" METHOD="post" ACTION="<? echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="action" value="Update">
<input type="hidden" name="thisIdField" value="<? echo $thisId; ?>">
	<TR BGCOLOR="<? echo $bgColor; ?>">
		<TD><input type"text" name="thisIdField" value="<? echo $thisId; ?>"></TD>
		<TD><input type"text" name="thisDescriptionField" value="<? echo $thisDescription; ?>"></TD>
	<TD COLSPAN=2><input type="button" name="Save" Value="Save" onClick="this.form.submit();"> </TD>
	</TR>
</FORM>

<?
} else { 
?>
	<TR BGCOLOR="<? echo $bgColor; ?>">
		<TD><? echo $thisId; ?></TD>
		<TD><? echo $thisDescription; ?></TD>
	<TD><a href="<? echo $_SERVER['PHP_SELF']; ?>?action=Edit&thisIdField=<? echo $thisId; ?>">Edit</a></TD>
	<TD><a href="<? echo $_SERVER['PHP_SELF']; ?>?action=Delete&thisIdField=<? echo $thisId; ?>">Delete</a></TD>
	</TR>

<?
}
?>
<?
		$i++;

	} // end while loop
?>
</TABLE>
<FORM NAME="insertForm" METHOD="post" ACTION="<? echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="action" value="EnterNew">
<input type="Submit" name="submit" value="Insert New Record">
</FORM>


<br>
<?
if ($_REQUEST['startLimit'] != "")
{
?>

<a href="<? echo  $_SERVER['PHP_SELF']; ?>?startLimit=<? echo $previousStartLimit; ?>&limitPerPage=<? echo $limitPerPage; ?>&sortBy=<? echo $sortBy; ?>&sortOrder=<? echo $sortOrder; ?>">Previous <? echo $limitPerPage; ?> Results</a>....
<? } ?>
<?
if ($numberOfRows == $limitPerPage)
{
?>
<a href="<? echo $_SERVER['PHP_SELF']; ?>?startLimit=<? echo $nextStartLimit; ?>&limitPerPage=<? echo $limitPerPage; ?>&sortBy=<? echo $sortBy; ?>&sortOrder=<? echo $sortOrder; ?>">Next <? echo $limitPerPage; ?> Results</a>
<? } ?>

<br><br>
<?
} // end of if numberOfRows > 0 
 ?>

<?php
include_once("../common/footer.php");
?>