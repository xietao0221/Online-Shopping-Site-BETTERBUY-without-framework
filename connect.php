<?php
$sqlServerName = "localhost";
$sqlUserName = "root";
$sqlPassWord = "tao19890221xie";

// Create connection
$con = mysql_connect($sqlServerName, $sqlUserName, $sqlPassWord);

// Check connection
if (!$con) {
	die ('Cannot connect: ' . mysql_error());
}

// Select a database
$res = mysql_select_db('betterbuy', $con);
if (!$res) {
	die ('Cannot use the database betterbuy: ' . mysql_error());
}
?>