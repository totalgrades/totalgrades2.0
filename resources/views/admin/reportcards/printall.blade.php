<!DOCTYPE html>
<html lang="en">
<head>
  <title>Toatalgrades - Print All Report Cards</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @include('google_analytics')
  <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/img/favicon.png')}}">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href='http://fonts.googleapis.com/css?family=Meddon|Miss+Fajardose' rel='stylesheet'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <style type="text/css" media="all">

      body{font-size: 12px;}
    
    .page1 {
      overflow: hidden;
      page-break-before: always;
      page-break-inside: avoid;
      }
      .page2 {
      overflow: hidden;
      page-break-before: always;
      page-break-inside: avoid;
      }
      h3, p.noil{
        margin-bottom: 0;
        margin-top: 0;
      }


      hr{
          padding: 5px;
          margin: 0px;    
        }
        .teacher_signature{
          font-family: 'Miss Fajardose'; 
          font-weight: bolder; 
          font-size: 45px;
          text-shadow: 4px 4px 4px #aaa;
        }

        .head_teacher_signature{
          font-family: 'Meddon'; 
          font-weight: bolder; 
          font-size: 25px;
          text-shadow: 4px 4px 4px #aaa;
        }
  </style>
</head>
<body>

@foreach (@$join_students_regs->where('school_year_id', $schoolyear->id)->where('term_id', $term->id)->where('group_id', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', $teacher->id)->first()->group_id ) as $reg_student)
   

<div class="page1">
        <div class="row">
            <div class="col-xs-3 ">
                       
            <div class="header text-center">
                          
               <img src="{{ public_path('assets/img/logo/logo.jpg') }}" style="width: 120px; height: 120Spx; border-radius: 50%; margin-right: 5px;"> 
                               
            </div>

            </div>{{-- head-1 --}}
            <div class="col-xs-6 ">
                       
                  <div class="header text-center">
                            
                    <h3 class="noil">{{@$school->name}}</h3> 
                    <p class="noil">{{@$school->address}}, {{@$school->city}}, {{@$school->state}} {{@$school->postal_code}}</p> 
                    <p class="noil">Phone:&nbsp; {{@$school->phone}} &nbsp; Email:&nbsp; {{@$school->email}}</p> 
                    <p class="noil">END OF TERM REPORT</p> 
                    <p class="noil">{{ @$schoolyear->school_year}} &nbsp; SESSION</p>
                    <p class="noil">{{ @$term->term }}</p> 
                 
                  </div>

            </div>{{-- head-2 --}}
              <div class="col-xs-3 ">
              
                     
              <div class="header text-center">

              @foreach($student_users as $student_user)

                @if($student_user->registration_code == $reg_student->student->registration_code && @$student_user->avatar !=null)
               
                
                  <img src="{{ public_path('assets/img/students/'.@$student_user->avatar) }}" style="width: 120px; height: 120Spx; border-radius: 50%; margin-right: 5px;"> 

                
                @endif
                    
              @endforeach
              <br>
                <p class="bg-primary">{{@$reg_student->student->first_name}} {{@$reg_student->student->last_name}}</p>             
              </div>
              
              </div>{{-- head-2 --}}
          </div>{{--END HEAD--}}

          <hr>

        <div class="row">

         
         <div class="col-xs-4 ">

                    
            <ul class="list-group">
              <li class="list-group-item justify-content-between">
                Name:&nbsp;&nbsp;
                <span class="label label-primary pull-right">{{@$reg_student->student->first_name}} {{@$reg_student->student->last_name}}</span>
              </li>
              <li class="list-group-item justify-content-between">
                Age
                <span class="label label-primary pull-right">{{ @$reg_student->student->dob->diffInYears($today) }}</span>
              </li>
              <li class="list-group-item justify-content-between">
                Admission #: 
                <span class="label label-primary pull-right">{{ @$reg_student->student->registration_code }}</span>
              </li>
          </ul>
          

         </div>{{-- biodata-1 --}}
          <div class="col-xs-4 ">
                       
          <ul class="list-group">
              <li class="list-group-item justify-content-between">
                Sex:
                <span class="label label-primary pull-right">{{ @$reg_student->student->gender}}</span>
              </li>
              <li class="list-group-item justify-content-between">
                # of students in class:
                <span class="label label-primary pull-right"> {{ @\App\StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('group_id', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', $teacher->id)->first()->group_id)->count() }}</span>
              </li>
              <li class="list-group-item justify-content-between">
                Admission Date: 
                <span class="label label-primary pull-right">{{ @$reg_student->student->date_enrolled }}</span>
              </li>
          </ul>

          </div>{{-- biodata-2 --}}
            <div class="col-xs-4 ">
                       
            <ul class="list-group">
              <li class="list-group-item justify-content-between">
                Teacher:&nbsp;&nbsp;
                <span class="label label-primary pull-right">{{ @$teacher->first_name }}&nbsp;&nbsp;{{ $teacher->last_name }}</span>
              </li>
              <li class="list-group-item justify-content-between">
                Class:
                <span class="label label-primary pull-right">{{ @\App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', $teacher->id)->first()->group->name }}</span>
              </li>
              @if(@$grade_grade_activities->where('student_id', '=', $reg_student->student->id)->count() != null )
              <li class="list-group-item justify-content-between">
                Overall &#37; (Total): 
                <span class="label label-primary pull-right">{{number_format(@$grade_grade_activities->where('student_id', '=', $reg_student->student->id)->sum('total')/@$grade_grade_activities->where('student_id', '=', $reg_student->student->id)->count()), 2}} &#37; ({{@$grade_grade_activities->where('student_id', '=', $reg_student->student->id)->sum('total')}})</span>
              </li>
              @else
              <li class="list-group-item justify-content-between">
                Overall &#37;: 
                <span class="label label-primary pull-right"> 0 &#37;</span>
              </li>

              @endif
            </ul>
          </div>{{-- biodata-2 --}}
        
            
        </div>{{--END BIODATA--}}
      
        
        <div class="row">


         <div class="col-xs-4 ">

                    
            <ul class="list-group">
         
              <li class="list-group-item justify-content-between">
                <h5>ATTENDANCE RECORD</h5>
            
              </li>
              <li class="list-group-item justify-content-between">
                Times Attendance Taken:
                <span class="label label-primary pull-right">{{ @$attendances->where('student_id', '=', $reg_student->student->id)->count() }}</span>
              </li>
              <li class="list-group-item justify-content-between">
                Times Present:
                <span class="label label-primary pull-right">{{ @$attendances->where('student_id', '=', $reg_student->student->id)->where('attendance_code_id', '=', '1')->count() }}</span>
              </li>
              <li class="list-group-item justify-content-between">
                Times absent:
                <span class="label label-primary pull-right">{{ @$attendances->where('student_id', '=', $reg_student->student->id)->where('attendance_code_id', '=', '2')->count() }}</span>
              </li>
              <li class="list-group-item justify-content-between">
                Times Late:
                <span class="label label-primary pull-right">{{@$attendances->where('student_id', '=', $reg_student->student->id)->where('attendance_code_id', '=', '3')->count()}}</span>
              </li>
           
          </ul>
          

        </div>{{-- biodata-1 --}}
                  
        <div class="col-xs-4">
                       
          <ul class="list-group">
          
              <li class="list-group-item justify-content-between">
                <h5>HEALTH RECORD</h5>
              </li>
            @foreach($health_records->where('student_id', '=', $reg_student->student->id) as $health_record)
              <li class="list-group-item justify-content-between">
                Student's Weight:
                <span class="label label-primary pull-right">{{ @$health_record->weight }} kg</span>
              </li>
              <li class="list-group-item justify-content-between">
                Students Height: 
                <span class="label label-primary pull-right">{{ @$health_record->height }} m</span>
              </li>
              <li class="list-group-item justify-content-between">
                Nurses's Comment: 
                <span class="label label-primary pull-right">{{@$health_record->comment_nurse}}</span>
              </li>
              <li class="list-group-item justify-content-between">
                Doctor's Comment: 
                <span class="label label-primary pull-right">{{@$health_record->comment_doctor}}</span>
              </li>
           @endforeach
           </ul>
        </div>{{-- biodata-2 --}}



          <div class="col-xs-4">
            <ul class="list-group">
              <li class="list-group-item justify-content-between">
              <h5>OVERALL REMARK</h5>
               </li>
              <li class="list-group-item justify-content-between">
                  <h5>POSITION IN CLASS
                                            
                    <span class="label label-warning pull-right"> 

                       @if ( array_search($reg_student->student->id,  $overall_position) + 1 == 1)

                        {{ array_search($reg_student->student->id,  $overall_position) + 1 }}ST

                      @elseif( array_search($reg_student->student->id,  $overall_position) + 1 == 2 )

                          {{ array_search($reg_student->student->id,  $overall_position) + 1 }}ND

                      @elseif( array_search($reg_student->student->id,  $overall_position) + 1 == 3 )

                          {{ array_search($reg_student->student->id,  $overall_position) + 1 }}RD

                      @elseif( array_search($reg_student->student->id,  $overall_position) + 1 == 21 )

                          {{ array_search($reg_student->student->id,  $overall_position) + 1 }}ST

                      @elseif( array_search($reg_student->student->id,  $overall_position) + 1 == 22 )

                          {{ array_search($reg_student->student->id,  $overall_position) + 1 }}ND

                      @elseif( array_search($reg_student->student->id,  $overall_position) + 1 == 23 )

                          {{ array_search($reg_student->student->id,  $overall_position) + 1 }}RD

                      @elseif( array_search($reg_student->student->id,  $overall_position) + 1 == 31 )

                          {{ array_search($reg_student->student->id,  $overall_position) + 1 }}ST

                      @elseif( array_search($reg_student->student->id,  $overall_position) + 1 == 32 )

                          {{ array_search($reg_student->student->id,  $overall_position) + 1 }}ND

                      @elseif( array_search($reg_student->student->id,  $overall_position) + 1 == 33 )

                          {{ array_search($reg_student->student->id,  $overall_position) + 1 }}RD

                      @else

                          {{ array_search($reg_student->student->id,  $overall_position) + 1 }}TH

                      @endif
                    </span>
                  
                  </span>
                </h5>
              </li>
                        
              </li>
              <li class="list-group-item justify-content-between">
                  <h5>PASSED
                          
                  @if( @$grade_grade_activities->where('student_id', '=', $reg_student->student->id)->count() > 0 && ( @$grade_grade_activities->where('student_id', '=', $reg_student->student->id)->sum('total')/@$grade_grade_activities->where('student_id', '=', $reg_student->student->id)->count() ) >= 50 )

                  <span class="label label-primary pull-right"> YES </span>
                          
                    @else
                            
                  <span class="label label-primary pull-right"> NO </span>
                          
                  @endif


                  </span>
                </h5>
              </li>
              
              <li class="list-group-item justify-content-between">
                  <h6>NEXT CLASS
                          
                  @if(@$grade_grade_activities->where('student_id', '=', $reg_student->student->id)->count() > 0 &&( @$grade_grade_activities->where('student_id', '=', $reg_student->student->id)->sum('total')/@$grade_grade_activities->where('student_id', '=', $reg_student->student->id)->count() ) >= 50 && @$term->id == 3)

                  <span class="label label-primary pull-right"> {{ @$next_group->name}} </span>
                          
                  @elseif(@$term->id != 3)
                            
                  <span class="label label-primary pull-right">Year not Ended Yet  </span>

                  @else
                            
                  <span class="label label-primary pull-right"> Not Promoted </span>
                          
                          
                  @endif


                  </span>
                </h6>
              </li>
                      
            </ul>
          </div>

            
        </div>{{-- row-ATT RECORED CLASS AGV HEALTH RECORD --}}
        
<div class="row">
  
        <div class="col-xs-12">
            <table class="table table-bordered text-center">
              <thead>
                <tr class="info">
                  <th colspan="1" class="text-center">SUBJECTS</th>
                  <th colspan="1" class="text-center">TOTAL SCORE</th>
                  <th colspan="3" class="text-center">CLASS STATISTICS</th>
                  <th colspan="1" class="text-center">STUDNET</th>
                  <th colspan="1" class="text-center">LETTER</th>
                  
                </tr>
                <tr class="info">
                  <th class="text-center">NAME-CODE</th>
                  <th class="text-center">100%</th>
                  <th class="text-center">HIGHEST</th>
                  <th class="text-center">LOWEST</th>
                  <th class="text-center">AVERAGE</th>
                  <th class="text-center">POSITION</th>
                  <th class="text-center">GRAGE</th>

                </tr>
              </thead>
              <tbody>
              
                  @foreach($courses as $course)

                    @foreach($join_grade_activities->where('course_id', $course->id)->where('student_id', $reg_student->student->id) as $grade)
                      
                      
                        <tr>
                          

                          <td class="text-center">{{$course->name}}-{{$course->course_code}}</td>
                          
                          <td class="text-center">{{$grade->sum}} %</td>
                          
                          <td class="text-center">
                          
                          
                            {{ $grade_grade_activities->where('course_id', $course->id)->max('total') }} %
                           
                          </td>
                         
                          <td class="text-center">

                             {{ $grade_grade_activities->where('course_id', $course->id)->min('total') }} %

                          </td>

                          <td class="text-center">

                            {{ $grade_grade_activities->where('course_id', $course->id)->avg('total') }} %


                          </td>

                          <td class="text-center">
                            @foreach($grade_grade_activities_ranking as $grouped_for_ranking)

                              @foreach($grouped_for_ranking as $k1 => $grouped)

                                @if($course->id == $grouped->course_id & $reg_student->student->id == $grouped->student_id)

                                    @if ($k1+1 == 1)

                                        {{ $k1+1 }}st

                                    @elseif( $k1+1 == 2 )

                                        {{ $k1+1 }}nd

                                    @elseif( $k1+1 == 3 )

                                        {{ $k1+1 }}rd

                                    @elseif( $k1+1 == 21 )

                                        {{ $k1+1 }}st

                                    @elseif( $k1+1 == 22 )

                                        {{ $k1+1 }}nd

                                    @elseif( $k1+1 == 23 )

                                        {{ $k1+1 }}rd
                                    @elseif( $k1+1 == 31 )

                                        {{ $k1+1 }}st

                                    @elseif( $k1+1 == 32 )

                                        {{ $k1+1 }}nd

                                    @elseif( $k1+1 == 33 )

                                        {{ $k1+1 }}rd

                                    @else

                                        {{ $k1+1 }}th
                                        
                                    @endif

                              @endif
                              @endforeach
                            @endforeach

                          </td>


                          <td class="text-center">

                              
                              @if ($grade->sum < 65)
                              F
                              @elseif ($grade->sum<= 66 && $grade->sum >=65)
                              D
                              @elseif ($grade->sum<= 69 && $grade->sum >=67)
                              D+
                              @elseif ($grade->sum<= 73 && $grade->sum >=70)
                              C-
                              @elseif ($grade->sum<= 76 && $grade->sum >=74)
                              C
                              @elseif ($grade->sum<= 79 && $grade->sum >=77)
                              C+
                              @elseif ($grade->sum<= 83 && $grade->sum >=80)
                              B-
                              @elseif ($grade->sum<= 86 && $grade->sum >=84)
                              B
                              @elseif ($grade->sum<= 89 && $grade->sum >=87)
                              B+
                              @elseif ($grade->sum<= 93 && $grade->sum >=90)
                              A-
                              @elseif ($grade->sum<= 96 && $grade->sum >=94)
                              A
                              @elseif ($grade->sum>= 97)
                              A+
                              @endif

                           
                          </td>
                        
                        </tr>

                                 
                            
                         
                        @endforeach
                         
                     
                  @endforeach
              
              </tbody>
            </table>
        </div>
    </div>{{--ACCADAMIC REPORT--}}
          

    </div>{{--END OF PAGE2--}} 

        <div class="page2">

            <div class="row">
            <div class="col-xs-12">
            

            
                     
                <div class="well well-sm">
                            
                  <strong>CLASS TEACHEAR'S COMMENT:</strong> <span> <i>
                  @foreach(@$comment_all->where('student_id', '=', @$reg_student->student->id) as $comment)
                      {{ @$comment->comment_teacher }}
                  @endforeach
                  </i></span>
                            
                    <hr>

                      <p> <strong>DATE:</strong> <i><u>
                      @foreach(@$comment_all->where('student_id', '=', @$reg_student->student->id) as $comment)
                          {{ @$comment->created_at->toFormattedDateString() }}
                      @endforeach
                      </u></i>&nbsp;&nbsp;&nbsp;&nbsp;<strong>SIGNATURE: &nbsp;</strong><span class="teacher_signature"><u>{{(@$teacher->first_name)}}{{(@$teacher->last_name)}}</u></span></p>


                </div>  
        
              
            </div>
        </div>
         <div class="row">
                                    
                  <div class="col-xs-12">
                  <strong>GRADE KEY</strong>
                  <table class="table table-bordered text-center">
                  <thead>
                    <tr class="info">
                      <th>grade >= 97</th>
                      <th>94 <= grade <= 96 </th>
                      <th>90 <= grade <= 93</th>
                      <th>87 <= grade <= 89 </th>
                      <th>84 <= grade <= 86</th>
                      <th>80 <= grade <= 83 </th>
                      <th>77 <= grade <= 79</th>
                      <th>74 <= grade <= 76 </th>
                      <th>70 <= grade <= 73</th>
                      <th>67 <= grade <= 69 </th>
                      <th>65 <= grade <= 66</th>
                      <th>grage < 65</th>

                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>A+</td>
                      <td>A</td>
                      <td>A-</td>
                      <td>B+</td>
                      <td>B</td>
                      <td>B-</td>
                      <td>C+</td>
                      <td>C</td>
                      <td>C-</td>
                      <td>D+</td>
                      <td>D</td>
                      <td>F</td>
                      
                    </tr>
                    
                  </tbody>
                </table>
          </div>
        </div>
        <div class="row"> 

                      <div class="col-xs-4">
                                    
                      
                        <ul class="list-group">
                        
                         
                          <li class="list-group-item justify-content-between">
                            <p>Observations on Conduct</p>
                            <h4>PSYCHOMOTOR</h4>
                          </li>
                        @foreach($psychomotors->where('student_id', '=', $reg_student->student->id) as $psychomotor)
                          <li class="list-group-item justify-content-between">
                            Hand Writting
                            <span class="label label-primary pull-right">{{ @$psychomotor->hand_writting }}</span>
                          </li>
                          <li class="list-group-item justify-content-between">
                            Verbal fluency
                            <span class="label label-primary pull-right">{{ @$psychomotor->vabal_fluency }}</span>
                          </li>
                          <li class="list-group-item justify-content-between">
                            Games/Sport
                            <span class="label label-primary pull-right">{{ @$psychomotor->games_sport }}</span>
                          </li>
                          <li class="list-group-item justify-content-between">
                            Handling of Tools
                            <span class="label label-primary pull-right">{{ @$psychomotor->handling_of_tools }}</span>
                          </li>
                       @endforeach  
                       </ul>                        
                      </div>
                                    
                  <div class="col-xs-4">
                                    
                       
                    <ul class="list-group">
                      <li class="list-group-item justify-content-between">
                        <p>Observations on Conduct</p>
                        <h4>EFFECTIVE AREAS</h4>
                        
                    @foreach($effective_areas->where('student_id', '=', $reg_student->student->id) as $effective_area)  
                      </li>
                      <li class="list-group-item justify-content-between">
                        Punctuality
                        <span class="label label-primary pull-right"> {{@$effective_area->punctuality}} </span>
                      </li>
                      <li class="list-group-item justify-content-between">
                        Creativity
                        <span class="label label-primary pull-right">{{@$effective_area->creativity}}</span>
                      </li>
                      <li class="list-group-item justify-content-between">
                        Reliability
                        <span class="label label-primary pull-right">{{@$effective_area->reliability}}</span>
                      </li>
                      <li class="list-group-item justify-content-between">
                        Neatness
                        <span class="label label-primary pull-right">{{@$effective_area->neatness}}</span>
                      </li>
                    @endforeach
                    </ul>

                  </div>
                                     
                  <div class="col-xs-4">
                                    
                    
                    <ul class="list-group">
                      <li class="list-group-item justify-content-between">
                        <p>Observations on Conduct</p>
                        <h5>LEARNING ACTIVITIES</h5>
                        
                    @foreach($learnining_accademics->where('student_id', '=', $reg_student->student->id) as $learnining_accademic)    
                      </li>
                      <li class="list-group-item justify-content-between">
                        Class Work
                        <span class="label label-primary pull-right"> {{ @$learnining_accademic->class_work}} </span>
                      </li>
                      <li class="list-group-item justify-content-between">
                        Home Work
                        <span class="label label-primary pull-right">{{ @$learnining_accademic->home_work}}</span>
                      </li>
                      <li class="list-group-item justify-content-between">
                        Project
                        <span class="label label-primary pull-right">{{ @$learnining_accademic->project}}</span>
                      </li>
                      <li class="list-group-item justify-content-between">
                        Note Taking
                        <span class="label label-primary pull-right">{{ @$learnining_accademic->note_taking}}</span>
                      </li>
                    @endforeach
                    </ul>
                                                   
                  </div>

            </div>
                 
                  <div class="row">
                    <div class="col-xs-12">
                            
                      <ul class="list-group">
                      <li class="list-group-item justify-content-between">
                        <h4>RATING KEY</h4>
                        
                      </li>
                      <li class="list-group-item justify-content-between">
                        Maintains an excellent degree of observed trait
                        <span class="label label-primary pull-right">5</span>
                      </li>
                      <li class="list-group-item justify-content-between">
                        Maintains a high level of observed trait
                        <span class="label label-primary pull-right">4</span>
                      </li>
                      <li class="list-group-item justify-content-between">
                        Maintains acceptable level
                        <span class="label label-primary pull-right">3</span>
                      </li>
                      <li class="list-group-item justify-content-between">
                        Shows minimal regard for trait
                        <span class="label label-primary pull-right">2</span>
                        <li class="list-group-item justify-content-between">
                        Has no regards for observed trait
                        <span class="label label-primary pull-right">1</span>
                      </li>
                      </li>
                    </ul>
                    
                               
                   </div>                                
                 </div>
                                    

                    <div class="row">
                      <div class="col-xs-12">

                     
                        

                            <div class="well well-sm">

                              <strong>REPORT CARD APPROVED BY:</strong> <span> <i>{{@$school->name}}</i></span>

                              <hr>

                              <p> <strong>DATE PRINTED:</strong><i><u>{{ @$today->toFormattedDateString() }}</u></i></p>&nbsp;&nbsp;&nbsp;&nbsp;<p><strong>SIGNATURE: &nbsp;</strong><span class="head_teacher_signature"><u>{{strtoupper(str_limit(encrypt(@$school->name), 5, (@$school_year->school_year) ))}}</u></span></p>

                            </div>
                           
                     
                    </div>
                  </div>
                          
                </div>

                                                
                <div class="row">

                  <div class="col-xs-4">
                         
                         <div class="well well-sm"><strong>Next Term Begins:</strong><br>
                         
                            @if(@$term->term != '3rd Term')
                            <i><u>{{ @$next_term->start_date->toFormattedDateString() }}</u></i>
                            @else
                            End of Year
                            @endif
                          
                         </div>

                  </div>{{-- footer-1 --}}

                    <div class="col-xs-4">
                         
                        <div class="well well-sm"><strong>Report Card reviewed by:</strong><br>

                            <i><u>{{@$teacher->first_name }}&nbsp;&nbsp;{{ @$teacher->last_name }}</u></i>

                        </div>

                    </div>{{-- footer-2 --}}


                    <div class="col-xs-4">
                         
                        <div class="well well-sm"><strong>Review Date:</strong><br>

                            <i><u>{{ $today->toFormattedDateString() }}</u></i>

                        </div>

                    </div>{{-- footer-3 --}}
               </div>

              

</div>{{--END OF PAGE2--}}

  
@endforeach

</body>
</html>