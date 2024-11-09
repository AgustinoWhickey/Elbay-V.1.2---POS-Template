  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon">
        <img src="<?= base_url('assets/img/logo2.png') ?>" style="width: 88%;margin-left: -14px;margin-top: 22px;">
      </div>
    </a>

    <hr class="sidebar-divider" style="border:none;">

    <div class="sidebar-heading" style="margin-top: 20px;">
      <b>Main Navigation</b>
    </div>

    <li class="nav-item <?= $this->uri->segment(1) == 'admin'|| $this->uri->segment(1) == '' ? 'active' : '' ?>">
      <a class="nav-link" href="<?= base_url('admin?status=tahunan'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- <li class="nav-item">
      <a class="nav-link" href="">
        <i class="fas fa-fw fa-users"></i>
        <span>Customers</span></a>
    </li> -->

    <li class="nav-item <?= $this->uri->segment(1) == 'item'|| $this->uri->segment(1) == 'category' ? 'active' : '' ?>">
      <a class="nav-link <?= $this->uri->segment(1) == 'item'|| $this->uri->segment(1) == 'category' ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseProduct" aria-expanded="true" aria-controls="collapseProduct">
        <i class="fas fa-fw fa-inbox"></i>
        <span>Products</span>
      </a>
      <div id="collapseProduct" class="collapse <?= $this->uri->segment(1) == 'item'|| $this->uri->segment(1) == 'category' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="<?= base_url('category'); ?>">Kategori</a>
          <a class="collapse-item" href="<?= base_url('item'); ?>">Menu</a>
          <a class="collapse-item" href="<?= base_url('itemMenu'); ?>">Item</a>
        </div>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransaction" aria-expanded="true" aria-controls="collapseTransaction">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Transaction</span>
      </a>
      <div id="collapseTransaction" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="<?= base_url('sale'); ?>">Sales</a>
          <a class="collapse-item" href="<?= base_url('stockin'); ?>">Stock In</a>
          <!-- <a class="collapse-item" href="<?//= base_url('stock/stockout'); ?>">Stock Out</a> -->
        </div>
      </div>
    </li>

    <?php if($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 2) { ?>
      <li class="nav-item <?= $this->uri->segment(1) == 'report' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport" aria-expanded="true" aria-controls="collapseReport">
          <i class="fas fa-fw fa-edit"></i>
          <span>Reports</span>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?= base_url('report/sales'); ?>">Sales</a>
            <a class="collapse-item" href="<?= base_url('stockreport'); ?>">Stocks</a>
          </div>
        </div>
      </li>

      <li class="nav-item <?= $this->uri->segment(1) == 'branch' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBranch" aria-expanded="true" aria-controls="collapseBranch">
          <i class="fas fa-fw fa-home"></i>
          <span>Cabang</span>
        </a>
        <div id="collapseBranch" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?= base_url('branch'); ?>">Kelola Cabang</a>
            <a class="collapse-item" href="<?= base_url('userbranch'); ?>">Pegawai Cabang</a>
          </div>
        </div>
      </li>

      <!-- <li class="nav-item <?= $this->uri->segment(1) == 'promosi' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('promosi'); ?>">
          <i class="fas fa-fw fa-bullhorn"></i>
          <span>Promosi</span></a>
      </li> -->

      <li class="nav-item <?= $this->uri->segment(1) == 'supplier' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('supplier'); ?>">
          <i class="fas fa-fw fa-truck"></i>
          <span>Suppliers</span></a>
      </li>

      <li class="nav-item <?= $this->uri->segment(1) == 'user' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user'); ?>">
          <i class="fas fa-fw fa-user"></i>
          <span>User</span>
        </a>
      </li>
    <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider mt-3">

    <li class="nav-item">
      <div class="nav-link" id="logout" style="cursor: pointer;">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Logout</span>
    </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->