<?php

use Illuminate\Database\Seeder;
use Faker\Factory AS Fake;

class CatalogSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        die;
        // \App\Modules\Products\Models\Product::truncate();
        // \App\Modules\Categories\Models\Category::truncate();
        // \App\Modules\Brands\Models\Brand::truncate();
        // \App\Modules\Features\Models\Feature::truncate();
        // \App\Modules\Comments\Models\Comment::truncate();
        
        $faker = Fake::create();
        $languages = \App\Core\Modules\Languages\Models\Language::all();
        $categories = $this->fillCategoriesAndReturnIds($languages);
        $brands = $this->fillBrandsAndReturnIds($languages);
        $featuresAndValues = $this->fillFeaturesAndValuesAndReturnIds($languages, $faker);
        $images = $this->getAvailableImages();
        
        for ($i = 0; $i < 10000; $i++) {
            try {
                $product = new \App\Modules\Products\Models\Product();
                $price = random_int(50, 60000);
                $oldPrice = random_int(50, 60000);
                $product->fill([
                    'price' => $price,
                    'old_price' => $oldPrice > $price ? $oldPrice : null,
                    'active' => (bool)random_int(0, 10),
                    'available' => (bool)random_int(0, 10),
                    'vendor_code' => 'new-product-' . $i,
                    'position' => 500,
                ]);
                $product->save();
                
                $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($faker, $product) {
                    $translate = new \App\Modules\Products\Models\ProductTranslates();
                    $name = $faker->text(random_int(10, 60));
                    $translate->fill([
                        'name' => $name,
                        'slug' => \Illuminate\Support\Str::slug($name) . '-' . $language->slug . '-' . random_int(10000, 999999),
                    ]);
                    $translate->row_id = $product->id;
                    $translate->language = $language->slug;
                    $translate->save();
                });
                
                $pc = new \App\Modules\Products\Models\ProductCategory();
                $pc->fill([
                    'product_id' => $product->id,
                    'category_id' => array_random($categories),
                    'main' => true,
                ]);
                $pc->save();
                
                $brandId = array_random($brands);
                $pc = new \App\Modules\Products\Models\ProductBrand();
                $pc->fill([
                    'product_id' => $product->id,
                    'brand_id' => $brandId,
                ]);
                $pc->save();
                
                foreach ($featuresAndValues as $featureId => $valuesIds) {
                    if (random_int(0, 5) > 0) {
                        continue;
                    }
                    foreach ((array)array_random($valuesIds, count($valuesIds) > 1 ? random_int(1, 2) : null) as $valueId) {
                        \App\Modules\Products\Models\ProductFeatureValue::link($product, $featureId, $valueId);
                    }
                }
                
                $this->addComments($product->id, $faker);
                
                if (count($images) > 0 && (bool)random_int(0, 4)) {
                    foreach (array_random($images, random_int(1, 6)) as $imageName) {
                        $image = new \App\Core\Modules\Images\Models\Image();
                        $image->imageable_class = \App\Modules\Products\Models\Product::class;
                        $image->imageable_id = $product->id;
                        $image->imageable_type = 'products';
                        $image->basename = $imageName;
                        $image->name = $imageName;
                        $image->mime = 'image/jpeg';
                        $image->ext = 'jpeg';
                        $image->size = 1000;
                        $image->save();
                    }
                }
            } catch (Exception $exception) {
                $this->command->alert($exception->getMessage());
            }
        }
    }
    
    /**
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     * @return array
     */
    private function fillCategoriesAndReturnIds($languages): array
    {
        $categories = [
            [
                'name' => 'Ноутбуки и компьютеры',
                'slug' => 'noutbuki-i-kompyutery',
                'active' => true,
            ],
            [
                'name' => 'Массажные кресла',
                'slug' => 'massazhnye-kresla',
                'active' => true,
            ],
            [
                'name' => 'Телевизоры',
                'slug' => 'televizory',
                'active' => true,
            ],
            [
                'name' => 'Смартфоны',
                'slug' => 'smartfony',
                'active' => true,
            ],
            [
                'name' => 'Бытовая техника',
                'slug' => 'bytovaya-tekhnika',
                'active' => true,
                'children' => [
                    [
                        'name' => 'Стиральные машины',
                        'slug' => 'stiralnye-mashiny',
                        'active' => true,
                    ],
                    [
                        'name' => 'Холодильники',
                        'slug' => 'kholodilniki',
                        'active' => true,
                    ],
                    [
                        'name' => 'Кухонные плиты',
                        'slug' => 'kukhonnye-plity',
                        'active' => true,
                    ],
                ],
            ],
            [
                'name' => 'Товары для дома',
                'slug' => 'tovary-dlya-doma',
                'active' => true,
            ],
            [
                'name' => 'Спорт и увлечения',
                'slug' => 'sport-i-uvlecheniya',
                'active' => true,
                'children' => [
                    [
                        'name' => 'Велосипеды',
                        'slug' => 'velosipedy',
                        'active' => true,
                    ],
                    [
                        'name' => 'Зимние виды спорта',
                        'slug' => 'zimnie-vidy-sporta',
                        'active' => true,
                    ],
                ],
            ],
        ];
        $ids = [];
        foreach ($categories as $position => $data) {
            $ids = array_merge($ids, (array)$this->addCategory($data, $languages, null, $position));
        }
        return $ids;
    }
    
    /**
     * @param array $data
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     * @param int|null $parentId
     * @param int $position
     * @return array
     */
    private function addCategory(array $data, $languages, ?int $parentId = null, $position = 0): array
    {
        $ids = [];
        
        $category = new \App\Modules\Categories\Models\Category();
        $category->active = $data['active'];
        $category->parent_id = $parentId;
        $category->position = $position;
        $category->save();
        
        $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($category, $data) {
            $translate = new \App\Modules\Categories\Models\CategoryTranslates();
            $translate->fill([
                'name' => $data['name'] . ($language->default ? '' : ' ' . $language->name),
                'slug' => $data['slug'] . ($language->default ? '' : '-' . $language->slug),
            ]);
            $translate->row_id = $category->id;
            $translate->language = $language->slug;
            $translate->save();
        });
        
        if (!isset($data['children'])) {
            $ids[] = $category->id;
        } else {
            foreach ($data['children'] as $position => $child) {
                $ids = array_merge($ids, (array)$this->addCategory($child, $languages, $category->id, $position));
            }
        }
        
        return $ids;
    }
    
    /**
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     * @return array
     */
    private function fillBrandsAndReturnIds($languages): array
    {
        $brands = [
            ['name' => 'Akai', 'slug' => 'akai'],
            ['name' => 'Apple', 'slug' => 'apple'],
            ['name' => 'Asus', 'slug' => 'asus'],
            ['name' => 'Google', 'slug' => 'google'],
            ['name' => 'HP', 'slug' => 'hp'],
            ['name' => 'Lenovo', 'slug' => 'lenovo'],
            ['name' => 'LG', 'slug' => 'lg'],
            ['name' => 'Panasonic', 'slug' => 'panasonic'],
            ['name' => 'Phillips', 'slug' => 'phillips'],
            ['name' => 'Samsung', 'slug' => 'samsung'],
            ['name' => 'Sony', 'slug' => 'sony'],
        ];
        $ids = [];
        foreach ($brands as $position => $data) {
            $brand = new \App\Modules\Brands\Models\Brand();
            $brand->active = true;
            $brand->save();
            
            $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($brand, $data) {
                $translate = new \App\Modules\Brands\Models\BrandTranslates();
                $translate->fill([
                    'name' => $data['name'] . ($language->default ? '' : ' ' . $language->name),
                    'slug' => $data['slug'] . ($language->default ? '' : '-' . $language->slug),
                ]);
                $translate->row_id = $brand->id;
                $translate->language = $language->slug;
                $translate->save();
            });
            
            $ids[] = $brand->id;
        }
        return $ids;
    }
    
    /**
     * @param \Faker\Generator $faker
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     * @return array
     * @throws Exception
     */
    private function fillFeaturesAndValuesAndReturnIds($languages, $faker): array
    {
        $featuresAndValues = [];
        for ($i = 0; $i < 50; $i++) {
            $feature = new \App\Modules\Features\Models\Feature();
            $feature->active = (bool)random_int(0, 10);
            $feature->in_filter = (bool)random_int(0, 4);
            $feature->main = (bool)random_int(0, 1);
            $feature->save();
            
            $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($feature, $faker) {
                $translate = new \App\Modules\Features\Models\FeatureTranslates();
                $name = $faker->text(random_int(6, 35));
                $translate->fill([
                    'name' => $name,
                    'slug' => \Illuminate\Support\Str::slug($name) . '-' . $language->slug . '-' . random_int(10000, 999999),
                ]);
                $translate->row_id = $feature->id;
                $translate->language = $language->slug;
                $translate->save();
            });
            
            $featuresAndValues[$feature->id] = [];
            
            for ($j = 0; $j < random_int(3, 10); $j++) {
                $value = new \App\Modules\Features\Models\FeatureValue();
                $value->feature_id = $feature->id;
                $value->active = true;
                $value->save();
                
                $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($value, $faker) {
                    $translate = new \App\Modules\Features\Models\FeatureValueTranslates();
                    $name = $faker->text(random_int(6, 35));
                    $translate->fill([
                        'name' => $name,
                        'slug' => \Illuminate\Support\Str::slug($name) . '-' . $language->slug . '-' . random_int(10000, 999999),
                    ]);
                    $translate->row_id = $value->id;
                    $translate->language = $language->slug;
                    $translate->save();
                });
                
                $featuresAndValues[$feature->id][] = $value->id;
            }
        }
        return $featuresAndValues;
    }
    
    /**
     * @param int $productId
     * @param \Faker\Generator $faker
     * @throws Exception
     */
    private function addComments(int $productId, $faker): void
    {
        if (random_int(0, 3) === 0) {
            return;
        }
        for ($i = 0; $i < random_int(1, 10); $i++) {
            $comment = new \App\Modules\Comments\Models\Comment();
            $comment->fill([
                'name' => $faker->name,
                'email' => $faker->email,
                'comment' => $faker->text(),
                'active' => (bool)random_int(0, 10),
                'published_at' => $faker->dateTime(),
                'mark' => random_int(0, 5) ?: null,
            ]);
            $comment->commentable_type = 'products';
            $comment->commentable_id = $productId;
            $comment->save();
        }
    }
    
    /**
     * @return array
     */
    private function getAvailableImages(): array
    {
        $images = [];
        foreach (scandir(storage_path('app/public/products/original')) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $images[] = $file;
        }
        return $images;
    }
}
