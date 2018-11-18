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
    translate(5px, 51px)
    /* 45 is really 360 - 45 */
    rotate(271deg);
  width: 30px;
}
th.rotate > div > span {
  /*border-bottom: 1px solid #ccc;*/
  padding: 10px 10px;
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
                    <a class="btn btn-danger pull-right" href="{{asset('/admin/gradingsetup/categories/'.$schoolyear->id) }}/{{$term->id}}/{{$course->id}}" role="button">Back to Activities Categories</a>
                  </div>
                  

                	<div class="col-md-12">

                        <div class="card">
                            
                            <div class="header">
                                <div class="alert alert-success">
                                    <h4 class="title">
                                        {{$gradeactivitycategory->grade_activity_category_name}}({{$gradeactivitycategory->grade_activity_category_weight}}%)
                                    </h4>
                                </div>
                                <p class="category"> 
                                    <ul class="list-inline">
                                      <li><i class="fa fa-circle text-info"></i> <strong>Course: <span style="color: rgb(48, 145, 178)">{{ strtoupper($course->course_code) }} {{ strtoupper($course->name) }} </span></strong></li>
                                      <li><i class="fa fa-circle" style="color: #FF5733"></i> <strong>School Year: <span style="color: #FF5733">{{ strtoupper($schoolyear->school_year) }} </span></strong></li>
                                      <li><i class="fa fa-circle" style="color: orange"></i> <strong>Group(Class): <span style="color: orange">{{ strtoupper($course->group->name) }}</span> </strong></li>
                                      <li><i class="fa fa-circle " style="color: #800000"></i> <strong>Term: <span style="color: #800000">{{ strtoupper($term->term) }}</span> </strong></li>
                                    </ul>
                                   
                                </p>
                                
                            </div>
                            
                        <div class="content">
                        <div class="table-responsive">
                          <table id="studentsCategoryGrades" class="table table-hover table-bordered">
                            <thead>
                              <tr >
                                  <th  class="text-center" style="font-size: 15px"><strong>#</strong></th>
                                  <th  class="text-center" style="font-size: 15px"><strong>Face
                                    <button type="button" class="btn btn-sm btn-warning"><strong><span style="font-size: 15px; color: #C70039;">{{$grade_activities->sum('grade_activity_weight')}}% </span></strong></button></strong></th>
                                  <th  class="text-center" style="font-size: 15px"><strong>First Name</strong></th>
                                  <th  class="text-center" style="font-size: 15px"><strong>Last Name</strong></th>

                                  @foreach($grade_activities as $key=>$grade_activity)

  	                                <th class="rotate">
                                      <div>
                                        <span style="font-size: 12px">

                                              {{$gradeactivitycategory->grade_activity_category_name}}
                                           
                                          <br>
                                          <strong>{{$grade_activity->grade_activity_name}}-({{$grade_activity->grade_activity_weight}}%)</strong>
                                          <br>
                                          <strong><span style="font-size: 15px; color: #C70039; font-style: italic;">{{$grade_activity->grade_activity_weight}}%</span></strong>
                                        </span>
                                      </div>
                                  </th>

                                  @endforeach
  	                                                              
                              </tr>
                            </thead>
                            <tbody>

                              
                                  @foreach (@$join_students_regs->where('term_id', $term->id)->where('group_id', $course->group_id ) as $key => $reg_students)

                                      <tr>
                                        <td class="text-center">{{$number_init++}}</td>

                                        <td class="text-center"> 
                                          @foreach ($all_users as $st_user)

                                              @if ($st_user->registration_code == $reg_students->student->registration_code)                         

                                              <img class="avatar border-white" src="{{asset('/assets/img/students/'.$st_user->avatar) }}" alt="{{$st_user->name}}"/><br>                                             

                                             @endif
                                              
                                          @endforeach
                                           <button type="button" class="btn btn-sm"><strong><span style="font-size: 20px; color: #EB5E28;">{{ $grades_and_activities->where('student_id', $reg_students->student->id)->sum('activity_grade') }}%</span></strong></button>
                                        </td>

                                        <td class="text-center">{{$reg_students->student->first_name}}</td>
                                        <td class="text-center">{{$reg_students->student->last_name}} </td>
                                       
                                        @foreach($grade_activities as $key=>$grade_activity)
                                        <td>
                                        
                                          @foreach ($student_grades->where('grade_activity_id', $grade_activity->id) as $student_grade)
                                              @if($student_grade->student_id == $reg_students->student->id)
                                                <span id="weightedGrade-{{$grade_activity->id}}{{$student_grade->id}}">{{$student_grade->activity_grade}}%</span> 
                                                <i class="fa fa-edit" id="editGradeIcon-{{$grade_activity->id}}{{$student_grade->id}}"></i>
                                                <a  id="deleteGradeIcon-{{$grade_activity->id}}{{$student_grade->id}}" href="{{asset('/grades/gradeactivity/student/deletegrade/'.$student_grade->id) }}" onclick="return confirm('Are you sure you want to Delete this record?')"><i class="fa fa-trash"></i></a>
                                                <!-- Add grade form-->
                                                <form method="post" action="{{ url('/grades/gradeactivity/student/editgrade', [$grade_activity->id, $student_grade->id]) }}" id="editGradeForm-{{$grade_activity->id}}{{$student_grade->id}}" style="display: none;">
                                                {{ csrf_field() }}

                                                
                                                <div class="form-group row">
                                                  <div class="col-xs-2">
                                                      <label>/{{$grade_activity->max_point}}%</label>
                                                      <input type="number" step=".01" class="form-control" id="activity_grade" name="activity_grade" value="{{$student_grade->actual_grade}}" required="">
                                                  </div>
                                                
                                                </div>
                                                <div class="row">
                                                  <div class="col-xs-3">
                                                    <button type="submit" class="btn btn-sm btn-success" id="editGradeSubmit-{{$grade_activity->id}}{{$student_grade->id}}">Submit</button>
                                                  </div>
                                                  <div class="col-xs-3">
                                                    <button type="button" class="btn btn-sm btn-danger" id="closeEditGradeForm-{{$grade_activity->id}}{{$student_grade->id}}">Close</button>
                                                  </div>
                                                </div>
                                                
                                              </form>
                                              <!-- End General Controls -->
                                          
                                           
                                              <script type="text/javascript">
                                                  jQuery(document).ready(function(){
                                           
                                                     
                                                     $("#editGradeIcon-{{$grade_activity->id}}{{$student_grade->id}}").click(function(){
                                                        $("#editGradeForm-{{$grade_activity->id}}{{$student_grade->id}}").show(1000);
                                                        $("#editGradeIcon-{{$grade_activity->id}}{{$student_grade->id}}").hide(1000);
                                                        $("#deleteGradeIcon-{{$grade_activity->id}}{{$student_grade->id}}").hide(1000);
                                                        $("#weightedGrade-{{$grade_activity->id}}{{$student_grade->id}}").hide(1000);
                                                        $("#addGradeIcon-{{$grade_activity->id}}{{$reg_students->student->id}}").hide(1000);
                                                     });
                                                     $("#closeEditGradeForm-{{$grade_activity->id}}{{$student_grade->id}}").click(function(){
                                                        $("#editGradeForm-{{$grade_activity->id}}{{$student_grade->id}}").hide(1000);
                                                        location.reload();
                                                     });
                                                  });

                                              </script>
                                              <!-- Add grade form Ends-->

                                              @endif
                                          @endforeach
                                            
                                             <button type="button" class="btn btn-sm btn-light" style="color: red" id="addGradeIcon-{{$grade_activity->id}}{{$reg_students->student->id}}"><i class="fa fa-pencil"></i></button>
                                            <!-- Add grade form-->
                                            <form method="post" action="{{ url('/grades/gradeactivity/student/addgrade', [$grade_activity->id]) }}" id="addGradeForm-{{$grade_activity->id}}{{$reg_students->student->id}}" style="display: none;">
                                            {{ csrf_field() }}

                                            
                                            <input type="hidden" name="grade_activity_id" value="{{$grade_activity->id}}" required="">
                                            <input type="hidden" name="student_id" value="{{$reg_students->student->id}}" required="">

                                            <div class="row">
                                              <div class="col-xs-3">
                                                  <label><small>Marked Out Of {{$grade_activity->max_point}}%</label>
                                                  <input type="number" step=".01" class="form-control" id="activity_grade" name="activity_grade" required="" placeholder="/{{$grade_activity->max_point}}%">
                                              </div>
                                            
                                            </div>
                                            <div class="row">
                                              <div class="col-xs-3">
                                                <button type="submit" class="btn btn-sm btn-success" id="addGradeSubmit-{{$grade_activity->id}}{{$reg_students->student->id}}">Submit</button>
                                              </div>
                                              <div class="col-xs-3">
                                                <button type="button" class="btn btn-sm btn-danger" id="closeGradeForm-{{$grade_activity->id}}{{$reg_students->student->id}}">Close</button>
                                              </div>
                                            </div>
                                            
                                          </form>
                                          <!-- End General Controls -->
                                      
                                       
                                          <script type="text/javascript">
                                              jQuery(document).ready(function(){
                                       
                                                 
                                                 $("#addGradeIcon-{{$grade_activity->id}}{{$reg_students->student->id}}").click(function(){
                                                    $("#addGradeForm-{{$grade_activity->id}}{{$reg_students->student->id}}").show(1000);
                                                    $("#addGradeIcon-{{$grade_activity->id}}{{$reg_students->student->id}}").hide(1000);
                                                 });
                                                 $("#closeGradeForm-{{$grade_activity->id}}{{$reg_students->student->id}}").click(function(){
                                                    $("#addGradeForm-{{$grade_activity->id}}{{$reg_students->student->id}}").hide(1000);
                                                    location.reload();
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

                          <!-- DataTable js starts -->
                          <script type="text/javascript">
                            $(document).ready(function() {
                              $('#studentsCategoryGrades').DataTable();
                          } );
                          </script>
                          <!-- DataTable js ends -->
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
