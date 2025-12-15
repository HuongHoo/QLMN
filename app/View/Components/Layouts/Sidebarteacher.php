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
                'icon' => 'bi bi-people',
            ],
            [
                'key' => 'diemdanh',
                'name' => 'Điểm danh hằng ngày',
                'route' => 'teacher.diemdanh.index',
                'icon' => 'bi bi-check2-square',
            ],
            [
                'key' => 'hocphi',
                'name' => 'Quản lý học phí',
                'route' => 'teacher.hocphi.index',
                'icon' => 'bi bi-wallet2',
            ],
            [
                'key' => 'danhgia',
                'name' => 'Đánh giá học sinh',
                'route' => 'teacher.danhgia.index',
                'icon' => 'bi bi-star',
            ],
            [
                'key' => 'hoatdong',
                'name' => 'Hoạt động hàng ngày',
                'route' => 'teacher.hoatdong.index',
                'icon' => 'bi bi-camera',
            ],
            [
                'key' => 'thongbao',
                'name' => 'Thông báo',
                'route' => 'teacher.thongbao.index',
                'icon' => 'bi bi-bell',
            ],
            [
                'key' => 'chat',
                'name' => 'Nhắn tin Phụ huynh',
                'route' => 'teacher.chat.index',
                'icon' => 'bi bi-chat-dots',
            ],
            [
                'key' => 'xuatfile',
                'name' => 'Xuất file báo cáo',
                'route' => 'teacher.xuatfile.index',
                'icon' => 'bi bi-file-earmark-pdf',
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
