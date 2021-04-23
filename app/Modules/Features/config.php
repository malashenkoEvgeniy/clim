<?php

use App\Modules\Features\Models\Feature;

return [
    'types' => [
        Feature::TYPE_SINGLE => 'features::general.types.single',
        Feature::TYPE_MULTIPLE => 'features::general.types.multiple',
    ],
];
