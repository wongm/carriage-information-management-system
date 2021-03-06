<?php

//******************************************************************************
// Miscellaneous functions for the ZenPhoto gallery that I need
//
// For vlinecars.com
//
// V 1.0.0
//
//******************************************************************************

// max images per page

define ('IMAGETITLE_TRUNCATE_LENGTH', 40);
define ('FORUM_IMAGE_SIZE', 500);

// for searching by date links in the EXIF info box
DEFINE ('DATE_SEARCH', false);

define ('maxImagesPerPage', 24);
define ('timeFormat', '%B %d, %Y %H:%M %p');
define ('truncatedImageTitleLength', 40);
define ('forumPhotoSize', 500);
define ('thumbnailImageSize', 250);
define ('GALLERY_PATH', '/gallery');
define ('UPDATES_URL_PATH', '/gallery/recent');
define ('SEARCH_URL_PATH', '/gallery/search');
define ('PREFIX', 'zp_');

if ($_zp_options != '')
	{
	// dynamic from the DB
	define ('MAXIMAGES_PERPAGE', $_zp_options['images_per_page']);
	define ('MAXALBUMS_PERPAGE', $_zp_options['albums_per_page']);
	define ('THUMBNAIL_IMAGE_SIZE', $_zp_options['thumb_size']);
	define ('TIME_FORMAT', $_zp_options['date_format']);
}
else
{
	define ('MAXIMAGES_PERPAGE', 24);
	define ('MAXALBUMS_PERPAGE', 24);
	define ('THUMBNAIL_IMAGE_SIZE', 250);
	define ('MAXIMAGES_LOCATIONPAGE', 9);
	DEFINE ('GALLERY_PATH', '/gallery');
	define ('TIME_FORMAT', '%B %d, %Y %H:%M %p');
}

function printSearchBreadcrumb($foo)
{	
	//printSearchForm();
}	// end function

/**
 * Prints the album description of the current album.
 *
 * @param bool $editable
 */
function printAlbumDescAndLink($editable=false) 
{
	global $_zp_current_album;
	
	$desc = htmlspecialchars(getAlbumDesc());
	$desc = str_replace("\r\n", "\n", $_zp_current_album->getDesc());
	$desc = str_replace("\n", '<br />', $desc);
	
	$lineLink = $_zp_current_album->get('line_link');
	$locationId = $_zp_current_album->get('location_id');
	
	if ($lineLink != '')
	{
		$name = $_zp_current_album->get('line_name');
		$url = "/lineguide/$lineLink";
	}	
	else if ($locationId != 0 AND $locationId != '')
	{
		$name = $_zp_current_album->get('location_name');
		$url = "/location/$locationId";
	}
	
	if ($name != '')
	{
		$linkContent = "For more details see <a href=\"$url\">$name</a>.";
	}
	
	if ($editable AND zp_loggedin())
	{
		echo "<div id=\"albumDescEditable\" style=\"display: block;\">" . $desc . "</div>\n";
		echo "<script type=\"text/javascript\">initEditableDesc('albumDescEditable');</script>\n";
		echo '<div class="albumdesc">'.$linkContent.'</div>';
	}
	else
	{
		$len = strlen($desc);
		if ($len > 1 AND substr($desc, $len-1, 1) != '.') {
			$desc .= ".";
		}
		
		echo "<div class=\"albumdesc\">$desc $linkContent</div>";
	}
}
?>