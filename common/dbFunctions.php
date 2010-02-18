<?php

/**
 * dbFunctions.php
 * 
 * Functions that get infomation from the database 
 * and return arrays in most cases. 
 * so data can be used elsewhere.
 * 
 * all the dirty work of SQL.
 * 
 * Marcus Wong
 * May 2008
 *
 */

/**
 * returns an array of the ID and description of a given object table
 * can use for carriage, carriage_type, carset, carset_type, familiy, railcar, railcarset, and railcarset_type
 * @param object the type of object to be returned. same as the database table name
 * @param status 'outofservice' for as it suggests, otherwise gets objects with the status passed along. leave blank for all objects
 * @param order SQL specifying how to order the results. Omit the ' ORDER BY ' from the begining
 * @return an array of objects. blank space, then ID, description, and status.
 */
function getAllObjectsOfTable($object, $status='', $order='', $specific='')
{
	$objectArray = array();
	
	if ($order != '')
	{
		$order = ' ORDER BY '.$order;
	}
	
	if ($object == 'locomotive')
	{
		$limit = " WHERE class = '$specific'";
	}
	else if ($object == 'railcar')
	{
		$limit = " WHERE railcar_type = '$specific'";
	}
	else
	{
		$limit = $specific;
	}
		
	if ($object == 'carriage' OR $object == 'carset')
	{
		if ($status == 'outofservice')
		{
			$status = " WHERE status != 'service'";
		}
		elseif ($status != '')
		{
			$status = " WHERE status = '$status'";
		}
	}
	
	$isFamily = false;
	
	switch ($object)
	{
		case carriage_type:
		case carset_type:
		case railcarset_type:
		case locomotive_class:
		case family:
		case railcarset:
			$showDescription = true;
			$isFamily = true;
		case carriage:
		case locomotive:
		case carset:
		case railcar:
			$showLivery = getIfLiveryShown($object);
			$showName = getIfObjectNamed($object, $specific);
			
			if ($showLivery)
			{
				$livery = " LEFT OUTER JOIN livery l ON o.livery = l.livery_id ";
			}
			
			if (!$isFamily)
			{
				$serviceJoin = " LEFT OUTER JOIN ".$object."_event e ON o.id = e.$object AND e.type = 'service'";
			}
			$sql = "SELECT * FROM $object o $livery $serviceJoin $status $limit $order";
			$result = MYSQL_QUERY($sql);
			
			$numberOfRows = MYSQL_NUM_ROWS($result);
			
			if ($numberOfRows > 0)
			{
				for ($i = 0; $i < $numberOfRows; $i++)
				{
					$thisStatus = '';
					$thisLivery = '';
					$thisDescription = '';
					$thisId = MYSQL_RESULT($result,$i,"id");
					
					if (!$showDescription)
					{
						$thisStatus = MYSQL_RESULT($result,$i,"status");
					}
					
					if ($showDescription)
					{
						$thisDescription = MYSQL_RESULT($result,$i,"description");
					}
					else if ($showName)
					{
						$thisDescription = "<i>".MYSQL_RESULT($result,$i,"description")."</i>";
					}
					
					if ($showLivery)
					{
						$thisLivery = MYSQL_RESULT($result,$i,"l.name");
					}
					
					if (!$isFamily)
					{
						$thisService = MYSQL_RESULT($result,$i,"e.date");
						if ($thisService != '')
						{
							$thisService = strftime(TIME_FORMAT, strtotime($thisService));
						}
					}
					$objectArray[] = array($thisId, '', $thisDescription, $thisStatus, $thisLivery, $thisService);
				}
			}
	}
	
	return $objectArray;
}

/**
 * returns all carriages from the database.
 * results can be limited to ID or status
 * @param status 'outofservice' for as it suggests, otherwise gets objects with the status passed along. leave blank for all objects
 * @param id to return only one carriage, with carriage ID given
 * @return an array of objects. Current carriage type, then ID, description, and status.
 */
