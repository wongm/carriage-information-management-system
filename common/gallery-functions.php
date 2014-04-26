<?php
include_once('dbConnection.php');
include_once('formatting-functions.php');
include_once('./gallery/themes/vlinecars/functions-search.php');
include_once('./gallery/themes/vlinecars/vlinecars-functions.php');

// check this location has images to show
function getObjectmages($location)
{
	$location = split(';', $location);
	$subLocation = sizeof($location);
	
	// for comma seperated individual images
	if ($subLocation > 1)
	{
		$gallerySQL = "SELECT zp_albums.folder, zp_images.filename, zp_images.title, zp_images.id 
			FROM zp_images
			INNER JOIN zp_albums ON zp_images.albumid = zp_albums.id 
			WHERE ( zp_images.filename = '".mysql_real_escape_string($location[0])."' ";
		for ($i = 1; $i < $subLocation; $i++)
		{
			$gallerySQL .= " OR zp_images.filename = '".$location[$i]."' ";
		}
		$gallerySQL .= " ) ORDER BY zp_images.sort_order";
	}
	// for album in the gallery 
	else
	{
		$gallerySQL = "SELECT zp_albums.folder, zp_images.filename, zp_images.title, zp_images.id 
			FROM zp_images
			INNER JOIN zp_albums ON zp_images.albumid = zp_albums.id 
			WHERE folder = '".mysql_real_escape_string($location[0])."' ORDER BY zp_images.sort_order";
	}
	$galleryResult = MYSQL_QUERY($gallerySQL, galleryDBconnect());
	
	for ($i = 0; $i < MYSQL_NUM_ROWS($galleryResult); $i++)
	{
		$photoArray[] = mysql_fetch_assoc($galleryResult);
	}
	
	return $photoArray;
}

function printFrontpageRecent()
{
	$sql = "SELECT * , zp_images.mtime as fdate FROM zp_images, zp_albums 
		WHERE zp_images.albumid = zp_albums.id 
		GROUP BY albumid 
		ORDER BY zp_images.id DESC LIMIT 0,".FRONT_PAGE_MAX_IMAGES;
	$galleryResult = MYSQL_QUERY($sql, galleryDBconnect());	
	
	drawAlbums($galleryResult);
}

/*
 * Gets the images for a specified location
 * $locations = path to album, or CSV of image ids
 */
function drawObjectmages($locationPhotos, $path='')
{
	$displayRows = $originalRows = sizeof($locationPhotos);
	$path = $locationPhotos[0]['folder'];
	
	if ($originalRows > 0) 
	{	
?>
<h4 id="photos" name="photos">Photos</h4>
<?
	if ($originalRows > MAXIMAGES_LOCATIONPAGE) 
	{
		$moreString = MAXIMAGES_LOCATIONPAGE.' of <a href="/gallery/'.$path.'">'.$originalRows.' images found</a> displayed.';
		$displayRows = MAXIMAGES_LOCATIONPAGE;
	}
	else		
	{
		$moreString = $displayRows.' images found.';
	}
?>
<p><?=$moreString?> These will open in a new window</p>
<table class="centeredTable">
<?
	$i=0;
	$j=0;
	
	if ($numberOfRows == '4')
	{
		$j=1;
	}
	
	if ($originalRows > MAXIMAGES_LOCATIONPAGE)
	{
		$k=rand(0, ($originalRows/9));
	}
	else
	{
		$k = 0;
	}
	
	while ($i<$displayRows)
	{
		echo "<tr>\n";

		while ($j < 3 AND $i<$displayRows )
		{
			// check index is within limits...
			if ($k >= $originalRows)
			{
				$k = $originalRows-1;
			}
			
			$photoPath = $locationPhotos[$k]['folder'];
			$photoUrl = $locationPhotos[$k]['filename'];
			$photoTitle = $locationPhotos[$k]['title'];
			$photoId = $locationPhotos[$k]['id'];
			// for when URL rewrite is on
			/* <td><a href="/gallery/<? echo $photoPath; ?>/<? echo $photoUrl; ?>.html" target="new" ><img src="/gallery/cache/<? echo $photoPath; ?>/<? echo $photoUrl; ?>_<?php echo thumbsize; ?>.jpg" alt="<? echo $photoTitle; ?>" title="<? echo $photoTitle; ?>" /></a>*/
			// non rewrite
			/* <a href="/gallery/index.php?album=<? echo $photoPath; ?>&amp;image=<? echo $photoUrl; ?>&size=" target="new" ><img src="/gallery/cache/<? echo $photoPath; ?>/<? echo $photoUrl; ?>_<?php echo thumbsize; ?>.jpg" alt="<? echo $photoTitle; ?>" title="<? echo $photoTitle; ?>" /></a> */
			
			// old version
			/*<td class="i"><a href="/gallery/<? echo $photoPath; ?>/<? echo $photoUrl; ?>.html?size=" target="new" ><img src="/gallery/cache/<? echo $photoPath; ?>/<? echo $photoUrl; ?>_150_cw150_ch150.jpg" alt="<? echo $photoTitle; ?>" title="<? echo $photoTitle; ?>" />*/
			
			$thumbUrl = replace_filename_with_cache_thumbnail_version($photoUrl);
			$imageUrl = GALLERY_PATH."/cache/$photoPath/$thumbUrl";
?>
<td class="i">
	<a href="/gallery/<? echo $photoPath; ?>/<? echo $photoUrl; ?>.html?size=" target="new" ><img src="<? echo $imageUrl; ?>" alt="<? echo $photoTitle; ?>" title="<? echo $photoTitle; ?>" /></a>
	<p><?=$photoTitle ?></p></td>
<?		$j++;
			$i++;
			$k = $k+(rand(1, ($original/7)));
	
		}	//end while for cols
		$j=0;
?>
</tr>
<?
		}	//end while for rows
		?>
</table>
<p><a href="#top" class="credit">Top</a></p>
<?	}		// end if
	return;	
	
}	//end function

