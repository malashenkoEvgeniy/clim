<?php
/**
 * SeoShieldClient v1.2.
 */
// скрипт занимается обслуживанием запросов от seoshield
error_reporting(0);
ini_set('display_errors', 0);

// UNCOMMENT IF PHP CACHING ENABLED
//ini_set("soap.wsdl_cache_enabled", 0);
//opcache_reset();

if (!defined('SEOSHIELD_ROOT_PATH')) {
    define('SEOSHIELD_ROOT_PATH', rtrim(realpath(dirname(__FILE__)), '/'));
}

include_once SEOSHIELD_ROOT_PATH.'/core/module.php';

// глобальный конфиг
if (!isset($GLOBALS['SEOSHIELD_CONFIG'])) {
    $GLOBALS['SEOSHIELD_CONFIG'] = [];
}
$GLOBALS['SEOSHIELD_CONFIG']['content_area_selector'] = [[
    'type' => 'regex',
    'pattern' => '#(<!--seo_text_start-->)(.*?)(<!--seo_text_end-->)#is',
]];
$GLOBALS['SEOSHIELD_CONFIG']['content_replace_type'] = 0;
$GLOBALS['SEOSHIELD_CONFIG']['pages_adverts_config'] = [
    'pages_adverts' => '<!--{seoshield_pages_adverts}-->',
    'pages_keywords' => '<!--{seoshield_pages_keywords}-->',
    'use_relative_url' => false,
    'use_default_css' => true,
    'add_css' => '',
    'per_page' => 6,
];
$GLOBALS['SEOSHIELD_CONFIG']['page_uri'] = $_SERVER['REQUEST_URI'];
$page_uri_res = explode('?', $_SERVER['REQUEST_URI']);
$GLOBALS['SEOSHIELD_CONFIG']['page_uri_alt'] = $page_uri_res[0];
$GLOBALS['SEOSHIELD_CONFIG']['page_url'] = '//'.$_SERVER['HTTP_HOST'].$GLOBALS['SEOSHIELD_CONFIG']['page_uri'];
$GLOBALS['SEOSHIELD_CONFIG']['page_url_alt'] = '//'.$_SERVER['HTTP_HOST'].$GLOBALS['SEOSHIELD_CONFIG']['page_uri_alt'];
$GLOBALS['SEOSHIELD_CONFIG']['page_hash'] = md5($GLOBALS['SEOSHIELD_CONFIG']['page_url']);
$GLOBALS['SEOSHIELD_CONFIG']['page_hash_alt'] = md5($GLOBALS['SEOSHIELD_CONFIG']['page_url_alt']);
$GLOBALS['SEOSHIELD_CONFIG']['contents_path'] = SEOSHIELD_ROOT_PATH.'/data/generate_content';
$GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'] = 'utf-8';
$GLOBALS['SEOSHIELD_CONFIG']['api_pager'] = 'api.pager.seoshield.ru:8882';
$GLOBALS['SEOSHIELD_CONFIG']['is_static_page'] = false;

if (file_exists(SEOSHIELD_ROOT_PATH.'/configs/main.php')) {
    include_once SEOSHIELD_ROOT_PATH.'/configs/main.php';
}

/*
 * загружаем остальные конфиги
 */
foreach (glob(SEOSHIELD_ROOT_PATH.'/configs/*.php') as $config_file) {
    if ('main.php' == basename($config_file)) {
        continue;
    }
    include_once $config_file;
}

/*
 * пробуем подгрузить конфиг клиента
 */
if (file_exists(SEOSHIELD_ROOT_PATH.'/../seoshield_config.php')) {
    include_once SEOSHIELD_ROOT_PATH.'/../seoshield_config.php';
}

function error_response($error)
{
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');

    $data = base64_decode($_POST['seoshield_query']);
    $data = json_decode($data);

    echo json_encode([
        'errors' => is_array($error) ? $error : [$error],
        'query' => $data,
    ]);
    exit;
}

function success_response($data)
{
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');

    echo json_encode([
        'data' => $data,
    ]);
    exit;
}

