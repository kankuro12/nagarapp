  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">

          <div class="sidebar-brand-text mx-3">Nagar App</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
          <a class="nav-link" href="/">
              <i class="fas fa-fw fa-tachometer-alt"></i>
              <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      @if (Auth::user()->level == 0)
          <li class="nav-item">
              <a class="nav-link" href="{{ route('superadmin.user.index') }}">
                  <i class="fas fa-fw fa-user"></i>
                  <span>Users</span></a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="{{ route('superadmin.setting.index') }}">
                  <i class="fas fa-fw fa-cog"></i>
                  <span>Settings</span></a>
          </li>
      @endif
      @if (Auth::user()->level == 1)
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse-member"
                  aria-expanded="true" aria-controls="collapse-member">
                  <i class="fas fa-fw fa-user"></i>
                  <span>Members</span>
              </a>
              <div id="collapse-member" class="collapse" aria-labelledby="headingUtilities"
                  data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin.member.index') }}">List</a>
                    <a class="collapse-item" href="{{ route('admin.member.add') }}">Add</a>

                  </div>
              </div>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse-alert"
                aria-expanded="true" aria-controls="collapse-alert">
                <i class="fas fa-fw fa-user"></i>
                <span>Alerts</span>
            </a>
            <div id="collapse-alert" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item" href="{{ route('admin.alert.index') }}">List</a>
                  <a class="collapse-item" href="{{ route('admin.alert.add') }}">Add</a>

                </div>
            </div>
        </li>
          <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.samiti.index') }}">
                  <i class="fas fa-fw fa-user"></i>
                  <span>Samiti</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.news.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>News</span></a>
        </li>
      @endif

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>


  </ul>
  <!-- End of Sidebar -->
