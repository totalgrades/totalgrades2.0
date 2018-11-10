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
                                 
                                 <a><i class="fa fa-book fa-2x" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Course:&nbsp; {{ $gradeactivitycategory->course->course_code }}: {{ $gradeactivitycategory->course->name }} </a> <div class="pull-right"><a href="{{asset('/admincourses/'.$schoolyear->id) }}/{{$term->id}}"><button type="button" class="btn btn-primary">Back To {{@$term->term}} Courses</button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger">Select Another Grade Activity</button></div>
                                 <strong><p>{{ strtoupper($schoolyear->school_year) }} School Year</p></strong>
                                 </h4>
                                
                                
                            </div>
                            
                        <div class="content">
                        <div class="table-responsive">
                          <table class="table table-bordered table-hover" style="font-size: 12px;">
                            <thead>
                                <tr>
	                                <th  class="text-center">#</th>
	                                <th  class="text-center">Activity Name</th>
	                                <th  class="text-center">Weight</th>
                                  <th  class="text-center">Description</th>
	                                @if($schoolyear->id == $current_school_year->id && $term->id == $current_term->id)
	                                    <th colspan="3" class="text-center">Action</th>
	                                @endif
                              </tr>
                          </thead>
                            <tbody>

                             @foreach ($grade_activities as $key=>$grade_activity)
                                  

                                      <tr>
                                        <td class="text-center">{{$number_init++}}</td>
                                        <td class="text-center">{{$grade_activity->grade_activity_name}}</td>
                                        <td class="text-center">{{$grade_activity->grade_activity_weight}}</td>
                                        <td class="text-center">{{$grade_activity->grade_activity_description}}</td>
                                        
                                        <td class="text-center">
                                          <button type="button" class="btn btn-primary">Edit</button>
                                            <!-- Edit grade activity form-->
                                            <form class="form-group" action="{{ url('/admin/gradingsetup/editGradeActivity/') }}" method="POST" id="editGradeActivityForm-{{$grade_activity->id}}" style="display: none">
                                                {{ csrf_field() }}
                                                  
              
                                                  <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                      <label for="grade_activity_name"><strong>Activity Name</strong></label>
                                                      <input type="text" class="form-control" id="grade_activity_name" name="grade_activity_name" placeholder="Activity name" required="">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                      <label for="max_point"><strong>Weight of this activity in this category</strong></label>
                                                      <input type="number" step=".01" class="form-control" id="grade_activity_weight" name="grade_activity_weight" placeholder="Weight of this activity in this category" required="">
                                                    </div>
                                                  </div>
                                                  <div class="form-group col-md-12">
                                                    <label for="grade_activity_description"><strong>Short Description</strong></label>
                                                    <input type="text" class="form-control" id="grade_activity_description" name="grade_activity_description" placeholder="Short Description" required="">
                                                  </div>                                
                                                 
                                                  <button type="submit" class="btn btn-success">Add Activity</button>
                                                  <button type="button" class="btn btn-danger" id="closeGradeActivityForm">Close Form</button>
                                                </form>
                                  		    <!-- End General Controls -->
                                  		  
                                  		   
                                  		   	<script type="text/javascript">
        				                            jQuery(document).ready(function(){
        				                     
        				                               
        				                               $("#showAddGradeForm").click(function(){
        				                                  $("#addGradeForm").show(1000);
        				                               });
        				                               $("#closeGradeForm").click(function(){
        				                                  $("#addGradeForm").hide(1000);
        				                               });
        				                            });

        				                          </script>
                                  		   <!-- Edit grade activity form Ends-->
                              		      </td>

                                        <td class="text-center">
                                                                                 		
	                                        	<a href="{{ url('/grades/gradeactivity/student/deletegrade/'.$grade_activity->id) }}" onclick="return confirm('Are you sure you want to Delete this record?')"> <i class="fa fa-trash fa-2x" aria-hidden="true"></i>&nbsp;&nbsp;Delete
		                                        </a>
			                                  
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
