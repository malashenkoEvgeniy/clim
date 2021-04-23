<?php

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

// метод который выполняется перед запуском CMS
function seo_shield_start_cms()
{
    list($usec, $sec) = explode(' ', microtime());
    $GLOBALS['SEOSHIELD_CMS_START_TIME'] = (float) $usec + (float) $sec;
    $GLOBALS['SEOSHIELD_DATA']['template_data'] = [];

    seo_shield_load_modules();

    if (function_exists('header')) {
        @header('SeoShieldClient: v=0.01');
    }

    foreach ($GLOBALS['SEOSHIELD_MODULES'] as $module_name => $module) {
        if (method_exists($module, 'start_cms')) {
            $module->start_cms();
        }
    }
}

// метод который должен пропускать через себя итоговый HTML
function seo_shield_out_buffer($out_html)
{
    if (!isset($GLOBALS['SEOSHIELD_MODULES'])) {
        seo_shield_load_modules();
    }

    $currentH1 = "";
	preg_match('#<h1[^>]*?>(.*?)<\/h1>#s', $out_html, $finder);
	if (isset($finder[0]) && !empty($finder[1])){
		$currentH1 = strip_tags($finder[1]);
		$currentH1 = trim($currentH1);
	}
	$out_html = str_replace('</body>', '<!--ss_category_name:'.$currentH1.'--></body>', $out_html);

    foreach ($GLOBALS['SEOSHIELD_MODULES'] as $module_name => $module) {
        if (method_exists($module, 'html_out_buffer')) {
            $out_html = $module->html_out_buffer($out_html);
        }
    }

    // если страница продвигаемая
    $landing = '';
    $config_uri = '';
    if (isset($GLOBALS['SEOSHIELD_CONFIG']) && isset($GLOBALS['SEOSHIELD_CONFIG']['page_url'])) {
        $config_uri = '<!--URI:'.var_export($GLOBALS['SEOSHIELD_CONFIG']['page_url'], true).'-->';
    }
    if (file_exists(SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php')) {
        $text_static = include SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php';
        if (is_array($text_static)) {
            if (array_key_exists($GLOBALS['SEOSHIELD_CONFIG']['page_url'], $text_static)) {
                $landing = '<!--seo_shield_landing_page-->';
            }
        }
    }

    $out_html = str_replace('</body>', $config_uri.$landing.'<!--{seo_shield_out_buffer}--></body>', $out_html);

    return $out_html;
}

/*
 *	метод который в массив шилда добавляет переменные с шаблона
 */
function seo_shield_set_data($where_params)
{
    if (is_array($where_params)) {
        $GLOBALS['SEOSHIELD_DATA']['template_data'] += $where_params;
    }
}

class InitGenerateContent
{
    private $start_txt = '';
    private $end_txt = '';

    public function init_hash($hash)
    {
        if (strlen($hash) > 0) {
            $this->start_txt = '<!--{ss_api_content_start:'.$hash.':ss_api_content_start}-->';
            $this->end_txt = '<!--{ss_api_content_end:'.$hash.':ss_api_content_end}-->';
        }
    }

    public function start()
    {
        echo $this->start_txt;
    }

    public function get_start()
    {
        return $this->start_txt;
    }

    public function end()
    {
        echo $this->end_txt;
    }

    public function get_end()
    {
        return $this->end_txt;
    }
}

/*
 *	метод вызывается в шаблонах в разных местах, собирает данные для генерации контента
 *	если по текущему хэшу есть текст - пропускаем его
 *	метод возвращает экземпляр класса у которого надо вызвать 2 метода start и end
 *	они рисуют комменты, которые потом заменятся сгенереным или подтянутым с кэша контентом
 */
function seo_shield_init_generate_content($where_params)
{
    $init_gen_content = new InitGenerateContent();

    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        return $init_gen_content;
    }

    if (isset($GLOBALS['SEOSHIELD_CONFIG']['enabled_modules'])) {
        if (!in_array('api_generate_content', $GLOBALS['SEOSHIELD_CONFIG']['enabled_modules'])) {
            return $init_gen_content;
        }
    } elseif (isset($GLOBALS['SEOSHIELD_CONFIG']['disabled_modules'])) {
        if (false !== in_array('api_generate_content', $GLOBALS['SEOSHIELD_CONFIG']['disabled_modules'])) {
            return $init_gen_content;
        }
    }

    if (!isset($where_params['type'])
        || (empty($GLOBALS['SEOSHIELD_CONFIG']['access_key']) && empty($GLOBALS['SEOSHIELD_CONFIG']['access_keys'][0]))
        || empty($GLOBALS['SEOSHIELD_CONFIG']['api_pager'])) {
        return $init_gen_content;
    }

    $template_res = null;
    if (isset($where_params['template'])) {
        $template_res = $where_params['template'];
        unset($where_params['template']);
    }
    $dynamic_markers = [];
    if (isset($where_params['dynamic_markers'])) {
        $dynamic_markers = $where_params['dynamic_markers'];
        unset($where_params['dynamic_markers']);
    }

    $hash = md5($GLOBALS['SEOSHIELD_CONFIG']['page_hash'].serialize($where_params));
    $GLOBALS['SEOSHIELD_DATA']['api_generate_content_options'][$hash]['template'] = $template_res;
    $init_gen_content->init_hash($hash);

    if (!isset($GLOBALS['SEOSHIELD_DATA']['api_generate_content'][$hash])) {
        unset($where_params['for_hash']);
        $send_data = [];
        $send_data['markers'] = [];
        if (isset($where_params['markers']) && sizeof($where_params['markers']) > 0) {
            $send_data['markers'] += $where_params['markers'];
        }
        if (sizeof($dynamic_markers) > 0) {
            $send_data['markers'] += $dynamic_markers;
        }
        $GLOBALS['SEOSHIELD_DATA']['init_api_generate_content'][$where_params['type']][$hash] = $send_data;
    }

    return $init_gen_content;
}

