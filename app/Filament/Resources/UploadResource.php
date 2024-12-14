<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UploadResource\Pages;
use App\Filament\Resources\UploadResource\RelationManagers;
use App\Models\Upload;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UploadResource extends Resource
{
    protected static ?string $model = Upload::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_file')
                    ->label('Nama File')
                    ->required(),
                FileUpload::make('path')
                    ->label('Upload File')
                    ->directory('uploads')
                    ->image()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_file')
                    ->label('Nama File'),
                ImageColumn::make('path')
                    ->label('File')
                    ->circular(),
                TextColumn::make('created_at')
                    ->label('Diupload Pada')
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
            'index' => Pages\ListUploads::route('/'),
            'create' => Pages\CreateUpload::route('/create'),
            'edit' => Pages\EditUpload::route('/{record}/edit'),
        ];
    }
}
