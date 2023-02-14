<?php
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  include 'dbconnect.php';
  $fname = $_POST["fname"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $phonenumber = $_POST["phonenumber"];
  $password = $_POST["password"];
  $cpassword = $_POST["cpassword"];
  $gender = $_POST["gender"];



  $existSql = "SELECT * FROM `users` WHERE `username` =  '$username'";
  $result = mysqli_query($conn, $existSql);
  $numExistRows = mysqli_num_rows($result);

  $existSql2 = "SELECT * FROM `users` WHERE `email` =  '$email'";
  $result2 = mysqli_query($conn, $existSql2);
  $numExistRows2 = mysqli_num_rows($result2);

  $existSql3 = "SELECT * FROM `users` WHERE `phonenumber` =  '$phonenumber'";
  $result3 = mysqli_query($conn, $existSql3);
  $numExistRows3 = mysqli_num_rows($result3);

  if ($numExistRows > 0 || $numExistRows2 > 0 || $numExistRows3 > 0) {
    $showError = 'Username/Email/Phone Number already exists';
  } 
  else {
    if (($password == $cpassword)) {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users(fname,username,email,phonenumber,password,gender) VALUES('$fname','$username','$email',$phonenumber,'$hash','$gender');";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        $showAlert = true;
      }
    } else {
      $showError = "Passwords do not match";
    }
  }
}
?>
<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>Sign Up here</title>
  <link rel="stylesheet" href="signup.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php require 'navbar.php' ?>


</head>

<body>




  <?php
  if ($showAlert) {
    echo ('<div class="alert alert-success alert-dismissible fade show my-4" role="alert">
      <strong>Success!</strong> You can login now.
      
    </div>');
  }

  if ($showError) {
    echo ('<div class="alert alert-danger alert-dismissible fade show my-4" role="alert">
      <strong></strong> ' . $showError . '
      
    </div>');
  }

  ?>


  <div class="center">
    <form action="signup.php" method="post">
      <div class="form-header">

        <h1>Sign Up Here</h1>
      </div>
      <div class="user-details">
        <div class="txt_field">

          <input type="text" id="fname" maxlength="30" minlength="3" name="fname" required />
          <label>Fullname</label>
        </div>

        <div class="txt_field">
        
          <input type="text" id="username" maxlength="15" minlength="5" name="username"  required />
          <label>Username</label>
        </div>

        <div class="txt_field">
        
          <input type="email" id="email" name="email" maxlength="30"  required />
          <label>E-mail</label>
        </div>
        <div class="txt_field">
          
          <input type="tel" id="phonenumber" name="phonenumber" maxlength="11" minlength="10" required />
          <label>Phone Number</label>
        </div>
        <div class="txt_field">
          
          <input type="password" id="password" minlength="8" maxlength="20" name="password" required />
          <label>Password</label>
        </div>
        <div class="txt_field">
          
          <input type="password" id="cpassword" minlength="8" maxlength="20" name="cpassword" required />
          <label>Confirm Password</label>
        </div>
      </div>

      <div class="gender-details">
        <input type="radio" name="gender" value="Male" id="dot-1" required/>
        <input type="radio" name="gender" value="Female" id="dot-2" />
        <input type="radio" name="gender" value="Nil" id="dot-3" />
        <span class="gender-title">Gender</span>
        <div class="category">
          <label for="dot-1">
            <span class="dot one"></span>
            <span class="gender">Male</span>
          </label>
          <label for="dot-2">
            <span class="dot two"></span>
            <span class="gender">Female</span>
          </label>
          <label for="dot-3">
            <span class="dot three"></span>
            <span class="gender">Prefer not to say</span>
          </label>
        </div>
      </div>
      <div class="button">
        <button onclick=validateForm()>Sign Up</button>
      </div>
      <div class="btn2">
        <a href="login.php">Already have a account?</a>
      </div>
    </form>
  </div>


  <?php require 'footer.php' ?>
</body>
<script> 
function validateForm() {
  let x = document.forms["myForm"]["fname"].value;
  if (x == "") {
    alert("Name must be filled out");
    return false;
  }
}
</script>

</html>