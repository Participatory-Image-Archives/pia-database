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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            // basic metadata
            $table->unsignedInteger('salsah_id')->nullable();
            $table->string('oldnr')->nullable();
            $table->string('signature')->nullable();
            $table->string('sequence_number')->nullable();
            
            $table->string('title')->nullable()->index();
            $table->string('salsah_title')->nullable();
            $table->string('origin')->nullable();

            // associated image file
            $table->string('file_name')->nullable();
            $table->string('original_file_name')->nullable();
            $table->string('base_path')->nullable();

            // relationship metadata
            $table->unsignedInteger('place_id')->nullable();
            $table->foreign('place_id')->references('id')->on('places')->onDelete('set null');

            $table->unsignedInteger('date_id')->nullable();
            $table->foreign('date_id')->references('id')->on('dates')->onDelete('set null');

            $table->unsignedInteger('copyright_id')->nullable();
            $table->foreign('copyright_id')->references('id')->on('agents')->onDelete('set null');

            /*
                1:n relations:
                - people
                - keywords
                - comments
            */
            
            // materiality metadata
            $table->unsignedInteger('object_type_id')->nullable();
            $table->foreign('object_type_id')->references('id')->on('object_types')->onDelete('set null');

            $table->unsignedInteger('model_type_id')->nullable();
            $table->foreign('model_type_id')->references('id')->on('model_types')->onDelete('set null');

            $table->unsignedInteger('format_id')->nullable();
            $table->foreign('format_id')->references('id')->on('formats')->onDelete('set null');

            // TODO
            /*
                - copyright
                - references to other images
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
        Schema::dropIfExists('images');
    }
};
