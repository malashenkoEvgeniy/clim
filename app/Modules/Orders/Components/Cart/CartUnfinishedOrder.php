<?php

namespace App\Modules\Orders\Components\Cart;

use App\Modules\Orders\Models\CartUnfinishedOrder as CartUnfinishedOrderModel;
use Illuminate\Database\Eloquent\Model;
use Exception;

/**
 * Class CartItem
 *
 * @package App\Modules\Orders\Facades
 */
class CartUnfinishedOrder
{
    
    /**
     * Cart item model
     *
     * @var Model|CartUnfinishedOrderModel
     */
    protected $model;
    
    public function store(int $cartId, array $information): bool
    {
        $object = $this->model ?: new CartUnfinishedOrderModel();
        $object->cart_id = $cartId;
        $object->information = $information;
        return $object->save();
    }
    
    /**
     * Returns cart item model from database
     *
     * @return Model|null
     */
    public function getModel(): ?Model
    {
        return $this->model;
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
     * Order additional information
     *
     * @return array
     */
    public function getInformation(): array
    {
        return ($this->model && $this->model->exists) ? $this->model->information : [];
    }
    
}