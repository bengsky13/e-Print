<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('session')->unique();
            $table->unsignedBigInteger('outlet_id'); // Change to unsignedBigInteger
            $table->integer('status');
            $table->integer('color')->default(0);
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
        });
    }

    public function down(): void
    {
    }
};
