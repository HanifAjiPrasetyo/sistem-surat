<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Filament\Models\Contracts\FilamentUser;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Panggil seeder RoleSeeder untuk master data Role
        $this->call(RoleSeeder::class);

        // Cari role admin dan warga
        $adminRole = Role::where('name', 'admin')->first();
        $wargaRole = Role::where('name', 'warga')->first();
        $rtRole = Role::where('name', 'rt')->first();
        $rwRole = Role::where('name', 'rw')->first();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin.sisurpeng@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        $rt = User::create([
            'name' => 'Pak RT',
            'email' => 'pakrt@gmail.com',
            'password' => Hash::make('password123'),
        ]);
        $rw = User::create([
            'name' => 'Pak RW',
            'email' => 'pakrw@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // Assign role admin ke user admin
        $admin->roles()->attach($adminRole);
        $admin->roles()->attach($wargaRole);

        $rt->roles()->attach($rtRole);
        $rt->roles()->attach($wargaRole);

        $rw->roles()->attach($rwRole);
        $rw->roles()->attach($wargaRole);
    }
}
