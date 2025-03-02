<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contentable_tags', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('title')->unique()->index();
            $table->string('slug')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('contentable_taggables', function (Blueprint $table) {
            $table->foreignId('tag_id');
            $table->morphs('taggable');
            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
            $table->foreign('tag_id')
                ->references('id')
                ->on('contentable_tags')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('contentable_tags');
        Schema::dropIfExists('contentable_taggables');
    }
};
