<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductComment;

class ProductCommentSeeder extends Seeder
{
    public function run(): void
    {
        ProductComment::factory(50)->create();
    }
}
