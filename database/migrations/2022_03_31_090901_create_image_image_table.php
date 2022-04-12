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
        Schema::create('image_image', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->tinyInteger('type')->nullable();

            /*
                Type:
                    1: Reference
                    2: Verso
            */

            $table->unsignedBigInteger('image_a_id')->nullable();
            $table->foreign('image_a_id')->references('id')->on('images')->onDelete('cascade');
            
            $table->unsignedBigInteger('image_b_id')->nullable();
            $table->foreign('image_b_id')->references('id')->on('images')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_image');
    }
};
