<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CartDetail;

class CartDetailSeeder extends Seeder
{
    public function run()
    {
        CartDetail::factory(20)->create(); // Tạo 20 bản ghi mẫu
    }
}
