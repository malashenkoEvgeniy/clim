<?php
/*
 *	глобальный модуль
 */
if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_global_module extends seoShieldModule
{
	function start_cms()
	{

	}

	function html_out_buffer($out_html)
	{
		/*
		 *	$GLOBALS['SEOSHIELD_DATA']['template_data'] - массив с данными шаблона
		 */
		

		return $out_html;
	}
}