<?php

include_once("vlinecars-definitions.php");

/**
 * draw a list of all objects of a type
 * outputs XHTML
 * @param data an array containing an array of objects. first element is type of object, then ID, description, status
 * @param status the type of events you want shown
 * @param pagename the page to hyperlink to in table - eg: designs.php?family=
 */
function drawObjectsOfType($data, $status, $pagename)
{
	$size = sizeof($data);
	
	if ($size > 0 AND $data != '')
	{
		echo "<table class=\"linedTable\">\n";
		
		if ($data[0][5] != '')
		{
			$enterServiceHeader = "<th>Entered service</th>";
			$showEnteredService = true;
		}
		else
		{
			$showEnteredService = false;
		}
		
		//for groupings / class / type of objects
		if ($pagename == '/carset/type/' OR $pagename == '/carriage/type/')
		{
			$showLimited = true;
		}
		else if (($pagename == '/locomotive/number/' OR $pagename == '/railcar/number/') AND $data[0][2] != '')
		{
			echo "<tr><th></th><th>Livery</th><th>Status</th>$enterServiceHeader<th>Name</th></tr>\n";
		}
		//for objects themselves
		else
		{
			echo "<tr><th></th><th>Livery</th><th>Status</th>$enterServiceHeader</tr>\n";
		}
		
		for ($i = 0; $i < $size; $i++)
		{
			$thisId = $data[$i][0];
			$thisType = str_replace('-','', $data[$i][1]);
			$thisDescription = $data[$i][2];
			$thisStatus = "<td>".getStatus($data[$i][3])."</td>";
			$thisLivery = "<td>".$data[$i][4]."</td>";
			
			if ($showEnteredService)
			{
				$thisService = "<td>".$data[$i][5]."</td>";
			}
			else
			{
				$thisService = "";
			}
			
			if ($thisDescription != '')
			{
				$thisDescription = "<td>$thisDescription</td>";
			}
			
			if ($i%2 == '0')
			{
				$style = 'class="x"';
			}
			else
			{
				$style = 'class="y"';
			}
			
			if ($showLimited)
			{
				echo "<tr $style><td class=\"code\"><a href=\"$pagename$thisId\">$thisType$thisId</a></td>$thisDescription</tr>\n";
			}
			else
			{
				echo "<tr $style><td class=\"code\"><a href=\"$pagename$thisId\">$thisType$thisId</a></td>$thisLivery$thisStatus$thisService$thisDescription</tr>\n";
			}
		}
		echo '</table>';
	}	
}

/**
 * draw a list of all objects of a type
 * outputs XHTML MP
 * @param data an array containing an array of objects. first element is type of object, then ID, description, status
 * @param status the type of events you want shown
 * @param pagename the page to hyperlink to in table - eg: designs.php?family=
 */
function drawObjectsOfTypeMobile($data, $status, $pagename)
{
	$size = sizeof($data);
	
	if ($size > 0)
	{
		echo '<p>';
		for ($i = 0; $i < $size; $i++)
		{
			$thisId = $data[$i][1];
			$thisType = $data[$i][0];
			$thisDescription = $data[$i][2];
			if($thisType == '-')
			{
				$thisType = '';
			}
			
			echo "<a href=\"$pagename$thisId\">$thisType$thisId</a><br/>";
		}
		echo '</p>';
	}	
}

/*
 * PRIVATE
 * parses text for links and returns with HTML
 * using wiki style formatting
 * [[LINE TO LINK TO]]
 * or [[LOCATION TO LINK TO|nice name]]
 *
 */
