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
                        <div class="card">
                            <div class="header">
                              
                                 
                              
                                
                            </div>
                            
                        <div class="content">
                        <div class="table-responsive">
                          <table class="table table-bordered table-hover" style="font-size: 12px;">
                            <thead>
                                <tr>
	                                <th  class="text-center">Table</th>
	                                <th  class="text-center">Face</th>
	                                <th  class="text-center">Last Name</th>
	                                <th  class="text-center">Course</th>
	                                <th  class="text-center">Activity Name</th>
	                                <th  class="text-center">Max Point</th>
	                                <th  class="text-center">Student's Point</th>
	                                @if($schoolyear->id == $current_school_year->id && $term->id == $current_term->id)
	                                    <th colspan="3" class="text-center">Action</th>
	                                @endif
                              </tr>
                          </thead>
                            <tbody>

                            
                           
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
