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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('label')->nullable();
            $table->string('origin')->nullable();

            // place data
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->string('geometry')->nullable();

            // geonames
            $table->unsignedInteger('geonames_id')->nullable();
            $table->string('geonames_uri')->nullable();
            $table->string('geonames_code')->nullable();
            $table->string('geonames_code_name')->nullable();
            $table->string('geonames_division_level')->nullable();

            // other place related information
            $table->string('wiki_uri')->nullable();
            $table->string('swisstopo_uri')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
};
