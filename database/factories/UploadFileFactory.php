<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UploadFile;
use App\Models\User;

class UploadFileFactory extends Factory
{
    protected $model = UploadFile::class;
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(), // Lấy user ngẫu nhiên hoặc tạo mới
            'file_name' => $this->faker->word . '.' . $this->faker->fileExtension(),
            'file_path' => $this->faker->imageUrl(640, 480, 'cats', true,'Faker'),
            'file_type' => $this->faker->mimeType,
        ];
    }
}
