<?php

namespace App\Modules\ProductsDictionary\Controllers\Admin;

use App\Core\AjaxTrait;
use App\Core\AdminController;
use App\Modules\ProductsDictionary\Forms\DictionaryValueForm;
use App\Modules\ProductsDictionary\Models\Dictionary;
use App\Modules\ProductsDictionary\Forms\DictionaryForm;
use App\Modules\ProductsDictionary\Models\DictionaryTranslates;
use App\Modules\ProductsDictionary\Requests\DictionaryValueRequest;
use Illuminate\Http\Request;

class DictionaryController extends AdminController
{
    use AjaxTrait;
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $options = [];
        $dictionary = Dictionary::orderBy('position')->get();
        if (!$dictionary) {
            return $this->successJsonAnswer([
                'options' => $options,
            ]);
        }
        return $this->successJsonAnswer([
            'options' => $options,
        ]);
    }
    
    /**
     * @param Dictionary $feature
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function create(Dictionary $feature)
    {
        $formId = 'add-feature-value';
        return $this->successMfpMessage(view('products_dictionary::admin.values.popup', [
            'title' => trans('products_dictionary::admin.add-value-title'),
            'form' => DictionaryValueForm::make(),
            'validation' => $this->makeValidationJavaScript(
                (new DictionaryValueRequest())->rules(),
                '#' . $formId
            ),
            'formId' => $formId,
            'url' => route('admin.dictionary.store', $feature->id),
        ])->render());
    }
    
    /**
     * @param DictionaryValueRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(DictionaryValueRequest $request)
    {
        $dictionary = (new Dictionary);
        if ($message = $dictionary->createRow($request)) {
            return $this->errorJsonAnswer([
                'notyMessage' => $message,
            ]);
        }
        $dictionaries = Dictionary::all();
        return $this->successJsonAnswer([
            'insert' => view('products_dictionary::admin.values.items', [
                'values' => $dictionaries->fresh()
            ])->render(),
            'mfpClose' => true,
        ]);
    }
    
    /**
     * @param int $value
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function edit($value)
    {
        $dictionary = Dictionary::whereId($value)->firstOrFail();
        $formId = 'edit-feature-value-' . $dictionary->id;
        return $this->successMfpMessage(view('products_dictionary::admin.values.popup', [
            'title' => trans('products_dictionary::admin.update-value-title', [
                'value' => $dictionary->current->name,
            ]),
            'form' => DictionaryValueForm::make($dictionary),
            'validation' => $this->makeValidationJavaScript(
                (new DictionaryValueRequest())->rules(),
                '#' . $formId
            ),
            'formId' => $formId,
            'method' => 'PUT',
            'url' => route('admin.dictionary.update', [$dictionary->id]),
        ])->render());
    }
    
    /**
     * @param DictionaryValueRequest $request
     * @param int $value
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(DictionaryValueRequest $request, $value)
    {
        $dictionaries = Dictionary::all();
        $dictionary = Dictionary::whereId($value)->firstOrFail();
        $values = [];
        $dictionary->data->each(function (DictionaryTranslates $translate) use (&$values) {
            $values[$translate->language] = $translate->slug;
        });
    
        if ($message = $dictionary->updateRow($request)) {
            return $this->errorJsonAnswer([
                'notyMessage' => $message,
            ]);
        }
    
        return $this->successJsonAnswer([
            'insert' => view('products_dictionary::admin.values.items', [
                'values' => $dictionaries->fresh()
            ])->render(),
            'mfpClose' => true,
        ]);
    }
    
    /**
     * @param int $value
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy($value)
    {
        $dictionary = Dictionary::whereId($value)->firstOrFail();
        $dictionary->deleteRow();
        $dictionaries = Dictionary::all();
        event('products_dictionary::value-deleted', $value);
        return $this->successJsonAnswer([
            'insert' => view('products_dictionary::admin.values.items', [
                'values' => $dictionaries->fresh(),
            ])->render(),
            'mfpClose' => true,
        ]);
    }

}
