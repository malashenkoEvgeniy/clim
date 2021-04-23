<?php

use Illuminate\Database\Seeder;

class RestoreDemoDataSeeder extends Seeder
{
    private $folder;

    /**
     * @throws Throwable
     * @throws \App\Exceptions\WrongParametersException
     */
    public function run()
    {
        $this->folder = storage_path('app/' . app()->environment());
        if (is_dir($this->folder) === false) {
            $this->folder = storage_path('app/demo');
        }
        if (is_dir($this->folder) === false) {
            $this->command->info('Can not fill database with fake data! No files to proceed');
            die;
        }

        \App\Modules\Products\Models\Product::query()->delete();
        \App\Modules\Products\Models\ProductGroup::query()->delete();
        \App\Modules\Products\Models\ProductGroupFeatureValue::query()->delete();
        \App\Modules\LabelsForProducts\Models\Label::query()->delete();
        \App\Modules\Categories\Models\Category::query()->delete();
        \App\Modules\Brands\Models\Brand::query()->delete();
        \App\Modules\Features\Models\Feature::query()->delete();
        \App\Modules\Comments\Models\Comment::query()->delete();
        \App\Modules\SlideshowSimple\Models\SlideshowSimple::query()->delete();
        \App\Modules\News\Models\News::query()->delete();
        \App\Modules\Articles\Models\Article::query()->delete();
        \App\Modules\Pages\Models\Page::query()->delete();
        \App\Modules\SiteMenu\Models\SiteMenu::query()->delete();
        \App\Components\Settings\Models\Setting::query()->delete();

        $this->removeFiles();

        $languages = \App\Core\Modules\Languages\Models\Language::all();
        $this->fillSlider($languages);
        $this->fillArticles($languages);
        $this->fillNews($languages);
        $this->loadFiles();
        $this->loadPages($languages);
        $this->loadSystemPages();
        $this->loadMenu($languages);
        $this->loadSettings();
        $this->loadLogo();
        $labels = $this->loadLabels($languages);
        $categories = $this->fillCategoriesAndReturnIds($languages);
        $brands = $this->fillBrandsAndReturnIds($languages);
        $this->fillProducts($categories, $brands, $labels, $languages);
        $this->updateFeaturesType();

        if (isProd()) {
            File::deleteDirectory($this->folder);
        }
    }

