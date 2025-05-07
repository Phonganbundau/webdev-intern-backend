<?php

namespace App\Services;

use App\Models\DiemThi;
use Illuminate\Support\Facades\DB;

class DiemThiService
{

    // Tra cứu điểm thi theo số báo danh (SBD)
  
    public function findBySbd($sbd)
    {
        return DiemThi::where('sbd', $sbd)->first();
    }

    

    //Thống kê số lượng học sinh theo khoảng điểm của từng môn 
   
    public function getStatisticsBySubject()
{
    // Kiểm tra xem bảng có dữ liệu không
    if (DiemThi::count() === 0) {
        throw new \Exception('Không có dữ liệu để thống kê!');
    }

    // Sử dụng caching
    return cache()->remember('statistics_by_subject', 3600, function () {
        $subjects = ['toan', 'ngu_van', 'ngoai_ngu', 'vat_li', 'hoa_hoc', 'sinh_hoc', 'lich_su', 'dia_li', 'gdcd'];
        $result = [];

        foreach ($subjects as $subject) {
            $result[$subject] = DiemThi::selectRaw("
                SUM(CASE WHEN {$subject} >= 8 THEN 1 ELSE 0 END) as '>=8',
                SUM(CASE WHEN {$subject} BETWEEN 6 AND 7.99 THEN 1 ELSE 0 END) as '>=6_and_<8',
                SUM(CASE WHEN {$subject} BETWEEN 4 AND 5.99 THEN 1 ELSE 0 END) as '>=4_and_<6',
                SUM(CASE WHEN {$subject} < 4 AND {$subject} > 0 THEN 1 ELSE 0 END) as '<4'
            ")
            ->where($subject, '>', 0)
            ->whereNotNull($subject)
            ->first()
            ->toArray();
        }

        return $result;
    });
}


    
    //Lấy top 10 thí sinh có điểm khối A (Toán + Lý + Hóa) cao nhất

    public function getTop10KhoiA()
{
    // Kiểm tra xem bảng có dữ liệu không
    if (DiemThi::count() === 0) {
        throw new \Exception('Không có dữ liệu để xếp hạng!');
    }

    return cache()->remember('top10_khoi_a', 3600, function () {
        return DiemThi::select('*', DB::raw('(toan + vat_li + hoa_hoc) as tong_diem'))
            ->where('toan', '>', 0)
            ->where('vat_li', '>', 0)
            ->where('hoa_hoc', '>', 0)
            ->whereNotNull('toan')
            ->whereNotNull('vat_li')
            ->whereNotNull('hoa_hoc')
            ->orderByDesc('tong_diem')
            ->limit(10)
            ->get();
    });
}
}