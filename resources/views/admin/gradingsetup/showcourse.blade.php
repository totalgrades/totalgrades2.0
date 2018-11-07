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
                    
                    <div class="col-md-8">
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
                                <div class="alert alert-info">
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
                                                <button type="button" class="btn btn-primary" id="editGradeActivityCategoryModal-{{$activitycategory->id}}">Edit Category</button>
                                                @include('admin.gradingsetup.updategradeactivitycategory')

                                                  <script type="text/javascript">
                                                    $('#editGradeActivityCategoryModal-{{$activitycategory->id}}').on('click', function(){
                                                      $('#showGradeActivityCategoryModal-{{$activitycategory->id}}').modal('show');
                                                    })
                                                  </script>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info" id="addGradeActivityModal-{{$activitycategory->id}}">Add Grade Activity</button>
                                                

                                                  <script type="text/javascript">
                                                    $('#addGradeActivityCategoryModal-{{$activitycategory->id}}').on('click', function(){
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
                                        @if($gradeactivitycategories->sum('grade_activity_category_weight') < 100 )
                                            <button type="button" class="btn btn-warning"><strong>Total Weight so far: {{ $gradeactivitycategories->sum('grade_activity_category_weight') }} <span>&#37;</span></strong> <mark>must be equal to 100 <span>&#37;</mark></span></button>
                                        @elseif($gradeactivitycategories->sum('grade_activity_category_weight') > 100)
                                            <button type="button" class="btn btn-danger"><strong>Total Weight: {{ $gradeactivitycategories->sum('grade_activity_category_weight') }} <span>&#37;</span></strong><mark>must be equal to 100 <span>&#37;</mark></button>
                                        @elseif($gradeactivitycategories->sum('grade_activity_category_weight') == 100)
                                            <button type="button" class="btn btn-info"><strong>Total Weight: {{ $gradeactivitycategories->sum('grade_activity_category_weight') }} <span>&#37;</span></strong></button>
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
