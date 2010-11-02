<?php
/**
 * functions.php
 * 
 * Functions that format data - common between carriages and carsets.
 * 
 * Marcus Wong
 * May 2008
 *
 */
 
/**
 * outputs a XHTML level 3 heading
 * @param title text to enclose
 */
function drawTitle($title)
{
	echo "<h2>$title</h2>";
}

function getCIMSPageTitle($pageTitle)
{
	$toreturn = SITE_NAME;
	$size = sizeof($pageTitle);
	
	for ($i = 0; $i < $size; $i++)
	{
		if ($pageTitle[$i][0] != '')
		{
			$toreturn = "$toreturn - ".$pageTitle[$i][0];
		}
	}
		
	return $toreturn;
}

function getStatus($status)
{
	switch ($status)
	{
		case 'factory';
			return 'Under construction';
		case 'service';
			return 'In service';
		case 'stored';
			return 'Stored';
		case 'brokenup';
			return 'Broken up';
		case 'scrapped';
			return 'Scrapped';
		case 'sold';
			return 'Sold';
	}
}

function getPageBreadcrumbs($pageTitle)
{
	$toreturn = '<a href="/" title="'.SITE_NAME.' Home">Home</a>';
	$size = sizeof($pageTitle);
	
	for ($i = 0; $i < $size; $i++)
	{
		$url = $pageTitle[$i][1];
		$title = $pageTitle[$i][0];
		
		if ($url != '')
		{
			$toreturn = "$toreturn &raquo; <a href=\"$url\" title=\"$title\">$title</a>";
		}
		else if ($title != '')
		{
			$toreturn = "$toreturn &raquo; $title";
		}
	}
		
	return $toreturn;
	
} 

// fix crappy formatting
function fixcrap($description)
{
	// fixing up old crap left behind
	$description = eregi_replace('\[\]', ' ', $description);
	$description = eregi_replace('<br/><br/>', ' ', $description);
	$description = eregi_replace('<br/>', ' ', $description);
	
	// replace new line with paragraphs
	$description = eregi_replace("\n\n", "\n", $description);
	$description = eregi_replace("\n\n\n", "\n", $description);
	$description = preg_replace('#[\n\r]+#s', "</p><p>", $description);
	
	// for tables
	$description = eregi_replace('<p><tr>', "<tr>", $description);
	$description = eregi_replace('</tr></p>', "</tr>\n", $description);
	
	// then add new lines in output
	$description = eregi_replace('</p><p>', "</p>\n<p>", $description);
	
	$description = eregi_replace("</p><p>", '', $description);
	return $description;
}

/*
 * Gets description for the text
 * formatted correctly with <p> tags between paragraphs
 * and subsheadings too
 *
 * [[LOCATION TO LINK TO]]
 * or [[LOCATION TO LINK TO|nice name]]
 * 
 */
function getDescription($text)
{
	$description = parseSimpleLinks($text);
	$description = fixcrap($description);
	
	$description = split ("==", $description);
	$size = sizeof($description);
	
	if (substr($text, 0, 2) != '==')
	{
		if (substr($description[0], strlen($description[0])-7, strlen($description[0])) == '</p><p>')
		{
			// deletes the extra '<p>' that slip in
			echo '<p>'.substr($description[0], 0, strlen($description[0])-7).'</p>';
		}
		else
		{
			echo '<p>'.$description[0].'</p>';
		}
	}
	
	$i = 1; 
	
	while ($i < $size)
	{
		if ($i % 2 == 0)
		{
			// deletes the extra '<p>' that slip in
			if (substr($description[$i], 0, 7) == '</p><p>')
			{
				// if they are at both ends
				if (substr($description[$i], strlen($description[$i])-7, strlen($description[$i])) == '</p><p>')
				{
					echo substr($description[$i], 7, strlen($description[$i])-14).'</p>';
				}
				// or only one end (usually for the last subsection of a page)
				else
				{
					echo substr($description[$i], 7, strlen($description[$i])-7).'</p>';
				}
			}
			// or none found
			else
			{
				echo $description[$i].'</p>';
			}
?>
<p><a href="#top" class="credit">Top</a></p>
<?
		}
		else
		{
?>
<h4 id="<? echo strtolower(eregi_replace(' ', '-', $description[$i])); ?>"><?=$description[$i];?></h4><p>
<?
		}
		$i++;
	}
}	//end function

