<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="{{ config('app.locale') }}">
<!--<![endif]-->

<head>

    <!--- basic page needs -->
    <meta charset="utf-8">
    <title>{{ isset($post) && $post->seo_title ? $post->seo_title : __(lcfirst('Title')) }}</title>
    <meta name="description" content="{{ isset($post) && $post->meta_description ? $post->meta_description : __('description') }}">
    <meta name="author" content="@lang(lcfirst ('Author'))"> @if(isset($post) && $post->meta_keywords)
    <meta name="keywords" content="{{ $post->meta_keywords }}"> @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- mobile specific metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main_test.css') }}"> @yield('css')


    <!-- script -->
    <script src="{{ asset('js/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery/jquery.mousewheel.min.js') }}"></script>
    <!-- <script src="https://cdn.anychart.com/releases/8.2.1/js/graphics.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll@14/dist/smooth-scroll.polyfills.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script> -->

    <script src="{{ asset('js/vendor/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/background.js') }}"></script>
    <!-- favicons -->
    <!-- <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon"> -->

</head>

<body>
    @if(session('confirmation-success'))
        <script>
            alert({!! session('confirmation-success') !!})
        </script>
        {{-- @component('front.components.alert')
        @slot('type') success
        @endslot
        {!! session('confirmation-success') !!}
    @endcomponent--}}
    @endif
    @if(session('confirmation-danger'))
        <script>
            alert({!! session('confirmation-danger') !!})
        </script>
        {{-- @component('front.components.alert')
        @slot('type') error

        @endslot
        {!! session('confirmation-danger') !!}
    @endcomponent--}}
    @endif
    <div id="background">
    </div>
    <div id="fancy_hack">
    </div>

    @guest
        <div id="log-in-out">
            <div id="log-in-out-container" class="container-login100">
                <div id="log-in-out-animate" class="wrap-login100">
                </div>
                {{-- _________________ --}}
            </div>
        </div>
    @endguest
    <div id="layout" class="content">

        <div id="main-content" class="col-xl-10">
            <header class="sticky-top">

                <nav class="navbar navbar-expand-md navbar-light bg-light ">
                    <a class="navbar-brand" href="#">PRO-MAN</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">

                            <li class="nav-item {{ currentRouteBootstrap('home') }}">
                                <a class="nav-link" href="{{ route('home') }}">Home </a>
                            </li>
                            <li class="nav-item row" style="width: 190px !important">
                                <div class="col-2 pure-menu-scrollable-direction border-gradient-right" id="navbar-dir-left">
                                    <i class="fas fa-angle-left"></i>

                                </div>
                                <div class="col-8 pure-menu pure-menu-horizontal pure-menu-scrollable">
                                    <ul class="pure-menu-list">
                                        <li class="pure-menu-item"><a href="#" class="nav-link">Wiki</a></li>
                                        <li class="pure-menu-item"><a href="#" class="nav-link">Documentation</a></li>
                                        <li class="pure-menu-item"><a href="#" class="nav-link">Forum</a></li>
                                        <li class="pure-menu-item"><a href="#" class="nav-link">FAQ</a></li>

                                    </ul>
                                </div>
                                <div class="col-2 pure-menu-scrollable-direction border-gradient-left" id="navbar-dir-right">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav mr-right">
                            @guest
                                <li class="nav-item">
                                    <button class="nav-link log-in-toggle" style="white-space: nowrap !important;">Log
                                        in</button>
                                </li>
                                {{--
                                <li {{ currentRoute( 'contacts.create') }}>
                                    <a href="{{ route('contacts.create') }}">@lang('Contact')</a>
                                </li> --}} @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin') }}">Admin</a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pro.display') }}">@lang('App')</a>
                                    </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}">@lang('Logout')</a>
                                </li>
                            @endguest{{-- @request('register')
                            <li class="nav-item">
                                <a href="{{ request()->url() }}">@lang('Register')</a>
                            </li>
                            @endrequest--}}
                            <li class="nav-item">

                                <form style="width: 100%; height: 100%; margin: auto">
                                    <div class="float-right-div" style="height: 100%;">
                                        <button style="height: 100%;" class="btn-search" id="btn-search-trigger" type="submit"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                    <div id="search-input-field" class="float-left-div" style="height: 100%; overflow: hidden;">
                                        <input id="focus-search-input" class="form-control" type="search" placeholder="Search..."
                                            aria-label="Search" style="width: 200px;">
                                    </div>
                                </form>
                            </li>
                        </ul>


                    </div>
                </nav>
            </header>
            <div class="row" style=" margin: 0; height: 100%;width: 100%; clear:both !important;">

                <div id="top-tags-section" class="col-md-3" style="height: auto;padding: 0;">
                    <div class="sticky-top" style="width: 100%; height: 300px;  top:56px; ">
                        <div class="text-center">

                            {{-- <p class="mb-0">
                                <h6 style="margin:auto;">Usefull links:</h6>
                            </p> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-6" style="height: 100%; padding: 0;">

                    @yield('main')
                </div>
                <div id="top-posts-section" class="col-md-3" style="height:  auto; padding: 0;">
                    <div class="sticky-top" style="width: 100%; height: 300px; top:56px;">
                        <div class="text-center">

                            {{-- <p class="mb-0">
                                <h6 style="margin:auto;">Top posts:</h6>
                            </p> --}}
                        </div>
                    </div>
                </div>





            </div>

        </div>
    </div>


    {{--

    <!-- <header class="short-header">

   	<div class="gradient-block"></div>

   	<div class="row header-content">

   		<div class="logo">
	    	<a href="{{ url('') }}">Author</a>
	    </div>

	   	<nav id="main-nav-wrap">
			<ul class="main-navigation sf-menu">
				<li {{ currentRoute('home') }}>
					<a href="{{ route('home') }}">@lang('Home')</a>
				</li>
				<li class="has-children">
					<a href="#">@lang('Categories')</a>
					<ul class="sub-menu">
@foreach($categories as $category)
							<li><a href="{{ route('category', [$category->slug ]) }}">{{ $category->title }}</a></li>
@endforeach
					</ul>
				</li>
@guest
					<li {{ currentRoute('contacts.create') }}>
						<a href="{{ route('contacts.create') }}">@lang('Contact')</a>
					</li>
@endguest
@request('register')
					<li class="current">
						<a href="{{ request()->url() }}">@lang('Register')</a>
					</li>
@endrequest
@request('password/email')
					<li class="current">
						<a href="{{ request()->url() }}">@lang('Forgotten password')</a>
					</li>
@else
@guest
						<li {{ currentRoute('login') }}>
							<a href="{{ route('login') }}">@lang('Login')</a>
						</li>
@request('password/reset')
							<li class="current">
								<a href="{{ request()->url() }}">@lang('Password')</a>
							</li>
@endrequest
@request('password/reset/*')
							<li class="current">
								<a href="{{ request()->url() }}">@lang('Password')</a>
							</li>
@endrequest
@else
@admin
							<li>
								<a href="{{ url('admin') }}">@lang('Administration')</a>
							</li>
@endadmin
@redac
							<li>
								<a href="{{ url('admin/posts') }}">@lang('Administration')</a>
							</li>
@endredac
						<li>
							<a id="logout" href="{{ route('logout') }}">@lang('Logout')</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hide">
								{{ csrf_field() }}
							</form>
						</li>
@endguest
@endrequest
			</ul>
		</nav>

		<div class="search-wrap">
			<form role="search" method="get" class="search-form" action="{{ route('posts.search') }}">
				<label>
					<input type="search" class="search-field" placeholder="@lang('Type Your Keywords')"  name="search" autocomplete="off" required>
				</label>
				<input type="submit" class="search-submit" value="">
			</form>

			<a href="#" id="close-search" class="close-btn">Close</a>

		</div>

		<div class="triggers">
			<a class="search-trigger" href="#"><i class="fa fa-search"></i></a>
			<a class="menu-toggle" href="#"><span>Menu</span></a>
		</div>

   	</div>

   </header> -->
    <!-- end header -->


    <!-- footer
   ================================================== -->

    <!-- <footer>

   	<div class="footer-main">

   		<div class="row">

	      	<div class="col-six tab-full mob-full footer-info">

	            <h4>@lang('About Our Site')</h4>

	               <p>@lang('Lorem ipsum Ut velit dolor Ut labore id fugiat in ut fugiat nostrud qui in dolore commodo eu magna Duis cillum dolor officia esse mollit proident Excepteur exercitation nulla. Lorem ipsum In reprehenderit commodo aliqua irure labore.')</p>

		      </div>

	      	<div class="col-three tab-1-2 mob-1-2 site-links">

	      		<h4>@lang('Site Links')</h4>

	      		<ul>
				  	<li><a href="#">@lang('About us')</a></li>
					<li><a href="{{ url('') }}">@lang('Blog')</a></li>
					<li><a href="{{ route('contacts.create') }}">@lang('Contact')</a></li>
					<li><a href="#">@lang('Privacy Policy')</a></li>
				</ul>

	      	</div>

	      	<div class="col-three tab-1-2 mob-1-2 social-links">

	      		<h4>@lang('Social')</h4>

	      		<ul>
	      			<li><a href="#">Twitter</a></li>
					<li><a href="#">Facebook</a></li>
					<li><a href="#">Dribbble</a></li>
					<li><a href="#">Google+</a></li>
					<li><a href="#">Instagram</a></li>
				</ul>

	      	</div>

	      </div>

   	</div>

      <div class="footer-bottom">
      	<div class="row">

      		<div class="col-twelve">
	      		<div class="copyright">
		         	<span>© Copyright Abstract 2016</span>
		         	<span>Design by <a href="http://www.styleshout.com/">styleshout</a></span>
		         </div>

		         <div id="go-top">
		            <a class="smoothscroll" title="Back to Top" href="#top"><i class="icon icon-arrow-up"></i></a>
		         </div>
	      	</div>

      	</div>
      </div>

   </footer> -->

    <!-- <div id="preloader">
    	<div id="loader"></div>
   </div> -->

    <!-- Java Script
   ================================================== -->
    <!-- <script src="{{ asset('js/plugins.js') }}"></script>
   <script src="{{ asset('js/main.js') }}"></script>
   <script>
	   $(function() {
		   $('#logout').click(function(e) {
			   e.preventDefault();
			   $('#logout-form').submit()
		   })
	   })
   </script> -->--}}
    @yield('scripts')

</body>

</html>