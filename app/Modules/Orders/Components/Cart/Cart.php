<?php

namespace App\Modules\Orders\Components\Cart;

use App\Modules\Orders\Models\Cart as CartModel;
use App\Modules\Orders\Models\CartItem as CartItemModel;
use App\Modules\Orders\Models\CartUnfinishedOrder as UnfinishedOrderModel;
use App\Modules\Products\Models\Product;
use App\Modules\ProductsDictionary\Models\Dictionary;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Exception, Cookie, Hash;

/**
 * Class Cart
 *
 * @package App\Modules\Orders\Facades
 */
class Cart
{
    const CART_ALIAS = 'cart';
    
    /**
     * @var Model
     */
    protected $model;
    
    /**
     * Items inside the cart
     *
     * @var Collection|CartItem[]
     */
    protected $items;
    
    /**
     * Items inside the cart
     *
     * @var CartUnfinishedOrder|null
     */
    protected $unfinishedOrder;
    
    /**
     * CartAbstraction constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->items = new Collection();
        $this->create();
    }
    
    /**
     * @return Cart
     */
    public function me(): self
    {
        return $this;
    }
    
    /**
     * Returns model of the cart from the database
     *
     * @return Model|null
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }
    
    /**
     * Returns all items inside the cart
     *
     * @return CartItem[]|Collection
     */
    public function getItems(): Collection
    {
        return $this->items->filter(function (CartItem $cartItem) {
            return $cartItem->isAvailable();
        });
    }
    
    /**
     * Returns new cart hash
     * Stores unique hash key of the cart to cookies
     *
     * @return string
     * @throws Exception
     */
    public function create(): string
    {
        $cartHash = array_get($_COOKIE, self::CART_ALIAS);
        if ($cartHash) {
            $this->createFromHash($cartHash);
            return $cartHash;
        }
        return $this->createNew();
    }
    
    /**
     * Will create cart and cart items instances from the existed data
     *
     * @param string $hash
     * @return string
     * @throws Exception
     */
    private function createFromHash(string $hash): string
    {
        $cart = CartModel::whereHash($hash)->first();
        if (!$cart) {
            return $this->createNew();
        }
        $this->model = $cart;
        
        $this->fillItemsList();
        $this->restoreUnfinishedOrder();
        
        return $hash;
    }
    
    /**
     * Creates new cart instance
     *
     * @return string
     * @throws Exception
     */
    private function createNew(): string
    {
        /** @var CartModel $cart */
        $cart = new CartModel();
        $cart->hash = Hash::make(microtime() . random_int(1, 999999));
        $cart->save();
        
        $this->model = $cart;
        
        setcookie(self::CART_ALIAS, $cart->hash, time() + 2628000, '/');
        
        return $cart->hash;
    }
    
    /**
     * Adds product to the cart
     * Add $quantity to the existed cart item or creates new
     *
     * @param int $productId
     * @param int $quantity
     * @param int|null $dictionaryId
     * @return CartItem|null
     * @throws Exception
     */
    public function addItem(int $productId, int $quantity = 1, ?int $dictionaryId = null): ?CartItem
    {
        // Check product availability
        $product = Product::find($productId);
        if (!$product || !$product->active || !$product->is_available) {
            return null;
        }
        if (!$dictionaryId && config('db.products_dictionary.site_status')) {
            $status = config('db.products_dictionary.select_status');
            if ($status) {
                $dictionary = Dictionary::orderBy('position')->first();
            } else {
                $dictionary = Dictionary::whereHas('relations', function (Builder $builder) use ($product) {
                    $builder->where('group_id', $product->id);
                })->orderBy('position')->first();
            }
            if ($dictionary) {
                $dictionaryId = $dictionary->id;
            }
        }
        // Add product to the cart
        if ($this->hasItem($productId, $dictionaryId)) {
            $item = $this->addToExistedItem($productId, $quantity, $dictionaryId);
        } else {
            $item = $this->createItem($productId, $quantity, $dictionaryId);
        }
        return $item;
    }
    