function getDirInfo($dir_path, &$data = [])
{
    $dir_path = rtrim($dir_path, '/').'/';

    if (is_dir($dir_path)) {
        if ($dh = opendir($dir_path)) {
            while (false !== ($file = readdir($dh))) {
                if ('.' == $file
                    || '..' == $file
                    || '.DS_Store' == $file
                    || '.git' == $file) {
                    continue;
                }

                $type = filetype($dir_path.$file);

                if ('dir' == $type) {
                    getDirInfo($dir_path.$file, $data);
                }
                $data[] = [
                    'path' => str_replace(SEOSHIELD_ROOT_PATH.'/', '', $dir_path.$file),
                    'type' => $type,
                    'perms' => substr(sprintf('%o', fileperms($dir_path.$file)), -4),
                ];
            }
            closedir($dh);
        }
    }

    return $data;
}

function update_files_structure($files, $remove_not_exists = false)
{
    if (!is_array($files)) {
        error_response('BAD_QUERY');
    }

    /*
     * сначала обновляем структуру директорий
     */
    foreach ($files as $r) {
        if ('dir' != $r->type) {
            continue;
        }

        if (file_exists(SEOSHIELD_ROOT_PATH.'/'.$r->path)) {
            continue;
        }

        if (!mkdir(SEOSHIELD_ROOT_PATH.'/'.$r->path)) {
            error_response('CANT_CREATE_DIR');
        }
        chmod(SEOSHIELD_ROOT_PATH.'/'.$r->path, 0755);
    }

    /*
     * теперь обновляем файлы
     */
    foreach ($files as $r) {
        if ('file' != $r->type
            || 'config.php' == $r->path) {
            continue;
        }

        if (false === file_put_contents(SEOSHIELD_ROOT_PATH.'/'.$r->path, $r->content, LOCK_EX)) {
            error_response('CANT_WRITE_TO_FILE');
        }
    }
}

function check_file_exists($path)
{
    $data = [];

    $path_res = explode('/', $path);
    array_pop($path_res);
    $path_dir = implode('/', $path_res);

    if (is_dir($path_dir)) {
        if (is_writable($path_dir)) {
            $data['access'] = true;
        } else {
            chmod($path_dir, 0777);
            if (is_writable($path_dir)) {
                $data['access'] = true;
            } else {
                $data['error'] = 'no access to directory';
            }
        }
    } else {
        $dirs = explode('/', $path_dir);
        $dirs_path = [];
        foreach ($dirs as $dir) {
            if ((empty($dir) || '.' == $dir) && '0' !== $dir) {
                continue;
            }

            $dirs_path[] = $dir;

            $dir_path = implode('/', $dirs_path).'/';
            $dir_path = '/' !== substr($dir_path, 1) ? '/'.$dir_path : $dir_path;
            if (!is_dir($dir_path)) {
                mkdir($dir_path, 0777);
                chmod($dir_path, 0777);
            }
        }

        if (!is_dir($path_dir)) {
            $data['error'] = 'cant create directory';
        }
    }

    if (!isset($data['error'])) {
        if (!is_file($path)) {
            touch($path);
        }

        if (is_file($path)) {
            if (is_writable($path)) {
                $data['access'] = true;
            } else {
                chmod($path, 0777);
                if (is_writable($path)) {
                    $data['access'] = true;
                } else {
                    $data['error'] = 'no access to file';
                }
            }
        } else {
            $data['error'] = 'cant create file';
        }
    }

    return $data;
}

function recursive_rm($path)
{
    if (is_dir($path)) {
        $path = '/' !== substr($path, -1) ? $path.'/' : $path;
        chmod($path, 0777);
        $path_res = glob($path.'*', GLOB_MARK);
        foreach ($path_res as $path_part) {
            recursive_rm($path_part);
        }
        rmdir($path);
    } elseif (is_file($path)) {
        unlink($path);
    }
}

