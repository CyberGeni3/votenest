<!-- jQuery -->
<script src="<?php echo URLROOT; ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo URLROOT; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo URLROOT; ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo URLROOT; ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo URLROOT; ?>/dist/js/adminlte.min.js"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
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
    var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
    document.getElementById('loginPic').value = raw_image_data;
    document.getElementById('loginForm').submit();
      
      // swap buttons back
      document.getElementById('pre_take_buttons').style.display = '';
      document.getElementById('post_take_buttons').style.display = 'none';
    });
    Webcam.reset();
  }
  function disablesubmit() {
    document.getElementById("closesub").disabled = true;
  }
  function enableVote() {
    document.getElementById("botar").disabled = false;
  }
  function disableVote() {
    document.getElementById("botar").disabled = true;
  }

  function enableclose() {
    document.getElementById("closesub").disabled = false;
  }
  function disableSnap() {
    document.getElementById("snappy").disabled = true;
  }
  function enableSnap() {
    document.getElementById("snappy").disabled = false;
  }
  function enableMC() {
    document.getElementById("modal_ender").disabled = false;
  }
  function disableMC() {
    document.getElementById("modal_ender").disabled = true;
  }
  function disableSelf() {
    document.getElementById("botar").disabled = true;
  }

</script>
<script>
  $(function(){
     $('#login').click(function(e){
    e.preventDefault();
    var form = $('#loginForm').serialize();
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
            title: 'Form is empty',
          });
    }
    else{
      $.ajax({
        type: 'POST',
        url: '<?php echo URLROOT; ?>/login/logValidator',
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
            position: 'top-end',
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
<?php
  if(!empty($data['voter_id_err'])) {
    echo '
      <script>
        var Toast = Swal.mixin({
          toast: true,
          position: "top-end",
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
          title: "' . $data['voter_id_err'] . '"
        });
      </script>
    ';
  }
  elseif(!empty($data['password_err'])) {
    echo '
      <script>
        var Toast = Swal.mixin({
          toast: true,
          position: "top-end",
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
          title: "' . $data['password_err'] . '"
        });
      </script>
    ';
  }
  elseif(!empty($data['error'])) {
    echo '
      <script>
        var Toast = Swal.mixin({
          toast: true,
          position: "top-end",
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
  }
  elseif(!empty($data['admin_err'])) {
    echo '
      <script>
        var Toast = Swal.mixin({
          toast: true,
          position: "top-end",
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
          title: "' . $data['admin_err'] . '"
        });
      </script>
    ';
  }
?>