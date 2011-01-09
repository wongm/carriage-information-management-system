<?

function invalidupdate()
{
	include_once("../common/header.php");
	echo "<p class=\"error\">Invalid data - insert not performed!</p>";
	include_once("../common/footer.php");
}
function basicEditObjectForm($object, $title, $result)
{
	//print_r($object);
	$thisId = MYSQL_RESULT($result,$i,"id");
	$thisDescription = stripslashes(MYSQL_RESULT($result,$i,"description"));
	$thisContent = stripslashes(MYSQL_RESULT($result,$i,"content"));
?>
<fieldset id="<?=$object?>data"><legend><?=$title?></legend>
<form name="<?=$object?>UpdateForm" method="post" action="update<?=str_replace(' ', '', $title)?>.php">
<input type="hidden" name="thisIdField" value="<? echo $thisId; ?>" />

<table>
	<tr valign="top" height="20">
		<td align="right"> <b> Id :  </b> </td>
		<td> <? echo $thisId; ?>  </td>
	</tr>
<?	if ($object == 'carriage' OR $object == 'carset')
	{}
	else
	{
?>
	<tr valign="top" height="20">
		<td align="right"> <b> Description :  </b> </td>
		<td> <input type="text" name="thisDescriptionField" size="60" value="<? echo $thisDescription; ?>" />  </td>
	</tr>
<?	}

	if ($object == 'family')
	{
		$thisCarsetContent = stripslashes(MYSQL_RESULT($result,$i,"carset_content"));
		$thisCarriageContent = stripslashes(MYSQL_RESULT($result,$i,"carriage_content"));

?>

	<tr valign="top" height="20">
		<td align="right"> <b> Carset content :  </b> </td>
		<td> <? fancyform('CarsetContent', $thisCarsetContent); ?> </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Carriage content :  </b> </td>
		<td>
		<textarea name="thisCarriageContentField" id="thisCarriageContentField" wrap="VIRTUAL" cols="100" rows="30"><? echo $thisCarriageContent; ?></textarea>
		</td>
	</tr>
<?
	}
	else
	{
?>
	<tr valign="top" height="20">
		<td align="right"> <b> Content :  </b> </td>
		<td> <? fancyform('Content', $thisContent); ?> </td>
	</tr>
<?
	}
	?>
</table>
<input type="submit" value="Update <? echo str_replace('_',' ',$object);?>" />

</form>
</fieldset>
<?
}	// end function












function editAddObjectEventsForm($object, $title, $thisId)
{
	$fileName = str_replace(' ','',$title);
	?>
<fieldset id="<?=$object?>events"><legend><?=$title?> events</legend>
<table>
<?
	$sql = "SELECT * FROM ".$object."_event WHERE $object = '$thisId' ORDER BY date ASC";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	for ($i = 0; $i < $numberOfRows; $i++)
	{
		$thisEventId = MYSQL_RESULT($result,$i,"id");
		$thisCarriage = MYSQL_RESULT($result,$i,$object);
		$thisDate = MYSQL_RESULT($result,$i,"date");
		$thisWhy = MYSQL_RESULT($result,$i,"why");
		$thisNote = MYSQL_RESULT($result,$i,"note");
		$thisType = MYSQL_RESULT($result,$i,"type");
		?>
	<tr>
		<td><?=$thisDate?></td><td>(<?=$thisWhy?>)</td><td><?=$thisNote?></td><td><?=$thisType?></td>
		<td><a href="../common/editObjectEvent.php?object=<?=$object?>&id=<?=$thisEventId?>">Edit</a></td>
		<td><a href="../common/confirmDeleteObjectEvent.php?object=<?=$object?>&id=<?=$thisEventId?>">Delete</a></td>
	</tr>
<?	}
?>
</table>
Add:
<form name="<?=$object?>EventEnterForm" method="post" action="../common/insertNewObjectEvent.php">
<input type="hidden" name="this<?=$fileName?>Field" value="<? echo $thisId; ?>" />
<input type="hidden" name="object" value="<? echo $object; ?>" />
<table>
	<tr valign="top" height="20">
		<td align="right"> <b> Date :  </b> </td>
		<td> <input type="text" name="thisDateField" size="20" value="" />  </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Date modifier :  </b> </td>
		<td> <select name="thisWhyField">
		<option selected value="book">Book</option>
		<option value="seen">Seen</option>
		<option <? if ($thisStatus == 'current'){echo selected;} ?> value="current">Current</option>
		</select> </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Note :  </b> </td>
		<td> <input type="text" name="thisNoteField" size="60" value="" />  </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Event type :  </b> </td>
		<td> <select name="thisTypeField">
		<option selected value="text">Text [Default]</option>
		<option <? if ($thisStatus == 'built'){echo selected;} ?> value="built">Built</option>
		<option <? if ($thisStatus == 'service'){echo selected;} ?> value="service">Service</option>
		<option <? if ($thisStatus == 'stored'){echo selected;} ?> value="stored">Stored</option>
		<option <? if ($thisStatus == 'scrap'){echo selected;} ?> value="scrap">Scrapped</option>
		<option <? if ($thisStatus == 'sold'){echo selected;} ?> value="sold">Sold</option>
		<option <? if ($thisStatus == 'sparepool'){echo selected;} ?> value="sparepool">In sparepool</option>
		</select></td>
	</tr>
</table>

<input type="submit" name="submitEnter<?=$title?>_eventForm" value="Enter <? echo str_replace('_',' ',$object);?> event" />
</form>
</fieldset>
<?
}	// end function

