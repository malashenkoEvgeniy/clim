<?php
/*
 *	модуль подтверждения аналитики/метрики
 */
if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_seo_markup extends seoShieldModule
{
	function html_out_buffer($out_html)
	{
	    $initial_facebook_url = '';
	    $initial_project_title = '';
	    
	    if (isset($GLOBALS['SEOSHIELD_CONFIG']['seo_markup'])){
	        if (isset($GLOBALS['SEOSHIELD_CONFIG']['seo_markup']['facebook_url'])){
	            $initial_facebook_url = $GLOBALS['SEOSHIELD_CONFIG']['seo_markup']['facebook_url'];
	        }
	        if (isset($GLOBALS['SEOSHIELD_CONFIG']['seo_markup']['project_title'])){
	            $initial_project_title = $GLOBALS['SEOSHIELD_CONFIG']['seo_markup']['project_title'];
	        }
	    }
	    
		$page_components = array(
			'h1' => '',
			'description' => '',
			'image' => '',
			'url' => $GLOBALS['SEOSHIELD_CONFIG']['page_url'],
			'facebook' => $initial_facebook_url,
			'project' => $initial_project_title
		);

		$markup_content = '
		<meta property="og:type" content="website" />
		<meta property="og:title" content="{h1}"/>
		<meta property="og:url" content="{url}"/>
		<meta property="og:description" content="{description}" />
		<meta property="article:author" content="{facebook}" />
		<meta property="og:image" content="{image}" />
		<meta property="og:publisher" content="{facebook}" />
		<meta property="og:site_name" content="{project}" />';

		if (isset($GLOBALS['SEOSHIELD_CONFIG']['seo_markup']['content_product_page']) && isset($GLOBALS['SEOSHIELD_CONFIG']['seo_markup']['content_listing_page'])) {
			if ($GLOBALS['SEOSHIELD_CONFIG']['seo_markup']['content_product_page']!=='' && $GLOBALS['SEOSHIELD_CONFIG']['seo_markup']['content_listing_page']!=='') {
				if (strpos($out_html, $GLOBALS['SEOSHIELD_CONFIG']['seo_markup']['content_product_page'])!==false || strpos($out_html, $GLOBALS['SEOSHIELD_CONFIG']['seo_markup']['content_listing_page'])!==false) {
					if (preg_match('#<h1[^>]*?>(.*?)</h1>#s', $out_html, $page_h1)==1) {
						$page_components['h1'] = $page_h1[1];
					}
					if (preg_match('#<meta[^>]*?description[^>]*?content=["\'](.*?)["\'][^>]*?>#s', $out_html, $page_description)==1) {
						$page_components['description'] = $page_description[1];
					}

					if (preg_match($GLOBALS['SEOSHIELD_CONFIG']['seo_markup']['content_markup_img'], $out_html, $page_image)==1) {
						$page_components['image'] = $page_image[1];
					}
				}
				foreach ($page_components as $k => $v) {
					if (!empty($v)) {
						$markup_content = str_replace('{'.$k.'}', $v, $markup_content);
					}
					else {
						$out_html = str_replace('</body>', '<!--seo_shield_warning_empty_markup_components['.$k.']--></body>', $out_html);
						return $out_html;
					}
				}
				$out_html = str_replace('</head>', $markup_content.'</head>', $out_html);
			}
		}
		return $out_html;
	}
}