<!doctype html>
<html lang="en">
	<head>
		<title>
			@yield('title')
		</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		{{HTML::style('frontend/css/font-awesome.min.css')}} {{HTML::style('frontend/css/prettyPhoto.css')}} {{HTML::style('frontend/css/price-range.css')}} {{HTML::style('frontend/css/animate.css')}} {{HTML::style('frontend/css/bootstrap.min.css')}}
		{{HTML::style('frontend/css/responsive.css')}} {{HTML::style('frontend/css/main.css', array('class' => 'main-stylesheet'))}} {{HTML::style('frontend/css/member/member.css')}} {{HTML::style('frontend/css/layout.css')}}
		{{HTML::script('frontend/js/jquery.js')}}
		<!--[if lt IE 9]>
			{{HTML::script('frontend/js/html5shiv.js')}} {{HTML::script('frontend/js/respond.min.js')}}
		<![endif]-->
		<link rel="shortcut icon" href="{{Config::get('app.url')}}/frontend/images/ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{Config::get('app.url')}}/frontend/images/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{Config::get('app.url')}}/frontend/images/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{Config::get('app.url')}}/frontend/images/ico/apple-touch-icon-72-precomposed.png">
	</head>
	<body>
		<header id="header">
			<!--=====Start Header]==============-->
			<div class="header_top">
				<!--header_top-->
				<div class="container">
					<div class="row">
						<div class="col-sm-3">
							<div class="contactinfo">
								<ul class="nav nav-pills">
									<li>
										<a href="{{Config::get('app.url')}}" taget="_blank">www.psarkhmer.com</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-sm-9">
							<div class="social-icons pull-right ">
								<ul class="nav navbar-nav">
									@if(Session::get('currentUserId'))
									<li>
										<a href="#">Add New Products</a>
									</li>
									<li>
										<a href="#">Product Management</a>
									</li>
									<li>
										<a href="#">Enterprise Tool</a>
									</li>
									<li>
										<a href="#">Setting</a>
									</li>
									<li>
										<a href="#">My Account</a>
									</li>
									<li role="presentation" class="dropdown">
										<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
										My Account <span class="caret"></span>
										</a>
										<ul class="dropdown-menu" role="menu">
											<li>
        										<a href="#">View Profile info</i></a>
        									</li>
                                            <li>
        										<a href="#">Your Status</i></a>
        									</li>
                                            <li>
        										<a href="#">Chage Password</i></a>
        									</li>
                                            <li>
        										<a href="{{URL::to('logout')}}"><i class="glyphicon glyphicon-off"> Log out</i></a>
        									</li>
										</ul>
									</li>
									@else
									<li>
										<a href="#"><i class="fa">Contact us</i></a>
									</li>
									<li>
										<a href="#"><i class="fa">About us</i></a>
									</li>
									<li>
										<a href="#"><i class="fa">User Agreement</i></a>
									</li>
									<li>
										<a href="#"><i class="fa">Policy</i></a>
									</li>
									<li>
										<a href="#"><i class="fa">Usage</i></a>
									</li>
									<li>
										<a href="{{Config::get('app.url')}}/member/login"><i class="fa">Sign in /</i></a>
									</li>
									<li>
										<a href="{{Config::get('app.url')}}/member/register"><i class="fa">Free Register</i></a>
									</li>
									@endif
								</ul>
								<div class="language-bar">
									<a href="{{Config::get('app.url')}}?lang=en">
									<img src="{{Config::get('app.url')}}/frontend/images/en.png" alt="" title="" />
									English
									</a>
									<a href="{{Config::get('app.url')}}?lang=km">
									<img src="{{Config::get('app.url')}}/frontend/images/km.png" alt="" title="" />
									Khmer
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--============End header top here==============-->
			<!--for mesage alert -->
			<div class="message-alert alert alert-warning" data-time="3000" style="display: none;">
				<strong>
					Warning!
				</strong>
				Better check yourself, you're not looking too good.
			</div>
			<div class="message-alert alert alert-warning message-loading" data-time="5000" style="display: none;">
				<img src="{{Config::get('app.url')}}frontend/images/upload_progress.gif" alt="loading...."/>
				Loading...
			</div>
			<div class="message-alert alert alert-success" data-time="3000" style="display: none;">
				<strong>
					Well done!
				</strong>
				You successfully read this important alert message.
			</div>
			<div class="message-alert alert alert-success message-success" data-time="3000" style="display: none;">
				<strong>
					Updated...
				</strong>
			</div>
			<div class="message-alert alert alert-info" data-time="3000" style="display: none;">
				<strong>
					Heads up!
				</strong>
				This alert needs your attention, but it's not super important.
			</div>
			<div class="message-alert alert alert-danger" data-time="3000" style="display: none;">
				<strong>
					Oh snap!
				</strong>
				Change a few things up and try submitting again.
			</div>