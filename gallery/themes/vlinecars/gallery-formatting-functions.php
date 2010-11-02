<?php

//******************************************************************************
// Miscellaneous functions for the ZenPhoto gallery that I need
//
// For railgeelong.com and wongm.railgeelong.com
//
// V 1.0.0
//
//******************************************************************************

function pluralNumberWord($number, $text)
{
	if (is_numeric($number))
	{
		if ($number == 0)
		{
			return $number.' '.$text.'s';
		}
		if ($number > 1)
		{
			return $number.' '.$text.'s';
		}
		else
		{
			return "$number $text";
		}
	}
}

function getNumberCurrentDispayedRecords($maxRecordsPerPage,$numberOfRecords,$searchPageNumber)
{
	if ($numberOfRecords != $totalNumberOfRecords)
	{
		$lowerBound = ($maxRecordsPerPage*$searchPageNumber)+1;
		$upperBound = $lowerBound+$numberOfRecords-1;
		$extraBit = "$lowerBound to $upperBound shown on this page";
	}
	return $extraBit;
}

function getFullImageLinkURL() {
	if ($_REQUEST['p'] == 'full')
	{
		if(!in_context(ZP_IMAGE)) return false;
  global $_zp_current_album, $_zp_current_image;
  return rewrite_path('/' . pathurlencode($_zp_current_album->name) . '/' . urlencode($_zp_current_image->name) . im_suffix(),
    '/index.php?album=' . urlencode($_zp_current_album->name) . '&image=' . urlencode($_zp_current_image->name));
	}
	else
	{
		if(!in_context(ZP_IMAGE)) return false;
	  global $_zp_current_album, $_zp_current_image;
	  return rewrite_path('/' . pathurlencode($_zp_current_album->name) . '/' . urlencode($_zp_current_image->name) . im_suffix() . '?p=full',
	    '/index.php?album=' . urlencode($_zp_current_album->name) . '&image=' . urlencode($_zp_current_image->name));
    }
}

function drawRandomPage()
{
	echo "<table class=\"centeredTable\">";
	$i=0;
	$j=0;

	while ($i < MAXIMAGES_PERRANDOM)
	{
		echo "<tr>";

		while ($j < 3)
		{
			$randomImage = getRandomImages();
			$randomImageURL = getURL($randomImage);
			$photoTitle = $randomImage->getTitle();
			$photoDate = strftime(TIME_FORMAT, strtotime($randomImage->getDateTime()));
			$imageCode = "<img src='".$randomImage->getThumb()."' alt='".$photoTitle."'>";

			$albumForPhoto = $randomImage->getAlbum();
			$photoAlbumTitle = $albumForPhoto->getTitle();
			$photoPath = $albumForPhoto->getAlbumLink();

			if ($photoDesc == '')
			{
				$photoDesc = $photoTitle;
			}
			else
			{
				$photoDesc = 'Description: '.$photoDesc;
			}
?>
<td class="i" width="30%"><a href="http://<?=$_SERVER['HTTP_HOST'].$randomImageURL?>"><?=$imageCode?></a>
	<h4><a href="http://<?=$_SERVER['HTTP_HOST'].$randomImageURL?>"><?=$photoTitle; ?></a></h4>
	<small><?=$photoDate?><? printHitCounter($randomImage); ?></small><br/>
	In Album: <a href="http://<?=$_SERVER['HTTP_HOST'].$photoPath; ?>"><?=$photoAlbumTitle; ?></a>
</td>
<?
			$j++;
			$i++;
		}	//end while for cols
		$j=0;
		echo "</tr>";
	}	//end while for rows

	echo "</table>";
}

/*
function getRecentImageLink()
{
	$recentSQL = "SELECT zen_images.filename, zen_images.date, zen_albums.folder FROM `zen_images`, `zen_albums`
		WHERE zen_images.albumid = zen_albums.id
		ORDER BY zen_images.id DESC LIMIT 0 , 1";
	$lastImage = query_full_array($recentSQL);
	$recenturl = "http://".$_SERVER['HTTP_HOST'].'/'.$lastImage[0]['folder'].
		'/image/'.getOption('thumb_size').'/'.$lastImage[0]['filename'];
	return "<img src=\"$recenturl\" title=\"Recent Uploads\" alt=\"Recent Uploads\" />";
}
*/

