<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeActivity extends Model
{
    public function school_year()
    {
        return $this->belongsTo('App\School_year');
    }

    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function grade_activity_category()
    {
        return $this->belongsTo(GradeActivityCategory::class);
    }

    public function grades()
    {
        return $this->hasMany('App\Grade');
    }

    
}
