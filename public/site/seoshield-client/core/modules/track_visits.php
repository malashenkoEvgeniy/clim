<?php

if (!defined('SEOSHIELD_ROOT_PATH')) {
    define('SEOSHIELD_ROOT_PATH', rtrim(realpath(dirname(__FILE__)), '/'));
}

class SeoShieldModule_track_visits extends seoShieldModule
{
    private function check_and_create_table()
    {
        return $GLOBALS['SEOSHIELD_CONFIG']['mysql']->mysql_query('CREATE TABLE IF NOT EXISTS `'.$GLOBALS['SEOSHIELD_CONFIG']['track_visits']['table_name']."` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `url` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `category_name` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `filter_1` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `filter_2` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `title` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `h1` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `description` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `breadcrumbs` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `robots` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `seo_text` BOOLEAN NOT NULL DEFAULT FALSE,
            `products_num` int(11) DEFAULT '0',
            `visits` int(11) DEFAULT '0',
            `date_add` DATE NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `id` (`id`),
            UNIQUE KEY `url` (`url`)
        )");
    }

    private function get_full_url()
    {
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['seoshield_config_url_key'])) {
            return 'http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 's' : '').':'.$GLOBALS['SEOSHIELD_CONFIG'][$GLOBALS['SEOSHIELD_CONFIG']['track_visits']['seoshield_config_url_key']];
        }

        return 'http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 's' : '').':'.$GLOBALS['SEOSHIELD_CONFIG']['page_url_alt'];
    }

    private function get_page_h1($out_html)
    {
        $h1 = '';
        preg_match_all('#<h1[^>]*>(.*?)<\/h1>#s', $out_html, $matches);
        if (isset($matches[0][0])) {
            $h1 = strip_tags($matches[0][0]);
        }

        return $h1;
    }

    private function get_page_title($out_html)
    {
        $title = '';
        preg_match_all('#<title>(.*?)<\/title>#s', $out_html, $matches);
        if (isset($matches[0][0])) {
            $title = strip_tags($matches[0][0]);
        }

        return $title;
    }

    private function get_filter_info($out_html, $position)
    {
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['selected_filters_selector'])) {
            $index = $position - 1;
            preg_match_all($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['selected_filters_selector'], $out_html, $filters_matches);
            if (isset($filters_matches['filter_name']) && isset($filters_matches['filter_value'])) {
                if (isset($filters_matches['filter_name'][$index])) {
                    return $filters_matches['filter_name'][$index].': '.$filters_matches['filter_value'][$index];
                }
            }
        }

        return '';
    }

    private function get_page_description($out_html)
    {
        $ps_descr = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['meta_description_selector'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['meta_description_selector'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $ps_descr = $finder[1];
            }
            unset($finder);
        }

        return $ps_descr;
    }

    private function get_breadcrumbs($out_html)
    {
        $breadcrums_list = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['breadcrumbs_selector'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['breadcrumbs_selector'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $breadcrums_list = $finder[1];
            }
            unset($finder);
        }

        return $breadcrums_list;
    }

    private function get_robots_txt($out_html)
    {
        preg_match_all('#<meta[^>]*?name=[\'"]?robots[\'"]?[^>]+?>#s', $out_html, $robots_matches);
        if (isset($robots_matches[0]) && isset($robots_matches[0][0])) {
            $robots_tag = $robots_matches[0][0];
            preg_match('#content=[\'"]([^\'"]+)[\'"]#s', $robots_tag, $robots_content);
            if (isset($robots_content[1])) {
                return $robots_content[1];
            }
        }

        return '';
    }

    private function get_products_num($out_html)
    {
        return substr_count($out_html, $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['product_selector']);
    }

    private function get_seo_text_bool($out_html)
    {
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['content_area_selector'])) {
            foreach ($GLOBALS['SEOSHIELD_CONFIG']['content_area_selector'] as $patternInfo) {
                if (isset($patternInfo['type']) && 'regex' == $patternInfo['type'] && isset($patternInfo['pattern']) && !empty($patternInfo['pattern'])) {
                    if (preg_match($patternInfo['pattern'], $out_html)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function get_category_name($out_html)
    {
        $category_name = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['cms_category_name'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['cms_category_name'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $category_name = $finder[1];
            }
            unset($finder);
        }

        return $category_name;
    }

    public function html_out_buffer($out_html)
    {
        if (function_exists('http_response_code')) {
            $response_code = http_response_code();
            if (404 == $response_code) {
                return $out_html;
            }
        }

        preg_match_all('#<meta[^>]*?name=[\'"]?robots[\'"]?[^>]+?>#s', $out_html, $robots_matches);
        if (isset($robots_matches[0]) && isset($robots_matches[0][0])) {
            if (false !== strpos($robots_matches[0][0], 'noindex')) {
                return $out_html;
            }
        }

        if (!isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits'])) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) {
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: empty track_visits module config--></body>', $out_html);
            }

            return $out_html;
        }

        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['pagination_comment']) && false !== strpos($out_html, $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['pagination_comment'])) {
            return $out_html;
        }

        if (!isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['selectors'])
            || empty($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['selectors'])
            || !isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['table_name'])
            || empty($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['table_name'])
            || !isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['product_selector'])
            || empty($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['product_selector'])
        ) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) {
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: empty fields in track_visits module config--></body>', $out_html);
            }

            return $out_html;
        }

        if (!$GLOBALS['SEOSHIELD_CONFIG']['mysql'] instanceof seoShieldDb) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) {
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: problems in DB config--></body>', $out_html);
            }

            return $out_html;
        }

        if (!$this->check_and_create_table()) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) {
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: table in DB was not created--></body>', $out_html);
            }

            return $out_html;
        }

        $matched = false;
        foreach ($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['selectors'] as $selector) {
            if (!isset($selector['selector'])) {
                continue;
            }
            if (isset($selector['type'])) {
                if ('regex' == $selector['type']) {
                    if (preg_match($selector['selector'], $out_html)) {
                        $matched = true;
                        break;
                    }
                } elseif ('strpos' == $selector['type']) {
                    if (false !== strpos($out_html, 'strpos')) {
                        $matched = true;
                        break;
                    }
                }
            } else {
                if (false !== strpos($out_html, $selector['selector'])) {
                    $matched = true;
                    break;
                }
            }
        }

        if (!$matched) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) {
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: selectors not matched--></body>', $out_html);
            }

            return $out_html;
        }

        if (false === strpos($out_html, $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['product_selector'])) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) {
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: products not matched--></body>', $out_html);
            }

            return $out_html;
        }
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['filter_uri_part']) && false === strpos($GLOBALS['SEOSHIELD_CONFIG']['page_url_alt'], $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['filter_uri_part'])) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) {
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: URI not matches--></body>', $out_html);
            }

            return $out_html;
        }

        $row = [
            'url' => $this->get_full_url(),
            'category_name' => $this->get_category_name($out_html),
            'filter_1' => $this->get_filter_info($out_html, 1),
            'filter_2' => $this->get_filter_info($out_html, 2),
            'title' => $this->get_page_title($out_html),
            'h1' => $this->get_page_h1($out_html),
            'description' => $this->get_page_description($out_html),
            'breadcrumbs' => $this->get_breadcrumbs($out_html),
            'robots' => $this->get_robots_txt($out_html),
            'products_num' => $this->get_products_num($out_html),
            'seo_text' => $this->get_seo_text_bool($out_html),
            'visits' => 1,
            'date_add' => date('Y-m-d H:i:s'),
        ];
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) {
            $out_html = str_replace('</body>', '<!--SEOSHIELD_INFO: tracked_row:'."\n".var_export($row, true).'--></body>', $out_html);
        }

        $result = $GLOBALS['SEOSHIELD_CONFIG']['mysql']->mysql_query('INSERT INTO '.$GLOBALS['SEOSHIELD_CONFIG']['track_visits']['table_name'].' (`'.implode('`, `', array_keys($row))."`)
            VALUES ('".implode("', '", $row)."')
            ON DUPLICATE KEY UPDATE visits = visits + 1;
        ");

        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_visits']['debug']) {
            $out_html = str_replace('</body>', '<!--SEOSHIELD_INFO:insert_result:'.var_export($result, true).'--></body>', $out_html);
        }

        return $out_html;
    }
}