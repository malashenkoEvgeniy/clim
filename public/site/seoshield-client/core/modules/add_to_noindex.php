<?php
if(!defined("SEOSHIELD_ROOT_PATH"))
	define("SEOSHIELD_ROOT_PATH", rtrim(realpath(dirname(__FILE__)), "/"));

class SeoShieldModule_add_to_noindex extends seoShieldModule
{
	function add_to_noindex_rules()
	{

	}

	function html_out_buffer($out_html)
	{
		$this->add_to_noindex_rules();

		if(isset($GLOBALS['SEOSHIELD_CONFIG']['noindex_pattern'])){
			foreach($GLOBALS['SEOSHIELD_CONFIG']['noindex_pattern'] AS $pattern)
			{
				if(preg_match_all($pattern,$out_html,$noindex_content,PREG_SET_ORDER)==0)
					continue;

				foreach($noindex_content AS $tag){
					$out_html=str_replace($tag[0],"<noindex>".$tag[0]."</noindex>",$out_html);
				}
			}
		}

		return $out_html;
	}
}