function getNiceName($object)
{
	return ucwords(str_replace('_', ' ', $object));
}


function editCarriageMovesForm($carriage, $carset)
{
	if ($carriage != '')
	{
		$thisId = $carriage;
		$title = 'Carriage';
		$object = 'carriage';
		$oppose = 'carset';
		$titleoppose = 'Carset';
		$moved = 'Moved to ';
	}
	elseif ($carset != '')
	{
		$thisId = $carset;
		$title = 'Carset';
		$object = 'carset';
		$oppose = 'carriage';
		$titleoppose = 'Carriage';
		$moved = 'Added car ';
	}
?>
<fieldset id="carriagemoves"><legend>Carriage moves</legend>
<table>
<?
	$sql = "SELECT * FROM carriage_carset WHERE $object = '$thisId' ORDER BY date ASC";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);

	for ($i = 0; $i < $numberOfRows; $i++)
	{
		$thisEventId = MYSQL_RESULT($result,$i,"id");
		$thisObject = MYSQL_RESULT($result,$i,$oppose);
		$thisDate = MYSQL_RESULT($result,$i,"date");
		$thisWhy = MYSQL_RESULT($result,$i,"why");
		$thisNote = MYSQL_RESULT($result,$i,"note");
		$thisPosition = MYSQL_RESULT($result,$i,"position");
		?>
	<tr>
		<td><?=$thisDate?></td><td>(<?=$thisWhy?>)</td><td><?=$moved.$oppose?> <?=$thisObject?></td><td><?=$thisNote?></td><td><?=$thisType?></td>
		<td><a href="../common/editCarriageSetMove.php?id=<?=$thisEventId?>">Edit</a></td>
		<td><a href="../common/confirmDeleteCarriageSetMove.php?id=<?=$thisEventId?>">Delete</a></td>
	</tr>
<?	}
?>
</table>
<form name="carriageMoveForm" method="post" action="../common/insertNewCarriageSet.php">
<input type="hidden" name="this<?=$title?>Field" value="<? echo $thisId; ?>" />
<input type="hidden" name="thisTypeField" value="moved" />

Add:
<table>
	<tr valign="top" height="20">
		<td align="right"> <b> <?=$moved?> :  </b> </td>
		<td><select name="this<?=$titleoppose?>Field">
<?
	$result = MYSQL_QUERY("SELECT * FROM $oppose ORDER BY id ASC");
	$numberOfRows = MYSQL_NUM_ROWS($result);

	for ($i = 0; $i < $numberOfRows; $i++)
	{
		$thisObjectId = MYSQL_RESULT($result,$i,"id");
		echo "<option value=\"$thisObjectId\">$thisObjectId</option>";
	}
		?>
		</select></td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Position :  </b> </td>
		<td> <input type="text" name="thisPositionField" size="20" value="" />  </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Date :  </b> </td>
		<td> <input type="text" name="thisDateField" size="20" value="" />  </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Date modifier :  </b> </td>
		<td> <select name="thisWhyField">
		<option <? if ($thisStatus == 'built'){echo selected;} ?> value="built">Built</option>
		<option selected value="book">Book</option>
		<option <? if ($thisStatus == 'seen'){echo selected;} ?> value="seen">Seen</option>
		<option <? if ($thisStatus == 'current'){echo selected;} ?> value="current">Current</option>
		</select> </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Note :  </b> </td>
		<td> <input type="text" name="thisNoteField" size="60" value="" />  </td>
	</tr>
