<?php

use App\Enums\PackageType;
use App\Enums\StatusStory;
use App\Enums\StoryType;
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
            $table->enum('status', [StatusStory::PENDING, StatusStory::ACTIVE, StatusStory::BAN])->default(StatusStory::PENDING);
            $table->string('cover_image')->nullable();
            $table->enum('package_type', [PackageType::FREE, PackageType::BASE, PackageType::PREMIUM])->default(PackageType::FREE);
            $table->enum('story_type', [StoryType::NOVEL, StoryType::COMIC])->default(StoryType::NOVEL);
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
