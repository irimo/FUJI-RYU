<?php
require_once (dirname(__FILE__)."/Smarty_conf.php");

if(isset($_GET["id"]))
{
	$id = $_GET["id"];
}
else
{
	$id = "【あなたのid】";
}

$smarty->assign("id",$id);
$smarty->display("nabiba.html");