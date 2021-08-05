<!-- jQuery -->
<script src="<?php echo URLROOT; ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo URLROOT; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo URLROOT; ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo URLROOT; ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo URLROOT; ?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo URLROOT; ?>/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script>
  function showStart() {
    document.getElementById('end').style.display = 'none';
    document.getElementById('start').style.display = '';
    localStorage.setItem('show', 'true');
  }
  function showEnd() {
    document.getElementById('start').style.display = 'none';
    document.getElementById('end').style.display = '';
    localStorage.setItem('show', 'false');
  }
</script>
<script>
  window.onload = function() {
    var show = localStorage.getItem('show');
    if(show === 'true'){
      document.getElementById('end').style.display = 'none';
      document.getElementById('start').style.display = '';
    }
    else {
      document.getElementById('start').style.display = 'none';
      document.getElementById('end').style.display = '';
    }
}
</script>
<?php
  if(!empty($data['success'])) {
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
          icon: "success",
          title: "' . $data['success'] . '"
        });
      </script>
    ';
    unset($data['success']);
  }
  if(!empty($data['error'])) {
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
            title: "'.$data['error'].'"
          });
        </script>
      ';
      unset($data['error']);
    }
?>