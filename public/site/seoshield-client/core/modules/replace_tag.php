<?php
/*
* модуль подменяет статические мета данные
*/

if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_replace_tag extends seoShieldModule
{
	function html_out_buffer($out_html)
	{
		if(!empty($GLOBALS['SEOSHIELD_CONFIG']['replace_tag'])){
			foreach($GLOBALS['SEOSHIELD_CONFIG']['replace_tag'] as $tag){
				$out_html=str_replace("<".$tag.">","<span class=\"stag".$tag."\">",$out_html);
				$out_html=preg_replace("#<(".$tag." )(((.(?!class))*?)(class *= *[\"']([^\"']*)[\"'])?)?([^>]*)>#is","<span \\3 \\7 class=\"\\6 stag".$tag."\">",$out_html);
				$out_html=str_replace("</".$tag.">","</span>",$out_html);
			}
		}
		
		return $out_html;
	}
	
// Снизу новый вариант данного модуля. На случай, если старый не будет работать в каких-то ситуациях.
// Для того чтобы его запустить, надо убрать из имени нижней функции приставку _alter и дописать её в верхнюю.

	function html_out_buffer_alter($out_html)
	{
		if(!empty($GLOBALS['SEOSHIELD_CONFIG']['replace_tag'])){
			foreach($GLOBALS['SEOSHIELD_CONFIG']['replace_tag'] as $tag){
				// Есть два варианта str_replace. Один оригинальный, второй на тот случай, если
				// поломается js. В такой ситуации его надо раскомментить, а первый закомментить
				$out_html=str_replace("<".$tag.">","<span class=\"stag".$tag."\">",$out_html);
				// $out_html=str_replace("<".$tag.">","<span class='stag".$tag."'>",$out_html);

				$out_html = preg_replace_callback('#(<(?:(?!\/)'.$tag.')(?:(?:\s+(?:[\w-]+)(?:\s*=\s*(?:"(?:[^"]*)"|\'(?:[^\']*)\'|(?:[^\'">\s]+)))?)+\s*|\s*)(?:\/)?>)#si', function($finder_outer) use ($tag, &$out_html){

					preg_match_all('#(?<tag_name><'.$tag.'\s)|(?<name>[\w\-]+)\s*=\s*(?:(?:\'(?<value>[^\']*)\')|(?:\"(?<value2>[^\"]*)\"))|(?<e_name>[\w\-]+\s*)#is', $finder_outer[1], $finder_inner);

					if (isset($finder_inner[0]) && !empty($finder_inner[0])){
						$attrs = "";
						$clss = "";
						$attrs_a = array();
						$clss_a = '';

						foreach ($finder_inner['name'] as $k => $attr_name) {
							$attr_name = trim($attr_name);
							if (empty($attr_name)){
								$attr_name = trim($finder_inner['e_name'][$k]);
							}
							if (empty($attr_name)){continue;}
							$attr_value = '';
							$delimiter = '"';
							if (isset($finder_inner['value'][$k]) && !empty($finder_inner['value'][$k])){
								$delimiter = "'";
								$attr_value = $finder_inner['value'][$k];
							}
							if (isset($finder_inner['value2'][$k]) && !empty($finder_inner['value2'][$k])){
								$delimiter = '"';
								$attr_value = $finder_inner['value2'][$k];
							}
							if ($attr_name == 'class'){
								$clss_a = $attr_name.'="'.$attr_value.' stag'.$tag.'"';
							} else {
								$attrs_a[] = $attr_name.'='.$delimiter.$attr_value.$delimiter;
							}
						}
						$attrs = implode(' ', $attrs_a);
						$clss = preg_replace(array('#("\s+)#', '#\s+#'), array('"', ' '), $clss_a);
						if ($clss == ""){
							$clss = 'class="stag'.$tag.'"';
						}
					}

					$result = '<span '.implode(' ', array($attrs, $clss)).'>';
					$result = preg_replace('#(\s{2,})#s', ' ', $result);
					return $result;
				}, $out_html);

				$out_html=str_replace("</".$tag.">","</span>",$out_html);
			}
		}
		
		return $out_html;
	}
	
}
