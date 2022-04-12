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
        Schema::create('alt_label_keyword', function (Blueprint $table) {
            $table->timestamps();

            $table->unsignedBigInteger('alt_label_id')->nullable();
            $table->foreign('alt_label_id')->references('id')->on('alt_labels')->onDelete('cascade');
            
            $table->unsignedBigInteger('keyword_id')->nullable();
            $table->foreign('keyword_id')->references('id')->on('keywords')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alt_label_keyword');
    }
};