/*
 * PRIVATE
 * give it a bit of text with  "==HEADING==" formating
 * and creates a string with a HTML unordered list of subtitles
 * and links to go to subheadings
 */
function getDescriptionTitles($text)
{
	$description = split ("==", $text);
	$size = sizeof($description);
	$i = 1; 
	
	while ($i < $size)
	{
		$toReturn[] = '<a href="#'.strtolower(eregi_replace(' ', '-', $description[$i])).'">'.$description[$i].'</a>';
		$i = $i+2;
	}
	
	return $toReturn;
}	//end function

/*
 * PUBLIC
 * give it a bit of text with  "==HEADING==" formating
 * and it displays an unordered list with of a table of contents
 */
function printDescriptionTitles($pageContent)
{
	$descriptionTabs = getDescriptionTitles($pageContent);
	if (sizeof($descriptionTabs) > 1)
	{
?>
<h4 id="top">Contents</h4>
<ul>
<?
		for ($i = 0; $i < sizeof($descriptionTabs); $i++)
		{
?>			
	<li><?=$descriptionTabs[$i]?></li>
<?
		}
?>
</ul>
<?
	}
}

function draw404InvalidSubpage($pageUrlRoot, $title='subpage')
{
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	
	$pageTitle = $pageTitle = array(array("404 Page Not Found", ''));
	include_once("common/header.php");
	echo "<h2>Error - Invalid $title!</h2>";
	echo "<a class=\"error\" href=\"/$pageUrlRoot\">Return</a>";
	include_once("common/footer.php");
	return;
}

/*
 * PUBLIC
 * give it a bit of text with  "==HEADING==" formating
 * and it returns how many headings there are
 */
function getDescriptionSize($text)
{
	$description = split ("==", $text);
	$size = sizeof($description)/2;
	return $size-1;
}	//end function


function drawNextAndBackLinks($index, $totalimg, $max, $url)
{
	$page = $index/$max;
	
	if ($index > 0 OR $totalimg == $max)
	{	?>
<table class="headbar"><tr><td>
<?
		if ($index > 0)
		{
			if ($index - $max < 0)
			{
				$index = $max;
			}
?>
<a class="prev" href="<? echo $url.($page) ?>" title="Previous Page"><span>&laquo;</span> Previous</a></td>
<?
		}
		if ($totalimg >= $max)
		{	
?>
<td align="right"><a class="next" href="<? echo $url.($page+2) ?>" title="Next Page">Next <span>&raquo;</span></a>
<?
		}
?>
</td></tr></table>
<?
	}
} // end function

function drawNumberCurrentDispayedRecords($maxRecordsPerPage,$numberOfRecords,$searchPageNumber)
{
	if ($numberOfRecords != $totalNumberOfRecords)
	{
		$lowerBound = ($maxRecordsPerPage*$searchPageNumber)+1;
		$upperBound = $lowerBound+$numberOfRecords-1;
		$extraBit = "$lowerBound to $upperBound shown on this page";
	}
	return $extraBit;
}

/*
 * prints a pretty dodad that lists the total number of pages in a set
 * give it the index you are up to,
 * the total number of items,
 * the number  to go per page,
 * and the URL to link to
 */
function drawPageNumberLinks($index, $totalimg, $max, $url)
{
	$total = floor(($totalimg)/$max)+1;
	$current = $index/$max;
	
	echo '<p>';
  
  	if ($total > 0)
  	{
		echo 'Page: ';
	}
	
	if ($current > 3 AND $total > 7)
	{
		echo "\n <a href=\"$url\" alt=\"First page\" title=\"First page\">1</a>&nbsp;...&nbsp;"; 
	}
	
	for ($i=($j=max(1, min($current-2, $total-6))); $i <= min($total, $j+6); $i++) 
	{
		if ($i == $current+1)
		{
			echo $i;
		}
		else
		{
			echo '<a href="'.$url.$i.'" alt="Page '.$i.'" title="Page '.$i.'">'.($i).'</a>';
		}
		echo "&nbsp;";
	}
	if ($i <= $total) 
	{
		echo "...&nbsp;<a href=\"$url$total\" alt=\"Last page\" title=\"Last page\">" . $total . "</a>"; 
	}
	echo '</p>';
}	// end function