class seoShieldDb
{
    public $type;
    public $link;

    public function __construct($config)
    {
        $charsets = [
            'utf-8' => 'utf8',
            'windows-1251' => 'cp1251',
        ];

        $this->type = 'mysqli';
        if ('mysql' == $config['type']) {
            $this->type = 'mysql';
        }

        if ('mysql' == $this->type) {
            $this->link = mysql_connect($config['host'], $config['user'], $config['password'], true);
            if ($this->link) {
                mysql_select_db($config['db'], $this->link);
                mysql_set_charset(str_replace(array_keys($charsets), array_values($charsets), $config['encoding']), $this->link);
            }
        } else {
            $this->link = mysqli_connect($config['host'], $config['user'], $config['password'], $config['db']);
            if ($this->link) {
                mysqli_set_charset($this->link, str_replace(array_keys($charsets), array_values($charsets), $config['encoding']));
            }
        }
    }

    public function mysql_query($q)
    {
        if ('mysql' == $this->type) {
            return mysql_query($q, $this->link);
        } else {
            return mysqli_query($this->link, $q);
        }
    }

    public function mysql_num_rows($res)
    {
        if ('mysql' == $this->type) {
            return mysql_num_rows($res);
        } else {
            return mysqli_num_rows($res);
        }
    }

    public function mysql_fetch_array($res)
    {
        if ('mysql' == $this->type) {
            return mysql_fetch_array($res);
        } else {
            return mysqli_fetch_array($res);
        }
    }

    public function mysql_fetch_assoc($res)
    {
        if ('mysql' == $this->type) {
            return mysql_fetch_assoc($res);
        } else {
            return mysqli_fetch_assoc($res);
        }
    }

    public function mysql_escape_string_s($res)
    {
        if ('mysql' == $this->type) {
            return mysql_escape_string($res);
        } else {
            return mysqli_real_escape_string($this->link, $res);
        }
    }
}

// метод загружает модули
function seo_shield_load_modules()
{
    // подключаемся к базе
    if (isset($GLOBALS['SEOSHIELD_CONFIG']['mysql'])
        && !is_object($GLOBALS['SEOSHIELD_CONFIG']['mysql'])
        && !empty($GLOBALS['SEOSHIELD_CONFIG']['mysql']['db'])) {
        if (empty($GLOBALS['SEOSHIELD_CONFIG']['mysql']['encoding'])) {
            $GLOBALS['SEOSHIELD_CONFIG']['mysql']['encoding'] = $GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'];
        }
        $GLOBALS['SEOSHIELD_CONFIG']['mysql'] = new seoShieldDb($GLOBALS['SEOSHIELD_CONFIG']['mysql']);
    }

    $GLOBALS['SEOSHIELD_MODULES'] = [];

    $module_files = [];
    foreach (glob(SEOSHIELD_ROOT_PATH.'/core/modules/*.php') as $module_file) {
        $module_files[substr(basename($module_file), 0, -4)] = $module_file;
    }

    $module_files_sorted = [];
    if (isset($GLOBALS['SEOSHIELD_CONFIG']['modules_ordering'])) {
        foreach ($GLOBALS['SEOSHIELD_CONFIG']['modules_ordering'] as $module_name) {
            if (!isset($module_files[$module_name])) {
                continue;
            }

            $module_files_sorted[$module_name] = $module_files[$module_name];
            unset($module_files[$module_name]);
        }
    }
    $module_files_sorted = array_merge($module_files_sorted, $module_files);

    foreach ($module_files_sorted as $module_file) {
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['enabled_modules'])) {
            if (!in_array(substr(preg_replace("#^[0-9]+\.#", '', basename($module_file)), 0, -4), $GLOBALS['SEOSHIELD_CONFIG']['enabled_modules'])) {
                continue;
            }
        } elseif (isset($GLOBALS['SEOSHIELD_CONFIG']['disabled_modules'])) {
            if (sizeof($GLOBALS['SEOSHIELD_CONFIG']['disabled_modules']) > 0
                && in_array(substr(preg_replace("#^[0-9]+\.#", '', basename($module_file)), 0, -4), $GLOBALS['SEOSHIELD_CONFIG']['disabled_modules'])) {
                continue;
            }
        }

        include_once $module_file;

        $module_file_name = basename($module_file);
        if (is_numeric(substr($module_file_name, 0, 1))) {
            $module_file_name = preg_replace("#^[0-9]+\.#is", '', $module_file_name);
        }

        if ('!' == substr($module_file_name, 0, 1)) {
            continue;
        }

        //$module_name=rtrim($module_file_name,".php");
        $module_name = basename($module_file_name, '.php');

        if (!class_exists('SeoShieldModule_'.$module_name)) {
            continue;
        }

        $module_config_file = SEOSHIELD_ROOT_PATH.'/modules/'.basename($module_file_name);

        if (file_exists($module_config_file)) {
            include_once $module_config_file;
            $module_class_name = 'SeoShieldModule_'.$module_name.'_config';
        } else {
            $module_class_name = 'SeoShieldModule_'.$module_name;
        }

        $GLOBALS['SEOSHIELD_MODULES'][$module_name] = new $module_class_name();
    }
}