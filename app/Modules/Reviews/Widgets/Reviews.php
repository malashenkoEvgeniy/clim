<?php

namespace App\Modules\Reviews\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Reviews\Models\Review;

class Reviews implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $reviews = Review::forWidget();
        if (!$reviews || !$reviews->count()) {
            return null;
        }
        $bg = 'app/public/' . config('db.reviews.background');
        $bg = storage_path($bg);
        if (is_file($bg)) {
            $image = url('storage/' . config('db.reviews.background'));
        } else {
            $image = site_media('static/images/reviews/bg.jpg', true);
        }
        return view('reviews::site.widget', [
            'reviews' => $reviews,
            'image' => $image,
        ]);
    }
    
}
