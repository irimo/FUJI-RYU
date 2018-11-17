<?php

require_once (dirname(__FILE__)."/class/DBManager.php");
require_once (dirname(__FILE__)."/Smarty_conf.php");

if(isset($_POST["mode"]))
{
	$mode = $_POST["mode"];
}
else
{
	$mode = "";
}

if(isset($_POST["id"]))
{
	$id = $_POST["id"];
}
else
{
	$id = 0;
}
if($mode == "")
{
	$smarty->display("secret_q_show.html");
}
if($mode == "result")
{
	$dbm = new DBManager();
	$secret_q = $dbm->getSecretQ($id);
	$smarty->assign("secret_q", $secret_q);
	$smarty->assign("id", $id);
	$smarty->display("secret_q_question.html");
}
if($mode == "check_a")
{
	if(isset($_POST["secret_a"]))
	{
		$secret_a = $_POST["secret_a"];
	}
	else
	{
		$secret_a = "";
	}
	$dbm = new DBManager();
	$pw = $dbm->getPwFromSecretQ($id,$secret_a);
	$smarty->assign("pw", $pw);
	$smarty->display("secret_q_pw.html");
}