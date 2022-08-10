<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Category::insert([
            ['name' => 'Alimentação'],
            ['name' => 'Saúde'],
            ['name' => 'Moradia'],
            ['name' => 'Transporte'],
            ['name' => 'Educação'],
            ['name' => 'Lazer'],
            ['name' => 'Imprevistos'],
            ['name' => 'Outros'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
