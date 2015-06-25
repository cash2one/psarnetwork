<!doctype html>
<html lang="en">
<head>
<title>@yield('title')</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
{{HTML::style('frontend/css/font-awesome.min.css')}}
{{HTML::style('frontend/css/prettyPhoto.css')}}
{{HTML::style('frontend/css/price-range.css')}}
{{HTML::style('frontend/css/animate.css')}}
{{HTML::style('frontend/css/bootstrap.min.css')}}
{{HTML::style('frontend/css/responsive.css')}}
{{HTML::style('frontend/css/main.css')}}
{{HTML::style('frontend/css/layout.css')}}
{{HTML::script('frontend/js/jquery.js')}}
{{HTML::script('frontend/js/popupdetails.js')}}
<!--[if lt IE 9]>
                {{HTML::script('frontend/js/html5shiv.js')}}
                {{HTML::script('frontend/js/respond.min.js')}}
            <![endif]-->
<link rel="shortcut icon"
	href="{{Config::get('app.url')}}frontend/images/icons/favicon.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144"
	href="{{Config::get('app.url')}}frontend/images/icons/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114"
	href="{{Config::get('app.url')}}frontend/images/icons/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72"
	href="{{Config::get('app.url')}}frontend/images/icons/apple-touch-icon-72-precomposed.png">
