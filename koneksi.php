<?php
$hostname	= "localhost";
$username	= "root";
$password	= "";
$database	= "survey";

$masuk = mysql_connect($hostname, $username, $password, $database) or die('Connection Failed');
$hore = mysql_select_db("$database") or die('Database Failed');
?>