function getAllCarriages($status, $id)
{
	$objectArray = array();
	
	if ($status == 'outofservice')
	{
		$status = " WHERE status != 'service'";
	}
	elseif ($status != '')
	{
		$status = " WHERE status = '$status'";
	}
	
	if (is_numeric($id))
	{
		$status .= " AND carriage = '$id' ";
	}
	
	$sql = "SELECT id AS carriage, status, '-' AS carriage_type, '0001-01-01' AS date, '-' AS description, '-' AS liveryname
				FROM carriage $status 
		UNION ALL
			SELECT carriage, status, carriage_type, date, carriage_type.description AS description, l.name AS liveryname
				FROM carriage_converted
				INNER JOIN carriage ON carriage.id = carriage_converted.carriage 
				INNER JOIN carriage_type ON carriage_converted.carriage_type = carriage_type.id
				LEFT OUTER JOIN livery l ON l.livery_id = carriage.livery 
				$status 
				GROUP BY carriage ORDER BY carriage ASC, date DESC";
	$result = MYSQL_QUERY($sql);
	
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
	if ($numberOfRows > 0)
	{
//		$objectArray[] = array('', 'Status', 'Livery');
		
		for ($i = 0; $i < $numberOfRows; $i++)
		{
			$thisId = MYSQL_RESULT($result,$i,"carriage");
			$thisStatus = MYSQL_RESULT($result,$i,"status");
			$thisDescription = str_replace('-', '', MYSQL_RESULT($result,$i,"description"));
			$thisLivery = MYSQL_RESULT($result,$i,"liveryname");
			
			// skip forward if type of carriage is found
			if ($i != $numberOfRows)
			{
				$thisType = MYSQL_RESULT($result,$i,"carriage_type");
				if ($thisType != '-')
				{
					$i++;
					$objectArray[] = array($thisId, $thisType, $thisDescription, $thisStatus, $thisLivery);
				}
			}
			else
			{
				$thisType = '-';
			}
		}
	}
	return $objectArray;
}

/**
 * returns all railcars from the database.
 * results can be limited to ID or status
 * @param status 'outofservice' for as it suggests, otherwise gets objects with the status passed along. leave blank for all objects
 * @param id to return only one railcar, with railcar ID given
 * @return an array of objects. Current railcar type, then ID, description, and status.
 */
function getAllRailcars($status, $id)
{
	$objectArray = array();
	
	if ($status == 'outofservice')
	{
		$status = " WHERE status != 'service'";
	}
	elseif ($status != '')
	{
		$status = " WHERE status = '$status'";
	}
	
	if (is_numeric($id))
	{
		$status .= " AND railcar = '$id' ";
	}
	
	$sql = "SELECT id AS railcar, status, '-' AS railcar_type, '-' AS description FROM railcarset $status 
		UNION ALL
			SELECT railcarset.id AS railcar, status, railcarset_type, railcarset_type.description AS description
				FROM railcarset, railcarset_type $status 
				AND railcarset.railcarset_type = railcarset_type.id
				GROUP BY railcar ORDER BY railcar ASC";
	$result = MYSQL_QUERY($sql);
	//echo $sql;
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
	if ($numberOfRows > 0)
	{
		for ($i = 0; $i < $numberOfRows; $i++)
		{
			$thisId = MYSQL_RESULT($result,$i,"carriage");
			$thisStatus = MYSQL_RESULT($result,$i,"status");
			$thisDescription = str_replace('-', '', MYSQL_RESULT($result,$i,"description"));
			// skip forward if type of carriage is found
			if ($i != $numberOfRows)
			{
				$thisType = MYSQL_RESULT($result,$i,"carriage_type");
				if ($thisType != '-')
				{
					$i++;
					$objectArray[] = array($thisId, $thisType, $thisDescription, $thisStatus);
				}
			}
			else
			{
				$thisType = '-';
			}
		}
	}
	return $objectArray;
}

/**
 * returns all carriage sets from the database.
 * results can be limited by status
 * @param status 'outofservice' for as it suggests, otherwise gets objects with the status passed along. leave blank for all objects
 * @return an array of objects. Current carriage set type, then ID, description, and status.
 */
