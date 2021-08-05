<?php require APPROOT . '/views/inc/login/mobileheader.php'; ?>
<body class="hold-transition login-page">
	<div class="login-box">
      <div class="card card-outline card-primary">
        <div class="card-header text-center bg-primary">
          <a href="#" class="h1"><b>Vote</b>Nest</a>
        </div>
    		<div class="card-body">
      		<p class="login-box-msg">Sign in to start voting</p>

      		<form action="<?php echo URLROOT; ?>/login/mobile" id="loginForm" method="POST" enctype="multipart/form-data">
        			<div class="input-group mb-3">
          			<input type="text" class="form-control" name="voter" placeholder="Voter's ID" value="<?php echo $data['voter_id']; ?>">
          			<div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
        			</div>
            		<div class="input-group mb-3">
              		<input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo $data['password']; ?>">
              		<div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
            		</div>
        			<div class="row">
      				<div class="col-4">
            				<button type="button" id="login" class="btn btn-primary btn-block"><i class="fa fa-camera"></i> Photo</button>
          			</div>
        			</div>
              <div class="modal fade" id="mobilelog" data-backdrop="static"  data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content card-info">
                      <div id="overlay" class="overlay" style="display: none;">
                        <i class="fas fa-2x fa-sync fa-spin"></i>
                    </div>
                        <div class="modal-header">
                          <h4 class="modal-title"><b>Open Mobile Camera</b></h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                              <div class="col-md-8 mx-auto">
                                <div class="custom-file">
                                  <input class="custom-file-input" id="filename" type="file" name="photo" accept="image/*" capture>
                                  <label class="custom-file-label" for="filename">Click here to open camera</label>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-secondary" id="close_modal" data-dismiss="modal" value="Close"><i class="fa fa-times"></i> Close</button>
                          <button type="submit" class="btn btn-primary" id="botar_vote" onclick="enableOverlay();"><i class="fa fa-sign-in-alt"></i> Sign In</button>
                        </div>
                    </div>
                </div>
              </div>
      		</form>
    		</div>      
  </div>
</div>
<?php require APPROOT . '/views/inc/login/mobilescripts.php'; ?>
<script>
$(document).ready(
    function(){
        $('#botar_vote').attr('disabled',true);
        $('#filename').change(
            function(){
                if ($(this).val()){
                    $('#botar_vote').removeAttr('disabled'); 
                }
                else {
                    $('#botar_vote').attr('disabled',true);
                }
            });
});
</script>
<script>
  function enableOverlay() {
    document.getElementById('overlay').style.display = '';
  }
</script>
</body>
</html>
