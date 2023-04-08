<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php 

$message = "";

if(isset($_FILES["file"])) {

$photo = new Photo;
$photo->user_id = $_SESSION['user_id'];
$photo->title = $_POST['title'];
$photo->set_file($_FILES['file']); 

if($photo->save()) {
    redirect("photos.php");
    $session->message("The photo {$photo->filename}, has been sucessfully added");

} else {
    
   $messages =  $photo->errors;
   foreach($messages as $message) {
   $message . "<br>";
   }
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
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php var_dump($_SESSION['user_id']); ?>
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Blank Page
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

 
<div class="row">
<div class="col-md-3">
    <?php echo $message; ?>
<form action="upload.php" method="post" enctype="multipart/form-data">

<div class="form-group">

<input type="text" name="title" class="form-control">

</div>

<div class="form-group">

<input type="file" name="file">

</div>

<input type="submit" name="submit">

</form>
</div>
</div><!--end-row-->

<div class="row">

<div class="col-6-lg">
    <form action="upload.php" class="dropzone">
    
    </form>
</div>


</div><!-- /.container-fluid -->     




</div><!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>