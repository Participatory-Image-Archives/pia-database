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
        Schema::create('call_entry_keyword', function (Blueprint $table) {
            $table->timestamps();

            $table->unsignedBigInteger('call_entry_id')->nullable();
            $table->foreign('call_entry_id')->references('id')->on('call_entries')->onDelete('cascade');
            
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
        Schema::dropIfExists('call_entry_keyword');
    }
};
