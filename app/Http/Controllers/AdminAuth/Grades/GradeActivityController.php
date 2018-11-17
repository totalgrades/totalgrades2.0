<?php

namespace App\Http\Controllers\AdminAuth\Grades;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\School_year;
use App\Event;
use App\Term;
use Carbon\Carbon;

use App\Http\Requests;
use Auth;
use Image;
use App\Student;
use App\Group;
use App\Staffer;
use App\Course;

use App\Admin;
use \Crypt;
use App\GradeActivity;
use App\GradeActivityCategory;
use DB;
use App\Grade;

class GradeActivityController extends Controller
{
    public function showStudents(School_year $schoolyear, Term $term , Course $course){

    	$grade_activity_categories = GradeActivityCategory::where('course_id', $course->id)->get();

        $grade_activities = GradeActivity::where('course_id', $course->id)->orderBy('grade_activity_category_id')->get();

        $student_grades = Grade::get();

        $grades_and_activities = DB::table('grades')
                    ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
                    ->where('grade_activities.school_year_id', $schoolyear->id)
                    ->where('grade_activities.term_id', $term->id)
                    ->where('grade_activities.course_id', $course->id)
                    ->get();
       

        //dd($grade_activities->sum('grade_activity_weight'));
        
    	return view('admin.grades.gradeactivity.students', compact('schoolyear', 'term', 'course', 'grade_activity_categories', 'grade_activities', 'student_grades', 'grades_and_activities'));
    }

    public function addStudentGrade(Request $r, GradeActivity $gradeactivity){

    	$max_point = GradeActivity::where('id', $gradeactivity->id)->first();

        $max_value = $max_point->max_point;

        $this->validate(request(), [

            'grade_activity_id' => 'required',
            'student_id' => 'required',
            'activity_grade' => "required|numeric|min:0|max:$max_value",
                    

    		]);

    	Grade::insert([

            'grade_activity_id' => $r->grade_activity_id,
            'student_id' => $r->student_id,
            'activity_grade' => ($r->activity_grade/$gradeactivity->max_point)*$gradeactivity->grade_activity_weight,
            'actual_grade'=>$r->activity_grade,
    		'activity_comment'=>$r->activity_comment,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),    
    	]);

    	flash('Grade Added Successfully!')->success();

    	return back();
    }

    public function editStudentGrade(Request $r, GradeActivity $gradeactivity, Grade $grade){

        $max_point = GradeActivity::where('id', $gradeactivity->id)->first();

        $max_value = $max_point->max_point;

    	$this->validate(request(), [

            'activity_grade' => "required|numeric|min:0|max:$max_value",
            //'activity_comment'=> 'required',
            
    		]);

    	$edit_grade = Grade::where('id', '=', $grade->id)->first();
         
        $edit_grade->activity_grade = ($r->activity_grade/$gradeactivity->max_point)*$gradeactivity->grade_activity_weight;
        $edit_grade->actual_grade = $r->activity_grade;
        $edit_grade->activity_comment = $r->activity_comment;
              
        $edit_grade->save();
    	
    	flash('Grade Updated!')->info();

    	return back();
    }

    public function deleteStudentGrade(Grade $grade){

    	Grade::where('id', $grade->id)->delete();

        flash('Grade Deleted!')->warning();
        	
    	return back();
    }

    // Add edit Student Grades from the Grades set up page

    public function studentsCategoryGrades(GradeActivityCategory $gradeactivitycategory, School_year $schoolyear, Term $term , Course $course){

        
        $grade_activities = GradeActivity::where('grade_activity_category_id', $gradeactivitycategory->id)->get();
        
        $student_grades = Grade::get();

        $grades_and_activities = DB::table('grades')
                    ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
                    ->where('grade_activities.school_year_id', $schoolyear->id)
                    ->where('grade_activities.term_id', $term->id)
                    ->where('grade_activities.grade_activity_category_id', $gradeactivitycategory->id)
                    ->get();

        //dd($grades_and_activities);

        return view('admin.grades.gradeactivity.studentscategorygrades', compact( 'gradeactivitycategory', 'schoolyear', 'term', 'course', 'grade_activities', 'student_grades', 'grades_and_activities'));
    }
}
