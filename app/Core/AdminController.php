<?php

namespace App\Core;

use App\Core\ObjectValues\RouteObjectValue;
use App\Helpers\Alert;
use App\Widgets\Admin\HeaderButton;
use Widget, Route, CustomRoles;
use Illuminate\Database\Eloquent\Model;

class AdminController extends Controller
{
    
    /**
     * Adds create button to top of the page
     *
     * @param string $route
     * @param array $parameters
     */
    protected function addCreateButton(string $route, array $parameters = [])
    {
        list(, $module, $action) = explode('.', $route);
        if (CustomRoles::can($module, $action)) {
            Widget::register(
                new HeaderButton(
                    RouteObjectValue::make($route, $parameters),
                    __('admin.buttons.create'),
                    ['bg-olive', 'margin']
                ),
                'add-button',
                'header-buttons'
            );
        }
    }
    
    /**
     * Adds list button to top of the page
     *
     * @param string $route
     * @param array $parameters
     */
    protected function addListButton(string $route, array $parameters = [])
    {
        list(, $module, $action) = explode('.', $route);
        if (CustomRoles::can($module, $action)) {
            Widget::register(
                new HeaderButton(
                    RouteObjectValue::make($route, $parameters),
                    __('admin.buttons.list'),
                    'bg-orange'
                ),
                'list-button',
                'header-buttons'
            );
        }
    }
    
    /**
     * Adds deleted list button to top of the page
     *
     * @param string $route
     * @param array $parameters
     */
    protected function addDeletedListButton(string $route, array $parameters = [])
    {
        list(, $module, $action) = explode('.', $route);
        if (CustomRoles::can($module, $action)) {
            Widget::register(
                new HeaderButton(
                    RouteObjectValue::make($route, $parameters),
                    __('admin.buttons.deleted'),
                    'bg-red'
                ),
                'deleted-button',
                'header-buttons'
            );
        }
    }
    
    /**
     * Leave message and redirect user
     *
     * @param  string $route
     * @param  array $routeParameters
     * @param  string $message
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function customRedirect(string $route, array $routeParameters = [], string $message)
    {
        // Success message
        Alert::success($message);
        // Redirect back
        return redirect()->route($route, $routeParameters);
    }
    
    /**
     * Leave message and redirect user
     *
     * @param  array $parameters
     * @param  string|null $message
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterStore(array $parameters = [], ?string $message = null)
    {
        // Success message
        Alert::success($message ?? 'admin.messages.data-created');
        // Redirect back
        return $this->redirect($parameters);
    }
    
    /**
     * Failed operation
     *
     * @param null|string $message
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterFail(?string $message = null)
    {
        // Success message
        Alert::danger($message ?? 'admin.messages.fail');
        // Redirect back
        return back()->withInput();
    }
    
    /**
     * Leave message and redirect user
     *
     * @param  array $parameters
     * @param  string|null $message
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterUpdate(array $parameters = [], string $message = null)
    {
        // Success message
        Alert::success($message ?? 'admin.messages.data-updated');
        // Redirect back
        return $this->redirect($parameters);
    }
    
    /**
     * Leave message and redirect user
     *
     * @param  string|null $message
     * @param  string|null $customRedirect
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterDestroy(string $message = null, ?string $customRedirect = null)
    {
        // Success message
        Alert::success($message ?? 'admin.messages.data-destroyed');
        // Redirect back
        return $customRedirect ? redirect($customRedirect) : redirect()->back();
    }
    
    /**
     * Leave message and redirect user
     *
     * @param  string|null $message
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterRestore(string $message = null)
    {
        return $this->afterDestroy($message ?? 'admin.messages.data-restored');
    }
    
    /**
     * Leave message and redirect user
     *
     * @param  string|null $message
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterDeletingImage(?string $message = null)
    {
        return $this->afterDestroy($message ?? 'admin.messages.image-deleted');
    }
    
    /**
     * Redirect administrator to the page he choose
     *
     * @param  array $parameters
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function redirect(array $parameters = [])
    {
        list(, $module, $action) = explode('.', Route::currentRouteName());
        if (array_key_exists('submit_only', request()->input())) {
            if ($action === 'store') {
                return redirect(route("admin.$module.edit", $parameters));
            }
            return redirect()->back();
        } elseif (array_key_exists('submit_close', request()->input())) {
            if (array_key_exists('id', $parameters)) {
                unset($parameters['id']);
            }
            return redirect(route("admin.$module.index", $parameters));
        } elseif (array_key_exists('submit_add', request()->input())) {
            if (array_key_exists('id', $parameters)) {
                unset($parameters['id']);
            }
            return redirect(route("admin.$module.create", $parameters));
        }
        return redirect()->back();
    }
    
    /**
     * Sort elements in model you need
     *
     * @param string $className
     */
    protected function saveSortable(string $className)
    {
        $data = json_decode(request()->input('json'), true);
        if (!$data) {
            return;
        }
        $elements = $className::all()->mapWithKeys(function ($element) {
            return [$element->id => $element];
        });
        $this->recursiveSortable($elements, $data);
    }
    
    /**
     * Recursively save parent_id and position
     *
     * @param Model[] $elements
     * @param array $data
     * @param int $parentId
     */
    private function recursiveSortable($elements, array $data, $parentId = 0)
    {
        $position = 0;
        foreach ($data as $datum) {
            $element = array_get($elements, $datum['id']);
            if (!$element) {
                continue;
            }
            $element->position = $position++;
            if (array_key_exists('parent_id', $element->getAttributes())) {
                $element->parent_id = $parentId;
            }
            $element->save();
            if (array_get($datum, 'children')) {
                $this->recursiveSortable($elements, $datum['children'], $element->id);
            }
        }
    }
    
    /**
     * Action to change active status of a model
     *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function active($id)
    {
        $modelName = request()->query('class');
        abort_unless($modelName, 404);
        $element = $modelName::findOrFail($id);
        if (array_key_exists('active', $element->getAttributes())) {
            $element->active = !$element->active;
            $element->save();
        }
        return response()->json(['success' => true]);
    }
    
    /**
     * Sortable method + nested tree
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sortable()
    {
        $modelName = request()->query('class');
        abort_unless($modelName, 404);
        $this->saveSortable($modelName);
        return response()->json();
    }
    
}
