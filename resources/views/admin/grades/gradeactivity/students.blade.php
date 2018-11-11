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
    rotate(315deg);
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
                    <a class="btn btn-danger pull-right" href="{{asset('/admincourses/'.$schoolyear->id) }}/{{$term->id}}" role="button">Back to Courses</a>
                  </div>
                  

                  <div class="col-md-12">

                        <div class="card">
                            
                            <div class="header">
                                <div class="alert alert-success">
                                    <h4 class="title">
                                        {{$course->name}}({{$course->course_code}}%)
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
                          <table class="table table-hover">
                            <thead>
                              <tr >
                                  <th  class="text-center" style="font-size: 15px"><strong>#</strong></th>
                                  <th  class="text-center" style="font-size: 15px"><strong>Face</strong></th>
                                  <th  class="text-center" style="font-size: 15px"><strong>Last Name</strong></th>

                                  @foreach($grade_activities as $key=>$grade_activity)

                                    <th class="rotate" style="padding-left: 8%;">
                                      <div>
                                        <span style="font-size: 15px">
                                          <strong>{{$grade_activity->grade_activity_name}}-({{$grade_activity->grade_activity_weight}}%)</strong><br>
                                          @foreach($grade_activity_categories as $key=>$grade_activity_category)
                                            @if($grade_activity->grade_activity_category_id == $grade_activity_category->id)
                                              {{$grade_activity_category->grade_activity_category_name}}
                                            @endif
                                          @endforeach
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

                                              @if ($st_user->registration_code ==  $reg_students->student->registration_code)                         

                                              <img class="avatar border-white" src="{{asset('/assets/img/students/'.$st_user->avatar) }}" alt="..."/>
                                              <button type="button" class="btn btn-sm"><strong><span style="font-size: 20px; color: #EB5E28;"></span></strong></button>
                                               

                                             @endif
                                              
                                          @endforeach
                                        </td>

                                        <td class="text-center">{{$reg_students->student->last_name}} {{$reg_students->student->first_name}}</td>

                                       
                                        
                                      
                                      
                                        
                                       
                                       
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
