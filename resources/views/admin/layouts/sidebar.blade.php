<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('jkd')}}" class="brand-link">
        <img src="{{asset('/images/jkdlogo.png')}}" alt="JKDBlog Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('/bower_components/admin-lte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        @php
            $menu = $menu ?? '';
            $jkdUri = $jkdUri ?? '';
            $topUri = $topUri ?? '';
        @endphp
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                @if($menu)
                    @foreach($menu as $men)
                    <li class="nav-item has-treeview @if(in_array($topUri, $men['routePrefix'])) menu-open @endif">
                        <a href="#" class="nav-link @if(in_array($topUri, $men['routePrefix'])) active @endif">
                            <i class="nav-icon fas {{ $men['icon'] }}"></i>
                            <p>
                                {{ $men['name'] }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(isset($men['children']) && count($men['children']))
                                @foreach($men['children'] as $meChil)
                                <li class="nav-item">
                                    <a href="{{ route($meChil['route']) }}" class="nav-link @if($jkdUri == '/'.$meChil['route']) active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ $meChil['name'] }}</p>
                                    </a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    @endforeach
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
