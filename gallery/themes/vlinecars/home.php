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
	$("#randomimage").attr("src", '/images/frontpage/' + rand + '.jpg');
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
<h3>Updated galleries</h3>
<table class="centeredTable">
<tbody>


<?php 
$latestalbums = getAlbumStatistic(6, "latest");

foreach ($latestalbums as $latestalbum) {
	$i++;
	
	if (($i % 3) == 1)
	{
		echo "<tr>";
	}
	
	$folderpath = "/gallery/" . $latestalbum['folder'];
	$foldername = "";
	$splitfoldernames = str_replace('-', ' ', split('/', $latestalbum['folder']));
	
	foreach ($splitfoldernames as $foldernameitem)
	{
		if (strlen($foldername) > 0)
		{
			$foldername .= " - ";
		}
		$foldername .= ucfirst($foldernameitem);
	}
	
	$images = getImageStatistic(1, "latest", $latestalbum['folder']);
	
	foreach ($images as $image) {
		echo '<td class="image">';
		echo "<a href=\"" . htmlspecialchars($folderpath)."\" title=\"" . html_encode($foldername) . "\">\n";
		echo "<img src=\"".htmlspecialchars($image->getThumb())."\" alt=\"" . html_encode($foldername) . "\" /></a>\n";
		echo "<h4><a href=\"".htmlspecialchars($folderpath)."\" title=\"" . html_encode($foldername) . "\">$foldername</a></h4>\n";
		echo "<small>". zpFormattedDate(getOption('date_format'),strtotime($image->getDateTime()))."</small>";
	}
	
	if (($i % 3) == 0)
	{
		echo "</tr>";
	}
}
?>
</tbody></table>
</div>
<?php
include("footer.php"); 
?>