<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlamableFieldItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->bigInteger('task_id')->after('checklist_id')->nullable();
            $table->bigInteger('assignee_id')->after('checklist_id')->nullable();
            $table->integer('deleted_by')->nullable()->after('due_unit');
            $table->integer('updated_by')->nullable()->after('due_unit');
            $table->integer('created_by')->nullable()->after('due_unit');
            $table->dateTime('completed_at')->nullable()->after('due_unit');
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
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('task_id');
            $table->dropColumn('assignee_id');
            $table->dropColumn('completed_at');
            $table->dropColumn('is_completed');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('deleted_by');
        });
    }
}
