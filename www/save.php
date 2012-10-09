<?php
include("config.php");

if (!isset($_POST['data'])) {
   exit("no variables set");
}

print("data posted: " . $_POST['data'] . "\n");

$data = strip_tags($_POST['data']);

$link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD)
                 or die("Could not connect to database");
mysql_select_db(MYSQL_DB) or die( "Could not select database" );	


$query = "DELETE from lists";
mysql_query($query);

$query = "INSERT INTO lists (lists) VALUES('$data')";
mysql_query($query);
?>
