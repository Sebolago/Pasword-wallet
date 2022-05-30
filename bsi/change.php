<?php include('server.php');

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Change Password</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Change password</h2>
  </div>
	
  <form method="post" action="change.php">
  	
  	<div class="input-group">
  	  <label>Old password</label>
  	  <input type="password" name="password_old">
  	</div>
      <div class="input-group">
  	  <label>New password</label>
  	  <input type="password" name="password_new">
  	</div>
      
  	
  	<div class="input-group">
  	  <button type="submit" class="btn" name="change_pass">Change password</button>
  	</div>
  	<p>
  		 <a href="index.php">Go back</a>
  	</p>
  </form>
</body>
</html>