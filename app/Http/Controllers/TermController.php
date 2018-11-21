<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\School_year;
use App\Event;
use App\Term;
use Carbon\Carbon;
use App\Course;
use Auth;
use Image;
use App\Student;
use App\Grade;
use App\Group;
use \Crypt;
use Charts;
use App\StudentRegistration;
use DB;

class TermController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }


    public function showTermCourses(School_year $schoolyear, $term)
    {


        $term = Term::find(Crypt::decrypt($term));
        
        //get all term courses student is registered in 
        $term_courses = Course::where('term_id', '=', $term->id)
                            ->where('group_id', '=', @StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->first()->group_id)
                            ->get();

        //Start of School statistics - current term     
        //class statistics - current term
        $grade_grade_activities_class_term = DB::table('grades')
            ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
            ->where('grade_activities.school_year_id', $schoolyear->id)
            ->where('grade_activities.term_id', $term->id)
            ->where('grade_activities.group_id', @StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->first()->group_id )
            ->groupBy('course_id')->groupBy('student_id')->get(['student_id', 'school_year_id', 'group_id','term_id', 'course_id', DB::raw('SUM(activity_grade) as total')]);

        $class_term_max = $grade_grade_activities_class_term->max('total');                    
        $class_term_min = $grade_grade_activities_class_term->min('total'); 
        $class_term_avg = $grade_grade_activities_class_term->avg('total');
               
        //student statistics - current term
        $grade_grade_activities_student_term = DB::table('grades')
            ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
            ->where('grades.student_id', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)
            ->where('grade_activities.school_year_id', $schoolyear->id)
            ->where('grade_activities.term_id', $term->id)
            ->where('grade_activities.group_id', @StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->first()->group_id )
            ->groupBy('course_id')->get(['student_id', 'school_year_id', 'group_id','term_id', 'course_id', DB::raw('SUM(activity_grade) as total')]);

        //dd($grade_grade_activities_class_term);

        $student_term_max = $grade_grade_activities_student_term->max('total');
        $student_term_min = $grade_grade_activities_student_term->min('total'); 
        $student_term_avg = $grade_grade_activities_student_term->avg('total'); 

        //School-Student-Class Statistics- current term
        $class_student_term_chart = Charts::multi('bar', 'material')
                // Setup the chart settings
                ->title("Student-Class $term->term $schoolyear->school_year Statistics")
                // A dimension of 0 means it will take 100% of the space
                ->dimensions(0, 230) // Width x Height
                // This defines a preset of colors already done:)
                ->template("material")
                ->responsive(true)
                // You could always set them manually
                // ->colors(['#2196F3', '#F44336', '#FFC107'])
                // Setup the diferent datasets (this is a multi chart)
                //->dataset('School', [$school_min,$school_max,$school_avg])
                ->dataset('Student', [$student_term_min,$student_term_max,$student_term_avg])
                ->dataset('Class', [$class_term_min, $class_term_max, $class_term_avg])
                // Setup what the values mean
                ->labels(['Minimum', 'Maximum', 'Average']);      


        return view('showtermcourses', 
        	compact( 'schoolyear', 'term_courses', 'term','class_student_term_chart',
                    'student_term_max', 'student_term_avg', 'student_term_min'));

        }
}
