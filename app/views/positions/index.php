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
              <h1>Positions</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                <li class="breadcrumb-item active">Positions</li>
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
                <table id="example2" class="table table-bordered">
                  <thead>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Maximum Vote</th>
                    <th>Tools</th>
                  </thead>
                  <tbody>
                    <?php
                      foreach($data['getPositions'] as $row){
                        echo "
                          <tr>                            
                            <td>".$row->description."</td>
                            <td>".$row->priority."</td>
                            <td>".$row->max_vote."</td>
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
  <?php require APPROOT . '/views/inc/admin/positions_modal.php'; ?>
</div>
<?php require APPROOT . '/views/inc/admin/votes_scripts.php'; ?>
<?php flash('position_success'); ?>
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

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: '<?php echo URLROOT; ?>/positions/posrow',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.id').val(response.id);
      $('#edit_description').val(response.description);
      $('#edit_max_vote').val(response.max_vote);
      $('#edit_priority').val(response.priority);
      $('.description').html(response.description);
    }
  });
}
</script>
</body>
</html>
