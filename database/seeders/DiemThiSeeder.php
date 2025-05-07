<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\DiemThi;

class DiemThiSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = storage_path('app/public/diem_thi_thpt_2024.csv');

        if (!file_exists($filePath)) {
            throw new \Exception("File CSV không tồn tại: $filePath");
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file); // dòng tiêu đề

        while (($row = fgetcsv($file)) !== false) {
            $data = array_combine($header, $row);

            DiemThi::create([
                'sbd'       => $data['sbd'],
                'toan'      => $data['toan'],
                'ngu_van'   => $data['ngu_van'],
                'ngoai_ngu' => $data['ngoai_ngu'],
                'vat_li'    => $data['vat_li'],
                'hoa_hoc'   => $data['hoa_hoc'],
                'sinh_hoc'  => $data['sinh_hoc'],
                'lich_su'   => $data['lich_su'],
                'dia_li'    => $data['dia_li'],
                'gdcd'      => $data['gdcd'],
                'ma_ngoai_ngu' => $data['ma_ngoai_ngu'],
            ]);
        }

        fclose($file);
    }
}
