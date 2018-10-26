<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    public function grade_activity()
    {
    	return $this->belongsTo(GradeActivity::class);
    }

    public function student()
    {
    	return $this->belongsTo(Student::class);
    }
    
}
