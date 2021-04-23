<?php
if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));


class SeoShieldModule_pages_adverts extends seoShieldModule
{
	/**
	 *	Модуль работы с pages adverts (объявлениями страниц)
	 *	может выводить как полные объявления (заголовок, контент, ключевое слово), так и только ключевые слова
	 *
	 *	for work:
	 * 		в pager'e сгенерировать pages adverts для продвигаемых (будет генериться только для тех страниц, у которых есть контент)
	 *		синхронизировать pages adverts в клиент (создастся файл pages_adverts.cache.php)
	 *		включть в modules.php
	 *		если надо, поменять конфиг $GLOBALS['SEOSHIELD_CONFIG']['pages_adverts_config'] в main.php
	 *
	 *	pager:
	 *		кнопка удаления "Cache" - удаляет форматированный и сгенеренный кэш
	 *		кнопка удаления "All" - удаляет форматированный, сгенеренный кэш и синхронизированные данные
	 *
	 *	config structure:
	 *		bool	debug			при дебаге производятся все действия кроме сохранений кэша и вывода на страницы
	 *		string	pages_adverts	коммент для замены advert'ов
	 *		string	pages_keywords	коммент для замены keyword'ов
	 *		bool	use_default_css	использование дефолтных стилей
	 *		string	add_css			строка может содержать доп стили, которые добавятся при выводе advert'a
	 *		string	before			строка перед блоком advert'a
	 *		string	after			строка после блоком advert'a
	 *		int		per_page		кол-во advert'ов на странице
	 *
	 *	cache structure:
	 *		- pages_adverts.cache.php - основной кэш с пейджера, содержит adverts и keywords по каждой продвигаемой
	 *		- pages_adverts_formatted.cache.php - форматированый кэш, создается при первом запуске или когда обновился pages_adverts.cache.php,
	 *		  содержит упорядоченную структуру для выбора advert'ов
	 *		- pages_adverts_config.php - внутренний конфиг модуля
	 *			+ pages_adverts_time	время модифиации pages_adverts.cache.php
	 *			+ adv_key				порядковый номер первого advert'a для генерации следующей пачки
	 *			+ adverts_count			кол-во advert'ов
	 *		- cache - папка с кэшом по каждой странице, где название файла - хэш урла страницы, имеет вложенную структуру
	 */

	protected $cache_files;

	function __construct()
	{
		$this->cache_files = array(
			'pages_adverts' => SEOSHIELD_ROOT_PATH . '/data/pages_adverts/pages_adverts.cache.php',
			'pages_adverts_f' => SEOSHIELD_ROOT_PATH . '/data/pages_adverts/pages_adverts_formatted.cache.php',
			'pages_adverts_config' => SEOSHIELD_ROOT_PATH . '/data/pages_adverts/pages_adverts_config.php',
		);
	}

	function check_cache_file($file_key)
	{
		$file_path = $this->cache_files[$file_key];
		$check_file = $this->check_file_exists($file_path);
		if(isset($check_file['error']))
			return false;
		
		$file_data = require($file_path);
		if(!is_array($file_data))
		{
			if($file_key == 'pages_adverts')
				$file_data = false;
			else
				$file_data = array();
		}
		return $file_data;
	}

