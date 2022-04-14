<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(20)->create();
       
        // Comment::factory(30)->create();
        
        Category::factory(20)->create();
        Product::factory(40)->create();

        // $comments = Comment::all();

        // foreach ($comments as $comment) {
        //     $u = rand(1, 21);
        //     $p = rand(1, 21);
        //     $comment->update(['user_id' => $u, 'product_id' => $p]);
        // }
    }
}
