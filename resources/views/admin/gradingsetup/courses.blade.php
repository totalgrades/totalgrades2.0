@extends('admin.dashboard')

@section('content')

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                     @include('admin.includes.headdashboardtop')
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <div class="alert alert-success">
                                    <h4 class="title">
                                        <strong>Setup Grading For {{ strtoupper($term->term) }} COURSES</strong>
                                        <p><strong>{{ strtoupper($schoolyear->school_year) }} School Year</strong></p>
                                    </h4>
                                </div>
                                <p class="category"> <i class="fa fa-circle text-danger"></i> <strong>My Assigned Class:</strong> 
                                    {{ @\App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', '=', $teacher->id)->first()->group->name }}
                                </p>
                            </div>

                            <div class="content">
                                <table id="gradingSetupCourses" class="table table-striped text-center">
                                    <thead>
                                        <th class="text-center"><strong>Course Code</strong></th>
                                        <th class="text-center danger"><strong>Course Name</strong></th>
                                        @if($schoolyear->id == $current_school_year->id && $term->id == $current_term->id)
                                            <th class="text-center"><strong>Setup Grading</strong></th>
                                        @else
                                            <th class="text-center"><strong>View Grades</strong></th>
                                        @endif
                                    </thead>
                                    <tbody>
                                    @foreach ($term_courses->where('group_id', '=', @\App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', '=', $teacher->id)->first()->group_id) as $course)

                                        <tr>
                                            
                                            <td>{{ $course->course_code }}</td>
                                            <td class="danger">{{ $course->name }}</td>
                                            @if($schoolyear->id == $current_school_year->id && $term->id == $current_term->id)
                                                <td>
                                                    <strong>
                                                        <a href="{{asset('/admin/gradingsetup/categories/'.$schoolyear->id) }}/{{$term->id}}/{{$course->id}}"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>&nbsp;&nbsp;Setup Grading</a>
                                                    </strong>
                                                </td>
                                            @else

                                                <td>
                                                    <strong>
                                                        <a href="{{asset('/showstudentcoursesgrades/'.Crypt::encrypt($course->id)) }}/{{$schoolyear->id}}/{{$term->id}}"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>&nbsp;&nbsp;View Grades</a>
                                                    </strong>
                                                </td> 
                                            @endif
                                           
                                        </tr>
                                    @endforeach
                                        
                                    </tbody>
                                </table>

                                <!-- DataTable js starts -->
                                <script type="text/javascript">
                                  $(document).ready(function() {
                                    $('#gradingSetupCourses').DataTable();
                                } );
                                </script>
                                <!-- DataTable js ends -->

                                <div class="footer">
                                   
                                    <hr>
                                    
                                    <div class="stats">
                                        <i class="ti-timer"></i> These course are for the class you are responsible for this term. You can add/edit or delect students grades.
                                    </div>
                                    
                                </div>
                            </div>
                        
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <div class="alert alert-danger">
                                    <h4 class="title">
                                        <strong>Setup Grading For {{ strtoupper($term->term) }} COURSES</strong>
                                        <p><strong>{{ strtoupper($schoolyear->school_year) }} School Year</strong></p>
                                    </h4>
                                </div>
                                <p class="category"> <i class="fa fa-circle text-danger"></i> <strong>Courses Am Teaching This Term:</strong> 
                                    {{ $term->term }}
                                </p>
                            </div>

                            <div class="content">
                                <table id="gradingSetupCoursesTeaching" class="table table-striped text-center">
                                        <thead>
                                            <th class="text-center"><strong>Course Code</strong></th>
                                            <th class="text-center success"><strong>Course Name</strong></th>
                                            <th class="text-center success"><strong>Class Name</strong></th>
                                            @if($schoolyear->id == $current_school_year->id && $term->id == $current_term->id)
                                                <th class="text-center"><strong>Setup Grading</strong></th>
                                            @else
                                                <th class="text-center"><strong>View Grades</strong></th>
                                            @endif

                                        </thead>
                                        <tbody>
                                            @foreach($term_courses->where('staffer_id', '=', @\App\StafferRegistration::where('school_year_id', '=', $schoolyear->id)->where('term_id', '=', $term->id)->where('staffer_id', $teacher->id)->first()->staffer_id) as $course)

                                            <tr>
                                                
                                                <td>{{ $course->course_code }}</td>
                                                <td class="success">{{ $course->name }}</td>
                                                <td class="success">{{$course->group->name}}</td>

                                                @if($schoolyear->id == $current_school_year->id && $term->id == $current_term->id)
                                                <td>
                                                    <strong>
                                                        <a href="{{asset('/admin/gradingsetup/categories/'.$schoolyear->id) }}/{{$term->id}}/{{$course->id}}"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>&nbsp;&nbsp;Setup Grading</a>
                                                    </strong>
                                                </td>
                                                @else

                                                <td>
                                                    <strong>
                                                        <a href="{{asset('/showstudentcoursesgrades/'.Crypt::encrypt($course->id)) }}/{{$schoolyear->id}}/{{$term->id}}"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>&nbsp;&nbsp;View Grades</a>
                                                    </strong>
                                                </td> 
                                                @endif 
                                               
                                            </tr>
                                            
                                         @endforeach
                                            
                                        </tbody>
                                    </table>

                                    <!-- DataTable js starts -->
                                    <script type="text/javascript">
                                      $(document).ready(function() {
                                        $('#gradingSetupCoursesTeaching').DataTable();
                                    } );
                                    </script>
                                    <!-- DataTable js ends -->
                                <div class="footer">
                                   
                                    <hr>
                                    
                                    <div class="stats">
                                        <i class="ti-timer"></i> These course are for the class you are responsible for this term. You can add/edit or delect students grades.
                                    </div>
                                    
                                </div>
                            </div>
                        
                        </div>
                    </div>

                </div>
            </div>
        </div>

       
@endsection
