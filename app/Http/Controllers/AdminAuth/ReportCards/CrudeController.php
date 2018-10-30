<?php

namespace App\Http\Controllers\AdminAuth\ReportCards;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\School_year;
use App\School;
use App\Event;
use App\Term;
use Carbon\Carbon;

use App\Http\Requests;
use Auth;
use Image;
use App\Student;
use App\Group;
use App\Staffer;
use App\User;
use App\Comment;
use App\HealthRecord;
use \Crypt;
use PDF;
use App\Grade;
use App\Course;
use App\Attendance;
use DB;
use App\Psychomotor;
use App\EffectiveArea;
use App\LearningAndAccademic;
use App\GradeActivity;

class CrudeController extends Controller
{
   
    public function Students(School_year $schoolyear, Term $term)
    {
              

        return view('admin/reportcards/students', compact('schoolyear', 'term'));
    }

   

    public function Print($student, School_year $schoolyear, Term $term)
            {
                $student = Student::find($student);

                $next_term = Term::find($term->id+1);
               

                $student_user = User::where('registration_code', '=', $student->registration_code)->first();

                //join grades and grade_activities used to calculate maximum, minimum and average.
                //grouped by course_id and student_id FOR TESTING
                $grade_grade_activities_test = DB::table('grades')
                    ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
                    ->where('grades.student_id', $student->id)
                    ->where('grade_activities.school_year_id', $schoolyear->id)
                    ->where('grade_activities.term_id', $term->id)
                    ->where('grade_activities.group_id', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', \App\Staffer::where('registration_code', '=', Auth::guard('web_admin')->user()->registration_code)->first()->id)->first()->group_id )
                    ->groupBy('course_id')->get();

                //join grades and grade_activities used to calculate students' rank in each course
                //grouped by course_id and student_id FOR TESTING
                $grade_grade_activities_ranking = DB::table('grades')
                    ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
                    //->where('grades.student_id', $student->id)
                    ->where('grade_activities.school_year_id', $schoolyear->id)
                    ->where('grade_activities.term_id', $term->id)
                    ->where('grade_activities.group_id', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', \App\Staffer::where('registration_code', '=', Auth::guard('web_admin')->user()->registration_code)->first()->id)->first()->group_id )
                    ->groupBy('course_id')->groupBy('student_id')->get(['student_id', 'course_id', DB::raw('SUM(activity_grade) as sum')])->sortByDesc('sum')->groupBy('course_id');

                //join grades and grade_activities used to calculate maximum, minimum and average.
                //grouped by course_id and student_id
                $grade_grade_activities = DB::table('grades')
                    ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
                    //->where('grades.student_id', $student->id)
                    ->where('grade_activities.school_year_id', $schoolyear->id)
                    ->where('grade_activities.term_id', $term->id)
                    ->where('grade_activities.group_id', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', \App\Staffer::where('registration_code', '=', Auth::guard('web_admin')->user()->registration_code)->first()->id)->first()->group_id )
                    ->groupBy('course_id')->groupBy('student_id')->get(['student_id', 'course_id', DB::raw('SUM(activity_grade) as sum')]);

                                    
                //join grades and grade_activities to get total grades for eachcourse for each students in the group and the term in question.
                $join_grade_activities = DB::table('grades')
                    ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
                    ->where('grades.student_id', $student->id)
                    ->where('grade_activities.school_year_id', $schoolyear->id)
                    ->where('grade_activities.term_id', $term->id)
                    ->where('grade_activities.group_id', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', \App\Staffer::where('registration_code', '=', Auth::guard('web_admin')->user()->registration_code)->first()->id)->first()->group_id )
                    ->groupBy('course_id')->get(['student_id', 'course_id', DB::raw('SUM(activity_grade) as sum')]);

                //join grades and grade_activities used to calculate students' overall positions in class.
                //grouped by student_id, sorted by sum, plucked, and converted to array
                $overall_position = DB::table('grades')
                    ->join('grade_activities', 'grade_activities.id', '=', 'grades.grade_activity_id')
                    //->where('grades.student_id', $student->id)
                    ->where('grade_activities.school_year_id', $schoolyear->id)
                    ->where('grade_activities.term_id', $term->id)
                    ->where('grade_activities.group_id', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', \App\Staffer::where('registration_code', '=', Auth::guard('web_admin')->user()->registration_code)->first()->id)->first()->group_id )
                    ->groupBy('student_id')->get(['student_id', DB::raw('SUM(activity_grade) as sum')])->sortByDesc('sum')->pluck('student_id')->toArray();

                                
                $courses = Course::where('term_id', $term->id)
                    ->where('group_id', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', \App\Staffer::where('registration_code', '=', Auth::guard('web_admin')->user()->registration_code)->first()->id)->first()->group_id )->get();

                //get health records
        
                $health_record = HealthRecord::where('student_id', '=', $student->id)
                                ->where('term_id', '=', $term->id)
                                ->first();
               
                $attendance = Attendance::where('student_id', '=', $student->id)
                                            ->where('term_id', '=', $term->id)
                                            ->count();

                $attendance_code = Attendance::join('attendance_codes', 'attendances.attendance_code_id', '=', 'attendance_codes.id')
                                            ->where('student_id', '=', $student->id)
                                            ->where('term_id', '=', $term->id)
                                            ->get();


                $attendance_present = $attendance_code->where('code_name', '=', 'Present')->count();
                $attendance_absent = $attendance_code->where('code_name', '=', 'Absent')->count();
                $attendance_late = $attendance_code->where('code_name', '=', 'Late')->count();

                //addd comments
                $comment_all = Comment::where('student_id', '=', $student->id)
                                            ->where('term_id', '=', $term->id)
                                            ->first();

                $psychomotor = Psychomotor::where('student_id', '=', $student->id)
                                            ->where('term_id', '=', $term->id)
                                            ->first();

                $effective_areas = EffectiveArea::where('student_id', '=', $student->id)
                                            ->where('term_id', '=', $term->id)
                                            ->first();
                $learnining_accademic = LearningAndAccademic::where('student_id', '=', $student->id)
                                            ->where('term_id', '=', $term->id)
                                            ->first();
                //dd($grade_grade_activities_test);
                //dd($join_grade_activities->groupBy('course_id')->sum('activity_grade'));
               
                $pdf = PDF::loadView('admin.reportcards.print', 
                    compact('student', 'schoolyear', 'term', 'next_term', 'student_user', 'join_grade_activities', 'comment_all', 'psychomotor', 'effective_areas', 'learnining_accademic', 'courses', 'grade_grade_activities', 'health_record', 'attendance', 'attendance_code', 'attendance_present', 'attendance_absent', 'attendance_late', 'grade_grade_activities_ranking', 'overall_position', 'grade_grade_activities_test'));

                return $pdf->inline('reportcard.pdf');
            }

 

        public function PrintAll(School_year $schoolyear, Term $term )
            {

                $next_term = Term::find($term->id+1);
    

                
                $student_users = User::get();
 
                
                $course_grades = Course::join('grades', 'courses.id', '=', 'grades.course_id')
                                ->where('courses.term_id', '=', $term->id)
                                ->get();
                //dd($course_grades);
                //Rank
                //$mgb_total = DB::table('grades')->groupBy('student_id')->get(['student_id', DB::raw('SUM(total) as sum')]);
                $mgb_total_term_grade = Course::join('grades', 'courses.id', '=', 'grades.course_id')
                                ->where('courses.term_id', '=', $term->id)
                                ->groupBy('student_id')
                                ->get(['student_id', DB::raw('SUM(total) as sum')]);

                $mgb_total_term_grade_sorted = $mgb_total_term_grade->sortByDesc('sum');

                $pluck_mgb_total_term_grade_sorted = $mgb_total_term_grade_sorted->pluck('student_id')->toArray();

                //dd($mgb_total_term_grade_sorted);


                //get health records
        
                $health_records = HealthRecord::where('term_id', '=', $term->id)->get();


               
                $attendances = Attendance::where('term_id', '=', $term->id)->get();

              

                $mgb = DB::table('grades')->groupBy('course_id')->get(['course_id', DB::raw('MAX(total) as max')]);



                $mgb_lowest = DB::table('grades')->groupBy('course_id')->get(['course_id', DB::raw('min(total) as min')]);

           
                $mgb_avg = DB::table('grades')->groupBy('course_id')->get(['course_id', DB::raw('avg(total) as avg')]);
                
                

                $pluck_course_id = $mgb->pluck('course_id')->toArray(); 

                $pluck_course_id_min = $mgb_lowest->pluck('course_id')->toArray();
                
                $pluck_course_id_avg = $mgb_avg->pluck('course_id')->toArray(); 


                $course_grade_all_students = Course::join('grades', 'courses.id', '=', 'grades.course_id')
                ->where('courses.group_id', '=', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->first()->group_id)
                ->where('courses.term_id', '=', $term->id)
                ->get();

                            
                $sorted = $course_grade_all_students->sortByDesc('total'); 

                $sorted_grouped = $course_grade_all_students->sortByDesc('total')->groupBy('course_id');

                //addd comments
                $comment_all = Comment::where('term_id', '=', $term->id)->get();
                
                $psychomotors = Psychomotor::where('term_id', '=', $term->id)->get();

                $effective_areas = EffectiveArea::where('term_id', '=', $term->id)->get();

                $learnining_accademics = LearningAndAccademic::where('term_id', '=', $term->id)->get();

                $pdf = PDF::loadView('admin.reportcards.printall', 
                    compact('schoolyear', 'term', 'next_term', 'student_users', 'course_grades', 'health_records', 'attendances',
                        'attendance_code', 'attendance_present', 'attendance_absent', 'attendance_late',
                        'mgb', 'mgb_lowest', 'mgb_avg', 'pluck_course_id', 'pluck_course_id_min',
                        'pluck_course_id_avg', 'course_grade_all_students', 'sorted', 'sorted_grouped', 'comment_all',
                        'psychomotors', 'effective_areas', 'learnining_accademics', 'mgb_total_term_grade', 'mgb_total_term_grade_sorted', 'pluck_mgb_total_term_grade_sorted'));

                return $pdf->inline('allreportcard.pdf');
            }
}
   