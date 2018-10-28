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
use DB;
use App\Grade;

class GradeActivityController extends Controller
{
    public function showStudents(GradeActivity $gradeactivity, School_year $schoolyear, Term $term ){

    	
		$grade_activities = GradeActivity::where('id', $gradeactivity->id)->get();
		$student_grades = Grade::where('grade_activity_id', $gradeactivity->id)->get();

    	return view('admin.grades.gradeactivity.students', compact('schoolyear', 'term','gradeactivity', 'grade_activities_grades', 'grade_activities', 'student_grades'));
    }

    public function addStudentGrade(Request $r){

    	$this->validate(request(), [

            'grade_activity_id' => 'required',
            'student_id' => 'required',
            'activity_grade' => 'required|numeric|min:0',
            'activity_comment' => 'required',        

    		]);

    	Grade::insert([

            'grade_activity_id' => $r->grade_activity_id,
            'student_id' => $r->student_id,
            'activity_grade' => $r->activity_grade,
    		'activity_comment'=>$r->activity_comment,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),    
    	]);

    	flash('Grade Added Successfully!')->success();

    	return back();
    }

    public function editStudentGrade(Request $r, Grade $grade){

    	$this->validate(request(), [

            'activity_grade'=> 'required|numeric|min:0',
            'activity_comment'=> 'required',
            
    		]);

    	$edit_grade = Grade::where('id', '=', $grade->id)->first();
         
        $edit_grade->activity_grade = $r->activity_grade;
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
}