    /**
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     * @return array
     */
    private function loadLabels($languages): array
    {
        $file = $this->folder . '/data/labels.php';
        if (is_file($file) === false) {
            $this->command->info("Can not load file $file");
            return [];
        }
        $labels = require $file;
        $labelsIds = [];
        foreach ($labels as $data) {
            $label = new \App\Modules\LabelsForProducts\Models\Label();
            $label->fill([
                'active' => true,
                'color' => $data['color'],
            ])->save();
            $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($label, $data) {
                $translate = new \App\Modules\LabelsForProducts\Models\LabelTranslates();
                $translate->fill([
                    'name' => $data['name'],
                    'slug' => \Illuminate\Support\Str::slug($data['name']),
                    'text' => $data['text'],
                ]);
                $translate->row_id = $label->id;
                $translate->language = $language->slug;
                $translate->save();
            });
            $labelsIds[] = $label->id;
        }
        return $labelsIds;
    }

    private function updateFeaturesType(): void
    {
        $featuresIds = [];
        \App\Modules\Products\Models\ProductGroupFeatureValue::select(['product_id', 'feature_id'])
            ->groupBy(['product_id', 'feature_id'])
            ->having(DB::raw('COUNT(value_id)'), '>', 1)
            ->get()
            ->each(function (\App\Modules\Products\Models\ProductGroupFeatureValue $featureValue) use (&$featuresIds) {
                $featuresIds[] = $featureValue->feature_id;
            });
        \App\Modules\Features\Models\Feature::whereIn('id', $featuresIds)->update([
            'type' => \App\Modules\Features\Models\Feature::TYPE_MULTIPLE,
        ]);
    }

    private function loadSettings(): void
    {
        $file = $this->folder . '/data/settings.php';
        if (is_file($file) === false) {
            $this->command->info("Can not load file $file");
            return;
        }
        $settings = require $file;
        foreach ($settings as $data) {
            \App\Components\Settings\Models\Setting::create($data);
        }
    }

    private function loadLogo(): void
    {
        $logo = storage_path('app/demo/logo.png');
        if (is_file($logo)) {
            copy($logo, storage_path(preg_replace('/\/{2,}/', '/', 'app/public/' . config('app.logo.path') . '/' . config('app.logo.filename'))));
        }
        $logo = storage_path('app/demo/logo--mobile.png');
        if (is_file($logo)) {
            copy($logo, storage_path(preg_replace('/\/{2,}/', '/', 'app/public/' . config('app.logo-mobile.path') . '/' . config('app.logo-mobile.filename'))));
        }
    }

    private function removeFiles(): void
    {
        $path = storage_path('app/public');
        foreach (scandir($path) as $item) {
            if ($item === '.' || $item === '..' || $item === '.gitignore') {
                continue;
            }
            $element = $path . '/' . $item;
            if (is_dir($element)) {
                File::deleteDirectory($element);
            } else if(is_file($element)) {
                File::delete($element);
            }
        }
    }

    private function loadFiles(): void
    {
        File::copyDirectory($this->folder . '/files', storage_path('app/public/files'));
    }

    private function loadSystemPages(): void
    {
        $file = $this->folder . '/data/system-pages.php';
        if (is_file($file) === false) {
            $this->command->info("Can not load file $file");
            return;
        }
        $pages = require $file;
        foreach ($pages as $slug => $data) {
            \App\Core\Modules\SystemPages\Models\SystemPageTranslates::whereSlug($slug)
                ->get()->each(function (\App\Core\Modules\SystemPages\Models\SystemPageTranslates $translate) use ($data) {
                    $translate->name = $data['name'];
                    $translate->content = $data['content'] ?? null;
                    $translate->keywords = $data['keywords'] ?? null;
                    $translate->description = $data['description'] ?? null;
                    $translate->title = $data['title'] ?? null;
                    $translate->h1 = $data['h1'] ?? null;
                    $translate->save();
                });
        }
    }

    /**
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     */
    private function loadMenu($languages): void
    {
        $file = $this->folder . '/data/pages.php';
        if (is_file($file) === false) {
            $this->command->info("Can not load file $file");
            return;
        }
        $pages = require $file;
        $i = 0;
        foreach ($pages as $slug => $data) {
            foreach (config('site_menu.places', []) as $place) {
                $menu = new \App\Modules\SiteMenu\Models\SiteMenu();
                $menu->active = true;
                $menu->noindex = false;
                $menu->nofollow = false;
                $menu->parent_id = null;
                $menu->place = $place;
                $menu->position = $i++;
                $menu->save();

                $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($menu, $data) {
                    $translate = new \App\Modules\SiteMenu\Models\SiteMenuTranslates();
                    $translate->fill([
                        'name' => $data['name'],
                        'slug' => $data['slug'],
                        'slug_type' => 'internal',
                    ]);
                    $translate->row_id = $menu->id;
                    $translate->language = $language->slug;
                    $translate->save();
                });
            }
        }
    }

    /**
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     */
    private function loadPages($languages): void
    {
        $file = $this->folder . '/data/pages.php';
        if (is_file($file) === false) {
            $this->command->info("Can not load file $file");
            return;
        }
        $pages = require $file;
        foreach ($pages as $position => $data) {
            $page = new \App\Modules\Pages\Models\Page();
            $page->active = true;
            $page->position = $position;
            $page->menu = $data['menu'] ?? null;
            $page->save();
            $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($page, $data) {
                $translate = new \App\Modules\Pages\Models\ServicesRubricTranslates();
                $translate->fill([
                    'name' => $data['name'],
                    'slug' => $data['slug'] ?? \Illuminate\Support\Str::slug($data['name']),
                    'content' => $data['content'] ?? null,
                    'h1' => $data['h1'] ?? null,
                    'title' => $data['title'] ?? null,
                    'keywords' => $data['keywords'] ?? null,
                    'description' => $data['description'] ?? null,
                ]);
                $translate->row_id = $page->id;
                $translate->language = $language->slug;
                $translate->save();
            });
        }
    }

    /**
     * @param array $categories
     * @param array $brands
     * @param array $labels
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     * @throws Throwable
     * @throws \App\Exceptions\WrongParametersException
     */
    private function fillProducts(array $categories, array $brands, array $labels, $languages): void
    {
        $features = [];

        $file = $this->folder . '/data/products.php';
        if (is_file($file) === false) {
            $this->command->info("Can not load file $file");
            return;
        }
        $data = require $file;
        foreach ($data as $i => $datum) {
            $mainFeatureId = null;
            $mainFeatureValuesIds = [];
            $otherFeatures = [];
            // Features
            foreach (array_get($datum, 'features', []) as $featureName => $featureValues) {
                if (isset($features[$featureName])) {
                    $featureId = $features[$featureName]['id'];
                } else {
                    $feature = new \App\Modules\Features\Models\Feature();
                    $feature->active = true;
                    $feature->type = \App\Modules\Features\Models\Feature::TYPE_SINGLE;
                    $feature->in_filter = (bool)random_int(0, 4);
                    $feature->main = (bool)random_int(0, 1);
                    $feature->save();
                    $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($feature, $featureName) {
                        $translate = new \App\Modules\Features\Models\FeatureTranslates();
                        $translate->fill([
                            'name' => $featureName,
                            'slug' => \Illuminate\Support\Str::slug($featureName),
                        ]);
                        $translate->row_id = $feature->id;
                        $translate->language = $language->slug;
                        $translate->save();
                    });
                    $features[$featureName] = ['id' => $feature->id, 'values' => []];
                    $featureId = $feature->id;
                }
                $valuesIds = [];
                foreach ($featureValues as $valueName) {
                    if (isset($features[$featureName]['values'][$valueName])) {
                        $valueId = $features[$featureName]['values'][$valueName];
                        $valuesIds[] = $valueId;
                    } else {
                        $value = new \App\Modules\Features\Models\FeatureValue();
                        $value->feature_id = $featureId;
                        $value->active = true;
                        $value->save();

                        $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($value, $valueName) {
                            $translate = new \App\Modules\Features\Models\FeatureValueTranslates();
                            $translate->fill([
                                'name' => $valueName,
                                'slug' => \Illuminate\Support\Str::slug($valueName),
                            ]);
                            $translate->row_id = $value->id;
                            $translate->language = $language->slug;
                            $translate->save();
                        });

                        $features[$featureName]['values'][$valueName] = $value->id;
                        $valuesIds[] = $value->id;
                    }
                }
                if (!$mainFeatureId) {
                    $mainFeatureId = $featureId;
                    $mainFeatureValuesIds = $valuesIds;
                } else {
                    $otherFeatures[$featureId] = $valuesIds;
                }
            }
            $group = new \App\Modules\Products\Models\ProductGroup();
            $group->position = 500;
            $group->brand_id = isset($datum['brand']) && isset($brands[$datum['brand']]) ? $brands[$datum['brand']] : null;
            $group->category_id = isset($datum['category']) && isset($categories[$datum['category']]) ? $categories[$datum['category']] : null;
            $group->active = $group->category_id ? true : false;
            $group->feature_id = $mainFeatureId;
            $group->saveOrFail();
            // Add category to remote table
            if ($group->category_id) {
                $group->syncOtherCategories([], $group->category_id);
            }
            // Product group translates
            foreach (config('languages', []) as $languageAlias => $language) {
                $translate = new \App\Modules\Products\Models\ProductGroupTranslates();
                $translate->name = $datum['name'];
                $translate->text = $datum['text'] ?? null;
                $translate->row_id = $group->id;
                $translate->language = $languageAlias;
                $translate->save();
            }
            // Labels
            if (count($labels) > 0 && (bool)random_int(0, 1)) {
                $group->syncLabels(array_random($labels, random_int(1, count($labels))));
            }
            // Products
            $prices = [];
            foreach ($mainFeatureValuesIds as $index => $valueId) {
                $price = $datum['price'] * (1 + $index * 0.05);
                $prices[] = $price;
                $oldPrice = (bool)random_int(0, 1) ? ceil($price * (1 + random_int(5, 60) / 100)) : null;
                $product = new \App\Modules\Products\Models\Product();
                $product->active = $group->active;
                $product->brand_id = $group->brand_id;
                $product->available = (bool)random_int(0, 10);
                $product->price = $price;
                $product->old_price = $oldPrice;
                $product->vendor_code = $datum['vendor_code'] ?? 'new-product-' . $i;
                $product->position = 500;
                $product->group_id = $group->id;
                $product->is_main = !$index;
                $product->value_id = $valueId;
                $product->saveOrFail();
                // Product translates
                foreach (config('languages', []) as $languageAlias => $language) {
                    $nameParts = [];
                    if ($product->brand) {
                        $nameParts[] = $product->fresh()->brand->current->name;
                    }
                    $nameParts[] = $datum['name'];
                    if ($product->value) {
                        $nameParts[] = $product->fresh()->value->current->name;
                    }
                    $translate = new \App\Modules\Products\Models\ProductTranslates();
                    $translate->name = '';
                    $translate->hidden_name = implode(' ', $nameParts);
                    $translate->slug = \Illuminate\Support\Str::slug($translate->hidden_name);
                    $translate->row_id = $product->id;
                    $translate->language = $languageAlias;
                    $translate->save();
                }
                \App\Modules\Products\Models\ProductGroupFeatureValue::link($group, $product, $mainFeatureId, $valueId);
                // Link other features
                foreach ($otherFeatures as $otherFeatureId => $otherValueIds) {
                    foreach ($otherValueIds as $otherValueId) {
                        \App\Modules\Products\Models\ProductGroupFeatureValue::link($group, $product, $otherFeatureId, $otherValueId);
                    }
                }
            }
            $group->updatePrices();
            // Images
            $folder = $this->folder . "/products/{$datum['category']}";
            if (is_dir($folder)) {
                $images = array_filter(scandir($folder), function ($file) {
                    return $file !== '.' && $file !== '..';
                });
                if (empty($images)) {
                    continue;
                }
                $maxCount = 5;
                if (count($images) < $maxCount) {
                    $maxCount = count($images);
                }
                foreach (array_random($images, random_int(1, $maxCount)) as $file) {
                    $group->uploadImageFromResource(new \Illuminate\Http\UploadedFile($folder . '/' . $file, $file));
                }
            }
        }
    }

    /**
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     * @return array
     * @throws \App\Exceptions\WrongParametersException
     */
    private function fillCategoriesAndReturnIds($languages): array
    {
        $file = $this->folder . '/data/categories.php';
        if (is_file($file) === false) {
            $this->command->info("Can not load file $file");
            return [];
        }
        $categories = require $file;
        $result = [];
        foreach ($categories as $position => $data) {
            $result += $this->addCategory($data, $languages, null, $position);
        }
        return $result;
    }

    /**
     * @param array $data
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     * @param int|null $parentId
     * @param int $position
     * @return array
     * @throws \App\Exceptions\WrongParametersException
     */
    private function addCategory(array $data, $languages, ?int $parentId = null, $position = 0): array
    {
        $category = new \App\Modules\Categories\Models\Category();
        $category->active = true;
        $category->parent_id = $parentId;
        $category->position = $position;
        $category->save();

        if (isset($data['image'])) {
            $nameParts = explode('/', $data['image']);
            $originalName = end($nameParts);
            $category->uploadImageFromResource(new \Illuminate\Http\UploadedFile($this->folder . '/' . $data['image'], $originalName));
        }

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

        $result = [$data['slug'] => $category->id];
        if (isset($data['children'])) {
            foreach ($data['children'] as $position => $child) {
                $result += $this->addCategory($child, $languages, $category->id, $position);
            }
        }
        return $result;
    }

    /**
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     * @return array
     * @throws \App\Exceptions\WrongParametersException
     */
    private function fillBrandsAndReturnIds($languages): array
    {
        $result = [];
        $file = $this->folder . '/data/brands.php';
        if (is_file($file) === false) {
            $this->command->info("Can not load file $file");
            return [];
        }
        $brands = require $file;
        foreach ($brands as $position => $data) {
            $brand = new \App\Modules\Brands\Models\Brand();
            $brand->active = true;
            $brand->save();

            if (isset($data['image']) && is_file($this->folder . '/' . $data['image'])) {
                $nameParts = explode('/', $data['image']);
                $originalName = end($nameParts);
                $brand->uploadImageFromResource(new \Illuminate\Http\UploadedFile($this->folder . '/' . $data['image'], $originalName));
            }

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

            $result[$data['slug']] = $brand->id;
        }
        return $result;
    }

    /**
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     * @throws \App\Exceptions\WrongParametersException
     */
    private function fillSlider($languages): void
    {
        $file = $this->folder . '/data/slider.php';
        if (is_file($file) === false) {
            $this->command->info("Can not load file $file");
            return;
        }
        $slider = require $file;
        foreach ($slider as $position => $data) {
            $slide = new \App\Modules\SlideshowSimple\Models\SlideshowSimple();
            $slide->active = true;
            $slide->save();

            if (isset($data['image']) && is_file($this->folder . '/' . $data['image'])) {
                $nameParts = explode('/', $data['image']);
                $originalName = end($nameParts);
                $slide->uploadImageFromResource(new \Illuminate\Http\UploadedFile($this->folder . '/' . $data['image'], $originalName));
            }

            $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($slide, $data) {
                $translate = new \App\Modules\SlideshowSimple\Models\SlideshowSimpleTranslates();
                $translate->fill([
                    'name' => $data['name'],
                ]);
                $translate->row_id = $slide->id;
                $translate->language = $language->slug;
                $translate->save();
            });
        }
    }

    /**
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     * @throws \App\Exceptions\WrongParametersException
     */
    private function fillArticles($languages): void
    {
        $file = $this->folder . '/data/articles.php';
        if (is_file($file) === false) {
            $this->command->info("Can not load file $file");
            return;
        }
        $articles = require $file;
        foreach ($articles as $position => $data) {
            $article = new \App\Modules\Articles\Models\Article();
            $article->active = true;
            $article->save();

            if (isset($data['image']) && is_file($this->folder . '/' . $data['image'])) {
                $nameParts = explode('/', $data['image']);
                $originalName = end($nameParts);
                $article->uploadImageFromResource(new \Illuminate\Http\UploadedFile($this->folder . '/' . $data['image'], $originalName));
            }

            $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($article, $data) {
                $translate = new \App\Modules\Articles\Models\ArticleTranslates();
                $translate->fill([
                    'name' => $data['name'],
                    'slug' => \Illuminate\Support\Str::slug($data['name']),
                    'content' => $data['content'],
                    'short_content' => $data['short_content'],
                ]);
                $translate->row_id = $article->id;
                $translate->language = $language->slug;
                $translate->save();
            });
        }
    }

    /**
     * @param \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages
     * @throws \App\Exceptions\WrongParametersException
     */
    private function fillNews($languages): void
    {
        $file = $this->folder . '/data/news.php';
        if (is_file($file) === false) {
            $this->command->info("Can not load file $file");
            return;
        }
        $articles = require $file;
        foreach ($articles as $position => $data) {
            $article = new \App\Modules\News\Models\News();
            $article->active = true;
            $article->published_at = $data['date'];
            $article->save();

            if (isset($data['image']) && is_file($this->folder . '/' . $data['image'])) {
                $nameParts = explode('/', $data['image']);
                $originalName = end($nameParts);
                $article->uploadImageFromResource(new \Illuminate\Http\UploadedFile($this->folder . '/' . $data['image'], $originalName));
            }

            $languages->each(function (\App\Core\Modules\Languages\Models\Language $language) use ($article, $data) {
                $translate = new \App\Modules\News\Models\NewsTranslates();
                $translate->fill([
                    'name' => $data['name'],
                    'slug' => \Illuminate\Support\Str::slug($data['name']),
                    'content' => $data['content'],
                    'short_content' => $data['short_content'],
                ]);
                $translate->row_id = $article->id;
                $translate->language = $language->slug;
                $translate->save();
            });
        }
    }
}