</head>
<body>
	<!-- Call facebook script -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<!-- End facebook calling -->
	<header id="header" class="mainHeader">
		<!--=====Start Header]==============-->
		<div class="header_top">
			<!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li class="user-home"><a href="{{Config::get('app.url')}}"
									taget="_blank">www.khmerabba.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-9">
						<div class="social-icons pull-right ">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa">Contact us</i></a></li>
								<li><a href="#"><i class="fa">About us</i></a></li>
								<li><a href="#"><i class="fa">User Agreement</i></a></li>
								<li><a href="#"><i class="fa">Policy</i></a></li>
								<li><a href="#"><i class="fa">Usage</i></a></li>
                                @if(!Session::get('currentUserId'))
								<li><a href="{{Config::get('app.url')}}/member/login"><i
										class="fa">Sign in /</i></a></li>
								<li><a href="{{Config::get('app.url')}}/member/register"><i
										class="fa">Free Register</i></a></li>
                                @else
                                <li role="presentation" class="dropdown">
										<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
										My Account <span class="caret"></span>
										</a>
										<ul class="dropdown-menu" role="menu">
											<li>
            									<a href="{{URL::to('member/userinfo/infomation')}}">View Profile info</a>
            								</li>
            								<li>
            									<a href="{{URL::to('member/userinfo/summary')}}">Your Status</a>
            								</li>
                                            <li>
        										<a href="{{URL::to('member/userinfo/infomation?pw=1#password')}}">Chage Password</i></a>
        									</li>
                                            <li>
        										<a href="{{URL::to('member/logout')}}"><i class="glyphicon glyphicon-off"> Log out</i></a>
        									</li>
										</ul>
									</li>
                                @endif
							</ul>
							<div class="language-bar">
								<a href="{{URL::current()}}?lang=en"> <img
									src="{{Config::get('app.url')}}/frontend/images/en.png" alt=""
									title="" /> English
								</a> <a href="{{URL::current()}}?lang=km"> <img
									src="{{Config::get('app.url')}}/frontend/images/km.png" alt=""
									title="" /> Khmer
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container-fluid top-menu">
			<div class="col-lg-12 top_promotion">
				<div class="col-lg-2">
					<a href="{{Config::get('app.url')}}"><img
						src="{{Config::get('app.url')}}frontend/images/khmerabba_logo.png"
						width="200" />
					<a>
				</div>
				<div class="col-lg-10">
						<div class="col-lg-12" id="form-search">
					{{
						Form::open(
							array(
								'url'=>'search',
								'method'=>'get'
							)
						)
					}}
					<div class="col-lg-6 search-bar">
						<div class="col-lg-8 pull-right" style="padding: 0; margin: 0;">
							<div class="col-lg-3 pull-right" style="padding: 0; margin: 0;">
								<button type="submit"
									class="btn btn-warning pull-right col-lg-12"
									style="border-radius: 0;">
									<span class="glyphicon glyphicon-search"></span> Search
								</button>
							</div>
							<div class="col-lg-9" style="padding: 0; margin: 0;">
								<input type="text" name="q" class="form-control" placeholder="Search here"
									style="border-radius: 0; border: none; border-left: 1px solid #ddd;" />
							</div>
						</div>
						<div class="col-lg-4" style="margin: 0; padding: 0;">
							<div class="col-lg-6 pull-right" style="margin: 0; padding: 0;">
								<div class="btn-group col-lg-12" style="padding: 0; margin: 0;">
									<select name="location">
										<option value="0">Location</option>
										@foreach($locations as $location)
											<option value="{{$location->province_id}}">{{$location->province_name}}</option>
										@endforeach;
									</select>
								</div>
							</div>
	
							<div class="col-lg-6" style="margin: 0; padding: 0;">
								<div class="btn-group col-lg-12 " style="margin: 0; padding: 0;">
									<select name="type">
										<option value="0">Type</option>
										<option value="1">Products</option>
										<option value="2">Buyers</option>
										<option value="3">Suppliers</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					{{Form::close()}}
				</div>
					<!--<ul class="promotion_top_menu pull-right">
						<li><a
								href="{{Config::get('app.url')}}product/list/10">Hot
								Promotion</a></li>
						<li><a
							href="{{Config::get('app.url')}}product/list/10">New
								Arrival</a></li>
						<li><a
							href="{{Config::get('app.url')}}product/list/10">Second
								Hand</a></li>
						<li><a
							href="{{Config::get('app.url')}}product/list/10">Buy</a></li>
						<li><a
							href="{{Config::get('app.url')}}product/list/10">Sell</a></li>
						<li><a
							href="{{Config::get('app.url')}}product/list/10">Monthly
								Pay</a></li>
					</ul>-->
				</div>
			</div>
			<!--<div class="col-lg-6 navbar navbar-default topmenu-container"
				role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse"
						data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span> <span
							class="icon-bar"></span> <span class="icon-bar"></span> <span
							class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse promotion-list">
					<ul class="nav navbar-nav top_menu_list">
						<li><a href="{{Config::get('app.url')}}product/list/10">Super Market</a></li>
						<li><a href="{{Config::get('app.url')}}product/list/10">Traditional
								Market</a></li>
						<li><a href="{{Config::get('app.url')}}product/list/10">Private
								Company</a></li>
						<li><a href="{{Config::get('app.url')}}product/list/10">Home Shop</a></li>
						<li><a href="{{Config::get('app.url')}}product/list/10">Individual</a></li>
						<li class="facebook-like">
							<div class="fb-like" data-href="https://www.facebook.com/khmerabba?ref=hl" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
						</li>
					</ul>
				</div>
				<!--/.nav-collaps
			</div>-->
		</div>
	</header>
		<!--for mesage alert -->
		<div class="message-alert alert alert-warning" data-time="3000"
			style="display: none;">
			<strong>Warning!</strong> Better check yourself, you're not looking
			too good.
		</div>
		<div class="message-alert alert alert-warning message-loading"
			data-time="5000" style="display: none;">
			<img
				src="{{Config::get('app.url')}}frontend/images/upload_progress.gif"
				alt="loading...." /> Loading...
		</div>
		<div class="message-alert alert alert-success" data-time="3000"
			style="display: none;">
			<strong>Well done!</strong> You successfully read this important
			alert message.
		</div>
		<div class="message-alert alert alert-success message-success"
			data-time="3000" style="display: none;">
			<strong>Updated...</strong>
		</div>
		<div class="message-alert alert alert-info" data-time="3000"
			style="display: none;">
			<strong>Heads up!</strong> This alert needs your attention, but it's
			not super important.
		</div>
		<div class="message-alert alert alert-danger" data-time="3000"
			style="display: none;">
			<strong>Oh snap!</strong> Change a few things up and try submitting
			again.
		</div>