<?php

use App\Enums\BookType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->string('service_package_name');
            $table->double('price');
            $table->integer('duration');
            $table->enum('type', [BookType::FREE, BookType::BASE, BookType::PREMIUM])->default(BookType::FREE);
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
        Schema::dropIfExists('service_pakages');
    }
};