function getAllCarsets($status)
{
	$objectArray = array();
	
	if ($status == 'outofservice')
	{
		$status = " WHERE status != 'service'";
	}
	elseif ($status != '')
	{
		$status = " WHERE status = '$status'";
	}
	
	$sql = "SELECT id AS carset, status, '-' AS carset_type, '0001-01-01' AS date, '-' AS description 
			FROM carset $status 
		UNION ALL
			SELECT carset, '-' AS status, carset_type, date, carset_type.description AS description
				FROM carset_recoded, carset, carset_type $status 
				AND carset.id = carset_recoded.carset AND carset_recoded.carset_type = carset_type.id
				ORDER BY carset ASC, date ASC";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
			
	if ($numberOfRows > 1)
	{
		$nextId = MYSQL_RESULT($result,$i+1,"carset");
		
		for ($i = 0; $i < $numberOfRows; $i++)
		{
			$thisId = MYSQL_RESULT($result,$i,"carset");
			$thisStatus = MYSQL_RESULT($result,$i,"status");
			$thisId = MYSQL_RESULT($result,$i,"carset");
			$thisType = MYSQL_RESULT($result,$i,"carset_type");
			$thisDescription = str_replace('-', '', MYSQL_RESULT($result,$i,"description"));
			
			// skip forward if type of carriage is found
			if ($thisId != $pastId AND $i > 1)
			{
				$pastType = MYSQL_RESULT($result,$i-1,"carset_type");
				$objectArray[] = array($pastId, $pastType, $pastDescription, $thisStatus);
			}
			elseif ($thisId == $pastId AND $numberOfRows <= 2)
			{
				$objectArray[] = array($pastId, $thisType, $pastDescription, $thisStatus);
			}
			
			// last minute clean up
			if ($i == $numberOfRows-1 AND $numberOfRows > 2)
			{
				$objectArray[] = array($thisId, $thisType, $thisDescription, $thisStatus);
			}
			
			$pastId = $thisId;
			$pastType = $thisType;
			$pastDescription = $thisDescription;
		}
	}
	else
	{
		$objectArray = '';
	}
	
	sort($objectArray);
	return $objectArray;
}

function getIfObjectNamed($typeshow, $specific)
{
	switch ($typeshow)
	{
		case locomotive:
			if ($specific == 'N' OR $specific == 'A')
				return true;
		case railcar:
			if ($specific == 'Sprinter')
				return true;
		default:
			return false;
	}
}

function getIfLiveryShown($typeshow)
{
	if ($typeshow == 'carriage_carset')
	{
		$showLivery = false;
	}
	elseif ($typeshow == 'carriage')
	{
		$showLivery = true;
	}
	elseif ($typeshow == 'carset')
	{
		$showLivery = true;
	}
	elseif ($typeshow == 'carriage_type_family')
	{
		$showLivery = false;
	}
	elseif ($typeshow == 'locomotive' OR $typeshow == 'railcar')
	{
		$showLivery = true;
	}
	else
	{
		$showLivery = false;
	}
	return $showLivery;
}


function getIfStatusShown($typeshow)
{
	if ($typeshow == 'carriage')
	{
		$showStatus = true;
	}
	elseif ($typeshow == 'carset')
	{
		$showStatus = true;
	}
	elseif ($typeshow == 'locomotive' OR $typeshow == 'railcar')
	{
		$showStatus = true;
	}
	else
	{
		$showStatus = false;
	}
	return $showStatus;
}

/**
 * returns all objects of a certain TABLE and a certain CODE from the database.
 * three uses:
 * get all XXX type coded carsets and their current code
 * get all XXX type coded carriages and their current code
 * get all member cars of carset and their current carset
 * results can be limited by status
 * @param order SQL specifying how to order the results. Omit the ' ORDER BY ' from the begining
 * @param typeshow the type of TABLE we are hitting. 'carriage_carset' for all members of carset. 'carriage' for all carriages of CODE. 'carset' for all carsets of CODE
 * @param objectype the CODE of object we want
 * @param displaytype 'past' or 'current'
 * @return an array of objects. Current CODE / CARSET, then ID
 */
