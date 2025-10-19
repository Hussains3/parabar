<?php

namespace Database\Factories;

use App\Models\AdvisoryCommittee;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvisoryCommitteeFactory extends Factory
{
    protected $model = AdvisoryCommittee::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'designation' => $this->faker->jobTitle(),
            'photo' => 'photos/' . $this->faker->image('public/storage/photos', 400, 400, null, false),
            'order' => $this->faker->unique()->numberBetween(1, 100),
            'active' => $this->faker->boolean(),
            'type' => $this->faker->randomElement(['type1', 'type2', 'type3']),
            'message' => $this->faker->paragraph(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'officename' => $this->faker->company(),
            'officeaddress' => $this->faker->address(),
        ];
    }
}
