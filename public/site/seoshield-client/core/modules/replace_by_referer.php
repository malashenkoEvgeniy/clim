<?php
/*
* модуль подменяет данные по рефереру
*/

if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_replace_by_referer extends seoShieldModule
{
	function check_substring($needle, $haystack)
	{
		if (substr_count($needle, '#') == 2)
		{
			$pattern = $needle;
			if (preg_match($pattern, $haystack))
				return true;
			else
				return false;       
		}
		else
		{
			if (strpos($needle, $haystack) !== false)
				return true;
			else
				return false;
		}
	}

	function detect_user_source()
	{
		$_COOKIE = array();
		$source = array("","","");

		if (!isset($_COOKIE['ss_source']) 
			&& isset($_SERVER['HTTP_REFERER']) 
			&& isset($_SERVER['REQUEST_URI']) 
			&& isset($_SERVER['REMOTE_ADDR']))
		{
			$http_referer = $_SERVER['HTTP_REFERER'];
			$request_uri = $_SERVER['REQUEST_URI'];
			$remote_addr = $_SERVER['REMOTE_ADDR'];
			$referer = null;
			$traffic = null;
			$country = null;

			// $country = $this->httpGet("http://pager.seoshield.ru/geolocate.php?ip=".$remote_addr);

			foreach ($GLOBALS['SEOSHIELD_CONFIG']['replace_by_referer'] as $source => $data) {
				foreach ($data['domains'] as $domain) {
					if ($this->check_substring($domain, $http_referer))
					{
						$referer = $source;
						break;
					}
				}
			}
			if (!is_null($referer))
			{
				$traffic = 'organic';
				foreach ($GLOBALS['SEOSHIELD_CONFIG']['replace_by_referer'][$referer]['traffic'] as $traffic_type => $mark)
				{
					foreach ($mark as $m) {
						if ($this->check_substring($m, $request_uri))
						{
							$traffic = $traffic_type;
							break;
						}
					}
				}
			}
			$source = array($referer, $traffic, $country);
			setcookie('ss_source', json_encode($source), time() + 14*24*60*60);            
		}
		elseif (isset($_COOKIE['ss_source']))
			$source = json_decode($_COOKIE['ss_source']);

		return $source; 
	}

	function html_out_buffer($out_html)
	{
		$source = $this->detect_user_source();
		$referer = $source[0];
		$traffic = $source[1];
		$country = $source[2];

		$additional_js = '';
		$csv_file_name = SEOSHIELD_ROOT_PATH . '/data/replace_by_referer.csv';

		if(file_exists($csv_file_name)
			&& is_readable($csv_file_name))
		{
			$file_res = $this->csv2array($csv_file_name, ',', '"');

			/*
			 *  csv файл должен быть в 1251 кодировке, разделитель - ',' ограничитель - '"' 
			 *  cols[0] - реферер, cols[1] - тип трафикаб cols[2] - страна, cols[3] - комментарий для замены, cols[4] - контент замены
			 *  комменты вида <!--ss_replace_1--> ... <!--/ss_replace_1-->
			 */
			$comment_arr = array();
			$content_arr = array();
			foreach($file_res AS $cols)
			{
				$referer_csv = trim(strtolower($cols[0]));
				$traffic_csv = trim(strtolower($cols[1]));
				$country_csv = trim(strtolower($cols[2]));
				$comment = trim($cols[3]);
				$content = trim($cols[4]);

				if(strpos($referer, $referer_csv) !== false
					&& strpos($traffic, $traffic_csv) !== false
					&& strpos($country, $country_csv) !== false
					&& !empty($comment) && !empty($content))
				{
					$comment_arr[] = $comment;
					$content_arr[] = $content;
				}
			}
		}
		if(isset($comment_arr) && sizeof($comment_arr) > 0 && sizeof($content_arr) > 0)
		{
			/*
			 *  пробегаемся по всем нодам, если нашли открывающий коммент, начинаем удалять все что после него,
			 *  когда нашли закрывающий - заканчиваем удалять и добавляем контент
			 */
			$additional_js = '
			<script type="text/javascript">
				function load_script (url)
				{
					var xmlhttp;
					try {
						xmlhttp = new XMLHttpRequest();
					} catch (e) {
						xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
					}
					xmlhttp.open("GET", url, false); xmlhttp.send("");
					eval(xmlhttp.responseText);
					var s = xmlhttp.responseText.split(/\n/);
					var r = /^function\s*([a-z_]+)/i; 
					for (var i = 0; i < s.length; i++)
					{
						var m = r.exec(s[i]);
						if (m != null)
							window[m[1]] = eval(m[1]);
					}
				}
				try {
					$(document).ready();
				}
				catch (e){
					load_script("https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js");  
				}
				jQuery = $.noConflict();
				jQuery(document).ready(function(){
					var comment_arr = '.json_encode($comment_arr).',
						content_arr = '.json_encode($content_arr).',
						remove_nodes = false;
					jQuery("*").contents().filter(function(){ 
						if(this.nodeType == 8 && comment_arr.indexOf(this.nodeValue) !== -1)
							remove_nodes = true;
						else if(this.nodeType == 8 && comment_arr.indexOf(this.nodeValue.substr(1)) !== -1)
						{
							jQuery(this).before(content_arr[comment_arr.indexOf(this.nodeValue.substr(1))]).remove();
							remove_nodes = false;
						}

						if(remove_nodes)
							jQuery(this).remove();
					});
				});
				$ = jQuery.noConflict();
			</script>
			';
		}
		
		$out_html = str_replace('</body>', $additional_js.'</body>', $out_html);
		return $out_html;
	}
}