<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\School_year;
use App\Event;
use App\Term;
use Carbon\Carbon;

use App\Http\Requests;
use Auth;
use Image;
use App\Student;
use App\User;

use App\Group;
use App\Attendance;
use App\AttendanceCode;
use Charts;
use \Crypt;
use App\LoginActivity;
use Location;
use App\Grade;
use App\Course;
use App\StafferRegistration;
use App\StudentRegistration;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        return view('home');
    }

    public function selectYearModal()
    {

        return view('selectYearModal');
    }

    public function homeSchoolYear(School_year $schoolyear)
    {
        //get current date
        $today = Carbon::today();

        $term = Term::where([['start_date', '<=', $today], ['show_until', '>=', $today]])->first();

        $student = Auth::user()->name;

        $students_teachers = @StafferRegistration::with('staffer')->with('school_year')->with('term')->with('group')->where('school_year_id', '=', $schoolyear->id)->where('group_id', StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->first()->group_id)->get(); 
            
        //dd($students_teachers->group->name);

        $class_members = @StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->get();
       
        //Attendance
        $attendance_today = Attendance::join('attendance_codes', 'attendances.attendance_code_id', '=', 'attendance_codes.id')
                                      ->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)
                                      ->where('day', '=', Carbon::today())
                                      ->first();
        $join_term_attendance = Term::join('attendances', 'terms.id', '=', 'attendances.term_id')->get();

        $att_code = AttendanceCode::get();

        $number_of_courses_current_term = Course::where('term_id', $term->id)->where('group_id', StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->first()->group_id)->get();

  
        //get over all grade f max and min for current term averages for student's group 
        //join grade activities and grade for the school year of interest.
        $grade_grade_activities_current_term = DB::table('grades')
            ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
            //->where('grades.student_id', $student->id)
            ->where('grade_activities.school_year_id', $schoolyear->id)
            ->where('grade_activities.term_id', $term->id)
            ->where('grade_activities.group_id', \App\StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('student_id', \App\Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->first()->group_id )
            ->groupBy('student_id')->get(['student_id', DB::raw('SUM(activity_grade) as total')]);

        $group_max_overall_current_term = $grade_grade_activities_current_term->max('total')/$number_of_courses_current_term->count();
        $group_min_overall_current_term = $grade_grade_activities_current_term->min('total')/$number_of_courses_current_term->count();


        //student stats - school year
        //Start of Student statistics - for the school years of interest
        //join grade activities and grade
        $grade_grade_activities_student_schoolyear = DB::table('grades')
            ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
            ->where('grades.student_id', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)
            ->where('grade_activities.school_year_id', $schoolyear->id)
             ->where('grade_activities.term_id', $term->id)
            ->where('grade_activities.group_id', \App\StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('student_id', \App\Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->first()->group_id )
           ->get(['student_id', 'term_id', DB::raw('SUM(activity_grade) as total')]);

        //dd($grade_grade_activities_student_schoolyear);
        
        $student_overall_current_term = $grade_grade_activities_student_schoolyear->max('total')/$number_of_courses_current_term->count();
        
      
        $school_class_student_chart = Charts::create('bar', 'highcharts')
                ->title("Overall % Statistics - $term->term")
                ->labels(['Overall % - Class Minimum', 'Overall % - Class Maximum', "Overall % - $student"])
                ->values([ $group_min_overall_current_term,$group_max_overall_current_term,$student_overall_current_term])
                ->dimensions(0,230);
        
        return view('homeSchoolYear', compact( 'today', 'students_teacher', 'schoolyear', 'term', 'number_of_courses_current_term', 'class_members', 'attendance_today', 'att_code','school_max', 'school_min', 'school_avg', 'school_class_student_chart', 'school_max_school_year', 'school_min_school_year', 'school_avg_school_year', 'join_term_attendance'));
    }

    

}
