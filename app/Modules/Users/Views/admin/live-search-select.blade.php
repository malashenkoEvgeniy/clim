<label class="form-label">@lang('users::general.user')</label>
{!! Form::select('user_id', [], null, [
    'class' => ['form-control', 'js-data-ajax'],
    'data-href' => route('admin.users.live-search'),
]) !!}
