<?php 
include_once("vlinecars-definitions.php");
include_once("vlinecars-formatting-functions.php");
include_once("formatting-functions.php");

//start timer
$time = round(microtime(), 3);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=getPageTitle($pageTitle)?></title>
<script type="text/javascript" src="/js/jquery-1.2.2.pack.js"></script>
<script type="text/javascript" src="/js/ddaccordion.js"></script>
<script type="text/javascript">//<![CDATA[ 
ddaccordion.init({
        headerclass: "xpand", //Shared CSS class name of headers group that are xpand
        contentclass: "menuitem", //Shared CSS class name of contents group
        collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
        defaultexpanded: [<?=getMenuIndex($pageTitle)?>], //index of content(s) open by default [index1, index2, etc]. [] denotes no content
        animatedefault: false, //Should contents open by default be animated into view?
        persiststate: false, //persist state of opened contents within browser session?
        toggleclass: ["", "openheader"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
        togglehtml: ["prefix", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
        animatespeed: "normal" //speed of animation: "fast", "normal", or "slow"
})//]]></script>
<link href="/css/vlinecars.css" rel="stylesheet" type="text/css" />
<!--[if IE 5]>
<style type="text/css"> 
/* place css box model fixes for IE 5* in this conditional comment */
.ThreeColumnFixedHeader #LeftColumn1 { width: 200px; }
.ThreeColumnFixedHeader #RightColumn { width: 200px; }
</style>
<![endif]--><!--[if IE]>
<style type="text/css"> 
/* place css fixes for all versions of IE in this conditional comment */
.ThreeColumnFixedHeader #RightColumn, .ThreeColumnFixedHeader #LeftColumn { padding-top: 30px; }
.ThreeColumnFixedHeader #mainContent { zoom: 1; }
/* the above proprietary zoom property gives IE the hasLayout it needs to avoid several bugs */
</style>
<![endif]-->
</head>
<body class="ThreeColumnFixedHeader">
<table id="container"><a name="top" id="top"></a>
<tr><td id="header" colspan="2">
<div id="HeaderLogo">
<h1><a href="/" alt="V/LineCars.com Home" title="V/LineCars.com Home"><img src="/images/vlinecarslogo.png" alt="V/LineCars.com Home" title="V/LineCars.com Home" width="154" height="80" class="HeaderLogo" /></a></h1>
</div><div id="HeaderSearch">
<form action="" method="post">Search <input name="searchterm" type="text" /> <input name="StartSearch" type="button" value="Go" /></form>
</div></td></tr>
<tr><td colspan="2" id="subheader">
<?=getPageBreadcrumbs($pageTitle); ?>
</td></tr>
<tr><td id="LeftColumn">
<?php include_once('nav.php');
?>
</td>
<td id="mainContent">