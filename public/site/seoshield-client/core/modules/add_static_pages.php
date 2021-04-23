<?php
/*
 *	создание статических страниц
 */
if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_add_static_pages extends seoShieldModule
{
	protected $cache_file_path = '';

	function start_cms()
	{
		if(file_exists(SEOSHIELD_ROOT_PATH . '/data/static_meta.cache.php') && file_exists(SEOSHIELD_ROOT_PATH . '/data/templates.cache.php'))
		{
			$static_data = $this->get_static_meta(true);
			$current_url = isset($GLOBALS['SEOSHIELD_CONFIG']['page_url']) ? 
				$GLOBALS['SEOSHIELD_CONFIG']['page_url'] : (isset($GLOBALS['SEOSHIELD_CONFIG']['page_uri']) ? 
				$GLOBALS['SEOSHIELD_CONFIG']['page_uri'] : null);
			if (!is_null($current_url) 
				&& isset($static_data[$current_url]) 
				&& isset($static_data[$current_url]['type'])
				&& (
					$static_data[$current_url]['type'] == 'static_page' || 
					$static_data[$current_url]['type'] == 'static_category' 
					)
				){
				$templates_data = $this->get_templates();
				$current_data = $static_data[$current_url];
				$content = $templates_data[$current_data['template']];
				if (!is_null($content)){
					$GLOBALS['SEOSHIELD_CONFIG']['is_static_page'] = true;
					$content_res = base64_decode($content);
					$out = ob_end_clean();
					$old_selector = $GLOBALS["SEOSHIELD_CONFIG"]["content_area_selector"];
					$GLOBALS['SEOSHIELD_CONFIG']['content_area_selector'] = array();
					$GLOBALS['SEOSHIELD_CONFIG']['content_area_selector'][] = array(
						'type' => 'regex',
						'pattern' => '#<!--seoshield_static_page_content-->.*?<!--/seoshield_static_page_content-->#isu',
					);
					$static_meta_module = new \SeoShieldModule_static_meta;
					$content = $static_meta_module->html_out_buffer($content_res);

					# h1 fix
					if(strpos($content, '</h1>') === false)
					{
						$content_res = str_replace('<!--seoshield_static_page_content-->', '<h1></h1><!--seoshield_static_page_content-->', $content_res);
						$content = $static_meta_module->html_out_buffer($content_res);
					}
                    if (class_exists("SeoShieldModule_pages_adverts")){
					    $pa_module = new \SeoShieldModule_pages_adverts;
					    $content = $pa_module->html_out_buffer($content);
                    }
					$GLOBALS['SEOSHIELD_CONFIG']['content_area_selector'] = $old_selector;
					if ($current_data['type'] == 'static_category' && isset($current_data['category']['_id'])){
						$subcategories = array();
						$child_pages = array();
						foreach ($static_data as $url => $data) {
							if (substr($url, 0, 2) != '//') continue;
							if (isset($data['type'])){
								if (
									isset($data['category']) && (
										$data['category']['parent'] == $current_data['category']['_id']
										|| in_array($current_data['category']['_id'], $data['category']['ancestors'])
										|| ($current_data['category']['_id'] == $data['category']['_id'] && $url != $current_url)
									))
								{
									if ($data['type'] == 'static_category'){
										$subcategories[] = '<a href="'.$url.'">'.$data[2].'</a>';
									} elseif ($data['type'] == 'static_page'){
										$child_pages[] = '<a href="'.$url.'">'.$data[2].'</a>';
									}
								}
							}
						}
						$subcategories = implode('<br/>', $subcategories);
						$child_pages = implode('<br/>', $child_pages);

						$content = preg_replace('#<!--seoshield_listing_items-->(.*?)<!--/seoshield_listing_items-->#isu', $child_pages, $content);
						$content = preg_replace('#<!--seoshield_subcategory_listing_items-->(.*?)<!--/seoshield_subcategory_listing_items-->#isu', $subcategories, $content);
						$content = preg_replace('#<!--seoshield_static_page_content-->.*?<!--/seoshield_static_page_content-->#isu', '', $content);
					}
					echo $content;
					exit();
				}
			}
		}
	}
}
