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
              <h1>Candidates List</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                <li class="breadcrumb-item active">Candidates</li>
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
                    <th>Position</th>
                    <th>Photo</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Tools</th>
                  </thead>
                  <tbody>
                    <?php
                      foreach($data['getCanFromPos'] as $row){
                        $image = (!empty($row->photo)) ? URLROOT . '/images/candidates/'.$row->photo : URLROOT . '/images/profile.jpg';
                        echo "
                          <tr>
                            <td>".$row->description."</td>
                            <td>
                              <img src='".$image."' width='30px' height='30px'>
                              <a href='#edit_photo' data-toggle='modal' class='pull-right photo' data-id='".$row->canid."'><span class='fa fa-edit'></span></a>
                            </td>
                            <td>".$row->firstname."</td>

                            <td>".$row->lastname."</td>
                            <td>
                              <ul>
                                <li style='list-style: none;'>
                                  <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row->canid."'><i class='fa fa-edit'></i> Edit</button>
                                  <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row->canid."'><i class='fa fa-trash'></i> Delete</button>
                                  <a href='".URLROOT."/pdf/candidate-coc/".strtolower(str_replace(' ','_',$row->firstname))."_".strtolower(str_replace(' ','_',$row->lastname)).".pdf' class='btn btn-primary btn-sm generate btn-flat' target='_blank'><i class='fa fa-certificate'></i> Certificate</a>
                                </li>
                              </ul>
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
  <?php require APPROOT . '/views/inc/admin/candidates_modal.php'; ?>
</div>
<?php require APPROOT . '/views/inc/admin/voter_scripts.php'; ?>
<?php flash('candidate_success'); ?>
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

  $(document).on('click', '.platform', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: '<?php echo URLROOT; ?>/candidates/canrow',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.id').val(response.canid);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#edit_student_id').val(response.student_id);
      $('#posselect').val(response.position_id).html(response.description);      
      $('#edit_platform').val(response.platform);
      $('.fullname').html(response.firstname+' '+response.lastname);
      $('#desc').html(response.platform);
    }
  });
}
</script>
<script>
  $('.yearpicker').yearpicker();
  $('.yearpicker1').yearpicker();

  function getAge() {
    var dob = document.getElementById('birthdate').value;
    var today = new Date();
    var birthDate = new Date(dob);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    document.getElementById('age').value=age;
  }
</script>
</body>
</html>
