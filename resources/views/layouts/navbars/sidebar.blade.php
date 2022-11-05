<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ _('WD') }}</a>
            <a href="#" class="simple-text logo-normal">{{ _('White Dashboard') }}</a>
        </div>
        <ul class="nav">
            {{-- <li @if ($pageSlug == 'dashboard') class="active " @endif> --}}
                <li  class="active " >
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ _('Dashboard') }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="false">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('User Management') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="laravel-examples">
                    <ul class="nav pl-4">
                        {{-- <li  class="active " >
                            <a href="">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ _('User Profile') }}</p>
                            </a>
                        </li> --}}
                        <li class="active " >
                            <a href="{{route('consumer.show')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ _('Consumer') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="active ">
                <a href="{{route('category.show')}}">
                    <i class="tim-icons icon-atom"></i>
                    <p>{{ _('Category') }}</p>
                </a>
            </li>
            <li  class="active " >
                <a href="{{route('product.show')}}">
                    <i class="tim-icons icon-pin"></i>
                    <p>{{ _('Products') }}</p>
                </a>
            </li>
            <li class="active ">
                <a href="{{route('message.show')}}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ _('Messages') }}</p>
                </a>
            </li>
            <li class="active " >
                <a href="{{route('notification.show')}}">
                    <i class="tim-icons icon-puzzle-10"></i>
                    <p>{{ _('Notification') }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#orders" aria-expanded="false">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Orders') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="orders">
                    <ul class="nav pl-4">
                        {{-- <li  class="active " >
                            <a href="">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ _('User Profile') }}</p>
                            </a>
                        </li> --}}
                        <li class="active " >
                            <a href="{{route('orders.show')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ _('Order List') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- <li class="active " >
                <a href="">
                    <i class="tim-icons icon-align-center"></i>
                    <p>{{ _('Typography') }}</p>
                </a>
            </li>
            <li class="active " >
                <a href="">
                    <i class="tim-icons icon-world"></i>
                    <p>{{ _('RTL Support') }}</p>
                </a>
            </li> --}}

        </ul>
    </div>
</div>
