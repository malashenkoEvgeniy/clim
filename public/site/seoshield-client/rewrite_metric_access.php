<?php

if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));
include_once(SEOSHIELD_ROOT_PATH."/core/module.php");$module_name="rewrite_metric_access";
$module_file = $module_name.".php";
include_once(SEOSHIELD_ROOT_PATH."/core/modules/".basename($module_file));
$module_config_file=SEOSHIELD_ROOT_PATH."/modules/".basename($module_file);

if(file_exists($module_config_file)){
	include_once($module_config_file);
	$module_class_name="SeoShieldModule_".$module_name."_config";
}else{
	$module_class_name="SeoShieldModule_".$module_name;
}
$rewriteModule = new $module_class_name();
$rewriteModule->start_cms();

?>