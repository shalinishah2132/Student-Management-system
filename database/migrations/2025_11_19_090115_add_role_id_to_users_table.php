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
    Schema::table('users', function (Blueprint $table) {
        $table->unsignedBigInteger('role_id')->nullable()->after('email');
        
        $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
        public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['role_id']);

            // Drop the column
            $table->dropColumn('role_id');
        });
    }
};