function getObjectsOfCode($typeshow, $displaytype, $objecttype, $order)
{
	$objectArray = array();
	$showLivery = getIfLiveryShown($typeshow);

	if ($order != '')
	{
		$order = ' ORDER BY '.$order;
	}

	// get all carriages of a specific type
	if ($typeshow == 'carriage_carset')
	{
		$database = 'carriage_carset';
		$fieldtype = 'carset';
		$object = 'carriage';
	}
	elseif ($typeshow == 'carriage')
	{
		$database = 'carriage_converted';
		$fieldtype = 'carriage_type';
		$object = 'carriage';
	}
	elseif ($typeshow == 'carset')
	{
		$database = 'carset_recoded';
		$fieldtype = 'carset_type';
		$object = 'carset';
	}
	elseif ($typeshow == 'carriage_type_family')
	{
		$database = 'family';
		$fieldtype = 'id';
		$object = 'carriage_type_family';
	}
	
	if ($showLivery)
	{
		$sql = "SELECT * FROM $database
			INNER JOIN $object ON $object.id = $database.$object 
			LEFT OUTER JOIN livery ON livery.livery_id = $object.livery 
			WHERE $database.$fieldtype = '$objecttype'
			GROUP BY $object $order ASC, date DESC";
	}
	else
	{	
		$sql = "SELECT * FROM $database, $object
			WHERE $database.$fieldtype = '$objecttype' AND $object.id = $database.$object GROUP BY $object $order ASC, date DESC";
	}
	//echo $sql;
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	//echo $sql.'<br><br>';
	
	if ($numberOfRows > 0)
	{
		//$objectArray[] = array('', 'Status', 'Livery');
		
		for ($i = 0; $i < $numberOfRows; $i++)
		{	
			$objectfound = MYSQL_RESULT($result,$i,$object);
			$status = MYSQL_RESULT($result,$i,'status');
			
			if ($showLivery)
			{
				$livery = MYSQL_RESULT($result,$i,'livery.name');
			}
			
			// check that the said cariage is still in this form
			$sqlcheck = "SELECT * FROM $database
				WHERE `$object` = '$objectfound' ORDER BY date DESC";
			$resultcheck = MYSQL_QUERY($sqlcheck);
			
			if (MYSQL_NUM_ROWS($resultcheck) > 0)
			{
				$objectcheck = MYSQL_RESULT($resultcheck,0,$fieldtype);
				
				// compare the earlier found of the wanted carriage type, 
				// and check the current form of this numbered carriage
				if ($objectcheck == $objecttype)
				{
					// get only carriages still in this form
					if ($displaytype == 'current' AND $status == 'service')
					{
						//echo $objectcheck.'-'.MYSQL_RESULT($result,$i,$object).'------<br><br>';
						$objectArray[] = array(MYSQL_RESULT($result,$i,$object), $objectcheck, '', $status, $livery);
					}
					elseif ($displaytype == 'past' AND $status != 'service')
					{
						//echo $objectcheck.'-'.MYSQL_RESULT($result,$i,$object).'------<br><br>';
						$objectArray[] = array(MYSQL_RESULT($result,$i,$object), $objectcheck, '', $status, $livery);
						
					}
				}
				// gets all carriages with the wanted code, but don't bear it now
				elseif ($displaytype == 'past')
				{
					//echo $objectcheck.'-'.MYSQL_RESULT($result,$i,$object).'------<br><br>';
					$objectArray[] = array(MYSQL_RESULT($result,$i,$object), $objectcheck, '', $status, $livery);
				}
			}
		}
	}
	return $objectArray;
}

function getCarsetsOfFamily($familytype, $family)
{
	$sql = "SELECT * FROM carset o
	LEFT OUTER JOIN livery l ON o.livery = l.livery_id
	WHERE o.family = '$family'";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	$date = date('Y-m-d');
	
//	$objectArray[] = array('', 'Status', 'Livery', 'Description');
	
	for ($i = 0; $i < $numberOfRows; $i++)
	{
		$object = MYSQL_RESULT($result,$i,'o.id');
		$carset = getTypeOfCarsetForDate($date, $object);
		$livery = MYSQL_RESULT($result,$i,'l.name');
		$status = MYSQL_RESULT($result,$i,'o.status');
		$objectArray[] = array($object, $carset['type'], $carset['desc'], $status, $livery);
	}
	return $objectArray;
}

function getObjectsOfFamily($familytype, $family)
{
	$sql = "SELECT * FROM ".$familytype."_family, family, $familytype
		WHERE family.id = '$family' AND ".$familytype."_family.family = family.id 
		AND $familytype.id = ".$familytype."_family.$familytype";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
//	$objectArray[] = array('', 'Description');
	
	for ($i = 0; $i < $numberOfRows; $i++)
	{
		$object = MYSQL_RESULT($result,$i,$familytype);
		$objectdesc = MYSQL_RESULT($result,$i,$familytype.'.description');
		$objectArray[] = array($object, '', $objectdesc);
	}
	
	return $objectArray;
}
	