if (!empty($_POST['resync_footers_data'])) {
    $data = [];
    $data['status'] = 'error';
    if (!empty($_POST['access_key']) &&
        ($_POST['access_key'] == $GLOBALS['SEOSHIELD_CONFIG']['access_key'] ||
            in_array($_POST['access_key'], $GLOBALS['SEOSHIELD_CONFIG']['access_keys']))) {
        if (function_exists('curl_init')) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $GLOBALS['SEOSHIELD_CONFIG']['footers_api_url'].$_POST['access_key']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['key' => $_POST['access_key']]));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

            $result = curl_exec($ch);
            curl_close($ch);
            $result = '<?php return '.var_export(json_decode($result, true), true).';';
            file_put_contents(SEOSHIELD_ROOT_PATH.'/data/footers_config_data.php', $result, LOCK_EX);
            if (is_dir(SEOSHIELD_ROOT_PATH.'/data/footers_cache')) {
                recursive_rm(SEOSHIELD_ROOT_PATH.'/data/footers_cache');
                mkdir(SEOSHIELD_ROOT_PATH.'/data/footers_cache', 0777, true);
            }
            file_put_contents(SEOSHIELD_ROOT_PATH.'/data/footers_data.cache.php', '<?php return array();', LOCK_EX);
            $data['status'] = 'success';
            success_response($data);
        }
    }
    success_response($data);
}

if (isset($_GET['check_tracks']) && isset($_GET['action'])){
    if (!empty($_GET['access_key']) &&
        ($_GET['access_key'] == $GLOBALS['SEOSHIELD_CONFIG']['access_key'] ||
            in_array($_GET['access_key'], $GLOBALS['SEOSHIELD_CONFIG']['access_keys']))) {
    } else {
        exit('Wrong key');
    }
    include SEOSHIELD_ROOT_PATH.'/main.php';
    if (!isset($GLOBALS['SEOSHIELD_CONFIG']['mysql'])){
        exit('Wrong db connection');
    }
    if (!$GLOBALS['SEOSHIELD_CONFIG']['mysql'] instanceof \seoShieldDb){
        $db = new seoShieldDb($GLOBALS['SEOSHIELD_CONFIG']['mysql']);
    } else {
        $db = $GLOBALS['SEOSHIELD_CONFIG']['mysql'];
    }
    if ($_GET['action'] == 'count'){
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['table_name'])){
            $q = $db->mysql_query("SELECT `id` FROM ".$GLOBALS['SEOSHIELD_CONFIG']['track_visits']['table_name']);
            echo $db->mysql_num_rows($q);
        }
        exit();
    } elseif ($_GET['action'] == 'download'){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=export_visits_'.$_SERVER["HTTP_HOST"].'_'.date('d.m.Y_H.i.s', time()).'.csv');

        $output = fopen('php://output', 'w');

        fputcsv($output, array('URL', 'CATEGORY_NAME', 'FILTER_1', 'FILTER_2', 'TITLE', 'H1', 'DESCRIPTION', 'BREADCRUMBS', 'ROBOTS', 'SEO_TEXT', 'PRODUCTS_NUM', 'VISITS', 'DATE_ADD',));
        $q = $db->mysql_query("SELECT `url`, `category_name`, `filter_1`, `filter_2`, `title`, `h1`, `description`, `breadcrumbs`, `robots`, `seo_text`, `products_num`, `visits`, `date_add` FROM ".$GLOBALS['SEOSHIELD_CONFIG']['track_visits']['table_name']);
        while ($row = $db->mysql_fetch_assoc($q)) {
            fputcsv($output, $row);
        }
        exit();
    } elseif ($_GET['action'] == 'clear') {
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_visits']['table_name'])){
            $q = $db->mysql_query("TRUNCATE table ".$GLOBALS['SEOSHIELD_CONFIG']['track_visits']['table_name']);
            if (!$q){
                exit('Error while truncating');
            }
            exit('Done');
        }
        exit('Error in config');
    } else {
        exit('Unknown action');
    }
    exit();
}

