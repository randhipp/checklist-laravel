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
            $table->string('task_id')->after('id')->nullable();
            $table->string('object_id')->after('id');
            $table->string('object_domain')->after('id');
            $table->integer('deleted_by')->nullable()->after('due_unit');
            $table->integer('updated_by')->nullable()->after('due_unit');
            $table->integer('created_by')->nullable()->after('due_unit');
            $table->boolean('completed_at')->nullable()->after('due_unit');
            $table->boolean('is_completed')->nullable()->default(false)->after('due_unit');
            $table->dateTime('due')->nullable()->after('due_unit');
            $table->integer('urgency')->after('due_unit')->nullable();
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
