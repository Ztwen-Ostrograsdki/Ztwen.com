<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if(Product::all()->count() > 0 && User::all()->count() > 0){

            $product_id = Product::all()->pluck('id')->shuffle()->first();
            $user_id = User::all()->pluck('id')->shuffle()->first();
            $approved = false;
            if($user_id == 1){
                $approved = true;
            }
            return [
                'content' => $this->faker->paragraph(2),
                'user_id' => $user_id,
                'product_id' => $product_id,
                'approved' => $approved,
            ];
        }
        else{
            return [];
        }
    }
}
