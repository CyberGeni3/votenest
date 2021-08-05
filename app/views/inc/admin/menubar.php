<?php if ($_SESSION['role'] == 'superadmin') { ?>


<aside class="main-sidebar sidebar-dark-primary elevation-4 fixed">
      <!-- Brand Logo -->
      <a href="<?php echo URLROOT; ?>/admins" class="brand-link">
        <img src="<?php echo URLROOT; ?>/images/fishtea.png" alt="VoteNest logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">VoteNest</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php echo (!empty($data['photo'])) ? URLROOT .'/images/admin/'.$data['photo'] : URLROOT .'/images/profile.jpg'; ?>" class="img-square elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">
              <p><?php echo $data['firstname'].' '.$data['lastname']; ?></p>
            </a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-header">REPORTS</li>
            <li class="nav-item">
              <a href="<?php echo URLROOT; ?>/admins" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  <span class="badge badge-info right"></span>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo URLROOT; ?>/admins/votes" class="nav-link">
                <i class="nav-icon fas fa-lock"></i>
                <p>
                  Votes
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo URLROOT; ?>/result" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Final Result
                </p>
              </a>
            </li>
            <li class="nav-header">SETTINGS</li>
            <li class="nav-item">
              <a href="#config" data-toggle="modal" class="nav-link">
                <i class="nav-icon fas fa-vote-yea"></i>
                <p>
                  Election
                </p>
              </a>
            </li>
            <li class="nav-header">MANAGE</li>
            <li class="nav-item sidebar-collapse">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shield-alt"></i>
                <p>
                  Election Manager
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo URLROOT; ?>/voter" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Voters</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo URLROOT; ?>/positions" class="nav-link">
                    <i class="fas fa-tasks nav-icon"></i>
                    <p>Positions</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo URLROOT; ?>/candidates" class="nav-link">
                    <i class="fas fa-user-tie nav-icon"></i>
                    <p>Candidates</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo URLROOT; ?>/officers" class="nav-link">
                    <i class="fab fa-black-tie nav-icon"></i>
                    <p>Officers</p>
                  </a>
                </li>
              </ul>
            </li>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    <?php require APPROOT . '/views/inc/admin/config_modal.php'; ?>
  <?php } elseif ($_SESSION['role'] == 'reg_officer') { ?>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 fixed">
      <!-- Brand Logo -->
      <a href="<?php echo URLROOT; ?>/admins" class="brand-link">
        <img src="<?php echo URLROOT; ?>/images/fishtea.png" alt="VoteNest logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">VoteNest</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php echo (!empty($data['photo'])) ? URLROOT .'/images/admin/'.$data['photo'] : URLROOT .'/images/profile.jpg'; ?>" class="img-square elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">
              <p><?php echo $data['firstname'].' '.$data['lastname']; ?></p>
            </a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            
            <li class="nav-header">MANAGE</li>
            <li class="nav-item">
              <a href="<?php echo URLROOT; ?>/voters" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Voters
                  <span class="badge badge-info right"></span>
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    

  <?php } else { ?>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 fixed">
      <!-- Brand Logo -->
      <a href="<?php echo URLROOT; ?>/admins" class="brand-link">
        <img src="<?php echo URLROOT; ?>/images/fishtea.png" alt="VoteNest logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">VoteNest</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php echo (!empty($data['photo'])) ? URLROOT .'/images/admin/'.$data['photo'] : URLROOT .'/images/profile.jpg'; ?>" class="img-square elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">
              <p><?php echo $data['firstname'].' '.$data['lastname']; ?></p>
            </a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            
            <li class="nav-header">MANAGE</li>
            <li class="nav-item">
              <a href="<?php echo URLROOT; ?>/voters" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Voters
                  <span class="badge badge-info right"></span>
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

  <?php } ?>

