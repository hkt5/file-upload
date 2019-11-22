<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_versions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('file_id')->nullable(false);
            $table->foreign('file_id')->references('id')->on('file_uploads')->onDelete('cascade');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE file_versions ADD file_body LONGBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         
         Schema::dropIfExists('file_versions');
         Schema::dropIfExists('file_uploads');
    }
}
