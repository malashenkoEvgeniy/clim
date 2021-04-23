@php
    /** @var \App\Modules\Comments\Models\Comment[] $comments */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        {!! $filter !!}
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.first_name') }}</th>
                        <th>{{ __('validation.attributes.email') }}</th>
                        <th>{{ __('validation.attributes.user_id') }}</th>
                        <th>{{ __('comments::general.commentable_id') }}</th>
                        <th>{{ __('validation.attributes.publish_date') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($comments AS $comment)
                        <tr>
                            <td>{{ $comment->name }}</td>
                            <td>{{ Html::mailto($comment->email) }}</td>
                            <td>{!! $comment->user ? ($comment->user->name ?: '&mdash;') : '&mdash;' !!}</td>
                            <td>{!! $comment->commentable_element !!}</td>
                            <td>{!! $comment->publish_date ?? '&mdash;' !!}</td>
                            <td>{!! Widget::active($comment, 'admin.comments.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.comments.edit', ['id' => $comment->id, 'type' => $comment->commentable_type]) !!}
                                {!! \App\Components\Buttons::delete('admin.comments.destroy', ['id' => $comment->id, 'type' => $comment->commentable_type]) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $comments->links() }}</div>
    </div>
@stop
