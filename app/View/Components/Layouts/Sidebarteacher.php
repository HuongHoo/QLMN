<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebarteacher extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $thongtin = [
            [
                'key' => 'dashboard',
                'name' => 'Trang chủ',
                'route' => 'teacher.teacher',
                'icon' => 'bi bi-house',
            ],
            // [
            //     'key' => 'lophoc',
            //     'name' => 'Lớp học',
            //     'route' => 'lophoc.index',
            //     'icon' => 'bi bi-folder',
            //     'childmenu' => [
            [
                'key' => 'thongtincanhan',
                'name' => 'Thông tin cá nhân',
                'route' => 'teacher.thongtincanhan.index',
                'icon' => 'bi bi-house-door',
            ],
            [
                'key' => 'hocsinh',
                'name' => 'Danh sách học sinh',
                'route' => 'teacher.hocsinh.index',
                'icon' => 'bi bi-house-door',
            ],


            //     ]
            // ],
            // [
            //     'key' => 'nguoidung',
            //     'name' => 'Người dùng',
            //     'route' => 'admin.nguoidung.index',
            //     'icon' => 'bi bi-people',
            // ],

        ];

        return view('components.layouts.sidebarteacher', [
            'menu' => $thongtin,
        ]);
    }
}
