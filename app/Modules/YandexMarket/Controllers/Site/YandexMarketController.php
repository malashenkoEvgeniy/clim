<?php

namespace App\Modules\YandexMarket\Controllers\Site;

use App\Core\SiteController;
use App\Modules\YandexMarket\Models\YandexMarket;
use Carbon\Carbon;

/**
 * Class YandexMarketController
 *
 * @package App\Modules\YandexMarket\Controllers\Site
 */
class YandexMarketController extends SiteController
{
    
    /**
     * Yandex xml output
     *
     * @return \Illuminate\Http\Response
     */
    public function indexXml()
    {
        $model = new YandexMarket;
        $offers = $model->getYandexOffersXml();
        return response()->view('yandex_market::site.xml', [
            'offers' => $offers,
            'date' => $offers->isNotEmpty() ? $offers->max('updated_at') : Carbon::now(),
            'categories' => $model->getYandexCategoriesXml(),
            'currencies' => $model->getCurrencies(),
        ])->header('Content-Type', 'text/xml');
    }

}
