<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('admin/assets/img/logo-ct-dark.png') }}" width="26" height="26">
        </div>
        <div class="sidebar-brand-text mx-3">Quản lý mầm non</div>
    </a>

    <hr class="sidebar-divider my-0">

    @foreach ($menu as $item)
        @if (isset($item['childmenu']))
            {{-- Menu có submenu --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                   data-target="#collapse-{{ $item['key'] }}" aria-expanded="false"
                   aria-controls="collapse-{{ $item['key'] }}">
                    <i class="{{ $item['icon'] }}"></i>
                    <span>{{ $item['name'] }}</span>
                </a>
                <div id="collapse-{{ $item['key'] }}" class="collapse"
                     aria-labelledby="heading-{{ $item['key'] }}" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{ $item['name'] }}</h6>
                        @foreach ($item['childmenu'] as $child)
                            <a class="collapse-item" href="{{ route($child['route']) }}">
                                <i class="{{ $child['icon'] }}"></i> {{ $child['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </li>
        @else
            {{-- Menu không có submenu --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route($item['route']) }}">
                    <i class="{{ $item['icon'] }}"></i>
                    <span>{{ $item['name'] }}</span>
                </a>
            </li>
        @endif
    @endforeach

    <hr class="sidebar-divider d-none d-md-block">

</ul>
