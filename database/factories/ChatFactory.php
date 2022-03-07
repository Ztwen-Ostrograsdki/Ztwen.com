<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $receiver = 1;
        $sender = rand(1, 2);
        if ($sender == 1) {
            $receiver = 2;
        }
        else{
            $receiver = 1;
        }
        return [
            'message' => $this->faker->paragraph(4),
            'sender_id' => $sender,
            'receiver_id' => $receiver,
        ];
    }
}
