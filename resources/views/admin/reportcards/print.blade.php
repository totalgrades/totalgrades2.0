<!DOCTYPE html>
<html lang="en">
<head>
  <title>Totalgrades - Print Report Cards</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <p class="noil">{{ $schoolyear->school_year }} &nbsp; SESSION</p>
            <p class="noil">{{ $term->term }}</p> 
         
          </div>

        </div>{{-- head-2 --}}

        <div class="col-xs-3 ">
          
                 
          <div class="header text-center">
          @if(@$student_user->avatar !=null )      
              <img src="{{ public_path('assets/img/students/'.@$student_user->avatar) }}" style="width: 120px; height: 120Spx; border-radius: 50%; margin-right: 5px;"> 
          @else
              <img src="{{ public_path('assets/img/students/default.jpg') }}" style="width: 120px; height: 120Spx; border-radius: 50%; margin-right: 5px;"> 
          @endif
          <p class="bg-primary">{{@$student->first_name}} {{@$student->last_name}}</p>          
          </div>
          
        </div>{{-- head-2 --}}

    </div>{{--END HEAD--}}

    <hr>

    <div class="row">

     
       <div class="col-xs-4 ">
                  
          <ul class="list-group">
            <li class="list-group-item justify-content-between">
              Name:&nbsp;&nbsp;
              <span class="label label-primary pull-right">{{@$student->first_name}} {{@$student->last_name}}</span>
            </li>
            <li class="list-group-item justify-content-between">
              Age
              <span class="label label-primary pull-right">{{ @$student->dob->diffInYears($today) }}</span>
            </li>
            <li class="list-group-item justify-content-between">
              Admission #: 
              <span class="label label-primary pull-right">{{ @$student->registration_code }}</span>
            </li>
          </ul>
        
       </div>{{-- biodata-1 --}}

       <div class="col-xs-4 ">
                   
        <ul class="list-group">
            <li class="list-group-item justify-content-between">
              Sex:
              <span class="label label-primary pull-right">{{ @$student->gender}}</span>
            </li>
            <li class="list-group-item justify-content-between">
              # of students in class:
              <span class="label label-primary pull-right"> {{ @\App\StudentRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('group_id', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', '=', $teacher->id)->first()->group_id)->count() }}</span>
            </li>
            <li class="list-group-item justify-content-between">
              Admission Date: 
              <span class="label label-primary pull-right">{{ @$student->date_enrolled }}</span>
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
              <span class="label label-primary pull-right">{{ @\App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->first()->group->name }}</span>
            </li>
            @if(@$join_grade_activities->where('student_id', $student->id)->count() != null)
            <li class="list-group-item justify-content-between">
              Overall &#37;(Total): 
              <span class="label label-primary pull-right">{{number_format(@$join_grade_activities->where('student_id', $student->id)->sum('sum')/@$join_grade_activities->where('student_id', $student->id)->count()),2}} &#37; ({{@$join_grade_activities->where('student_id', $student->id)->sum('sum')}})</span>
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
              Times School Opened:
              <span class="label label-primary pull-right">{{@$attendance}}</span>
            </li>
            <li class="list-group-item justify-content-between">
              Times Present:
              <span class="label label-primary pull-right">{{@$attendance_present}}</span>
            </li>
            <li class="list-group-item justify-content-between">
              Times absent:
              <span class="label label-primary pull-right">{{@$attendance_absent}}</span>
            </li>
            <li class="list-group-item justify-content-between">
              Times Late:
              <span class="label label-primary pull-right">{{@$attendance_late}}</span>
            </li>
          </ul>
        
       </div>{{-- biodata-1 --}}
                
       <div class="col-xs-4">
                     
          <ul class="list-group">
              <li class="list-group-item justify-content-between">
                <h5>HEALTH RECORD</h5>
              </li>
              <li class="list-group-item justify-content-between">
                Student's Weight:
                <span class="label label-primary pull-right">{{ @$health_record->weight }} kg</span>
              </li>
              <li class="list-group-item justify-content-between">
                Students Height: 
                <span class="label label-primary pull-right">{{ @$health_record->height }} cm</span>
              </li>
              <li class="list-group-item justify-content-between">
                Nurses's Comment: 
                <span class="label label-primary pull-right">{{@$health_record->comment_nurse}}</span>
              </li>
              <li class="list-group-item justify-content-between">
                Doctor's Comment: 
                <span class="label label-primary pull-right">{{@$health_record->comment_doctor}}</span>
              </li>
          </ul>

       </div>{{-- biodata-2 --}}



        <div class="col-xs-4">
          <ul class="list-group">
            <li class="list-group-item justify-content-between">
              <h5>OVERALL REMARK</h5>
            </li>
            <li class="list-group-item justify-content-between">
                <h4>POSITION IN CLASS
                  
               <span class="label label-danger pull-right">
                  

                   @if (array_search($student->id,  $overall_position) + 1 == 1)

                        {{ array_search($student->id,  $overall_position) + 1 }}ST

                    @elseif( array_search($student->id,  $overall_position) + 1 == 2 )

                        {{ array_search($student->id,  $overall_position) + 1 }}ND

                    @elseif( array_search($student->id,  $overall_position) + 1 == 3 )

                        {{ array_search($student->id,  $overall_position) + 1 }}RD

                    @elseif( array_search($student->id,  $overall_position) + 1 == 21 )

                        {{ array_search($student->id,  $overall_position) + 1 }}ST

                    @elseif( array_search($student->id,  $overall_position) + 1 == 22 )

                        {{ array_search($student->id,  $overall_position) + 1 }}ND

                    @elseif( array_search($student->id,  $overall_position) + 1 == 23 )

                        {{ array_search($student->id,  $overall_position) + 1 }}RD

                    @elseif( array_search($student->id,  $overall_position) + 1 == 31 )

                        {{ array_search($student->id,  $overall_position) + 1 }}ST

                    @elseif( array_search($student->id,  $overall_position) + 1 == 32 )

                        {{ array_search($student->id,  $overall_position) + 1 }}ND

                    @elseif( array_search($student->id,  $overall_position) + 1 == 33 )

                        {{ array_search($student->id,  $overall_position) + 1 }}RD

                    @else

                        {{ array_search($student->id,  $overall_position) + 1 }}TH

                    @endif
                  
                </span>
              
              </h4>
            </li>
            
            <li class="list-group-item justify-content-between">
                <h5>PASSED
                        
                @if( @$join_grade_activities->where('student_id', $student->id)->count() > 0 && ( @$join_grade_activities->where('student_id', $student->id)->sum('sum')/@$join_grade_activities->where('student_id', $student->id)->count() ) >= 50 )

                <span class="label label-primary pull-right"> YES </span>
                        
                  @else
                          
                <span class="label label-primary pull-right"> NO </span>
                        
                @endif

               
              </h5>
            </li>
            
            <li class="list-group-item justify-content-between">
                <h6>NEXT CLASS
                        
                @if(@$join_grade_activities->where('student_id', $student->id)->count() > 0 &&( @$join_grade_activities->where('student_id', $student->id)->sum('sum')/@$join_grade_activities->where('student_id', $student->id)->count() ) >= 50  && @$term->id == 3)

                <span class="label label-primary pull-right"> {{ @$next_group->name}} </span>
                        
                  @elseif(@$term->id != 3)
                          
                <span class="label label-primary pull-right"> Year not ended Yet</span>
                @else
                          
                <span class="label label-primary pull-right"> Not Promoted </span>
                        
                        
                @endif

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

                    @foreach($join_grade_activities->where('course_id', $course->id) as $grade)
                      
                      
                        <tr>
                          

                          <td class="text-center">{{$course->name}}-{{$course->course_code}}</td>
                          
                          <td class="text-center">{{$grade->sum}} %</td>
                          
                          <td class="text-center">
                          
                          
                              {{ $grade_grade_activities->where('course_id', $course->id)->max('sum') }} %
                           
                          </td>
                         
                          <td class="text-center">

                             {{ $grade_grade_activities->where('course_id', $course->id)->min('sum') }} %

                          </td>

                          <td class="text-center">

                            {{ $grade_grade_activities->where('course_id', $course->id)->avg('sum') }} %


                          </td>

                          <td class="text-center">
                            
                            @foreach($grade_grade_activities_ranking as $grouped_for_ranking)

                              @foreach($grouped_for_ranking as $k1 => $grouped)

                                @if($course->id == $grouped->course_id & $student->id == $grouped->student_id)

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
        
</div>{{--END OF PAGE1--}} 
          


<div class="page2">

    <div class="row">
      <div class="col-xs-12">
        @if($comment_all === null )           
                
        <div class="well well-sm">
                      
            <strong>CLASS TEACHEAR'S COMMENT:</strong> <span> <i></i></span>
                      
                <hr>

                <p> <strong>DATE:</strong> <i><u></u></i>&nbsp;&nbsp;&nbsp;&nbsp;<strong>SIGNATURE:</strong><u>{{@$teacher->first_name}}</u></p>


          </div>

          @else            
             
                   
          <div class="well well-sm">
                      
            <strong>CLASS TEACHEAR'S COMMENT:</strong> <span> <i>{{ $comment_all->comment_teacher }}</i></span>
                      
              <hr>

                <p> <strong>DATE:</strong> <i><u>{{ $comment_all->created_at->toFormattedDateString() }}</u></i>&nbsp;&nbsp;&nbsp;&nbsp;<strong>SIGNATURE: &nbsp;</strong><span class="teacher_signature"><u>{{(@$teacher->first_name)}}{{(@$teacher->last_name)}}</u></span></p>


          </div>

          @endif
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
              <li class="list-group-item justify-content-between">
                Hand Writting
                <span class="label label-primary pull-right">{{@$psychomotor->hand_writting}}</span>
              </li>
              <li class="list-group-item justify-content-between">
                Verbal fluency
                <span class="label label-primary pull-right">{{@$psychomotor->vabal_fluency}}</span>
              </li>
              <li class="list-group-item justify-content-between">
                Games/Sport
                <span class="label label-primary pull-right">{{@$psychomotor->games_sport}}</span>
              </li>
              <li class="list-group-item justify-content-between">
                Handling of Tools
                <span class="label label-primary pull-right">{{@$psychomotor->handling_of_tools}}</span>
              </li>
            </ul>                                        
      </div>
                                
      <div class="col-xs-4">
                           
        <ul class="list-group">
          <li class="list-group-item justify-content-between">
            <p>Observations on Conduct</p>
            <h4>EFFECTIVE AREAS</h4>
            
            
          </li>
          <li class="list-group-item justify-content-between">
            Punctuality
            <span class="label label-primary pull-right">{{@$effective_areas->punctuality}}</span>
          </li>
          <li class="list-group-item justify-content-between">
            Creativity
            <span class="label label-primary pull-right">{{@$effective_areas->creativity}}</span>
          </li>
          <li class="list-group-item justify-content-between">
            Reliability
            <span class="label label-primary pull-right">{{@$effective_areas->reliability}}</span>
          </li>
          <li class="list-group-item justify-content-between">
            Neatness
            <span class="label label-primary pull-right">{{@$effective_areas->neatness}}</span>
          </li>
        </ul>

      </div>
                                 
      <div class="col-xs-4">
                        
        
        <ul class="list-group">
          <li class="list-group-item justify-content-between">
            <p>Observations on Conduct</p>
            <h5>LEARNING ACTIVITIES</h5>
            
            
          </li>
          <li class="list-group-item justify-content-between">
            Class Work
            <span class="label label-primary pull-right">{{@$learnining_accademic->class_work}}</span>
          </li>
          <li class="list-group-item justify-content-between">
            Home Work
            <span class="label label-primary pull-right">{{@$learnining_accademic->home_work}}</span>
          </li>
          <li class="list-group-item justify-content-between">
            Project
            <span class="label label-primary pull-right">{{@$learnining_accademic->project}}</span>
          </li>
          <li class="list-group-item justify-content-between">
            Note Taking
            <span class="label label-primary pull-right">{{@$learnining_accademic->note_taking}}</span>
          </li>
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

              <strong>REPORT CARD APPROVED BY:</strong> <span> <i> {{@$school->name}} </i></span>

              <hr>

              <p> <strong>DATE:</strong><i><u>{{ @$today->toFormattedDateString() }}</u></i></p>&nbsp;&nbsp;&nbsp;&nbsp;<p><strong>SIGNATURE:&nbsp;</strong><span class="head_teacher_signature"><u>{{strtoupper(str_limit(encrypt(@$school->name), 5, (@$school_year->school_year) ))}}</u></span> </p>

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




</body>
</html>