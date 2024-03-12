<?php

namespace Database\Factories;

use App\Models\ProfileClinic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProfileClinicFactory extends Factory
{
    protected $model = ProfileClinic::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'logo' => $this->faker->word(),
            'description' => $this->faker->text(),
            'doctor_name' => $this->faker->name(),
            'unique_code' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
