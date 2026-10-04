<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Wishing Quotes</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('admin/assets/css/app.min.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/bundles/datatables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon.ico') }}" />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"><i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn"><i data-feather="maximize"></i></a></li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="{{ asset('admin/assets/img/user.png') }}" class="user-img-radious-style">
            </a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Welcome Admin</div>
              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </div>
          </li>
        </ul>
      </nav>

      <!-- Sidebar -->
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ url('admin/dashboard') }}">
              <img alt="image" src="{{ asset('admin/assets/img/logo.png') }}" class="header-logo" />
              <span class="logo-name">Wishing</span>
            </a>
          </div>

          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>

            <!-- Dashboard -->
            <li class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">
              <a href="{{ url('admin/dashboard') }}" class="nav-link">
                <i data-feather="monitor"></i><span>Dashboard</span>
              </a>
            </li>

            <!-- Posts -->
            <li class="dropdown {{ request()->is('admin/posts*') ? 'active' : '' }}">
              <a href="#" class="menu-toggle nav-link has-dropdown {{ request()->is('admin/posts*') ? 'toggled' : '' }}">
                <i data-feather="file-text"></i><span>Posts</span>
              </a>
              <ul class="dropdown-menu" style="{{ request()->is('admin/posts*') ? 'display:block;' : '' }}">
                <li class="{{ request()->routeIs('posts.index') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('posts.index') }}">Post List</a>
                </li>
                <li class="{{ request()->routeIs('posts.create') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('posts.create') }}">Create Post</a>
                </li>
                <li class="{{ request()->routeIs('posts.categories.index') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('posts.categories.index') }}">Post Categories</a>
                </li>
                <li class="{{ request()->routeIs('posts.categories.create') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('posts.categories.create') }}">Create Post Category</a>
                </li>
              </ul>
            </li>

            <!-- Galleries -->
            <li class="dropdown {{ request()->is('admin/galleries*') ? 'active' : '' }}">
              <a href="#" class="menu-toggle nav-link has-dropdown {{ request()->is('admin/galleries*') ? 'toggled' : '' }}">
                <i data-feather="image"></i><span>Galleries</span>
              </a>
              <ul class="dropdown-menu" style="{{ request()->is('admin/galleries*') ? 'display:block;' : '' }}">
                <li class="{{ request()->routeIs('galleries.index') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('galleries.index') }}">Gallery List</a>
                </li>
                <li class="{{ request()->routeIs('galleries.create') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('galleries.create') }}">Create Gallery</a>
                </li>
                <li class="{{ request()->routeIs('galleries.categories.index') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('galleries.categories.index') }}">Gallery Categories</a>
                </li>
                <li class="{{ request()->routeIs('galleries.categories.create') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('galleries.categories.create') }}">Create Gallery Category</a>
                </li>
              </ul>
            </li>

            <!-- Videos -->
            <li class="dropdown {{ request()->is('admin/videos*') ? 'active' : '' }}">
              <a href="#" class="menu-toggle nav-link has-dropdown {{ request()->is('admin/videos*') ? 'toggled' : '' }}">
                <i data-feather="video"></i><span>Videos</span>
              </a>
              <ul class="dropdown-menu" style="{{ request()->is('admin/videos*') ? 'display:block;' : '' }}">
                <li class="{{ request()->routeIs('videos.index') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('videos.index') }}">Video List</a>
                </li>
                <li class="{{ request()->routeIs('videos.create') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('videos.create') }}">Create Video</a>
                </li>
                <li class="{{ request()->routeIs('videos.categories.index') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('videos.categories.index') }}">Video Categories</a>
                </li>
                <li class="{{ request()->routeIs('videos.categories.create') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('videos.categories.create') }}">Create Video Category</a>
                </li>
              </ul>
            </li>

            <!-- Contacts -->
            <li class="{{ request()->is('admin/contacts*') ? 'active' : '' }}">
              <a href="{{ route('contacts.index') }}" class="nav-link">
                <i data-feather="mail"></i><span>Contacts</span>
                @if(\App\Models\Contact::where('is_read', false)->count() > 0)
                  <span class="badge badge-warning">{{ \App\Models\Contact::where('is_read', false)->count() }}</span>
                @endif
              </a>
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

      <!-- Footer -->
      <footer class="main-footer">
        <div class="footer-left">
          <a href="https://www.loopersolutions.com" target="_blank">LooperSolutions</a>
        </div>
        <div class="footer-right"></div>
      </footer>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('admin/assets/js/app.min.js') }}"></script>
  <script src="{{ asset('admin/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
  <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
  @yield('script')
  <script>
    // Ensure loader overlay always fades out as soon as DOM is ready
    $(document).ready(function() {
      setTimeout(function() {
        $(".loader").fadeOut("fast");
      }, 150);
    });
  </script>
</body>
</html>
