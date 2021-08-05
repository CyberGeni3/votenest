<?php require APPROOT . '/views/inc/admin/header.php'; ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo URLROOT; ?>/images/fishtea.png" alt="VoteNest logo" height="60" width="60">
  </div> -->
  <?php require APPROOT . '/views/inc/admin/navbar.php'; ?>
  <?php require APPROOT . '/views/inc/admin/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <section class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-tachometer-alt"></i> Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="card-header">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <span class="pull-left">
                    <div id="start" style="display: ">
                      <a href="#activate" data-toggle="modal" class="btn btn-app bg-success"><i class="fa fa-hourglass-start"></i> Start</a>
                    </div>
                    <div id="end" style="display: none">
                      <a href="#ending" data-toggle="modal" class="btn btn-app bg-danger"><i class="fa fa-hourglass-start"></i> End</a>
                    </div>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <?php
               echo '<h3>'.count($data['pos']).'</h3>';
              ?>

              <p>No. of Positions</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a href="<?php echo URLROOT; ?>/admins/positions" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <?php
                echo '<h3>'.count($data['can']).'</h3>';
              ?>
          
              <p>No. of Candidates</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-tie"></i>
            </div>
            <a href="<?php echo URLROOT; ?>/admins/candidates" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php
                echo '<h3>'.count($data['vote']).'</h3>';
              ?>
             
              <p>Total Voters</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="<?php echo URLROOT; ?>/admins/voters" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner">
              <?php
                echo '<h3>'.count($data['votenum']).'</h3>';
              ?>

              <p>Voters Voted</p>
            </div>
            <div class="icon">
              <i class="fa fa-edit"></i>
            </div>
            <a href="<?php echo URLROOT; ?>/admins/votes" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      
      <div class="row">
        <div class="col-md-12">
          <h3>Votes Tally
          </h3>
        </div>
      </div>

      <?php
        $inc = 2;
        foreach($data['getPositions'] as $row) {
          $inc = ($inc == 2) ? 1 : $inc+1; 
          if($inc == 1) echo "<div class='row'>";
          echo "
            <div class='col-sm-6'>
              <div class='card'>
                <div class='card-header bg-primary'>
                  <h4 class='card-title'><b>".$row->description."</b></h4>
                </div>
                <div class='card-body'>
                  <div id='".slugify($row->description)."' style='height:200px'></div>
                </div>
              </div>
            </div>
          ";
          if($inc == 2) echo "</div>";  
        }
        if($inc == 1) echo "<div class='col-sm-6'></div></div>";
      ?>

      </section>
      <!-- right col -->
    </div>
  	<?php require APPROOT . '/views/inc/admin/footer.php'; ?>
    <?php require APPROOT . '/views/inc/admin/voters_modal.php'; ?>
  </div>
</section>
<!-- ./wrapper -->
<?php require APPROOT . '/views/inc/admin/scripts.php'; ?>
<?php flash('admin_login_success'); ?>
<?php flash('admin_success'); ?>

<?php
  $dataPoints = array();
  $candi = array();
  foreach ($data['getPositionsAsc'] as $position) {
    foreach ($data['winners'] as $winner) {
      if ($position->id == $winner->posid) {
        $candi = array("y" => $winner->total, "label" => $winner->canlast);
        array_push($dataPoints, $candi);
      }
    }
?>
    <script>
    $(function() {
    var chart = new CanvasJS.Chart("<?php echo slugify($position->description); ?>", {
      animationEnabled: true,
      axisY: {
        title: "Total Votes",
        includeZero: true
      },
      data: [{
        type: "bar",
        yValueFormatString: "#,##0",
        indexLabel: "{y}",
        indexLabelPlacement: "inside",
        indexLabelFontWeight: "bolder",
        indexLabelFontColor: "white",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
      }]
    });
    chart.render();
    })
    </script>
<?php 
    $dataPoints = array(); 
    $candi = array(); 
  } 
?>
<script src="<?php echo URLROOT; ?>/plugins/canvasjs/canvasjs.min.js"></script>
</body>
</html>
