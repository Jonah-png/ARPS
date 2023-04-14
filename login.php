<?php session_start();
if (isset($_POST['Submit'])) {
  // gets the username and password from the login form
  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  // reads the hashed password from the file
  $file = file_get_contents("secure/login.txt");
  $lines = explode("\n", $file);
  if (trim($lines[0]) === $username and password_verify($password, $lines[1])) {
    // sets session variables and redirects to UI
    $_SESSION['UserData']['Username'] = $lines[1];
    header("location:professorUI.php");
    exit;
  } else {
    $msg = "<span style='color:red'>Invalid Login Details</span>";
  }

  // // code if username and password need to be changed
  // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  // $file = fopen("secure/login.txt", "a");
  // fwrite($file, $username . "\n" . $hashedPassword);
  // fclose($file);
}
?>

<!--Reference: https://www.youtube.com/watch?v=p1GmFCGuVjw&t=4s&ab_channel=Codehal-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div class="page">
    <header>
      <div class="logo">
        <a href="navbar.html"><img id="logo" src="assets/logo.png" alt="Logo"></a>
      </div>
    </header>
  </div>
  <div class="login-page">
    <div class="login-box">
      <h2>Login</h2>
      <form method="post" style="text-align: center;">

        <?php if (isset($msg)) { ?>
          <div><?php echo $msg; ?></div>
        <?php } ?>
        <div class="login-req">
          <span class="icon"><ion-icon name="mail"></ion-icon></span>
          <input type="text" name="username" />
          <label>Username</label>
        </div>
        <div class="login-req">
          <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
          <input type="password" name="password" />
          <label>Password</label>
        </div>
        <button name="Submit" type="submit" class="login-btn" value="Login">Login</button>
      </form>
    </div>
  </div>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>