<?php

namespace App\Modules\Orders\Components\Cart;

use App\Modules\Orders\Models\CartItem as CartItemModel;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Exception;

/**
 * Class CartItem
 *
 * @package App\Modules\Orders\Facades
 */
class CartItem
{
    
    /**
     * Cart item model
     *
     * @var Model|CartItemModel
     */
    protected $model;
    
    /**
     * Returns cart item model from database
     *
     * @return Model|\App\Modules\Orders\Models\CartItem|null
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }
    
    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        if (!$this->model || !$this->model->product) {
            return null;
        }
        return $this->model->product;
    }
    
    /**
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->getProduct() && $this->getProduct()->active && $this->getProduct()->is_available;
    }
    
    /**
     * Adds cart item model to the object
     *
     * @param Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }
    
    /**
     * Deletes current item
     *
     * @throws Exception
     */
    public function delete(): void
    {
        $this->model->delete();
    }
    
    /**
     * Sets quantity to item
     *
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->model->quantity = $quantity;
        $this->model->save();
    }

    /**
     * Sets dictionary to item
     *
     * @param int $dictionaryId
     */
    public function setDictionary(int $dictionaryId): void
    {
        $this->model->dictionary_id = $dictionaryId;
        $this->model->save();
    }
    
    /**
     * Add quantity to the item
     *
     * @param int $quantity
     * @throws Exception
     */
    public function increment(int $quantity = 1): void
    {
        if (!$this->model) {
            throw new Exception('Cart item model does not exist!');
        }
        $this->setQuantity($this->getQuantity() + $quantity);
    }
    
    /**
     * Add quantity to the item
     *
     * @param int $quantity
     * @throws Exception
     */
    public function decrement(int $quantity = 1): void
    {
        if (!$this->model) {
            throw new Exception('Cart item model does not exist!');
        }
        $newQuantity = $this->getQuantity() - $quantity;
        if ($newQuantity > 0) {
            $this->setQuantity($newQuantity);
        } else {
            Cart::removeItem($this->getProductId());
        }
    }
    
    /**
     * Returns product quantity
     *
     * @return int
     */
    public function getQuantity(): int
    {
        if ($this->getProduct()->is_available) {
            return $this->model->quantity ?: 0;
        }
        return 0;
    }
    
    /**
     * Returns product id
     *
     * @return int
     */
    public function getProductId(): int
    {
        return $this->model->product_id;
    }
    /**
     * Returns product id
     *
     * @return int|null
     */
    public function getDictionaryId(): ?int
    {
        return $this->model->dictionary_id ?? null;
    }
    
    /**
     * Create item model and link product to it
     *
     * @param int $cartId
     * @param int $productId
     * @param int $quantity
     * @param int|null $dictionaryId
     * @return Model
     */
    public function create(int $cartId, int $productId, int $quantity = 1, $dictionaryId = null): Model
    {
        if(isset($dictionaryId)){
            $item = CartItemModel::create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'cart_id' => $cartId,
                'dictionary_id' => $dictionaryId,
            ]);
        } else {
            $item = CartItemModel::create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'cart_id' => $cartId,
            ]);
        }
        $this->model = $item;
        return $item;
    }
    
}
