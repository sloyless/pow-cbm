<?php require_once('views/head.php'); ?>
  <title>Login to your Account :: POW! Comic Book Manager</title>
</head>
<body>
  <?php include 'views/header.php';?>
  <div class="container content">
    <div class="row">
      <div class="col-sm-12">
        <!-- login form box -->
        <h2>Log into your Account</h2>
        <form method="post" action="<?php echo filter_input ( INPUT_GET, 'return' ); ?>" name="loginform" class="form-inline">
        	<div class="form-group">
            <label for="login_input_username">Username</label>
          	<input id="login_input_username" class="login_input form-control" type="text" name="user_name" required />
          </div>
          <div class="form-group">
            <label for="login_input_password">Password</label>
            <input id="login_input_password" class="login_input form-control" type="password" name="user_password" autocomplete="off" required />
          </div>
        	<input type="submit" name="login" value="Log in" class="btn btn-default form-submit" />
        </form>
      </div>
    </div>
  </div>
  <?php include 'views/footer.php';?>

</body>
</html>