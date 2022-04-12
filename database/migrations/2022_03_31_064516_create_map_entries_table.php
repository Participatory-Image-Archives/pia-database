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
        Schema::create('map_entries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('label')->nullable();
            $table->string('description')->nullable();

            $table->tinyInteger('type')->nullable();
            $table->string('complex_data')->nullable();

            // relations
            $table->unsignedInteger('place_id')->nullable();
            $table->foreign('place_id')->references('id')->on('places')->onDelete('set null');

            $table->unsignedInteger('map_layer_id')->nullable();
            $table->foreign('map_layer_id')->references('id')->on('map_layers')->onDelete('set null');

            // TODO: is this a document, or an iiif image
            $table->unsignedInteger('image_id')->nullable();
            $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');

            /*
                Type can be either:
                
                    1: precise, which is a marker placed on the map by hand; leading to the creation of a location
                    2: complex, which is mutiple markers, a shape or line or an image; stores the information in complex_data
                    3: image, overlaying the map; stores information in complex_data
                    4: image, as marker; leading to the creation of a location

            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_entries');
    }
};
