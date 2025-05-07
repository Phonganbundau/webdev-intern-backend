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
        if (!preg_match('/^\d{8}$/', $sbd)) {
            return response()->json(['message' => 'Số báo danh không hợp lệ! Phải có đúng 8 chữ số (ví dụ: 12345678).'], 400);
        }

        $diem = $this->diemThiService->findBySbd($sbd);

        if (!$diem) {
            return response()->json(['message' => 'Không tìm thấy SBD'], 404);
        }

        return response()->json($diem);
    }

    // 2. Tổng hợp số lượng học sinh theo khoảng điểm của từng môn
    public function thongKe()
    {
        try {
            $result = $this->diemThiService->getStatisticsBySubject();
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
    // 3. Top 10 khối A (Toán + Lý + Hóa)

        public function top10KhoiA()
    {
        try {
            $top = $this->diemThiService->getTop10KhoiA();
            return response()->json($top);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}