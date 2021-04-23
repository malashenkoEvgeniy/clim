<?php
/*
* модуль подменяет динамические мета данные
*/

if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_genereate_meta extends seoShieldModule
{
	function html_out_buffer($out_html)
	{
		// $out_html=$this->replace_page_h1($out_html,$GLOBALS['SEOSHIELD_CONFIG']['page_h1']);
		// $out_html=$this->replace_page_meta_description($out_html,$GLOBALS['SEOSHIELD_CONFIG']['page_meta_description']);
		// $out_html=$this->replace_page_title($out_html,$GLOBALS['SEOSHIELD_CONFIG']['page_title']);
		// $out_html=$this->replace_page_meta_keywords($out_html,$GLOBALS['SEOSHIELD_CONFIG']['page_meta_keywords']);
		return $out_html;
	}
}