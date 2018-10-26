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

    	//Here we joing 3 trables(students, grades, and grade_activities)
    	$grade_activities_grades = DB::table('grades')
    		->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
		    ->get();
    	//dd($grade_activities_grades);

		$grade_activities = GradeActivity::where('id', $gradeactivity->id)->get();
		$student_grades = Grade::where('grade_activity_id', $gradeactivity->id)->get();

    	return view('admin.grades.gradeactivity.students', compact('schoolyear', 'term','gradeactivity', 'grade_activities_grades', 'grade_activities', 'student_grades'));
    }
}
