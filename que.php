<?php

require_once '../century/Smarty/Smarty.class.php';
require_once (dirname(__FILE__)."/class/DBManager.php");
$smarty = new Smarty; 
$smarty->template_dir = dirname(__FILE__)."/tpl/";
$smarty->compile_dir = dirname(__FILE__)."/tplc/";



$dbm = new DBManager();
$site_arr = $dbm->getSiteDataQue();
$var_mangas = array();
$var_sites = array();
if(count($site_arr) > 0)
{
	foreach($site_arr as $i => $data)
	{
		$id = $data["id"];
		$var_sites[$id] = array();
		$var_sites[$id] = $data;
	}
}
$smarty->assign("data",$var_sites);
$smarty->display("que.html");