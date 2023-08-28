<?php

use App\Models\StreamlabsUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('streamlabs_users', function (Blueprint $table) {
            $table->id();
            $table->string('streamlab_id')->unique();
            // Add other columns as needed
            $table->timestamps();
        });

        for ($i = 1; $i <= 500; $i++) {
            StreamlabsUser::create([
                'streamlab_id' => $i
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streamlabs_users');
    }
};
