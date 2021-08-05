<!-- jQuery -->
<script src="<?php echo URLROOT; ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo URLROOT; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- InputMask -->
<script src="<?php echo URLROOT; ?>/plugins/moment/moment.min.js"></script>
<!-- date-range-picker -->
<script src="<?php echo URLROOT; ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo URLROOT; ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo URLROOT; ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- DataTables -->
<script src="<?php echo URLROOT; ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo URLROOT; ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo URLROOT; ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo URLROOT; ?>/bower_components/fastclick/lib/fastclick.js"></script>
<!-- Data Table Initialize -->
<!-- AdminLTE App -->
<script src="<?php echo URLROOT; ?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo URLROOT; ?>/dist/js/demo.js"></script>
<script language="JavaScript">
    function preview_snapshot() {
      // freeze camera so user can preview pic
      Webcam.freeze();
      
      // swap button sets
      document.getElementById('pre_take_buttons').style.display = 'none';
      document.getElementById('post_take_buttons').style.display = '';
    }
    
    function cancel_preview() {
      // cancel preview freeze and return to live camera feed
      Webcam.unfreeze();
      
      // swap buttons back
      document.getElementById('pre_take_buttons').style.display = '';
      document.getElementById('post_take_buttons').style.display = 'none';
    }
    
    function save_photo() {
      // actually snap photo (from preview freeze) and display it
      Webcam.snap( function(data_uri) {
        Webcam.upload(data_uri, '<?php echo URLROOT; ?>/voters/saveimage', function(code, text) {} );
        
        // swap buttons back
        document.getElementById('pre_take_buttons').style.display = '';
        document.getElementById('post_take_buttons').style.display = 'none';
      });
      Webcam.reset();
    }
    function enableVote() {
      document.getElementById("botar").disabled = false;
    }
    function disableSnap() {
      document.getElementById("snappy").disabled = true;
    }
    function enableSnap() {
      document.getElementById("snappy").disabled = false;
    }
  </script>
<script>
  function take_snapshot() {
    // take snapshot and get image data
    Webcam.snap(function(data_uri) {
      // upload image to folder 
      Webcam.upload(data_uri, '<?php echo URLROOT; ?>/voters/saveimage', function(code, text) {} );  
    });
    Webcam.reset();
  }
</script>
<script>
  $(function () {
    $('#example1').DataTable()
    var bookTable = $('#booklist').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    })

    $('#searchBox').on('keyup', function(){
      bookTable.search(this.value).draw();
  });

  })
</script>
<script>
$(function(){
  $(document).on('click', '.reset', function(e){
      e.preventDefault();
      var desc = $(this).data('desc');
      $('.'+desc).iCheck('uncheck');
  });

  $(document).on('click', '.platform', function(e){
    e.preventDefault();
    $('#platform').modal('show');
    var platform = $(this).data('platform');
    var fullname = $(this).data('fullname');
    $('.candidate').html(fullname);
    $('#plat_view').html(platform);
  });

  $('#preview').click(function(e){
    e.preventDefault();
    var form = $('#ballotForm').serialize();
    if(form == ''){
      var Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });
          Toast.fire({
            icon: 'error',
            title: 'Choose at least one candidate',
          });
    }
    else{
      $.ajax({
        type: 'POST',
        url: '<?php echo URLROOT; ?>/voters/preview',
        data: form,
        dataType: 'json',
        success: function(response){
          if(response.error){
            var errmsg = '';
            var messages = response.message;
            for (i in messages) {
              errmsg += messages[i]; 
            }
            var Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            });
            Toast.fire({
              icon: 'error',
              title: errmsg,
            });
          }
          else{
            $('#preview_modal').modal('show');
            $('#preview_body').html(response.list);
          }
        }
      });
    }   
  });
});
</script>
<script>
  $(function(){
     $('#send').click(function(e){
    e.preventDefault();
    var form = $('#ballotForm').serialize();
    if(form == ''){
      var Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });
          Toast.fire({
            icon: 'error',
            title: 'Vote at least one candidate',
          });
    }
    else{
      $.ajax({
        type: 'POST',
        url: '<?php echo URLROOT; ?>/voters/maxvote',
        data: form,
        dataType: 'json',
        success: function(response){
          if(response.error){
            var errmsg = '';
            var messages = response.message;
            for (i in messages) {
              errmsg += messages[i]; 
            }
            var Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            });
            Toast.fire({
              icon: 'error',
              title: errmsg,
            });
          }
          else{
             $('#opencam').modal('show');
              Webcam.set({
                width: 320,
                height: 240,
                dest_width: 640,
                dest_height: 480,
                image_format: 'jpeg',
                jpeg_quality: 90,
                flip_horiz: true
              });
            Webcam.attach('#my_camera');
          }
        }
      });
    }   
  });
});
</script>
<script>
  $(function(){
     $('#sendi').click(function(e){
    e.preventDefault();
    var form = $('#ballotForm').serialize();
    if(form == ''){
      var Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });
          Toast.fire({
            icon: 'error',
            title: 'Vote at least one candidate',
          });
    }
    else{
      $.ajax({
        type: 'POST',
        url: '<?php echo URLROOT; ?>/voters/maxvote',
        data: form,
        dataType: 'json',
        success: function(response){
          if(response.error){
            var errmsg = '';
            var messages = response.message;
            for (i in messages) {
              errmsg += messages[i]; 
            }
            var Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            });
            Toast.fire({
              icon: 'error',
              title: errmsg,
            });
          }
          else{
             $('#openmobilecam').modal('show');
           }
        }
      });
    }   
  });
});
</script>
<script>
$(document).ready(
    function(){
        $('button:submit').attr('disabled',true);
        $('input:file').change(
            function(){
                if ($(this).val()){
                    $('button:submit').removeAttr('disabled'); 
                }
                else {
                    $('button:submit').attr('disabled',true);
                }
            });
});
</script>
