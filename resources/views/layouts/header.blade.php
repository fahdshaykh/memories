<div id="eskimo-sidebar">
    <div id="eskimo-sidebar-wrapper" class="d-flex align-items-start flex-column h-100 w-100">
        <!-- LOGO -->
        <div id="eskimo-logo-cell" class="w-100">
            <a class="eskimo-logo-link" href="{{ url('/') }}">
                <img src="{{ asset('frontend/images/logo.png') }}" class="eskimo-logo" alt="eskimo" />
            </a>
        </div>
        <!-- MENU CONTAINER -->
        <div id="eskimo-sidebar-cell" class="w-100">
            <!-- MOBILE MENU BUTTON -->
            <div id="eskimo-menu-toggle">MENU</div>
            <!-- MENU -->
            <nav id="eskimo-main-menu" class="menu-main-menu-container">
                <ul class="eskimo-menu-ul">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('categories.user') }}">Galleries</a></li>
                </ul>
            </nav>
        </div>
        <!-- SOCIAL MEDIA ICONS -->
        <div id="eskimo-social-cell" class="mt-auto w-100">
            <div id="eskimo-social-inner">
                <ul class="eskimo-social-icons">
                    <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-vimeo"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>