/**
 * returns any basic objects
 * @param object the database table to grab it from
 * @param id the ID / primary key of the object in the table
 * @return an array with the object. ID, description, content. can be broken apart with "extract()"
 */
function getObject($object, $id)
{
	$showLivery = getIfLiveryShown($object);
	
	if ($showLivery)
	{
		$sql = " LEFT OUTER JOIN livery l ON o.livery = l.livery_id ";
	}
	
	$sql = "SELECT * FROM $object o $sql
			WHERE o.id = '$id' LIMIT 0, 1";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
	if ($numberOfRows > 0)
	{
		$return['id'] = MYSQL_RESULT($result,0,"id");
		$return['description'] = stripslashes(MYSQL_RESULT($result,0,"o.description"));
		$return['content'] = stripslashes(MYSQL_RESULT($result,0,"o.content"));
		
		if ($showLivery)
		{
			$return['livery'] = stripslashes(MYSQL_RESULT($result,0,"l.name"));
		}
		
		if (getIfStatusShown($object))
		{
			$return['status'] = stripslashes(MYSQL_RESULT($result,0,"o.status"));
		}
		
		if ($object == 'family')
		{
			$return['carset_content'] = stripslashes(MYSQL_RESULT($result,0,"o.carset_content"));
			$return['carriage_content'] = stripslashes(MYSQL_RESULT($result,0,"o.carriage_content"));
		}
		
		if ($object == 'locomotive')
		{
			$return['class'] = MYSQL_RESULT($result,0,"o.class");
			
		}
		
		if ($object == 'railcar')
		{
			$return['type'] = MYSQL_RESULT($result,0,"o.railcar_type");
		}
			
	}
	return $return;
}




function getCarsetType($id)
{
	$sql = "SELECT * FROM carset_type, carset_type_family 
	WHERE id = '$id' 
	AND carset_type_family.carset_type = carset_type.id 
	LIMIT 0, 1";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
	if ($numberOfRows > 0)
	{
		$return['id'] = MYSQL_RESULT($result,0,"id");
		$return['description'] = stripslashes(MYSQL_RESULT($result,0,"description"));
		$return['content'] = stripslashes(MYSQL_RESULT($result,0,"content"));
		$return['family'] = stripslashes(MYSQL_RESULT($result,0,"family"));
			
	}
	return $return;
}

/**
 * returns a carriage
 * @param id the ID / primary key of the carriage in the table
 * @return an array with the object. ID, description, 
 * description of the parent CODE, current CODE, current CARSET, 
 * current carset type, status, content. 
 * can be broken apart with "extract()"
 */
function getCarriage($id)
{
	$sql = "SELECT * FROM carriage 
		LEFT OUTER JOIN carriage_converted ON carriage_converted.carriage = carriage.id  
		LEFT OUTER JOIN carriage_carset ON carriage_carset.carriage = carriage.id 
		LEFT OUTER JOIN carset_recoded ON carset_recoded.carset = carriage_carset.carset 
		LEFT OUTER JOIN carriage_type ON carriage_type.id = carriage_converted.carriage_type 
		LEFT OUTER JOIN livery ON carriage.livery = livery.livery_id 
		WHERE carriage.id = '$id' 
		ORDER BY carriage_carset.date DESC, carriage_converted.date DESC, carset_recoded.date DESC
		LIMIT 0, 1";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
	if ($numberOfRows > 0)
	{
		$carriage['id'] = MYSQL_RESULT($result,$i,"carriage.id");
		$carriage['description'] = stripslashes(MYSQL_RESULT($result,$i,"carriage.description"));
		$carriage['typedescription'] = stripslashes(MYSQL_RESULT($result,$i,"carriage_type.description"));
		$carriage['type'] = MYSQL_RESULT($result,$i,"carriage_converted.carriage_type");
		$carriage['set'] = MYSQL_RESULT($result,$i,"carriage_carset.carset");
		$carriage['status'] = MYSQL_RESULT($result,$i,"carriage.status");
		$carriage['settype'] = stripslashes(MYSQL_RESULT($result,$i,"carset_recoded.carset_type"));
		$carriage['content'] = stripslashes(MYSQL_RESULT($result,0,"carriage.content"));
		$carriage['livery'] = stripslashes(MYSQL_RESULT($result,0,"livery.name"));
		$carriage['liverylink'] = stripslashes(MYSQL_RESULT($result,0,"livery.livery_id"));
	}	
	return $carriage;
}

