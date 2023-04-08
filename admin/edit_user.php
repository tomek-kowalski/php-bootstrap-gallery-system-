<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>
<?php include("includes/photo_library_modal.php"); ?>

<?php 
//$message = "";

if(empty($_GET['id'])) {
    redirect("users.php");    
} else {

    $user = User::find_by_id($_GET['id']);

    if(isset($_POST['update'])) {
    if($user) {
    $user->username           =    $_POST['username'];
    $user->first_name         =    $_POST['first_name'];
    $user->last_name          =    $_POST['last_name'];
    $user->password           =    $_POST['password'];

    if(empty($_FILES['user_image'])) {

    $user->save(); 
        //$message = join($user->errors);
    $session->message("The user has been sucessfully updated");
    redirect("users.php");
    } else {   

    $user->update_file($_FILES['user_image']);

    $user->upload_photo();

    $user->save();
    
    $session->message("The user has been sucessfully edited");
    redirect("users.php");
    //$message = "The user was sucessfully edited";
    
    } 
    }
}

}

//add modal 




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
        <?php //echo $message; ?>
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

<dic class="col-md-4 user_image_box">

<a href="#" data-toggle="modal" data-target="#photo-modal" ><img class="img-responsive center-block image_size" src="<?php echo $user->image_path_and_placeholder(); ?>" alt=""></a>

</dic>

<div class="col-md-4">
<form action="" method="post" enctype="multipart/form-data" >

<div class="form-group">
<input type="file" name="user_image" class="form-control">
</div>


<div class="form-group">
<label class="bg-light text-info" for="username">Username</label>
<input type="text" name="username" class="form-control" autocomplete="false" value="<?php echo $user->username; ?>">
</div>


<div class="form-group">
<label class="bg-light text-info" for="first_name">First name</label>
<input type="text" name="first_name" class="form-control" value="<?php echo $user->first_name; ?>">
</div>

<div class="form-group">
<label class="bg-light text-info" for="last_name">Last name</label>
<input type="text" name="last_name" class="form-control" value="<?php echo $user->last_name; ?>">
</div>

<div class="form-group">
<label class="bg-light text-info" for="password">Password</label>
<input type="password" name="password" class="form-control" autocomplete="false" value="<?php echo $user->password; ?>">
</div>

<div class="form-group create-width">

<a id="user_id" class="btn btn-danger" href="delete_user.php?id=<?php echo $user->id; ?>">Delete</a>
<input type="submit" name="update" class="btn btn-primary pull-right" value="Update">
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

