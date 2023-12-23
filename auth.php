<?php
 // connect to the database
  $conn = mysqli_connect('localhost','raunak','raunak@php','users-php');
  // check connection status
  if(!$conn) {
    echo 'Connection failed: ' . mysqli_connect_error();
    exit();
  }
  session_start();
  if(isset($_POST['action']) && $_POST['action'] == 'signin') {
    $data = new stdClass();
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    // validate email and password
    if(!$email or !$password){
      $data->err = "Fields Cannot be Empty!";
      $data->status = 400;
      $myJSON = json_encode($data);
      echo $myJSON;
      exit();
    }
    
    // verify unique email
    $verify_query = mysqli_query($conn, "select * from users where email='$email'");
    if(mysqli_num_rows($verify_query) == 0) {
      $data->err = "Incorrect Credentials!";
      $data->status = 400;
      $myJSON = json_encode($data);
      echo $myJSON;
    } else {
      $row = mysqli_fetch_assoc($verify_query);
      if(!password_verify($password, $row['password'])) {
        $data->err = "Incorrect Password!";
        $data->status = 400;
        $myJSON = json_encode($data);
        echo $myJSON;
      }else {
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        $data->success = "Successfully Signed in!";
        $data->status = 200;
        $myJSON = json_encode($data);
        echo $myJSON;
      }
    }
  } else if(isset($_POST['action']) && $_POST['action'] == 'signup') {
    $data = new stdClass();
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $confirmPassword = mysqli_real_escape_string($conn, trim($_POST['cnfpassword']));

    // validate email and password
    if(!$name or !$email or !$password or !$confirmPassword) {
      $data->err = "Fields Cannot be Empty!";
      $data->status = 400;
      $myJSON = json_encode($data);
      echo $myJSON;
      exit();
    }

    // verify unique email
    $verify_query = mysqli_query($conn, "select email from users where email='$email'");
    if(mysqli_num_rows($verify_query) != 0) {
      $data->err = "Email already registered!";
      $data->status = 400;
      $myJSON = json_encode($data);
      echo $myJSON;
      exit();
    } elseif(strlen($password)<8) {
      $data->err = "Password must be at least 8 characters!";
      $data->status = 400;
      $myJSON = json_encode($data);
      echo $myJSON;
      exit();
    } elseif($password !== $confirmPassword) {
      $data->err = "Passwords not matching!";
      $data->status = 400;
      $myJSON = json_encode($data);
      echo $myJSON;
      exit();
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      mysqli_query($conn, "insert into users(name, email, password) values('$name', '$email', '$hash')");
      $_SESSION["name"] = $name;
      $_SESSION["email"] = $email;
      $data->success = "Successfully Signed up!";
      $data->status = 200;
      $myJSON = json_encode($data);
      echo $myJSON;
    }
  }
?>