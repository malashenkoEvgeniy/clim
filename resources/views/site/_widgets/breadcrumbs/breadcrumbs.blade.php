<div class="_ptb-def">
    <ol class="breadcrumbs">
        @php ($breadcrumsListText = [])
        @foreach(Seo::breadcrumbs()->elements() as $breadcrumb)
            @php ($breadcrumsListText[] = __($breadcrumb->getTitle()))
                @if ($loop->last || !$breadcrumb->getUrl())
                <li class="breadcrumbs__item">
                    <a class="breadcrumbs__link breadcrumbs__link--link" href="{{ $breadcrumb->getUrl() }}">
                        <span><!--dg_crumb_start-->{{ __($breadcrumb->getTitle()) }}<!--dg_crumb_start--></span>
                    </a>
                    <!--dg_breadcrumb_url:{{ $breadcrumb->getUrl() }};;dg_breadcrumb_value:{{ __($breadcrumb->getTitle()) }}-->
                </li>
                @else
                <li class="breadcrumbs__item">
                    <!--dg_active_crumb_on_cat_url:{{ $breadcrumb->getUrl() }};;dg_active_crumb_on_cat_name:{{ __($breadcrumb->getTitle()) }}-->
                    <a class="breadcrumbs__link breadcrumbs__link--link" href="{{ $breadcrumb->getUrl() }}">
                        <span><!--dg_crumb_start-->{{ __($breadcrumb->getTitle()) }}<!--dg_crumb_end--></span>
                    </a>
                    <!--dg_breadcrumb_url:{{ $breadcrumb->getUrl() }};;dg_breadcrumb_value:{{ __($breadcrumb->getTitle()) }}-->
                </li>
            @endif
        @endforeach
        <!--dg_filter_bc_ph-->
        <!--ss_breadcrums_list:{!! implode(' >> ', $breadcrumsListText) !!}-->
    </ol>
</div>