</table>

<input type="submit" value="Enter carriage movement" />
</form>
</fieldset>
<?
}	// end function





function editCarriageRecodesForm($carriage, $type)
{
	if ($carriage != '')
	{
		$thisId = $carriage;
		$title = 'Carriage';
		$object = 'carriage';
		$oppose = 'carriage_type';
		$niceOppose = 'type';
		$moved = 'Recoded to ';
	}
	elseif ($type != '')
	{
		$thisId = $type;
		$title = 'Type';
		$object = 'carriage_type';
		$oppose = 'carriage';
		$niceOppose = 'carriage';
		$moved = "Converted to $type - carriage ";
	}
	?>
<fieldset id="carriageconversions"><legend>Carriage conversions</legend>
<table>
<?
	$sql = "SELECT * FROM carriage_converted WHERE $object = '$thisId' ORDER BY date ASC";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);

	for ($i = 0; $i < $numberOfRows; $i++)
	{
		$thisEventId = MYSQL_RESULT($result,$i,"id");
		$thisCarriageType = MYSQL_RESULT($result,$i,$oppose);
		$thisDate = MYSQL_RESULT($result,$i,"date");
		$thisWhy = MYSQL_RESULT($result,$i,"why");
		$thisNote = MYSQL_RESULT($result,$i,"note");
		?>
	<tr>
		<td><?=$thisDate?></td><td>(<?=$thisWhy?>)</td><td><?=$moved.$niceOppose?> <?=$thisCarriageType?></td><td><?=$thisNote?></td><td><?=$thisType?></td>
		<td><a href="../common/editCarriageConverted.php?id=<?=$thisEventId?>">Edit</a></td>
		<td><a href="../common/confirmDeleteCarriageConverted.php?id=<?=$thisEventId?>">Delete</a></td>
	</tr>
<?	}
?>
</table>
<form name="carriageMoveEnterForm" method="post" action="../common/insertNewCarriageConverted.php">
<?
	if ($carriage != '')
	{
?>
<input type="hidden" name="thisCarriageField" value="<? echo $thisId; ?>" />
<?	}
	elseif ($type != '')
	{
?>
<input type="hidden" name="thisCarriageTypeField" value="<? echo $thisId; ?>" />
<?	}
?>
Add:
<table>
	<tr valign="top" height="20">
		<td align="right"> <b> <?=$moved?> :  </b> </td>
		<td> <? drawObjectField($oppose, $currentValue=''); ?> </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Date :  </b> </td>
		<td> <input type="text" name="thisDateField" size="20" value="" />  </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Date modifier :  </b> </td>
		<td> <? drawWhyField($thisStatus); ?> </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Note :  </b> </td>
		<td> <input type="text" name="thisNoteField" size="60" value="" />  </td>
	</tr>
</table>

<input type="submit" value="Enter carriage conversion" />
</form>
</fieldset>

<?
}	// end function

function drawObjectField($type, $currentValue='')
{
	if ($type == 'carset_type')
	{
		$oppose = 'CarsetType';
	}
	else if ($type == 'carriage_type')
	{
		$oppose = 'CarriageType';
	}
	else if ($type == 'carriage')
	{
		$oppose = 'Carriage';
	}
	else if ($type == 'carset')
	{
		$oppose = 'Carset';
	}
?>
<select name="this<?=$oppose?>Field">
<?
	$result = MYSQL_QUERY("SELECT * FROM $type ORDER BY id ASC");
	$numberOfRows = MYSQL_NUM_ROWS($result);

	for ($i = 0; $i < $numberOfRows; $i++)
	{
		$thisCarTypeId = MYSQL_RESULT($result,$i,"id");

		if ($currentValue == $thisCarTypeId)
		{
			$selected = " selected ";
		}
		else
		{
			$selected = "";
		}

		echo "<option $selected value=\"$thisCarTypeId\">$thisCarTypeId</option>\n";
	}
?>
</select>
<?
}

function drawWhyField($thisStatus)
{
?>
	<select name="thisWhyField">
		<option <? if ($thisStatus == 'built'){echo selected;} ?> value="built">Built</option>
		<option <? if ($thisStatus == 'book'){echo selected;} ?> value="book">Book</option>
		<option <? if ($thisStatus == 'seen'){echo selected;} ?> value="seen">Seen</option>
		<option <? if ($thisStatus == 'current'){echo selected;} ?> value="current">Current</option>
	</select>
<?
}



