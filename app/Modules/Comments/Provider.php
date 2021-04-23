<?php

namespace App\Modules\Comments;

use App\Components\Menu\Block;
use App\Components\Settings\SettingsGroup;
use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Comments\Models\Comment;
use App\Modules\Comments\Widgets\Site\ProductReviewForm;
use App\Modules\Comments\Widgets\Site\ProductReviews;
use App\Modules\Products\Models\ProductGroup;
use Carbon\Carbon;
use CustomForm\Input;
use CustomSettings, CustomRoles, CustomMenu, Widget;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Index
 */
class Provider extends BaseProvider
{
    
    private $morphMap = [
        'groups' => ProductGroup::class,
    ];
    
    /**
     * Set custom presets
     */
    protected function presets()
    {
        // Register morph relations to comments module
        Relation::morphMap($this->morphMap);
        // Add relation to User model
        $userModel = config('auth.providers.users.model');
        if ($userModel) {
            $userModel::addExternalMethod('comments', function () {
                return $this->hasMany(Comment::class, 'user_id', 'id');
            });
        }
        // Add `comments` relation to registered classes
        foreach ($this->morphMap as $type => $className) {
            // Add relation
            $className::addExternalMethod('comments', function () {
                return $this->morphMany(Comment::class, 'commentable')
                    ->where('active', true)
                    ->where('published_at', '<=', Carbon::now());
            });
        }
    }
    
    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('comments', 'comments::general.settings-name');
        $settings->add(
            Input::create('admin-name')
                ->setDefaultValue('Administrator')
                ->required()
        );
        if (count($this->morphMap) > 0) {
            $menuBlock = CustomMenu::get()
                ->group()
                ->block('comments', 'comments::menu.block', 'glyphicon glyphicon-comment');
            foreach ($this->morphMap as $type => $className) {
                $this->registerCommentsToModule($menuBlock, $settings, $type);
            }
        }
        // TODO Update role system with abilities for partial role system like in this module
        CustomRoles::add('comments', 'comments::general.permission-name')
            ->except(RoleRule::VIEW);
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        Widget::register(ProductReviews::class, 'comments::product-reviews');
        Widget::register(ProductReviewForm::class, 'comments::product-review-form');
    }
    
    /**
     * Add relation to comments module
     *
     * @param  Block $menuBlock
     * @param  SettingsGroup $settings
     * @param  string $type
     * @throws \App\Exceptions\WrongParametersException
     */
    final private function registerCommentsToModule(Block $menuBlock, SettingsGroup $settings, string $type)
    {
        // Menu
        $menuBlock
            ->link("comments::menu.$type", RouteObjectValue::make('admin.comments.index', ['type' => $type]))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.comments.edit', ['type' => $type]),
                RouteObjectValue::make('admin.comments.create', ['type' => $type])
            );
        // Settings
        $settings->add(
            Input::create("$type-per-page")->setLabel("comments::settings.$type.per-page"),
            ['required', 'integer', 'min:1']
        );
        $settings->add(
            Input::create("$type-per-page-site")->setLabel("comments::settings.$type.per-page-site"),
            ['required', 'integer', 'min:1']
        );
    }
    
}
