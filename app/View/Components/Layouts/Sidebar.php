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
           ['key' => 'dashboard',
                'name' => 'Trang chủ',
                'route' => 'admin.welcome',
               'icon' => 'bi bi-house',
        ],
           [ 'key' => 'lophoc',
                'name' => 'Lớp học',
                'route' => 'lophoc.index',
                'icon' => 'bi bi-house-door',
                'childmenu'=>[
                    ['key' => 'lophoc',
                    'name' => 'Lớp học',
                    'route' => 'lophoc.index',
                    'icon' => 'bi bi-house-door',
                ],

                ]
        ],
    ];

        return view('components.layouts.sidebar',  [
            'menu' => $menu,
    ]);
    }
}
