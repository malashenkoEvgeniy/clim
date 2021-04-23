<?php

namespace App\Modules\Orders\Controllers\Site\Cart;

use App\Core\AjaxTrait;
use App\Core\SiteController;
use App\Modules\Orders\Requests\CartRequest;
use App\Modules\Orders\Requests\UpdateCartRequest;
use App\Modules\ProductsDictionary\Models\Dictionary;
use App\Modules\ProductsDictionary\Models\DictionaryRelation;
use CustomForm\Select;
use Illuminate\Database\Eloquent\Builder;
use Widget, Cart;

/**
 * Class IndexController
 *
 * @package App\Modules\Orders\Controllers\Site
 */
class AjaxController extends SiteController
{
    use AjaxTrait;
    
    /**
     * @param array $addedProducts
     * @param int|null $dictionaryId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    private function cartStructureInJson(array $addedProducts = [], ?int $dictionaryId = null)
    {
        $cart = Cart::me();
        $totalAmount = Widget::show('products::amount', Cart::getQuantities());
        $totalAmountOld = Widget::show('products::amount-old', Cart::getQuantities());
        $totalQuantity = Cart::getTotalQuantity();
        $briefly = view('orders::site.cart.cart--briefly', [
            'cart' => $cart,
            'totalAmount' => $totalAmount,
        ])->render();
        if ($totalQuantity > 0) {
            $detailed = view('orders::site.cart.cart--detailed', [
                'cart' => $cart,
                'addedProducts' => $addedProducts,
                'dictionaryId' => $dictionaryId,
                'totalAmount' => $totalAmount,
                'totalAmountOld' => $totalAmountOld
            ])->render();
        } else {
            $detailed = view('orders::site.cart.cart--detailed-empty', [
                'cart' => $cart,
            ])->render();
        }
        return $this->successJsonAnswer([
            'html' => [
                'briefly' => $briefly,
                'detailed' => $detailed,
                'checkout' => (string)Widget::show('orders::cart::checkout'),
            ],
            'total_quantity' => $totalQuantity,
            'total_amount' => (float)$totalAmount,
        ]);
    }
    
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function index()
    {
        return $this->cartStructureInJson();
    }
    
    /**
     * Add product to the cart
     *
     * @param CartRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function add(CartRequest $request)
    {
        $productIds = $request->input('product_id', []);
        if (is_array($productIds) === false) {
            $productIds = [$productIds];
        }
        if(!config('db.products_dictionary.site_status')) {
            $dictionaryId = null;
        } else {
            $dictionaryId = $request->input('product_data.dictionary_id');
        }
        $addedProductsIds = [];
        foreach ($productIds as $productId) {
            if ($cartItem = Cart::addItem($productId, 1, $dictionaryId)) {
                $addedProductsIds[] = $cartItem->getProductId();
                $dictionaryId = $cartItem->getDictionaryId();
            }
        }
        return $this->cartStructureInJson($addedProductsIds, $dictionaryId);
    }
    
    /**
     * Delete item from the cart
     *
     * @param CartRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function delete(CartRequest $request)
    {
        $productIds = $request->input('product_id', []);
        $dictionaryId = $request->input('dictionary_id', null);
        if (is_array($productIds) === false) {
            $productIds = [$productIds];
        }
        foreach ($productIds as $productId) {
            Cart::removeItem($productId, $dictionaryId);
        }
        return $this->cartStructureInJson();
    }
    
    /**
     * Update item quantity
     *
     * @param UpdateCartRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function updateQuantity(UpdateCartRequest $request)
    {
        Cart::setQuantity(
            $request->input('product_id'),
            $request->input('product_data.quantity'),
            $request->input('product_data.dictionary_id')
        );
        return $this->cartStructureInJson();
    }
    
    /**
     * Update item dictionary
     *
     * @param UpdateCartRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function updateDictionary(UpdateCartRequest $request)
    {
        Cart::setDictionary(
            $request->input('product_id'),
            $request->input('product_data.old_dictionary_id'),
            $request->input('product_data.dictionary_id')
        );
        return $this->cartStructureInJson();
    }
    
}