function editObject($object, $title, $result)
{
	$thisId = MYSQL_RESULT($result,0,"id");
	$thisDescription = stripslashes(MYSQL_RESULT($result,0,"description"));
	$thisContent = stripslashes(MYSQL_RESULT($result,0,"content"));

	if ($object == 'locomotive' OR $object == 'carriage' OR $object == 'carset' OR $object == 'railcar')
	{
		$thisLivery = stripslashes(MYSQL_RESULT($result,0,"livery"));
	}

	if ($object != 'locomotive_class' AND $object != 'railcar_type')
	{
		$thisStatus= MYSQL_RESULT($result,0,"status");
	}

	if ($object != 'locomotive' AND $object != 'locomotive_class' AND $object != 'railcar_type' AND $object != 'railcar')
	{
		$thisFamily = MYSQL_RESULT($result,0,"family");
	}
	else if ($object == 'locomotive')
	{
		$thisClass = MYSQL_RESULT($result,0,"class");
	}

	if ($object == 'railcar')
	{
		$thisRailcarType = MYSQL_RESULT($result,0,"railcar_type");
	}

?>


<fieldset id="<?=$object?>"><legend><?=$title?></legend>
<form name="<?=$object?>UpdateForm" method="post" action="update<?=str_replace(' ', '', $title)?>.php">
<input type="hidden" name="thisIdField" value="<? echo $thisId; ?>" />
<table>
	<tr valign="top" height="20">
		<td align="right"> <b> Id :  </b> </td>
		<td> <? echo $thisId; ?></td>
	</tr>
<?
	if ($object != 'locomotive' AND $object != 'locomotive_class' AND $object != 'railcar_type' AND $object != 'railcar')
	{
		?>
	<tr>
		<td align="right"> <b> Family :  </b> </td>
		<td><select name="thisFamilyField">
<?
		$result = MYSQL_QUERY("SELECT * FROM family ORDER BY id ASC");
		$numberOfRows = MYSQL_NUM_ROWS($result);

		for ($i = 0; $i < $numberOfRows; $i++)
		{
			$thisFamilyId = MYSQL_RESULT($result,$i,"id");

			if ($thisFamilyId == $thisFamily)
			{
				echo "<option selected value=\"$thisFamilyId\">$thisFamilyId</option>";
			}
			else
			{
				echo "<option value=\"$thisFamilyId\">$thisFamilyId</option>";
			}
		}
		?>
		</select></td>
	</tr>
<?
	}
	elseif ($object == 'locomotive')
	{
		?>
	<tr>
		<td align="right"> <b> Class :  </b> </td>
		<td><select name="thisClassField">
<?
		$result = MYSQL_QUERY("SELECT * FROM locomotive_class ORDER BY id ASC");
		$numberOfRows = MYSQL_NUM_ROWS($result);

		for ($i = 0; $i < $numberOfRows; $i++)
		{
			$thisFamilyId = MYSQL_RESULT($result,$i,"id");

			if ($thisFamilyId == $thisClass)
			{
				echo "<option selected value=\"$thisFamilyId\">$thisFamilyId</option>";
			}
			else
			{
				echo "<option value=\"$thisFamilyId\">$thisFamilyId</option>";
			}
		}
		?>
		</select></td>
	</tr>


<?
	}	/// end loco if statement


	if ($object == 'railcar')
	{
		?>
	<tr>
		<td align="right"> <b> Railcar type :  </b> </td>
		<td><select name="thisRailcarTypeField">
<?
		$result = MYSQL_QUERY("SELECT * FROM railcar_type ORDER BY id ASC");
		$numberOfRows = MYSQL_NUM_ROWS($result);

		for ($i = 0; $i < $numberOfRows; $i++)
		{
			$thisFamilyId = MYSQL_RESULT($result,$i,"id");

			if ($thisFamilyId == $thisRailcarType)
			{
				echo "<option selected value=\"$thisFamilyId\">$thisFamilyId</option>";
			}
			else
			{
				echo "<option value=\"$thisFamilyId\">$thisFamilyId</option>";
			}
		}
		?>
		</select></td>
	</tr>
<?
	}

	if (isset($thisLivery))
	{
		drawLiveryRow($thisLivery);
	}

	if ($object == 'carriage' OR $object == 'carset')
	{}
	else
	{
?>
	<tr valign="top" height="20">
		<td align="right"> <b> Description :  </b> </td>
		<td> <input type="text" name="thisDescriptionField" size="60" value="<? echo $thisDescription; ?>" />  </td>
	</tr>
<?	}


	if ($object != 'locomotive_class' AND $object != 'railcar_type')
	{
		?>
	<tr valign="top" height="20">
		<td align="right"> <b> Status :  </b> </td>
		<td><select name="thisStatusField">
		<option <? if ($thisStatus == 'factory'){echo selected;} ?> value="factory">Construction</option>
		<option <? if ($thisStatus == 'service'){echo selected;} ?> value="service">Service</option>
		<option <? if ($thisStatus == 'stored'){echo selected;} ?> value="stored">Stored</option>
		<option <? if ($thisStatus == 'brokenup'){echo selected;} ?> value="brokenup">Broken up</option>
		<option <? if ($thisStatus == 'scrapped'){echo selected;} ?> value="scrapped">Scrapped</option>
		<option <? if ($thisStatus == 'sold'){echo selected;} ?> value="sold">Sold</option>
		</select></td>
	</tr>
<?	}		?>
	<tr valign="top" height="20">
		<td align="right"> <b> Content :  </b> </td>
		<td> <? fancyform('Content', $thisContent); ?> </td>
	</tr>
</table>
<input type="submit" value="Update <?=$title?>" />
</form></fieldset>

<?
}	// end function


