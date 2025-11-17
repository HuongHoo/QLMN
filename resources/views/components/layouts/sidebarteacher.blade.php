<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('admin/assets/img/logo-ct-dark.png') }}" width="26" height="26">
        </div>
        <div class="sidebar-brand-text mx-3">Quản lý mầm non</div>
    </a>
    <hr class="sidebar-divider my-0">
    @foreach ($menu as $item)
        @php
            $hasChildren = isset($item['childmenu']) && is_array($item['childmenu']) && count($item['childmenu']);
            $isActive = request()->routeIs($item['route']);
        @endphp

        <li class="nav-item {{ $isActive ? 'active' : '' }}">
            <a class="nav-link" href="{{ $hasChildren ? '#' : (isset($item['route']) ? route($item['route']) : '#') }}"
                @if ($hasChildren) data-toggle="collapse" data-target="#collapse-{{ $item['key'] }}" @endif>
                @if (!empty($item['icon']))
                    <i class="{{ $item['icon'] }}"></i>
                @endif
                <span>{{ $item['name'] }}</span>
            </a>

            @if ($hasChildren)
                <div id="collapse-{{ $item['key'] }}" class="collapse" aria-labelledby="heading-{{ $item['key'] }}"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @foreach ($item['childmenu'] as $child)
                            <a class="collapse-item"
                                href="{{ isset($child['route']) ? route($child['route']) : '#' }}">{{ $child['name'] }}</a>
                        @endforeach
                    </div>
                </div>
            @endif
        </li>
    @endforeach
</ul>
