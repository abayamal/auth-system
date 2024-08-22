<?php require "config.php"; ?>
<?php


if(isset($_POST['submit'])){

    if($_POST['username'] == '' OR $_POST['post_id'] == '' OR $_POST['comment'] == ''){
      echo "Some inputs are empty";
    }else{
        $username = $_POST['username'];
        $post_id = $_POST['post_id'];
        $comment = $_POST['comment'];
        
        $insert = $conn->prepare("INSERT INTO comments (username,post_id,comment) VALUES (:username, :post_id, :comment)");
        $insert->execute([
          ':username' => $username,
          ':post_id' => $post_id,
          ':comment' => $comment
        ]);
    }
  }


?>