	function html_out_buffer($out_html)
	{
		if(!isset($GLOBALS['SEOSHIELD_CONFIG']['pages_adverts_config']) || $_SERVER['REQUEST_METHOD'] !== 'GET')
			return $out_html;

		if(isset($GLOBALS['SEOSHIELD_CONFIG']['pages_adverts_config']['hide_if_page_content']) 
			&& $GLOBALS['SEOSHIELD_CONFIG']['pages_adverts_config']['hide_if_page_content'] === true
			&& isset($GLOBALS['SEOSHIELD_DATA']['static_meta_replace']['content'])
			&& $GLOBALS['SEOSHIELD_DATA']['static_meta_replace']['content'] === true
			&& isset($GLOBALS['SEOSHIELD_CONFIG']['is_static_page']) && $GLOBALS['SEOSHIELD_CONFIG']['is_static_page'] !== true)
		{
			return $out_html;
		}

		$config = $GLOBALS['SEOSHIELD_CONFIG']['pages_adverts_config'];
		$config['per_page'] = isset($config['per_page']) ? $config['per_page'] : 6;
		$config['debug'] = isset($config['debug']) ? $config['debug'] : false;
		$config['use_default_css'] = isset($config['use_default_css']) ? $config['use_default_css'] : false;
		$config['use_relative_url'] = isset($config['use_relative_url']) ? $config['use_relative_url'] : false;

		$config['replace'] = false;
		if(strpos($out_html, $config['pages_adverts']) !== false)
			$config['replace'] = 'pages_adverts';
		elseif(strpos($out_html, $config['pages_keywords']) !== false)
			$config['replace'] = 'pages_keywords';

		if($config['replace'] === false && $config['debug'] !== true)
			return $out_html;

		$a = array();
		$cache = array();
		$protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
		$page_url = $protocol . ':' . $GLOBALS['SEOSHIELD_CONFIG']['page_url'];
		$page_hash = $GLOBALS['SEOSHIELD_CONFIG']['page_hash_alt'];
		$this->cache_files['page_cache'] = SEOSHIELD_ROOT_PATH . '/data/pages_adverts/cache'.$this->get_path_from_hash($page_hash);

		$cache['pages_adverts_config'] = $this->check_cache_file('pages_adverts_config');
		if(!isset($cache['pages_adverts_config']['pages_adverts_time']))
			$cache['pages_adverts_config']['pages_adverts_time'] = 0;
		if(!isset($cache['pages_adverts_config']['adv_key']))
			$cache['pages_adverts_config']['adv_key'] = 0;
		if(!isset($cache['pages_adverts_config']['adverts_count']))
			$cache['pages_adverts_config']['adverts_count'] = 0;

		if(!file_exists($this->cache_files['page_cache']) || $config['debug'])
		{
			$cache['pages_adverts_all'] = $this->check_cache_file('pages_adverts');
			if($cache['pages_adverts_all'] == false || sizeof($cache['pages_adverts_all']) == 0)
				return $out_html;

			$cache['pages_adverts_config']['adverts_count'] = sizeof($cache['pages_adverts_all']);
			$cache['pages_adverts_time'] = filemtime($this->cache_files['pages_adverts']);
			
			$cache['pages_adverts_f'] = $this->check_cache_file('pages_adverts_f');

			if(!is_array($cache['pages_adverts_f']['adverts']) || sizeof($cache['pages_adverts_f']['adverts']) == 0 
				|| $cache['pages_adverts_time'] > $cache['pages_adverts_config']['pages_adverts_time'])
			{
				$cache['pages_adverts'] = array();
				$cache['pages_keywords'] = array();
				foreach($cache['pages_adverts_all'] as $p_url => $p_res)
				{
					if(isset($p_res['adverts']) && sizeof($p_res['adverts']) > 0)
						$cache['pages_adverts'][$p_url] = $p_res['adverts'];
					if(isset($p_res['keywords']) && sizeof($p_res['keywords']) > 0)
						$cache['pages_keywords'][$p_url] = $p_res['keywords'];
				}

				$cache['pages_adverts_f'] = array();
				$cache['pages_adverts_f']['adverts'] = array();
				$cache['pages_adverts_f']['keywords'] = $cache['pages_keywords'];
				$cache['pages_adverts_copy'] = $cache['pages_adverts'];
				do {
					$tmp_urls = array();
					$tmp_adverts = array();
					foreach($cache['pages_adverts_copy'] as $adv_url => $advs_res)
					{
						$key = key($advs_res);
						$advs_res[$key]['url'] = $adv_url;

						$tmp_urls[] = $adv_url;
						$tmp_adverts[] = $advs_res[$key];
						
						unset($cache['pages_adverts_copy'][$adv_url][$key]);
						if(sizeof($cache['pages_adverts_copy'][$adv_url]) == 0)
							unset($cache['pages_adverts_copy'][$adv_url]);
						
						continue;
					}

					if(sizeof($tmp_adverts) < $config['per_page'])
					{
						$tmp_urls = array_diff(array_keys($cache['pages_adverts']), $tmp_urls);

						$available_urls = sizeof($tmp_adverts) + sizeof($tmp_urls);
						if($available_urls >= $config['per_page'])
						{
							do {
								$tmp_url_key = array_rand($tmp_urls);
								$tmp_url = $tmp_urls[$tmp_url_key];

								$key = array_rand($cache['pages_adverts'][$tmp_url]);
								$adv_res = $cache['pages_adverts'][$tmp_url][$key];
								$adv_res['url'] = $tmp_url;

								$tmp_adverts[] = $adv_res;
								unset($tmp_urls[$tmp_url_key]);
							} while(sizeof($tmp_adverts) !== $config['per_page']);
						}
						else
							$tmp_adverts = array();
					}

					$cache['pages_adverts_f']['adverts'] = array_merge($cache['pages_adverts_f']['adverts'], $tmp_adverts);
				} while(sizeof($cache['pages_adverts_copy']) > 0);

				if(!$config['debug'])
					file_put_contents($this->cache_files['pages_adverts_f'], '<?php return '.var_export($cache['pages_adverts_f'], true).';', LOCK_EX);
			}

			$cache['page_cache'] = array();
			if($config['replace'] == 'pages_adverts' && sizeof($cache['pages_adverts_f']['adverts']) > 0)
			{
				$adv_key = $cache['pages_adverts_config']['adv_key'];

				do {
					if(!isset($cache['pages_adverts_f']['adverts'][$adv_key]))
						$adv_key = 0;

					$adv_res = $cache['pages_adverts_f']['adverts'][$adv_key];
					if($adv_res['url'] !== $page_url && $adv_res['url'] !== $GLOBALS['SEOSHIELD_CONFIG']['page_url'])
					{
						if(isset($cache['pages_adverts_f']['keywords'][$adv_res['url']]))
						{
							$adv_keywords = $cache['pages_adverts_f']['keywords'][$adv_res['url']];
							$adv_res['keyword'] = $adv_keywords[array_rand($adv_keywords)];
						}

						if($config['use_relative_url'])
							$adv_res['url'] = str_replace('//' . $_SERVER['HTTP_HOST'], '', $adv_res['url']);

						$cache['page_cache'][] = $adv_res;
					}

					$adv_key++;
					$cache['pages_adverts_config']['adv_key'] = $adv_key;
				} while(sizeof($cache['page_cache']) < $config['per_page']);
			}
			elseif($config['replace'] == 'pages_keywords' && sizeof($cache['pages_adverts_f']['keywords']) > 0)
			{
				do {
					$kw_key = array_rand($cache['pages_adverts_f']['keywords']);

					if($kw_key == $page_url && $kw_key == $GLOBALS['SEOSHIELD_CONFIG']['page_url'])
					{
						unset($cache['pages_adverts_f']['keywords'][$kw_key]);
						continue;
					}

					$adv_res = array(
						'url' => $kw_key,
					);

					$adv_keywords = $cache['pages_adverts_f']['keywords'][$adv_res['url']];
					$adv_res['keyword'] = $adv_keywords[array_rand($adv_keywords)];

					if($config['use_relative_url'])
						$adv_res['url'] = str_replace('//' . $_SERVER['HTTP_HOST'], '', $adv_res['url']);

					$cache['page_cache'][] = $adv_res;
					unset($cache['pages_adverts_f']['keywords'][$kw_key]);
				} while(sizeof($cache['page_cache']) < $config['per_page']);
			}

			if(!$config['debug'])
			{
				$this->check_cache_file('page_cache');
				file_put_contents($this->cache_files['page_cache'], '<?php return '.var_export($cache['page_cache'], true).';', LOCK_EX);
			}

			$cache['pages_adverts_config']['pages_adverts_time'] = $cache['pages_adverts_time'];
			if(!$config['debug'])
				file_put_contents($this->cache_files['pages_adverts_config'], '<?php return '.var_export($cache['pages_adverts_config'], true).';', LOCK_EX);
		}

		if(file_exists($this->cache_files['page_cache']) || $config['debug'])
		{
			if(!$config['debug'])
				$cache['page_cache'] = $this->check_cache_file('page_cache');

			if(isset($cache['page_cache']) && sizeof($cache['page_cache']) > 0)
			{
				$page_adverts_txt = '<div class="seoshield_page_adverts"><ul>';
				foreach($cache['page_cache'] as $adv_res)
				{
					if($config['replace'] == 'pages_keywords' && !isset($adv_res['keyword']))
						continue;

					$page_adverts_txt .= '<li>';
					if($config['replace'] == 'pages_adverts')
					{
						$page_adverts_txt .= '<p><a href="'.$adv_res['url'].'">'.$adv_res['title'].'</a></p>';
						$page_adverts_txt .= '<p>'.$adv_res['content'].'</p>';
					}

					if(isset($adv_res['keyword']))
						$page_adverts_txt .= '<p class="ss_pa_keyword"><a href="'.$adv_res['url'].'">'.$adv_res['keyword'].'</a></p>';

					$page_adverts_txt .= '</li>';
				}
				$page_adverts_txt .= '</ul></div>';

				$page_adverts_css = '';
				if($config['use_default_css'])
					$page_adverts_css .= $this->get_default_css();
				if(isset($config['add_css']) && gettype($config['add_css']) == 'string')
					$page_adverts_css .= $config['add_css'];
				if(!empty($page_adverts_css))
					$page_adverts_txt .= '<style>'.$page_adverts_css.'</style>';

				if(isset($config['before']))
					$page_adverts_txt = $config['before'] . $page_adverts_txt;
				if(isset($config['after']))
					$page_adverts_txt = $page_adverts_txt . $config['after'];

				if($config['replace'] !== false)
					$out_html = str_replace($config[$config['replace']], $page_adverts_txt, $out_html);
			}
		}

		return $out_html;
	}

	function get_default_css()
	{
		return '.seoshield_page_adverts {width: 100%;padding: 20px;border: 1px solid #BFBFBF;margin-top: 20px;}.seoshield_page_adverts p {display: block;}.seoshield_page_adverts p:not(:last-child) {padding-bottom: 5px;}.seoshield_page_adverts li {display: block;width: 100%;}.seoshield_page_adverts li:not(:last-child) {margin-bottom: 10px;padding-bottom: 10px;border-bottom: 1px solid #BFBFBF;}.ss_pa_keyword * {font-size: 90%;line-height:90%;}';
	}
}