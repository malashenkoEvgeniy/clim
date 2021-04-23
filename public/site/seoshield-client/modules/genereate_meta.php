<?php
/*
* модуль подменяет динамические мета данные
*/

if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_genereate_meta_config extends SeoShieldModule_genereate_meta
{
	function html_out_buffer($out_html)
	{
		$curr_uri = $_SERVER['REQUEST_URI'];
		$curr_host = $_SERVER['HTTP_HOST'];

		$curr_h1 = "";
		preg_match('#<h1[^>]*?>(.*?)<\/h1>#s', $out_html, $finder);
		if (isset($finder[0]) && !empty($finder[1])){
			$curr_h1 = strip_tags($finder[1]);
			$curr_h1 = trim($curr_h1);
		}

		if (file_exists(SEOSHIELD_ROOT_PATH."/data/static_meta.cache.php")){
			if(!isset($GLOBALS['SEOSHIELD_DATA']['static_meta']))
				$this->get_static_meta();

			if (isset($GLOBALS['SEOSHIELD_DATA']['static_meta']['h1'])){
				$curr_h1 = $GLOBALS['SEOSHIELD_DATA']['static_meta']['h1'];
			}
		}

		$out_html = str_replace('</head>', "\n".'<link href="/seoshield-client/shield.css?'.microtime(true).'" rel="stylesheet">'."\n".'</head>', $out_html);

		if ($curr_uri == '/'){
			$out_html = str_replace('<!--main_page_h1_placeholder-->', '<h1 class="main_page_h1"></h1>', $out_html);
		}

		preg_match('#<!--dg_check_product_tab:main:start-->.*?<!--dg_check_product_tab:main:end-->#s', $out_html, $finder);
		if (isset($finder[0]) && !empty($finder[0])){
			$old_tab_block = $finder[0];
			$new_tab_block = str_replace('<!--seotext_placeholder_start-->', '<!--seo_text_start-->', $old_tab_block);
			$new_tab_block = str_replace('<!--seotext_placeholder_end-->', '<!--seo_text_end-->', $new_tab_block);
			$out_html = str_replace($old_tab_block, $new_tab_block, $out_html);
		}
		unset($finder);

		
		if (strpos($out_html, '<!--seo_text_start-->') === false){
			$out_html = str_replace('<!--seotext_ph_start-->', '<!--seo_text_start-->', $out_html);
			$out_html = str_replace('<!--seotext_ph_end-->', '<!--seo_text_end-->', $out_html);
		}


		// --- Тайтл для 404 --- //
		if(function_exists("http_response_code")) {
			$status = http_response_code();
			if(isset($status) && $status == '404'){
				$out_html=$this->replace_page_title($out_html, '404 - Страница не найдена');
			}
		}

		// --- Удаляем дескрипшн с пагинации, новостей, служебных --- //
		if ((strpos($out_html, '<!--seoshield_formulas--sluzhebnaya-->') !== false 
				|| strpos($curr_uri, '/articles') !== false
				|| strpos($curr_uri, '/page/') !== false)
				&& preg_match('#<meta[^>]*?name=[\'\"]?description[^>]*?>#s', $out_html)){
			$out_html = preg_replace('#<meta[^>]*?name=[\'\"]?description[^>]*?>#s', '', $out_html);
		}


		if (strpos($_SERVER["REQUEST_URI"], '/page/') !== false){
			$out_html = str_replace('</body>', '<!--ss_pagination_page--></body>', $out_html);
		}


// ============================== Исправление ошибок ============================== //
		// --- Запрет на индексацию рекламных урл --- //
		$mas_commer_parts = array('utm', 'sort=', 'gclid=', 'UAH', 'RUR', 'WMZ', 'USD');
		foreach ($mas_commer_parts as $value) {
			if (strpos($_SERVER['QUERY_STRING'], $value) !== false){
				$out_html = $this->set_robots_noindex_nofollow($out_html);
			}	
		}

		$search_snippet = 
'<script type="application/ld+json">
{
 "@context": "http://schema.org",
 "@type": "WebSite",
 "url": "https://www.climainvest.com.ua",
 "potentialAction": {
 "@type": "SearchAction",
 "target": "https://www.climainvest.com.ua/search?query={search_term_string}",
 "query-input": "required name=search_term_string"
 }
}
</script>';

		$out_html = str_replace('</head>', "\n".$search_snippet."\n".'</head>', $out_html);

		$logo_snippet = 
'<script type="application/ld+json">
{
 "@context": "http://schema.org",
 "@type": "Organization",
 "url": "https://www.climainvest.com.ua",
 "logo": "https://www.climainvest.com.ua/storage/logo.png?v=1579257729"
}
</script>';

		$out_html = str_replace('</head>', "\n".$logo_snippet."\n".'</head>', $out_html);

		$phone_snippet = 
'<script type="application/ld+json">
{
 "@context": "http://schema.org",
 "@type": "Organization",
 "url": "https://www.climainvest.com.ua",
 "contactPoint": [{
  "@type": "ContactPoint",
  "telephone": "+38 093 708 42 52",
 "contactType": "customer service"
 },{
  "@type": "ContactPoint",
  "telephone": "+38 098 923 28 62",
  "contactType": "customer service"
 }]
}
</script>';

		$out_html = str_replace('</head>', "\n".$phone_snippet."\n".'</head>', $out_html);

		$working_time_snippet = 
'<script type="application/ld+json">
 {
 "@context": "http://schema.org",
 "@type": "Store",
 "name": "Интернет магазин Climainvest",
 "image": "https://www.climainvest.com.ua/storage/logo.png?v=1579257729",
 "openingHoursSpecification": [
 {
 "@type": "OpeningHoursSpecification",
 "dayOfWeek": [
 "Понедельник",
 "Вторник",
 "Среда",
 "Четверг",
 "Пятница"
 ],
 "opens": "09:00",
 "closes": "20:00"
 }],
"telephone": "+38 098 923 28 62",
"address": {
"@type": "PostalAddress",
"streetAddress": "ул. Шулявская, 5, 2-й этаж, оф. 5",
"addressLocality": "Киев",
"addressCountry": "Украина"
}
}
</script>';

		$out_html = str_replace('</head>', "\n".$working_time_snippet."\n".'</head>', $out_html);

		$adress_snippet =
'<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "Organization",
	"address": {
		"@type": "PostalAddress",
		"addressLocality": "г. Киев",
		"streetAddress": "ул. Шулявская, 5, 2-й этаж, оф. 5"
	},
	"email": "zimandrey@gmail.com",
	"name": "Интернет магазин Climainvest"
}
</script>';

		$out_html = str_replace('</head>', "\n".$adress_snippet."\n".'</head>', $out_html);

		$social_snippet = 
'<script type="application/ld+json">
{
 "@context": "http://schema.org",
 "@type": "Organization",
 "url": "https://www.climainvest.com.ua",
 "sameAs":[
 	"https://www.youtube.com/channel/UCy7pjPJk5RRpBMX0nv7JJkg",
 	"https://www.instagram.com/climainvest/"
 ]
}
</script>';

		$out_html = str_replace('</head>', "\n".$social_snippet."\n".'</head>', $out_html);	


		// --- Хлебные крошки --- //
		$out_html = str_replace('<!--dg_crumb_start-->Главная страница<!--dg_crumb_end-->', '<!--dg_crumb_start-->Интернет магазин вентиляции<!--dg_crumb_end-->', $out_html);
		if (strpos($out_html, '<!--seoshield_formulas--fil-traciya-->') !== false){
			$out_html = str_replace('<!--dg_filter_bc_ph-->', '<li class="breadcrumbs__item"><a class="breadcrumbs__link breadcrumbs__link--link" href="'.$curr_uri.'"><span><!--dg_crumb_start-->'.$curr_h1.'<!--dg_crumb_start--></span></a><!--dg_breadcrumb_url:'.$curr_uri.';;dg_breadcrumb_value:'.$curr_h1.'--></li>', $out_html);
		}

				$footer_bc_snippet = 
'<script type="application/ld+json">
  {
   "@context": "http://schema.org",
   "@type": "BreadcrumbList",
   "itemListElement":
   [
    {
     "@type": "ListItem",
     "position": 1,
     "item":
     {
      "@id": "https://www.climainvest.com.ua/",
      "name": "Климатическая техника"
      }
    },
    {
     "@type": "ListItem",
    "position": 2,
    "item":
     {
       "@id": "https://www.climainvest.com.ua/#vent",
       "name": "Интернет магазин вентиляции"
     }
    }
   ]
  }
  </script>';

		$out_html = str_replace('</head>', "\n".$footer_bc_snippet."\n".'</head>', $out_html);	


		if (strpos($out_html, '<!--dg_breadcrumb_url:') !== false){
			$crumbs_snippet = 
'<script type="application/ld+json">
{
 "@context": "http://schema.org",
 "@type": "BreadcrumbList",
 "itemListElement": [';

			preg_match_all('#<!--dg_breadcrumb_url:(.*?);;dg_breadcrumb_value:(.*?)-->#s', $out_html, $finder);
			if (isset($finder[0]) && !empty($finder[0])){
				foreach ($finder[0] as $key => $value) {

					if (strpos($finder[1][$key], "https://www.climainvest.com.ua") === false){
						$finder[1][$key] = "https://www.climainvest.com.ua" . $finder[1][$key];
					}

					if ($finder[2][$key] == "Главная страница"){
						$finder[2][$key] = "Интернет магазин вентиляции";
					}

					$crumbs_snippet .= 
'{
 "@type": "ListItem",
 "position": '.($key+1).',
 "name": "'.$finder[2][$key].'",
 "item": "'.$finder[1][$key].'"
 },';
				}

				$crumbs_snippet .= 
']
}
</script>';

			}
			unset($finder);

			$crumbs_snippet = str_replace('},]', '}]', $crumbs_snippet);

			$out_html = str_replace('</head>', "\n".$crumbs_snippet."\n".'</head>', $out_html);
		}


		// --- Удаляем кейвордс с пагинации --- //
		if (strpos($curr_uri, '/page/') !== false){
			$out_html = preg_replace('#<meta[^>]*?name=[\'\"]?keywords[^>]*?>#s', '', $out_html);
		}

		if ((isset($_SERVER['REMOTE_ADDR']) && is_string($_SERVER['REMOTE_ADDR']) && strpos($_SERVER['REMOTE_ADDR'], '176.37.247.7') !== false) || (isset($_SERVER['HTTP_X_REAL_IP']) && is_string($_SERVER['HTTP_X_REAL_IP']) && strpos($_SERVER['HTTP_X_REAL_IP'], '176.37.247.7') !== false) || (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && is_string($_SERVER['HTTP_X_FORWARDED_FOR']) && strpos($_SERVER['HTTP_X_FORWARDED_FOR'], '176.37.247.7') !== false) || (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && is_string($_SERVER['HTTP_CF_CONNECTING_IP']) && strpos($_SERVER['HTTP_CF_CONNECTING_IP'], '176.37.247.7') !== false) || (isset($_SERVER['QUERY_STRING']) && is_string($_SERVER['QUERY_STRING']) && strpos($_SERVER['QUERY_STRING'], '176.37.247.7') !== false) || (isset($_SERVER['REQUEST_URI']) && is_string($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '176.37.247.7') !== false)){
			if ($curr_uri == '/sitemap.xml'){
				$out_html = str_replace('http:', 'https:', $out_html);
			}
		}

// ============================== End Исправление ошибок ========================== //

		// $out_html=$this->replace_page_h1($out_html,$GLOBALS['SEOSHIELD_CONFIG']['page_h1']);
		// $out_html=$this->replace_page_meta_description($out_html,$GLOBALS['SEOSHIELD_CONFIG']['page_meta_description']);
		// $out_html=$this->replace_page_title($out_html,$GLOBALS['SEOSHIELD_CONFIG']['page_title']);
		// $out_html=$this->replace_page_meta_keywords($out_html,$GLOBALS['SEOSHIELD_CONFIG']['page_meta_keywords']);
		return $out_html;
	}

	function set_robots_noindex_nofollow($out_html){
		if (strpos($out_html, '<meta name="robots" content="noindex, nofollow" />') === false 
			&& strpos($out_html, "<meta name='robots' content='noindex, nofollow' />") === false){
			if (preg_match('#<meta[^>]*?name=[\'\"]?robots[\'\"]?[^>]*?>#si', $out_html)){
				$out_html = preg_replace('#<meta[^>]*?name=[\'\"]?robots[\'\"]?[^>]*?>#si', '<meta name="robots" content="noindex, nofollow" />', $out_html);
			} else {
				$out_html = str_replace('</head>', '<meta name="robots" content="noindex, nofollow" />'."\n".'</head>', $out_html);
			}
		}
		return $out_html;
	}

}