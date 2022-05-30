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
<style>
    table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding:4px;
}
</style>
<head>
  <title>Adding pasword to wallet</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Add new login data</h2>
  </div>
	
  <form method="post" action="add.php">
  	  	
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="passworda">
  	</div>
    <div class="input-group">
  		<label>Web adress</label>
  		<input type="text" name="web" >
  	</div>
    <div class="input-group">
  		<label>Descryption</label>
  		<input type="text" name="descryption" >
  	</div>
    <div class="input-group">
  	  <label>Login</label>
  	  <input type="text" name="login" value="<?php echo $username; ?>">
  	</div>    
  	
  	<div class="input-group">
  	  <button type="submit" class="btn" name="add_pass">Add password</button>
  	</div><br>
      <div class="input-group">
  	  <button type="submit" class="btn" name="show">Show saved</button>
  	</div><br>
      <div class="input-group">
  		<label>To show saved password input master password</label><br>
  		<input type="password" name="dec_pass" >
  	</div>
      </div>
      <div class="input-group">
  	  <button type="submit" class="btn" name="show_pass">Show pass</button>
  	</div>
  	<p>
  		Return to <a href="index.php">Home page</a>
  	</p>

  </form>
</body>
</html>