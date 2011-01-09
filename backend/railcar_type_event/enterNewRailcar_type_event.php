<?php
include_once("../common/dbConnection.php");
include_once("../common/header.php");
?>
<h2>Enter Railcar_type_event</h2>
<form name="railcar_type_eventEnterForm" method="post" action="insertNewRailcar_type_event.php">

<table cellspacing="2" cellpadding="2" border="0" width="100%">
	<tr valign="top" height="20">
		<td align="right"> <b> Id :  </b> </td>
		<td> <input type="text" name="thisIdField" size="20" value="">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Railcar_type :  </b> </td>
		<td> <input type="text" name="thisRailcar_typeField" size="20" value="">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Date :  </b> </td>
		<td> <input type="text" name="thisDateField" size="20" value="">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Why :  </b> </td>
		<td> <input type="text" name="thisWhyField" size="20" value="">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Note :  </b> </td>
		<td> <input type="text" name="thisNoteField" size="20" value="">  </td> 
	</tr>
</table>

<input type="submit" name="submitEnterRailcar_type_eventForm" value="Enter Railcar_type_event">
<input type="reset" name="resetForm" value="Clear Form">

</form>

<?php
include_once("../common/footer.php");
?>