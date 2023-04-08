<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php 

if(empty($_GET['id'])) {
    redirect("photos.php");
}
$message = "";
$comments = Comment::find_the_comment($_GET['id']);
$photo = Photo::find_by_id($_GET['id']);
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
        <h1 class="page-header justify-content-center">
            Comments
            <small>Subheading</small>
        </h1>
        <p class="bg-success"><?php echo $message; ?></p>
<a href="add_comment.php?id=<?php echo $_GET['id']; ?>" class="btn btn-primary">Add Comment</a>
<div class="col-md-2">
<div class="from-group">
    <a class="thumbnail" href="#"><img src="<?php echo $photo->picture_path(); ?>" width="200" alt=""></a>
</div>  
</div>
<div class="col-md-10">
<?php //echo $message; ?>
<table class="table table-hover">

<thead>
    <tr>
        <th>Id</th>
        <th>Avatar</th>
        <th>Author</th>
        <th>Comment</th>
    </tr>
</thead>
<tbody>

<?php foreach($comments as $comment) : ?>


    <tr>
    <td><?php echo $comment->id; ?></td>
<td class="user_image_cell"><img class="user_image" src="<?php echo $comment->image_path_and_placeholder($comment->id); ?>" alt=""></td>
<td><?php echo $comment->author; ?>
<div class="action-links">

<a href="delete_comment_photo.php?id=<?php echo $comment->id; ?>">Delete</a>
<a href="edit_comment.php?id=<?php echo $comment->id; ?>">Edit</a>


</div>
</td>


<td><?php echo $comment->body; ?></td>

    </tr>

<?php endforeach; ?>

</tbody>
</table>


</div>


    </div>
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->      

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>