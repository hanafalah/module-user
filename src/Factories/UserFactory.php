<?php

namespace Hanafalah\ModuleUser\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class UserFactory extends Factory
{
    /**
     * Create a new factory instance.
     *
     * @param  int|null  $count
     * @param  \Illuminate\Database\Eloquent\Collection|null  $states
     * @param  \Illuminate\Database\Eloquent\Collection|null  $has
     * @param  \Illuminate\Database\Eloquent\Collection|null  $for
     * @param  \Illuminate\Database\Eloquent\Collection|null  $afterMaking
     * @param  \Illuminate\Database\Eloquent\Collection|null  $afterCreating
     * @param  string|null  $connection
     * @param  \Illuminate\Database\Eloquent\Collection|null  $recycle
     * @return void
     */
    public function __construct(
        $count = null,
        ?Collection $states = null,
        ?Collection $has = null,
        ?Collection $for = null,
        ?Collection $afterMaking = null,
        ?Collection $afterCreating = null,
        $connection = null,
        ?Collection $recycle = null
    ) {
        $this->model = app(config('database.models.User'));
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection, $recycle);
    }

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username'          => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => now(),
        ]);
    }
}
