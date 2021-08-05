<!-- jQuery -->
<script src="<?php echo URLROOT; ?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo URLROOT; ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo URLROOT; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<!-- BS-Stepper -->
<script src="<?php echo URLROOT; ?>/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo URLROOT; ?>/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo URLROOT; ?>/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo URLROOT; ?>/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo URLROOT; ?>/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo URLROOT; ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo URLROOT; ?>/plugins/moment/moment.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo URLROOT; ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo URLROOT; ?>/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo URLROOT; ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo URLROOT; ?>/plugins/iCheck/icheck.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo URLROOT; ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?php echo URLROOT; ?>/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo URLROOT; ?>/dist/js/adminlte.min.js"></script>
<script src="<?php echo URLROOT; ?>/dist/js/demo.js"></script>

<!-- Page specific script -->
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
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
<!-- Active Script -->
<script>
$(function(){
	/** add active class and stay opened when selected */
	var url = window.location;

	// for sidebar menu entirely but not cover treeview
	$('ul.nav-sidebar a').filter(function() {
	    return this.href == url;
	}).parent().addClass('active');

	// for treeview
	$('ul.treeview-menu a').filter(function() {
	    return this.href == url;
	}).parentsUntil(".nav-sidebar > .treeview-menu").addClass('active');

});
</script>
<!-- Data Table Initialize
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script> -->
<!-- Date and Timepicker -->
<script>
$(function(){
  //Date picker
  $('#datepicker_add').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })
  $('#datepicker_edit').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  }) 
});
</script>
<?php
  if(isset($data['success'])) {
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
          toast: true,
          position: "top-start",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer)
            toast.addEventListener("mouseleave", Swal.resumeTimer)
          }
        });
        Toast.fire({
          icon: "error",
          title: "' . $data['error'] . '"
        });
      </script>
    ';
    unset($data['error']);
  }
?>

