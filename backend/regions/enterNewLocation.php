<?php

$thisLocation_id = $_REQUEST['location'];
$thisLine = $_REQUEST['line'];
$pageTitle = 'Insert New Location';
include_once("../common/dbConnection.php");
include_once("../common/header.php");	?>

<form name="locationsEnterForm" method="POST" action="insertNewLocations.php">
<fieldset><legend>General</legend>
<table cellspacing="2" cellpadding="2" border="0" width="100%">
	<tr valign="top" height="20">
		<td align="right"> <b> Name :  </b> </td>
		<td> <input type="text" name="thisNameField" size="30" value="">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Line :  </b> </td>
		<td> <select name="thisLineField">
<? drawLineNameSelectFields($thisLine); ?>	
		</select></td>
	</tr>
    <tr valign="top" height="20">
		<td align="right"> <b> Km :  </b> </td>
		<td> <input type="text" name="thisKmField" size="30">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Description :  </b> </td>
		<td> <textarea name="thisDescriptionField" wrap="VIRTUAL" cols="80" rows="8"></textarea></td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Co-ordinates :  </b> </td>
		<td> <input type="text" name="thisCoordsField" size="30" value="<? echo $thisCoOrds; ?>">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Photos?:  </b> </td>
		<td> <input type="text" name="thisPhotosField" size="30">  </td> 
	</tr>
</table>

<input type="submit" name="submitEnterLocationsForm" value="Insert Location"></form>
</fieldset>




<?php
include_once("../common/footer.php");
?>