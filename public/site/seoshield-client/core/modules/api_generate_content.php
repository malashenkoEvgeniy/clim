<?php
/*
 *	генерация текста с API'шки
 */
if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_api_generate_content extends seoShieldModule
{
	protected $cache_file_path = '';

	function start_cms()
	{
		$GLOBALS['SEOSHIELD_DATA']['api_generate_content'] = array();
		$GLOBALS['SEOSHIELD_DATA']['init_api_generate_content'] = array();
		$GLOBALS['SEOSHIELD_DATA']['api_generate_content_options'] = array();

		if(!is_dir($GLOBALS['SEOSHIELD_CONFIG']['contents_path']))
		{
			mkdir($GLOBALS['SEOSHIELD_CONFIG']['contents_path']);
			chmod($GLOBALS['SEOSHIELD_CONFIG']['contents_path'], 0777);
		}

		$this->cache_file_path = $GLOBALS['SEOSHIELD_CONFIG']['contents_path'] . '/' . $GLOBALS['SEOSHIELD_CONFIG']['page_hash'] . '.php';
		if(file_exists($this->cache_file_path))
		{
			$GLOBALS['SEOSHIELD_DATA']['api_generate_content'] = require($this->cache_file_path);
			if(!(is_array($GLOBALS['SEOSHIELD_DATA']['api_generate_content'])
				&& sizeof($GLOBALS['SEOSHIELD_DATA']['api_generate_content']) > 0))
				$GLOBALS['SEOSHIELD_DATA']['api_generate_content'] = array();
		}
	}

	function html_out_buffer($out_html)
	{
		/*
		 *	отправляем запрос в API на получение контента для страницы
		 */
		$contents_res = array();
		if(sizeof($GLOBALS['SEOSHIELD_DATA']['init_api_generate_content']) > 0)
		{
			$access_key = $GLOBALS['SEOSHIELD_CONFIG']['access_key'];
			if(!empty($GLOBALS['SEOSHIELD_CONFIG']['access_keys'][0]))
				$access_key = $GLOBALS['SEOSHIELD_CONFIG']['access_keys'][0];

			$api_url = $GLOBALS['SEOSHIELD_CONFIG']['api_pager'] . '/get_generate_content';

			$data = array();
			$data['access_key'] = $access_key;
			$data['h1'] = '';
			if(isset($GLOBALS['SEOSHIELD_DATA']['static_meta']['h1'])
				&& !is_null($GLOBALS['SEOSHIELD_DATA']['static_meta']['h1']))
				$data['h1'] = $GLOBALS['SEOSHIELD_DATA']['static_meta']['h1'];
			elseif(preg_match('#<h1[^>]*>(.*)<\/h1>#isU', $out_html, $h1_res))
				$data['h1'] = $h1_res[1];
			$data['data'] = $GLOBALS['SEOSHIELD_DATA']['init_api_generate_content'];

			$curl = curl_init();
			$curl_options = array(
				CURLOPT_URL => $api_url,
				CURLOPT_HEADER => FALSE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_POST => TRUE,
				CURLOPT_POSTFIELDS => array('data' => json_encode($data)),
				CURLOPT_TIMEOUT => 5,
			);
			
			curl_setopt_array($curl, $curl_options);
			$response = curl_exec($curl);
			$response = json_decode($response, true);
			if (sizeof($response) == 0)
				return $out_html;
			curl_close($curl);

			/*
			 *	кэшируем полученые текста в файлики
			 */
			$contents_res = $response['contents_res'];
			$debug_generate_content = false;
			if(isset($response['debug_generate_content']))
				$debug_generate_content = $response['debug_generate_content'];

			if($debug_generate_content == false)
			{
				if(!is_file($this->cache_file_path))
				{
					touch($this->cache_file_path);
					chmod($this->cache_file_path, 0777);
				}
				else
				{
					$cache_contents_res = require($this->cache_file_path);
					if(is_array($cache_contents_res) && sizeof($cache_contents_res) > 0)
						$contents_res += $cache_contents_res;
				}

				if(file_exists($this->cache_file_path) && is_writable($this->cache_file_path) && sizeof($contents_res) > 0)
					file_put_contents($this->cache_file_path, '<?php return ' . var_export($contents_res, true) . ';', LOCK_EX);
			}
		}

		if(sizeof($GLOBALS['SEOSHIELD_DATA']['api_generate_content']) > 0)
			$contents_res += $GLOBALS['SEOSHIELD_DATA']['api_generate_content'];

		/*
		 *	пробегаемся по комментариям-хэшам, вставляем текст
		 *	если есть только start'овый коммент
		 */
		foreach($contents_res as $content_hash => $content_data)
		{
			if(empty($content_data['text']) || (isset($GLOBALS['SEOSHIELD_DATA']['static_meta']['content']) && !empty($GLOBALS['SEOSHIELD_DATA']['static_meta']['content'])
					&& isset($content_data['hide_template']) && $content_data['hide_template'] == true))
				continue;

			$template_res = array('before' => '', 'after' => '');
			if(isset($GLOBALS['SEOSHIELD_DATA']['api_generate_content_options'][$content_hash]['template']))
				$template_res = $GLOBALS['SEOSHIELD_DATA']['api_generate_content_options'][$content_hash]['template'];
			$content_data['text'] = $template_res['before'] . $content_data['text'] . $template_res['after'];

			if(strpos($out_html, '<!--{ss_api_content_start:'.$content_hash.':ss_api_content_start}-->') !== false)
			{
				if(strpos($out_html, '<!--{ss_api_content_end:'.$content_hash.':ss_api_content_end}-->') !== false)
				{
					$out_html = preg_replace('#<!--{ss_api_content_start:'.$content_hash.':ss_api_content_start}-->(.*?)<!--{ss_api_content_end:'.$content_hash.':ss_api_content_end}-->#is', $content_data['text'], $out_html);
				}
				else
				{
					$out_html = str_replace('<!--{ss_api_content_start:'.$content_hash.':ss_api_content_start}-->', $content_data['text'], $out_html);
				}
			}
		}

		return $out_html;
	}
}