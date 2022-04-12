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
        Schema::create('map_entry_map_key', function (Blueprint $table) {
            $table->timestamps();
            
            $table->unsignedBigInteger('map_entry_id')->nullable();
            $table->foreign('map_entry_id')->references('id')->on('map_entries')->onDelete('cascade');

            $table->unsignedBigInteger('map_key_id')->nullable();
            $table->foreign('map_key_id')->references('id')->on('map_keys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_entry_map_key');
    }
};
