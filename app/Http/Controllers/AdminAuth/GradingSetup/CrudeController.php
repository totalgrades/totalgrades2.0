<?php

namespace App\Http\Controllers\AdminAuth\GradingSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\School_year;
use App\Term;
use Carbon\Carbon;
use App\Course;
use App\GradeActivity;
use App\GradeActivityCategory;

class CrudeController extends Controller
{
    public function courses(School_year $schoolyear, Term $term){

        $term_courses = Course::where('term_id', '=', $term->id)->get();

        return view('admin.gradingsetup.courses', compact('schoolyear', 'term','term_courses'));
    }

    public function categories(School_year $schoolyear, Term $term, Course $course){

        $grade_activities = GradeActivity::where('school_year_id', $schoolyear->id)
                                           ->where('term_id', $term->id)
                                           ->where('course_id', $course->id)->get();

        $gradeactivitycategories =  GradeActivityCategory::where('course_id', $course->id)->get();

                        
        return view('admin.gradingsetup.categories', compact('schoolyear', 'term','course', 'grade_activities', 'gradeactivitycategories'));
    }

    public function addNewGradeActivityCategory(Request $r){

        $this->validate(request(), [
            
            'course_id' => 'required',
            'grade_activity_category_name'=> 'required',
            'grade_activity_category_weight'=> 'required|numeric|min:0|max:100',
            //'grade_activity_category_description'=> 'required',
            

            ]);

        GradeActivityCategory::insert([
            
            'course_id'=>$r->course_id,
            'grade_activity_category_name'=>$r->grade_activity_category_name,
            'grade_activity_category_weight'=>$r->grade_activity_category_weight,
            'grade_activity_category_description'=>$r->grade_activity_category_description,
            //'total'=>$r->first_ca+$r->second_ca+$r->third_ca+$r->fourth_ca+$r->exam,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),    
        ]);

        flash('Grade Activity Category Added!')->success();
        return back();
    }

    public function editGradeActivityCategory(Request $r, GradeActivityCategory $gradeactivitycategory){

        $this->validate(request(), [

            'course_id' => 'required',
            'grade_activity_category_name'=> 'required',
            'grade_activity_category_weight'=> 'required|numeric|min:0|max:100',

            ]);

        $edit_grade_activity_category = GradeActivityCategory::where('id', '=', $gradeactivitycategory->id)->first();
         
        $edit_grade_activity_category->grade_activity_category_name = $r->grade_activity_category_name;
        $edit_grade_activity_category->grade_activity_category_weight = $r->grade_activity_category_weight;
        $edit_grade_activity_category->grade_activity_category_description = $r->grade_activity_category_description;
      
        $edit_grade_activity_category->save();
        
        flash('Category Updated!')->info();

        return back();
    }

    public function deleteGradeActivityCategory(GradeActivityCategory $gradeactivitycategory){

        GradeActivityCategory::where('id', $gradeactivitycategory->id)->delete();

        flash('Grade Activity Category Deleted!')->warning();
            
        return back();
    }

    public function showCourse(School_year $schoolyear, Term $term, Course $course){

        $grade_activities = GradeActivity::where('school_year_id', $schoolyear->id)
                                           ->where('term_id', $term->id)
                                           ->where('course_id', $course->id)->get();

        $gradeactivitycategories =  GradeActivityCategory::where('course_id', $course->id)->get();

                        
        return view('admin.gradingsetup.showcourse', compact('schoolyear', 'term','course', 'grade_activities', 'gradeactivitycategories'));
    }

    public function addNewGradeActivity(Request $r){

        $this->validate(request(), [
            
            'school_year_id' => 'required',
            'term_id' => 'required',
            'group_id' => 'required',
            'course_id' => 'required',
            'grade_activity_name'=> 'required',
            'max_point'=> 'required|numeric|min:0',
            'grade_activity_description'=> 'required',
            

            ]);

        GradeActivity::insert([
            
            'school_year_id' => $r->school_year_id,
            'term_id' => $r->term_id,
            'group_id' => $r->group_id,
            'course_id'=>$r->course_id,
            'grade_activity_name'=>$r->grade_activity_name,
            'max_point'=>$r->max_point,
            'grade_activity_description'=>$r->grade_activity_description,
            //'total'=>$r->first_ca+$r->second_ca+$r->third_ca+$r->fourth_ca+$r->exam,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),    
        ]);

        flash('Grade Activity Added!')->success();
        return back();
    }

   
    public function editGradeActivity(Request $r, GradeActivity $gradeactivity){

        $this->validate(request(), [

            'grade_activity_name'=> 'required',
            'max_point'=> 'required|numeric|min:0',
            'grade_activity_description'=> 'required', 

            ]);

        $edit_grade_activity = GradeActivity::where('id', '=', $gradeactivity->id)->first();
         
        $edit_grade_activity->grade_activity_name = $r->grade_activity_name;
        $edit_grade_activity->max_point = $r->max_point;
        $edit_grade_activity->grade_activity_description = $r->grade_activity_description;
      
        $edit_grade_activity->save();
        
        flash('Grade Activity Updated!')->info();

        return back();
    }

    public function deleteGradeActivity(GradeActivity $gradeactivity){

        GradeActivity::where('id', $gradeactivity->id)->delete();

        flash('Grade Activity Deleted!')->warning();
            
        return back();
    }
}