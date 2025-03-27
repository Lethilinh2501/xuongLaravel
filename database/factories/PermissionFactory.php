<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Permission;
use App\Models\Role;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'role_id' => Role::inRandomOrder()->first()->id ?? Role::factory(),
            'permission_name' => $this->faker->word,
        ];
    }
}
