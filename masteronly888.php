<?php
require_once (dirname(__FILE__)."/class/DBManager.php");
require_once (dirname(__FILE__)."/Smarty_conf.php");
define("MY_ADDR", "219.121.160.148");
//define("MY_ADDR", "127.0.0.1");
echo "your addr:".$_SERVER["REMOTE_ADDR"] .": ALLOW_ADDR:219.121.160.148";

if(isset($_POST["mode"]))
{
	$mode = $_POST["mode"];
} 
else
{
	$mode = "";
}
$dbm = new DBManager();

if($mode != "")
{
	if(MY_ADDR != $_SERVER["REMOTE_ADDR"])
	{
		die("FORBID UPADTE");
	}
	
	if(isset($_POST["siteid"]))
	{
		$id = $_POST["siteid"];
	}
	else
	{
		die("NO SITEID");
	}
	
	
	if($mode == "join")
	{
		$ret = $dbm->setCheckFlag($id);
	}
	if($mode == "kari")
	{
		$ret = $dbm->setCheckFlag($id,0);
	}
	elseif($mode == "delete")
	{
		$ret = $dbm->setDelFlag($id,1);
	}
	elseif($mode == "recover")
	{
		$ret = $dbm->setDelFlag($id,0);		
	}
}
$ret = $dbm->getSiteDataAll_master();
$smarty->assign("data", $ret);
$smarty->display("master_only.html");
