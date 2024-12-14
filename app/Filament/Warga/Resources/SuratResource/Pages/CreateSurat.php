<?php

namespace App\Filament\Warga\Resources\SuratResource\Pages;

use App\Filament\Warga\Resources\SuratResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class CreateSurat extends CreateRecord
{
    protected static string $resource = SuratResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['no_surat'] = 'TEMP-' . time();

        return $data;
    }

    protected function afterCreate()
    {
        $data = $this->data;
        $surat = $this->record;

        $surat->userData()->create([
            'surat_id' => $surat['id'],
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'tempat_lahir' => $data['tempatLahir'],
            'tgl_lahir' => $data['tanggalLahir'],
            'alamat' => $data['alamat'] . " RT " . $data['rt'] . " RW " . $data['rw'] . ", " . $data['kelurahanDesa'] . ", " . $data['kecamatan'] . ", " . $data['kabupatenKota'] . ", " . $data['provinsi'],
            'agama' => $data['agama'],
            'pekerjaan' => $data['pekerjaan'],
            'status_perkawinan' => $data['statusPerkawinan'],
            'kewarganegaraan' => $data['kewarganegaraan'],
            'jenis_kelamin' => $data['jenisKelamin'],
        ]);

        return Notification::make()
            ->success()
            ->title('Surat Berhasil Dibuat')
            ->body('Surat Anda telah berhasil diajukan dan akan diproses.')
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }
}