/**
 * get the designation of a carset dependant on the year
 * @param carset the carset to check for in the table
 * @param date the date to check for, looks for last events before this date
 * @return the current CODE of a carset
 */
function getTypeOfCarsetForDate($date, $carset)
{
	$result = MYSQL_QUERY("SELECT * 
						FROM carset_recoded cr
						INNER JOIN carset_type ct ON ct.id = cr.carset_type
						WHERE (date <= '$date' OR date = '9999-01-01') AND cr.carset = '$carset' 
						ORDER BY date DESC");
	if (MYSQL_NUM_ROWS($result) >= 1)
	{
		$toreturn['type'] = MYSQL_RESULT($result,$i,"carset_type");
		$toreturn['numberCars'] = MYSQL_RESULT($result,$i,"cars");
		$toreturn['desc'] = MYSQL_RESULT($result,$i,"description");
		return $toreturn;
	}
	
}	// end function

/**
 * get the designation of a carriage dependant on the year
 * @param carset the carriage to check for in the table
 * @param date the date to check for, looks for last events before this date
 * @return the current CODE of a carriage
 */
function getCarriageType($date, $carriage)
{
	$result = MYSQL_QUERY("SELECT * FROM carriage_converted WHERE date <= '$date' AND carriage = '$carriage' ORDER BY date DESC");
	if (MYSQL_NUM_ROWS($result) >= 1)
	{
		return MYSQL_RESULT($result,$i,"carriage_type");
	}
	
}	// end function


/**
 * returns a carset
 * @param id the ID / primary key of the carset in the table
 * @return an array with the object. ID, description, current CODE, 
 * status, content. can be broken apart with "extract()"
 */
function getCarset($id)
{
	$sql = "SELECT * FROM carset
		LEFT OUTER JOIN carset_recoded ON carset_recoded.carset = carset.id 
		LEFT OUTER JOIN carset_type ON carset_recoded.carset_type = carset_type.id
		LEFT OUTER JOIN livery ON livery.livery_id = carset.livery 
		WHERE carset.id = '$id' 
		ORDER BY carset_recoded.date DESC
		LIMIT 0, 1";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
	if ($numberOfRows > 0)
	{
		$set['id'] = MYSQL_RESULT($result,$i,"carset.id");
		$set['description'] = stripslashes(MYSQL_RESULT($result,$i,"carset.description"));
		$set['typedescription'] = stripslashes(MYSQL_RESULT($result,$i,"carset_type.description"));
		$set['type'] = MYSQL_RESULT($result,$i,"carset_recoded.carset_type");
		$set['status'] = MYSQL_RESULT($result,$i,"carset.status");
		$set['content'] = stripslashes(MYSQL_RESULT($result,0,"carset.content"));
		$set['livery'] = stripslashes(MYSQL_RESULT($result,0,"livery.name"));
		$set['liverylink'] = stripslashes(MYSQL_RESULT($result,0,"livery.livery_id"));
	}	
	return $set;
}

/**
 * returns all the events for a particular type of object
 * @param id the ID / primary key of the carset in the table
 * @return an array with the object. ID, description, current CODE, 
 * status, content. can be broken apart with "extract()"
 * returns an array of the events for given object type
 * can use for carriage, carriage_type, carset, carset_type, familiy, railcar, railcarset, and railcarset_type
 */

function getEventsOfType($database, $where, $order='')
{
	$eventArray = array();
	$typeofobject = str_replace('_event', '', $database);
	
	if ($order != '')
	{
		$order = ' ORDER BY '.$order;
	}
	
	if ($where != '')
	{
		$where = ' WHERE '.$where;
	}
	
	$sql = "SELECT DATE_FORMAT(date, '%e %M, %Y') AS fdate, date AS plaindate, id, why, note, type, $typeofobject FROM $database $where $order";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
	if ($numberOfRows > 0)
	{
		for ($i = 0; $i < $numberOfRows; $i++)
		{
			$thisId = MYSQL_RESULT($result,$i,"id");
			$thisObject = MYSQL_RESULT($result,$i,$typeofobject);
			$thisPlainDate = MYSQL_RESULT($result,$i,"plaindate");
			$thisDate = MYSQL_RESULT($result,$i,"fdate");
			$thisWhy = MYSQL_RESULT($result,$i,"why");
			$thisNote = MYSQL_RESULT($result,$i,"note");
			$thisType = MYSQL_RESULT($result,$i,"type");
			
			$eventArray[] = array($thisId, $thisObject, $thisDate, $thisWhy, $thisNote, $thisType);
		}
	}	
	return $eventArray;
}

 /**
 * returns all the events for a carriage 
 * carriage movements, 
 * carriage only events, 
 * carriage conversions, 
 * and carset events when the car was part of the set.  
 * @param car the ID / primary key of the carriage in the table
 * @return an array with the events. PlainDate, Date, 
 * Why (sighting, book date, ect), Note about event, carriage type Converted to,
 * carriage set added to, type of event
 */
function getCarriageEvents($car)
{
	
	$sql = "SELECT DATE_FORMAT(date, '%e %M, %Y') AS fdate, date AS plaindate, why, note, 
		'-' AS `carset`, '-' AS carriage_type, type 
		FROM carriage_event WHERE carriage = $car
			UNION
		SELECT DATE_FORMAT(date, '%e %M, %Y') AS fdate, date AS plaindate, why, note, `carset`, 
		'-' AS carriage_type, 'moved' AS type 
		FROM carriage_carset WHERE carriage = '$car'
			UNION
		SELECT DATE_FORMAT(date, '%e %M, %Y') AS fdate, date AS plaindate, why, note, 
		'-' AS `set`, carriage_type, 'converted' AS type 
		FROM carriage_converted WHERE carriage = '$car'
			UNION
		SELECT DATE_FORMAT(carset_event.date, '%e %M, %Y') AS fdate, carset_event.date AS plaindate, carset_event.why, carset_event.note, 
		carriage_carset.carset AS `carset`, 'set' AS carriage_type, type  
		FROM carset_event, carriage_carset 
		WHERE carset_event.carset = carriage_carset.carset AND carriage_carset.carriage = '$car' 
		ORDER BY plaindate ASC";
		//echo $sql;
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
	if ($numberOfRows > 0)
	{
		for ($i = 0; $i < $numberOfRows; $i++)
		{
			$thisPlainDate = MYSQL_RESULT($result,$i,"plaindate");
			$thisDate = MYSQL_RESULT($result,$i,"fdate");
			$thisWhy = MYSQL_RESULT($result,$i,"why");
			$thisNote = MYSQL_RESULT($result,$i,"note");
			$thisConvert = MYSQL_RESULT($result,$i,"carriage_type");
			$thisSetId = MYSQL_RESULT($result,$i,"carset");
			$thisSetType = getTypeOfCarsetForDate($thisPlainDate, $thisSetId);
			$thisSet = $thisSetType['type'].$thisSetId;
			$thisType = MYSQL_RESULT($result,$i,"type");
			 
			if ($thisConvert != 'set')
			{
				$eventArray[] = array($thisPlainDate, $thisDate, $thisWhy, $thisNote, $thisConvert, $thisSet, $thisType);
			}
			else
			{
				$sql = "SELECT * FROM carriage_carset WHERE carriage = '$car' ORDER BY date ASC";
				//echo $sql.'<br>';
				$dateresult = MYSQL_QUERY($sql);
				$numberOfRowsDate = MYSQL_NUM_ROWS($dateresult);
				
				for ($j = 0; $j < $numberOfRowsDate; $j++)
				{
					$thisDateSetId = MYSQL_RESULT($dateresult,$j,"carset");
					
					//echo '<br>'.$thisDateSetId.'----';
					//echo $thisSetId.'<br>';
					
					if ($thisDateSetId == $thisSetId)
					{
						if ($j < ($numberOfRowsDate-1))
						{
							//echo $numberOfRowsDate.'<br>';
							$thisTopDate = MYSQL_RESULT($dateresult,$j+1,"date");
						}
						else
						{
							$thisTopDate = '9999-01-01';
						}
						$thisBottomDate = MYSQL_RESULT($dateresult,$j,"date");
						
						//echo $thisTopDate.' top----';
						//echo $thisPlainDate.' middle----';
						//echo $thisBottomDate.' bottom----';
						//echo $thisDateSetId.' in set----';
						
						if ($thisPlainDate <= $thisTopDate AND $thisPlainDate >= $thisBottomDate )
						{
							// fix up event parameters before adding
							$thisNote = "Set $thisSet: $thisNote";
							$thisSet = '-';
							$thisConvert = '-';
							$eventArray[] = array($thisPlainDate, $thisDate, $thisWhy, $thisNote, $thisConvert, $thisSet, $thisType);
						}
					}
				}
			}
		}
		sort($eventArray, 0);
	}	
	return $eventArray;
}

 /**
 * returns all the events for a carriage set 
 * carriage movements, 
 * carset only events, 
 * and carset recodings. 
 * @param set the ID / primary key of the carriage in the table
 * @return an array with the events. PlainDate, Date, 
 * Why (sighting, book date, ect), Note about event, carset type recoded to,
 * carriage added to set , type of event
 */
function getCarsetEvents($set)
{
	$sql = "SELECT DATE_FORMAT(date, '%e %M, %Y') AS fdate, date AS plaindate, why, note, '-' AS `carriage`, '-' AS carset_type, `type`  
		FROM carset_event WHERE `carset` = '$set'
			UNION
		SELECT DATE_FORMAT(date, '%e %M, %Y') AS fdate, date AS plaindate, why, note, `carriage`, '-' AS carset_type, 'moved' AS type 
		FROM carriage_carset WHERE `carset` = '$set'
			UNION
		SELECT DATE_FORMAT(date, '%e %M, %Y') AS fdate, date AS plaindate, why, note, '-' AS `carriage`, carset_type, 'recoded' AS type  
		FROM carset_recoded WHERE `carset` = '$set'
		ORDER BY plaindate ASC";
		
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
	if ($numberOfRows > 0)
	{
		for ($i = 0; $i < $numberOfRows; $i++)
		{
			$thisPlainDate = MYSQL_RESULT($result,$i,"plaindate");
			$thisDate = MYSQL_RESULT($result,$i,"fdate");
			$thisWhy = MYSQL_RESULT($result,$i,"why");
			$thisNote = MYSQL_RESULT($result,$i,"note");
			$thisConvert = MYSQL_RESULT($result,$i,"carset_type");
			$thisCarno = MYSQL_RESULT($result,$i,"carriage");
			$thisCar = getCarriageType($thisPlainDate, $thisCarno).$thisCarno;
			$thisType = MYSQL_RESULT($result,$i,"type");
			
			// if it is a car movement event INTO the set
			// find out when the car is moved to ANOTHER set
			if ($thisCarno != '-')
			{
				$sqlnextevent = "SELECT DATE_FORMAT(date, '%e %M, %Y') AS fdate, date AS plaindate, why, note, carriage, carset 
					FROM carriage_carset WHERE carriage = '$thisCarno' AND`carset` != '$set' AND date > '$thisPlainDate' ORDER BY date ASC";
				$resultnextevent = MYSQL_QUERY($sqlnextevent);
				if (MYSQL_NUM_ROWS($resultnextevent) > 0)
				{
					$altPlainDate = MYSQL_RESULT($resultnextevent,0,"plaindate");
					$altDate = MYSQL_RESULT($resultnextevent,0,"fdate");
					$altNote = MYSQL_RESULT($resultnextevent,0,"note");
					$altCar = getCarriageType($altPlainDate, $thisCarno).$thisCarno;
					$altWhy = 'removed';
					$altType = 'removed';
					$altConvert = '-';
					$eventArray[] = array($altPlainDate, $altDate, $altWhy, $altNote, $altConvert, $altCar, $altType);
				}
			}
			
			$eventArray[] = array($thisPlainDate, $thisDate, $thisWhy, $thisNote, $thisConvert, $thisCar, $thisType);
		}
		sort($eventArray, 0);
	}	
	return $eventArray;
}


?>