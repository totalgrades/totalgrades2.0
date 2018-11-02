<!-- Modal -->
<div class="modal fade" id="gradeActivitySelectionCourseModal-{{$gradeactivity->course->id}}" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Please select an activity to enter grades</h4>
      </div>
        <div class="modal-body">
                                
            <ul class="list-group">
            @foreach($grade_activities_course as $key=>$grade_activity_course)
              

                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong><a href="{{ url('grades/gradeactivity/students/'.$grade_activity_course->id) }}/{{$schoolyear->id}}/{{$term->id}}">{{$grade_activity_course->grade_activity_name}}-({{$grade_activity_course->course->course_code}})</a></strong>
                    <span class="badge badge-primary badge-pill">Max Point: {{$grade_activity_course->max_point}} %</span>
                  </li>

            @endforeach 
            </ul>
                  
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>