<?php

namespace App\Modules\Export\Controllers\Site;

use App\Core\SiteController;
use Illuminate\Support\Facades\DB;

/**
 * Class GoogleMerchantController
 *
 * @package App\Modules\Export\Controllers\Site
 */
class GMFeedController extends SiteController
{

    public $category_tree = array();
    
    /**
     * Google xml output
     *
     * @return \Illuminate\Http\Response
     */
    public function indexXml()
    {
        $lang = 'ru';

        $cat = DB::select(
            "SELECT categories.id
                FROM categories 
                WHERE active = 1;", []);

        foreach ($cat as $item) {
            //var_dump($item->id); die;
            $categories_arr[]=$item->id;
        }



        $categories_list = $categories_arr;
        $cl_revers = array_flip($categories_list);
        $this->category_tree = array();


        // список id категорий
        foreach ($categories_arr as $category_id) {
            if ($row = DB::selectOne(
                "SELECT cat.id,cat.parent_id, ct.name
                FROM categories as cat
                LEFT JOIN categories_translates as ct
                    ON cat.id = ct.row_id
                    AND ct.language = '$lang'
                WHERE cat.id = $category_id 
                AND active = 1;", [])) {
                $this->category_tree[$category_id] = array();
                $this->category_tree[$category_id]['main'] = $category_id;
                $this->category_tree[$category_id]['name'] = $row->name;
//                $categories_list = array_merge($categories_list, $this->getCategoryTree($row->id ,$category_id,$row->name));


            }
        }
        $ids = join("','",$categories_list);
        $offers = DB::select("SELECT 
            pg.id as pg_id, 
            pg.category_id, 
            pgt.name as title, 
            pgt.text as description, 
            pg.available, 
            p.price, 
            p.old_price,
            bt.name as brand, 
            p.vendor_code as art,
            pt.slug,
            p.id as url_id,
            i.name as img,
            pgfv.value_id as pgfv
          FROM products_groups as pg
          LEFT JOIN products_groups_translates as pgt
            ON pg.id = pgt.row_id
            AND pgt.language = '$lang'
          LEFT JOIN brands_translates as bt
            ON pg.brand_id = bt.row_id
            AND bt.language = '$lang'
          LEFT JOIN products as p
            ON pg.id = p.group_id
          INNER JOIN products_translates as pt
            ON p.id = pt.row_id
            AND pt.language = '$lang'
          INNER JOIN images as i
            ON pg.id = i.imageable_id
          LEFT OUTER JOIN products_groups_features_values as pgfv
            ON p.id = pgfv.product_id
            AND pgfv.feature_id = 253
          WHERE `category_id` 
            IN ('$ids') 
          AND p.active = 1
           ORDER BY p.id ASC;", []);

        return response()->view('export::site.google.gm12_feed_xml', [
            'offers' => $offers,
            'category_tree' => $this->category_tree,
            'cl_revers' => $cl_revers,
        ])->header('Content-Type', 'text/xml');
    }

    public function getCategoryTree($category_id, $main, $name) {
        $cats = array();
        if ($results = DB::select( "SELECT id FROM categories WHERE `parent_id` = $category_id AND active = 1;",[])) {
            foreach( $results as $row ){
                $cats[] = (int)$row->id;
                $new_arr = $this->getCategoryTree((int)$row->id,$main, '');
                if($new_arr) {
                    $cats = array_merge($cats,$new_arr);
                }
                $this->category_tree[(int)$row->id]['main'] = $main;
                $this->category_tree[(int)$row->id]['name'] = $name;
            }
            return $cats;
        } else {
            return false;
        }
    }
}
