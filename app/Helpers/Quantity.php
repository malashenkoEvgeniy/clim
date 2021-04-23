<?php namespace App\Helpers;

/**
 * Class Quantity
 *
 * @package App\Helpers
 */
class Quantity
{
    
    /**
     * Kilobytes to Megabytes calculator
     *
     * @param  int $kilobytes
     * @return float
     */
    public static function getMbFromKb(int $kilobytes)
    {
        return (float)number_format((int)$kilobytes / 1024, 2, '.', '');
    }
    
    /**
     * Bytes to Megabytes calculator
     *
     * @param  int $bytes
     * @return float
     */
    public static function getMbFromBytes(int $bytes)
    {
        return (float)number_format((int)$bytes / (1024 * 1024), 2, '.', '');
    }
    
}
