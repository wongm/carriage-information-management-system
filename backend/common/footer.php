</div><div id="footer">
<a href="/index.php">Site Home</a> :: <a href="/backend">Admin Home</a><br/>
<?php 	//display page generation time
	// start $time = round(microtime(), 3);
$time2 = round(microtime(), 3);
$generation = str_replace('-', '', $time2 - $time);
echo "Page Generation: $generation seconds.<br/>";?>
Copyright 2008 &copy; Marcus Wong except where otherwise noted.
</div>
<div id="navigation">
<!-- http://www.projectseven.com/tutorials/css/uberlinks/index.htm -->
<?php include_once("nav.php"); ?>
</div>
</td></tr>
</table>
</body>
</html>
