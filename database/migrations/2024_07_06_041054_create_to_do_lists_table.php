<?php

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
        Schema::create('to_do_lists', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->string('status');
            $table->date('date');
            $table->bigInteger('user_id');
            $table->text('keterangan'); 
            $table->text('pesan')->nullable();
            $table->bigInteger('attendance_id');
            $table->timestamps();
           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('to_do_lists');
    }
};