if (!empty($_POST['check_connection'])) {
    $data = [];
    $data['status'] = 'success';
    $data['access_key'] = false;
    $data['file_access'] = false;
    $data['directory_access'] = false;
    if (!empty($_POST['access_key']) &&
        ($_POST['access_key'] == $GLOBALS['SEOSHIELD_CONFIG']['access_key'] ||
            in_array($_POST['access_key'], $GLOBALS['SEOSHIELD_CONFIG']['access_keys']))) {
        $data['access_key'] = true;
    }
    if (is_dir(SEOSHIELD_ROOT_PATH.'/data')) {
        if (is_writable(SEOSHIELD_ROOT_PATH.'/data')) {
            $data['directory_access'] = true;
        } else {
            chmod(SEOSHIELD_ROOT_PATH.'/data', 0777);
            if (is_writable(SEOSHIELD_ROOT_PATH.'/data')) {
                $data['directory_access'] = true;
            } else {
                $data['directory_access'] = 'no access';
            }
        }
    } else {
        $data['directory_access'] = 'no directory';
    }
    if (!is_file(SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php')) {
        touch(SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php');
    }
    if (is_file(SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php')) {
        if (is_writable(SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php')) {
            $data['file_access'] = true;
        } else {
            chmod(SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php', 0777);
            if (is_writable(SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php')) {
                $data['file_access'] = true;
            } else {
                $data['file_access'] = 'no access';
            }
        }
    } else {
        $data['file_access'] = 'no file';
    }

    // проверяем директорию с index.php на возможность записи
    if (is_writable(SEOSHIELD_ROOT_PATH.'/../')) {
        $data['writable_index_dir'] = true;
    } else {
        $data['writable_index_dir'] = false;
    }

    $data['config'] = $GLOBALS['SEOSHIELD_CONFIG'];
    $rm_fields = [
        'allow_get',
        'message_404',
        'meta_title_404',
        'replace_by_referer',
        'run_404_check_get',
        'run_404_check_slash',
        'run_404_check_space',
        'run_404_check_strlower',
        'run_404_check_user_config',
        'run_404_start_cms',
        'run_404_start_cms_template',
        'way_to_content',
    ];
    foreach ($rm_fields as $f_name) {
        if (isset($data['config'][$f_name])) {
            unset($data['config'][$f_name]);
        }
    }

    success_response($data);
}

if (!empty($_POST['seoshield_query']) && !empty($_POST['seoshield_query_hash'])) {
    $query_hashes = [];
    $query_hashes[] = md5($_POST['seoshield_query'].$GLOBALS['SEOSHIELD_CONFIG']['access_key']);
    foreach ($GLOBALS['SEOSHIELD_CONFIG']['access_keys'] as $key) {
        $query_hashes[] = md5($_POST['seoshield_query'].$key);
    }

    if (in_array($_POST['seoshield_query_hash'], $query_hashes)) {
        $data = json_decode(base64_decode($_POST['seoshield_query']));

        /*
         * purge cache cloudflare
         */
        if (!is_null($data->command) && in_array($data->command, ['formulas_cache_sync', 'sync_data', 'clear_data', 'clear_all_data'])) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['cloudflare']['email'])
                && isset($GLOBALS['SEOSHIELD_CONFIG']['cloudflare']['api_key'])
                && !empty($GLOBALS['SEOSHIELD_CONFIG']['cloudflare']['email'])
                && !empty($GLOBALS['SEOSHIELD_CONFIG']['cloudflare']['api_key'])
                && function_exists('curl_init')
            ) {
                $zone_id = null;
                if (isset($GLOBALS['SEOSHIELD_CONFIG']['cloudflare']['zone_id'])
                    && !empty($GLOBALS['SEOSHIELD_CONFIG']['cloudflare']['zone_id'])) {
                    $zone_id = $GLOBALS['SEOSHIELD_CONFIG']['cloudflare']['zone_id'];
                } else {
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, 'https://api.cloudflare.com/client/v4/zones?');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

                    $headers = [];
                    $headers[] = 'X-Auth-Email: '.$GLOBALS['SEOSHIELD_CONFIG']['cloudflare']['email'];
                    $headers[] = 'X-Auth-Key: '.$GLOBALS['SEOSHIELD_CONFIG']['cloudflare']['api_key'];
                    $headers[] = 'Content-Type: application/json';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $result = curl_exec($ch);
                    $curl_error = curl_errno($ch);
                    curl_close($ch);
                    if (0 === $curl_error) {
                        $result = json_decode($result, true);
                        if (isset($result['result'][0]['id'])) {
                            $zone_id = $result['result'][0]['id'];
                        }
                    }
                }

                if (!is_null($zone_id)) {
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, 'https://api.cloudflare.com/client/v4/zones/'.$zone_id.'/purge_cache');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"purge_everything":true}');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

                    $headers = [];
                    $headers[] = 'X-Auth-Email: '.$GLOBALS['SEOSHIELD_CONFIG']['cloudflare']['email'];
                    $headers[] = 'X-Auth-Key: '.$GLOBALS['SEOSHIELD_CONFIG']['cloudflare']['api_key'];
                    $headers[] = 'Content-Type: application/json';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $result = curl_exec($ch);
                    curl_close($ch);
                }
            }
        }

        switch ($data->command) {
            /*
             * синхронизирует данные формул с seoshield
             */
            case 'formulas_cache_sync':
                $cache_file = SEOSHIELD_ROOT_PATH.'/data/formulas_meta.cache.php';
                $check_file = check_file_exists($cache_file);
                if (isset($check_file['error'])) {
                    error_response([
                        'check_file' => $check_file,
                    ]);
                }

                $formulas = $_POST['data'];
                $formulas = json_decode($formulas, true);
                $cache_new_data = $formulas;

                // список для исключения работы формул
                if (!empty($_POST['url_exec'])) {
                    $cache_new_data['url_exec'] = json_decode($_POST['url_exec'], true);
                }

                if (!empty($_POST['url_access'])) {
                    $cache_new_data['url_access'] = json_decode($_POST['url_access'], true);
                }

                file_put_contents($cache_file, '<?php return '.var_export($cache_new_data, true).';', LOCK_EX);
                $cache_file_time = filemtime($cache_file);
                success_response([
                    'complete' => 'success',
                    'cache_file_time' => $cache_file_time,
                ]);

                break;

            /*
             * синхронизирует данные модулей с seoshield
             */
            case 'sync_data':
                switch ($data->destination) {
                    case 'static_meta':
                    case 'static_meta:by_id':
                        $cache_file = SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php';

                        $cache_file_time = 0;
                        if (file_exists($cache_file)) {
                            $cache_file_time = filemtime($cache_file);
                        }
                        $data->data = json_decode($data->data);

                        /**
                         * кеш файл на сервере новее того что мы
                         * последний раз синхронизировали с шилдом
                         *
                         * проверяем что изменилось для ручной синхронизации
                         */
                        $save_data_from_shield = true;

                        $cache_new_data = (array) $data->data->data;
                        foreach ($cache_new_data as $url => $cached_data) {
                            foreach ($cached_data as $k => $v) {
                                if (5 == $k) {
                                    $cached_data['type'] = $v;
                                    unset($cached_data[$k]);
                                } elseif (6 == $k) {
                                    $cached_data['template'] = $v;
                                    unset($cached_data[$k]);
                                } elseif (7 == $k) {
                                    $cached_data['category'] = (array) $v;
                                    unset($cached_data[$k]);
                                }
                            }
                            $cache_new_data[$url] = $cached_data;
                        }

                        if ('static_meta:by_id' == $data->destination
                            && file_exists($cache_file)) {
                            $current_data = require $cache_file;
                            if (is_null($current_data) || !is_array($current_data)) {
                                $current_data = [];
                            }
                            $current_data = array_merge($current_data, $cache_new_data);

                            $cache_new_data = $current_data;
                            unset($current_data);
                        }

                        /*
                         * похоже все ок,
                         * просто сохраняем данные которые пришли в кеш файл
                         */
                        if ($save_data_from_shield) {
                            $bytes_written = file_put_contents($cache_file, '<?php return '.var_export($cache_new_data, true).';', LOCK_EX);

                            $cache_file_time = filemtime($cache_file);

                            success_response([
                                'complete' => 'success',
                                'cache_file_time' => $cache_file_time,
                                'write_status' => $bytes_written,
                            ]);
                        }

                        break;

                    case 'pages_adverts':
                    case 'pages_adverts:by_id':
                        $cache_file = SEOSHIELD_ROOT_PATH.'/data/pages_adverts/pages_adverts.cache.php';

                        $check_file = check_file_exists($cache_file);
                        if (isset($check_file['error'])) {
                            error_response([
                                'check_file' => $check_file,
                            ]);
                        }

                        $data->data = json_decode($data->data, true);
                        $cache_new_data = $data->data['data'];

                        if ('pages_adverts:by_id' == $data->destination) {
                            $current_data = require $cache_file;
                            if (is_null($current_data) || !is_array($current_data)) {
                                $current_data = [];
                            }
                            $current_data = array_merge($current_data, $cache_new_data);
                            $cache_new_data = $current_data;
                            unset($current_data);
                        }

                        file_put_contents($cache_file, '<?php return '.var_export($cache_new_data, true).';', LOCK_EX);

                        $cache_file_time = filemtime($cache_file);
                        success_response([
                            'complete' => 'success',
                            'cache_file_time' => $cache_file_time,
                        ]);

                        break;

                    /*
                     * Синхронизация клиентских файлов
                     */
                    case 'sync_client_file':
                        $data->data = json_decode($data->data);

                        $file_name = $data->data->data->file_name;
                        $file_content = $data->data->data->file_content;
                        $was_synced = $data->data->data->was_synced;

                        if (!isset($file_name) || empty($file_name)) {
                            error_response([
                                'error_msg' => 'Пустое имя файла.',
                            ]);
                        }

                        // проверим на возможность записи
                        if (!is_writable(SEOSHIELD_ROOT_PATH.'/../')) {
                            error_response([
                                'error_msg' => 'Директория с index.php недоступна для записи.',
                            ]);
                        }

                        // проверим на возможность записи файла
                        if (!is_writable(SEOSHIELD_ROOT_PATH.'/../'.$file_name)) {
                            error_response([
                                'error_msg' => 'Файл не доступен для записи.',
                            ]);
                        }

                        /**
                         * Если это первая синхронизация, перед созданием файла нужно проверить,
                         * существует ли он уже на сервере. Если мы собираемся его перезаписать,
                         * нужно сделать метку в базе о том, что данный файл уже был на сервере
                         * и при удалении нужно вернуть его первоначальное состояние.
                         */
                        $existing = 0;
                        $original_content = '';

                        if (!$was_synced) {
                            if (file_exists(SEOSHIELD_ROOT_PATH.'/../'.$file_name)) {
                                $existing = 1;
                                $original_content = file_get_contents(SEOSHIELD_ROOT_PATH.'/../'.$file_name);
                            }
                        }

                        // пробуем создать файл
                        file_put_contents(SEOSHIELD_ROOT_PATH.'/../'.$file_name, $file_content, LOCK_EX);
                        if (!file_exists(SEOSHIELD_ROOT_PATH.'/../'.$file_name)) {
                            error_response([
                                'error_msg' => 'Не получилось создать файл.',
                                'file_name' => $file_name,
                                'file_content' => $file_content,
                            ]);
                        }

                        success_response([
                            'complete' => 'success',
                            'existing' => $existing,
                            'original_content' => $original_content,
                        ]);

                        break;

                    /*
                     * Получение контента клиентского файла
                     */
                    case 'get_content_from_site':
                        $data->data = json_decode($data->data);

                        $file_name = $data->data->data->file_name;
                        $file_content = $data->data->data->file_content;
                        $was_synced = $data->data->data->was_synced;

                        if (!isset($file_name) || empty($file_name)) {
                            error_response([
                                'error_msg' => 'Пустое имя файла.',
                            ]);
                        }

                        /**
                         * Если это первая синхронизация, перед созданием файла нужно проверить,
                         * существует ли он уже на сервере. Если мы собираемся его перезаписать,
                         * нужно сделать метку в базе о том, что данный файл уже был на сервере
                         * и при удалении нужно вернуть его первоначальное состояние.
                         */
                        $existing = 0;
                        $original_content = '';

                        if (!$was_synced) {
                            if (file_exists(SEOSHIELD_ROOT_PATH.'/../'.$file_name)) {
                                $existing = 1;
                                $original_content = file_get_contents(SEOSHIELD_ROOT_PATH.'/../'.$file_name);
                            }
                        }

                        // проверим есть ли такой файл
                        $file_exists = 0;
                        $file_content = '';

                        if (file_exists(SEOSHIELD_ROOT_PATH.'/../'.$file_name)) {
                            $file_exists = 1;
                            $file_content = file_get_contents(SEOSHIELD_ROOT_PATH.'/../'.$file_name);
                        }

                        success_response([
                            'complete' => 'success',
                            'file_exists' => $file_exists,
                            'file_content' => $file_content,
                            'existing' => $existing,
                            'original_content' => $original_content,
                        ]);

                        break;

                    /*
                     * Проверка клиентских файлов
                     */
                    case 'check_client_file':
                        $data->data = json_decode($data->data);

                        $file_name = $data->data->data->file_name;
                        $file_content = $data->data->data->file_content;

                        if (!isset($file_name) || empty($file_name)) {
                            error_response([
                                'error_msg' => 'Пустое имя файла.',
                            ]);
                        }

                        $file_name_correct = 0;
                        $file_content_correct = 0;

                        // проверим есть ли такой файлик
                        if (file_exists(SEOSHIELD_ROOT_PATH.'/../'.$file_name)) {
                            $file_name_correct = 1;

                            // и совпадает ли содержимое
                            if ($file_content == file_get_contents(SEOSHIELD_ROOT_PATH.'/../'.$file_name)) {
                                $file_content_correct = 1;
                            }
                        }

                        success_response([
                            'complete' => 'success',
                            'file_name_correct' => $file_name_correct,
                            'file_content_correct' => $file_content_correct,
                        ]);

                        break;

                    /*
                     * Удаление клиентских файлов
                     */
                    case 'delete_client_file':
                        $data->data = json_decode($data->data);

                        $file_name = $data->data->data->file_name;
                        $existing = $data->data->data->existing;
                        $content_history = $data->data->data->content_history;

                        if (!isset($file_name) || empty($file_name)) {
                            error_response([
                                'error_msg' => 'Пустое имя файла.',
                            ]);
                        }

                        // если файл раньше был на сервере, вернём его в его предыдущее состояние
                        if (1 == $existing) {
                            $original_content = array_shift($content_history);

                            // проверим на возможность записи
                            if (!is_writable(SEOSHIELD_ROOT_PATH.'/../'.$file_name)) {
                                error_response([
                                    'error_msg' => 'Файл не доступен для записи.',
                                ]);
                            }

                            file_put_contents(SEOSHIELD_ROOT_PATH.'/../'.$file_name, $original_content, LOCK_EX);
                            if (!file_exists(SEOSHIELD_ROOT_PATH.'/../'.$file_name)) {
                                error_response([
                                    'error_msg' => 'Не получилось вернуть первоначальное содержимое.',
                                    'file_name' => $file_name,
                                ]);
                            }
                        }
                        // если не было, просто удалим файл
                        else {
                            if (!unlink(SEOSHIELD_ROOT_PATH.'/../'.$file_name)) {
                                error_response([
                                    'error_msg' => 'Не получилось удалить файл.',
                                    'file_name' => $file_name,
                                ]);
                            }
                        }

                        success_response([
                            'complete' => 'success',
                        ]);

                        break;

                    default:
                        error_response('SYNC_DESTINATION_NOT_FOUND');
                        break;
                }
                break;

            /*
             * обновляем данные по клиенту сеошилда
             */
            case 'clear_data':
                $cache_file = SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php';
                $cache_file_time = 0;
                if (file_exists($cache_file)) {
                    $cache_file_time = filemtime($cache_file);
                    $current_data = require $cache_file;
                    $data->data = json_decode($data->data);
                    $cache_new_data = array_keys((array) $data->data->data);
                    foreach ($cache_new_data as $k) {
                        unset($current_data[$k]);
                    }
                    file_put_contents($cache_file, '<?php return '.var_export($current_data, true).';', LOCK_EX);
                    $cache_file_time = filemtime($cache_file);
                    success_response([
                        'complete' => 'success',
                        'cache_file_time' => $cache_file_time,
                    ]);
                }
            break;

            case 'clear_all_data':
                $cache_file = SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php';
                if (file_exists($cache_file)) {
                    $current_data = [];
                    file_put_contents($cache_file, '<?php return '.var_export($current_data, true).';', LOCK_EX);
                    success_response([
                        'complete' => 'success',
                    ]);
                }
            break;

            case 'clear_pages_adverts_all':
            case 'clear_pages_adverts_cache':
                $cache_files = [
                    SEOSHIELD_ROOT_PATH.'/data/pages_adverts/cache',
                    SEOSHIELD_ROOT_PATH.'/data/pages_adverts/pages_adverts_config.php',
                    SEOSHIELD_ROOT_PATH.'/data/pages_adverts/pages_adverts_formatted.cache.php',
                ];

                if ('clear_pages_adverts_all' == $data->command) {
                    $cache_files[] = SEOSHIELD_ROOT_PATH.'/data/pages_adverts/pages_adverts.cache.php';
                }

                foreach ($cache_files as $cache_path) {
                    recursive_rm($cache_path);
                }

                success_response([
                    'complete' => 'success',
                ]);
            break;

            case 'upload_data':
                $client_files_structure = json_decode($data->client_files_structure);

                update_files_structure($client_files_structure, true);

                success_response([
                    'complete' => 'success',
                ]);
            break;

            /*
             * метод для обновления клиента
             */
            case'upload_files':
                $client_files_structure = json_decode($data->client_files_structure);

                update_files_structure($client_files_structure, true);

                success_response([
                    'complete' => 'success',
                ]);
            break;

            /*
             * метод для создания бекапа клиента
             */
            case'get_client_backup':
                $client_files_structure = getDirInfo(SEOSHIELD_ROOT_PATH);
                $files_data = [];
                foreach ($client_files_structure as $i => $r) {
                    if ('file' == $r['type']) {
                        $content = file_get_contents($r['path']);
                        $client_files_structure[$i]['content'] = $content;
                        $client_files_structure[$i]['md5_hash'] = md5($content);
                    }
                }
                success_response([
                    'client_files_structure' => $client_files_structure,
                ]);
            break;

            /*
             * метод для получения информации о системе
             */
            case 'get_info':
                $data = [];

                /*
                 * структура, размер, и права на файлы
                 */
                $data['client_files_structure'] = getDirInfo(SEOSHIELD_ROOT_PATH);

                /*
                 * время на сервере
                 */
                $data['server_unix_time'] = time();
                $data['server_time_zone'] = date_default_timezone_get();

                /*
                 * информация о РНР
                 */
                if (function_exists('phpversion')) {
                    $data['php_version'] = phpversion();
                }

                if (function_exists('get_loaded_extensions')) {
                    $data['php_extensions'] = get_loaded_extensions();
                }

                /*
                 * информация о апаче
                 */
                if (function_exists('apache_get_modules')) {
                    $data['apache_modules'] = apache_get_modules();
                }

                /*
                 * стандартные переенные РНР
                 */
                $data['server_var'] = $_SERVER;

                /**
                 * конфиг клиента.
                 */
                $config = $GLOBALS['SEOSHIELD_CONFIG'];
                unset($config['access_key']);
                $data['seoshield_config'] = $config;

                success_response($data);
            break;
            case 'checksum':
                $data = [];
                $data['current_sum'] = md5_file(__FILE__);
                success_response($data);
                // no break
            case 'sync_template':
                $new_data = [];
                $current_data = [];
                $cache_file = SEOSHIELD_ROOT_PATH.'/data/templates.cache.php';
                $recieved_data = json_decode($data->data, true);
                if (isset($recieved_data['data']['template']['template_name']) && isset($recieved_data['data']['template']['template_html'])) {
                    $new_data[$recieved_data['data']['template']['template_name']] = $recieved_data['data']['template']['template_html'];
                }
                if (sizeof($new_data) > 0) {
                    if (file_exists($cache_file)) {
                        $current_data = require $cache_file;
                    }
                    $new_data = array_merge($current_data, $new_data);
                    file_put_contents(
                        $cache_file,
                        '<?php return '.var_export($new_data, true).';'
                    );
                    success_response([
                        'complete' => 'success',
                    ]);
                }
            break;
            default:
                error_response('COMMAND_NOT_FOUND');
            break;
        }
    } else {
        error_response('BAD_ACCESS');
    }
}