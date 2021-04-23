<div class="schedule-work">
    {!! SiteHelpers\SvgSpritemap::get('icon-working-time', [
        'class' => 'schedule-work__icon',
        'width' => 24,
        'height' => 24
    ]) !!}
    <div class="schedule-work__content">
        <div class="schedule-work__descr">
            @lang('site.schedule-call-center')
        </div>
        <div class="schedule-work__times">{!! $schedule !!}</div>
    </div>
</div>
