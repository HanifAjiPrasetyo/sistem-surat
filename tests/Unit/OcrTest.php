<?php

namespace Tests\Feature;

use App\Services\OcrService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class OcrTest extends TestCase
{
    public function test_ocr_ktp_with_real_file()
    {
        // Lokasi file KTP yang sudah ada
        $ktpPath = storage_path('app/public/01JEQGXQMTKCCY6QZ1BYEDZZR8.jpeg'); // Sesuaikan path

        // Pastikan file ada
        $this->assertFileExists($ktpPath);

        // Inisiasi service
        $ocrService = new OcrService();

        try {
            // Proses OCR
            $result = $ocrService->OcrKTP($ktpPath);

            // Cetak hasil untuk debug
            return $result;

            // Atau assert sesuai kebutuhan
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // Tangani error
            $this->fail('OCR process failed: ' . $e->getMessage());
        }
    }
}
