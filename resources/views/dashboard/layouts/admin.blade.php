<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Wishing Quotes</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('admin/assets/css/app.min.css')}}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('admin/assets/bundles/datatables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{asset('admin/assets/css/components.css')}}">
  <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('admin/assets/css/custom.css')}}">
  <link rel='shortcut icon' type='image/x-icon' href="{{asset('admin/assets/img/favicon.ico')}}" />
  
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="{{asset('admin/assets/img/user.png')}}"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Welcome Admin</div>
              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"> <i class="fas fa-sign-out-alt"></i>
                {{ __('Logout') }}
              </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="/dashboard"> <img alt="image" src="{{asset('admin/assets/img/logo.png')}}" class="header-logo" /> <span
                class="logo-name">Wishing</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="{{(request()->is('dashboard') ? 'active' : '' )}}">
              <a href="/dashboard" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            {{-- <li class="">
              <a class="nav-link" href="/contacts"><i data-feather="users"></i><span>Contacts</span></a>
            </li> --}}

            <li class="dropdown {{( (request()->is('categories*')) ? 'active' : '' )}}">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Categories</span></a>
              <ul class="dropdown-menu">
                <li class="{{( request()->is('categories') ? 'active' : '' )}}"><a class="nav-link" href="{{ route('categories.index') }}">Category list</a></li>
                <li class="{{( request()->is('categories/create') ? 'active' : '' )}}"><a class="nav-link" href="{{ route('categories.create') }}">Create category</a></li>
              </ul>
            </li>

            <li class="dropdown {{( (request()->is('posts*')) ? 'active' : '' )}}">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Posts</span></a>
              <ul class="dropdown-menu">
                <li class="{{( (request()->is('posts')) ? 'active' : '' )}}"><a class="nav-link" href="{{ route('posts.index') }}">Post list</a></li>
                <li class="{{( (request()->is('posts/create')) ? 'active' : '' )}}"><a class="nav-link" href="{{ route('posts.create') }}">Create post</a></li>
              </ul>
            </li>

          </ul>
        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          @include('dashboard.layouts.flash_message')
            <div class="section-body">
                @yield('content')
            </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <a href="www.loopersolutions.com">LooperSolutions</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <!-- General JS Scripts -->
  
  <script src="{{asset('admin/assets/js/app.min.js')}}"></script>
  <!-- JS Libraies -->
  <script src="{{asset('admin/assets/bundles/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Template JS File -->
  <script src="{{asset('admin/assets/js/scripts.js')}}"></script>
  <!-- Custom JS File -->
  <script src="{{asset('admin/assets/js/custom.js')}}"></script>
  @yield('script')
</body>

</html>