
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Ktown Rooms | Login</title>
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
	<!-- <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"> -->
	<link href="{{assets(css/bootstrap.min.css)}}" rel="stylesheet" type="text/css">
	
	<link href="{{asset('assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{asset('global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/ui/ripple.min.js')}}"></script>
	<script src="https://kit.fontawesome.com/ff383a412e.js" crossorigin="anonymous"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

	<script src="assets/js/app.js"></script>
	<script src="{{asset('global_assets/js/demo_pages/login.js')}}"></script>
	<!-- /theme JS files -->

	<style>
	.field-icon {
	float: right;
	margin-left: -25px;
	margin-top: -25px;
	position: relative;
	z-index: 2;
	}

	.container{
	padding-top:50px;
	margin: auto;
	}
	.bg-slate-800 {
    background-color: #37474f;
    background-image: url(https://www.ktownrooms.com/resources/assets/web/img/abt-slide-img.jpg);
    background-repeat: no-repeat;
    background-size: cover;
}
.toaster {
    background: #fde1df;
    color: #7f231c;
    width: 90%;
    box-shadow: 0 0 7px 0px #fde1df;
    margin: 22px auto;
}
.eror p {
    margin: 0;
}
.eror {
    text-align: left;
    padding: 10px;
}
	</style>
</head>

<body class="bg-slate-800">

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">
       

			<!-- Content area -->
			<div class="content ">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-3">
											<img src="https://www.ktownrooms.com/resources/assets/web/img/logo.png" alt="" srcset="">
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 10%;">
				<div class="col-md-6" style="text-align: right">
					
					<h1 style="font-size: 45px;line-height: 55px;font-weight: 800;">Come to <span style="color: #ea863b;">Ktown Rooms</span><br> & Experience Hospitality Beyond Borders!</h1>
					<h3 style="font-weight: 400;">Affordability. Standardization. Predictability. Classification.</h3>
				</div>
				<div class="col-md-4">
						<!-- Login card -->
						 {{-- <div class="card"> --}}
							
							<form class="login-form" action="{{url('login')}}" method="POST" style="float: right;">
								{{ csrf_field() }}
									<div class="card mb-0">
										@if ($errors->any())
										<div class="toaster">
											<div class="eror">
												@foreach ($errors->all() as $error)
												<p>{{ $error }}</p>
												@endforeach
												
											</div>
										</div>
										@endif
										<div class="card-body">
											<div class="text-center mb-3">
												<div class="toaster">
													<div class="box"></div>
												</div>
												<h2 class="mb-0">LOGIN</h2>
											</div>
											
											<div class="floating-label"> 
												{{-- <input ng-model="searchID" type="text" class="form-control" placeholder=" "> --}}
												<input name="email" type="email" class="form-control" placeholder=" ">
												<span class="highlight"></span>
												<label>Email</label>
											</div>

											<div class="floating-label"> 
												{{-- <input ng-model="searchID" type="text" class="form-control" placeholder=" "> --}}
												<input id="password-field" name="password" type="password" class="form-control" placeholder=" ">
												<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password" style="right:5px"></span>
												<span class="highlight"></span>
												<label>Password</label>
											</div>

											

											{{-- <div class="form-group form-group-feedback form-group-feedback-left">
												<input name="email" type="email" class="form-control" placeholder="Email">
												<div class="form-control-feedback" style="left:2px">
													<i class="fas fa-envelope text-muted"></i>
												</div>
											</div> --}}
				
											{{-- <div class="form-group form-group-feedback form-group-feedback-left">
												<input id="password-field" name="password" type="password" class="form-control" placeholder="Password">
												<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password" style="right:5px"></span>
												<div class="form-control-feedback" style="left:2px">
													<i class="icon-lock2 text-muted"></i>
												</div>
											</div> --}}
				
											<div class="form-group d-flex align-items-center">
												<div class="form-check mb-0">
													<label class="form-check-label">
														<input type="checkbox" name="remember" class="form-input-styled" data-fouc>
														Remember
													</label>
												</div>
				
												<a href="password/reset" class="ml-auto">Forgot password?</a>
											</div>
				
											<div class="form-group">
												<button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 ml-2"></i></button>
											</div>
				
											<!-- <div class="form-group text-center text-muted content-divider">
												<span class="px-2">or sign in with</span>
											</div>
				
											<div class="form-group text-center">
												<button type="button" class="btn btn-outline bg-indigo border-indigo text-indigo btn-icon rounded-round border-2"><i class="icon-facebook"></i></button>
												<button type="button" class="btn btn-outline bg-pink-300 border-pink-300 text-pink-300 btn-icon rounded-round border-2 ml-2"><i class="icon-dribbble3"></i></button>
												<button type="button" class="btn btn-outline bg-slate-600 border-slate-600 text-slate-600 btn-icon rounded-round border-2 ml-2"><i class="icon-github"></i></button>
												<button type="button" class="btn btn-outline bg-info border-info text-info btn-icon rounded-round border-2 ml-2"><i class="icon-twitter"></i></button>
											</div>
				
											<div class="form-group text-center text-muted content-divider">
												<span class="px-2">Don't have an account?</span>
											</div>
				
											<div class="form-group">
												<a href="#" class="btn btn-light btn-block">Sign up</a>
											</div> -->
				
											<span class="form-text text-center text-muted">By continuing, you're confirming that you've read our <a href="https://www.ktownrooms.com/terms-conditions">Terms &amp; Conditions</a> and <a href="https://www.ktownrooms.com/web-privacy-policy">Privacy Policy</a></span>
										</div>
									</div>
							</form>
							<!-- /login card -->
						{{-- </div> --}}
				</div>
					

				</div>
			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
	<script>
	$(".toggle-password").click(function() {

	$(this).toggleClass("fa-eye fa-eye-slash");
	var input = $($(this).attr("toggle"));
	if (input.attr("type") == "password") {
	input.attr("type", "text");
	} else {
	input.attr("type", "password");
	}
	});
	</script>
</body>
</html>
