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
        Schema::create('model_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            // basic metadata
            $table->string('label')->nullable();
            $table->string('comment')->nullable();

            // extending keywords through aat
            $table->unsignedInteger('aat_id')->nullable();
            $table->string('aat_uri')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('models');
    }
};
