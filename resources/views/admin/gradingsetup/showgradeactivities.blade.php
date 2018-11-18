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
                    <a class="btn btn-primary pull-left" href="{{asset('/admin/gradingsetup/categories/'.$schoolyear->id) }}/{{$term->id}}/{{$course->id}}" role="button"><i class="fa fa-reply"></i> Back to Categories</a> <span style="font-size: 22px; color: #17202A;">&nbsp; OR </span>
                    <button type="button" class="btn btn-danger" id="selectAnotherCategory-{{$course->id}}"><i class="fa fa-cog"></i>Select Another Category
                    </button>
                     @include('admin.gradingsetup.selectAnotherCategoryModal')

                    <script type="text/javascript">
                      $('#selectAnotherCategory-{{$course->id}}').on('click', function(){
                        $('#selectAnotherCategoryModal-{{$course->id}}').modal('show');
                      })
                    </script>
                    <button type="button" class="btn btn-success pull-right" id="newGradeActivity-{{$gradeactivitycategory->id}}"><i class="fa fa-plus"></i>New Activity
                    </button>
                    @include('admin.grades.gradeactivity.newgradeactivity')

                    <script type="text/javascript">
                      $('#newGradeActivity-{{$gradeactivitycategory->id}}').on('click', function(){
                        $('#showNewGradeActivityModal-{{$gradeactivitycategory->id}}').modal('show');
                      })
                    </script>
                 </div>
                </div>

                <div class="row">
                                    
                	<div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                 <div class="alert alert-success">
                                    <h5 class="title">
                                        <strong>{{$gradeactivitycategory->grade_activity_category_name}}({{$gradeactivitycategory->grade_activity_category_weight}}%)
                                        </strong>
                                        
                                    </h5>
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
                          <table id="gradingSetupshowGradeActivities" class="table table-bordered table-hover">
                            <thead>
                                <tr>
	                                <th  class="text-center"><strong>#</strong></th>
	                                <th  class="text-center"><strong>Activity Name</strong></th>
                                   <th  class="text-center"><strong>Marked Over</strong></th>
	                                <th  class="text-center"><strong>Weight</strong></th>
                                  <th  class="text-center"><strong>Description</strong></th>
	                                @if($schoolyear->id == $current_school_year->id && $term->id == $current_term->id)
	                                    <th colspan="2" class="text-center"><strong>Action</strong></th>
	                                @endif
                              </tr>
                          </thead>
                            <tbody>

                             @foreach ($grade_activities as $key=>$grade_activity)
                                  

                                      <tr>
                                        <td class="text-center">{{$number_init++}}</td>
                                        <td class="text-center">{{$grade_activity->grade_activity_name}}</td>
                                        <td class="text-center">{{$grade_activity->max_point}}%</td>
                                        <td class="text-center">{{$grade_activity->grade_activity_weight}}%</td>
                                        <td class="text-center">{{$grade_activity->grade_activity_description}}</td>
                                        
                                        <td class="text-center">
                                          <button type="button" class="btn btn-primary" id="editGradeActivity-{{$grade_activity->id}}"><i class="fa fa-edit"></i> Edit</button>
                                            <!-- Edit grade activity form-->
                                            <form class="form-horizontal" action="{{ url('/admin/gradingsetup/editGradeActivity', [$grade_activity->id]) }}" method="POST" id="editGradeActivityForm-{{$grade_activity->id}}" style="display: none">
                                                {{ csrf_field() }}


                                                <input type="hidden" name="grade_activity_category_id" value="{{$gradeactivitycategory->id}}">
                                                <input type="hidden" name="grade_activity_category_weight" value="{{$gradeactivitycategory->grade_activity_category_weight}}">

                                                  <div class="form-group">

                                                    <div class="col-md-3">
                                                      <label for="grade_activity_name"><strong>Activity Name</strong></label>
                                                      <input type="text" class="form-control" id="grade_activity_name" name="grade_activity_name" value="{{$grade_activity->grade_activity_name}}" required="">
                                                    </div>
                                                    <div class="col-md-3">
                                                      <label for="max_point"><strong>Marked Over(%)</strong></label>
                                                      <input type="number" step=".01" class="form-control" id="max_point" name="max_point" value="{{$grade_activity->max_point}}" required="">
                                                    </div>
                                                    <div class="col-md-3">
                                                      <label for="grade_activity_weight"><strong>Weight(%)</strong></label>
                                                      <input type="number" step=".01" class="form-control" id="grade_activity_weight" name="grade_activity_weight" value="{{$grade_activity->grade_activity_weight}}" required="">
                                                    </div>
                                                  </div>

                                                  <div class="form-group">
                                                    <div class="col-md-4">
                                                      <label for="grade_activity_description"><strong>Short Description</strong></label>
                                                      <input type="text" class="form-control" id="grade_activity_description" name="grade_activity_description" value="{{$grade_activity->grade_activity_description}}" required="">
                                                    </div>                                
                                                 </div>
                                                 <div class="form-group">

                                                    <div class="col-md-3">
                                                      <button type="submit" class="btn btn-success">Update Activity</button>
                                                    </div>
                                                    <div class="col-md-2">
                                                      <button type="button" class="btn btn-danger" id="closeEditGradeActivityForm-{{$grade_activity->id}}">Close Form</button>
                                                    </div>
                                                  </div> 
                                                </form>
                                  		    <!-- End General Controls -->
                                  		  
                                  		   
                                  		   	<script type="text/javascript">
        				                            jQuery(document).ready(function(){
        				                     
        				                               
        				                               $("#editGradeActivity-{{$grade_activity->id}}").click(function(){
        				                                  $("#editGradeActivityForm-{{$grade_activity->id}}").show(1000);
                                                  $("#editGradeActivity-{{$grade_activity->id}}").hide(1000);
        				                               });
        				                               $("#closeEditGradeActivityForm-{{$grade_activity->id}}").click(function(){
        				                                  $("#editGradeActivityForm-{{$grade_activity->id}}").hide(1000);
                                                  $("#editGradeActivity-{{$grade_activity->id}}").show(1000);
        				                               });
        				                            });

        				                          </script>
                                  		   <!-- Edit grade activity form Ends-->

                                            
                              		      </td>
                                        <td>
                                          <a href="{{ url('/admin/gradingsetup/deleteGradeActivity/'.$grade_activity->id) }}" onclick="return confirm('Are you sure you want to Delete this record?')" class="btn btn-danger" role="button"> <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                        
                                      </tr>
                                   
                                 
                                @endforeach
                           
                            </tbody>
                          </table>

                          <!-- DataTable js starts -->
                          <script type="text/javascript">
                            $(document).ready(function() {
                              $('#gradingSetupshowGradeActivities').DataTable();
                          } );
                          </script>
                          <!-- DataTable js ends -->
                        </div>


                               
                                <div class="footer">
                                   
                                    <hr>
                                    
                                    <div class="stats">
                                       
                                          @if($grade_activities->sum('grade_activity_weight') < $gradeactivitycategory->grade_activity_category_weight)
                                              <div class="alert alert-warning">
                                                <strong>Total Weight so far: {{ $grade_activities->sum('grade_activity_weight') }} <span>&#37;</span></strong> <mark>must be equal to {{ $gradeactivitycategory->grade_activity_category_weight }}</mark>
                                              </div>
                                          @elseif($grade_activities->sum('grade_activity_weight') > $gradeactivitycategory->grade_activity_category_weight)
                                              <div class="alert alert-danger">
                                                <strong>Total Weight: {{ $grade_activities->sum('grade_activity_weight') }} <span>&#37;</span></strong><mark>must be equal to {{ $gradeactivitycategory->grade_activity_category_weight }} <span>&#37;</span></mark>
                                              </div>

                                          @elseif($grade_activities->sum('grade_activity_weight') == $gradeactivitycategory->grade_activity_category_weight)
                                              <div class="alert alert-success"><strong>Total Weight: {{ $grade_activities->sum('grade_activity_weight') }} <span>&#37;</span></strong> <mark>Awesome! You have reached the maximum weight allowed for this category</mark></div>
                                          @endif
                                                                              
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
         </div>

       
@endsection
