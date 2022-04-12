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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            // basic metadata
            $table->unsignedInteger('salsah_id')->nullable();
            $table->string('label')->nullable()->index();
            $table->string('title')->nullable()->index();
            $table->string('signature')->nullable();
            $table->string('description')->nullable();
            
            // relationship metadata
            $table->unsignedInteger('date_id')->nullable();
            $table->foreign('date_id')->references('id')->on('dates')->onDelete('set null');

            // materiality metadata
            $table->unsignedInteger('object_type_id')->nullable();
            $table->foreign('object_type_id')->references('id')->on('object_types')->onDelete('set null');

            /*
                1:n relations:
                - people
                - comments
                - dates
                - images
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
        Schema::dropIfExists('albums');
    }
};
