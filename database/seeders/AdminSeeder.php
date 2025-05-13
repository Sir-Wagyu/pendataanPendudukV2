<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => '10' . str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT),
            'username' => 'admin',
            'nik' => '1234567890123456',
            'name' => 'Super Admin',
            'alamat' => 'Jl. Raya No. 1',
            'email' => 'admin@admin.com',
            'telepon' => '08123456789',
            'role' => 'admin',
            'password' => Hash::make('admin'),
            'status' => 'approved',
            'must_change_password' => true,
        ]);
    }
}
