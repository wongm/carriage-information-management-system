<?php
$pageTitle = array(array("Welcome", ''));
$pageHeading = "Welcome";
include_once("common/dbConnection.php");
include_once("common/vlinecars-definitions.php");
include_once("common/formatting-functions.php");
include_once("common/header.php");
?>
<table>
<tr><td valign="top">
<?

//echo getConfigVariable('index_page');
/*
<h1>Welcome to the Carriage Information Management System</h1>

<p align=center>The aim of this project is to produce a web based content management system to collate and display the history of Victorian railway carriages and carriage sets.</p>
<p align=center>Data includes histories of carriages, carriage types, and carriage sets, and you are able to browse these in various ways.</p>
<p align=center>In addition to the standard XHTML page you are viewing, a low bandwidth version optimised for mobile phone browsers is available <a href="/mindex.php">at this page</a></p>

</td><td>
<p align=center><img src="/img2.jpg" alt="Carriage at Southern Cross Station" title="Carriage at Southern Cross Station" /></p>

*/ ?>
</td></tr>
</table>
<?
//echo getConfigVariable('index-top');
//echo getConfigVariable('index-bottom');
include_once("common/footer.php");
?>