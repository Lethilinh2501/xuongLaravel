<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role::truncate(); // Xóa dữ liệu cũ trước khi thêm mới
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Admin']);
    }
}
