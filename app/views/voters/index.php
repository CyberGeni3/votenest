<?php require APPROOT . '/views/inc/voter/header.php'; ?>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <?php require APPROOT . '/views/inc/voter/navbar.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <!-- Main content -->
        <div class="container-fluid">
          <?php
            $parse = parse_ini_file(APPROOT . '/views/admins/config.ini', FALSE, INI_SCANNER_RAW);
            $title = $parse['election_title'];
          ?>
          <h1 class="page-header text-center title"><b><?php echo strtoupper($title); ?></b></h1>
            <div class="col-md-12 col-md-offset-1">
              <?php flash('login_success'); ?>
            <?php
              if ($data['votedAlready']) {
            ?>
                <div class="text-center">
                  <h3>You have already voted for this election.</h3>
                  <a href="#view" data-toggle="modal" class="btn btn-flat btn-primary btn-lg">View Ballot</a>
                </div>
            <?php
              } else {
            ?>
                <!-- Voting Ballot BUWAGON ANG FORM SA INDEX-->
                <div class="row">
                  <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                      <div class="card-body box-profile">
                        <div class="text-center">
                          <img class="profile-user-img img-fluid img-circle" src="<?php echo (!empty($_SESSION['photo'])) ? URLROOT . '/images/voter_faces/'.$_SESSION['photo'] : URLROOT . '/images/profile.jpg'; ?>" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center"><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?></h3>
                        <p class="text-muted text-center">
                          <?php echo strtoupper($_SESSION['program']) . ' student'; ?>
                        </p>
                        <ul class="list-group list-group-unbordered mb-3">
                          <li class="list-group-item">
                            <b>Status</b> <a class="float-right">
                              <?php echo $_SESSION['status']; ?></a>
                          </li>
                          <li class="list-group-item">
                            <b>Voted?</b> 
                            <a class="float-right">
                              No
                            </a>
                          </li>
                            <a href="<?php echo URLROOT; ?>/voters/vote" class="btn btn-primary btn-block"><i class="fa fa-file-text"></i> Vote Now!</a>
                        </ul>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                  </div>

                  <div class="col-md-9">
                    <div class="card">
                      <div class="card-header p-2">
                        <div class="row">
                          <ul class="nav nav-pills">
                            <?php foreach ($data['pos'] as $pos) {
                              if ($pos->priority == 1) {
                                echo '<li class="nav-item"><a class="nav-link active" href="#'.slugify($pos->description).'" data-toggle="tab">'.$pos->description.'</a></li>';
                              }
                              else {
                                echo '<li class="nav-item"><a class="nav-link" href="#'.slugify($pos->description).'" data-toggle="tab">'.$pos->description.'</a></li>';
                              }
                            } ?>
                          </ul>
                        </div>
                      </div><!-- /.card-header -->
                      <div class="card-body">
                        <div class="tab-content">
                          <?php 
                            $candidate = '';
                            foreach ($data['pos'] as $pos) {
                              if ($pos->priority == 1) {
                                $position = '<div class="active tab-pane" id="'.slugify($pos->description).'">';
                              }
                              else {
                                $position = '<div class="tab-pane" id="'.slugify($pos->description).'">';
                              }
                              foreach ($data['can'] as $can) {
                                if ($can->position_id == $pos->id) {
                                  $image = (!empty($can->photo)) ? URLROOT . '/images/voter_faces/'.$can->photo : URLROOT . '/images/profile.jpg';
                                  $candidate .= '
                                  
                                    <div class="post">
                                      <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="'.$image.'">
                                        <span class="username">
                                          <a href="#">'.$can->firstname.' '.$can->lastname.'</a>
                                        </span>
                                      </div>
                                      <!-- /.user-block -->
                                      <p>
                                        '.$can->platform.'
                                      </p>
                                    </div>
                                  ';
                                }
                              }
                              echo '
                                    '.$position.'
                                    '.$candidate.'
                                    </div>

                                ';
                                $candidate = '';
                                $position = '';
                            } 
                          ?>
                        </div>
                      </div>
                  </div>
                </div>
                <!-- End Voting Ballot -->  
            </div>
          <?php } ?>
        </div>
       
      </section>
    </div>
    <?php require APPROOT . '/views/inc/voter/footer.php'; ?>
    <?php require APPROOT . '/views/inc/voter/ballot_modal.php'; ?>
</div>
<?php require APPROOT . '/views/inc/voter/scripts.php'; ?>
<?php flash('voter_login_success'); ?>
</body>
</html>
