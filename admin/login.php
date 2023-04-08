<?php

require_once("includes/header.php");

?>
<?php



if($session->is_signed_in()) {

redirect("index.php");
}


$the_message = "";

if(isset($_POST["submit"])) {
    if((!empty($_POST['username']) && !empty($_POST['password']))) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        $found_user = User::verify_user($username, $password);

            if($found_user) {

            $session->login($found_user);
            redirect("index.php");
            
            } 

            else {
            $the_message = "Your Username or Password are incorrect";    
            }
    }
    else { 
    
        $the_message = "Username or Password fields are required";  

    }        
}


?>
<div class="col-md-4 col-md-offset-3">

<h4 class="bg-danger"><?php 

echo $the_message;?></h4>
	
<form id="login-id" action="" method="post">
	
<div class="form-group">
	<label for="username">Username</label>
	<input type="text" class="form-control" name="username" value="<?php if(!empty($username)) {echo htmlentities($username);} ?>" >

</div>

<div class="form-group">
	<label for="password">Password</label>
	<input type="password" class="form-control" name="password" autocomplete="on" value="<?php if(!empty($password)) {echo htmlentities($password);} ?>">
	
</div>


<div class="form-group">
<input type="submit" name="submit" value="Submit" class="btn btn-primary">

</div>


</form>


</div>