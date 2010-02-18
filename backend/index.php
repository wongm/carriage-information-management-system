<?php 

session_start();
$_SESSION['authorised'] = false;

// test for localhost
$server = $_SERVER['HTTP_HOST'];
if ($server == 'z' OR $server == 'localhost')
{
	$localhost = true;
	$_SESSION['authorised'] = true;
	$url = "/backend/admin.php";
	$url = "http://".$_SERVER['HTTP_HOST'].$url;
	header("Location: ".$url,TRUE,302);
}

if (isset($_REQUEST['username']))
{
	$username = addslashes($_REQUEST['username']);
	$password = md5(addslashes($_REQUEST['password']));
	include_once("common/dbConnection.php");

	$sql = "SELECT  * FROM users WHERE username = '$username' AND password = '$password'";
	//echo $sql;

	if (MYSQL_NUM_ROWS(MYSQL_QUERY($sql)) == 1)
	{
		$_SESSION['authorised'] = true;
		$url = "/backend/admin.php";
		$url = "http://".$_SERVER['HTTP_HOST'].$url;
		header("Location: ".$url,TRUE,302);
	}
	else
	{
		fail();
	}
}
else
{
	fail();
}

function fail()
{
	session_unregister($_SESSION['username']);
	session_unregister($_SESSION['password']);
	session_unregister($_SESSION['authorised']);
	session_destroy();
	
	$pageHeading = 'Site Management';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>CIMS - <?php echo $pageTitle;?></title>
<link rel="stylesheet" type="text/css" href="/backend/common/style.css" media="all" title="Normal" />
<script src="/backend/common/functions.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1"/>
<meta name="author" content="Marcus Wong" />
<meta name="description" content="Carriage Infomation Management System"" />
<meta name="keywords" content="railways trains victoria" />
</head>
<body>
<table id="container" cellspacing="5">
<tr><td id="header" colspan="2">
<h1><?php echo $pageHeading; ?></h1>
</td></tr>
<tr><td width="140"></td>
<td id="big" valign="top">
<div id="content">
<table>
<tr><td>
<form name="login" method="POST" action="index.php">

<table cellspacing="2" cellpadding="2" border="0" width="100%">
	<tr valign="top" height="20">
		<td align="right"> <b> Username :  </b> </td>
		<td> <input type="text" name="username" size="20" value="">  </td> 
	</tr>
	<tr valign="top" height="20">
		<td align="right"> <b> Password :  </b> </td>
		<td> <input type="password" name="password" size="20" value="">  </td> 
	</tr>
	<tr valign="top" height="20"><td align="right"><input type="submit" name="submitEnterUserForm" value="Login"></td><td></td></tr>
</table>
</form>
</td></tr>
</table>
</div><div id="footer">
<a href="/index.php">Home</a> :: <a href="/sitemap.php">Sitemap</a><br/>
<?php 	//display page generation time
	// start $time = round(microtime(), 3);
$time2 = round(microtime(), 3);
$generation = str_replace('-', '', $time2 - $time);
echo "Page Generation: $generation seconds.<br/>";?>
Copyright 2008 &copy; Marcus Wong except where otherwise noted.
</div>
</td></tr>
</table>
</body>
</html>
<?php 
}	// end function
?>