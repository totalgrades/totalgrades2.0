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
        

        $students_teachers = @StafferRegistration::with('staffer')->with('school_year')->with('term')->with('group')->where('school_year_id', '=', $schoolyear->id)->where('group_id', StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->first()->group_id)->get(); 
            


        $class_members = @StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->get();
       
        //Attendance
        $attendance_today = Attendance::join('attendance_codes', 'attendances.attendance_code_id', '=', 'attendance_codes.id')
                                      ->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)
                                      ->where('day', '=', Carbon::today())
                                      ->first();
        $join_term_attendance = Term::join('attendances', 'terms.id', '=', 'attendances.term_id')->get();

        $att_code = AttendanceCode::get();

        //get events
       // $events = Event::where('group_id', '=', $student->group_id)->orderBy('start_date', 'desc')->paginate(3);

        //$upcomming_events = Event::where('group_id', '=', $student->group_id)->whereDate('start_date', '>', $today)->count();

        //$active_events = Event::where('group_id', '=', $student->group_id)->where('start_date', '<=', $today)
                    //->Where('end_date', '>=', $today)->count();

        //$expired_events = Event::where('group_id', '=', $student->group_id)->whereDate('end_date', '<', $today )->count();

        //join grades and grade_activities used to calculate maximum, minimum and average.
        //grouped by course_id and student_id FOR TESTING
        $grade_grade_activities_test = DB::table('grades')
            ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
            //->where('grades.student_id', $student->id)
            ->where('grade_activities.school_year_id', $schoolyear->id)
            //->where('grade_activities.term_id', $term->id)
            //->where('grade_activities.group_id', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', \App\Staffer::where('registration_code', '=', Auth::guard('web_admin')->user()->registration_code)->first()->id)->first()->group_id )
            ->groupBy('student_id')->get(['student_id', DB::raw('SUM(activity_grade) as total')]);

        //school max, min, total, count, school average   
       //Start of School statistics - school year
        //join grade activities and grade for the school year of interest.
        $grade_grade_activities_schoolyear = DB::table('grades')
            ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
            ->where('grade_activities.school_year_id', $schoolyear->id)
            ->groupBy('student_id')->get(['student_id', DB::raw('SUM(activity_grade) as total')]);

        
        $school_max_school_year = $grade_grade_activities_schoolyear->max('total');
        $school_min_school_year = $grade_grade_activities_schoolyear->min('total');
        $school_total_school_year = $grade_grade_activities_schoolyear->sum('total');
        $school_count_school_year = $grade_grade_activities_schoolyear->count('total');
        $school_avg_school_year = $grade_grade_activities_schoolyear->avg('total');

        //school max, min, total, count, school average
        //Start of School statistics - All school years
        //Start of School statistics - school year
        //join grade activities and grade for all school years
        $grade_grade_activities_allschoolyear = DB::table('grades')
            ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
            ->groupBy('student_id')->get(['student_id', DB::raw('SUM(activity_grade) as total')]);
                
        $school_max = $grade_grade_activities_allschoolyear->max('total');
        $school_min = $grade_grade_activities_allschoolyear->min('total');
        $school_total = $grade_grade_activities_allschoolyear->sum('total');
        $school_count = $grade_grade_activities_allschoolyear->count('total');
        $school_avg = $grade_grade_activities_allschoolyear->avg('total');

        //student stats - school year
        //Start of Student statistics - for the school years of interest
        //join grade activities and grade
        $grade_grade_activities_student_schoolyear = DB::table('grades')
            ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
            ->where('grades.student_id', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)
            ->where('grade_activities.school_year_id', $schoolyear->id)
            ->groupBy('term_id')->get(['student_id', 'term_id', DB::raw('SUM(activity_grade) as total')]);
        
        $student_max_school_year = $grade_grade_activities_student_schoolyear->max('total');
        $student_min_school_year = $grade_grade_activities_student_schoolyear->min('total');
        $student_total_school_year = $grade_grade_activities_student_schoolyear->sum('total');
        $student_count_school_year = $grade_grade_activities_student_schoolyear->count('total');
        $student_avg_school_year = $grade_grade_activities_student_schoolyear->avg('total');
      
        //student stats - All school year
        $grade_grade_activities_student_allschoolyear = DB::table('grades')
            ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
            ->where('grades.student_id', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)
            ->groupBy('school_year_id')->get(['student_id', 'school_year_id', DB::raw('SUM(activity_grade) as total')]);

        $student_max = $grade_grade_activities_student_allschoolyear->max('total');
        $student_min = $grade_grade_activities_student_allschoolyear->min('total');
        $student_total = $grade_grade_activities_student_allschoolyear->sum('total');
        $student_count = $grade_grade_activities_student_allschoolyear->count('total');
        $student_avg = $grade_grade_activities_student_allschoolyear->avg('total');


       /* //class statistics - school year
        $grade_grade_activities_class_schoolyear = DB::table('grades')
            ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
            ->where('grade_activities.school_year_id', $schoolyear->id)
            ->where('grade_activities.group_id', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', \App\Staffer::where('registration_code', '=', Auth::guard('web_admin')->user()->registration_code)->first()->id)->first()->group_id )
            ->groupBy('student_id')->get(['student_id', 'school_year_id', 'group_id', DB::raw('SUM(activity_grade) as total')]);
dd($grade_grade_activities_class_schoolyear);
        $student_class_max_school_year = $grade_grade_activities_class_schoolyear->max('total');         
        $student_class_min_school_year = $grade_grade_activities_class_schoolyear->min('total'); 
        $student_class_avg_school_year = $grade_grade_activities_class_schoolyear->avg('total');  



        //class statistics - All school year
        $student_class_max = @Course::join('grades', 'courses.id', '=', 'grades.course_id')
                ->where('courses.group_id', '=', StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->first()->group_id)
                ->max('total');

        $student_class_min = @Course::join('grades', 'courses.id', '=', 'grades.course_id')
                ->where('courses.group_id', '=', StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->first()->group_id)
                ->min('total'); 

        $student_class_avg = @Course::join('grades', 'courses.id', '=', 'grades.course_id')
                ->where('courses.group_id', '=', StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('student_id', '=', Student::where('registration_code', '=', Auth::user()->registration_code)->first()->id)->first()->group_id)
                ->avg('total');*/        
               

        //School-Student-Class Statistics- school year
        $school_class_student_chart = Charts::multi('bar', 'material')
                // Setup the chart settings
                ->title("School-Student $schoolyear->school_year Statistics")
                // A dimension of 0 means it will take 100% of the space
                ->dimensions(0, 235) // Width x Height
                // This defines a preset of colors already done:)
                ->template("material")
                ->responsive(true)
                // You could always set them manually
                ->colors(['#2196F3', '#F44336', '#FFC107'])
                // Setup the diferent datasets (this is a multi chart)
                ->dataset('School', [$school_min_school_year,$school_max_school_year,$school_avg_school_year])
                ->dataset('Student', [$student_min_school_year,$student_max_school_year,$student_avg_school_year])
                //->dataset('Class', [$student_class_min_school_year,$student_class_max_school_year,$student_class_avg_school_year])
                // Setup what the values mean
                ->labels(['Minimum', 'Maximum', 'Average']);

        
        return view('homeSchoolYear', compact('students_teacher', 'schoolyear', 'term', 'class_members', 'attendance_today', 'att_code','school_max', 'school_min', 'school_avg', 'school_class_student_chart', 'school_max_school_year', 'school_min_school_year', 'school_avg_school_year', 'join_term_attendance'));
    }

    

}
