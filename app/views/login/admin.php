<?php require APPROOT . '/views/inc/login/header.php'; ?>
<body class="hold-transition login-page">
	<div class="login-box">
      <div class="card card-outline card-primary">
        <div class="card-header text-center bg-primary">
          <a href="#" class="h1"><b>VoteNest</b> Admin</a>
        </div>
    		<div class="card-body">
      		<p class="login-box-msg">Sign in to start voting</p>

      		<form action="<?php echo URLROOT; ?>/login/admin" method="POST">
        			<div class="input-group mb-3">
          			<input type="text" class="form-control" name="admin" placeholder="Admin username" value="<?php echo $data['admin']; ?>">
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
            				<button type="submit" id="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in"></i> Sign In</button>
          			</div>
        			</div>
      		</form>
    		</div>      
  </div>
</div>
<?php require APPROOT . '/views/inc/login/scripts.php'; ?>

</body>
</html>
