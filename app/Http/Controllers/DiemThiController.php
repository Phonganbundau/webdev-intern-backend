<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiemThi;
use Illuminate\Support\Facades\DB;

class DiemThiController extends Controller
{
    // 1. Tra cứu điểm theo SBD
    public function traCuu($sbd)
    {
        $diem = DiemThi::where('sbd', $sbd)->first();

        if (!$diem) {
            return response()->json(['message' => 'Không tìm thấy SBD'], 404);
        }

        return response()->json($diem);
    }

    // 2. Báo cáo phân loại theo điểm trung bình
    public function baoCao()
{
    $subjects = [
        'toan', 'ngu_van', 'ngoai_ngu', 'vat_li', 'hoa_hoc',
        'sinh_hoc', 'lich_su', 'dia_li', 'gdcd'
    ];

    $result = [];

    foreach ($subjects as $subject) {
        $result[$subject] = [
            '>=8' => DiemThi::where($subject, '>=', 8)->count(),
            '>=6_and_<8' => DiemThi::where($subject, '>=', 6)->where($subject, '<', 8)->count(),
            '>=4_and_<6' => DiemThi::where($subject, '>=', 4)->where($subject, '<', 6)->count(),
            '<4' => DiemThi::where($subject, '<', 4)->count(),
        ];
    }

    return response()->json($result);
}


    // 3. Thống kê số lượng học sinh theo từng môn trong các mức điểm
    public function thongKe()
    {
        $subjects = ['toan', 'ngu_van', 'ngoai_ngu', 'vat_li', 'hoa_hoc', 'sinh_hoc', 'lich_su', 'dia_li', 'gdcd'];
        $levels = [
            '>=8' => fn($query) => $query->where($subject, '>=', 8),
            '>=6_and_<8' => fn($query) => $query->whereBetween($subject, [6, 7.99]),
            '>=4_and_<6' => fn($query) => $query->whereBetween($subject, [4, 5.99]),
            '<4' => fn($query) => $query->where($subject, '<', 4),
        ];

        $result = [];

        foreach ($subjects as $subject) {
            $result[$subject] = [
                '>=8' => DiemThi::where($subject, '>=', 8)->count(),
                '>=6_and_<8' => DiemThi::whereBetween($subject, [6, 7.99])->count(),
                '>=4_and_<6' => DiemThi::whereBetween($subject, [4, 5.99])->count(),
                '<4' => DiemThi::where($subject, '<', 4)->count(),
            ];
        }

        return response()->json($result);
    }

    // 4. Top 10 khối A (Toán + Lý + Hóa)
    public function top10KhoiA()
    {
        $top = DiemThi::select('*', DB::raw('(toan + vat_li + hoa_hoc) as tong_diem'))
            ->orderByDesc('tong_diem')
            ->limit(10)
            ->get();

        return response()->json($top);
    }
}
