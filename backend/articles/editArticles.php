<?php

$pageTitle = 'Update Articles';
include_once("../common/dbConnection.php");
include_once("../common/header.php");

$thisId = $_REQUEST['id'];

$sql = "SELECT   * FROM articles WHERE id = '$thisId'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows==0) {  
?>

Sorry. No records found !!

<?php
}
else if ($numberOfRows>0) {

	$i=0;
	$thisId = MYSQL_RESULT($result,$i,"id");
	$thisLink = stripslashes(MYSQL_RESULT($result,$i,"link"));
	$thisTitle = stripslashes(MYSQL_RESULT($result,$i,"title"));
	$thisDescription = stripslashes(MYSQL_RESULT($result,$i,"description"));
	$thisContent = stripslashes(MYSQL_RESULT($result,$i,"content"));
	$thisPhotos = stripslashes(MYSQL_RESULT($result,$i,"photos"));
	$thisLine = stripslashes(MYSQL_RESULT($result,$i,"line_id"));
	$thisCaption = stripslashes(MYSQL_RESULT($result,$i,"caption"));

}
?>
<h3><? echo $thisDescription; ?></h3>
<?
if ($_REQUEST['inserted'])
{
	echo "<p class=\"updated\">Inserted!<p>";
}
elseif ($_REQUEST['updated'])
{
	echo "<p class=\"updated\">Updated!<p>";
}
?>
<hr>
<a href="listArticles.php">Return without changes!</a><hr>
<form name="articlesUpdateForm" method="POST" action="updateArticles.php">

<table cellspacing="2" cellpadding="2" border="0" width="100%">
<input type="hidden" name="thisIdField" value="<? echo $thisId; ?>">
	<? /*<tr valign="top" height="20">
		<td align="right"> <b> Id :  </b> </td>
		<td><? echo $thisId; ?></td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Description :  </b> </td>
		<td> <? echo $thisDescription;  
		<textarea name="thisDescriptionField" id="thisDescriptionField" wrap="VIRTUAL" cols="80" rows="5"></textarea> 
		</td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Link :  </b> </td>
		<td> <input type="text" name="thisLinkField" size="40" value="<? echo $thisLink; ?>">  </td> 
	</tr>*/ ?>
	<tr valign="top" height="20">
		<td align="right"> <b> Link :  </b> </td>
		<td> <? echo $thisLink; ?></td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Title :  </b> </td>
		<td> <input type="text" name="thisTitleField" size="40" value="<? echo $thisTitle; ?>">  </td> 
	</tr>
	
    <tr valign="top" height="20">
		<td align="right"> <b> Gallery folder :  </b> </td>
		<td> 
		<input type="text" name="thisPhotosField" size="40" value="<?=$thisPhotos?>">  <br>
		<small>Eg: 'LINE-NAME/LOCATION-NAME'</small> 
		</td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Lead image caption :  </b> </td>
		<td> 
		<input type="text" name="thisCaptionField" size="83" value="<? echo $thisCaption; ?>"><br>
		<small>For image at top of article page, file needs to be at "/images/header-LINELINK-<? echo $thisLink; ?>.jpg"</small> 
		</td> 
	</tr>
	
	<tr valign="top" height="20">
		<td align="right"> <b> Content :  </b> </td>
		<td>
		<form>
		<script type="text/javascript" src="../common/js_quicktags.js"></script>
		<script type="text/javascript">edToolbar();</script>
		<textarea name="thisContentField" id="thisContentField" wrap="VIRTUAL" cols="100" rows="30"><? echo $thisContent; ?></textarea>
		<script type="text/javascript">var edCanvas = document.getElementById('thisContentField');</script>
		</form>
		</td>
	</tr>
</table>

<input type="submit" name="submitUpdateArticlesForm" value="Update Articles">
<input type="reset" name="resetForm" value="Clear Form">

</form>
<?
if ( !$_REQUEST['updated'])
{
?>
<hr>
<a href="listArticles.php">Return without changes!</a>
<?php
}
include_once("../common/footer.php");
?>