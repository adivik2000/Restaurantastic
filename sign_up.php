<?php
  include('includes/bootstrap.php');
  
  if(is_signed_in()) {
    set_notice("You can't sign up while signed in. Sign out and try again.");
    // Already signed in, can't sign up while logged in
    redirect_to(Config::get()->signed_in_page());
    exit;
  }
  elseif(isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm'])) {
    if($_POST['password'] != $_POST['confirm']) {
      set_notice("Password confirmation failed, retype your password and try again.");
    }
    else {
      $user = new User;
      if($user->create_new($_POST['email'], $_POST['password'], $_POST['name'])) {
        redirect_to("sign_in.php");
      }
      else{
        // Make sure there's no old data in post when we print the form
        $_POST = array();
      }
    }
    set_notice("You didn't fill out the whole form, please make sure you fill out everything!");
  }
  
  $title = "Sign up";
  include("includes/top.php");
?>

<form action="" method="post">
  <fieldset class="sign_form">
    <legend>Sign up</legend>
    <label for="email">Email: </label>
    <input name="email" type="text" id="email" value="<?php echo $_POST['email']; ?>" /><br />
    <label for="name">Name: </label>
    <input name="name" type="text" id="name" value="<?php echo $_POST['name']; ?>" /><br />
    <label for="password">Password: </label>
    <input name="password" type="password" id="password" /><br />
    <label for="confirm">Confirm: </label>
    <input name="confirm" type="password" id="confirm" /><br />
    <input name="submit" type="submit" class="button" id="submit" value="Sign up!" />
  </fieldset>
</form>

<?php
  include("includes/bottom.php");
?>