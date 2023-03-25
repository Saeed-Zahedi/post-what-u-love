<?php require "includes/header.php"; 
      require "config.php";
?>

<?php 
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $onePost=$conn->query("SELECT * FROM posts WHERE id='$id'");
        $onePost->execute();
        $post=$onePost->fetch(PDO::FETCH_OBJ);
    }

?>
<?php
if(isset($_POST['submit'])&&empty($_SESSION['username'])){
  header("location:login.php");
}   
if(isset($_POST['submit'])&&!empty($_POST['comment'])){
$comment=$_POST['comment'];
$insert=$conn->prepare("INSERT INTO comments (username,post_id,comment) 
VALUES (:username,:post_id,:comment)");
$insert->execute([
  ':username'=>$_SESSION['username'],
  ':post_id'=>$_GET['id'],
  ':comment'=>$comment, 
]);
}

?>

<?php
$id=$_GET['id'];
$comment=$conn->query("SELECT * FROM comments WHERE post_id='$id'");
$comment->execute();
$comments=$comment->fetchAll(PDO::FETCH_OBJ);
?>
<main class="form-signin w-50 m-auto mt-5">
<div class="card">
  <div class="card-body">
    <h5 class="card-title"><?php echo $post->title;?></h5>
    <p class="card-text"><?php echo $post->body;?></p>
    <br>
  </div>
</div> 
<div class="row mt-3">
  <form method="POST" id="comment_data">  

    <div class="form-floating">
      <textarea rows="10" name="comment" class="form-control" placeholder="body" id="comment"></textarea>
      <label for="floatingPassword">Comment</label>
    </div>

    <button name="submit" id="submit" class="w-100 btn btn-lg btn-primary mt-2" type="submit">Create Comment</button>
  </form>
</br>
</br>
</br>
</br>
<h6>comments for this post:</h6>
</main>
<?php foreach($comments as $singlecomment):?>
<main class="form-signin w-50 m-auto">  
<div class="card-body">
    <h5 class="card-title"><?php echo $singlecomment->username;?></h5>
    <p class="card-text"><?php echo $singlecomment->comment;?></p>
    <?php if(isset($_SESSION['username'])&&$singlecomment->username==$_SESSION['username']):?>
    <a href="delete_comment.php?comment_id=<?php echo $singlecomment->id;?>&&post_id=<?php echo $_GET['id'];?>">Delete Comment</a>
    <br>
    <?php endif;?>
  </div>  
</main>
<?php endforeach;?>
<?php require "includes/footer.php"; ?>   

