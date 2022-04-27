<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('lead_id')->unique();
            $table->string('name')->nullable();
            $table->dateTime('created')->nullable();
            $table->integer('price')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('created_user_id')->nullable();
            $table->integer('responsible_user_id')->nullable();
            $table->json('custom_fields')->nullable();
            $table->integer('contact_id')->nullable();
            $table->integer('contact_responsible_user_id')->nullable();
            $table->dateTime('contact_created')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_test')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
