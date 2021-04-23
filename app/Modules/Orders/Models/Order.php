<?php

namespace App\Modules\Orders\Models;

use App\Modules\Orders\Filters\OrdersFilter;
use EloquentFilter\Filterable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Catalog;

/**
 * App\Modules\Orders\Models\Order
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property bool $do_not_call_me
 * @property bool $paid
 * @property string|null $city
 * @property string|null $comment
 * @property string|null $delivery
 * @property string|null $delivery_address
 * @property string|null $payment_method
 * @property int|null $status_id
 * @property int|null $user_id
 * @property bool $paid_auto
 * @property string|null $city_ref
 * @property string|null $warehouse_ref
 * @property string|null $ttn
 * @property string|null $ttn_ref
 * @property-read \App\Modules\Orders\Models\OrderClient $client
 * @property-read mixed $formatted_date
 * @property-read mixed $total_amount_as_number
 * @property-read mixed $total_amount
 * @property-read mixed $total_amount_old
 * @property-read mixed $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Orders\Models\OrderStatusesHistory[] $history
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Orders\Models\OrderItem[] $items
 * @property-read \App\Modules\Orders\Models\OrderStatus $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order filter($input = array(), $filter = null)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Orders\Models\Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereCityRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereDeliveryAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereDoNotCallMe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order wherePaidAuto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereTtn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereTtnRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Order whereWarehouseRef($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Orders\Models\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Orders\Models\Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Model
{
    use Filterable, SoftDeletes;

    const DEFAULT_LIMIT_FOR_USER = 10;
    const DEFAULT_LIMIT_FOR_ADMIN = 10;

    const MAIL_TEMPLATE_ORDER_CREATED = 'order-created';
    const MAIL_TEMPLATE_ORDER_CREATED_ADMIN = 'order-created-admin';

    const PAYMENT_LIQPAY = 'liqpay';

    protected $table = 'orders';

    protected $casts = [
        'do_not_call_me' => 'boolean',
        'paid' => 'boolean',
        'paid_auto' => 'boolean',
    ];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'do_not_call_me', 'paid', 'user_id', 'city', 'comment', 'delivery',
        'delivery_address', 'payment_method', 'city_ref', 'warehouse_ref', 'ttn'
    ];

    /**
     * Register filter model
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(OrdersFilter::class);
    }

    public function client()
    {
        return $this->hasOne(OrderClient::class, 'order_id', 'id');
    }

    public function status()
    {
        return $this->hasOne(OrderStatus::class, 'id', 'status_id');
    }

    public function items()
    {
        return $this
            ->hasMany(OrderItem::class, 'order_id', 'id')
            ->latest('id');
    }

    public function history()
    {
        return $this->hasMany(OrderStatusesHistory::class, 'order_id', 'id')
            ->latest('id');
    }

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('d') . ' ' .
            __(config('months.full.' . $this->created_at->format('n'), $this->created_at->format('m'))) . ' ' .
            $this->created_at->format('Y');
    }

    public function getTotalAmountAttribute(): string
    {
        if (Catalog::currenciesLoaded()) {
            return Catalog::currency()->format($this->total_amount_as_number);
        }
        return $this->total_amount_as_number;
    }

    public function getTotalAmountAsNumberAttribute(): string
    {
        $amount = 0;
        $this->items->each(function (OrderItem $item) use (&$amount) {
            $amount += $item->price * $item->quantity;
        });
        return $amount;
    }

    public function getTotalAmountOldAttribute(): string
    {
        $amount = 0;
        $this->items->each(function (OrderItem $item) use (&$amount) {
            $amount += $item->old_price * $item->quantity;
        });
        if (Catalog::currenciesLoaded()) {
            return Catalog::currency()->format($amount);
        }
        return $amount;
    }

    /**
     * @param array $data
     * @param int $userId
     * @return Order
     */
    public static function store(array $data, ?int $userId = null): Order
    {
        $order = new Order;
        $order->fill($data);
        // Set status to order as NEW
        $newOrderStatus = OrderStatus::newOrder();
        if ($newOrderStatus) {
            $order->status_id = $newOrderStatus->id;
        }
        // Link order to registered user
        if ($userId) {
            $order->user_id = $userId;
        }
        $order->save();
        return $order;
    }

    /**
     * Returns paginated orders list
     *
     * @param int $userId
     * @return LengthAwarePaginator
     */
    public static function paginateForUser(int $userId): LengthAwarePaginator
    {
        return Order::whereUserId($userId)
            ->with('status', 'client', 'items')
            ->latest('id')
            ->paginate(
                config(
                    'db.orders.per-page-for-user',
                    Order::DEFAULT_LIMIT_FOR_USER
                )
            );
    }

    /**
     * Returns paginated orders list for administrator
     *
     * @param int|null $limit
     * @param int|bool $trashed
     * @return LengthAwarePaginator
     */
    public static function paginatedList(?int $limit = null, ?bool $trashed = false): LengthAwarePaginator
    {
        $ordersQuery = Order::with('status', 'client', 'items')->filter(request()->all())->latest('id');
        if ($trashed === true) {
            $ordersQuery->onlyTrashed();
        } elseif ($trashed === null) {
            $ordersQuery->withTrashed();
        }
        return $ordersQuery
            ->paginate(
                $limit ?? config(
                    'db.orders.per-page',
                    Order::DEFAULT_LIMIT_FOR_ADMIN
                )
            );
    }

    /**
     * Get trashed list of orders
     *
     * @param int|null $limit
     * @return LengthAwarePaginator
     */
    public static function paginatedListFromTheTrash(?int $limit = null): LengthAwarePaginator
    {
        return static::paginatedList($limit, true);
    }

    /**
     * Change order status
     *
     * @param int $statusId
     * @param null|string $comment
     */
    public function changeStatus(int $statusId, ?string $comment = null): void
    {
        if ($this->status_id === (int)$statusId) {
            return;
        }
        $this->status_id = $statusId;
        $this->save();
        // Write to history
        OrderStatusesHistory::write($this->id, $statusId, $comment);
    }

    public function one(int $orderId)
    {
        return $this->whereId($orderId)->first();
    }

    /**
     * @param array $items [ price => [ id => 45, id => 56.63, .. ], quantity => [ id => [ item_id => 1, item_id => 5, ... ], id => [ item_id => 4, item_id => 1, ... ], ..]
     */
    public function updateItems(array $items): void
    {
        $dictionaryCheck = config('db.products_dictionary.site_status', 0);
        $productsIds = array_keys(array_get($items, 'price', []));
        $existedProductIds = [];
        $newProducts = array_get($items, 'new', []);
        $this->items->each(function (OrderItem $item) use ($productsIds, $items, $dictionaryCheck, &$existedProductIds) {
            if (in_array($item->product_id, $productsIds)) {
                foreach (array_get(array_get($items, 'quantity', []), $item->product_id) as $id => $q) {
                    $item->updateQuantity($q, $id);
                }
                if ($dictionaryCheck) {
                    foreach (array_get(array_get($items, 'dictionaries', []), $item->product_id) as $id => $d) {
                        $item->updateDictionary($d, $id);
                    }
                }
                $existedProductIds[] = $item->product_id;
            } else {
                $item->delete();
            }
        });

        if (!empty($newProducts)) {
            foreach ($newProducts as $productId => $newProduct) {
                foreach ($newProduct['quantity'] as $index => $value) {
                    if ($dictionaryCheck) {
                        $data = [
                            'order_id' => $this->id,
                            'product_id' => $productId,
                            'quantity' => $newProduct['quantity'][$index] ?? 1,
                            'dictionary_id' => $newProduct['dictionaries'][$index] ?? 1,
                            'price' => array_get($newProduct, 'price') ?? 0,
                        ];
                    } else {
                        $data = [
                            'order_id' => $this->id,
                            'product_id' => $productId,
                            'quantity' => $newProduct['quantity'][$index] ?? 1,
                            'price' => array_get($newProduct, 'price') ?? 0,
                        ];
                    }
                    OrderItem::create($data);
                }

            }
        }
        
        OrderItem::checkSameItems($this->id);
    }
}
