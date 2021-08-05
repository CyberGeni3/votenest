  <!-- Logo
  <a href="home.php" class="brand-link">
     mini logo for sidebar mini 50x50 pixels
    <span class="logo-mini"><b>V</b>N</span>
    logo for regular state and mobile devices
    <span class="logo-lg"><b>VoteNest </span>
  </a> -->
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Sidebar toggle button-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>
   
    <ul class="navbar-nav ml-auto">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="nav-item dropdown user user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo (!empty($data['photo'])) ? URLROOT .'/images/admin/'.$data['photo'] : URLROOT .'/images/profile.jpg'; ?>" class="img-circle elevation-2 user-image" alt="User Image">
            <span class="hidden-xs"><?php echo $data['firstname'].' '.$data['lastname']; ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?php echo (!empty($data['photo'])) ? URLROOT .'/images/admin/'.$data['photo'] : URLROOT .'/images/profile.jpg'; ?>" class="img-square" alt="User Image">

              <p>
                <?php echo $data['firstname'].' '.$data['lastname']; ?>
                <small>Admin since <?php echo date('M. Y', strtotime($data['created_on'])); ?></small>
              </p>
            </li>
            <li class="user-footer">
              <div class="float-left">
                <a href="#profile" data-toggle="modal" class="btn btn-default btn-flat" id="admin_profile">Update</a>
              </div>
              <div class="float-right">
                <a href="<?php echo URLROOT; ?>/logins/adminlogout" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
    </ul>
  </nav>

  <?php require APPROOT . '/views/inc/admin/profile.php'; ?>