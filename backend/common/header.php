<?php 
//start timer
$time = round(microtime(), 3);

// start session
session_start();

include_once($_SERVER['DOCUMENT_ROOT']."/backend/common/dbConnection.php");
include_once($_SERVER['DOCUMENT_ROOT']."/common/formatting-functions.php");
include_once($_SERVER['DOCUMENT_ROOT']."/common/vlinecars-formatting-functions.php");

// test for localhost
$server = $_SERVER['HTTP_HOST'];
if ($server == 'z' OR $server == 'localhost')
{
	$localhost = true;
	$_SESSION['authorised'] = true;
}

if (!$_SESSION['authorised'])
{
	$url = "/backend/index.php";
	$url = "http://".$_SERVER['HTTP_HOST'].$url;
	header("Location: ".$url,TRUE,302);
}

if($pageTitle == '')
{
	$pageTitle = "Site Management";//V/LineCars.com - Carriage Infomation Management System";
}
if($pageHeading == "")
{
	$pageHeading = $pageTitle;
}	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>V/LineCars.com - <?php echo $pageTitle;?></title>
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
<div id="user_info"><p>
  <a href="/backend/admin.php">Admin Home</a> &nbsp; | &nbsp; <a href="/news/wp-admin/" target="_blank">News</a> &nbsp; | &nbsp; <a href="/gallery/zp-core/" target="_blank">Gallery</a> &nbsp; | &nbsp; <a href="/backend/index.php">Logout</a></p> 
</div>
<tr><td width="140"></td>
<td id="big" valign="top">
<div id="content">