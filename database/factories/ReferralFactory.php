<?php

namespace Database\Factories;

use App\Enums\ReferralStatus;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferralFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Referral::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'referrer_user_id' => User::factory()->create()->id,
            'recipient_email' => $this->faker->unique()->safeEmail(),
            'status' => ReferralStatus::Sent
        ];
    }

    /**
     * Indicate that the referral was already claimed
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function claimed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => ReferralStatus::Claimed
            ];
        });
    }
}
