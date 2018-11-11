<!-- Modal -->
<div class="modal fade" id="showNewGradeActivityModal-{{$gradeactivitycategory->id}}" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color: #FF5733">{{$gradeactivitycategory->grade_activity_category_name}}(Total Weight: {{$gradeactivitycategory->grade_activity_category_weight}}%)</h4>
      </div>
      <div class="modal-body">

        
            <div class="content">

                <div class="row">
          
                                           
                    <div class="card">
                       <div class="content">
                            <form class="form-group" action="{{ url('/admin/gradingsetup/addNewGradeActivity/') }}" method="POST">
                              {{ csrf_field() }}

                                <input type="hidden" name="grade_activity_category_weight" value="{{ $gradeactivitycategory->grade_activity_category_weight }}"> 
                                

                                <input type="hidden" name="grade_activity_category_id" value="{{$gradeactivitycategory->id}}">  
                                <input type="hidden" name="school_year_id" value="{{$schoolyear->id}}">
                                <input type="hidden" name="term_id" value="{{$term->id}}">
                                <input type="hidden" name="group_id" value="{{$course->group_id}}">
                                <input type="hidden" name="course_id" value="{{$course->id}}">

                              
                                <div class="form-group col-md-12">

                                  <div class="form-group col-md-6">
                                    <label for="grade_activity_name"><strong>Activity Name</strong></label>
                                    <input type="text" class="form-control" id="grade_activity_name" name="grade_activity_name" placeholder="Activity name" required="">
                                  </div>
                                  
                                </div>

                                <div class="form-group col-md-12">
                                  <div class="form-group col-md-6">
                                      <label for="grade_activity_weight"><strong>Weight of this activity in this category</strong></label>
                                      <input type="number" step=".01" class="form-control" id="grade_activity_weight" name="grade_activity_weight" placeholder="Weight of this activity in this category" required="">
                                  </div>
                                </div>

                                <div class="form-group col-md-12">
                                  <div class="form-group col-md-12">
                                    <label for="grade_activity_description"><strong>Short Description</strong></label>
                                    <input type="text" class="form-control" id="grade_activity_description" name="grade_activity_description" placeholder="Short Description" required="">
                                  </div>
                                </div>                                
                               
                               <div class="form-row">
                                 <button type="submit" class="btn btn-success">Add Activity</button>
                                </div>
                              
                            
                            </form>
                       </div>
                       
                   </div>
              
                </div>
            </div>

        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>

