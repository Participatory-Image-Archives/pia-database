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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            // basic metadata
            $table->unsignedInteger('salsah_id')->nullable();
            $table->string('title')->nullable()->index();
            $table->string('label')->nullable()->index();
            $table->string('signature')->nullable();
            $table->string('description')->nullable();

            $table->string('default_image')->nullable();
            $table->string('embedded_video')->nullable();

            $table->string('origin')->nullable();

            // relationship metadata
            $table->unsignedInteger('date_id')->nullable();
            $table->foreign('date_id')->references('id')->on('dates')->onDelete('set null');
            /*
                1:n relations:
                - people
                - comments
                - dates
                - literatures
                - alternative labels
                - TODO: keywords
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
        Schema::dropIfExists('collections');
    }
};
