<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('admin/assets/img/logo-ct-dark.png') }}" width="26" height="26">
        </div>
        <div class="sidebar-brand-text mx-3">Quản lý mầm non</div>
    </a>

    <hr class="sidebar-divider my-0">

    @php
        // support both variable names: $menus (from component) or $menu (legacy)
        $items = $menus ?? $menu ?? [];
    @endphp

    @foreach ($items as $item)
        @if (!empty($item['childmenu']) && is_array($item['childmenu']))
            {{-- Menu có submenu --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                   data-target="#collapse-{{ $item['key'] }}" aria-expanded="false"
                   aria-controls="collapse-{{ $item['key'] }}">
                    @if(!empty($item['icon']))
                        <i class="{{ $item['icon'] }}"></i>
                    @endif
                    <span>{{ $item['name'] }}</span>
                </a>
                <div id="collapse-{{ $item['key'] }}" class="collapse"
                     aria-labelledby="heading-{{ $item['key'] }}" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{ $item['name'] }}</h6>
                        @foreach ($item['childmenu'] as $child)
                            @php
                                $childHref = '#';
                                if (!empty($child['route']) && \Illuminate\Support\Facades\Route::has($child['route'])) {
                                    $childHref = route($child['route']);
                                } elseif (!empty($child['url'])) {
                                    $childHref = $child['url'];
                                }
                            @endphp
                            <a class="collapse-item" href="{{ $childHref }}">
                                @if(!empty($child['icon']))
                                    <i class="{{ $child['icon'] }}"></i>
                                @endif
                                {{ $child['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </li>
        @else
            {{-- Menu không có submenu --}}
            <li class="nav-item">
                @php
                    $href = '#';
                    if (!empty($item['route']) && \Illuminate\Support\Facades\Route::has($item['route'])) {
                        $href = route($item['route']);
                    } elseif (!empty($item['url'])) {
                        $href = $item['url'];
                    }
                @endphp
                <a class="nav-link" href="{{ $href }}">
                    @if(!empty($item['icon']))
                        <i class="{{ $item['icon'] }}"></i>
                    @endif
                    <span>{{ $item['name'] }}</span>
                </a>
            </li>
        @endif
    @endforeach

    <hr class="sidebar-divider d-none d-md-block">

</ul>
