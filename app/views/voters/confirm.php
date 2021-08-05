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
                <div class="text-center">
                  <h3>You have already voted for this election.</h3>
                  <a href="#view" data-toggle="modal" class="btn btn-flat btn-primary btn-lg">View Ballot</a>
                </div>
            </div>
        </div>
       <!-- View Ballot -->
<div class="modal fade" id="view">
    <div class="modal-dialog">
        <div class="modal-content card-primary">
            <div class="card-header">
              <h4 class="card-title">Your Votes</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>   
            </div>
            <div class="card-body">
              <?php
                foreach($data['vie'] as $row){
                  echo "
                    <div class='row votelist'>
                      <span class='col-sm-4'><span class='pull-right'><b>".$row->description." :</b></span></span> 
                      <span class='col-sm-8'>".$row->canfirst." ".$row->canlast."</span>
                    </div>
                  ";
                }
              ?>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>
      </section>
    </div>
    <?php require APPROOT . '/views/inc/voter/footer.php'; ?>
</div>
<?php require APPROOT . '/views/inc/voter/scripts.php'; ?>
<?php flash('submit_success'); ?>
</body>
</html>
