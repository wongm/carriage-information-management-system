<?php $startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die(); 

// trick zenpage into displaying the HOME page
zenpage_setup_page('home');

$pageTitle = ' - Home';
$selectedTabId = -1;
include_once('header.php'); 
?>
Welcome
<?php 
include_once('midbit.php'); 
?>
<script type="text/javascript">
$(document).ready(function(){
	var rand = Math.floor(<?php echo RANDOM_MAX; ?>*Math.random() + 1);
	$('#randomimage').attr('src', '/images/frontpage/' + rand + '.jpg');
});
</script>
<img class="photoright" id="randomimage" alt="Random image" title="Random image" />
<div id="home">
<h2>Welcome</h2>
<p><?php printPageContent(); ?></p>
<div class="clearfloat"></div>
<h3>Recent updates</h3>
<?php
while (next_news() && $i < 3): ;?> 
	<div class="newsarticle"> 
    	<h4><a href="/news/<?php echo getNewsTitleLink(); ?>"><?php echo getNewsTitle(); ?></a></h4>
        <div class="newsarticlecredit">
        <p><small><?php printNewsDate();?></small></p>
		</div>
    	<?php printNewsContent(); ?>
    	<p><a href="/news/<?php echo getNewsTitleLink(); ?>"><?php echo getNewsReadMore(); ?></a></p>
    	<?php printCodeblock(1); ?>
 	</div>	
<?php
	$i++;
  endwhile; 
?>
<p><a href="/news">Complete List...</a></p>
<h3>Updated galleries</h3>
<table class="centeredTable">
<tbody>
<?php 
$latestalbums = getAlbumStatistic(6, "latest");
$i = 0;

foreach ($latestalbums as $latestalbum) 
{
	$j = 1;
	
	$folderpath = "/gallery/" . $latestalbum['folder'];
	$foldername = "";
	$splitfoldernames = str_replace('-', ' ', split('/', $latestalbum['folder']));
	$albumTitle = $latestalbum['title'];
	
	foreach ($splitfoldernames as $foldernameitem)
	{
		if (strlen($foldername) > 0)
		{
			$foldername .= " - ";
		}
		
		// magic logic to make sure the last item in the path is the actual folder title
		if ($j++ == sizeof($splitfoldernames))
		{
			$foldername .= $albumTitle;
		}
		else
		{
			$foldername .= ucfirst($foldernameitem);
		}		
	}
	
	$images = getImageStatistic(1, "latest", $latestalbum['folder']);
	
	foreach ($images as $image) 
	{
		$i++;		
		
		if (($i % 3) == 1)
		{
			echo "<tr>";
		}
		
		echo '<td class="image">';
		echo "<a href=\"" . htmlspecialchars($folderpath)."\" title=\"" . html_encode($foldername) . "\">\n";
		echo "<img src=\"".htmlspecialchars($image->getThumb())."\" alt=\"" . html_encode($foldername) . "\" /></a>\n";
		echo "<h4><a href=\"".htmlspecialchars($folderpath)."\" title=\"" . html_encode($foldername) . "\">$foldername</a></h4>\n";
		echo "<small>Updated ". zpFormattedDate(getOption('date_format'),$image->get('mtime'))."</small>";
	
		if (($i % 3) == 0)
		{
			echo "</tr>";
		}
	}}
?>
</tr>
</tbody></table>
<p><a href="/gallery/recent">Complete List...</a></p>
</div>
<?php
include("footer.php"); 
?>