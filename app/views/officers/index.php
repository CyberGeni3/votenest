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
              <h1>Registration Officers</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                <li class="breadcrumb-item active">Registration Officers</li>
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
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th>Username</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Role</th>
                    <th>Photo</th>
                    <th>Tools</th>
                  </thead>
                  <tbody>
                    <?php
                      foreach($data['getOfficers'] as $row){
                        $image = (!empty($row->photo)) ? URLROOT . '/images/admin/'.$row->photo : URLROOT . '/images/profile.jpg';
                        echo "
                          <tr>
                            <td>".$row->username."</td>
                            <td>".$row->firstname."</td>
                            <td>".$row->lastname."</td>
                            <td>Registration Officer</td>
                            <td>
                              <img src='".$image."' width='30px' height='30px'>
                            </td>
                            <td>
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
  <?php require APPROOT . '/views/inc/admin/officer_modal.php'; ?>
</div>
<?php require APPROOT . '/views/inc/admin/voter_scripts.php'; ?>
<?php flash('officer_success'); ?>
<script>
$(function(){
  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: '<?php echo URLROOT; ?>/officers/offrow',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.id').val(response.id);
      $('.fullname').html(response.firstname+' '+response.lastname);
    }
  });
}
</script>
</body>
</html>
