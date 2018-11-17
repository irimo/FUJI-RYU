<?php

require_once dirname(__FILE__).'/../century/Smarty/Smarty.class.php';
$smarty = new Smarty();
$smarty->template_dir = dirname(__FILE__)."/tpl/";
$smarty->compile_dir = dirname(__FILE__)."/tplc/";