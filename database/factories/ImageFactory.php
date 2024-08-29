<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        return [
            'url' => $this->faker->imageUrl(),
            'imageable_id' => null, // to be set in the seeder
            'imageable_type' => null, // to be set in the seeder
        ];
    }
}
