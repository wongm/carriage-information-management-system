<?php $startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die(); 

$pageTitle = ' - Gallery - Photo Search';
include_once('header.php'); ?>
<a href="<?=getGalleryIndexURL();?>" title="Gallery Index"><?=getGalleryTitle();?></a> &raquo;
<a href="<?=SEARCH_URL_PATH?>" title="Photo Search">Photo Search</a>
<?php 
include_once('midbit.php'); 
?>
<div id="searchpage">
<?php

$totalAlbums = getNumAlbums();
$totalImages = getNumImages();
$total = $totalAlbums + $totalImages;

if ($totalAlbums > 0)
{
	$albumsText = " - $totalAlbums albums and $totalImages images.";
}
if ($total > 0) 
{
	if (isset($_REQUEST['date']))
	{
		$searchwords = getFullSearchDate();
	} 
	else 
	{ 
		$searchwords = getSearchWords(); 
	}
	
	echo "<h2>Search Results</h2>\n";
	
 	echo '<p>'.sprintf(gettext('%2$u total matches for <em>%1$s</em>'), $searchwords, $total)." $albumsText</p>";
}

if ($totalAlbums > 0)
{
	echo "<table class=\"indexalbums\">\n";
	while (next_album())
	{
		if (is_null($firstAlbum)) 
		{
			$lastAlbum = albumNumber();
			$firstAlbum = $lastAlbum;
		} 
		else 
		{
			$lastAlbum++;
		}
		drawWongmAlbumRow();
	}
	echo "</table>";
}
?>
<div id="images">
<?php 
$num = getNumImages();
if ($num > 0)
{
	drawWongmGridImages($num);
}
 ?>
</div>
<?php
if (function_exists('printSlideShowLink')) {
	echo "<p align=\"center\">";
	printSlideShowLink(gettext('View Slideshow'));
	echo "</p>";
}
if ($totalImages == 0 AND $totalAlbums == 0) 
{
	if (strlen($searchwords) != 0)
	{
		echo "<p>".gettext("Sorry, no image matches. Try refining your search.")."</p>";
	}
	else
	{
		echo "<h2>Photo Search</h2>\n";
		echo "<p>".gettext("Search for photos and albums.")."</p>";
	}
	
	printSearchForm();
}

if (hasPrevPage() || hasNextPage())
{
?>
<table class="nextables"><tr id="pagelinked"><td>
	<?php if (hasPrevPage()) { ?> <a class="prev" href="<?=getMyPageURL(getPrevPageURL());?>" title="Previous Page"><span>&laquo;</span> Previous</a> <?php } ?>
	</td><td><?php printPageList(); ?></td><td>
	<?php if (hasNextPage()) { ?> <a class="next" href="<?=getMyPageURL(getNextPageURL());?>" title="Next Page">Next <span>&raquo;</span></a><?php } ?>
</td></tr></table>
<?php
}
?>
</div>
<?php include_once('footer.php'); ?>