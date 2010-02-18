<?php 
include_once("common/dbConnection.php");
include_once("common/vlinecars-formatting-functions.php"); 
include_once("common/formatting-functions.php"); 
	
$link = $_REQUEST['name'];

if ($link == '')
{
	//drawAll();
	draw404InvalidSubpage('', 'Article');
}
// for a specific article
else
{
	$article = MYSQL_QUERY("SELECT * FROM articles WHERE `link` = '$link'");
	if (MYSQL_NUM_ROWS($article) == '1')
	{
		// for operations index page
		if ($link == 'operations')
		{
			$pageTitle = array(array('Operations', ''));
		}
		// for all operations pages
		elseif (isset($_REQUEST['operations']))
		{
			$pageTitle = array(array('Operations', '/operations'),
				array(stripslashes(MYSQL_RESULT($article,'0',"title")), ''));
		}
		else 
		{
			$pageTitle = array(array(stripslashes(MYSQL_RESULT($article,'0',"title")), ''));
		}
		
		$pageContent = stripslashes(MYSQL_RESULT($article,'0',"content"));
		$photos = stripslashes(MYSQL_RESULT($article,'0',"photos"));
		$heading = stripslashes(MYSQL_RESULT($article,'0',"title"));
		include_once("common/header.php");
		
		drawTitle($heading);
		
		// add extra link for photos
		if($photos != '')
		{
			printDescriptionTitles($pageContent.'==Photos==');
		}
		else
		{
			printDescriptionTitles($pageContent);
		}
		echo getDescription($pageContent);
		
		if($photos != '')
		{
			include_once("common/galleryFunctions.php");
			getImages($photos,$photos);
		}	/*	?>
<table class="headbar">
<tr><td><a href="/articles">&laquo; Back to Articles listing</a></td></tr>
</table>
<?*/
	}
	else
	{
		draw404InvalidSubpage('', 'Article');
		/*
		include_once("common/header.php");
		echo '<p class="error">Error - Article Not Found!</p>';
		echo '<a href="/">Return</a>';
		*/
	}
}

function drawAll()
{
	$pageTitle = array(array('Articles', ''));
	include_once("common/header.php");
	//echo '<h3>'.$pageTitle.'</h3><hr/>';
	//echo '<p>Here is a listing of the articles on this site:</p>';
		
	$articles = MYSQL_QUERY("SELECT * FROM articles WHERE link != '' AND link NOT LIKE 'operations%' AND `line_id` = '0'");
	
	for ($i = 0; $i < MYSQL_NUM_ROWS($articles); $i++)
	{
		echo '<h4><a href="/articles/'.stripslashes(MYSQL_RESULT($articles,$i,"link")).'">'.stripslashes(MYSQL_RESULT($articles,$i,"title")).'</a></h4>';
		echo '<p class="details">'.stripslashes(MYSQL_RESULT($articles,$i,"description")).'</p>';
	}	
}

include_once("common/footer.php"); ?>