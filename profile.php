<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', 1);
*/

//GET THE DB CONNECTION DETAILS
require_once 'db_connect.php';

$result = $con->prepare("SELECT * FROM websecuserinfo WHERE userId LIKE :profileId");
$result->bindParam(':profileId', $profileId);
$result->execute();
$resultCheckCount = $result->rowCount();
$result = $result->fetchAll();

$rentals = $con->prepare("SELECT * FROM websecrentals WHERE userId LIKE :profileId");
$rentals->bindParam(':profileId', $profileId);
$rentals->execute();
$rentalsCheckCount = $rentals->rowCount();
$rentals = $rentals->fetchAll();

$reviews = $con->prepare("SELECT * FROM websecreviews WHERE user LIKE :profileId");
$reviews->bindParam(':profileId', $profileId);
$reviews->execute();
$reviewsCount = $reviews->rowCount();
$reviews = $reviews->fetchAll();

if($resultCheckCount>0){
    ?>
    <div class="h-70">
        <div class="f-c m-20">
            <div class="f-sa w-250">
                <div class="f-w-600">
                    <p class="">Name</p>
                    <p class="">City</p>
                    <p class="">Age</p>
                    <p class="">Avg rating</p>
                </div>
                <div>
                    <p class="">
                        <?php echo $result[0]['firstname']?>
                    </p>
                    <p class="">
                        <?php if($result[0]['adress'] != ""){
                            echo $result[0]['adress'];
                        }else{
                            echo '...';
                        }?>
                    </p>
                    <p class="">
                        <?php if($result[0]['age'] != ""){
                            echo $result[0]['age'];
                        }else{
                            echo '...';
                        }?>
                    </p>
                    <p class="">
                        <?php
                        if($reviewsCount>0){
                            $finalRating = 0;
                            foreach($reviews as $eachReview){
                                $finalRating += $eachReview['rating'];      
                            }
                            echo $finalRating/$reviewsCount;
                        }else{
                            echo 'no reviews yet';
                        }
                        ?>
                    </p>
                </div>
            </div>
            <div class="img-s-150 m-l-r-50">
                <img src="../images/anonymousProfile.png" class="img-100" alt="Profile">
            </div>
        </div>

        <hr class="hr-90">
        <div class="f-cl-c m-20">

            <div class="f-cl-c m-20">
                <h2 class="h2-c">ADD ITEM <i class="fa fa-plus-circle" aria-hidden="true"></i></h2>
            </div>


            <h1 class="h1-c">CURRENT RENTALS</h1>
            <!-- TEMPLATE !!! -->
            <div class="h-200 f-cl-c m-20">
                <?php
                if($rentalsCheckCount>0){
                    foreach($rentals as $each){
                        echo "<div class='b-2 m-20 p-20'><div class='img-s-150 m-auto'>
                        <img src='../images/genericItem.png' class='img-100' alt='Profile'>
                    </div>
                    <p class='w-300 f-w-600 txt-align-center'>".$each['title']."</p></br>
                    <p class='w-300'>".$each['des'].
                        "</p><br><p class='w-300 txt-align-center'>Price: ".$each['price'].
                        "</p></div>";
                    }
                }else{
                    echo "<h1>You are currently not renting out anything</h1>";
                }
                ?>
            </p>
        </div>
        <!-- TEMPLATE END !!! -->
    </div>

    <hr class="hr-90">

    <div class="f-cl-c m-20">
        <h1 class="h1-c">HISTORY</h1>
        <!-- TEMPLATE !!! -->
        <?php
        if ($reviewsCount == 0){
            echo "<h1>No reviews have been made yet</h1>";
        }else{
            foreach($reviews as $each){
                echo "<div class='b-2 m-30'><div class='f-c m-20'>".str_repeat("<i class='fa fa-star fa-2' aria-hidden='true'></i>", $each['rating']).str_repeat("<i class='fa fa-star-o' aria-hidden='true'></i>", (5-$each['rating']))."</div>
                <div class=\"h-100 f-c m-20\">
                    <div class=\"img-s-150 m-l-r-50\">
                        <img src=\"../images/genericItem.png\" class=\"img-100\" alt=\"item\">
                    </div>
                    <div class=\"f-sp\">
                        <p class=\"w-300 f-grow\">".$each['comment']."</p>
                        <p class=\"w-300 f-08-ir\">User:". $each['reviewer']."</p>
                        <p class=\"w-300 f-08-ir\">Date:". $each['reviewTime']."</p>
                    </div>
                </div></div>";
            }
        }
        ?>
    </div>
</div>
<?php
}else{
    echo 'NO USER FOUND';
    echo '<br>NO USER FOUND';
}
?>