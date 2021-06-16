<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvertJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convert_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('job_number');
            $table->string('file_download_name');
            $table->integer('status')->default(0)->comment('0:Pending;1:Success;2:Failed;');
            $table->string('output_file')->nullable();
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
        Schema::dropIfExists('convert_jobs');
    }
}
