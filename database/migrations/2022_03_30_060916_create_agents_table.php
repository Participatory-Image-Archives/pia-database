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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            // basic metadata
            $table->unsignedInteger('salsah_id')->nullable();
            $table->string('name')->nullable();
            $table->string('given_name')->nullable();
            $table->string('family_name')->nullable();
            $table->string('title')->nullable();
            $table->string('family')->nullable();

            $table->string('description')->nullable();
            $table->tinyInteger('type')->nullable();

            // relational data
            $table->unsignedInteger('birthplace_id')->nullable();
            $table->foreign('birthplace_id')->references('id')->on('places')->onDelete('set null');
            $table->unsignedInteger('deathplace_id')->nullable();
            $table->foreign('deathplace_id')->references('id')->on('places')->onDelete('set null');

            $table->unsignedInteger('birthdate_id')->nullable();
            $table->foreign('birthdate_id')->references('id')->on('dates')->onDelete('set null');
            $table->unsignedInteger('deathdate_id')->nullable();
            $table->foreign('deathdate_id')->references('id')->on('dates')->onDelete('set null');

            // extended people through gnd
            $table->unsignedInteger('gnd_id')->nullable();
            $table->string('gnd_uri')->nullable();

            /*
                1:n relations:
                - comments
                - jobs
                - related literature
                - alternative names (alt_labels)
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
        Schema::dropIfExists('agents');
    }
};
