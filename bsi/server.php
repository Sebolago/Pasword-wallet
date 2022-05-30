<?php
session_start();

// initializing variables
$username = "";
global $id ;
global $password ;
$errors = array(); 


$ciphering = "AES-128-CTR";      
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
$encryption_iv = $decryption_iv = '1234567891011121';

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'wallet');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $isHash = mysqli_real_escape_string($db, $_POST['kod']);
 
  echo $username, $password_1, $isHash;

    
    if($isHash) $password = hash('sha512',('pepper'.'salt'.$password_1));
    else 	$password = hash_hmac('sha256', $password_1, 'salt');

  	$query = "INSERT INTO users (username,isHash, password) 
  			  VALUES('$username','$isHash', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  


    $query = "SELECT id, isHash FROM users WHERE username='$username'";
    $results = mysqli_query($db, $query);
    $row = mysqli_fetch_array($results);
    $isHash = $row['isHash'];
    $id= $row['id'];
    
    $_SESSION['password']= $password;
    $_SESSION['id'] =$id;

    if(strcmp($isHash,'1')==0){
        $passwordd = hash('sha512', ('pepper'.'salt'.$password));
    } 
    else {	
        $passwordd = hash_hmac('sha256', $password, 'salt');
    }
    
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$passwordd'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;
        $_SESSION['password']= $password;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  
}

// ADD PASSWORD
if (isset($_POST['add_pass'])) {
    // receive all input values from the form
    $passworda = mysqli_real_escape_string($db, $_POST['passworda']);
    $web = mysqli_real_escape_string($db, $_POST['web']);
    $descryption = mysqli_real_escape_string($db, $_POST['descryption']);
    $login = mysqli_real_escape_string($db, $_POST['login']);
    $id= $_SESSION['id'];
      

        $encryption_key = $decryption_key = $_SESSION['password'];
        
        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($passworda, $ciphering,
                    $encryption_key, $options, $encryption_iv);
                    
      
        $query = "INSERT INTO password (password, id_user, web_adress, descryption, login) 
                  VALUES('$encryption', $id, '$web', '$descryption', '$login')";   
        mysqli_query($db, $query);
        
        echo "<h4>Password added</h4>"; 
        //header('location: index.php');
    

        
  

  }
  // Display login data without password
  if (isset($_POST['show'])) {
    $id= $_SESSION['id'];
    $query = "SELECT login, web_adress, descryption FROM password WHERE id_user=$id";
    $results = mysqli_query($db, $query);
   
    echo "<h3> Saved login data </h3>" ;
    echo "<table>"; // start a table tag in the HTML

    echo "<tr><td> Login </td><td> Web adress </td><td> Descryption </td></tr>";

    while($row = mysqli_fetch_array($results)){   //Creates a loop to loop through results
    echo "<tr><td>" . $row['login'] . "</td><td>" . $row['web_adress'] . "</td><td>" . $row['descryption'] . "</td></tr>";  //$row['index'] the index here is a field name
    }
    
    echo "</table>"; 

  }
  // Display login data with password
  if (isset($_POST['show_pass'])) {
    $decryption_key = mysqli_real_escape_string($db, $_POST['dec_pass']);
    if (!empty($decryption_key)) {

        $id= $_SESSION['id'];
        $query = "SELECT login, web_adress, descryption, password FROM password WHERE id_user=$id";
        $results = mysqli_query($db, $query);
        
        echo "<h3> Saved login data with passwords </h3>" ;
        echo "<table>"; // start a table tag in the HTML

        echo "<tr><td> Login </td><td> Web adress </td><td> Descryption </td><td> Password </td></tr>";

        while($row = mysqli_fetch_array($results)){   //Creates a loop to loop through results
            $pass_to_show=openssl_decrypt ($row['password'], $ciphering, $decryption_key, $options, $decryption_iv);
        echo "<tr><td>" . $row['login'] . "</td><td>" . $row['web_adress'] . "</td>
        <td>" . $row['descryption'] . "</td><td>" . $pass_to_show . "</td></tr>";  //$row['index'] the index here is a field name
        }
        
        echo "</table>"; 
    }
    else echo "<h3> Please input master password to show passwords</h3> ";

  }
  //CHANGE PASSWORD
  if (isset($_POST['change_pass'])) {
    $oldp = mysqli_real_escape_string($db, $_POST['password_old']);
    $newp = mysqli_real_escape_string($db, $_POST['password_new']);
    $id_u= $_SESSION['id'];
    $_SESSION['password']=
  
  
      $query = "SELECT isHash FROM users WHERE id=$id_u";
      $results = mysqli_query($db, $query);
      $row = mysqli_fetch_array($results);
      $isHash = $row['isHash'];

  
      if(strcmp($isHash,'1')==0){
          $old = hash('sha512', ('pepper'.'salt'.$oldp));
          $new = hash('sha512', ('pepper'.'salt'.$newp));
      } 
      else {	
          $old = hash_hmac('sha256', $oldp, 'salt');
          $new = hash_hmac('sha256', $newp, 'salt');
      }
       // echo $isHash. "<br>". $id."<br>" .$old. "<br> " .$new;
        $query = "SELECT * FROM users WHERE id=$id_u AND password='$old'";
        $results = mysqli_query($db, $query);
            if (mysqli_num_rows($results) == 1) {
                $query = "UPDATE users SET password = '$new'  WHERE id = $id_u;";
                mysqli_query($db, $query);
                $_SESSION['password']=$newp;

                // changing key of passwords in wallet
                $query = "SELECT id, password FROM password WHERE id_user=$id_u";
                $results = mysqli_query($db, $query);
                $decryption_key=$oldp;
                $encryption_key=$newp;
                while($row = mysqli_fetch_array($results)){   //Creates a loop to loop through results
                    $pass_decoded=openssl_decrypt ($row['password'], $ciphering, $decryption_key, $options, $decryption_iv);
                    $pass_encoded= openssl_encrypt($pass_decoded, $ciphering,$encryption_key, $options, $encryption_iv);
                    $id_p=$row['id'];
                    $udt = "UPDATE password SET password = '$pass_encoded'  WHERE id_user = $id_u AND id = $id_p;";
                    mysqli_query($db,$udt);
                }


                $_SESSION['success'] = "Password changed";
                header('location: index.php');
        }else {
            echo "<h4>Wrong password combination</h4>";
        }
    
  }

?>
