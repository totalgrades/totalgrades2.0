<!-- Modal -->
<div class="modal fade" id="showGradeActivityCategoryModal-{{$activitycategory->id}}" role="dialog">
  <div class="modal-dialog modal-lg">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editing Category: <span style="color: red;">{{$activitycategory->grade_activity_category_name}}</span></h4>
      </div>
      <div class="modal-body">

        
            <div class="content">

                <div class="row">
          
                                           
                    <div class="card">
                       <div class="content">
                           <form class="form-group" action="{{ url('/admin/gradingsetup/editGradeActivityCategory/'.$activitycategory->id) }}" method="POST">
                           {{ csrf_field() }}
                             <input type="hidden" name="course_id" value="{{$course->id}}">
                                <div class="form-row">
                               
                                   <div class="form-group col-md-6">
                                     <label for="grade_activity_category_name"><strong>Category Name</strong></label>
                                     <input type="text" class="form-control" id="grade_activity_category_name" name="grade_activity_category_name" value="{{$activitycategory->grade_activity_category_name}}" required="">
                                   </div>
                                   <div class="form-group col-md-6">
                                     <label for="grade_activity_category_weight"><strong>Maximum Point Achievable</strong></label>
                                     <input type="number" step=".01" class="form-control" id="grade_activity_category_weight" name="grade_activity_category_weight" value="{{$activitycategory->grade_activity_category_weight}}" required="">
                                   </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                       <label for="grade_activity_category_description"><strong>Short Description</strong></label>
                                       <input type="text" class="form-control" id="grade_activity_category_description" name="grade_activity_category_description" value="{{$activitycategory->grade_activity_category_description}}" required="">
                                    </div>                                
                                </div>
                                <div class="form-row">
                                    <button type="submit" class="btn btn-success">Update Category</button>
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