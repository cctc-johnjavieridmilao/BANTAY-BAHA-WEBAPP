<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item <?=uri_string() == 'Admin/Dashboard' ? 'active' : '' ?>">
            <a class="nav-link" href="<?=base_url('Admin/Dashboard') ?>">
              <i class="mdi mdi-grid-large menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item <?=uri_string() == 'Admin/Setting' ? 'active' : '' ?>">
            <a class="nav-link" href="<?=base_url('Admin/Setting') ?>">
              <i class="menu-icon mdi mdi-cog"></i>
              <span class="menu-title">Settings</span>
            </a>
          </li>
          <li class="nav-item <?=uri_string() == 'Admin/Analytics' ? 'active' : '' ?>">
            <a class="nav-link" href="<?=base_url('Admin/Analytics') ?>">
              <i class="menu-icon mdi mdi-graph"></i>
              <span class="menu-title">Analytics</span>
            </a>
          </li>
          <li class="nav-item <?=uri_string() == 'Admin/Announcement' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('Admin/Announcement') ?>">
              <i class="menu-icon mdi mdi-bullhorn"></i>
              <span class="menu-title">Announcement</span>
            </a>
          </li>
          <li class="nav-item <?=uri_string() == 'Admin/UserManagement' ? 'active' : '' ?>">
            <a class="nav-link" href="<?=base_url('Admin/UserManagement') ?>">
              <i class="menu-icon mdi mdi-account-circle-outline"></i>
              <span class="menu-title">User Management</span>
            </a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)" onclick="Logout()">
              <i class="menu-icon mdi mdi-power"></i>
              <span class="menu-title">Logout</span>
            </a>
          </li>
        </ul>
      </nav>