<!-- Modal -->
<div class="modal fade" id="selectAnotherCategoryModal-{{$course->id}}" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{$course->name}}-{{$course->course_code}}:Please select a category</h4>
      </div>
        <div class="modal-body">
                                
            <ul class="list-group">
            @foreach($activity_categories as $key=>$activity_category)

                
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong><a href="{{ url('/admin/gradingsetup/showgradeactivities/'.$activity_category->id) }}/{{$schoolyear->id}}/{{$term->id}}/{{$course->id}}">{{$activity_category->grade_activity_category_name}}({{$grade_activities_modal->where('grade_activity_category_id', $activity_category->id)->count()}} Activities)</a></strong>
                    <span class="badge badge-primary badge-pill">Weight: {{$activity_category->grade_activity_category_weight}}%</span>
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