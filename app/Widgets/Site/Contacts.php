<?php

namespace App\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Exceptions\WrongParametersException;

/**
 * Class Contacts
 *
 * @package App\Widgets\Site
 */
class Contacts implements AbstractWidget
{
    
    /**
     * @var string
     */
    protected $place;
    
    /**
     * Contacts constructor.
     *
     * @param string $place
     * @throws WrongParametersException
     */
    public function __construct(string $place = 'header')
    {
        if ($place !== 'header' && $place !== 'footer') {
            throw new WrongParametersException('$place could be only `footer` or `header`');
        }
        $this->place = $place;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $additions = [];
        if (config('db.basic.phone_number_1')) {
            $additions[] = (object) [
                'text_content' => config('db.basic.phone_number_1'),
                'href' => '+' . preg_replace("/[^,.0-9]/", '', config('db.basic.phone_number_1')),
                'description' => null
            ];
        }
        if (config('db.basic.phone_number_2')) {
            $additions[] = (object) [
                'text_content' => config('db.basic.phone_number_2'),
                'href' => '+' . preg_replace("/[^,.0-9]/", '', config('db.basic.phone_number_2')),
                'description' => null
            ];
        }
        if (config('db.basic.phone_number_3')) {
            $additions[] = (object) [
                'text_content' => config('db.basic.phone_number_3'),
                'href' => '+' . preg_replace("/[^,.0-9]/", '', config('db.basic.phone_number_3')),
                'description' => null
            ];
        }
        if (config('db.basic.hot_line')) {
            $main = (object) [
                'text_content' => config('db.basic.hot_line'),
                'href' => preg_replace("/[^,.0-9]/", '', config('db.basic.hot_line')),
                'description' => __('site_menu::site.free-for-all-phones')
            ];
        }
        if (config('db.basic.site_email')) {
            $mail = (object) [
                'text_content' => config('db.basic.site_email'),
                'href' => config('db.basic.site_email'),
            ];
        }
        return view('site-custom.static.' . $this->place, [
            'main' => $main ?? null,
            'additions' => $additions,
            'schedule' => config('db.basic.schedule'),
            'mail' => $mail ?? null,
        ]);
    }

}
