<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OcrService;

class OcrController extends Controller
{
    protected $ocrService;

    public function __construct(OcrService $ocrService)
    {
        $this->ocrService = $ocrService;
    }

    public function processKTP()
    {
        // Validasi input file
        $fullPath = asset('storage/01JEQH1D84JG84EYFWRDF8BX4W.jpeg');

        try {
            // Proses OCR
            $result = $this->ocrService->OcrKTP($fullPath);

            // Hapus file sementara
            unlink($fullPath);

            // Kembalikan response
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            // Hapus file sementara jika ada error
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
