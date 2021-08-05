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
              <h1>Voters List</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                <li class="breadcrumb-item active">Voters</li>
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
                <a href="#addnew" data-toggle="modal" class="btn btn-app bg-info"><i class="fa fa-plus"></i> New</a>
              </div>
              <div class="card-body">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <th>Student ID</th>
                      <th>Name</th>
                      <th>Program</th>
                      <th>Photo</th>
                      <th>Voters ID</th>
                      <th>Status</th>
                      <th>Tools</th>
                    </thead>
                    <tbody>
                      <?php
                        $status = '';
                        foreach($data['getVoters'] as $row){
                          $image = (!empty($row->photo)) ? URLROOT . '/images/voter_faces/'.$row->photo : URLROOT . '/images/profile.jpg';
                          if ($row->statuses == 'Active') {
                            $status = "<span class='badge badge-success'>".$row->statuses."</span>";
                          }
                          else {
                            $status = "<span class='badge badge-danger'>".$row->statuses."</span>";
                          }
                          echo "
                            <tr>
                              <td>".$row->student_id."</td>
                              <td>".$row->firstname. '&nbsp;' .mb_substr($row->middlename, 0, 1, "UTF-8") .'.'.'&nbsp;' .$row->lastname."</td>
                              <td>".$row->program."</td>
                              <td>
                                <img src='".$image."' width='30px' height='30px'>
                              </td>
                              <td>".$row->voters_id."</td>
                              <td class='project-state'>".$status."</td>
                              <td>
                                <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row->id."'><i class='fa fa-edit'></i> Edit</button>
                                <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row->id."'><i class='fa fa-trash'></i> Delete</button>
                              </td>
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
  <?php require APPROOT . '/views/voter/modal.php'; ?>
</div>
<?php require APPROOT . '/views/inc/admin/voter_scripts.php'; ?>
<?php flash('voter_success'); ?>
<?php flash('admin_success'); ?>
<?php flash('admin_login_success'); ?>
<script>
$(function(){
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: '<?php echo URLROOT; ?>/voter/getrow',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.id').val(response.id);
      $('#edit_firstname').val(response.firstname);
      $('#edit_middlename').val(response.middlename);
      $('#edit_lastname').val(response.lastname);
      $('#edit_studentId').val(response.student_id);
      $('#edit_program').val(response.program);
      $('#new_email').val(response.email);
      $('.fullname').html(response.firstname+' '+response.lastname);
    }
  });
}
</script>
</body>
</html>
