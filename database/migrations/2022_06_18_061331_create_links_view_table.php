<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_views', function (Blueprint $table) {
            $table->id();
            $table->integer('link_id')->index();
            $table->string('user_id', 64);
            $table->timestamp('view_date');
            $table->string('user_ip', 15);
            $table->text('user_agent');
            $table->timestamps();
            $table->index(['user_ip', 'user_agent']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links_stats');
    }
};
