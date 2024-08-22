<?php require "includes/header.php"; ?>
<?php require "config.php"; ?>

<?php
     if(isset($_GET['id'])){

        $id = $_GET['id'];
        $onepost = $conn->query("SELECT * FROM posts WHERE id='$id'");
        $onepost->execute();

        $posts =$onepost->fetch(PDO::FETCH_OBJ);
     }

     $comments = $conn->query("SELECT * FROM comments WHERE post_id='$id'");
     $comments->execute();

     $comment = $comments->fetchAll(PDO::FETCH_OBJ);

?>


<div class="row">
    <div class="card mt-5">
        <div class="card-header">
            Featured
        </div>
        <div class="card-body">
            <h5 class="card-title"><?php echo $posts->title; ?></h5>
            <p class="card-text"><?php echo $posts->body.'....'; ?></p>
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

<script>
    $(document).ready(function(){
        $(document).on('submit',function(e){
            e.preventDefault();
            var formdata = $('#comment_data').serialize()+'&submit=submit';

            $.ajax({    
                type: 'post',
                url: 'insert-comments.php',
                data: formdata,

                success: function(){
                    $('#comment').val(null);
                    $('#username').val(null);
                    $('#post_id').val(null);

                    $('#msg').text('Added successfully').toggleClass("alert alert-success bg-success text-white mt-3");
                    fetch();
                }
            })
        })

        function fetch(){
            setInterval(() => {
               $("body").load("show.php?id=<?php echo $_GET['id']; ?>") 
            }, 4000);
        }


        $('#delete-btn').on('click',function(e){
            e.preventDefault();
            var id = $(this).val();

            $.ajax({    
                type: 'post',
                url: 'delete-comments.php',
                data: {
                    delete:'delete',
                    id:id
                },

                success: function(){

                    $('#delete-msg').text('Deleted successfully').toggleClass("alert alert-success bg-success text-white mt-3");
                    fetch();
                }
            })
        })
    });
</script>