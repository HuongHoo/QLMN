<?php

if (!function_exists('danhGiaBadge')) {
    function danhGiaBadge($value)
    {
        if (!$value) return '<span class="badge bg-secondary">—</span>';

        $colors = [
            1 => 'danger',
            2 => 'warning',
            3 => 'info',
            4 => 'primary',
            5 => 'success',
        ];

        return '<span class="badge bg-' . ($colors[$value] ?? 'secondary') . '">' . $value . '</span>';
    }
}
