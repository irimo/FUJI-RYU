<?php
require_once (dirname(__FILE__)."/class/DBManager.php");
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}
else
{
	exit();
}

if(isset($_GET["id"]))
{
	$id = $_GET["id"];
}
else
{
	exit();
}
$dbm = new DBManager();
if($mode == "back")
{
	$backid = $dbm->getBackId($id);
	$dbm->upOut($id);
	$dbm->upIn($backid);
	$url = $dbm->getUrl($backid);
}
elseif($mode == "next")
{
	$nextid = $dbm->getNextId($id);
	$dbm->upOut($id);
	$dbm->upIn($nextid);
	$url = $dbm->getUrl($nextid);
}
elseif($mode == "random")
{
	$randid = $dbm->getRandId();
	$dbm->upOut($id);
	$dbm->upIn($randid);
	$url = $dbm->getUrl($randid);
}
else
{
	$url = "http://www.yahoo.co.jp";
}
//header("Location : ".$url);
header("Location: {$url}");
exit();
