<?php
/**
 * Rolling image statistics
 *
 * Keeps track of image hitcount statistics on a weekly, monthly and all time basis
 *
 * @author Marcus Wong (wongm)
 * @package plugins
 */

$plugin_description = gettext("Keeps track of image hitcount statistics on a weekly, monthly and all time basis.");
$plugin_author = "Marcus Wong (wongm)";
$plugin_version = '1.0.0'; 
//$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_".PLUGIN_FOLDER."---contact_form.php.html";
$plugin_disable = (!array_key_exists('direct-db-access', getEnabledPlugins())) ? gettext("'direct-db-access' plugin is required to use this plugin.") : false;


function setupStatisticsPage()
{
	
	global $_zp_current_photostream_page, $_zp_current_photostream_recordset, $_zp_current_photostream_recordset_index, $_zp_current_photostream_urlbase;
	
	global $_zp_rollingImageStatistics_type;
	
	// verify page number
	$_zp_current_photostream_page = $_REQUEST['page'];
	if (!is_numeric($_zp_current_photostream_page) OR $_zp_current_photostream_page < 1)
	{
		$_zp_current_photostream_page = 1;
	}

	// various modifiers for the recent upload pages
	$_zp_rollingImageStatistics_type = $_REQUEST['period'];

	
	if ($_zp_current_photostream_page == '' OR $_zp_current_photostream_page <= 1 OR !is_numeric($_zp_current_photostream_page))
	{
		$_zp_current_photostream_recordset_index = 0;
	}
	else
	{
		$_zp_current_photostream_recordset_index = ($_zp_current_photostream_page*getOption('statistics_number_to_show'))-getOption('statistics_number_to_show');
	}
	
	// get gallery results, number of records, total number of records, and modified value of the next URL
	getDBResults($_zp_rollingImageStatistics_type, $start, $count);
}

function getStatisticsListingPageTitle()
{
	global $_zp_rollingImageStatistics_type;
	
	switch ($_zp_rollingImageStatistics_type)
	{
		case 'this-week':
			return 'Most viewed this week';
		case 'this-month':
			return 'Most viewed this month';
		case 'all-time':
			return 'Most viewed of all time';
		case 'ratings':
			return 'Highest rated';
	}
}

function getStatisticsPageTitle()
{
	if (isStatisticsListingPage())
	{
		return 'Popular photos - ' . getStatisticsListingPageTitle();
	}
	else
	{
		return 'Popular photos';
	}
}

function getStatisticsPageBaseURL()
{
	global $_zp_rollingImageStatistics_type;
	
	return "/page/statistics/$_zp_rollingImageStatistics_type";
}

function getStatisticsPageBreadCrumbs($seperator='&raquo;')
{
	$toReturn = "<a href=\"".POPULAR_URL_PATH."\" title=\"Popular photos\">Popular photos</a>";
	
	if (isStatisticsListingPage())
	{
		$toReturn .= " $seperator <a href=\"" . getStatisticsPageBaseURL() . "\" title=\"" . getStatisticsListingPageTitle() . "\">" . getStatisticsListingPageTitle() . "</a>";
	}
	
	return $toReturn;
}

function isStatisticsListingPage()
{
	global $_zp_rollingImageStatistics_type;
	
	return ($_zp_rollingImageStatistics_type != '');
}

function getMyHitCounter($obj)
{
	return formatHitCounter(array($obj->get('hitcounter'), $obj->get('hitcounter_month'), $obj->get('hitcounter_week')));
}

function printHitCounter($obj, $break=false)
{
	$text = getMyHitCounter($obj);
	
	if ($break and strlen($text ) > 0)
	{
		echo "<br>$text";
	}
	else
	{
		echo $text;
	}
}

function formatHitCounter($array, $splitLines=true)
{
	$alltime = $array[0];
	$month = $array[1];
	$week = $array[2];
	$galleryType = $array[3];
	
	// return just a single row, for the overall gallery listing pages
	if ($galleryType == 'this-month') {
		$toreturn = $month;
		$extraText = " this month";
	} else if ($galleryType == 'this-week') {
		$toreturn = $week;
		$extraText = " this week";
	} else if ($galleryType == 'all-time') {
		$toreturn = $alltime;
	}
	
	if ($toreturn > 0) {
		return "Viewed ".pluralNumberWord($toreturn, 'time').$extraText;
	}
	
	// otherwise build up a massive string
	if ($alltime > 0) {
		$toreturn = "Viewed ".pluralNumberWord($alltime, 'time');
	} else {
		return "";
	}
	
	if ($week > 0) {
		$toreturn .= "<br>(".pluralNumberWord($week, 'time')." this week";
		
		if ($month > 0) {
			$toreturn .= ", ".pluralNumberWord($month, 'time')." this month)";
		} else {
			$toreturn .= ")";
		}
	} else if ($month > 0) {
		$toreturn .= "<br>(".pluralNumberWord($month, 'time')." this month)";
	}
	
	// formattting fix for album page, when not in EXIF box
	if (!$splitLines) {
		$toreturn = str_replace('<br>',' ',$toreturn);
	}
	return $toreturn;
}



