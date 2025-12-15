<?php

namespace Database\Seeders;

use App\Models\HoatDong;
use App\Models\HoatDongHangNgay;
use App\Models\AnhHoatDong;
use App\Models\LopHoc;
use App\Models\GiaoVien;
use App\Models\HocSinh;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HoatDongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dữ liệu hoạt động gallery công khai (cho trang home)
        // Sử dụng ảnh từ Unsplash - ảnh thực tế về trẻ em và giáo dục
        $hoatDongCongKhai = [
            [
                'tieude' => 'Giờ học vẽ sáng tạo',
                'mota' => 'Các bé được thỏa sức sáng tạo với các bức tranh màu sắc',
                'anh' => 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=400&h=280&fit=crop',
                'loai' => 'hoctap',
                'ngay' => Carbon::now()->subDays(2),
                'thutu' => 1,
            ],
            [
                'tieude' => 'Hoạt động ngoài trời',
                'mota' => 'Khám phá thiên nhiên và vui chơi ngoài sân trường',
                'anh' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=400&h=280&fit=crop',
                'loai' => 'vuichoi',
                'ngay' => Carbon::now()->subDays(3),
                'thutu' => 2,
            ],
            [
                'tieude' => 'Lễ hội Trung thu',
                'mota' => 'Vui Tết Trung thu cùng các bạn nhỏ với rước đèn và múa lân',
                'anh' => 'https://images.unsplash.com/photo-1544776193-352d25ca82cd?w=400&h=280&fit=crop',
                'loai' => 'sukien',
                'ngay' => Carbon::now()->subDays(30),
                'thutu' => 3,
            ],
            [
                'tieude' => 'Bữa ăn dinh dưỡng',
                'mota' => 'Thực đơn đầy đủ chất dinh dưỡng cho các bé',
                'anh' => 'https://images.unsplash.com/photo-1484820540004-14229fe36ca4?w=400&h=280&fit=crop',
                'loai' => 'hoctap',
                'ngay' => Carbon::now()->subDays(1),
                'thutu' => 4,
            ],
            [
                'tieude' => 'Thể dục buổi sáng',
                'mota' => 'Rèn luyện sức khỏe mỗi ngày với bài tập thể dục vui nhộn',
                'anh' => 'https://images.unsplash.com/photo-1596464716127-f2a82984de30?w=400&h=280&fit=crop',
                'loai' => 'vuichoi',
                'ngay' => Carbon::now(),
                'thutu' => 5,
            ],
            [
                'tieude' => 'Văn nghệ cuối năm',
                'mota' => 'Biểu diễn tài năng ca múa nhạc của các bé',
                'anh' => 'https://images.unsplash.com/photo-1564429238067-4a96f9f0a4d3?w=400&h=280&fit=crop',
                'loai' => 'sukien',
                'ngay' => Carbon::now()->subDays(60),
                'thutu' => 6,
            ],
            [
                'tieude' => 'Học STEM vui nhộn',
                'mota' => 'Khám phá khoa học qua các thí nghiệm đơn giản',
                'anh' => 'https://images.unsplash.com/photo-1567057419565-4349c49d8a04?w=400&h=280&fit=crop',
                'loai' => 'hoctap',
                'ngay' => Carbon::now()->subDays(5),
                'thutu' => 7,
            ],
            [
                'tieude' => 'Góc chơi sáng tạo',
                'mota' => 'Phát triển tư duy qua các trò chơi xếp hình, lắp ghép',
                'anh' => 'https://images.unsplash.com/photo-1472162072942-cd5147eb3902?w=400&h=280&fit=crop',
                'loai' => 'vuichoi',
                'ngay' => Carbon::now()->subDays(4),
                'thutu' => 8,
            ],
            [
                'tieude' => 'Ngày hội bé khỏe',
                'mota' => 'Thi đua thể thao vui nhộn giữa các lớp',
                'anh' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&h=280&fit=crop',
                'loai' => 'sukien',
                'ngay' => Carbon::now()->subDays(15),
                'thutu' => 9,
            ],
        ];

        foreach ($hoatDongCongKhai as $data) {
            HoatDong::create($data);
        }

        // Tạo hoạt động hàng ngày cho các lớp
        $lophocs = LopHoc::all();
        $giaovien = GiaoVien::first();

        if ($giaovien && $lophocs->count() > 0) {
            $today = Carbon::today();

            foreach ($lophocs as $lop) {
                // Các hoạt động trong ngày
                $hoatDongNgay = [
                    [
                        'lophoc_id' => $lop->id,
                        'giaovien_id' => $giaovien->id,
                        'tieude' => 'Bữa sáng dinh dưỡng',
                        'mota' => 'Các bé ăn sáng với cháo thịt bằm, sữa tươi và trái cây tươi.',
                        'loai' => 'gioian',
                        'giobatdau' => '07:30',
                        'gioketthuc' => '08:00',
                        'ngay' => $today,
                    ],
                    [
                        'lophoc_id' => $lop->id,
                        'giaovien_id' => $giaovien->id,
                        'tieude' => 'Giờ học vẽ & thủ công',
                        'mota' => 'Các bé tham gia vẽ tranh về gia đình và làm thiệp tặng ba mẹ.',
                        'loai' => 'hoctap',
                        'giobatdau' => '08:30',
                        'gioketthuc' => '10:00',
                        'ngay' => $today,
                    ],
                    [
                        'lophoc_id' => $lop->id,
                        'giaovien_id' => $giaovien->id,
                        'tieude' => 'Hoạt động thể chất ngoài trời',
                        'mota' => 'Tập thể dục, chơi trò chơi vận động và khám phá sân chơi.',
                        'loai' => 'ngoaitroi',
                        'giobatdau' => '10:00',
                        'gioketthuc' => '10:30',
                        'ngay' => $today,
                    ],
                    [
                        'lophoc_id' => $lop->id,
                        'giaovien_id' => $giaovien->id,
                        'tieude' => 'Bữa trưa và giờ ngủ trưa',
                        'mota' => 'Các bé ăn trưa và nghỉ ngơi trong phòng mát mẻ.',
                        'loai' => 'nghingoi',
                        'giobatdau' => '11:00',
                        'gioketthuc' => '14:00',
                        'ngay' => $today,
                    ],
                ];

                foreach ($hoatDongNgay as $data) {
                    $hoatdong = HoatDongHangNgay::create($data);

                    // Thêm ảnh mẫu cho mỗi hoạt động
                    AnhHoatDong::create([
                        'hoatdong_hangngay_id' => $hoatdong->id,
                        'anh' => 'hoatdong/sample-' . $hoatdong->loai . '.jpg',
                        'mota' => 'Ảnh ' . $hoatdong->tieude,
                    ]);
                }
            }
        }

        $this->command->info('Đã tạo dữ liệu hoạt động mẫu!');
    }
}
