<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="">{{ config('app.name') }}</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="#">{{ strtoupper(substr(config('app.name'), 0, 2)) }}</a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="{{ request()->is('/') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/dashboard') }}">
        <i class="fas fa-columns"></i> <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-item dropdown" style="cursor: pointer;">
      <a class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-database"></i>
          <span>Master Data</span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="dashboardMasterStore">Stores</a>
          <a class="nav-link" href="dashboardMasterCategory">Categories</a>
          <a class="nav-link" href="dashboardMasterMenu">Menus</a>
          <a class="nav-link" href="dashboardDiscount">Discounts</a>
          <a class="nav-link" href="dashboardSpecialPrice">Special Prices</a>
        </li>
      </ul>
    </li>

    <li class="nav-item dropdown" style="cursor: pointer;">
      <a class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-cubes"></i>
          <span>Stock</span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="dashboardStockManagement">Stock Management</a>
        </li>
      </ul>
    </li>

    <li class="nav-item dropdown" style="cursor: pointer;">
      <a class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-file-medical-alt"></i>
          <span>Laporan</span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="dashboardLaporanPenjualan">Laporan Penjualan</a>
        </li>
        <li>
          <a class="nav-link" href="dashboardReportItemSales">Report Item Sales</a>
        </li>
      </ul>
    </li>

    <li class="nav-item dropdown" style="cursor: pointer;">
      <a class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-times-circle"></i>
          <span>Void</span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="dashboardVoidTransaksi">Transaksi void</a>
        </li>
      </ul>
    </li>

    <li class="menu-header">Users</li>
    <li><a class="nav-link" href="dashboardUsers"><i class="fas fa-users"></i> <span>Users</span></a></li>
  </ul>
</aside>
