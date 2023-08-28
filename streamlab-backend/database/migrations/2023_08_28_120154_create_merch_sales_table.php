<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('merch_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('streamlab_id')->constrained('streamlabs_users');
            $table->string('item_name');
            $table->integer('amount');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('merch_sales');
    }
};
