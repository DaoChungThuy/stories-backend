<?php

use App\Enums\UserServiceStatus;
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
        Schema::create('user_service_packages', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('service_package_id');
            $table->timestamp('start_date');
            $table->enum('status', [UserServiceStatus::ACTIVE, UserServiceStatus::UNACTIVE])->default(UserServiceStatus::ACTIVE);
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
        Schema::dropIfExists('user_service_pakages');
    }
};
