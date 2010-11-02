<?php 

/*
 * index.php in ROOT is where the redirect is set
 * contents are
 *
		// MW edit
		header("HTTP/1.1 404 Not Found");
		header("Status: 404 Not Found");
		
		if ($image != '')
		{
			$image  = str_replace('.jpg', '', $image);
			$search  = str_replace('.JPG', '', $image);
		}
		
		include_once('themes/railgeelong/404.php');
		exit();
 *	
 */
 
$startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die(); 

$pageTitle = ' - Gallery - 404 Page Not Found Error';
include_once('header.php');
include_once('search-functions.php');
?>
<a href="<?=getGalleryIndexURL();?>" title="Gallery Index"><?=getGalleryTitle();?></a> &raquo; 404 Page Not Found Error
<?php 
include_once('midbit.php'); 

echo gettext("<h2>404 Page Not Found Error</h2>");
echo gettext("<h4>The gallery object you are requesting cannot be found.</h4>");

if (isset($image) AND $image != '') 
{
	$term = $image;
	$image = true;
}
else if (isset($album)) 
{
	$term = $album;
	$image = false;
}

$term  = str_replace('.jpg', '', $term);
$term  = str_replace('.JPG', '', $term);
$numberofresults = 0;

if ($image)
{
	$numberofresults = imageOrAlbumSearch($term, 'Image', 'error');
}	

$term = str_replace('-', ' ', $term);

if ($numberofresults == 0)
{
	$numberofresults = imageOrAlbumSearch($term, 'Album', 'error');
}

// fix for wording below
if ($numberofresults == 1)
{
	$wording = "Is this it? If it isn't, then you ";
}
else if ($numberofresults > 1)
{
	$wording = "Are these it? If it isn't, then you ";
}
else
{
	$wording = "You ";
}
?>
<p><?=$wording?>can use search to find what you are looking for. </p> 
<p>Otherwise please check you typed the address correctly. If you followed a link from elsewhere, please inform them. If the link was from this site, then <a href="/contact.php">Contact Me</a>.</p>
<?php include_once('footer.php'); ?>