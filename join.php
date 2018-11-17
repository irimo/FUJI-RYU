<?php
require_once(dirname(__FILE__)."/class/DBManager.php");
require_once (dirname(__FILE__)."/Smarty_conf.php");
include(dirname(__FILE__)."/conf/mangas_conf.php");

if(isset($_POST["mode"]))
{
	$mode = $_POST["mode"];
}

if($mode == "submit" || $mode == "edit")
{
	$send_arr = array();
	$send_arr["sitename"] = $_POST["sitename"];
	$send_arr["banner"] = $_POST["banner"];
	$send_arr["url"] = $_POST["url"];
	$send_arr["master"] = $_POST["master"];
	$send_arr["explain"] = $_POST["explain"];
	$send_arr["secret_q"] = $_POST["secret_q"];
	$send_arr["secret_a"] = $_POST["secret_a"];
	$send_arr["mail"] = $_POST["mail"];
	$send_arr["pw"] = $_POST["pw"];
	
	$manga_arr = array();
	if(isset($_POST["hamerun"]))
		if($_POST["hamerun"] == 1)
			$manga_arr["hamerun"] = 1;
		else $manga_arr["hamerun"] = 0;
	if(isset($_POST["worlds"]))
		if($_POST["hamerun"] == 1)
			$manga_arr["worlds"] = 1;
		else $manga_arr["worlds"] = 0;
	if(isset($_POST["tight"]))
		if($_POST["tight"] == 1)
			$manga_arr["tight"] = 1;
		else $manga_arr["tight"] = 0;
	if(isset($_POST["shadow"]))
		if($_POST["shadow"] == 1)
			$manga_arr["shadow"] = 1;
		else $manga_arr["shadow"] = 0;
	if(isset($_POST["soul"]))
		if($_POST["soul"] == 1)
			$manga_arr["soul"] = 1;
		else $manga_arr["soul"] = 0;
	if(isset($_POST["psycho"]))
		if($_POST["psycho"] == 1)
			$manga_arr["psycho"] = 1;
		else $manga_arr["psycho"] = 0;
	if(isset($_POST["densengen"]))
		if($_POST["densengen"] == 1)
			$manga_arr["densengen"] = 1;
		else $manga_arr["densengen"] = 0;
	if(isset($_POST["digitalian"]))
		if($_POST["digitalian"] == 1)
			$manga_arr["digitalian"] = 1;
		else $manga_arr["digitalian"] = 0;
	if(isset($_POST["dramatic"]))
		if($_POST["dramatic"] == 1)
			$manga_arr["dramatic"] = 1;
		else $manga_arr["dramatic"] = 0;
	if(isset($_POST["houshin"]))
		if($_POST["houshin"] == 1)
			$manga_arr["houshin"] = 1;
		else $manga_arr["houshin"] = 0;
	if(isset($_POST["yugamizm"]))
		if($_POST["yugamizm"] == 1)
			$manga_arr["yugamizm"] = 1;
		else $manga_arr["yugamizm"] = 0;
	if(isset($_POST["milk"]))
		if($_POST["milk"] == 1)
			$manga_arr["milk"] = 1;
		else $manga_arr["milk"] = 0;
	if(isset($_POST["isetu"]))
		if($_POST["isetu"] == 1)
			$manga_arr["isetu"] = 1;
		else $manga_arr["isetu"] = 0;
	if(isset($_POST["sakura"]))
		if($_POST["sakura"] == 1)
		$manga_arr["sakura"] = 1;
		else $manga_arr["sakura"] = 0;
	if(isset($_POST["waqwaq"]))
		if($_POST["waqwaq"] == 1)
		$manga_arr["waqwaq"] = 1;
		else $manga_arr["waqwaq"] = 0;
	if(isset($_POST["tenkyuugi"]))
		if($_POST["tenkyuugi"] == 1)
		$manga_arr["tenkyuugi"] = 1;
		else $manga_arr["tenkyuugi"] = 0;
	if(isset($_POST["guripan"]))
		if($_POST["guripan"] == 1)
			$manga_arr["guripan"] = 1;
		else $manga_arr["guripan"] = 0;
	if(isset($_POST["shiki"]))
		if($_POST["shiki"] == 1)
			$manga_arr["shiki"] = 1;
		else $manga_arr["shiki"] = 0;
		
		
	$dbmanager = new DBManager();
	if($mode == "submit")
	{
		$ret = $dbmanager->setSite($send_arr);
		if(!$ret)die("登録内容に不足があります。もう一回やり直してください。");
		$id = $dbmanager->getSiteId($send_arr["url"]);
		$dbmanager->setMangas($id,$manga_arr);
		if(!$ret)die("登録に失敗しました。");
	}
	elseif($mode == "edit")
	{
		if(isset($_POST["id"]))
		{
			$id = $_POST["id"];
		}
		else
		{
			exit();
		}
		$ret = $dbmanager->updateSite($id,$send_arr);
		if($ret == false)die("サイト情報の修正に失敗しました。");
		$ret = $dbmanager->setMangas($id,$manga_arr);
		if($ret == false)die("取り扱い漫画情報の修正に失敗しました。");
	}
	
	$smarty->assign("id",$id);
	$smarty->assign("mode" , $mode);
	$smarty->display("join_success.html");
}
elseif($mode == "delete")
{
	if(isset($_POST["id"]))
	{
		$id = $_POST["id"];
	}
	else
	{
		exit();
	}
	$dbm = new DBManager();
	$ret = $dbm->setDelFlag($id,1);
	if($ret == false)die("削除に失敗しました。");
	echo "サイト情報を削除しました。今までありがとうございました。";
}
?>