function fancyform($type, $thisDescription)
{
	?>
	<script type="text/javascript" src="../common/js_quicktags.js"></script>
	<script type="text/javascript">edToolbar();</script>
	<textarea name="this<?=$type?>Field" id="this<?=$type?>Field" wrap="VIRTUAL" cols="100" rows="20"><? echo $thisDescription; ?></textarea>
	<script type="text/javascript">var edCanvas = document.getElementById('this<?=$type?>Field');</script>
<?
}	// end function


function editCarsetRecodesForm($carset, $type)
{
	if ($carset != '')
	{
		$thisId = $carset;
		$title = 'Carriage Set';
		$object = 'carset';
		$oppose = 'carset_type';
		$niceOppose = 'CarsetType';
		$moved = 'Recoded to ';
	}
	elseif ($type != '')
	{
		$thisId = $type;
		$title = 'CarsetType';
		$object = 'carset_type';
		$oppose = 'carset';
		$niceOppose = 'Carset';
		$moved = "Converted to $type - set ";
	}
	?>

<fieldset id="carsetrecoding"><legend>Carset recodings</legend>
<table>
<?
	$sql = "SELECT * FROM carset_recoded WHERE $object = '$thisId' ORDER BY date ASC";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);

	for ($i = 0; $i < $numberOfRows; $i++)
	{
		$thisEventId = MYSQL_RESULT($result,$i,"id");
		$thisCarriageType = MYSQL_RESULT($result,$i,$oppose);
		$thisDate = MYSQL_RESULT($result,$i,"date");
		$thisWhy = MYSQL_RESULT($result,$i,"why");
		$thisNote = MYSQL_RESULT($result,$i,"note");
		?>
	<tr>
		<td><?=$thisDate?></td><td>(<?=$thisWhy?>)</td><td><?=$moved?><?=$thisCarriageType?></td><td><?=$thisNote?></td><td><?=$thisType?></td>
		<td><a href="../common/editCarsetRecoded.php?id=<?=$thisEventId?>">Edit</a></td>
		<td><a href="../common/confirmDeleteCarsetRecoded.php?id=<?=$thisEventId?>">Delete</a></td>
	</tr>
<?	}
?>
</table>

<form name="carset_recodedEnterForm" method="post" action="../common/insertNewCarsetRecoded.php">
<input type="hidden" name="this<?=$title?>Field" value="<? echo $thisId; ?>" />
Add:
<table>
	<tr valign="top" height="20">
		<td align="right"> <b> <?=$moved?> :  </b> </td>
		<td><select name="this<?=$niceOppose?>Field">
