<?php

namespace SiteHelpers;

class SvgSpritemap
{
    /**
     * @var string Путь к SVG спрайту
     */
    private static $path = null;
    
    public static function symbolsList()
    {
        $path = site_media('assets/svg/spritemap.svg');
        $content = file_get_contents(public_path('site' . $path));
        preg_match_all('/id="([^"]*)"/i', $content, $matches);
        return array_get($matches, 1, []);
    }
    
    /**
     * @param string $symbol_id
     * @param array $attributes
     * @return string
     */
    private static function render($symbol_id, $attributes = [])
    {
        $href = self::$path . '#' . $symbol_id;
        $attrs = [];
        foreach ($attributes as $name => $value) {
            array_push($attrs, $name . '="' . $value . '"');
        }
        return '<svg ' . implode(' ', $attrs) . '><use xlink:href="' . $href . '"></use></svg>';
    }
    
    /**
     * @param string $symbol_id
     * @param array $svg_attributes
     * @param bool $absolute
     * @return string
     */
    public static function get($symbol_id, $svg_attributes = [], $absolute = false)
    {
        if (self::$path === null) {
            self::$path = site_media('assets/svg/spritemap.svg', true, false, $absolute);
        }
        
        $attributes = array_replace_recursive(['class' => 'svg-icon'], $svg_attributes);
        return self::render($symbol_id, $attributes);
    }
}
