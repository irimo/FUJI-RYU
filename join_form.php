<?php
require_once (dirname(__FILE__)."/class/DBManager.php");
require_once (dirname(__FILE__)."/Smarty_conf.php");
include(dirname(__FILE__)."/conf/mangas_conf.php");
$smarty->assign("mangas_arr",$mangas_arr);
$smarty->display("join_form.html");