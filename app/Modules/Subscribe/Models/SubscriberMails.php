<?php

namespace App\Modules\Subscribe\Models;

use App\Modules\Subscribe\Filters\SubscribeHistoryFilter;
use App\Modules\Subscribe\Requests\AdminSubscriberMailsRequest;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Subscribe\Models\SubscriberMails
 *
 * @property int $id
 * @property string $subject
 * @property string $text
 * @property int $count_emails
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails whereCountEmails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\SubscriberMails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubscriberMails extends Model
{
    use Filterable;

    protected $fillable = ['subject', 'text', 'count_emails'];

    public function modelFilter()
    {
        return $this->provideFilter(SubscribeHistoryFilter::class);
    }

    /**
     * Save to the database
     *
     * @param AdminSubscriberMailsRequest $request
     * @param int $subscriberCount
     * @return SubscriberMails
     */
    public static function stat(AdminSubscriberMailsRequest $request, int $subscriberCount)
    {
        $subscriberMail = new SubscriberMails();
        $subscriberMail->fill($request->only('subject', 'text'));
        $subscriberMail->count_emails = $subscriberCount;
        $subscriberMail->save();
        
        return $subscriberMail;
    }
    
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList()
    {
        return SubscriberMails::filter(request()->all())
            ->latest()->paginate(config('db.subscribe.history-per-page', 10));
    }
    
}
