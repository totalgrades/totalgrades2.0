@extends('admin.dashboard')

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
                                 <h4 class="title"> 
                                 
                                 <a><i class="fa fa-book fa-2x" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Course:&nbsp; {{ $gradeactivity->course->course_code }}: {{ $gradeactivity->course->name }} </a> <div class="pull-right"><a href="{{asset('/admincourses/'.$schoolyear->id) }}/{{$term->id}}"><button type="button" class="btn btn-primary">Back To {{@$term->term}} Courses</button></a></div>
                                 <strong><p>{{ strtoupper($schoolyear->school_year) }} School Year</p></strong>
                                 </h4>
                                <p class="category"><strong>{{strtoupper($gradeactivity->group->name)}} - {{ strtoupper($term->term) }}</strong></p>
                                
                            </div>
                            
                        <div class="content">
                        <div class="table-responsive">
                          <table class="table table-bordered table-hover" style="font-size: 12px;">
                            <thead>
                                <tr>
	                                <th  class="text-center">Table</th>
	                                <th  class="text-center">Face</th>
	                                <th  class="text-center">Last Name</th>
	                                <th  class="text-center">Course</th>
	                                <th  class="text-center">Activity Name</th>
	                                <th  class="text-center">Max Point</th>
	                                <th  class="text-center">Student's Point</th>
	                                @if($schoolyear->id == $current_school_year->id && $term->id == $current_term->id)
	                                    <th colspan="3" class="text-center">Action</th>
	                                @endif
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

                                        <td class="text-center">
                                        @foreach ($grade_activities as $grade)
                                            
                                          {{$grade->course->course_code}}
                                         
                                        @endforeach
                                        </td>

                                        <td class="text-center">
                                        @foreach ($grade_activities as $grade)
                                            
                                          {{$grade->grade_activity_name}}
                                         
                                        @endforeach
                                        </td>
                                        
                                        <td class="text-center">
                                        @foreach ($grade_activities as $grade)
                                            
                                          {{$grade->max_point}} %
                                         
                                        @endforeach
                                        </td>

                                        <td class="text-center">
                                        @foreach ($student_grades as $student_grade)
                                            @if($student_grade->student_id == $reg_students->student->id)
                                          		{{$student_grade->activity_grade}} %
                                          	@endif
                                        @endforeach
                                        <!-- Add grade form-->
                                        <form method="post" action="{{ url('/grades/gradeactivity/student/addgrade') }}" id="addGradeForm-{{$reg_students->student->id}}" style="display: none;">
                              		      {{ csrf_field() }}

                              		      <input type="hidden" name="grade_activity_id" value="{{$gradeactivity->id}}" required="">
                              		      <input type="hidden" name="student_id" value="{{$reg_students->student->id}}" required="">

                              		      <div class="row">
                              		      	<div class="col-md-3">
                              		           	<label>Grade</label>
                              		          	<input type="number" step=".01" class="form-control" id="activity_grade" name="activity_grade" required="">
                              		        </div>
                              		        <div class="col-md-4">
                              		        	<label>Comment</label>
                              		      		<input type="text" class="form-control" id="activity_comment" name="activity_comment"  required="">
                              		      	</div>
                              		      
                              		      </div>
                              		      <div class="row">
                              		      	<div class="col-md-2">
                              		      	 	<button type="submit" class="btn btn-success" id="addGradeSubmit-{{$reg_students->student->id}}">Submit</button>
                              		      	</div>
                              		      	<div class="col-md-2">
                              		      		<button type="button" class="btn btn-danger" id="closeGradeForm-{{$reg_students->student->id}}">Close</button>
                              		      	</div>
                              		      </div>
                              		      
                              		    </form>
                              		    <!-- End General Controls -->
                              		  
                              		   
                              		   	<script type="text/javascript">
				                            jQuery(document).ready(function(){
				                     
				                               
				                               $("#showAddGradeForm-{{$reg_students->student->id}}").click(function(){
				                                  $("#addGradeForm-{{$reg_students->student->id}}").show(1000);
				                               });
				                               $("#closeGradeForm-{{$reg_students->student->id}}").click(function(){
				                                  $("#addGradeForm-{{$reg_students->student->id}}").hide(1000);
				                               });
				                            });

				                        </script>
                              		  
                              		    
                              		   <!-- Add grade form Ends-->
                              		   <!-- Edit grade form-->
                              		   @foreach ($student_grades as $student_grade)
                                            @if($student_grade->student_id == $reg_students->student->id & $student_grade->grade_activity_id == $gradeactivity->id)
		                                        <form method="post" action="{{ url('/grades/gradeactivity/student/editgrade',[$student_grade->id]) }}" id="editGradeForm-{{$student_grade->id}}" style="display: none;">
		                              		      {{ csrf_field() }}

		                              		      <div class="row">
		                              		      	<div class="col-md-3">
		                              		           	<label>Grade</label>
		                              		          	<input type="number" step=".01" class="form-control" value="{{$student_grade->activity_grade}}" name="activity_grade" required="">
		                              		        </div>
		                              		        <div class="col-md-4">
		                              		        	<label>Comment</label>
		                              		      		<input type="text" class="form-control" value="{{$student_grade->activity_comment}}" name="activity_comment"  required="">
		                              		      	</div>
		                              		      
		                              		      </div>
		                              		      <div class="row">
		                              		      	<div class="col-md-2">
		                              		      	 	<button type="submit" class="btn btn-success" id="editGradeSubmit-{{$student_grade->id}}">Submit</button>
		                              		      	</div>
		                              		      	<div class="col-md-2">
		                              		      		<button type="button" class="btn btn-danger" id="closEditGradeForm-{{$student_grade->id}}">Close</button>
		                              		      	</div>
		                              		      </div>
		                              		      
		                              		    </form>
		                              		    <script type="text/javascript">
						                            jQuery(document).ready(function(){
						                     
						                               
						                               $("#showEditGradeForm-{{$student_grade->id}}").click(function(){
						                                  $("#editGradeForm-{{$student_grade->id}}").show(1000);
						                               });
						                               $("#closEditGradeForm-{{$student_grade->id}}").click(function(){
						                                  $("#editGradeForm-{{$student_grade->id}}").hide(1000);
						                               });
						                            });

						                        </script>
                              		  		@endif
                                        @endforeach
                              		    
                              		   <!-- Add grade form Ends-->
                                        </td>
                                      
                                      
                                        <td class="text-center"><button type="button" class="btn btn-info" id="showAddGradeForm-{{$reg_students->student->id}}">Add Grade</button></td>
                                       
                                        <td class="text-center">
                                        @foreach ($student_grades as $student_grade)
                                            @if($student_grade->student_id == $reg_students->student->id & $student_grade->grade_activity_id == $gradeactivity->id)
                                            
	                                        <button type="button" class="btn btn-danger" id="showEditGradeForm-{{$student_grade->id}}">Edit Grade</button>
                                        
                                        	@endif
                                        @endforeach
                                        </td>

                                        <td class="text-center">
                                         @foreach ($student_grades as $student_grade)
                                            @if($student_grade->student_id == $reg_students->student->id & $student_grade->grade_activity_id == $gradeactivity->id)
                                        		
	                                        	<a href="{{ url('/grades/gradeactivity/student/deletegrade/'.$student_grade->id) }}" onclick="return confirm('Are you sure you want to Delete this record?')"> <i class="fa fa-trash fa-2x" aria-hidden="true"></i>&nbsp;&nbsp;Delete
		                                        </a>
			                                    
                                      		@endif
                                        @endforeach
                                      </td>
                                      </tr>
                                   
                                 
                                @endforeach
                           
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
