<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">{{ config('app.name', 'Perpus') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        <a href="#" class="d-block">Anda login sebagai {{ getRoleNames( Auth::user() ) }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview menu-open">
          <a href="{{ route('home') }}" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>
        @role('admin')
        <li class="nav-item">
          <a href="{{ route('authors.index') }}" class="nav-link">
            <i class="nav-icon fas fa-book-reader"></i>
            <p>
              Authors
              {{-- <span class="right badge badge-danger">New</span> --}}
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('members.index') }}" class="nav-link">
            <i class="nav-icon fas fa-book-reader"></i>
            <p>
              Member
              {{-- <span class="right badge badge-danger">New</span> --}}
            </p>
          </a>
        </li>
        @endrole
        <li class="nav-item">
          <a href="{{ route('books.index') }}" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Book
              {{-- <span class="right badge badge-danger">New</span> --}}
            </p>
          </a>
        </li>
        @role('admin')
        <li class="nav-item">
          <a href="{{ route('transaction.admin') }}" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Transaction
              {{-- <span class="right badge badge-danger">New</span> --}}
            </p>
          </a>
        </li>
        @endrole
        @role('member')
        <li class="nav-item">
          <a href="{{ route('transaction.member') }}" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Transaction
              {{-- <span class="right badge badge-danger">New</span> --}}
            </p>
          </a>
        </li>
        @endrole
        <li class="nav-item">
          <a href="{{ route('profile') }}" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Profile
              {{-- <span class="right badge badge-danger">New</span> --}}
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-power-off"></i>
            <p>
              Sign Out
            </p>
          </a>
        <form id="logout-form" style="display:none;" action="{{route('logout')}}" method="post">
        @csrf
        </form>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>