function getMostRecentImageDate()
{
	global $mostRecentImageDate;

	// only get if not cached
	if ($mostRecentImageDate == '')
	{
		$recentSQL = "SELECT zen_images.date FROM `zen_images`
			ORDER BY zen_images.date DESC LIMIT 0 , 1";
		$lastImage = query_full_array($recentSQL);
		$mostRecentImageDate = strftime(TIME_FORMAT, strtotime($lastImage[0]['date']));
	}

	return $mostRecentImageDate;
}

/**
 * Returns the url of the previous image.
 *
 * @return string
 */
function getPrevImageTitle() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_album, $_zp_current_image;
	$previmg = $_zp_current_image->getPrevImage();
	return $previmg->getTitle();
}

function getNextImageTitle() {
	if(!in_context(ZP_IMAGE)) return false;
	global $_zp_current_album, $_zp_current_image;
	$nextimg = $_zp_current_image->getNextImage();
	return $nextimg->getTitle();
}

// MW edit
function printMySelectedSizedImage($alt, $class=NULL, $id=NULL) {
	if ($_REQUEST['p'] == 'full')
	{
		$url = getFullImageUrl();
		//$url = str_replace('gallery', 'gallery/albums', $url);
		$url = str_replace('.html?p=*full-image', '', $url);

	  	//echo "<img src=\"" . htmlspecialchars(getFullImageUrl()) . "\" alt=\"" . htmlspecialchars($alt, ENT_QUOTES) . "\"" .
	  	echo "<img src=\"" . htmlspecialchars($url) . "\" alt=\"" . htmlspecialchars($alt, ENT_QUOTES) . "\"" .
	    " width=\"" . getFullWidth() . "\" height=\"" . getFullHeight() . "\"" .
	    (($class) ? " class=\"$class\"" : "") .
	    (($id) ? " id=\"$id\"" : "") . " />";
	}
	else
	{
		echo "<img src=\"" . htmlspecialchars(getDefaultSizedImage()) . "\" alt=\"" . htmlspecialchars($alt, ENT_QUOTES) . "\"" .
	    " width=\"" . getDefaultWidth() . "\" height=\"" . getDefaultHeight() . "\"" .
	    (($class) ? " class=\"$class\"" : "") .
	    (($id) ? " id=\"$id\"" : "") . " />";
	}
}


/**
 * Prints the exif data of the current image.
 *
 */
function printEXIFData()
{
	global $_zp_current_image;
	$result = getImageEXIFData();
	$hitCounterText = formatHitCounter(incrementAndReturnHitCounter('image'));
	$ratingsText = formatRatingCounter(array(
		$_zp_current_image->get('ratings_win'),
		$_zp_current_image->get('ratings_view'),
		$_zp_current_image->get('ratings_score')
		));

	if ( zp_loggedin() )
	{
		$hitCounterText .= "<br>Week reset = ".$_zp_current_image->get('hitcounter_week_reset').", Month reset = ".$_zp_current_image->get('hitcounter_month_reset');
	}

	if (sizeof($result) > 1 AND $result[EXIFDateTimeOriginal] != '')
	{
		$date = split(':', $result[EXIFDateTimeOriginal]);
		$splitdate = split(' ', $date[2]);
		$udate = mktime($splitdate[1], $date[3],$date[4],$date[1],$splitdate[0],$date[0]);
		$fdate = strftime('%B %d, %Y', $udate);
		$ftime = strftime('%H:%M %p', $udate);

		if (DATE_SEARCH)
		{
			$dateLink = "<a href=\"".SEARCH_URL_PATH."/archive/$date[0]-$date[1]-$splitdate[0]\" alt=\"See other photos from this date\" title=\"See other photos from this date\">$fdate</a> $ftime";
		}
		else
		{
			$dateLink = $fdate.'&nbsp;'.$ftime;
		}
	?>
<p class="exif">
Taken with a <?=$result[EXIFModel] ?><br/>
Date: <?=$dateLink;?><br/>
Exposure Time: <?=$result[EXIFExposureTime] ?><br/>
Aperture Value: <?=$result[EXIFFNumber] ?><br/>
Focal Length: <?=$result[EXIFFocalLength] ?>
<?=$hitCounterText.$ratingsText?>
</p>
<?
	}
	else
	{
?>
<p class="exif">
<?=str_replace('<br>','',$hitCounterText.$ratingsText) ?>
</p>
<?
	}	// end if
}		// end function

