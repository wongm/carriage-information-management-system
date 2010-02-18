<?php
include_once("../common/dbConnection.php");
$pageTitle = 'Page variables';
include_once("../common/header.php");

$sql = "SELECT   * FROM config".$orderByQuery.$limitQuery;
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUM_ROWS($result);

if ($numberOfRows==0) {  
?>
Sorry. No records found !!
<?
}
else if ($numberOfRows>0) {

	$i=0;
?>
Miscellaneous text that appears inside other pages. The description tells you where each appears, access to them from the public site is hard coded.<hr/>

<TABLE CELLSPACING="0" CELLPADDING="3" BORDER="0" WIDTH="100%">
	<TR>
		<TD>
			<a href="<? echo $PHP_SELF; ?>?sortBy=name&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
				<B>Description</B>
			</a>
</TD>
		<TD>
			<a href="<? echo $PHP_SELF; ?>?sortBy=value&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
				<B>Value</B>
			</a>
</TD>
	</TR>
<?
	while ($i<$numberOfRows)
	{

		if (($i%2)==0) { $bgColor = "#FFFFFF"; } else { $bgColor = "#C0C0C0"; }

	$thisName = MYSQL_RESULT($result,$i,"name");
	$thisValue = stripslashes(MYSQL_RESULT($result,$i,"value"));
	$thisDescription = stripslashes(MYSQL_RESULT($result,$i,"description"));
	
	$maxlen = 500;
	if (strlen($thisValue ) > $maxlen)
	{
		$thisValue = substr($thisValue, 0, $maxlen)." [...]";
	}

?>
	<TR BGCOLOR="<? echo $bgColor; ?>">
		<TD><? echo $thisDescription; ?></TD>
		<TD><? if ($thisValue != '') { echo "Yes"; } ?></TD>
	<TD><a href="editConfig.php?id=<? echo $thisName; ?>">Edit</a></TD>
	</TR>
<?
		$i++;

	} // end while loop
?>
</TABLE>
<br><hr>
<a href="enterNewConfig.php">Add new variable</a>

<?
} // end of if numberOfRows > 0 
 ?>

<?php
include_once("../common/footer.php");
?>