/*
 * input formatted date string (eg: "Monday, 16 November 1959 ") ($fdate)
 * and the type keyword from the DB ($type)
 * and it gets formatted
 */
function formatDate($fdate, $type)
{
	switch ($type)
	{
		case 'exact':
			return $fdate;
			break;
		case 'approx':
			return '<abbr title="Seen on this date">('.$fdate.')</abbr>';
			break;
		case 'year':
			$str = split(' ', $fdate);
			return $str[3];
			break;
		case 'month':
			$str = split(' ', $fdate);
			return $str[2].' '.$str[3];
			break;
		default:
			return $fdate;
	}
}	// end function

/*
 * pass it a string ($name)
 * and a keyword ($keyword)
 * and it gets highlighted
 */
function highlight($keyword, $name)
{
	if ($keyword != '')
	{
		$bgcolor="#FFFF99";
		$start_tag = "<span style=\"background-color: $bgcolor\">";
		$end_tag = "</span>";
		$highlighted_results = $start_tag . $keyword . $end_tag;
		$highlightName = eregi_replace($keyword, $highlighted_results, $name);
		return $highlightName;
	}
	return $text;
}	// end function


/*
 * Gets undecorated string for a particular config vaiable
 * no html in it
 */
function getConfigVariable($name)
{
	$sql = "SELECT * FROM config WHERE name = '".$name." ' LIMIT 0,1";
	$result = MYSQL_QUERY($sql);
	$numberOfRows = MYSQL_NUM_ROWS($result);
	
	$description = '';
	
	if ($numberOfRows == 1)
	{
		$description = stripslashes(MYSQL_RESULT($result,0,"value"));
	}
	
	return $description;
}

/* 
 * pass it an SQL result srt
 * used by album search
 * and by the frontpage recently updated search

function drawAlbums($galleryResult)
{	
	$numberOfRows = MYSQL_NUM_ROWS($galleryResult);
	if ($numberOfRows>0) 
	{	
		echo '<table class="centeredTable">';
		$i=0;
		$j=0;
			
		while ($i<$numberOfRows AND $i<29)
		{
?>
<tr>
<?
			while ($j < 3 AND $i<$numberOfRows)
			{
				$photoPath = MYSQL_RESULT($galleryResult,$i,"zen_albums.folder");
				$photoAlbumTitle = stripslashes(MYSQL_RESULT($galleryResult,$i,"zen_albums.title"));
				$albumId = MYSQL_RESULT($galleryResult,$i,"zen_albums.id");
				
				// get an image to display with it
				$imageSql = "SELECT filename, id FROM zen_images WHERE zen_images.albumid = '$albumId' LIMIT 0,1 ";
				$imageResult = MYSQL_QUERY($imageSql);
				$numberOfImages = MYSQL_NUM_ROWS($imageResult);
				if ($numberOfImages > 0)
				{
					$photoUrl = MYSQL_RESULT($imageResult,0,"filename");
					$photoId = MYSQL_RESULT($imageResult,0,"id");
					$photoUrl = "/gallery/$photoPath/image/thumb/$photoUrl";
				}
				else
				{
					$photoUrl = '/gallery/foldericon.gif';
				}
					
				if ($photoDesc == '')
				{
					$photoDesc = $photoTitle;
				}
				else
				{
					$photoDesc = 'Description: '.$photoDesc;
				}	
?>
<td class="i"><a href="/gallery/<? echo $photoPath; ?>/"><img src="<?=$photoUrl ?>" alt="<? echo $photoAlbumTitle; ?>" title="<? echo $photoAlbumTitle; ?>" /></a>
	<br/><a href="/gallery/<? echo $photoPath; ?>/"><? echo $photoAlbumTitle; ?></a></td>
<?
				$j++;
				$i++;
			
			}	//end while for cols
			$j=0;
?>
</tr>
<?
		}	//end while for rows
?>
</table>
<?	
	}	// end if for non zero
}		// end function
 */
?>