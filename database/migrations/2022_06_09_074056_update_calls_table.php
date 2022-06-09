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
         Schema::table('calls', function (Blueprint $table) {
            $table->tinyInteger('type')->nullable();
        });       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calls', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
