<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFieldsNullableProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('province')->nullable()->change();
            $table->string('city_municipality')->nullable()->change();
            $table->string('barangay')->nullable()->change();
        });
        //->nullable()->change();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('province')->change();
            $table->string('city_municipality')->change();
            $table->string('barangay')->change();
        });
    }
}
