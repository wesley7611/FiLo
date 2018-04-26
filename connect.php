<?php
session_start();
//connect to the SQL database
$db = new PDO("mysql:dbname=id4501675_property;host=localhost", "id4501675_wesley7611", "*****");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
