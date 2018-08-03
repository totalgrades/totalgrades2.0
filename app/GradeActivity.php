<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeActivity extends Model
{
    public function school_year()
    {
        return $this->belongsTo('App\School_year');
    }
}
