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
<script src="<?php echo URLROOT; ?>/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="<?php echo URLROOT; ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Select2 -->
<script src="<?php echo URLROOT; ?>/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo URLROOT; ?>/plugins/yearpicker/dist/yearpicker.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo URLROOT; ?>/plugins/sweetalert2/sweetalert2.min.js"></script>

<!-- bs-custom-file-input -->
<script src="<?php echo URLROOT; ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo URLROOT; ?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo URLROOT; ?>/dist/js/demo.js"></script>
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
      document.getElementById('voterPic').value = raw_image_data;
      document.getElementById('newVoter').submit();
        
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
     $('#takepic').click(function(e){
    e.preventDefault();
    var form = $('#newVoter').serialize();
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
        url: '<?php echo URLROOT; ?>/voter/formchecker',
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
            $('#addnew').modal('hide');
          }
        }
      });
    }   
  });
});
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "colvis"]
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
<?php
  if(!empty($data['success'])) {
    echo '
      <script>
        var Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 5000,
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
  }
  if(!empty($data['error'])) {
    echo '
      <script>
        var Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer)
            toast.addEventListener("mouseleave", Swal.resumeTimer)
          }
          });
          Toast.fire({
            icon: "error",
            title: "'. $data['error'] .'"
          });
      </script>
    ';
  }
?>