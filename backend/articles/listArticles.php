<?php
include_once("../common/dbConnection.php");
$pageTitle = 'Operations and Miscellaneous';
include_once("../common/header.php");

$sql = "SELECT   * FROM articles";
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
Contains all pages under the /operations and /misc directories, the 'link' field contains the public URL so must be unique. You can also set up the 'link' field with "/" characters in it to make virtual subdirectories.<hr/>

<TABLE CELLSPACING="0" CELLPADDING="3" BORDER="0" WIDTH="100%">
	<TR>
		<TD><B>Link</B></TD>
		<TD><B>Title</B></TD>
		<TD><B>Description</B></TD>
		<TD><B>Content</B></TD>
	</TR>
<?
	while ($i<$numberOfRows)
	{

		if (($i%2)==0) { $bgColor = "#FFFFFF"; } else { $bgColor = "#C0C0C0"; }

	$thisId = MYSQL_RESULT($result,$i,"id");
	$thisLink = stripslashes(MYSQL_RESULT($result,$i,"link"));
	$thisTitle = stripslashes(MYSQL_RESULT($result,$i,"title"));
	$thisDescription = stripslashes(MYSQL_RESULT($result,$i,"description"));
	$thisContent = stripslashes(MYSQL_RESULT($result,$i,"content"));

?>
	<TR BGCOLOR="<? echo $bgColor; ?>">
		<TD><? echo $thisLink; ?></TD>
		<TD><? echo $thisTitle; ?></TD>
		<TD><? echo $thisDescription; ?></TD>
		<TD><? if($thisContent != '') { echo 'Yes'; } ?></TD>
	<TD><a href="editArticles.php?id=<? echo $thisId; ?>">Edit</a></TD>
	</TR>
<?
		$i++;

	} // end while loop
?>
</TABLE>
<?
} // end of if numberOfRows > 0 
 ?>
 <hr>
<a href="enterNewArticles.php">Add article</a>
<?php
include_once("../common/footer.php");
?>