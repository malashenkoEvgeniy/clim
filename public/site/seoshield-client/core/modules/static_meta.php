<?php
/*
* модуль подменяет статические мета данные
*/

if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_static_meta extends seoShieldModule
{
	/**
	 * метод для обновления данных
	 */
	function update_data($data)
	{
		var_dump($data);
	}

	function html_out_buffer($out_html)
	{
		if(file_exists(SEOSHIELD_ROOT_PATH . '/data/static_meta.cache.php'))
		{
			if(!isset($GLOBALS['SEOSHIELD_DATA']['static_meta']))
				$this->get_static_meta();

			if(isset($GLOBALS['SEOSHIELD_DATA']['static_meta']) && is_array($GLOBALS['SEOSHIELD_DATA']['static_meta']))
			{
				foreach($GLOBALS['SEOSHIELD_DATA']['static_meta'] as $static_type => $static_val)
				{
					$function = 'replace_page_'.$static_type;
					if(!is_null($static_val))
						$out_html = $this->$function($out_html, $static_val);
				}
			}
		}
		else
		{
			$csv_file_name = SEOSHIELD_ROOT_PATH . '/data/static_meta.csv';

			if(file_exists($csv_file_name)
				&& is_readable($csv_file_name))
			{
				$meta_data = $this->csv2array($csv_file_name);

				foreach($meta_data AS $cols)
				{
					$url = preg_replace("#^https?://[^/]+#is","",trim($cols[0]));
					if(substr($url, 0, 1) != '/')
						continue;

					if($url==$GLOBALS['SEOSHIELD_CONFIG']['page_uri']){
						if(!empty($cols[1])){
							$title=trim($cols[1]);
						}elseif($cols[1]=="удалить"
							|| $cols[1]==""){
							$title="";
						}
						$out_html=$this->replace_page_title($out_html,$title);

						if(!empty($cols[2])){
							$description=trim($cols[2]);
						}elseif($cols[2]=="удалить"
							|| $cols[2]==""){
							$description="";
						}
						if(strpos($description,"Генерируется по формуле") === false )
							$out_html=$this->replace_page_meta_description($out_html,$description);

						if(!empty($cols[3])){
							$h1=trim($cols[3]);
						}elseif($cols[3]=="удалить"
							|| $cols[3]==""){
							$h1="";
						}
						$out_html = $this->replace_page_h1($out_html,$h1);

						if(!empty($cols[4])){
							$meta_keywords=trim($cols[4]);
						}elseif($cols[4]=="удалить"
							|| $cols[4]==""){
							$meta_keywords="";
						}
						$out_html = $this->replace_page_meta_keywords($out_html,$meta_keywords);
					}
				}
			}
		}

		return $out_html;
	}
}