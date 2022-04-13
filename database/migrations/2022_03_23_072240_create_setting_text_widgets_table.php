<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTextWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_text_widgets', function (Blueprint $table) {
            $table->id();
            $table->string('s1_title')->nullable();
            $table->string('s2_title')->nullable();
            $table->text('s2_text')->nullable();
            $table->string('s3_title')->nullable();
            $table->text('s3_text')->nullable();
            $table->string('s4_title')->nullable();
            $table->text('s4_text')->nullable();
            $table->string('s5_title')->nullable();
            $table->text('s5_text')->nullable();
            $table->string('s6_title')->nullable();
            $table->text('s6_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_text_widgets');
    }
}
