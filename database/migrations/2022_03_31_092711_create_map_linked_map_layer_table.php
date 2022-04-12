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
        Schema::create('map_linked_map_layer', function (Blueprint $table) {
            $table->timestamps();
            
            $table->unsignedBigInteger('map_id')->nullable();
            $table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');

            $table->unsignedBigInteger('map_layer_id')->nullable();
            $table->foreign('map_layer_id')->references('id')->on('map_layers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_linked_map_layer');
    }
};
