<?php

require "config.php";

if(isset($_POST['insert'])){

    $post_id =$_POST['post_id'];
    $rating =$_POST['rating'];
    $insert = $conn->prepare("INSERT INTO rates(post_id,ratings) VALUES (:post_id, :rating)");

    $insert->execute([
        ':post_id' => $post_id,
        ':rating' => $rating
    ]);

    

}

?>