<?php require APPROOT . '/views/inc/login/header.php'; ?>
<body class="hold-transition login-page">
	<div class="login-box">
      <div class="card card-outline card-primary">
        <div class="card-header text-center bg-primary">
          <a href="#" class="h1"><b>Vote</b>Nest</a>
        </div>
    		<div class="card-body">
      		<p class="login-box-msg">Sign in to start voting</p>

      		<form action="<?php echo URLROOT; ?>/login" id="loginForm" method="POST" enctype="multipart/form-data">
              <input id="loginPic" type="hidden" name="loginPic" value=""/>
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
            				<button type="button" id="login" onclick="enableSnap(); enableMC();" class="btn btn-primary btn-block"><i class="fa fa-camera"></i> Photo</button>
          			</div>
        			</div>
              <!-- WEBCAM MODAL -->
              <div class="modal fade" id="opencam" data-backdrop="static"  data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content card-info">
                      <div id="overlay" class="overlay" style="display: none;">
                        <i class="fas fa-2x fa-sync fa-spin"></i>
                      </div>
                        <div class="modal-header">
                          <h4 class="modal-title"><b>Camera</b></h4>
                        </div>
                        <div class="modal-body">
                            <div id="my_camera" style="margin: auto; width: 50%;">
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-md-8 mx-auto">
                                <div id="pre_take_buttons" style="display: ">
                            <input class="btn btn-primary btn-block" id="snappy" type=button value="Take Snapshot" onClick="preview_snapshot(); enableVote(); disableMC();" disabled="false">
                          </div>
                          <div id="post_take_buttons" style="display:none">
                            <input class="btn btn-primary btn-block" type=button value="&lt; Take Another" onClick="cancel_preview(); disableVote(); enableMC();">
                          </div>
                              </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default btn-lg" id="modal_ender" data-dismiss="modal" onclick="Webcam.reset();" disabled><i class="fa fa-close"></i> Close</button>
                          <button type="submit" class="btn btn-primary btn-lg text-center" id="botar" onClick="disableSnap(); save_photo(); disableMC(); disableSelf();document.getElementById('overlay').style.display='';" disabled><i class="fas fa-sign-in-alt"></i>Sign In</button>
                        </div>
                    </div>
                </div>
              </div>
      		</form>
    		</div>      
  </div>
</div>
<?php require APPROOT . '/views/inc/login/scripts.php'; ?>

</body>
</html>
