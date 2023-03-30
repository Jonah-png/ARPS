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
<div style="
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 3px solid;
        border-radius: 20px;
        height: 200px;
        width: 320px;
        margin: 200px auto;
        ">
  <form method="post" style="text-align: center;">
    <h2>Login</h2>
    <?php if (isset($msg)) { ?>
      <div><?php echo $msg; ?></div>
    <?php } ?>
    <input style="display: block; margin: 5px" type="text" name="username" autocomplete="username" placeholder="username" />
    <input style="display: block; margin: 5px" type="password" name="password" autocomplete="current-password" placeholder="password" />
    <input name="Submit" type="submit" value="Login">
  </form>
</div>