<?php require APPROOT . '/views/inc/admin/votes_header.php'; ?>
<body class="hold-transition sidebar-mini layou-fixed">
<div class="wrapper">

  <?php require APPROOT . '/views/inc/admin/votes_navbar.php'; ?>
    <?php require APPROOT . '/views/inc/admin/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Voting Result</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                <li class="breadcrumb-item active">Final Result</li>
              </ol>
            </div>
          </div>
        </div>
      </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <!--<a href="#reset" data-toggle="modal" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-refresh"></i> Reset</a>
               <span class="pull-right">
                <a href="#print" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><span class="glyphicon glyphicon-print"></span> Print</a>
              </span> -->
                  <div id="result">
                    <a href="<?php echo URLROOT; ?>/result/print" target="_blank" class="btn btn-app bg-info"><i class="fa fa-print"></i> Print</a>
                    <a href="#reset" data-toggle="modal" class="btn btn-app bg-danger"><i class="fas fa-sync-alt"></i> Reset</a>
                  </div>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Position</th>
                      <th>Candidate Name</th>
                      <th>Total Votes</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $td = '';
                    foreach($data['votesResult'] as $row){
                      foreach ($data['totalVotes'] as $total) {
                        if ($total->candidate_id == $row->canid) {
                           $td++;
                        }
                      }
                      echo "
                        <tr>
                          <td>".$row->description."</td>
                          <td>".$row->canfirst.' '.$row->canlast."</td>                         
                          <td>".$td."</td>
                        </tr>
                      ";
                      $td = '';
                    }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php require APPROOT . '/views/inc/admin/footer.php'; ?>
  <?php require APPROOT . '/views/inc/admin/votes_modal.php'; ?>
</div>
<?php require APPROOT . '/views/inc/admin/votes_scripts.php'; ?>
<?php flash('reset_success'); ?>
</body>
</html>
