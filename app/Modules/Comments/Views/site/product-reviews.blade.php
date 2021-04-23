@php
/** @var \App\Modules\Comments\Models\Comment[]|\Illuminate\Pagination\LengthAwarePaginator $comments */
/** @var string $commentableType */
/** @var int $commentableId */
@endphp
<div class="_mb-lg">
    @foreach($comments as $comment)
        <div class="review">
            <div class="review__head">
                <div class="grid _items-center">
                    <div class="gcell">
                        <div class="review__user">{{ $comment->name }}</div>
                    </div>
                    @if($comment->mark)
                        <div class="gcell _pl-sm">
                            @include('site._widgets.stars-block.stars-block', [
                                'count' => $comment->mark,
                            ])
                        </div>
                    @endif
                </div>
                <time class="review__time" datetime="{{ $comment->published_at->format('Y-m-d') }}">{{ $comment->publish_date }}</time>
            </div>
            <div class="review__body">
                <div class="review__content">{!! $comment->comment !!}</div>
            </div>
            @if($comment->answered_at)
                <div class="review">
                    <div class="review__head">
                        <div class="review__user">{{ config('db.comments.admin-name', 'Administrator') }}</div>
                        <time class="review__time" datetime="{{ $comment->answered_at->format('Y-m-d') }}">{{ $comment->answer_date }}</time>
                    </div>
                    <div class="review__body">
                        <div class="review__content">{!! $comment->answer !!}</div>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>
{!! $comments->links('pagination.ajax', ['url' => route('site.comments.index', [$commentableType, $commentableId])]) !!}
<div class="separator _color-gray2 _mtb-def"></div>
