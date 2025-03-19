<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8"> -->
        <span class="brand-text font-weight-light">Zakat</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <!-- <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div> -->
            <div class="info">
                <a href="#" class="d-block"><?= session()->get('name') ?? 'Guest' ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="/" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <?php if (is_admin()): ?>
                    <li class="nav-item">
                        <a href="/rt" class="nav-link">
                            <i class="nav-icon fas fa-user-check"></i>
                            <p>
                                Data RT
                            </p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (is_admin() || is_rt()): ?>
                    <li class="nav-item">
                        <a href="/warga" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Data Warga
                            </p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (is_admin() || is_bendahara()): ?>
                    <li class="nav-item">
                        <a href="/pemasukan_zakat" class="nav-link">
                            <i class="nav-icon fas fa-weight"></i>
                            <p>
                                Pemasukan Zakat
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/penerima_zakat" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Penerima Zakat
                            </p>
                        </a>
                    </li>

                <?php endif; ?>




            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>