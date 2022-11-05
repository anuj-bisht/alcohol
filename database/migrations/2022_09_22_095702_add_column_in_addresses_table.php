<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->integer('zip_code')->after('id');
            $table->unsignedBigInteger('address_type_id')->after('user_id');
            $table->foreign('address_type_id')->on('address_type')->references('id')->onDelete('cascade');
            $table->tinyInteger('is_deleted')->default(0)->after('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn(['zip_code','address_type_id','is_deleted']);
        });
    }
}
