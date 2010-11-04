<?php
/**
 * Photostream
 *
 * Enables you to replicate the photostream feature of Flickr
 *
 * @author Marcus Wong (wongm)
 * @package plugins
 */

$plugin_description = gettext("Provides direct database access, the other plugins require.");
$plugin_author = "Marcus Wong (wongm)";
$plugin_version = '1.0.0'; 
//$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_".PLUGIN_FOLDER."---contact_form.php.html";

function getDBResults($pageTypeModifier, $start, $count)
{
	global $_zp_current_photostream_page, $_zp_current_photostream_recordset, $_zp_current_photostream_recordset_index, $_zp_current_photostream_totalcount, $_zp_current_photostream_urlbase;
	
	if ($count == '')
	{
		$count = getOption('photostream_number_to_show');
	}
	
	if ($count < getOption('photostream_number_to_show'))
	{
		$dontDoTotalCount = true;
	}
	
	if ($pageTypeModifier == 'double')
	{
		if (!($count > 1))
		{
			$count = getOption('photostream_number_to_show');
		}
		if (!is_numeric($start))
		{
			$start = 0;
		}
		
		$nextURL .= "?double=&count=$count&start=$start&page=" . ($_zp_current_photostream_page + 1);
	
		$sql = "SELECT * FROM " . prefix('images') . " images
			INNER JOIN " . prefix('albums') . " albums ON images.albumid = albums.id 
			WHERE images.filename IN (
				SELECT filename 
				FROM (
					SELECT filename, count(id) AS duplicates 
					FROM " . prefix('images') . "
					GROUP BY filename) AS inner_query 
				WHERE duplicates > 1)
			ORDER BY images.date DESC
			LIMIT $start, $count";
	}
	else
	{
		$captionLimitSql = "images.title REGEXP '" . getOption('photostream_caption_regex') . "' OR images.title REGEXP 'DSCF[0-9]{4}'";
		$captiona = $captionb = '';
		$order = " ORDER BY images.date DESC ";
		
		//show all images with bad captions
		if ($pageTypeModifier == 'images')
		{
			$nextURL .= "?caption=images&page=" . ($_zp_current_photostream_page + 1);
			$captiona = " AND ($captionLimitSql)";
			$captionb = "";
		}
		//show only albums that have one or more images with bad captions
		else if ($pageTypeModifier == 'albums')
		{
			$nextURL .= "?caption=albums&page=" . ($_zp_current_photostream_page + 1);
			$captiona = " AND ($captionLimitSql)";
			$captionb = " GROUP BY albumid ";
		}
		//change to order by how popular
		else
		{
			if ($pageTypeModifier == 'this-month')
			{
				$order = " ORDER BY images.hitcounter_month DESC";
				$where = " AND images.hitcounter_month > 0 ";
			}
			else if ($pageTypeModifier == 'this-week')
			{
				$order = " ORDER BY images.hitcounter_week DESC";
				$where = " AND images.hitcounter_week > 0 ";
			}
			else if ($pageTypeModifier == 'all-time')
			{
				$order = " ORDER BY images.hitcounter DESC";
			}
			else if ($pageTypeModifier == 'ratings')
			{
				$order = " ORDER BY images.ratings_score DESC, images.hitcounter DESC";
				$where = " AND images.ratings_view > 0 ";
			}
		}
		
		$sql = "SELECT * FROM " . prefix('images') . " images, " . prefix('albums') . " albums
			WHERE images.albumid = albums.id $captiona $captionb $where
			$order
			LIMIT $_zp_current_photostream_recordset_index,$count";
	}
	
	if (!$dontDoTotalCount) {
		$_zp_current_photostream_totalcount = MYSQL_RESULT(MYSQL_QUERY("SELECT count(*) 
			FROM " . prefix('images') . " images, " . prefix('albums') . " albums
			WHERE images.albumid = albums.id $captiona $captionb $where"), 0, 'count(*)');
	}
	
	$_zp_current_photostream_recordset = MYSQL_QUERY($sql);
	$_zp_current_photostream_urlbase = $nextURL;
	
	return $toreturn;
}

function loadNextPhotostreamImage()
{
	global $_zp_current_photostream_page, $_zp_current_photostream_totalcount, $_zp_current_photostream_recordset, $_zp_current_photostream_recordset_index, $_zp_current_photostream_current_image;
	
	// get the index into the current paginated record set
	$i = ($_zp_current_photostream_recordset_index % getOption('photostream_number_to_show'));
	
	// are we off the end of the paginated record set?
	if ($_zp_current_photostream_recordset_index >= ((int)getOption('photostream_number_to_show') * $_zp_current_photostream_page)
		OR $_zp_current_photostream_recordset_index >= $_zp_current_photostream_totalcount)
	{
		$_zp_current_photostream_current_image = null;
		return;
	}
	// grab all of the items for the current image
	else
	{
		$photoUrl =  MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.filename");
		$photoPath = MYSQL_RESULT($_zp_current_photostream_recordset,$i,"albums.folder");
		$photoDate = stripslashes(MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.date"));
		
		$toReturn['photoTitle'] = 		stripslashes(MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.title"));
		$toReturn['photoDesc'] = 		stripslashes(MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.desc"));
		$toReturn['photoId'] = 			MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.id");
		$toReturn['photoAlbumTitle'] = 	stripslashes(MYSQL_RESULT($_zp_current_photostream_recordset,$i,"albums.title"));
		$toReturn['photoDate'] = 		zpFormattedDate(getOption('date_format'),strtotime($photoDate));
					
		if ($type == 'ratings')
		{
			$toReturn['wins'] = 			MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.ratings_win");
			$toReturn['views'] = 			MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.ratings_view");
			$toReturn['score'] = 			MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.ratings_score");
			$toReturn['photoStatsText'] = 	formatRatingCounter(array($wins, $views, $score));
		}
		// any other type of popular / recent pages
		else
		{
			global $_zp_rollingImageStatistics_type;
			
			$toReturn['hitsAll'] = 		$hitsAll = 		MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.hitcounter");
			$toReturn['hitsMonth'] = 	$hitsMonth = 	MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.hitcounter_month");
			$toReturn['hitsWeek'] = 	$hitsWeek = 	MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.hitcounter_week");
			$photoHitcounter = array($hitsAll, $hitsMonth, $hitsWeek, $_zp_rollingImageStatistics_type);
			
			if ( zp_loggedin() )
			{
				$id = MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.id");
				$toReturn['hitCounterWeekLastReset'] = MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.hitcounter_week_reset");
				$toReturn['hitCounterMonthLastReset'] = MYSQL_RESULT($_zp_current_photostream_recordset,$i,"images.hitcounter_month_reset");
				$updatedHitCounter = updateHitCounter($hitsAll, $hitsMonth, $hitsWeek, $hitCounterMonthLastReset, $hitCounterWeekLastReset);
										 
				// only reset the monthly and weekly totals if and admin, and counter are past the date
				if ($updatedHitCounter['admin'] != '') 
				{
					//query("UPDATE " . prefix('images') . " SET ".$updatedHitCounter['admin']." WHERE `id` = $id");
					//$photoHitcounter = array($updatedHitCounter['hitCounterAllTime'], $updatedHitCounter['hitCounterMonth'], $updatedHitCounter['hitCounterWeek'], $_zp_rollingImageStatistics_type);
				}
			}
			$toReturn['photoStatsText'] = formatHitCounter($photoHitcounter);
		}
		
		if ($photoDesc == '')
		{
			$toReturn['photoDesc'] = $photoTitle;
		}
		else
		{
			$toReturn['photoDesc'] = 'Description: ' . $toReturn['photoDesc'];
		}
		
		$toReturn['imagePageLink'] = "/$photoPath/$photoUrl.html";
		$toReturn['albumPageLink'] = "/$photoPath/";
		$toReturn['imageUrl'] = "/$photoPath/image/thumb/$photoUrl";
	}
	
	$_zp_current_photostream_recordset_index++;
	$_zp_current_photostream_current_image = $toReturn;
}


?>