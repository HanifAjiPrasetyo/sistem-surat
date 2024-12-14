<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make('password123');

        return $data;
    }

    protected function afterCreate(): void
    {
        $user = $this->record;
        $roles = $this->data['roles'];

        $user->roles()->sync($roles);
    }
}
