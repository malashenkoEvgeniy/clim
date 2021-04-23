<div class="action-bar-inner-menu">
    @php
        $main_cats_counter = 0;
    @endphp
    @foreach(\App\Modules\Categories\Models\Category::getKidsFor(0) as $category)
        @php
            $main_cats_counter++;
            $kids = $category->getKids()
        @endphp
        @if(!$kids || $kids->isEmpty())
            @continue
        @endif
        @php
        /** @var \App\Core\Modules\Images\Models\Image $image */
        $image = $category->image;
        
        @endphp
        <div class="action-bar-inner-menu__item" id="inner-menu__item-{{ $loop->index }}">
            @if ($image && $image->exists && $image->isImageExists())
                <div class="action-bar-inner-menu__image _flex-order-1">
                    {!! $image->imageTag('small', ['width' => 320, 'height' => 240]) !!}
                </div>
            @endif
            <div class="action-bar-inner-menu__column">
                <div class="action-bar-inner-menu__scroll" data-perfect-scrollbar>
                    <div class="action-bar-inner-menu__holder">
                        <div class="action-bar-submenu">
                            @foreach($kids as $child)
                                
                                <div class="action-bar-submenu__item">

                                    <a class="action-bar-submenu__link" href="{{ $child->site_link }}">
                                        {{ $child->current->name }}
                                    </a>

                                    @php
                                        $kids2 = $child->getKids()
                                    @endphp
                                    @if($kids2 && !$kids2->isEmpty())
                                        <div class="action-bar-submenu">
                                            @foreach($kids2 as $child2)
                                                <div class="action-bar-submenu__item">
                                                    <a class="action-bar-submenu__link" href="{{ $child2->site_link }}">
                                                        {{ $child2->current->name }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    

        <div class="action-bar-inner-menu__item" id="inner-menu__item-{{ $main_cats_counter }}">
            
            <div class="action-bar-inner-menu__column">
                <div class="action-bar-inner-menu__scroll" data-perfect-scrollbar>
                    <div class="action-bar-inner-menu__holder">
                        <div class="action-bar-submenu">
                            @foreach(\App\Modules\Services\Models\Service::getList() as $service)
                                <div class="action-bar-submenu__item">
                                    <a class="action-bar-submenu__link" href="/services/{{ $service->current->slug }}">
                                        {{ $service->current->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
