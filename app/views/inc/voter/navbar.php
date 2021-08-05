<!-- Header Navbar: style can be found in header.less -->
<nav class="main-header navbar navbar-expand navbar-primary navbar-dark">

<ul class="navbar-nav ml-auto">
    <!-- User Account: style can be found in dropdown.less -->
    <li class="nav-item dropdown user user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <img src="<?php echo (!empty($_SESSION['photo'])) ? URLROOT . '/images/voter_faces/'.$_SESSION['photo'] : URLROOT . '/images/profile.jpg'; ?>" class="img-circle elevation-2 user-image" alt="User Image">
        <span class="hidden-xs"><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']; ?></span>
      </a>
      <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
          <img src="<?php echo (!empty($_SESSION['photo'])) ? URLROOT . '/images/voter_faces/'.$_SESSION['photo'] : URLROOT . '/images/profile.jpg'; ?>" class="img-square" alt="User Image">
          <p>
            <?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']; ?>
          </p>
        </li>
        <li class="user-footer">
          <div class="float-right">
            <a href="<?php echo URLROOT; ?>/logins/voterlogout" class="btn btn-danger btn-block">Sign out</a>
          </div>
        </li>
      </ul>
    </li>
</ul>
</nav>