<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiemThiService;

class DiemThiController extends Controller
{
    protected $diemThiService;

    // constructor
    public function __construct(DiemThiService $diemThiService)
    {
        $this->diemThiService = $diemThiService;
    }

    // 1. Tra cứu điểm theo SBD
    public function traCuu($sbd)
    {
        $diem = $this->diemThiService->findBySbd($sbd);

        if (!$diem) {
            return response()->json(['message' => 'Không tìm thấy SBD'], 404);
        }

        return response()->json($diem);
    }

    // 2. Tổng hợp số lượng học sinh theo khoảng điểm của từng môn
    public function thongKe()
    {
        $result = $this->diemThiService->getStatisticsBySubject();
        return response()->json($result);
    }

    // 3. Top 10 khối A (Toán + Lý + Hóa)
    public function top10KhoiA()
    {
        $top = $this->diemThiService->getTop10KhoiA();
        return response()->json($top);
    }
}