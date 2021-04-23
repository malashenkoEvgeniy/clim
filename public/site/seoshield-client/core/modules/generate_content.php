<?php
if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_generate_content extends seoShieldModule
{
    function generate_content_rules()
	{

	}

	function html_out_buffer($out_html)
	{
		// пример вставки кода в начало страницы
		$this->generate_content_rules();
		
		if(isset($GLOBALS['SEOSHIELD_CONFIG']['content_place'])){
			$out_html=preg_replace($GLOBALS['SEOSHIELD_CONFIG']['content_place'],$GLOBALS['SEOSHIELD_CONFIG']['content_formula'],$out_html);
		}

		return $out_html;
	}
}