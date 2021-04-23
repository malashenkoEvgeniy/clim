<?php

namespace App\Modules\Wishlist\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Wishlist\Models\Wishlist
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Wishlist\Models\Wishlist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Wishlist\Models\Wishlist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Wishlist\Models\Wishlist query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Wishlist\Models\Wishlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Wishlist\Models\Wishlist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Wishlist\Models\Wishlist whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Wishlist\Models\Wishlist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Wishlist\Models\Wishlist whereUserId($value)
 * @mixin \Eloquent
 */
class Wishlist extends Model
{
    protected $fillable = ['product_id', 'user_id'];
    
    /**
     * Links user and product
     *
     * @param int $productId
     * @param int $userId
     * @return Wishlist
     */
    public static function linkProductToUser(int $productId, int $userId): Wishlist
    {
        $productFromWishlist = new Wishlist();
        $productFromWishlist->product_id = $productId;
        $productFromWishlist->user_id = $userId;
        $productFromWishlist->save();

        return $productFromWishlist;
    }

    /**
     * Unlink product from user
     *
     * @param int $productId
     * @param int $userId
     * @return bool
     * @throws \Exception
     */
    public static function unlinkProductFromUser(int $productId, int $userId): bool
    {
        return Wishlist::whereUserId($userId)->whereProductId($productId)->delete();
    }
    
    /**
     * Deletes all related to user products from wishlist
     *
     * @param int $userId
     * @throws \Exception
     */
    public static function clear(?int $userId): void
    {
        if ($userId) {
            Wishlist::whereUserId($userId)->delete();
        }
    }
}