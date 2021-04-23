<?php
/***
PLACE THIS FILE INTO /seoshield-client/modules/ DIRECTORY
*/
error_reporting(E_ERROR);

if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_generate_formulas_config extends SeoShieldModule_generate_formulas
{
	public function setup_variables($out_html){
		$curr_uri = $_SERVER['REQUEST_URI'];
		$curr_host = $_SERVER['HTTP_HOST'];

		$out_html = str_replace('</head>', '<!--seoshield--version--site--rus-->'."\n".'</head>', $out_html);

		// --- Размечаем фильтры --- //
		if (strpos($out_html, '<!--dg_selected_filter_title') !== false){
			// --- Парсим зажатые фильтры --- //
			preg_match_all('#<!--dg_selected_filter_title:(.*?);;dg_selected_filter_name:(.*?)-->#s', $out_html, $finder);
			if (isset($finder[1]) && !empty($finder[1])){
				foreach ($finder[1] as $index => $f_title) {
					$out_html = str_replace('</body>', '<!--ss_selected_filters_info|'.$f_title.'|'.$finder[2][$index].'--></body>', $out_html);
				}
			}
			if (isset($finder[0]) && !empty($finder[0])){
				// --- Если зажато больше 2 --- //
				if (count($finder[0]) > 2){
				// --- Если зажато 2 из одной категории --- //
				} elseif (count($finder[0]) == 2 && $finder[1][0] == $finder[1][1]) {
				} else {
					$out_html = str_replace('</head>', '<!--seoshield_formulas--fil-traciya-->'."\n".'</head>', $out_html);
				}
			}
			unset($finder);
		}

		// --- Размечаем продукт --- //
		if (strpos($out_html, '<!--this_is_product-->') !== false){
			$out_html = str_replace('</head>', '<!--seoshield_formulas--tovar-->'."\n".'</head>', $out_html);
		}

		// --- Размечаем служебные --- //
		$mas_service = array('/checkout', '/delivery', '/politika-konfidentsialnosti', '/payment', '/warranty', '/contact');
		if (in_array($curr_uri, $mas_service)){
			$out_html = str_replace('</head>', '<!--seoshield_formulas--sluzhebnaya-->'."\n".'</head>', $out_html);
		}

		// --- Размечаем категорию --- //
		if (strpos($out_html, '<!--isset_listing_page-->') !== false 
					&& strpos($out_html, '<!--seoshield_formulas--fil-traciya-->') === false){
			$out_html = str_replace('</head>', '<!--seoshield_formulas--kategoriya-->'."\n".'</head>', $out_html);
		}

		return $out_html;
	}

	function set_robots_noindex_nofollow($out_html){
		if (strpos($out_html, '<meta name=[\'\"]?robots[\'\"]? content="noindex, nofollow" />') === false){
			if (preg_match('#<meta[^>]*?name=[\'\"]?robots[\'\"]?[^>]*?>#si', $out_html)){
				$out_html = preg_replace('#<meta[^>]*?name=[\'\"]?robots[\'\"]?[^>]*?>#si', '<meta name="robots" content="noindex, nofollow" />', $out_html);
			} else {
				$out_html = str_replace('</head>', '<meta name="robots" content="noindex, nofollow" />'."\n".'</head>', $out_html);
			}
		}
		return $out_html;
	}

	function h1_formulas_generation($out_html)
	{
		$curr_h1 = "";
		preg_match('#<h1[^>]*?>(.*?)<\/h1>#s', $out_html, $finder);
		if (isset($finder[0]) && !empty($finder[1])){
			$curr_h1 = strip_tags($finder[1]);
			$curr_h1 = trim($curr_h1);
		}

		$static_h1 = "";
		if (file_exists(SEOSHIELD_ROOT_PATH."/data/static_meta.cache.php")){
			if(!isset($GLOBALS['SEOSHIELD_DATA']['static_meta']))
				$this->get_static_meta();

			if (isset($GLOBALS['SEOSHIELD_DATA']['static_meta']['h1'])){
				$static_h1 = $GLOBALS['SEOSHIELD_DATA']['static_meta']['h1'];
			}
		}

		if ($static_h1 != ""){
			$curr_h1 = $static_h1;
		}
        
		return $curr_h1;
	}


	function parentCat_formulas_generation($out_html)
	{
		$curr_host = $_SERVER['HTTP_HOST'];

		$parent_cat = '';
		$parent_cat_url = "";
		$parent_cat_name = "";
		preg_match_all('#<!--dg_active_crumb_on_cat_url:(.*?);;dg_active_crumb_on_cat_name:(.*?)-->#s', $out_html, $finder);
		if (isset($finder[0]) && !empty($finder[0])){

			$parent_cat_name = array_pop($finder[2]);
			$parent_cat_url = array_pop($finder[1]);

			$parent_cat_url = preg_replace('#https:\/\/'.$curr_host.'#s', '', $parent_cat_url);
			$parent_static_data = $this->get_static_data_by_uri($parent_cat_url);

			if (!empty($parent_static_data[2])){
				$parent_cat = $parent_static_data[2];
			} else {
				$parent_cat = $parent_cat_name;
			}
		}
		unset($finder);

		return $parent_cat;
	}


	function filterPart_formulas_generation($out_html)
	{
		$filter_part = "";
		preg_match_all('#<!--dg_selected_filter_title:(.*?);;dg_selected_filter_name:(.*?)-->#s', $out_html, $finder);
		if (isset($finder[0]) && !empty($finder[0])){
			// --- Если один зажатый фильтр --- //
			if (count($finder[0]) == 1){
				// --- Если зажат производитель --- //
				if ($finder[1][0] == "Производитель"){
					$filter_part = " : ".$finder[2][0];
				// --- Если зажат НЕ производитель --- //
				} else{
					$filter_part = " : ".$finder[1][0]." - ".$finder[2][0];
				}
			// --- Если два зажатых фильтра --- //
			} elseif (count($finder[0]) == 2){
				// --- 2 фильтра из разных блоков --- //
				if (($finder[1][0] != $finder[1][1]) && ($finder[1][0] != "Производитель") && ($finder[1][1] != "Производитель")) {
					$filter_part = " : ".$finder[1][0]." - ".$finder[2][0].", ".$finder[1][1]." - ".$finder[2][1];
				}
			}
		}
		unset($finder);		

		return $filter_part;
	}

}