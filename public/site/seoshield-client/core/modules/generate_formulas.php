<?php
/*
* модуль формул генерации

	Инструкция ---> 
		Для определения языковой версии сайта разметьте комментарий типа <!--seoshield--version--site--язык-->
		Для определения типа страница разметьте комментарий типа <!--seoshield_formulas--тип страницы-->/s
*/

if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_generate_formulas extends seoShieldModule
{
	function html_out_buffer($out_html)
	{
		$out_html = $this->setup_variables($out_html);
		
		$uri_main = $_SERVER['REQUEST_URI'];

		// проверка недопустимых параметров
		if(isset($GLOBALS['SEOSHIELD_CONFIG']['unacceptable_parameters']) && !empty($GLOBALS['SEOSHIELD_CONFIG']['unacceptable_parameters'])) {
			foreach ($GLOBALS['SEOSHIELD_CONFIG']['unacceptable_parameters'] as $parameter => $noindex_nofollow) {
				if(strpos($uri_main, $parameter) == true) {
					if($noindex_nofollow == 'noindex_nofollow') {
						$out_html = str_replace("<head>", "<head>\n<meta name='robots' content='noindex, nofollow'/>", $out_html);
					}
					return $out_html;
				}
			}
		}

		// Формулы не распространяются 404 страницы
		if(function_exists("http_response_code")) {
			$status = http_response_code();
			if(isset($status) && $status != '200')
				return $out_html;
		}

		$h1_main    = '';
		$title_main = '';
		$desc_main  = '';

		$is_static_page = false;
		$access_variables = array();

		$static_data = $this->get_static_meta(true);
		$current_url = isset($GLOBALS['SEOSHIELD_CONFIG']['page_url']) ? 
				$GLOBALS['SEOSHIELD_CONFIG']['page_url'] : (isset($GLOBALS['SEOSHIELD_CONFIG']['page_uri']) ? 
				$GLOBALS['SEOSHIELD_CONFIG']['page_uri'] : null);

			if (!is_null($current_url)  && isset($static_data[$current_url]))
				$is_static_page = true;

		if(file_exists(SEOSHIELD_ROOT_PATH . '/data/formulas_meta.cache.php'))
		{
			$formulas  = include(SEOSHIELD_ROOT_PATH . '/data/formulas_meta.cache.php');
			if(is_array($formulas))
			{
				$variables = array();
				if(file_exists(SEOSHIELD_ROOT_PATH . '/data/type_pages_formulas.cache.php')) {
					$tmp = include(SEOSHIELD_ROOT_PATH . '/data/type_pages_formulas.cache.php');
					if(is_array($tmp))
					{
						if(array_key_exists('variables', $tmp))
							$variables = $tmp['variables'];

						// Заполнение массива реальными переменными
						foreach ($variables as $name => $name_cyr) {
							$funct_name = str_replace(array('{','}'), '', $name);
							if(method_exists($this, $funct_name.'_formulas_generation')){
							  $value = $this->{$funct_name.'_formulas_generation'}($out_html);
								$access_variables[$name] = $value;
							}
						}
					}
				}

				if(isset($formulas) && !empty($formulas))
				{
					if(substr($uri_main, strlen($uri_main)-1) == "/") $uri_main = substr($uri_main,0,strlen($uri_main)-1);

					$url_exec = array();
					if(array_key_exists('url_exec', $formulas))
						$url_exec = $formulas['url_exec'];

					$url_priority = array();
					if(array_key_exists('url_access', $formulas))
						$url_priority = $formulas['url_access'];

					$valid_url = true;
					foreach ($url_exec as $url_n) {
						if(strpos($url_n, '*') !== false) {
							$url_n = str_replace('/', '\/', $url_n);
							$url_n = str_replace('*', '[^\s]*', $url_n);
							if(preg_match('/'.$url_n.'/s', $uri_main)) {
								$valid_url = false;
							}
						}else {
							if($uri_main == $url_n) {
								$valid_url = false;
							}
						}
					}

					if($valid_url)
					{
						foreach ($formulas as $lang => $data) {
							preg_match('/<!--seoshield--version--site--'.$lang.'-->/s', $out_html, $check_lang);
							if(isset($check_lang[0]))
							{
								foreach ($data as $type_page => $ex_formulas)
								{
									// замена переменных на реальный текста
									foreach ($access_variables as $tag => $cyrilic) {
										foreach ($ex_formulas as $tag1 => $text) {
											if(strpos($text, $tag) !== false) {
												$text = str_replace($tag, $cyrilic, $text);
												$ex_formulas[$tag1] = $text;
											}
										}
									}

									// общая формула
									if($type_page == 'core')
									{
										$h1_main    = $ex_formulas['h1'];
										$title_main = $ex_formulas['title'];
										$desc_main  = $ex_formulas['description'];
									}
									else
									{
										preg_match('/<!--seoshield_formulas--'.$type_page.'-->/s', $out_html, $check_type_page);
										if(isset($check_type_page[0]))
										{
											// если продвигаемая страница
											if($is_static_page)
											{
												if(!empty($ex_formulas['h1_landing']))
													$h1_main = $ex_formulas['h1_landing'];
												else
													$h1_main = $ex_formulas['h1'];

												if(!empty($ex_formulas['title_landing']))
													$title_main = $ex_formulas['title_landing'];
												else
													$title_main = $ex_formulas['title'];

												if(!empty($ex_formulas['description_landing']))
													$desc_main = $ex_formulas['description_landing'];
												else
													$desc_main = $ex_formulas['description'];
											}
											else
											{
												$h1_main    = $ex_formulas['h1'];
												$title_main = $ex_formulas['title'];
												$desc_main  = $ex_formulas['description'];
											}		
										}
									}
									if(!empty($h1_main))
										$out_html=$this->replace_page_h1($out_html, $h1_main);
									if(!empty($title_main))
										$out_html=$this->replace_page_title($out_html, $title_main);
									if(!empty($desc_main))
										$out_html=$this->replace_page_meta_description($out_html, $desc_main);
								}
							}
						}

						// высокий приоритет для URL
						if(!empty($url_priority))
						{
							$url_priority = array();
							if(array_key_exists('url_access', $formulas)) {
								foreach ($formulas['url_access'] as $index => $data) {
									// подмена переменных
									foreach ($access_variables as $tag => $cyrilic) {
										foreach ($data['meta_tags'] as $tag1 => $text) {
											if(strpos($text, $tag) !== false) {
												$text = str_replace($tag, $cyrilic, $text);
												$data['meta_tags'][$tag1] = $text;
											}
										}
									}

									$check = false;
									foreach ($data as $type => $next_url)
									{
										if($type != 'meta_tags')
										{
											if(substr($next_url, strlen($next_url)-1) == "/") $next_url = substr($next_url,0,strlen($next_url)-1);

											// идентичный урл
											if($next_url == $uri_main) {	
												$h1_main    = $data['meta_tags']['h1'];
												$title_main = $data['meta_tags']['title'];
												$desc_main  = $data['meta_tags']['desc'];
												$check = true;
												break(2);
											}
											// формула по регулярке
											elseif(strpos($next_url, "*") !== false)
											{
												$next_url = str_replace('/', '\/', $next_url);
												$next_url = str_replace('*', '[^\s]*', $next_url);
												if(preg_match('/'.$next_url.'/s', $uri_main))
												{
													$h1_main    = $data['meta_tags']['h1'];
													$title_main = $data['meta_tags']['title'];
													$desc_main  = $data['meta_tags']['desc'];
												}
											}
										}
									}
								}	
							}
						}

						// Финальная замена мета-тегов
						if(!empty($h1_main))
							$out_html=$this->replace_page_h1($out_html, $h1_main);
						if(!empty($title_main))
							$out_html=$this->replace_page_title($out_html, $title_main);
						if(!empty($desc_main))
							$out_html=$this->replace_page_meta_description($out_html, $desc_main);
					}
				}
			}
		}
		return $out_html;
	}

	public function setup_variables($out_html){
		return $out_html;
	}
}