<?php

use App\Enums\BookType;
use App\Enums\StatusBook;
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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('author_id');
            $table->integer('genre_id');
            $table->string('description')->nullable();
            $table->enum('status', [StatusBook::PENDING, StatusBook::ACTIVE, StatusBook::BAN])->default(StatusBook::PENDING);
            $table->string('cover_image')->nullable();
            $table->enum('type', [BookType::FREE, BookType::BASE, BookType::PREMIUM])->default(BookType::FREE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
