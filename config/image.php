<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */
    
    'driver' => 'gd',
    
    /**
     * Watermark defaults
     */
    'watermark' => [
        'name' => 'watermark.png', // Path via storage folder to the watermark
        'x' => 15, // Offset over image by X
        'y' => 0, // Offset over image by Y
    ],
    
    'max-size' => 8 * 1024,

];
