<?php

use App\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Initial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(true);
            $table->text('description')->nullable(true);
            $table->string('address')->nullable(true);
            $table->string('place')->nullable(true);
            $table->dateTimeTz('start_at')->nullable(true);
            $table->dateTimeTz('end_at')->nullable(true);
            $table->integer('max')->default(0);
            $table->integer('price')->default(0);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference')->nullable(true);
            $table->string('name')->nullable(true);
            $table->string('email')->nullable(true);
            $table->tinyInteger('status')->default(Order::INITIAL);
            $table->integer('amount')->default(0);
            $table->integer('total')->default(0)->comment('有多少人');
            $table->unsignedInteger('event_id')->nullable(false);
            $table->foreign('event_id')->references('id')->on('events');
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('events');
    }
}
