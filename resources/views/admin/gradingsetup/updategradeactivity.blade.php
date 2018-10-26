<!-- Modal -->
<div class="modal fade" id="showGradeActivityModal-{{$grade_activity->id}}" role="dialog">
  <div class="modal-dialog modal-lg">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editing Grade Activity</h4>
      </div>
      <div class="modal-body">

        
            <div class="content">

                <div class="row">
          
                                           
                    <div class="card">
                       <div class="content">
                           <form class="form-group" action="{{ url('/admin/gradingsetup/editGradeActivity/'.$grade_activity->id) }}" method="POST">
                           {{ csrf_field() }}
                                <div class="form-row">
                               
                                   <div class="form-group col-md-6">
                                     <label for="grade_activity_name"><strong>Activity Name</strong></label>
                                     <input type="text" class="form-control" id="grade_activity_name" name="grade_activity_name" value="{{$grade_activity->grade_activity_name}}" required="">
                                   </div>
                                   <div class="form-group col-md-6">
                                     <label for="max_point"><strong>Maximum Point Achievable</strong></label>
                                     <input type="number" step=".01" class="form-control" id="max_point" name="max_point" value="{{$grade_activity->max_point}}" required="">
                                   </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                       <label for="grade_activity_description"><strong>Short Description</strong></label>
                                       <input type="text" class="form-control" id="grade_activity_description" name="grade_activity_description" value="{{$grade_activity->grade_activity_description}}" required="">
                                    </div>                                
                                </div>
                                <div class="form-row">
                                    <button type="submit" class="btn btn-success">Update Activity</button>
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