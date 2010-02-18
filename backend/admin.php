<?php 
$pageTitle = "Site Management";
include_once("common/header.php");
?>
<?
if ($_SESSION['authorised'])
{
	echo getDescription(getConfigVariable('admin-intro'));
		echo "<h4>Dates</h4><hr/>";
		echo "Date are formatted 'YYYY-MM-DD'";
		
	echo "<h4>Ways to make links</h4><hr/>";
	?>
There is an easy shorthand for links, typed as <pre>[[type-of-link:object-to-link-to|link-text]]</pre>

If the part after the pipe symbol (link-text, after the "|") is ommitted, then the link title is given by the text to the right of the colon (object-to-link-to, ":"). Full examples inculde...<hr/>

To carriage set FSH21
<pre>[[carset:21|FSH21]]</pre><hr/>

To FSH carriage sets
<pre>[[carsettype:FSH|FSH carriage sets]]</pre><hr/>

To H type carriage sets in general
<pre>[[carsetfamily:H|H type carriage sets]]</pre><hr/>

To carriage ACN3
<pre>[[car:3|ACN3]]</pre><hr/>

To ACN carriages
<pre>[[cartype:ACN|ACN carriages]]</pre><hr/>

To N type carriages in general
<pre>[[carfamily:N|N type carriages]]</pre><hr/>

To a station
<pre>[[station:geelong|Geeelong station]]</pre><hr/>

To a region
<pre>[[region:south western|South Western]]</pre><hr/>

To a locomotive
<pre>[[loco:N451|N451]]</pre><hr/>

To a locomotive class
<pre>[[lococlass:n|N class]]</pre><hr/>

To a railcar
<pre>[[railcar:VL02|VL02]]</pre><hr/>

To a railcar type
<pre>[[railcartype:VLocity|VLocity railcar]]</pre>
<?
}
else
{
	echo '<h3 class="error">Unauthorised</h3>';
}	// end login statement
?>

<? include_once("common/footer.php"); ?>