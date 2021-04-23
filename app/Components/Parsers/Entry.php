<?php

namespace App\Components\Parsers;

use Exception;
use App\Components\Parsers\PromUa\Parser as PromUaParser;
use App\Components\Parsers\YandexMarket\Parser as YandexMarketParser;

/**
 * Class Entry
 *
 * @package App\Components\Parsers
 */
class Entry
{
    const TYPE_PROM_UA = 'prom-ua';
    const TYPE_YANDEX_MARKET = 'yandex-market';
    
    /**
     * @param string|null $type
     * @param string $path
     * @return AbstractParser
     * @throws Exception
     */
    public static function getParser(?string $type, string $path): AbstractParser
    {
        switch ($type) {
            case Entry::TYPE_YANDEX_MARKET:
                return new YandexMarketParser($path);
        
            case Entry::TYPE_PROM_UA:
                return new PromUaParser($path);
        
            default:
                throw new Exception('Wrong parser type!');
        }
    }

}