    /**
     * Checks if cart has product inside it
     *
     * @param int $productId
     * @param int|null $dictionaryId
     * @return bool
     */
    public function hasItem(int $productId, ?int $dictionaryId = null): bool
    {
        foreach ($this->items as $item) {
            if ($item->getProductId() === $productId && $item->getDictionaryId() === $dictionaryId) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Returns cart item object by product id
     *
     * @param int $productId
     * @param null $dictionaryId
     * @return CartItem|null
     */
    public function getItem(int $productId, ?int $dictionaryId = null): ?CartItem
    {
        foreach ($this->items as $item) {
            if ($item->getProductId() === $productId && $item->getDictionaryId() === $dictionaryId) {
                return $item;
            }
        }
        return null;
    }
    
    /**
     * Removes item by product id
     *
     * @param int $productId
     * @param int|null $dictionaryId
     * @throws Exception
     */
    public function removeItem(int $productId, $dictionaryId): void
    {
        foreach ($this->items as $index => $item) {
            if ($item->getProductId() === $productId) {
                if (isset($dictionaryId)) {
                    if ($item->getDictionaryId() === $dictionaryId) {
                        $this->items->forget($index);
                        $item->delete();
                        break;
                    }
                } else {
                    $this->items->forget($index);
                    $item->delete();
                    break;
                }
            }
        }
    }
    
    /**
     * Sets new quantity value to the item
     *
     * @param int $productId
     * @param int $quantity
     * @param int|null $dictionaryId
     */
    public function setQuantity(int $productId, int $quantity = 1, ?int $dictionaryId = null): void
    {
        foreach ($this->items as $index => $item) {
            if ($item->getProductId() !== $productId) {
                continue;
            }
            if (!$dictionaryId) {
                $item->setQuantity($quantity);
                break;
            }
            if ($item->getDictionaryId() === $dictionaryId) {
                $item->setQuantity($quantity);
                break;
            }
        }
    }
    
    /**
     * Sets new quantity value to the item
     *
     * @param int $productId
     * @param int|null $dictionaryIdOld
     * @param int|null $dictionaryId
     * @throws Exception
     */
    public function setDictionary(int $productId, ?int $dictionaryIdOld, ?int $dictionaryId = null): void
    {
        foreach ($this->items as $index => $item) {
            if ($item->getProductId() !== $productId) {
                continue;
            }
            if ($item->getDictionaryId() === $dictionaryIdOld) {
                if ($this->hasItem($productId, $dictionaryId)) {
                    $otherItem = $this->getItem($productId, $dictionaryId);
                    $otherItem->increment($item->getQuantity());
                    \Cart::removeItem($productId, $dictionaryIdOld);
                } else {
                    $item->setDictionary($dictionaryId);
                }
                break;
            }
        }
    }
    
    /**
     * Removes cart from the database & cookies
     *
     * @throws Exception
     */
    public function delete(): void
    {
        $this->items = new Collection();
        if ($this->model && $this->model->exists) {
            $this->model->delete();
            $this->model = null;
        }
        Cookie::forget(static::CART_ALIAS);
    }
    
    /**
     * Returns total quantity of the cart items
     *
     * @return int
     */
    public function getTotalQuantity(): int
    {
        $totalCount = 0;
        $this->getItems()->each(function (CartItem $cartItem) use (&$totalCount) {
            $totalCount += $cartItem->getQuantity();
        });
        return $totalCount;
    }
    
    /**
     * @return array
     */
    public function getQuantities(): array
    {
        $quantities = [];
        $this->getItems()->each(function (CartItem $cartItem) use (&$quantities) {
            $quantities[$cartItem->getProductId()] = (isset($quantities[$cartItem->getProductId()])) ? $quantities[$cartItem->getProductId()] + $cartItem->getQuantity() : $cartItem->getQuantity();
        });
        return $quantities;
    }
    
    /**
     * @param CartUnfinishedOrder|null $unfinishedOrder
     */
    public function setUnfinishedOrder(?CartUnfinishedOrder $unfinishedOrder): void
    {
        $this->unfinishedOrder = $unfinishedOrder;
    }
    
    /**
     * @return CartUnfinishedOrder|null
     */
    public function getUnfinishedOrder(): ?CartUnfinishedOrder
    {
        return $this->unfinishedOrder;
    }
    
    /**
     * @return bool
     */
    public function hasUnfinishedOrder(): bool
    {
        return $this->unfinishedOrder !== null;
    }
    
    /**
     * @param int $productId
     * @param int $quantity
     * @return CartItem
     * @throws Exception
     */
    protected function addToExistedItem(int $productId, int $quantity = 1, $dictionaryId = null): CartItem
    {
        $cartItem = $this->getItem($productId, $dictionaryId);
        $cartItem->increment($quantity);
        
        return $cartItem;
    }
    
    /**
     * @param int $productId
     * @param int $quantity
     * @return CartItem
     */
    protected function createItem(int $productId, int $quantity = 1, $dictionaryId = null): CartItem
    {
        $cartItem = new CartItem;
        $cartItem->create($this->model->id, $productId, $quantity, $dictionaryId);
        $this->items->push($cartItem);
        
        return $cartItem;
    }
    
    protected function fillItemsList(): void
    {
        $cartInstance = $this;
        /** @var CartModel $cart */
        $cart = $this->model;
        $cart->items->each(function (CartItemModel $item) use (&$cartInstance) {
            $cartItem = new CartItem();
            $cartItem->setModel($item);
            $cartInstance->items->push($cartItem);
        });
    }
    
    protected function restoreUnfinishedOrder(): void
    {
        /** @var CartModel $cart */
        $cart = $this->model;
        if ($cart->unfinishedOrder) {
            $unfinishedOrder = new CartUnfinishedOrder();
            $unfinishedOrder->setModel($cart->unfinishedOrder);
            $this->setUnfinishedOrder($unfinishedOrder);
        }
    }
    
    /**
     * @param array $information
     */
    public function linkUnfinishedOrder(array $information): void
    {
        /** @var CartModel $cart */
        $cart = $this->model;
        if ($cart->unfinishedOrder) {
            $model = $cart->unfinishedOrder;
        } else {
            $model = new UnfinishedOrderModel();
        }
        $model->information = $information;
        $model->cart_id = $this->model->id;
        $model->save();
        
        $unfinishedOrder = new CartUnfinishedOrder();
        $unfinishedOrder->setModel($model);
        $this->setUnfinishedOrder($unfinishedOrder);
    }
    
}
