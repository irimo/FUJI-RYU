<?php

require_once '../century/Smarty/Smarty.class.php';
require_once (dirname(__FILE__)."/class/DBManager.php");
$smarty = new Smarty; 
$smarty->template_dir = dirname(__FILE__)."/tpl/";
$smarty->compile_dir = dirname(__FILE__)."/tplc/";



$dbm = new DBManager();
$site_arr = $dbm->getSiteDataAll();
$manga_arr = $dbm->getMangaDataAll();
$var_mangas = array();
include(dirname(__FILE__)."/conf/mangas_conf.php");
foreach($manga_arr as $j => $mangas)
{
	$id = $manga_arr[$j]["id"];
	$var_mangas[$id] = array();
	foreach($mangas as $label => $i)
	{	
		if($i > 0)
		{
			if(isset($mangas_arr[$label]) && $label != "id")
			{
				$var_mangas[$id][] = $mangas_arr[$label];
			}
		}
	}
}
$var_sites = array();
if(count($site_arr) > 0)
{
	foreach($site_arr as $i => $data)
	{
		$id = $data["id"];
		$var_sites[$id] = array();
		$var_sites[$id] = $data;
		$var_sites[$id]["mangas"] = $var_mangas[$id];
	}
}
$var_sites = array_reverse($var_sites);
$smarty->assign("data",$var_sites);
$smarty->display("list.html");