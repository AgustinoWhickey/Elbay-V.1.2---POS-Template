<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <!--<li class="nav-item <?php //echo $this->uri->segment(2) == '' ? 'active': '' ?>">
        <a class="nav-link" href="<?php //echo site_url('admin') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Overview</span>
        </a>
    </li>-->
	<?php if($_SESSION['role']=='Admin'){ ?>
		<li class="nav-item <?php echo $this->uri->segment(2) == 'dashboard' ? 'active': '' ?>">
			<a class="nav-link" href="<?php echo site_url('dashboard/users') ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Users</span>
			</a>
		</li>
		<li class="nav-item dropdown <?php echo $this->uri->segment(2) == 'buku' ? 'active': '' ?>">
			<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
				aria-expanded="false">
				<i class="fas fa-fw fa-boxes"></i>
				<span>Data Buku</span>
			</a>
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">
				<a class="dropdown-item" href="<?php echo site_url('dashboard/masterbuku') ?>">Master Buku</a>
				<a class="dropdown-item" href="<?php echo site_url('dashboard/laporanpeminjaman') ?>">Laporan Peminjaman</a>
			</div>
		</li>
	<?php } else{ ?>
		<li class="nav-item <?php echo $this->uri->segment(2) == 'user' ? 'active': '' ?>">
			<a class="nav-link" href="<?= site_url('dashboard/transaksipeminjaman') ?>">
				<i class="fas fa-fw fa-boxes"></i>
				<span>Transaksi Peminjaman</span>
			</a>
		</li>
		<li class="nav-item <?php echo $this->uri->segment(2) == 'user' ? 'active': '' ?>">
			<a class="nav-link" href="<?= site_url('dashboard/laporanpeminjaman') ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Laporan Peminjaman</span>
			</a>
		</li>
	<?php } ?>
</ul>
