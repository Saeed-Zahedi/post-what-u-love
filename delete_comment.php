<?php 
require "config.php";
?>
<?php
$post_id=$_GET['post_id'];
$comment_id=$_GET['comment_id'];
$delete_commet=$conn->query("DELETE FROM comments WHERE id='$comment_id'");
$delete_commet->execute();
header("location:show.php?id=$post_id");
?>