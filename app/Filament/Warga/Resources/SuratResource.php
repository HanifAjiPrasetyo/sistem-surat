<?php

namespace App\Filament\Warga\Resources;

use App\Filament\Warga\Resources\SuratResource\Pages;
use App\Models\Surat;
use App\Models\Upload;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;
use Termwind\Components\Dd;

class SuratResource extends Resource
{
    protected static ?string $model = Surat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('no_surat')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignorable: fn($record) => $record)
                    ->disabled()
                    ->visible(fn($livewire) => $livewire instanceof Pages\EditSurat),
                Forms\Components\Select::make('keperluan')
                    ->options([
                        'Surat Keterangan Tidak Mampu' => 'Surat Keterangan Tidak Mampu',
                        'Surat Izin Usaha' => 'Surat Izin Usaha',
                        'Surat Keterangan Domisili' => 'Surat Keterangan Domisili',
                    ])
                    ->required()
                    ->reactive(),
                Forms\Components\Placeholder::make('')
                    ->content(function ($get) {
                        $keperluan = $get('keperluan');
                        if (!$keperluan) {
                            return 'Silakan pilih keperluan terlebih dahulu.';
                        }
                        return new HtmlString(view('filament.components.dokumen-info', ['keperluan' => $keperluan])->render());
                    })
                    ->visible(fn($get) => $get('keperluan') !== null),
                Forms\Components\FileUpload::make('lampiran_ktp')
                    ->label('Foto KTP')
                    ->directory('lampiran_ktp')
                    ->image()
                    ->helperText('Upload KTP Anda, pastikan foto cerah dan area KTP terlihat jelas')
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            try {
                                $client = new Client();
                                $token = config('services.ocr.token');
                                $path = $state->getRealPath();
                                $url = 'https://api.aksarakan.com/document/ktp';

                                $response = $client->request('PUT', "$url", [
                                    'headers' => [
                                        'Authentication' => "Bearer $token"
                                    ],
                                    'multipart' => [
                                        [
                                            'name'     => 'file',
                                            'contents' => fopen($path, 'rb'),
                                            'filename' => basename($path)
                                        ]
                                    ],
                                ]);

                                $ocrData = json_decode($response->getBody()->getContents(), true);

                                if (in_array($response->getStatusCode(), [200, 201])) {
                                    $set('ocrStatus', true);
                                    Carbon::setLocale('id');
                                    $tglLahir = Carbon::parse($ocrData['result']['tanggalLahir']['value'])->translatedFormat('d F Y');
                                    $set('nik', $ocrData['result']['nik']['value'] ?? null);
                                    $set('nama', $ocrData['result']['nama']['value'] ?? null);
                                    $set('agama', $ocrData['result']['agama']['value'] ?? null);
                                    $set('pekerjaan', $ocrData['result']['pekerjaan']['value'] ?? null);
                                    $set('statusPerkawinan', $ocrData['result']['statusPerkawinan']['value'] ?? null);
                                    $set('alamat', $ocrData['result']['alamat']['value'] ?? null);
                                    $set('rt', $ocrData['result']['rt']['value'] ?? null);
                                    $set('rw', $ocrData['result']['rw']['value'] ?? null);
                                    $set('kelurahanDesa', $ocrData['result']['kelurahanDesa']['value'] ?? null);
                                    $set('kecamatan', $ocrData['result']['kecamatan']['value'] ?? null);
                                    $set('kewarganegaraan', $ocrData['result']['kewarganegaraan']['value'] ?? null);
                                    $set('jenisKelamin', $ocrData['result']['jenisKelamin']['value'] ?? null);
                                    $set('tanggalLahir', $tglLahir ?? null);
                                    $set('tempatLahir', $ocrData['result']['tempatLahir']['value'] ?? null);
                                    $set('kabupatenKota', $ocrData['result']['kabupatenKota']['value'] ?? null);
                                    $set('provinsi', $ocrData['result']['provinsi']['value'] ?? null);

                                    Notification::make()
                                        ->title('OCR Berhasil')
                                        ->body('Data KTP berhasil diekstrak')
                                        ->success()
                                        ->send();
                                }
                            } catch (RequestException $e) {
                                Log::error('OCR Request Error: ' . $e->getMessage());

                                Notification::make()
                                    ->title('OCR Gagal')
                                    ->body('Gagal mengekstrak data KTP: ' . $e->getMessage())
                                    ->danger()
                                    ->send();
                            } catch (\Exception $e) {
                                Log::error('OCR General Error: ' . $e->getMessage());

                                Notification::make()
                                    ->title('Error')
                                    ->body('Terjadi kesalahan: ' . $e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }
                    }),
                Forms\Components\Section::make('Hasil Ekstrak Data KTP')
                    ->description('Ubah data jika tidak sesuai')
                    ->visible(fn($get) => $get('ocrStatus') == true)
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('nik')
                                ->label('NIK')
                                ->required(),
                            Forms\Components\TextInput::make('nama')
                                ->label('Nama')
                                ->required(),
                        ]),
                        Grid::make(3)->schema([
                            Forms\Components\TextInput::make('jenisKelamin')
                                ->label('Jenis Kelamin')
                                ->required(),
                            Forms\Components\TextInput::make('tempatLahir')
                                ->label('Tempat Lahir')
                                ->required(),
                            Forms\Components\TextInput::make('tanggalLahir')
                                ->label('Tanggal Lahir')
                                ->required(),
                        ]),
                        Grid::make(4)->schema([
                            Forms\Components\TextInput::make('kelurahanDesa')
                                ->label('Kelurahan/Desa')
                                ->required(),
                            Forms\Components\TextInput::make('kecamatan')
                                ->label('Kecamatan')
                                ->required(),
                            Forms\Components\TextInput::make('kabupatenKota')
                                ->label('Kabupaten/Kota')
                                ->required(),
                            Forms\Components\TextInput::make('provinsi')
                                ->label('Provinsi')
                                ->required(),
                        ]),
                        Grid::make(3)->schema([
                            Forms\Components\TextInput::make('alamat')
                                ->label('Alamat')
                                ->required(),
                            Forms\Components\TextInput::make('rt')
                                ->label('RT')
                                ->required(),
                            Forms\Components\TextInput::make('rw')
                                ->label('RW')
                                ->required(),
                        ]),
                        Grid::make(4)->schema([
                            Forms\Components\TextInput::make('kewarganegaraan')
                                ->label('Kewarganegaraan')
                                ->required(),
                            Forms\Components\TextInput::make('agama')
                                ->label('Agama')
                                ->required(),
                            Forms\Components\TextInput::make('statusPerkawinan')
                                ->label('Status Perkawinan')
                                ->required(),
                            Forms\Components\TextInput::make('pekerjaan')
                                ->label('Pekerjaan')
                                ->required(),
                        ]),
                    ]),
                Forms\Components\FileUpload::make('lampiran_lain')
                    ->label('Foto Dokumen Lainnya')
                    ->directory('lampiran_lain')
                    ->image()
                    ->multiple()
                    ->minFiles(1)
                    ->maxFiles(5)
                    ->required()
                    ->helperText('Upload minimal 1 dan maksimal sesuai yang diperlukan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('keperluan'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diajukan pada')
                    ->dateTime('d F Y H:i', 'Asia/Jakarta')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(function ($state) {
                        $words = explode('_', $state);
                        $formattedWords = array_map(function ($word) {
                            return ucfirst($word);
                        }, $words);
                        return implode(' ', $formattedWords);
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('catatan_admin')
                    ->label('Catatan Admin')
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('downloadPdf')
                    ->visible(fn($record) => $record->status == 'disetujui_admin')
                    ->label('Download Surat')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        $rt = User::whereHas('roles', function ($query) {
                            $query->where('name', 'rt');
                        })->first();
                        $rw = User::whereHas('roles', function ($query) {
                            $query->where('name', 'rw');
                        })->first();
                        $ttdRT = Upload::where('nama_file', 'TTD RT')->first();
                        $ttdRW = Upload::where('nama_file', 'TTD RW')->first();
                        $stampRT = Upload::where('nama_file', 'STEMPEL RT')->first();
                        $stampRW = Upload::where('nama_file', 'STEMPEL RW')->first();
                        $pdf = Pdf::loadView('surat.surpeng', ['record' => $record, 'rt' => $rt, 'rw' => $rw, 'ttdRT' => $ttdRT, 'ttdRW' => $ttdRW, 'stampRT' => $stampRT, 'stampRW' => $stampRW]);
                        $pdf->setPaper('A4');
                        return response()->streamDownload(
                            fn() => print($pdf->stream()),
                            'suratPengantar-' . $record->id . '.pdf'
                        );
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurats::route('/'),
            'create' => Pages\CreateSurat::route('/create'),
            'edit' => Pages\EditSurat::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id());
    }
}
