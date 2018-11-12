<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_year_id')->unsigned();
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
            $table->integer('term_id')->unsigned();
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->integer('grade_activity_category_id')->unsigned();
            $table->foreign('grade_activity_category_id')->references('id')->on('grade_activity_categories')->onDelete('cascade');
            $table->string('grade_activity_name');
            $table->string('grade_activity_description');
            $table->decimal('grade_activity_weight', 3, 1);
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
        Schema::dropIfExists('grade_activities');
    }
}
