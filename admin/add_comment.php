<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>
<?php
$message = "";

if(empty($_GET['id'])) {
    redirect("comments.php");    
} else {

$comment = new Comment();
$photo = Photo::find_by_id($_GET['id']);
    if(isset($_POST['add_comment'])) {
    if($comment) {
    $comment->author             =    $_POST['author'];
    $comment->body               =    $_POST['body'];
    $comment->photo_id           =    $_GET['id'];

 
    if($comment->save()) {

       $message = "The comment was sucessfully added";
    
    } else {
        $message = "Comment saving failed";
    }
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
        <?php echo $message; ?>
        <div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-4 col-md-offset-4">
        <h1 class="page-header">
            Comments
            <small>Subheading</small>
        </h1>
    </div>  
</div>

<div class="row">

<div class="col-md-4">
<a class="thumbnail" href="#"><img src="<?php echo $photo->picture_path(); ?>" width="200" alt=""></a>
</div>

<div class="col-md-4">
<form action="" method="post" enctype="multipart/form-data" >

<div class="form-group">
<label class="bg-light text-info" for="author">Author</label>
<input type="text" name="author" class="form-control" value="<?php echo $comment->author; ?>">
</div>


<div class="form-group">
<label class="bg-light text-info" for="body">Comment</label>
<input type="text" name="body" class="form-control" value="<?php echo $comment->body; ?>">
</div>



<div class="form-group create-width">

<a class="btn btn-danger" href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete</a>
<input type="submit" name="add_comment" class="btn btn-primary pull-right" value="Update">
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

