<?php

namespace App\Modules\Sitemap\Models;

use App\Core\Modules\Images\Models\Image;
use App\Core\Modules\Languages\Models\Language;
use Illuminate\Database\Eloquent\Collection;

class Sitemap
{

    protected $_tree = [];
    protected $_xmlMap = [];
    protected $_imagesXmlMap = [];

    public function getSitemap()
    {
        if (empty($this->_tree)) {
            $this->buildSitemap();
        }
        return $this->_tree;
    }

    private function buildSitemap()
    {
        array_map(function($item) {
            if (!class_exists($item)) {
                return;
            }
            $provider = new $item([]);
            if (!method_exists($provider, 'initSitemap')) {
                return;
            }
            if ( ($parts = $provider->initSitemap()) && is_array($parts) ) {
                foreach ($parts as $part) {
                    $this->_tree[] = $part;
                }
            }
        }, config('app.providers'));
    }


    public function getSitemapXml()
    {
        if (empty($this->_xmlMap)) {
            $this->buildSitemapXml();
        }
        return $this->_xmlMap;
    }


    private function buildSitemapXml()
    {
        $languages = config('languages', []);
        /** @var Language $language */
        foreach($languages as $language){
            $prefix = $language->default ? '' : '/'.$language->slug;
            $this->_xmlMap[] = [
                'url' => url($prefix . route('site.home', [], false), [], isSecure()),
            ];
        }
        array_map(function($item) {
            if (!class_exists($item)) {
                return;
            }
            $provider = new $item([]);
            if (!method_exists($provider, 'initSitemapXml')) {
                return;
            }
            if ( ($parts = $provider->initSitemapXml()) && is_array($parts) ) {
                foreach ($parts as $part) {
                    $this->_xmlMap[] = $part;
                }
            }
        }, config('app.providers'));
    }


    public function getImagesSitemapXml()
    {
        if (empty($this->_imagesXmlMap)) {
            $this->buildImagesSitemapXml();
        }
        return $this->_imagesXmlMap;
    }


    private function buildImagesSitemapXml()
    {
        Image::all()->chunk(500)->each(function (Collection $collection) use (&$images){
            $collection->load('current')->each(function (Image $image) use (&$images){
                if (!class_exists($image->imageable_class)) {
                    return;
                }
                $keeper = new $image->imageable_class();
                if (!method_exists($keeper, 'getPagesLinksByIdForImage')) {
                    return;
                }
                if(!$links = $keeper->getPagesLinksByIdForImage($image->imageable_id)){
                    return;
                }
                foreach($links as $link){
                    $this->_imagesXmlMap[$link][] = [
                        'image' => $image->link(),
                    ];
                }

            });
        });
    }

}
