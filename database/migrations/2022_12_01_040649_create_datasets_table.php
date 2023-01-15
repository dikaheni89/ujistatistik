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
        Schema::create('datasets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisation_id')->index();
            $table->string('name', 100);
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('author_email')->nullable();
            $table->string('maintainer')->nullable();
            $table->string('maintainer_email')->nullable();
            $table->string('license_id')->nullable();
            $table->text('notes')->nullable();
            $table->text('url')->nullable();
            $table->text('version', 100)->nullable();
            $table->boolean('private')->default(false);
            $table->timestamps();

            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datasets');
    }
};
