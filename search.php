<?php
require_once (dirname(__FILE__)."/class/DBManager.php");
require_once (dirname(__FILE__)."/Smarty_conf.php");

if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}
else
{
	$mode = "";
}
if($mode == "")
{
	include(dirname(__FILE__)."/conf/mangas_conf.php");
	$smarty->assign("mangas_arr",$mangas_arr);
	$smarty->display("search_form.html");
}
if($mode == "search_explain")
{
	include(dirname(__FILE__)."/conf/mangas_conf.php");

	$word = htmlspecialchars($_GET["word"]);
	$smarty->assign("words", $word);

	$dbm = new DBManager();
	$sites = $dbm->getSearchSite($word);
	if($sites == false || count($sites) <= 0)
	{
		die("該当するサイトはありません");
	}
	$data = array();

// その人が登録している漫画を取得
	foreach($sites as $sitedata){
		$manga_arr = $dbm->getMangaDataAll($sitedata["id"]);
		foreach($manga_arr as $i => $mangadata)
		{
			$mymanga = array();
			foreach($mangadata as $id => $flag)
			{
				if($flag === "1"){
					$sitedata["mangas"][] = $mangas_arr[$id];
				}
			}
		}
		$data[] = $sitedata;
	}
$data = array_reverse($data);
$smarty->assign("mode", "search");
$smarty->assign("data", $data);
$smarty->display("list.html");
}
if($mode == "search_mangas")
{
	include(dirname(__FILE__)."/conf/mangas_conf.php");
	$mangas = array();
	$word = "";
	foreach($mangas_arr as $i => $value)
	{
		if(isset($_GET[$i]))
		{
			$mangas[] = $i;
			$word .= $mangas_arr[$i]."　";
		}
	}
	$smarty->assign("words", $word);
	
	$dbm = new DBManager();
	$sites = $dbm->getSearchFromMangas($mangas);
	if($sites == false || count($sites) <= 0)
	{
		die("該当するサイトはありません");
	}
	$data = array();

// その人が登録している漫画を取得
	foreach($sites as $sitedata){
		$manga_arr = $dbm->getMangaDataAll($sitedata["id"]);
		foreach($manga_arr as $i => $mangadata)
		{
			$mymanga = array();
			foreach($mangadata as $id => $flag)
			{
				if($flag === "1"){
					$sitedata["mangas"][] = $mangas_arr[$id];
				}
			}
		}
		$data[] = $sitedata;
	}
$data = array_reverse($data);
$smarty->assign("mode", "search");
$smarty->assign("data", $data);
$smarty->display("list.html");
}
