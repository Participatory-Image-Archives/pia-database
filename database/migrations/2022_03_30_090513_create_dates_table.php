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
        Schema::create('dates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            // legacy date string from salsah takeover
            $table->string('date_string')->nullable();

            // date data
            $table->date('date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('accuracy')->nullable();

            /*
                Accuracy:
                    1: to the day
                    2: to the month
                    3: to the year
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
        Schema::dropIfExists('dates');
    }
};
