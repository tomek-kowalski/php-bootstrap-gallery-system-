<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php 
$message = "";
$user = new User();

    if(isset($_POST['create'])) {
    if($user) {
    $user->username           =    $_POST['username'];
    $user->first_name         =    $_POST['first_name'];
    $user->last_name          =    $_POST['last_name'];
    $user->password           =    $_POST['password'];
    $user->set_file($_FILES['user_image']);
    $user->save();
    $session->message("The user {$user->first_name} has been sucessfully added");
    redirect("users.php");
    }
}


?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
           
            <?php include("includes/top_nav.php"); ?>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

            <?php include("includes/side_nav.php"); ?>
            
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

        <div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-4 col-md-offset-4">
        <h1 class="page-header">
            Users
            <small>Subheading</small>
        </h1>
    </div>  
</div>

<div class="row">
<div class="col-md-4 col-md-offset-4">
<form action="" method="post" enctype="multipart/form-data" >

<div class="form-group">
<input type="file" name="user_image" class="form-control">
</div>


<div class="form-group">
<label class="bg-light text-info" for="username">Username</label>
<input type="text" name="username" class="form-control" required>
</div>


<div class="form-group">
<label class="bg-light text-info" for="first_name">First name</label>
<input type="text" name="first_name" class="form-control">
</div>

<div class="form-group">
<label class="bg-light text-info" for="last_name">Last name</label>
<input type="text" name="last_name" class="form-control">
</div>

<div class="form-group">
<label class="bg-light text-info" for="password">Password</label>
<input type="text" name="password" class="form-control" required>
</div>

<div class="form-group create-width">
    
<input type="submit" name="create" class="btn btn-primary pull-right">
</div>
</div><!--col-4-->



</form>  
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->      

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>