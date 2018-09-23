<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsRelated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->text('related_event_ids')->nullable(true);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('related_order_id')->nullable(true);
            $table->foreign('related_order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('related_event_ids');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['related_order_id']);
            $table->dropColumn('related_order_id');
        });
    }
}
