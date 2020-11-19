<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlamableFieldChecklists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checklists', function (Blueprint $table) {
            $table->string('object_domain')->after('id')->default('domain');
            $table->integer('deleted_by')->nullable()->after('due_unit');
            $table->integer('updated_by')->nullable()->after('due_unit');
            $table->integer('created_by')->nullable()->after('due_unit');
            $table->boolean('is_completed')->nullable()->default(false)->after('due_unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checklists', function (Blueprint $table) {
            $table->dropColumn('object_domain');
            $table->dropColumn('is_completed');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('deleted_by');
        });
    }
}
