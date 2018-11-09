@extends('admin.dashboard')
<style type="text/css">
 th.rotate {
  /* Something you can count on */
  height: 140px;
  white-space: nowrap;
}

th.rotate > div {
  transform: 
    /* Magic Numbers */
    translate(25px, 51px)
    /* 45 is really 360 - 45 */
    rotate(290deg);
  width: 30px;
}
th.rotate > div > span {
  border-bottom: 1px solid #ccc;
  padding: 5px 10px;
}


</style>
@section('content')

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                     @include('admin.includes.headdashboardtop')
                </div>

                @include('flash::message')
                @include('formerror')
                <div class="row">

                	<div class="col-md-12">
                        <div class="card">
                            <div class="header">
                              
                                 
                              
                                
                            </div>
                            
                        <div class="content">
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                  <th  class="text-center">#</th>
                                  <th  class="text-center">Face</th>
                                  <th  class="text-center">Last Name</th>

                                  @foreach($grade_activities as $key=>$grade_activity)

  	                                <th class="rotate" >
                                      <div>
                                        <span style="font-size: 17px">
                                          {{$grade_activity->grade_activity_name}}-({{$grade_activity->grade_activity_weight}}%)
                                        </span>
                                      </div>
                                  </th>

                                  @endforeach
  	                                                              
                              </tr>
                            </thead>
                            <tbody>

                               @foreach (@$join_students_regs->where('term_id', $term->id)->where('group_id', \App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', \App\Staffer::where('registration_code', '=', Auth::guard('web_admin')->user()->registration_code)->first()->id)->first()->group_id ) as $key => $reg_students)
                                  

                                      <tr>
                                        <td class="text-center">{{$number_init++}}</td>

                                        <td class="text-center"> 
                                          @foreach ($all_users as $st_user)

                                              @if ($st_user->registration_code == $reg_students->student->registration_code)                         

                                              <img class="avatar border-white" src="{{asset('/assets/img/students/'.$st_user->avatar) }}" alt="..."/>

                                             @endif
                                              
                                          @endforeach
                                        </td>

                                        <td class="text-center">{{$reg_students->student->last_name}} {{$reg_students->student->first_name}}</td>

                                       
                                        @foreach($grade_activities as $key=>$grade_activity)
                                        <td class="text-center">
                                        
                                          @foreach ($student_grades->where('grade_activity_id', $grade_activity->id) as $student_grade)
                                              @if($student_grade->student_id == $reg_students->student->id)
                                                {{$student_grade->activity_grade}} % <i class="fa fa-edit"></i><i class="fa fa-trash"></i>
                                              @endif
                                          @endforeach
                                            <button type="button" class="btn btn-light" style="color: red" id="addGradeIcon-{{$grade_activity->id}}{{$reg_students->student->id}}"><i class="fa fa-pencil"></i></button>

                                             <!-- Add grade form-->
                                            <form method="post" action="{{ url('/grades/gradeactivity/student/addgrade', [$grade_activity->id]) }}" id="addGradeForm-{{$grade_activity->id}}{{$reg_students->student->id}}" style="display: none;">
                                            {{ csrf_field() }}

                                            
                                            <input type="hidden" name="grade_activity_id" value="{{$grade_activity->id}}" required="">
                                            <input type="hidden" name="student_id" value="{{$reg_students->student->id}}" required="">

                                            <div class="row">
                                              <div class="col-md-3">
                                                  <label>Grade</label>
                                                  <input type="number" step=".01" class="form-control" id="activity_grade" name="activity_grade" required="">
                                              </div>
                                              <div class="col-md-4">
                                                <label>Comment</label>
                                                <input type="text" class="form-control" id="activity_comment" name="activity_comment">
                                              </div>
                                            
                                            </div>
                                            <div class="row">
                                              <div class="col-md-2">
                                                <button type="submit" class="btn btn-success" id="addGradeSubmit-{{$grade_activity->id}}{{$reg_students->student->id}}">Submit</button>
                                              </div>
                                              <div class="col-md-2">
                                                <button type="button" class="btn btn-danger" id="closeGradeForm-{{$grade_activity->id}}{{$reg_students->student->id}}">Close</button>
                                              </div>
                                            </div>
                                            
                                          </form>
                                          <!-- End General Controls -->
                                      
                                       
                                          <script type="text/javascript">
                                              jQuery(document).ready(function(){
                                       
                                                 
                                                 $("#addGradeIcon-{{$grade_activity->id}}{{$reg_students->student->id}}").click(function(){
                                                    $("#addGradeForm-{{$grade_activity->id}}{{$reg_students->student->id}}").show(1000);
                                                 });
                                                 $("#closeGradeForm-{{$grade_activity->id}}{{$reg_students->student->id}}").click(function(){
                                                    $("#addGradeForm-{{$grade_activity->id}}{{$reg_students->student->id}}").hide(1000);
                                                 });
                                              });

                                          </script>
                                          <!-- Add grade form Ends-->

                                        </td>
                                        @endforeach
                                        
                                      
                                      
                                        
                                       
                                       
                                      </tr>
                                   
                                 
                                @endforeach
                           
                            </tbody>                            
                           
                            </tbody>
                          </table>
                        </div>


                               
                                <div class="footer">
                                    <!-- <div class="chart-legend">
                                        <i class="fa fa-circle text-info"></i> Open
                                        <i class="fa fa-circle text-danger"></i> Click
                                        <i class="fa fa-circle text-warning"></i> Click Second Time
                                    </div> -->
                                    <hr>
                                    <!-- <div class="stats">
                                        <i class="ti-reload"></i> Updated 3 minutes ago
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
         </div>

       
@endsection
