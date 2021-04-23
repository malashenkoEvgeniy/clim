<?php

use App\Components\Image\Watermark;

return [
    'watermark-positions' => [
        Watermark::POSITION_TOP_LEFT => 'settings::watermark.position.top-left',
        Watermark::POSITION_TOP => 'settings::watermark.position.top',
        Watermark::POSITION_TOP_RIGHT => 'settings::watermark.position.top-right',
        Watermark::POSITION_LEFT => 'settings::watermark.position.left',
        Watermark::POSITION_CENTER => 'settings::watermark.position.center',
        Watermark::POSITION_RIGHT => 'settings::watermark.position.right',
        Watermark::POSITION_BOTTOM_LEFT => 'settings::watermark.position.bottom-left',
        Watermark::POSITION_BOTTOM => 'settings::watermark.position.bottom',
        Watermark::POSITION_BOTTOM_RIGHT => 'settings::watermark.position.bottom-right',
    ],
];
