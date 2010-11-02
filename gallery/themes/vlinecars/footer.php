</td></tr>
<tr><td id="footer" colspan="2">
Copyright 2006-<?php print date('Y'); ?> 
<?php 	//display page generation time
	// start $time = round(microtime(), 3);
$time2 = round(microtime(), 3);
$generation = str_replace('-', '', $time2 - $time);
?>
Page Generation: <?=$generation?> seconds.<br/>
</td></tr>
</table>
<!-- end #container -->
</body>
</html>