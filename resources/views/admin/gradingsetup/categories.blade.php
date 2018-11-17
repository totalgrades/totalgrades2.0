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
                        <div class="row">           

                            <div class="col-md-6 pull-right">
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
                                                <label for="grade_activity_category_description"><strong>Short Description<span style="color: red">(Optional)</span></strong></label>
                                                <input type="text" class="form-control" id="grade_activity_category_description" name="grade_activity_category_description" placeholder="Short Description">
                                              </div>                                
                                             
                                              <button type="submit" class="btn btn-success">Add Category</button>
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
                                <div class="alert alert-success">
                                    <h5 class="title">
                                        Grading Activity Categories
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
                                <table id="gradingSetupCategories" class="table table-bordered table-hover text-center">
                                    <thead>
                                        <th class="text-center">Category</strong></th>
                                        <th class="text-center info"><strong><span style="color: #FF5733;">Activities({{$grade_activities->sum('grade_activity_weight')}}%)</span> | <span style="color: #2874A6;">Categories({{$gradeactivitycategories->sum('grade_activity_category_weight') }}%)</span></strong></th>
                                        <th class="text-center">Description</strong></th>
                                        <th class="text-center">Date Added</strong></th>
                                        <th class="text-center">Edit</strong></th>
                                        <th class="text-center">Delete</strong></th>
                                        
                                    </thead>
                                    <tbody>
                                    @foreach ($gradeactivitycategories as $key=>$activitycategory)

                                        <tr>
                                            
                                            <td >
                                                
                                                {{ $activitycategory->grade_activity_category_name }} ({{$grade_activities->where('grade_activity_category_id', $activitycategory->id)->count()}} Activities - {{$grade_activities->where('grade_activity_category_id', $activitycategory->id)->sum('grade_activity_weight')}}%)<br>

                                                <a class="btn btn-sm btn-primary" href="{{asset('/grades/gradeactivity/studentscategorygrades/'.$activitycategory->id) }}/{{$schoolyear->id}}/{{$term->id}}/{{$course->id}}" role="button"><i class="fa fa-plus"></i>Add Grades</a>
                                            
                                                <button type="button" class="btn btn-sm btn-success" id="addGradeActivity-{{$activitycategory->id}}"><i class="fa fa-plus"></i>Add Activity
                                                </button>

                                                <a class="btn btn-sm btn-danger" href="{{asset('/admin/gradingsetup/showgradeactivities/'.$activitycategory->id) }}/{{$schoolyear->id}}/{{$term->id}}/{{$course->id}}" role="button"><i class="fa fa-pencil-square-o"></i>View/Edit Activity</a>
                                                
                                                    @include('admin.grades.gradeactivity.addgradeactivity')

                                                      <script type="text/javascript">
                                                        $('#addGradeActivity-{{$activitycategory->id}}').on('click', function(){
                                                          $('#showAddGradeActivityModal-{{$activitycategory->id}}').modal('show');
                                                        })
                                                      </script>

                                                

                                            </td>
                                            <td>
                                              <strong>
                                                <span style="color: #FF5733;">{{$grade_activities->where('grade_activity_category_id', $activitycategory->id)->sum('grade_activity_weight')}}%</span> | <span style="color: #2874A6;">{{ $activitycategory->grade_activity_category_weight }}%</span>
                                              </strong>
                                            </td>
                                            <td>{{ $activitycategory->grade_activity_category_description }}</td>
                                            <td>{{ $activitycategory->created_at->toFormattedDateString()}}</td>                                       
                                            <td>
                                                <button type="button" class="btn btn-primary" id="editGradeActivityCategoryModal-{{$activitycategory->id}}">Edit Category</button>
                                                @include('admin.gradingsetup.updategradeactivitycategory')

                                                  <script type="text/javascript">
                                                    $('#editGradeActivityCategoryModal-{{$activitycategory->id}}').on('click', function(){
                                                      $('#showGradeActivityCategoryModal-{{$activitycategory->id}}').modal('show');
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

                                <!-- DataTable js starts -->
                                <script type="text/javascript">
                                  $(document).ready(function() {
                                    $('#gradingSetupCategories').DataTable();
                                } );
                                </script>
                                <!-- DataTable js ends -->

                            </div>
                                <div class="footer">
                                   
                                    <hr>
                                    
                                    <div class="stats">
                                        @if($gradeactivitycategories->sum('grade_activity_category_weight') < 100 )
                                            <div class="alert alert-warning">
                                              <strong>Total Category Weight so far: {{ $gradeactivitycategories->sum('grade_activity_category_weight') }} <span>&#37;</span></strong> <mark>must be equal to 100</mark>
                                            </div>
                                        @elseif($gradeactivitycategories->sum('grade_activity_category_weight') > 100)
                                            <div class="alert alert-danger">
                                              <strong>Total Category Weight: {{ $gradeactivitycategories->sum('grade_activity_category_weight') }} <span>&#37;</span></strong><mark>must be equal to 100 <span>&#37;</span></mark>
                                            </div>

                                        @elseif($gradeactivitycategories->sum('grade_activity_category_weight') == 100)
                                            <div class="alert">
                                              <strong><span style="color: #FF5733;">Total Weight of all activities in this course is: {{$grade_activities->sum('grade_activity_weight')}} <span>&#37;</span></span></strong>
                                            </div> 
                                            <strong>|</strong>
                                            <div class="alert">
                                              <strong><span style="color: #2874A6;">Total Weight of all categories in this course is {{$gradeactivitycategories->sum('grade_activity_category_weight') }} <span>&#37;</span></span></strong>
                                            </div>
                                            
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