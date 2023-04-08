<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php 

$comments = Comment::find_all();

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
            All Comments
            <small>Subheading</small>
        </h1>
        <p class="bg-success"><?php echo $message; ?></p>

<div class="col-md-12">

<table class="table table-hover">

<thead>
    <tr>
        <th>Id</th>
        <th>Image</th>
        <th>Avatar</th>
        <th>Author</th>
        <th>Comment</th>
    </tr>
</thead>
<tbody>

<?php foreach($comments as $comment) : ?>

<tr>
<td class="id_cell"><?php echo $comment->id; ?></td> 
<td class="comment_image_cell" >


<img src="<?php echo $comment->picture_path(); ?>" alt="" width="100">
</td>



<td class="user_image_cell"><img class="user_image" src="<?php echo $comment->image_path_and_placeholder(); ?>" alt=""></td>
<td class="user_name_cell"><?php echo $comment->author; ?>
<div class="action-links">

<a class="delete_link" href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete</a>
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