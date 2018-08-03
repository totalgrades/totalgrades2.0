@extends('admin.superadmin.dashboard')

@section('content')
    <div class="page-header">
        <h1>
           Setup Gradebook Activities
         
            @include('flash::message')
                                            
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
    <div class="col-md-6 col-sm-6">
        <a class="btn btn-primary" href="{{asset('/schoolsetup/gradebookActivities/addActivity') }}" role="button">Add New Activity</a>
    </div>
</div>
    <div class="row">
        <div class="col-sm-6">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title"> <strong style="color:darkred;">Showing <mark>{{ $current_school_year->school_year}}</mark>Activities and Maximum Points Allowed</strong></h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                       <table class="table table-striped table-bordered">
                            <thead>
                                <th>ID #</th>
                                <th>Activity Name</th>
                                <th>Max Points Allowed(%)</th>
                                <th>Edit</th>
                                <th>Delete</th>

                            </thead>
                            <tbody>
                                @foreach ($grade_activities as $key => $grade_activity)

                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $grade_activity->activity_name }}</td>
                                    <td>{{ $grade_activity->max_point }} <span>&#37;</span></td>
                                    <td><strong><a href="{{asset('/schoolsetup/gradebookActivities/editActivity/'.$grade_activity->id) }}"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a></strong>
                                    </td>
                                    <td><strong><a href="{{asset('/schoolsetup/gradebookActivities/deleteActivity/'.$grade_activity->id) }}" onclick="return confirm('Are you sure you want to Delete this record?')"><i class="danger fa fa-trash-o fa-2x" aria-hidden="true" style="color:red"></i></a></strong>
                                    </td>
                                   
                                </tr>
                             @endforeach
                                
                            </tbody>
                        </table>
                        @if($grade_activities->where('school_year_id', $current_school_year->id)->sum('max_point') < 100 )
                            <button type="button" class="btn btn-danger"><strong>Total Points: {{ $grade_activities->where('school_year_id', $current_school_year->id)->sum('max_point') }} <span>&#37;</span></strong> <mark>must be equal to 100 <span>&#37;</span></mark></button>
                        @elseif($grade_activities->where('school_year_id', $current_school_year->id)->sum('max_point') == 100)
                            <button type="button" class="btn btn-success"><strong>Total Points: {{ $grade_activities->where('school_year_id', $current_school_year->id)->sum('max_point') }} <span>&#37;</span></strong></button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

	<div class="alert-danger">
		
		<ul>
			@foreach($errors->all() as $error)

				<li> {{ $error }}</li>

			@endforeach

		</ul>

	</div>


@endsection
