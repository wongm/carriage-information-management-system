<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<h2>Enter Locomotive_class</h2>
<form name="locomotive_classEnterForm" method="post" action="insertNewLocomotiveClass.php">

<table cellspacing="2" cellpadding="2" border="0" width="100%">
	<tr valign="top" height="20">
		<td align="right"> <b> Id :  </b> </td>
		<td> <input type="text" name="thisIdField" size="20" value="">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Description :  </b> </td>
		<td> <input type="text" name="thisDescriptionField" size="20" value="">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Content :  </b> </td>
		<td> <input type="text" name="thisContentField" size="20" value="">  </td> 
	</tr>
</table>

<input type="submit" name="submitEnterLocomotive_classForm" value="Enter Locomotive_class">
<input type="reset" name="resetForm" value="Clear Form">

</form>

<?php
include_once("../common/footer.php");
?>