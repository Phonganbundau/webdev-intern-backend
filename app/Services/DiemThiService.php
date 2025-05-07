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
        $subjects = ['toan', 'ngu_van', 'ngoai_ngu', 'vat_li', 'hoa_hoc', 'sinh_hoc', 'lich_su', 'dia_li', 'gdcd'];
        $levels = [
            '>=8' => fn($query, $subject) => $query->where($subject, '>=', 8),
            '>=6_and_<8' => fn($query, $subject) => $query->whereBetween($subject, [6, 7.99]),
            '>=4_and_<6' => fn($query, $subject) => $query->whereBetween($subject, [4, 5.99]),
            '<4' => fn($query, $subject) => $query->where($subject, '<', 4),
        ];

        $result = [];

        foreach ($subjects as $subject) {
            $result[$subject] = [];
            foreach ($levels as $level => $condition) {
                $result[$subject][$level] = $condition(DiemThi::query(), $subject)->count();
            }
        }

        return $result;
    }

    
    //Lấy top 10 thí sinh có điểm khối A (Toán + Lý + Hóa) cao nhất
  
    public function getTop10KhoiA()
    {
        return DiemThi::select('*', DB::raw('(toan + vat_li + hoa_hoc) as tong_diem'))
            ->orderByDesc('tong_diem')
            ->limit(10)
            ->get();
    }
}