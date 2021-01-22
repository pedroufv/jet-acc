<?php

namespace Database\Factories;

use App\Models\Contractor;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contractor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'team_id' => Team::factory(),
            'name' => $this->faker->unique()->company,
            'company_name' => $this->faker->unique()->name,
            'identifier' => $this->faker->numerify('###.###.###'),
        ];
    }
}
