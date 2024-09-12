<!DOCTYPE html>
<html lang="en">
<head>
    <!-- META TAGS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="">
    <meta name="keywords" content="">
	<title>@yield('title')</title>
	
    @include('layouts.style')
</head>
<body>
    <!-- READING POSITION INDICATOR -->
    <progress value="0" id="eskimo-progress-bar">
        <span class="eskimo-progress-container">
            <span class="eskimo-progress-bar"></span>
        </span>
    </progress>
    <!-- SITE WRAPPER -->
    <div id="eskimo-site-wrapper">
        <!-- MAIN CONTAINER -->
        <main id="eskimo-main-container">
            <div class="container">
                <!-- SIDEBAR -->
                @include('layouts.header')
                <!-- TOP ICONS -->
                <ul class="eskimo-top-icons">
                    <li id="eskimo-panel-icon">
                        <a href="#eskimo-panel" class="eskimo-panel-open"><i class="fa fa-bars"></i></a>
                    </li>
                    <li id="eskimo-search-icon">
                        <a id="eskimo-open-search" href="#"><i class="fa fa-search"></i></a>
                    </li>
                </ul>

                @yield('content')
            </div>
        </main>
        <!-- FOOTER -->
        @include('layouts.footer')
    </div>
    <!-- GO TO TOP BUTTON -->
    <a id="eskimo-gototop" href="#"><i class="fa fa-chevron-up"></i></a>
    <!-- SLIDE PANEL OVERLAY -->
    <div id="eskimo-overlay"></div>
    <!-- SLIDE PANEL -->
    @include('layouts.sidebar')
    <!-- FULLSCREEN SEARCH -->
    <div id="eskimo-fullscreen-search">
        <div id="eskimo-fullscreen-search-content">
            <a href="#" id="eskimo-close-search"><i class="fa fa-times"></i></a>
            <form role="search" method="GET" action="{{ route('search.posts') }}" class="eskimo-lg-form">
                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" placeholder="Enter a keyword..." name="search" />
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- JS FILES -->

    @include('layouts.script')
    @yield('scripts')
</body>
</html>