function parseSimpleLinks($text)
{
	// check if the first bit of text is a link
	if (substr($text, 0, 1) == '[[')
	{
		$firstlink = true;
	}
	
	$description = str_replace('[[', ']]', $text);
	$description = split ("]]", $description);
	$size = sizeof($description);
	
	if($size > 1)
	{
		// if fist bit isn't a lik, append it to output;
		if($firstlink == false)
		{
			$toreturn .= $description[0];
		}
		
		$i = 1;
		while( $i < $size-1)
		{
			// test for type of link
			$path = split (":", $description[$i]);
			
			// test for link itself
			if(sizeof($path) > 1)
			{
				// test for optional link title
				$pathurl = $path[0];
				$title = split ("\|", $path[1]);
				$linkurl = $title[0];
				$linktitle = $title[0];
				
				// custom title found - set it
				if(sizeof($title) > 1)
				{
					$linktitle = $title[1];
				}
			}
			else
			{
				$pathurl = '';
			}
			
			// add link if all params found
			if ($pathurl != '')
			{
				switch ($pathurl)
				{
					case 'carset':
						$pathurl = "/carset/number/$linkurl";
						break;
					case 'carsettype':
						$pathurl = "/carset/type/$linkurl";
						break;
					case 'carsetfamily':
						$pathurl = "/carsets/$linkurl-type";
						break;
					case 'car':
						$pathurl = "/carriage/number/$linkurl";
						break;
					case 'cartype':
						$pathurl = "/carriage/type/$linkurl";
						break;
					case 'carfamily':
						$pathurl = "/cariages/$linkurl-type";
						break;
					case 'station':
						$pathurl = "/region/station/$linkurl";
						break;
					case 'region':
						$pathurl = "/region/$linkurl";
						break;
					case 'loco':
						$pathurl = "/locomotive/number/$linkurl";
						break;
					case 'lococlass':
						$pathurl = "/locomotives/$linkurl-class";
						break;
					case 'railcar':
						$pathurl = "/railcar/number/$linkurl";
						break;
					case 'railcartype':
						$pathurl = "/railcars/$linkurl";
						break;
				}
				
				// output URL of location
				$pathurl = str_replace(' ', '-', $pathurl);
				$toreturn .= '<a href="'.strtolower($pathurl).'">'.$linktitle.'</a>';
			}
			
			// output rest of text
			$toreturn .= $description[$i+1];
			$i = $i+2;
			
		}
	}
	// if no links found
	else
	{
		$toreturn = $text;
	}
	return $toreturn;
}



/**
 * draws a table of the objects in the array
 * for carriages, carriage sets
 * in XHTML markup
 * odd and even styling
 * @param dataarray array with the data, first element date, then event description
 */
function drawObjectEvents($dataarray)
{
	$numberOfRows = sizeof($dataarray);
	
	if ($numberOfRows > 0)
	{
?>
<table class="linedTable">	<?	
	$j=0;
	
	for ($i = 0; $i<$numberOfRows; $i++)
	{	
		// styling
		if ($j%2 == '0')
		{
			$style = 'class="x"';
		}
		else
		{
			$style = 'class="y"';
		}
		?>
<tr <? echo $style; ?> valign="top"><td class="date"><? echo $dataarray[$i][0]; ?></td>
<td><? echo $dataarray[$i][1];	?></td></tr><?
			
			$j++;
	}	//end for loop
?>
</table>
<?	} //end if

} //end function


/**
 * draws a table of the objects in the array
 * for carriages, carriage sets
 * in XHTML MP markup
 * @param dataarray array with the data, first element date, then event description
 */
function drawObjectEventsMobile($dataarray)
{
	$numberOfRows = sizeof($dataarray);
	
	if ($numberOfRows > 0)
	{
?>
<p><b>History</b></p>
<?	
		for ($i = 0; $i<$numberOfRows; $i++)
		{
?>
<p><u><i><? echo $dataarray[$i][0]; ?></i></u><br/>
<? echo $dataarray[$i][1];	?></p><?	
		}	//end for loop
	} //end if

} //end function


function drawDiagramTabs($diagramData)
{
?>
<div class="centeredTable">
<ul id="maintab" class="shadetabs">
<?	
	// draw the tabs headers for all diagram tabs
	for ($i = 0; $i < sizeof($diagramData); $i++)
	{	
?>
	<li <? if ($i == sizeof($diagramData)-1) {echo 'class="selected"'; }?>><a href="#year<? echo $diagramData[$i][2]; ?>" rel="year<? echo $diagramData[$i][2]; ?>" ><? echo $diagramData[$i][2]; ?></a></li>
<?	}	
?>
</ul>
<div class="tabcontentstyle">
<?
	// draw the diagram tabs themselves
	for ($i = 0; $i < sizeof($diagramData); $i++)
	{	
?>
<div id="year<? echo $diagramData[$i][2]; ?>" name="year<? echo $diagramData[$i][2]; ?>" class="tabcontent">
	<div id="tabtitle<? echo $i; ?>" ><br/><h5><? echo $diagramData[$i][2]; ?></h5> <a href="#diagrams" class="credit">Back to Year Listing</a></div>
	<img src="/t/<? echo $diagramData[$i][0].'.gif'; ?>" alt="<? echo $name.' '.$diagramData[$i][1]; ?>" title="<? echo $name.' '.$diagramData[$i][1]; ?>" />
</div>
<?	
	}	
?>
</div>
<? 
	/* fixes which tab is open */ 
?>
<script type="text/javascript">
initializetabcontent("maintab")
</script>
</div>
<? 	/* end tabs div */	
	
} // end function
?>