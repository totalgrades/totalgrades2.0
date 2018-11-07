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
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary pull-left" id="newGradeActivity">New Grade Activity</button>
                                <hr>
                                <div class="col-md-12 pull-left" id="newGradeActivityForm" style="display: none;">
                                    <div class="card">
                                        <div class="content">
                                            <form class="form-group" action="{{ url('/admin/gradingsetup/addNewGradeActivity/') }}" method="POST">
                                            {{ csrf_field() }}
                                              
                                                <input type="hidden" name="school_year_id" value="{{$schoolyear->id}}">
                                                <input type="hidden" name="term_id" value="{{$term->id}}">
                                                <input type="hidden" name="group_id" value="{{$course->group_id}}">
                                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                            <div class="form-group col-md-12">
                                                <div class="form-group col-md-6">
                                                    <select name="attendance_code_id" id="attendance_code_id">
                                                       <option selected disabled>Please select a Category</option>
                                                        @foreach($gradeactivitycategories as $key => $gradeactivitycategory)

                                                            <option value="{{ $gradeactivitycategory->id }}" >
                                                                {{ $gradeactivitycategory->grade_activity_category_name }}({{ $gradeactivitycategory->grade_activity_category_weight }} %)
                                                            </option>

                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>

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
                                        </div>
                                        
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    jQuery(document).ready(function(){
                             
                                       
                                       $("#newGradeActivity").click(function(){
                                          $("#newGradeActivityForm").show(1000);
                                       });
                                       $("#closeGradeActivityForm").click(function(){
                                          $("#newGradeActivityForm").hide(1000);
                                       });
                                    });

                                </script>
                            </div>
                        </div>

                        <div class="card">
                            <div class="header">
                                <div class="alert alert-info">
                                    <h4 class="title">
                                        <strong>Grading Activities For <span style="color: red">{{ strtoupper($course->course_code) }} {{ strtoupper($course->name) }}</span></strong>
                                        <p><strong>School Year: <span style="color: red">{{ strtoupper($schoolyear->school_year) }} </span></strong></p>
                                        <p><strong>Group(Class): <span style="color: red">{{ strtoupper($course->group->name) }}</span> </strong></p>
                                        <p><strong>Term: <span style="color: red">{{ strtoupper($term->term) }}</span> </strong></p>
                                    </h4>
                                </div>
                                <p class="category"> <i class="fa fa-circle text-danger"></i> <strong>My Assigned Class:</strong> 
                                    {{ @\App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', '=', $teacher->id)->first()->group->name }}
                                </p>
                            </div>

                            <div class="content">
                                <table class="table table-striped text-center">
                                    <thead>
                                        <th class="text-center"><strong>Grade Activity</strong></th>
                                        <th class="text-center info"><strong>Max Point Allowed</strong></th>
                                        <th class="text-center"><strong>Activity Description</strong></th>
                                        <th class="text-center info"><strong>Date Added</strong></th>
                                        <th class="text-center"><strong>Edit</strong></th>
                                        <th class="text-center"><strong>Delete</strong></th>
                                        
                                    </thead>
                                    <tbody>
                                    @foreach ($grade_activities as $key=>$grade_activity)

                                        <tr>
                                            
                                            <td>{{ $grade_activity->grade_activity_name }}</td>
                                            <td>{{ $grade_activity->max_point }} %</td>
                                            <td>{{ $grade_activity->grade_activity_description }}</td>
                                            <td>{{ $grade_activity->created_at->toFormattedDateString()}}</td>                                       
                                            <td>
                                                <button type="button" class="btn btn-primary" id="editGradeActivityModal-{{$grade_activity->id}}">Edit</button>
                                                @include('admin.gradingsetup.updategradeactivity')

                                                  <script type="text/javascript">
                                                    $('#editGradeActivityModal-{{$grade_activity->id}}').on('click', function(){
                                                      $('#showGradeActivityModal-{{$grade_activity->id}}').modal('show');
                                                    })
                                                  </script>
                                            </td>
                                          

                                            <td>
                                                <strong>
                                                    <a href="{{asset('/admin/gradingsetup/deleteGradeActivity/'.$grade_activity->id) }}" onclick="return confirm('Are you sure you want to Delete this record?')"><i class="fa fa-trash fa-2x" aria-hidden="true"></i>&nbsp;&nbsp;Delete</a>
                                                </strong>
                                            </td>
                                           
                                           
                                        </tr>
                                    @endforeach
                                        
                                    </tbody>
                                </table>

                                <div class="footer">
                                   
                                    <hr>
                                    
                                    <div class="stats">
                                        <i class="ti-timer"></i> These grade activities are for the class you are responsible for this term. You can manage them here.
                                    </div>
                                    
                                </div>
                            </div>
                        
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">           

                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger pull-right" id="newGradeActivityCategory">New Grade Activity Category</button>
                                <hr>
                                <div class="col-md-12 pull-right" id="newGradeActivityCategoryForm" style="display: none;">
                                    <div class="card">
                                        <div class="content">
                                            <form class="form-group" action="{{ url('/admin/gradingsetup/addNewGradeActivityCategory/') }}" method="POST">
                                            {{ csrf_field() }}
                                                                                      
                                                
                                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                                                                   

                                              <div class="form-row">

                                                <div class="form-group col-md-6">
                                                  <label for="grade_activity_category_name"><strong>Category Name</strong></label>
                                                  <input type="text" class="form-control" id="grade_activity_category_name" name="grade_activity_category_name" placeholder="Category name" required="">
                                                </div>
                                                <div class="form-group col-md-6">
                                                  <label for="grade_activity_category_weight"><strong>Total Weight of this category</strong></label>
                                                  <input type="number" step=".01" class="form-control" id="grade_activity_category_weight" name="grade_activity_category_weight" placeholder="Weight of this category" required="">
                                                </div>
                                              </div>
                                              <div class="form-group col-md-12">
                                                <label for="grade_activity_category_description"><strong>Short Description</strong></label>
                                                <input type="text" class="form-control" id="grade_activity_category_description" name="grade_activity_category_description" placeholder="Short Description">
                                              </div>                                
                                             
                                              <button type="submit" class="btn btn-success">Add Activity</button>
                                              <button type="button" class="btn btn-danger" id="closeGradeActivityCategoryForm">Close Form</button>
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    jQuery(document).ready(function(){
                             
                                       
                                       $("#newGradeActivityCategory").click(function(){
                                          $("#newGradeActivityCategoryForm").show(1000);
                                       });
                                       $("#closeGradeActivityCategoryForm").click(function(){
                                          $("#newGradeActivityCategoryForm").hide(1000);
                                       });
                                    });

                                </script>
                            </div>

                        </div>

                        <div class="card">
                            <div class="header">
                                <div class="alert alert-danger">
                                    <h4 class="title">
                                        <strong>Grading Activity Categories</strong>
                                        <p><strong>Course: <span style="color: red">{{ strtoupper($course->course_code) }} {{ strtoupper($course->name) }} </span></strong></p>
                                        <p><strong>School Year: <span style="color: red">{{ strtoupper($schoolyear->school_year) }} </span></strong></p>
                                        <p><strong>Group(Class): <span style="color: red">{{ strtoupper($course->group->name) }}</span> </strong></p>
                                        <p><strong>Term: <span style="color: red">{{ strtoupper($term->term) }}</span> </strong></p>
                                    </h4>
                                </div>
                                <p class="category"> <i class="fa fa-circle text-danger"></i> <strong>My Assigned Class:</strong> 
                                    {{ @\App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', '=', $teacher->id)->first()->group->name }}
                                </p>
                            </div>

                            <div class="content">
                                <table class="table table-striped text-center">
                                    <thead>
                                        <th class="text-center"><strong>Category</strong></th>
                                        <th class="text-center info"><strong>Weight</strong></th>
                                        <th class="text-center"><strong>Description</strong></th>
                                        <th class="text-center info"><strong>Date Added</strong></th>
                                        <th class="text-center"><strong>Edit</strong></th>
                                        <th class="text-center"><strong>Delete</strong></th>
                                        
                                    </thead>
                                    <tbody>
                                    @foreach ($gradeactivitycategories as $key=>$activitycategory)

                                        <tr>
                                            
                                            <td>{{ $activitycategory->grade_activity_category_name }}</td>
                                            <td>{{ $activitycategory->grade_activity_category_weight }} %</td>
                                            <td>{{ $activitycategory->grade_activity_category_description }}</td>
                                            <td>{{ $activitycategory->created_at->toFormattedDateString()}}</td>                                       
                                            <td>
                                                <button type="button" class="btn btn-primary" id="editGradeActivityCategoryModal-{{$activitycategory->id}}">Edit</button>
                                                

                                                  <script type="text/javascript">
                                                    $('#editGradeActivityCategoryModal-{{$activitycategory->id}}').on('click', function(){
                                                      $('#showGradeActivityModal-{{$activitycategory->id}}').modal('show');
                                                    })
                                                  </script>
                                            </td>
                                          

                                            <td>
                                                <strong>
                                                    <a href="{{asset('/admin/gradingsetup/deleteGradeActivityCategory/'.$activitycategory->id) }}" onclick="return confirm('Are you sure you want to Delete this record?')"><i class="fa fa-trash fa-2x" aria-hidden="true"></i>&nbsp;&nbsp;Delete</a>
                                                </strong>
                                            </td>
                                           
                                           
                                        </tr>
                                    @endforeach
                                        
                                    </tbody>
                                </table>

                                <div class="footer">
                                   
                                    <hr>
                                    
                                    <div class="stats">
                                        <i class="ti-timer"></i> These grade activities are for the class you are responsible for this term. You can manage them here.
                                    </div>
                                    
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

       
@endsection
