<?php
require_once (dirname(__FILE__)."/class/DBManager.php");

if(isset($_GET["url"]))
{
	$url = $_GET["url"];
}
else
{
	exit();
}
$dbm = new DBManager();
$id = $dbm->getSiteId($url);
$dbm->upOut($id);
header("location: {$url}");
exit();