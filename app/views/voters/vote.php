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
                <!-- Voting Ballot -->
                <form method="POST" id="ballotForm" action="<?php echo URLROOT; ?>/voters/vote" enctype="multipart/form-data">
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
                            <a class="float-right">No</a>
                          </li>
                            <a href="<?php echo URLROOT; ?>/voters" class="btn btn-primary btn-block"><i class="fa fa-file-text"></i> Home</a> 
                            <button type="button" class="btn btn-primary btn-block" id="preview"><i class="fa fa-file-text"></i> Preview</button>
                            <button type="button" id="send" class="btn btn-primary btn-block"><i class="fa fa-file-text"></i> Submit</button>
                        </ul>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                  </div>

                  <div class="col-md-9">
                    <div class="tab-content">
                      <?php  
                        $candidate = '';
                        $echopos = '';
                          foreach($data['pos'] as $row) {
                            foreach($data['can'] as $crow){
                              if ($crow->position_id == $row->id) {                                 
                                $slug = slugify($row->description);
                                $checked = '';
                                $input = ($row->max_vote > 1) ? '<input type="checkbox" class="square-blue '.$slug.'" name="'.$slug."[]".'" value="'.$crow->id.'" '.$checked.' id="'.$slug.$crow->id.'"><label for="'.$slug.$crow->id.'" style="margin-left: 10px;">  '.$crow->firstname.' '.$crow->lastname.'</label>' : '<input type="radio" class="square-blue '.$slug.'" name="'.slugify($row->description).'" value="'.$crow->id.'" '.$checked.' id="'.$slug.$crow->id.'"><label for="'.$slug.$crow->id.'" style="margin-left: 10px;">  '.$crow->firstname.' '.$crow->lastname.'</label>';
                                $candidate .= '
                                              <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline">
                                                '.$input.'
                                                </div>
                                              </div>
                                            ';
                              }
                            }

                            $instruct = ($row->max_vote > 1) ? 'You may select up to '.$row->max_vote.' candidates' : 'Select only one candidate';
                            $reset = ($row->max_vote > 1) ? 'Press <code>reset</code> button to uncheck your choices' : 'Press <code>reset</code> button to uncheck your choice';

                            $echopos = '
                              <div class="card card-primary">
                                <div class="card-header">
                                  <h3 class="card-title"><b>'.$row->description.'</b></h3>
                                </div>
                                <div class="card-body">
                                  '.$instruct.'
                                    <div class="float-right">
                                      <button type="button" class="btn btn-xs btn-danger reset" data-desc="'.slugify($row->description).'"><i class="fa fa-sync-alt"></i> Reset</button>
                                    </div>
                                  <hr>
                                    '.$candidate.'
                                </div>
                                <div class="card-footer">
                                  '.$reset.'
                                </div>
                              </div>
                            ';
                            echo $echopos;
                            $candidate = '';
                            $echopos = '';   
                        }

                      ?>
                    </div>
                  </div>

                    
                  </div>
                  <?php require APPROOT . '/views/inc/voter/cam_modal.php'; ?>
                </form>
                <!-- End Voting Ballot -->
            </div>
        </div>
       
      </section>
    </div>
    <?php require APPROOT . '/views/inc/voter/footer.php'; ?>
    <?php require APPROOT . '/views/inc/voter/ballot_modal.php'; ?>
</div>
<?php require APPROOT . '/views/inc/voter/scripts.php'; ?>
<?php
if(!empty($data['sub_error'])) {
    echo '
      <script>
        var Toast = Swal.mixin({
          toast: false,
          position: "center",
          showConfirmButton: true,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer)
            toast.addEventListener("mouseleave", Swal.resumeTimer)
          }
        });
        Toast.fire({
          icon: "error",
          title: "' . $data['sub_error'] . '"
        });
      </script>
    ';
  }
?>
</body>
</html>
