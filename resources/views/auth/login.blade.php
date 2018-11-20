@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Students & Parents Login</strong></div>
                <div class="panel-body">
                <div class="row">
                
                <div class="col-md-3" >
                    <div class="logo text-center">
                    <a href="https://socidy.com/" class="simple-text">
                        <img src="{{asset('/assets/img/logo/logo.jpg')}}" style="width: 130px; height: 130px; border-radius: 50%; margin-left: 1%; ">
                    </a>
                    <div class="text-center" style="color: #3097d1;"> <strong>An Free Online Gradebook Project<br> for Primary & Secondary Schools</strong> </div>
                   </div>
                    
                </div>
                <div class="col-md-9" style="border-left: 1px solid #ccc;">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                  </div>
                </div>
                </div>
            </div>
            <footer style="font-size: 11px;">
                <!-- Container -->
                <div class="text-center">
                    <!-- Footer Content -->
                        <!-- Paragraph -->
                        <p style="margin: 0;"> <strong>Copyright &copy; <a href="https://totalgrades.com">Totalgrades</a> 2017 - 2018 (v1.0)</p>
                        <p style="margin: 0;"><strong>ALberta T0L0T0, Canada</strong></p>
                        <p style="margin: 0;"><strong>Email: <a href="mailto:totalgrades@gmail.com"> totalgrades@gmail.com </a></a>
                        <p style="margin: 0;"><strong>Phone: +14034022387</strong></p>
    
                        <!-- Clearfix -->
                        <div class="clearfix"></div>
                </div>
            </footer>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-warning">
                  <div class="panel-heading" style="background-color: #3097d1; color: #FFFFFF"><strong>Demo Students: Login Deatils</strong></div>
                  <div class="panel-body">
                     <table class="table table-hover">
                         <thead>
                           <tr>
                             <th><strong>Email</strong></th>
                             <th><strong>Password</strong></th>
                           </tr>
                         </thead>
                         <tbody>
                           <tr>
                             <td><strong>studentone@gmail.com</strong></td>
                             <td><strong>123456</strong></td>
                             
                           </tr>
                           <tr>
                             <td><strong>studentsix@gmail.com</strong></td>
                             <td><strong>123456</strong></td>
                             
                           </tr>
                           <tr>
                             <td><strong>studenteleven@gmail.com</strong></td>
                             <td><strong>123456</strong></td>
                             
                           </tr>
                           <tr>
                             <td><strong>studentsixteen@gmail.com</strong></td>
                             <td><strong>123456</strong></td>
                             
                           </tr>
                         </tbody>
                       </table>
                  </div>
                </div>
        </div>
    </div>
</div>
@endsection
