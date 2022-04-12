<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection= 'pia';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_keys', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('label')->nullable();

            // associated image file
            $table->string('icon')->nullable();
            $table->string('icon_file_name')->nullable();
            $table->string('original_icon_file_name')->nullable();

            // belongs to map
            $table->unsignedInteger('map_id')->nullable();
            $table->foreign('map_id')->references('id')->on('maps')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_keys');
    }
};
