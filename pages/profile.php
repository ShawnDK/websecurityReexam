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
                        <?php echo htmlentities($result[0]['firstname'])." ".$result[0]['lastname']?>
                    </p>
                    <p class="">
                        <?php if($result[0]['adress'] != ""){
                            echo htmlentities($result[0]['adress']);
                        }else{
                            echo '...';
                        }?>
                    </p>
                    <p class="">
                        <?php if($result[0]['age'] != ""){
                            echo htmlentities($result[0]['age']);
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
                            echo round($finalRating/$reviewsCount, 2);
                        }else{
                            echo 'no reviews yet';
                        }
                        ?>
                    </p>
                </div>
            </div>
            <div class="img-s-150 m-l-r-50">
                <img src="<?php
            
                if($result[0]['image'] != ""){
                    echo "/websecurity/uploads/".$result[0]['image'];
                }else{
                    echo "images/anonymousProfile.png";
                }

                ?>" class="img-100" alt="Profile">
            </div>
        </div>

        <hr class="hr-90">
        <div class="f-cl-c m-20">

            <div class="f-cl-c m-20">
                <?php
                if(isset($_SESSION["userIdSession"])){
                if($_SESSION["userIdSession"] == $result[0]['userId']){
                echo "<a href='/websecurity/products/add'><h2 class='h2-c'>ADD ITEM <i class='fa fa-plus-circle' aria-hidden='true'></i></h2></a>";
                }
                }
                ?>
            </div>


            <h1 class="h1-c">CURRENT RENTALS</h1>
            <!-- TEMPLATE !!! -->
            <div class="h-200 f-cl-c m-20">
                <?php
                
                if($rentalsCheckCount>0){

                    foreach($rentals as $each){                       
                        echo "<a href='/websecurity/products/".$each['id']."'><div class='b-2 m-20 p-20'><div class='img-s-150 m-auto'>
                        <img src='";

                        if($each['image']){
                            echo "/websecurity/uploads/".$each['image'];
                        }else{
                            echo '/websecurity/images/genericItem.png';
                        }

                        echo "' class='img-100' alt='Profile'>
                    </div>
                    <p class='w-300 f-w-600 txt-align-center'>".htmlentities($each['title'])."</p></br>
                    <p class='w-300'>".htmlentities($each['des']).
                        "</p><br><p class='w-300 txt-align-center'>Price: ".$each['price'].
                        "</p></div></a>";
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
                    
                    ";foreach($rentals as $eachR){   
                        if ($eachR['id'] == $each['itemId'])
                        {
                         echo "<img src=/websecurity/uploads/".$eachR['image']." class=\"img-100\"";
                        }
                    } echo "
                    
                        <img src=\"/websecurity/images/genericItem.png\" class=\"img-100\" alt=\"item\">
                    </div>
                    <div class=\"f-sp\">
                        <p class=\"w-300 f-grow\">".htmlentities($each['comment'])."</p>
                        <a href='/websecurity/profile/".$each['reviewer']."'><p class=\"w-300 f-08-ir\">User:". $each['reviewer']."</p></a>
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
    echo $profileId;
    echo '<br>NO USER FOUND';
}
?>