/**
 * Prints a list of all pages.
 *
 * @param string $class the css class to use, "pagelist" by default
 * @param string $id the css id to use
 */
function drawGalleryPageNumberLinks($url='')
{
	$total = getTotalPages();
	$current = getCurrentPage();

	echo '<p>';

  	if ($total > 0)
  	{
		echo 'Page: ';
	}

	if ($current > 3 AND $total > 7)
	{
		echo "\n <a href=\"".$url.getPageURL(1)."\" alt=\"First page\" title=\"First page\">1</a>&nbsp;";

		if ($current > 4)
		{
			echo "...&nbsp;";
		}
	}

	for ($i=($j=max(1, min($current-2, $total-6))); $i <= min($total, $j+6); $i++)
	{
		if ($i == $current)
		{
			echo $i;
		}
		else
		{
			echo '<a href="'.$url.getPageURL($i).'"\" alt="Page '.$i.'" title="Page '.$i.'">'.($i).'</a>';
		}
		echo "&nbsp;";
	}
	if ($i <= $total)
	{
		if ($current < $total-5)
		{
			echo "...&nbsp;";
		}

		echo "<a href=\"".$url.getPageURL($total)."\" alt=\"Last page\" title=\"Last page\">" . $total . "</a>";
	}
	echo '</p>';
}

/**
 * Returns the title of the current image.
 * Truncates it if over given length
 *
 * @param bool $editable if set to true and the admin is logged in allows editing of the title
 */
function printTruncatedImageTitle($editable=false) {
	global $_zp_current_image;

	if ($editable && zp_loggedin())
	{
		echo "<span id=\"imageTitle\" style=\"display: inline;\">" . getImageTitle() . "</span>\n";
		echo "<script type=\"text/javascript\">initEditableTitle('imageTitle');</script>";
	}
	else
	{
		$imageTitle = getImageTitle();

		if (strlen($imageTitle) > IMAGETITLE_TRUNCATE_LENGTH)
		{
			//$imageTitle = "<abbr title=\"$imageTitle\">" . substr($imageTitle, 0, IMAGETITLE_TRUNCATE_LENGTH) . "</abbr>...";
			$imageTitle = substr($imageTitle, 0, IMAGETITLE_TRUNCATE_LENGTH) . "...";
		}
		echo "<span id=\"imageTitle\" style=\"display: inline;\">" . $imageTitle . "</span>\n";
	}
}

function drawNewsNextables()
{
	$next = getNextNewsURL();
	$prev = getPrevNewsURL();

	if($next OR $prev) {
	?>
<table class="nextables"><tr><td>
  <?php if($prev) { ?><a class="prev" href="<?=$prev['link'];?>" title="<?=$prev['title']?>"><span>&laquo;</span> <?=$prev['title']?></a> <? } ?>
  <?php if($next) { ?><a class="next" href="<?=$next['link'];?>" title="<?=$next['title']?>"><?=$next['title']?> <span>&raquo;</span></a> <? } ?>
</td></tr></table>
  <?php }
}

