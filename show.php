<?php require "includes/header.php"; ?>
<?php require "config.php"; ?>

<?php

  if(!isset($_SESSION['username'])){
    header('location: index.php');
  }

     if(isset($_GET['id'])){

        $id = $_GET['id'];
        $onepost = $conn->query("SELECT * FROM posts WHERE id='$id'");
        $onepost->execute();

        $posts =$onepost->fetch(PDO::FETCH_OBJ);
     }

     $comments = $conn->query("SELECT * FROM comments WHERE post_id='$id'");
     $comments->execute();

     $comment = $comments->fetchAll(PDO::FETCH_OBJ);
     if(isset($_SESSION['user_id'])){
         $user_id = $_SESSION['user_id'];
     }

     $ratings = $conn->query("SELECT * FROM rates WHERE post_id='$id' AND user_id='$user_id'");
     $ratings->execute();

     $rating = $ratings->fetch(PDO::FETCH_OBJ);

?>

<div id="searched-data"></div>
<div class="row">
    <div class="card mt-5">
        <div class="card-header">
            Featured
        </div>
        <div class="card-body">
            <h5 class="card-title"><?php echo $posts->title; ?></h5>
            <p class="card-text"><?php echo $posts->body.'....'; ?></p>
            <form id="form-data" method="post">
                <div class="my-rating"></div>
                <input id="rating" type="hidden" name="rating" value=""/>
                <input id="post_id" type="hidden" name="post_id" value="<?php echo $posts->id; ?>"/>
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"/>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <form method="POST" id="comment_data">
        
    <div class="form-floating mb-3">
        <input name="username" type="hidden" value="<?php 
        if(isset($_SESSION['username'])){
            echo $_SESSION['username'];
        }
        
        ?>" class="form-control" id="username">
    </div>
    <div class="form-floating mb-3">
        <input name="post_id" type="hidden" value="<?php echo $posts->id; ?>" class="form-control" id="post_id">
    </div>
    <div class="form-floating mb-3">
        <textarea rows="9" name="comment" placeholder="comment" class="form-control"></textarea>
        <label for="floatingPassword">Comment</label>
    </div>
    
    <button name="submit" id="submit" class="w-100 btn btn-lg btn-primary" type="submit">Create comment</button>
</form>
<div id="msg" class="nothing"></div>
<div id="delete-msg" class="nothing"></div>

<div class="row">
    <?php foreach($comment as $singleComment) : ?>
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title"><?php echo $singleComment->username; ?></h5>
            <p class="card-text"><?php echo $singleComment->comment; ?></p>
            <?php if(isset($_SESSION['username']) && $_SESSION['username'] == $singleComment->username): ?>
            <button id="delete-btn" value="<?php echo $singleComment->id; ?>" class="btn btn-danger mt-3">Delete Comment</button>
            <?php endif;?>
        </div>

    </div>
    <?php endforeach;  ?>
</div>


</div>
<?php require "includes/footer.php"; ?>

