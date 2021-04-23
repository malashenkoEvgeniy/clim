<?php
/*
* отвечает за 301 редиректы
*/
if (!defined('SEOSHIELD_ROOT_PATH')) {
    define('SEOSHIELD_ROOT_PATH', rtrim(realpath(dirname(__FILE__)), '/'));
}

class SeoShieldModule_redirect_301_config extends SeoShieldModule_redirect_301
{
    public function start_cms()
    {
        $curr_uri = $_SERVER['REQUEST_URI'];
        $curr_host = $_SERVER['HTTP_HOST'];

		$query_string = '';
        if (strpos($curr_uri, '?') !== false){
            $parts = explode('?', $curr_uri);
            $query_string = end($parts);
            $curr_uri = reset($parts);
        }

        // --- С нулевой пагинации --- //
        if (strpos($curr_uri, '/page/0') !== false){
            $new_uri = str_replace('/page/0', '/', $curr_uri);
            header('Location: //' . $curr_host . $new_uri, true, 301);
            die();
        }


        if (preg_match('#gclid#i', $query_string) != 1 && preg_match('#utm_#i', $query_string) != 1){

            // --- Для товаров --- //
            $final_uri = $curr_uri;

            //--- C много слешей на один ---//
            if (strpos($final_uri, '//') !== false) {
                while (strpos($final_uri, '//') !== false) {
                    $final_uri = str_replace('//', '/', $final_uri);
                }
            }

            //--- C верхнего регистра на нижний ---//
            if (preg_match('#[A-Z]#su', $final_uri)) {
                $final_uri = strtolower($final_uri);
            }

            if ($curr_uri != $final_uri){
                if (!empty($query_string)) {
                    $query_string = '?' . $query_string;
                }
                header('Location: //' . $curr_host . $final_uri . $query_string, true, 301);
                die();
            }
        }


        //--- С www на без www ---//
        /*if ($curr_host == "www.name.com"){
            header('Location: //' . "name.com" . $curr_uri, true, 301);
             die();
        }*/

        //--- С без www на www ---//
        /*if ($curr_host == "name.com"){
            header('Location: //' . "www.name.com" . $curr_uri, true, 301);
             die();
        }*/

        //--- C много слешей на один ---//
        /*if (strpos($curr_uri, '//') !== false) {
            $newRequestUri = $curr_uri;
            while (strpos($newRequestUri, '//') !== false) {
                $newRequestUri = str_replace('//', '/', $newRequestUri);
            }
            header('Location: //' . $curr_host . $newRequestUri, true, 301);
            die();
        }*/

        //--- Cо слеша в конце на без слеша в конце ---//
        /*if (substr($curr_uri, -1) == "/" && $curr_uri !== "/") {
            $newRequestUri = substr($curr_uri, 0, strlen($curr_uri)-1);
            header('Location: //' . $curr_host . $newRequestUri, true, 301);
            die();
        }*/

        // --- С без слеша в конце на слеш в конце --- //
        /*if (substr($curr_uri, -1) != "/") {
            $newRequestUri = $curr_uri."/";
            header('Location: //' . $curr_host . $newRequestUri, true, 301);
            die();
        }*/

        //--- C верхнего регистра на нижний ---//
        /*if (preg_match('#[A-Z]#su', $curr_uri)){
            $newRequestUri = strtolower($curr_uri);
            header('Location: //' . $curr_host . $newRequestUri, true, 301);
            die();
        }*/

        //--- C index.php на без index.php ---//
        /*if (strpos($curr_uri, "index.php") !== false && empty($_GET)){
            $newRequestUri = str_replace('index.php', '', $curr_uri);
            header('Location: //' . $curr_host . $newRequestUri, true, 301);
            die();
        }*/

        $csv_file_name = SEOSHIELD_ROOT_PATH.'/data/redirect_301.csv';
        if (file_exists($csv_file_name)
            && is_readable($csv_file_name)) {
            $redirect_data = $this->csv2array($csv_file_name);

            foreach ($redirect_data as $cols) {
                $url = preg_replace('#^https?://[^/]+#is', '', trim($cols[0]));
                $url = current(explode('#', $url));
                if ('/' != substr($url, 0, 1)) {
                    continue;
                }

                if ($url == $GLOBALS['SEOSHIELD_CONFIG']['page_uri'] && $cols[0] != $cols[1]) {
                    header('HTTP/1.1 301 Moved Permanently');
                    header('Location: '.$cols[1]);
                    exit();
                }
            }
        }
    }
}
