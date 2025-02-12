<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('artist_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('album_id')->nullable()->constrained()->onDelete('set null');
            $table->string('genre')->nullable();
            $table->string('file_path'); // Đường dẫn file nhạc
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('songs');
    }
};

