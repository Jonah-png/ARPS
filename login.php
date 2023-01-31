<?php session_start();        
if(isset($_POST['Submit'])){
  // hard-coded
  $logins = array('username' => 'password');
  // make sure fields were set
  $Username = isset($_POST['Username']) ? $_POST['Username'] : '';
  $Password = isset($_POST['Password']) ? $_POST['Password'] : '';
              
  if (isset($logins[$Username]) && $logins[$Username] == $Password){
    // sets session variables and redirect to UI
    $_SESSION['UserData']['Username']=$logins[$Username];
    header("location:professorUI.php");
    exit;
  } else {
    $msg="<span style='color:red'>Invalid Login Details</span>";
  }
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
    <?php if(isset($msg)){?>
    <div><?php echo $msg;?></div>
    <?php } ?>
    <input
      style="display: block; margin: 5px"
      type="text"
      name="Username"
      autocomplete="username"
      placeholder="Username"
    />
    <input
      style="display: block; margin: 5px"
      type="password"
      name="Password"
      autocomplete="current-password"
      placeholder="password"
    />
    <input name="Submit" type="submit" value="Login">
  </form>
</div>