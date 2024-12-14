<?php

namespace App\Filament\Resources\SuratResource\Pages;

use App\Filament\Resources\SuratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSurat extends EditRecord
{
    protected static string $resource = SuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['status'] == 'disetujui_admin') {
            $data['catatan_admin'] = 'Surat dapat didownload';

            $surat = $this->record;

            $data['no_surat'] = '0' . $surat['id'] . "/RT01-RW01/KEL.PAKUNDEN/" . $surat['created_at']->format('m') . "/" . $surat['created_at']->format('Y');
        }

        return $data;
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
