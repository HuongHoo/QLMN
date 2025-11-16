<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
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
        $menu = [
            [
                'key' => 'dashboard',
                'name' => 'Trang chủ',
                'route' => 'admin.welcome',
                'icon' => 'bi bi-house',
            ],
            // [
            //     'key' => 'lophoc',
            //     'name' => 'Lớp học',
            //     'route' => 'lophoc.index',
            //     'icon' => 'bi bi-folder',
            //     'childmenu' => [
            //         [
            //             'key' => 'lophoc',
            //             'name' => 'Lớp học',
            //             'route' => 'lophoc.index',
            //             'icon' => 'bi bi-house-door',
            //         ],


            //     ]
            // ],
            [
                'key' => 'nguoidung',
                'name' => 'Người dùng',
                'route' => 'admin.nguoidung.index',
                'icon' => 'bi bi-people',
            ],
            [
                'key' => 'lophoc',
                'name' => 'Lớp học',
                'route' => 'admin.lophoc.index',
                'icon' => 'bi bi-folder',
            ],
            [
                'key' => 'giaovien',
                'name' => 'Giáo viên',
                'route' => 'admin.giaovien.index',
                'icon' => 'bi bi-person-badge',
            ],
            [
                'key' => 'phuhuynh',
                'name' => 'Phụ huynh',
                'route' => 'admin.phuhuynh.index',
                'icon' => 'bi bi-person-lines-fill',
            ],
            [
                'key' => 'hocsinh',
                'name' => 'Học sinh',
                'route' => 'admin.hocsinh.index',
                'icon' => 'bi bi-mortarboard',
            ],
            [
                'key' => 'diemdanh',
                'name' => 'Điểm danh',
                'route' => 'admin.diemdanh.index',
                'icon' => 'bi bi-journal-check',
            ],
            [
                'key' => 'danhgia',
                'name' => 'Đánh giá',
                'route' => 'admin.danhgia.index',
                'icon' => 'bi bi-star-half',
            ],
            [
                'key' => 'suckhoe',
                'name' => 'Sức khỏe',
                'route' => 'admin.suckhoe.index',
                'icon' => 'bi bi-heart-pulse',
            ],
        ];

        return view('components.layouts.sidebar',  [
            'menu' => $menu,
        ]);
    }
}
