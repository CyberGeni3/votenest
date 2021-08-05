<?php $db = new Database(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VoteNest | Print Result</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
          <i class="fas fa-vote-yea"></i> <?php $parse = parse_ini_file(APPROOT . '/views/admins/config.ini', FALSE, INI_SCANNER_RAW);
            $title = $parse['election_title'];
            echo $title; ?>
          <small class="float-right"><?php echo date('l jS \of F Y') ?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <strong>Admin</strong>
        <address>
          Name: 
          <strong> <?php echo $data['firstname'].' '.$data['lastname']; ?></strong><br>
          Platform:
          <strong><?php echo SITENAME; ?></strong>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <strong>Result Info: </strong>
        <br>
        Election Title: <?php $parse = parse_ini_file(APPROOT . '/views/admins/config.ini', FALSE, INI_SCANNER_RAW);
            $title = $parse['election_title'];
            echo $title;
            ?><br>
        Voters:  <?php echo count($data['votenum']); ?><br>
        Candidates:  <?php echo count($data['cannum']); ?>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped table-bordered">
          <br>
          <hr class="bg-primary">
          <p><h2 class="text-center">LIST OF WINNERS</h2></p>
          <thead>
          <tr>
            <th>Position</th>
            <th>Candidate Name</th>
            <th>Total Votes</th>
          </tr>
          </thead>
          <tbody>
            <?php
              $finalWinner = '';
              $totals = [];
              $msg = '';
              foreach ($data['getpos'] as $position) {
                foreach ($data['winners'] as $winner) {
                  if ($position->id == $winner->position_id) {
                    foreach ($totals as $total) {
                      if ($total == $winner->total) {
                        $msg .= $finalWinner;
                      }
                      else {
                        $msg = '';
                      }
                    }
                    $finalWinner = '
                      <tr>
                        <td>'.$winner->description.'</td>
                        <td>'.$winner->canfirst.' '.$winner->canlast.'</td>
                        <td>'.$winner->total.'</td>
                      </tr>
                    ';
                    array_push($totals, $winner->total);
                  }
                }
                echo $finalWinner;
                echo $msg;
                $finalWinner = '';
                $msg = '';
              }
            ?>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <br>

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
        <p class="lead"><strong>Votes by Courses:</strong> in no particular order</p>

        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <tr>
              <th style="width:50%">Course Name: <em>(Abbr)</em></th>
              <td>Total Votes:</td>
            </tr>
            <?php
              $num = '';
              foreach ($data['grp'] as $program) {  
                foreach ($data['activeDept'] as $active) {
                  if ($active->program == $program->program) {
                    $num++;
                  }
                }
                echo '
                  <tr>
                    <th>'.$program->program.'</th>
                    <td>'.$num.'</td>
                  </tr>
                ';
                $num = '';
              }
            ?>
          </table>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <p class="lead">Tally Analysis: <?php echo date('l jS \of F Y') ?></p>

        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th>Total Candidates:</th>
              <td><?php echo count($data['cannum']); ?></td>
            </tr>
            <tr>
              <th style="width:50%">Total Voters:</th>
              <td><?php echo count($data['votenum']); ?></td>
            </tr>
            <tr>
              <th>Total Voters Voted:</th>
              <?php echo '<td>'.count($data['stud']).'</td>'; ?>
            </tr>
            <tr>
              <th>Didn't vote:</th>
              <td><?php  
                echo count($data['votenum']) - count($data['stud']). '<em>  (Total Voters - Total Voters Voted)';
              ?></td>
            </tr>
            <tr>
              <th>Total Votes: <em>(with non-winners)</em></th>
              <td><?php echo count($data['votes']) ?></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped table-bordered">
          <br>
          <hr class="bg-primary">
          <p><h2 class="text-center">LIST OF ALL CANDIDATES <em>(with votes)</em></h2></p>
          <thead>
          <tr>
            <th>Position</th>
            <th>Candidate Name</th>
            <th>Total Votes</th>
          </tr>
          </thead>
          <tbody>
            <?php
              $tally = 0;
              foreach ($data['winnersDesc'] as $winner) {
                echo '
                    <tr>
                      <td>'.$winner->description.'</td>
                      <td>'.$winner->canfirst.' '.$winner->canlast.'</td>
                      <td>'.$winner->total.'</td>
                    <tr>
                  ';
              }
              foreach ($data['winnersDesc'] as $votes) {
                $tally+=$votes->total;
              }
              echo '
                <tr>
                  <td colspan=2 class="text-right">Total Votes (overall)</td>
                  <td>'.$tally.'</td>
                </tr>
              ';
            ?>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
