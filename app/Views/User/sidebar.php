<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item <?=uri_string() == 'Home/DashBoard' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('Home/DashBoard') ?>">
              <i class="mdi mdi-grid-large menu-icon"></i>
              <span class="menu-title">Dashboard </span>
            </a>
          </li>
          <li class="nav-item <?=uri_string() == 'Home/Setting' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('Home/Setting') ?>">
              <i class="menu-icon mdi mdi-cog"></i>
              <span class="menu-title">Settings</span>
            </a>
          </li>
          <li class="nav-item <?=uri_string() == 'Home/Analytics' ? 'active' : '' ?>">
            <a class="nav-link" href="<?=base_url('Home/Analytics') ?>">
              <i class="menu-icon mdi mdi-graph"></i>
              <span class="menu-title">Analytics</span>
            </a>
          </li>
          <li class="nav-item <?=uri_string() == 'Home/Announcement' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('Home/Announcement') ?>">
              <i class="menu-icon mdi mdi-bullhorn"></i>
              <span class="menu-title">Announcement</span>
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
