</div>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="" crossorigin=""></script>
<script src="rating-plugin/dist/jquery.star-rating-svg.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js
"></script>
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
               $("body").load("show.php?id=<?php 
                if(isset($_GET['id'])){
                    echo $_GET['id'];
                }else{
                    echo "nothing";
                }
                
                ?>") 
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


        $(".my-rating").starRating({
            starSize: 25,
            initialRating:"<?php 

            if(isset($rating->ratings) AND isset($rating->user_id) AND $rating->user_id == $_SESSION['user_id']){
                echo $rating->ratings;
            }else{
                echo '0';

            }
            
                ?>",
            callback: function(currentRating, $el){
                $('#rating').val(currentRating)
                $(".my-rating").click(function(e){
                    e.preventDefault();
                    var formdata = $("#form-data").serialize()+'&insert=insert';

                    $.ajax({
                        type:"POST",
                        url:"insert-rating.php",
                        data:formdata,

                        success: function(){
                            
                        }
                    });

                });
            }

        });

        $('#search').keyup(function() {
            var search = $(this).val();

            if(search != ''){
                $('.row').css("display","none");
                $('main').css("display","none");
                $.ajax({
                    type:"POST",
                    url:"search.php",
                    data:{
                        search:search
                    },
                    success: function(data){
                        $('#searched-data').css('display','block');
                        $('#searched-data').html(data);
                    }
                })
            }else{
                $('#searched-data').css('display','none');
                $('.row').css("display","block");
                $('main').css("display","block");


            }
        });


    });
</script>
</body>
</html>