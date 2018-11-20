@extends('homepublic.layouts.app')

@section('content')			
			

			<!-- page-top start-->
			<!-- ================ -->
			<div class="page-top object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="100">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h1 class="text-center title">TotalGrades2.0 (New and Improved Features!)</h1>
							<h3 class="text-center title"> <mark style="background-color: #FF5733;">Use Totalgrades2.0 for free! No commitment! <a href="https://totalgrades.com/schoolRegistrationForm"> <mark>Just Register</mark></a> and your portal will be up and running in no time</mark></h3>
							<h3 class="text-center title"> You can also check out the demo server. click on a login option below to get started.</h3>
							<div class="separator"></div>
							<p class="text-center">Simple, Smart, and Affordable.</p>
							<div class="text-center">
								<a href="{{url('login')}}" class="btn radius btn-primary btn-lg">Students-Login(Demo) <i class="fa fa-user"></i></a>
								<a href="{{url('admin_login')}}" class="btn radius btn-danger btn-lg">Teachers-Login(Demo) <i class="fa fa-user-plus"></i></a>
							</div>
							<div class="row grid-space-20">
								<div class="col-sm-12 col-md-4 col-md-push-4">
									<img src="{{asset('assets-homepublic/images/report_card_totalgrades.png')}}" alt="" class="object-non-visible" data-animation-effect="fadeInUp" data-effect-delay="0">
								</div>
								<div class="col-sm-6 col-md-4 col-md-pull-4">
									<div class="box-style-3 right object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="0">
										<div class="icon-container default-bg">
											<i class="fa fa-tablet"></i>
										</div>
										<div class="body">
											<h2>Easy to Use on Any Device</h2>
											<p>Use Total Grades Anywhere, Anytime-on your desktop, laptop, ipad, or phone...It is designed with students and their parents in mind.</p>
											
										</div>
									</div>
									<div class="box-style-3 right object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="0">
										<div class="icon-container default-bg">
											<i class="fa fa-line-chart"></i>
										</div>
										<div class="body">
											<h2>Student grades and Statistics</h2>
											<p>Easy to understand grades and class statistics.</p>
											
										</div>
									</div>
									
									<div class="box-style-3 right object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="400">
										<div class="icon-container default-bg">
											<i class="fa fa-money"></i>
										</div>
										<div class="body">
											<h2>Affordable</h2>
											<p>Total Grades is affordable no matter how many students you have. </p>
											
										</div>
									</div>

									<div class="box-style-3 right object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="400">
										<div class="icon-container default-bg">
											<i class="fa fa-user-plus"></i>
										</div>
										<div class="body">
											<h2>Student Registration and Biodata</h2>
											<p>Register your students and safely store and access student registration anytime. </p>
											
										</div>
									</div>
								</div>
								<div class="col-sm-6 col-md-4">
									<div class="box-style-3 object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="400">
										<div class="icon-container default-bg">
											<i class="fa fa-check"></i>
										</div>
										<div class="body">
											<h2>Course Grades Activities</h2>
											<p>Teachers can now set up grade activities for each course they are teaching. </p>
											
										</div>
									</div>
									<div class="box-style-3 object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="200">
										<div class="icon-container default-bg">
											<i class="fa fa-shield"></i>
										</div>
										<div class="body">
											<h2>Security</h2>
											<p>Secured using some of the latest web technologies around.Data Encryption, SSL, and Cross-site request forgeries protection.</p>
											
										</div>
									</div>
									
									<div class="box-style-3 object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="200">
										<div class="icon-container default-bg">
											<i class="fa fa-list"></i>
										</div>
										<div class="body">
											<h2>Report Card</h2>
											<p>Your students deserve beautifully designed report card.</p>
											
										</div>
									</div>
									<div class="box-style-3 object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="400">
										<div class="icon-container default-bg">
											<i class="fa fa-calendar"></i>
										</div>
										<div class="body">
											<h2>Attendance Records</h2>
											<p>Daily attendance record and attendance history.</p>
											
										</div>
									</div>

									
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- page-top end -->


@endsection