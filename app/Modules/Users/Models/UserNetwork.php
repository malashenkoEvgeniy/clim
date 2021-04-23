<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Users\Models\UserNetwork
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property string $network
 * @property string $uid
 * @property string|null $link
 * @property string $email
 * @property array|null $data
 * @property-read \App\Modules\Users\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\UserNetwork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\UserNetwork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\UserNetwork query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\UserNetwork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\UserNetwork whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\UserNetwork whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\UserNetwork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\UserNetwork whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\UserNetwork whereNetwork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\UserNetwork whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\UserNetwork whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\UserNetwork whereUserId($value)
 * @mixin \Eloquent
 */
class UserNetwork extends Model
{

    protected $table = 'users_networks';

    protected $fillable = ['uid', 'user_id', 'data', 'network', 'link', 'email'];

    protected $casts = ['data' => 'array'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function getByNetworkAndUid(string $network, string $uid): ?UserNetwork
    {
        return UserNetwork::whereUid($uid)->whereNetwork($network)->first();
    }

    public static function link(int $userId, array $input): UserNetwork
    {
        $network = new UserNetwork();
        $network->fill([
            'user_id' => $userId,
            'data' => $input,
            'network' => array_get($input, 'network'),
            'email' => array_get($input, 'email'),
            'uid' => array_get($input, 'uid'),
            'link' => array_get($input, 'identity'),
        ]);
        $network->save();

        return $network;
    }

}