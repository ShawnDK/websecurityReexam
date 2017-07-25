<div class="f-cl-c m-20">
    <?php print_r($aUrl()[2]) ?>
    <h1 class="h1-c">NEW REVIEW</h1>
    <div class="f-c m-20">
        <i class="p-4 fa fa-star-o fa-3x ratings_stars" aria-hidden="true"></i>
        <i class="p-4 fa fa-star-o fa-3x ratings_stars" aria-hidden="true"></i>
        <i class="p-4 fa fa-star-o fa-3x ratings_stars" aria-hidden="true"></i>
        <i class="p-4 fa fa-star-o fa-3x ratings_stars" aria-hidden="true"></i>
        <i class="p-4 fa fa-star-o fa-3x ratings_stars" aria-hidden="true"></i>
    </div>
    <div class="/*w-250 h-200*/">
        <textarea id="commentField" class="w-250 h-200" style="resize: none;"></textarea>
    </div>

    <button id="postR" class="btn btn-warning">Post</button>
</div>

<script>
$('.ratings_stars').hover(
    // Handles the mouseover
    function() {
        if (!$(this).hasClass("fa-star")) {
            $(this).prevAll().addBack().addClass('fa-star-selected');
        }
    },
    // Handles the mouseout
    function() {
        if (!$(this).hasClass("fa-star")) {
            $(this).nextAll().addBack().removeClass('fa-star-selected');
            $(this).prevAll().addBack().removeClass('fa-star-selected');
        }else{
            $(this).prevAll().addBack().removeClass('fa-star-selected');
        }
    }
);

$('.ratings_stars').click(function(){
    $(this).prevAll().addBack().addClass('fa-star');
    $(this).prevAll().addBack().removeClass('fa-star-o');
    $(this).nextAll().removeClass('fa-star');
    $(this).nextAll().removeClass('fa-star-selected');
    $(this).nextAll().addClass('fa-star-o');  
});



$("#postR").click(function(){
    var comment = $("#commentField").val();
    var rating = $('.fa-star').length;
    var itemId = <?php echo $aUrl()[2]; ?>;
    var sLink = "/websecurity/actions/action_make-review.php?comment=" + comment + "&rating=" + rating + "&itemId=" + itemId;

    $.ajax({
        "url":sLink,
        "dataType":"text",
        "method":"post",
        "cache": false
    }).done( function(Data){
        console.log(Data);

        if (Data == "yes") {
            swal("Good job!", "You made a review!", "success")
        }else{
            swal({
            title: "Error!",
            text: "Please enter something",
            type: "error",
            confirmButtonText: "Cool"
            });
        }
    });
});


</script>




