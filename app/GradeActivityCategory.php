<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeActivityCategory extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function grade_activities()
    {
        return $this->hasMany('App\GradeActivity');
    }
}
