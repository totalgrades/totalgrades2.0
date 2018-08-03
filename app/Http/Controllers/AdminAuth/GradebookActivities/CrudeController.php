<?php

namespace App\Http\Controllers\AdminAuth\GradebookActivities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GradeActivity;
use App\School_year;
use Carbon\Carbon;

class CrudeController extends Controller
{
    public function activities()
    {

    	return view('admin.superadmin.schoolsetup.gradebookActivities.activities');
    }

    public function addActivity()
    {

    	return view('admin.superadmin.schoolsetup.gradebookActivities.addActivity');
    }

    public function postAddActivity(Request $r)
    {
    	//get current date
        $today = Carbon::today();

    	//get current school year
        $current_school_year = School_year::where('start_date', '<=', $today)->where('show_until', '>=', $today)->first();

    	$this->validate(request(), [
       
            'activity_name' => 'required',
            'max_point'=> 'required|numeric|max:100|min:0',
            
    		]);


    	GradeActivity::insert([

            'school_year_id' => $current_school_year->id,
            'activity_name' => $r->activity_name,
            'max_point' => $r->max_point,
    		'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
    		
    		
    	]);

       return redirect()->route('gradeactivities');

    }

    public function editActivity($activity)
    {
    	
    	$grade_activity = GradeActivity::find($activity);

    	return view('admin.superadmin.schoolsetup.gradebookActivities.editActivity', compact('grade_activity'));
    }

    public function postEditActivity(Request $r, $activity)

    {
         $grade_activity = GradeActivity::find($activity);


         $this->validate(request(), [
       
            'activity_name' => 'required',
            'max_point'=> 'required|numeric|max:100|min:0',
            
    		]);

         $edit_grade_activity = GradeActivity::where('id', '=', $grade_activity->id)->first();
         

            $edit_grade_activity->activity_name = $r->activity_name;
            $edit_grade_activity->max_point = $r->max_point;

     
            $edit_grade_activity->save();

            return redirect()->route('gradeactivities');

     }


     public function deleteActivity($activity)
     {
        GradeActivity::destroy($activity);

        flash('Grade Activity has been deleted')->error();

        return back();
     }


}