function incrementAndReturnHitCounter($option='image', $viewonly=false, $id=NULL) {
	global $_zp_current_image, $_zp_current_album;
	
	switch($option) {
		case "image":
			$obj = $_zp_current_image;
			if (is_null($id)) {
				$id = getImageID();
			}
			$dbtable = prefix('images');
			$doUpdate = true;
			break;
		case "album":
			$obj = $_zp_current_album;
			if (is_null($id)) {
				$id = getAlbumID();
			}
			$dbtable = prefix('albums');
			$doUpdate = getCurrentPage() == 1; // only count initial page for a hit on an album
			break;
	}
	
	// get currrent counters and dates
	if ($obj != null) {	
		$hitCounterAllTime = $obj->get('hitcounter');
		$hitCounterMonth = $obj->get('hitcounter_month');
		$hitCounterWeek = $obj->get('hitcounter_week');
	} else {
		$doUpdate = false;
	}
	
	// check to see if changing from small to full size, or vice versa, then don't update counter
	if (substr_count($_SERVER['HTTP_REFERER'], str_replace('?p=full','', $_SERVER['REQUEST_URI'])) > 0) {
		$doUpdate = false;
	}
	
	// update counters if required
	if ( $doUpdate ) {
		
		$hitCounterMonthLastReset = $obj->get('hitcounter_month_reset');
		$hitCounterWeekLastReset = $obj->get('hitcounter_week_reset');
		
		$updatedHitCounter = updateHitCounter($hitCounterAllTime, $hitCounterMonth, $hitCounterWeek, $hitCounterMonthLastReset, $hitCounterWeekLastReset);
		
		// only reset the monthly and weekly totals if and admin, and counter are past the date
		if ( zp_loggedin() && $updatedHitCounter['admin'] != '') 
		{
			query("UPDATE $dbtable SET ".$updatedHitCounter['admin']." WHERE `id` = $id");
		}
		
		$hitCounterAllTime = $updatedHitCounter['hitCounterAllTime'];
		$hitCounterMonth = $updatedHitCounter['hitCounterMonth'];
		$hitCounterWeek = $updatedHitCounter['hitCounterWeek'];
	}
	return array($hitCounterAllTime, $hitCounterMonth, $hitCounterWeek);
}

function updateHitCounter($hitCounterAllTime, $hitCounterMonth, $hitCounterWeek, $hitCounterMonthLastReset, $hitCounterWeekLastReset)
{
	$time = time();
	$dateCurrent = date("Y-m-d");
	$dateLastWeek = date("Y-m-d", $time - (60*60*24*6));
	$dateLastMonth = date("Y-m-d", $time - (60*60*24*28));
	
	// alter the various counts
	if ( !zp_loggedin() )
	{
		$restartCount = 1;
	}
	else
	{
		$restartCount = 0;
	}
	
	// check last reset dates, fix if not set
	if ($hitCounterMonthLastReset == '0000-00-00' OR $hitCounterWeekLastReset == '0000-00-00') 
	{
		$adminSqlToUpdate = $publicSqlToUpdate = 
			", hitcounter_week_reset = '$dateCurrent', hitcounter_month_reset = '$dateCurrent', hitcounter_week = $restartCount, hitcounter_month = $restartCount";
		$hitCounterWeek = $restartCount;
		$hitCounterMonth = $restartCount;
	}
	else
	{
		
		// update week hit counters and last reset times if required
		if ($hitCounterWeekLastReset < $dateLastWeek) 
		{
			$sql = ", hitcounter_week_reset = '$dateCurrent', hitcounter_week = $restartCount ";
			$publicSqlToUpdate .= $sql;
			$adminSqlToUpdate .= $sql;
			$hitCounterWeek = $restartCount;
		}
		else 
		{
			$publicSqlToUpdate .= ", hitcounter_week = $hitCounterWeek ";
		}
		
		// update month hit counters and last reset times if required
		if ($hitCounterMonthLastReset < $dateLastMonth) 
		{
			$sql = ", hitcounter_month_reset = '$dateCurrent', hitcounter_month = $restartCount ";
			$publicSqlToUpdate .= $sql;
			$adminSqlToUpdate .= $sql;
			$hitCounterMonth = $restartCount;
		} 
		else 
		{
			$publicSqlToUpdate .= ", hitcounter_month = $hitCounterMonth ";
		}
	}
		
	// remove leading comma if required
	if (substr($adminSqlToUpdate, 0, 1) == ',') 
	{
		$adminSqlToUpdate = substr($adminSqlToUpdate, 1, strlen($adminSqlToUpdate));
	}
	
	if (substr($publicSqlToUpdate, 0, 1) == ',') 
	{
		$publicSqlToUpdate = substr($publicSqlToUpdate, 1, strlen($publicSqlToUpdate));
	}
	
	//$toreturn['public'] = "`hitCounter`= $hitCounterAllTime $publicSqlToUpdate";
	$toreturn['public'] = $publicSqlToUpdate;
	$toreturn['admin'] = $adminSqlToUpdate;
	$toreturn['hitCounterWeek'] = $hitCounterWeek;
	$toreturn['hitCounterMonth'] = $hitCounterMonth;
	$toreturn['hitCounterAllTime'] = $hitCounterAllTime;
	
	return $toreturn;
}


	
?>