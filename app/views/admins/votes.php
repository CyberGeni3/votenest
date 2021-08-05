<?php require APPROOT . '/views/inc/admin/votes_header.php'; ?>
<body class="hold-transition sidebar-mini layout-fixed">
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
              <h1>Votes</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                <li class="breadcrumb-item active">Votes</li>
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
                  <h3 class="card-title">Votes table</h3>
                </div>
                <div class="card-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <!--<th class="hidden"></th> -->
                    <tr>
                      <th>Voter</th>
                      <th>Program</th>
                      <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach($data['getStudents'] as $row){
                          echo "
                            <tr>
                              <td>".$row->student_id."</td>
                              <td>".$row->program."</td>
                              <td>".$row->voted_on."</td>
                            </tr>
                          ";
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
</div>
<?php require APPROOT . '/views/inc/admin/votes_scripts.php'; ?>
</body>
</html>
