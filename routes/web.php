<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing-page.layouts.main');
});

Route::get('/ocr', function () {
    return view('surat.surpeng');
});
