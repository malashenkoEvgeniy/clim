<header class="main-header">
    @include('admin.widgets.header.logo')
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                {!! Widget::position('header') !!}
            </ul>
        </div>
    </nav>
</header>