function drawNewsFrontpageNextables()
{
	$next = getNextNewsPageURL();
	$prev = getPrevNewsPageURL();

	if($next OR $prev) {
	?>
<table class="nextables"><tr><td>
  <?php if($prev) { ?><a class="prev" href="<?="http://".$_SERVER['HTTP_HOST'].$prev;?>" title="Previous page"><span>&laquo;</span> Previous page</a> <? } ?>
  <?php if($next) { ?><a class="next" href="<?="http://".$_SERVER['HTTP_HOST'].$next;?>" title="Next page">Next page <span>&raquo;</span></a> <? } ?>
</td></tr></table>
  <?php }
}

function drawWongmImageNextables()
{
	if (hasPrevImage() OR hasNextImage())
	{
?>
<table class="nextables"><tr><td>
    <?php if (hasPrevImage()) { ?> <a class="prev" href="<?=getPrevImageURL();?>" title="Previous Image"><span>&laquo;</span> Previous</a> <?php } ?>
    <?php if (hasNextImage()) { ?> <a class="next" href="<?=getNextImageURL();?>" title="Next Image">Next <span>&raquo;</span></a><?php } ?>
</td></tr></table>
<?
	}
}

function drawWongmAlbumNextables($showpagelist)
{
  	if (hasPrevPage() || hasNextPage())
  	{
?>
<table class="nextables"><tr><td>
	<?php if (hasPrevPage()) { ?> <a class="prev" href="<?=getPrevPageURL();?>" title="Previous Page"><span>&laquo;</span> Previous</a> <?php } ?>
	<?php if (hasNextPage()) { ?> <a class="next" href="<?=getNextPageURL();?>" title="Next Page">Next <span>&raquo;</span></a><?php } ?>
</td></tr></table>
<?php
		if ($showpagelist)
		{
?>
<div class="pages">
<?  drawGalleryPageNumberLinks();  ?>
</div>
<?		}
	}
}

function printForumLink() {

	if (zp_loggedin()) {
		global $_zp_current_image;
		$path = str_replace($_zp_current_image->filename, '', $_zp_current_image->webpath);
		$path = str_replace('albums/', '', $path);
		$textPlain = "\n[url=http://".$_SERVER['HTTP_HOST'].getImageLinkURL( )."]".
		"\n[img]http://".$_SERVER['HTTP_HOST'].$path.'image/'.FORUM_IMAGE_SIZE.'/'.$_zp_current_image->filename."[/img][/url]";
		$text = $_zp_current_image->getTitle().$textPlain;
		$textFull = $_zp_current_image->getTitle()."\n[url=http://".$_SERVER['HTTP_HOST'].getImageLinkURL( )."?p=full]".
		"\n[img]http://".$_SERVER['HTTP_HOST'].$path.'image/'.FORUM_IMAGE_SIZE.'/'.$_zp_current_image->filename."[/img][/url]"

?>		<script type="text/javascript">
		function SelectAll(id)
		{
    		document.getElementById(id).focus();
    		document.getElementById(id).select();
		}
		</script>
<?
		echo '<p>Forum links: </p>';
		echo '<textarea name="forumplain" id="forumplain" cols="100" rows="1" onClick="SelectAll(\'forumplain\')">'.$textPlain.'</textarea>';
		echo '<textarea name="forum" id="forum" cols="100" rows="2" onClick="SelectAll(\'forum\')">'.$text.'</textarea>';
		echo '<textarea name="forumfull" id="forumfull" cols="100" rows="2" onClick="SelectAll(\'forumfull\')">'.$textFull.'</textarea>';
		return true;
	}

	return false;
}

// MW edit
function getSelectedSizedThingy()
{
	if ($_REQUEST['p'] == 'full')
	{
	  	echo 'Click to fit photo to screen';
	}
	else
	{
		echo 'Click to view full size photo ('.getFullWidth().'px by '.getFullHeight().'px)';
	}
}

/**
 * Prints a link to administration if the current user is logged-in
 */
function printAdminSortLinks($text, $path) {
  if (zp_loggedin()) {
    echo '<p>';
    printLink(WEBPATH.'/' . ZENFOLDER . '/admin.php', $text, $title, $class, $id);
	echo '&nbsp; <a href="'.WEBPATH.'/' . ZENFOLDER . '/admin.php?page=edit&album='.$path.'">Edit Gallery</a> ';
 	echo '&nbsp; <a href="'.WEBPATH.'/' . ZENFOLDER . '/albumsort.php?page=edit&album='.$path.'">Sort Gallery</a>';
    echo '</p>';
  }
}


function drawWongmAlbumRow()
{
	global $_zp_current_album;
?>
<tr class="album">
	<td class="albumthumb">
		<a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo strip_tags(getAlbumTitle());?>"><?php printAlbumThumbImage(getAlbumTitle()); ?></a>
	</td><td class="albumdesc">
		<h4><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo strip_tags(getAlbumTitle());?>"><?php printAlbumTitle(); ?></a></h4>
		<p><small><?php printAlbumDate(""); printHitCounter($_zp_current_album); ?></small></p>
		<p><?php printAlbumDesc(); ?></p>
<? 	if (zp_loggedin())
	{
		echo "<p>";
		echo printLink($zf . '/zp-core/admin-albumdetails.php?album=' . urlencode(getAlbumLinkURL()), gettext("Edit details"), NULL, NULL, NULL);
		echo '</p>';
	}
?>
	</td>

</tr>
<?

}	// end function


function drawWongmGridSubalbums()
{
?>
<!-- Sub-Albums -->
<table class="centeredTable">
<?php
	// neater for when only 4 items
	if (getNumSubAlbums() == 4)
	{
		$i = 1;
	}
	else
	{
		$i = 0;
	}
	while (next_album()):
	if ($i == 0)
	{
		echo '<tr>';
	}
	global $_zp_current_album;
?>
<td class="album" valign="top">
	<div class="albumthumb"><a href="<?=getAlbumLinkURL();?>" title="<?=getAlbumTitle();?>">
	<?php printAlbumThumbImage(getAlbumTitle()); ?></a></div>
	<div class="albumtitle"><h4><a href="<?=getAlbumLinkURL();?>" title="<?=getAlbumTitle();?>">
	<?php printAlbumTitle(); ?></a></h4><small><?php printAlbumDate(); printHitCounter($_zp_current_album); ?></small></div>
	<div class="albumdesc"><?php printAlbumDesc(); ?></div>
</td>
<?php

	if ($i == 2)
	{
		echo "</tr>\n";
		$i = 0;
	}
	else
	{
		$i++;
	}
	endwhile;
?>
</table>
<?
}	/// end function

function drawWongmGridImages()
{
	?>
<!-- Images -->
<table class="centeredTable">
<?php
  // neater for when only 4 items
  if ($num == 4)
  {
	  $i = 1;
  }
  else
  {
	  $i = 0;
	  $style = 'width="30%" ';
  }

  while (next_image()): $c++;
  if ($i == 0)
  {
	  echo '<tr>';
  }

  if (in_context(ZP_SEARCH))
  {
	  $albumlink = getImageAlbumLink();
  }

  global $_zp_current_image;
?>
<td class="image" <?=$style?>valign="top">
	<div class="imagethumb"><a href="<?=getImageLinkURL();?>" title="<?=getImageTitle();?>">
	<?php printImageThumb(getImageTitle()); ?></a></div>
	<div class="imagetitle"><h4><a href="<?=getImageLinkURL();?>" title="<?=getImageTitle();?>">
	<?php printImageTitle(); ?></a></h4><small><?php printImageDate(); printHitCounter($_zp_current_image); ?></small><?= $albumlink?></div>
</td>
<?php

  if ($i == 2)
  {
	  echo "</tr>\n";
	  $i = 0;
  }
  else
  {
	  $i++;
  }
  endwhile; ?>
</table>
<?
  return $c;
}	// end function

//******************************************************************************
//*** END MW EDITS *******************************************************
//******************************************************************************




function formatRatingCounter($array, $splitLines=true)
{
	$votes = $array[0];
	$views = $array[1];
	$score = $array[2];

	if ($votes == 0 AND $views == 0)
	{
		return '';
	}
	else
	{
		if (zp_loggedin())
		{
			$extra = " for a score of $score";
		}

		return '<br>'.pluralNumberWord($votes, 'vote').' from '.pluralNumberWord($views, 'view').$extra;
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
		return "<br>Viewed ".pluralNumberWord($toreturn, 'time').$extraText;
	}

	// otherwise build up a massive string
	if ($alltime > 0) {
		$toreturn = "<br>Viewed ".pluralNumberWord($alltime, 'time');
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

function printHitCounter($obj)
{
	echo formatHitCounter(array($obj->get('hitcounter'), $obj->get('hitcounter_month'), $obj->get('hitcounter_week')));
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

		// update all counters if a public user
		if ( !zp_loggedin() )
		{
			query("UPDATE $dbtable SET ".$updatedHitCounter['public']." WHERE `id` = $id");
		}
		// only reset the monthly and weekly totals if and admin, and counter are past the date
		else if ($updatedHitCounter['admin'] != '')
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
		$hitCounterWeek++;
		$hitCounterMonth++;
		$hitCounterAllTime++;
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

	$toreturn['public'] = "`hitCounter`= $hitCounterAllTime $publicSqlToUpdate";
	$toreturn['admin'] = $adminSqlToUpdate;
	$toreturn['hitCounterWeek'] = $hitCounterWeek;
	$toreturn['hitCounterMonth'] = $hitCounterMonth;
	$toreturn['hitCounterAllTime'] = $hitCounterAllTime;

	return $toreturn;
}

?>