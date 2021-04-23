<?php
/*
* отвечает за ЧПУ url'ы
*/
if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_seo_urls extends seoShieldModule
{
	function start_cms()
	{
        if(file_exists(SEOSHIELD_ROOT_PATH . '/data/seo_urls.cache.php'))
        {
            $data = require(SEOSHIELD_ROOT_PATH . '/data/seo_urls.cache.php');

            /**
             * редиректим из старых URL
             */
            if(($key = array_search($_SERVER['REQUEST_URI'], $data)) !== false)
            {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: ' . $key);
                exit;
            }

            /**
             * реврайтим
             */
            if(isset($data[$_SERVER['REQUEST_URI']]))
            {
                $uri = $data[$_SERVER['REQUEST_URI']];
                $_SERVER['REQUEST_URI'] = $uri;

                if(strpos($uri, '?') !== false)
                {
                    list(, $query) = explode('?', $uri);

                    parse_str($query, $_GET);
                }
            }
        }
	}

    function html_out_buffer($out_html)
    {
        if(file_exists(SEOSHIELD_ROOT_PATH . '/data/seo_urls.cache.php'))
        {
            $data = require(SEOSHIELD_ROOT_PATH . '/data/seo_urls.cache.php');

            foreach($data AS $new_url => $original_url)
            {
                $out_html = preg_replace(
                    '#(<a[^>]*href *= *[\'"])((http://[^/]+)?' . preg_quote($original_url) . ')([\'"][^>]*>)#is',
                    '\\1' . $new_url . '\\4',
                    $out_html
                );
            }
        }

        return $out_html;
    }
}