<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_user', function (Blueprint $table) {
            $table->id(); // This creates an auto-incrementing 'id' column
            $table->unsignedBigInteger('user_id'); // This creates an unsigned BIGINT 'user_id' column
            $table->unsignedBigInteger('org_type_id'); // This creates an unsigned BIGINT 'org_type_id' column

            // Adding foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('org_type_id')->references('id')->on('org_type')->onDelete('cascade');

            $table->timestamps(); // This creates 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('org_user');
    }
}
