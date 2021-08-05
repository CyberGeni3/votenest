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
             $('#mobilelog').modal('show');
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
?>