<?php

require_once (dirname(__FILE__)."/class/DBManager.php");
require_once (dirname(__FILE__)."/Smarty_conf.php");

if(isset($_GET['mode']))
{
	$mode = $_GET['mode'];
}
else
{
	$mode = "";
}
if($mode == "")
{
	$smarty->display("edit_check.html");
}
elseif($mode == "edit")
{
	if(isset($_POST["siteid"]))
	{
		$siteid = $_POST["siteid"];
	}
	else
	{
		$smarty->display("edit_fault.html");
		return false;
	}
	if(isset($_POST["pw"]))
	{
		$pw = $_POST["pw"];
	}
	else
	{
		$smarty->display("edit_fault.html");
		return false;
	}
	
	$dbm = new DBManager();
	if($dbm->checkPW($siteid, $pw) == false)
	{
		$smarty->display("edit_fault.html");
		return false;
	}
	$ret = $data = $dbm->getSiteDataRow($siteid);
	if($ret == false || count($ret) <= 0)
	{
		die("no data");
	}
	$data_manga_id = $dbm->getMangaDataRow($siteid);
	$data_manga = array();
	include (dirname(__FILE__)."/conf/mangas_conf.php");
	foreach($data_manga_id as $id => $val)
	{	if($id != "id")
		{
			$data_manga[$id] = array();
			$data_manga[$id]["val"] = $val;
		}
	}
	foreach($mangas_arr as $id => $name)
	{
		$data_manga[$id]["str"] = $name;
	}
	$data["manga"] = $data_manga;
	$smarty->assign("data",$data);
	$smarty->assign("siteid",$siteid);
	$smarty->display("edit_form.html");
}