<?
	$result = MYSQL_QUERY("SELECT * FROM $oppose ORDER BY id ASC");
	$numberOfRows = MYSQL_NUM_ROWS($result);

	for ($i = 0; $i < $numberOfRows; $i++)
	{
		$thisObjectId = MYSQL_RESULT($result,$i,"id");
		echo "<option value=\"$thisObjectId\">$thisObjectId</option>";
	}
		?>
		</select></td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Date :  </b> </td>
		<td> <input type="text" name="thisDateField" size="20" value="" />  </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Date modifier :  </b> </td>
		<td> <select name="thisWhyField">
		<option <? if ($thisStatus == 'built'){echo selected;} ?> value="built">Built</option>
		<option selected value="book">Book</option>
		<option <? if ($thisStatus == 'seen'){echo selected;} ?> value="seen">Seen</option>
		<option <? if ($thisStatus == 'current'){echo selected;} ?> value="current">Current</option>
		</select> </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Note :  </b> </td>
		<td> <input type="text" name="thisNoteField" size="60" value="" />  </td>
	</tr>
</table>

<input type="submit" value="Enter carset recoding" />

</form>
</fieldset>


<?

}	// end function



function editObjectEventsForm($object, $title, $thisId)
{
	echo "<h3>Edit $title</h3><hr/>";
	$fileName = str_replace(' ','',$title);

	$sql = "SELECT * FROM ".$object."_event WHERE id = '$thisId'";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUMROWS($result);

	if ($numberOfRows > 0)
	{
		$i=0;
		$thisId = MYSQL_RESULT($result,$i,"id");
		$thisObject = MYSQL_RESULT($result,$i,$object);
		$thisDate = MYSQL_RESULT($result,$i,"date");
		$thisWhy = MYSQL_RESULT($result,$i,"why");
		$thisNote = MYSQL_RESULT($result,$i,"note");
		$thisType = MYSQL_RESULT($result,$i,"type");
?>
<form name="<?=$object?>EventEnterForm" method="post" action="updateObjectEvent.php">
<input type="hidden" name="thisIdField" value="<? echo $thisId; ?>" />
<input type="hidden" name="this<?=$fileName?>Field" value="<? echo $thisObject; ?>" />
<input type="hidden" name="object" value="<? echo $object; ?>" />
<table>
	<tr valign="top" height="20">
		<td align="right"> <b> <?=$title?> :  </b> </td>
		<td><?=$thisObject?></td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Date :  </b> </td>
		<td> <input type="text" name="thisDateField" size="20" value="<?=$thisDate?>" />  </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Date modifier :  </b> </td>
		<td> <select name="thisWhyField">
		<option <? if ($thisStatus == 'book'){echo selected;} ?> value="book">Book</option>
		<option <? if ($thisStatus == 'seen'){echo selected;} ?> value="seen">Seen</option>
		<option <? if ($thisStatus == 'current'){echo selected;} ?> value="current">Current</option>
		</select> </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Note :  </b> </td>
		<td> <input type="text" name="thisNoteField" size="60" value="<?=$thisNote ?>" />  </td>
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Event type :  </b> </td>
		<td> <select name="thisTypeField">
		<option selected value="text">Text [Default]</option>
		<option <? if ($thisType == 'built'){echo selected;} ?> value="built">Built</option>
		<option <? if ($thisType == 'service'){echo selected;} ?> value="service">Service</option>
		<option <? if ($thisType == 'stored'){echo selected;} ?> value="stored">Stored</option>
		<option <? if ($thisType == 'scrap'){echo selected;} ?> value="scrap">Scrapped</option>
		<option <? if ($thisType == 'sold'){echo selected;} ?> value="sold">Sold</option>
		<option <? if ($thisType == 'sparepool'){echo selected;} ?> value="sparepool">In sparepool</option>
		</select></td>
	</tr>
</table>

<input type="submit" value="Enter <? echo str_replace('_',' ',$object);?> event" />
</form>
<?
	} /// end if
}	// end function








function drawLiveryRow($thisLivery)
{
?>
	<tr valign="top" height="20">
		<td align="right"> <b> Livery :  </b> </td>
		<td><select name="thisLiveryField">
			<option>None!</option>
<?
	$result = MYSQL_QUERY("SELECT * FROM livery ORDER BY name ASC");
	$numberOfRows = MYSQL_NUM_ROWS($result);

	for ($i = 0; $i < $numberOfRows; $i++)
	{
		$thisObjectId = MYSQL_RESULT($result,$i,"livery_id");
		$thisName = MYSQL_RESULT($result,$i,"name");

		echo "<option ";

		if ($thisObjectId == $thisLivery)
		{
			echo "selected ";
		}

		echo "value=\"$thisObjectId\">$thisName</option>";
	}
		?>
		</select></td>
	</tr>
<?
}	// end function
?>