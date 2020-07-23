<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailArticleRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_article_relations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mail_id')->unsigned()->index();
            $table->bigInteger('article_history_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('mail_id')->references('id')->on('mail_contents');
            $table->foreign('article_history_id')->references('id')->on('article_histories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_article_relations');
    }
}
