<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratResource\Pages;
use App\Filament\Resources\SuratResource\RelationManagers;
use App\Models\Surat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuratResource extends Resource
{
    protected static ?string $model = Surat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('Nama Pengaju')
                    ->disabled(),
                Forms\Components\TextInput::make('keperluan')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                Forms\Components\FileUpload::make('lampiran_ktp')
                    ->directory('ktp')
                    ->image()
                    ->label('Lampiran KTP')
                    ->disabled(),
                Forms\Components\FileUpload::make('lampiran_lain')
                    ->directory('lain')
                    ->image()
                    ->multiple()
                    ->label('Lampiran Lain')
                    ->disabled(),
                Forms\Components\Select::make('status')
                    ->options([
                        'disetujui_admin' => 'Disetujui',
                        'ditolak_admin' => 'Ditolak',
                    ])
                    ->required()
                    ->reactive(),
                Forms\Components\Textarea::make('catatan_admin')
                    ->label('Catatan')
                    ->maxLength(1000)
                    ->hidden(fn(callable $get) => $get('status') !== 'ditolak_admin')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keperluan')
                    ->searchable(),
                ImageColumn::make('lampiran_ktp')
                    ->label('Lampiran KTP')
                    ->circular(),
                ImageColumn::make('lampiran_lain')
                    ->label('Lampiran Lain')
                    ->circular()
                    ->stacked()
                    ->limit(5),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(function ($state) {
                        $words = explode('_', $state);
                        $formattedWords = array_map(function ($word) {
                            return ucfirst($word);
                        }, $words);
                        return implode(' ', $formattedWords);
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diajukan pada')
                    ->dateTime('d F Y H:i', 'Asia/Jakarta')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
}
