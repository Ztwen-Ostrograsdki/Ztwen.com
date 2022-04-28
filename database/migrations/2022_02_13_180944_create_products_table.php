<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('description');
            $table->boolean('bought')->default(false);
            $table->unsignedBigInteger('total')->default(rand(150, 1000));
            $table->unsignedBigInteger('seen')->nullable()->default(0);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sells')->nullable()->default(0);
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->decimal('price', 12, 2)->default(500)->nullable();
            $table->decimal('reduction', 12, 2)->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
