<div id="content" class="f-row-c">
    <div class="calendar m-r-20">
        <div class="month">
            <ul>
                <li class="prev">&#10094;</li>
                <li class="next">&#10095;</li>
                <li style="text-align:center">
                    August<br>
                    <span style="font-size:18px">2016</span>
                </li>
            </ul>
        </div>

        <ul class="weekdays">
            <li>Mo</li>
            <li>Tu</li>
            <li>We</li>
            <li>Th</li>
            <li>Fr</li>
            <li>Sa</li>
            <li>Su</li>
        </ul>

        <ul class="days">
            <li>1</li>
            <li>2</li>
            <li>3</li>
            <li>4</li>
            <li>5</li>
            <li>6</li>
            <li>7</li>
            <li>8</li>
            <li>9</li>
            <li><span class="free">10</span></li>
            <li>11</li>
            <li>12</li>
            <li>13</li>
            <li><span class="free">14</span></li>
            <li><span class="free">15</span></li>
            <li><span class="free picked">16</span></li>
            <li><span class="free">17</span></li>
            <li>18</li>
            <li>19</li>
            <li>20</li>
            <li>21</li>
            <li>22</li>
            <li>23</li>
            <li>24</li>
            <li>25</li>
            <li>26</li>
            <li>27</li>
            <li>28</li>
            <li>29</li>
            <li>30</li>
            <li>31</li>
        </ul>
    </div>

    <?php
    require_once 'db_connect.php';

    $item = $con->prepare("SELECT * FROM websecrentals WHERE id LIKE :itemId LIMIT 1");
    $item->bindParam(":itemId", $itemId);
    $item->execute();
    $item = $item->fetchAll();

    $rentier = $con->prepare("SELECT * FROM websecuserinfo WHERE userId LIKE :userId LIMIT 1");
    $rentier->bindParam(":userId", $item[0]['userId']);
    $rentier->execute();
    $rentier = $rentier->fetchAll();
             //   $rentals = $con->prepare("SELECT websecrentals.id, websecrentals.title, websecrentals.image, websecuserinfo.firstname, websecuserinfo.lastname, websecuserinfo.adress, websecrentals.des, websecrentals.price FROM websecrentals LEFT JOIN websecuserinfo ON websecuserinfo.userId = websecrentals.userId ORDER BY websecrentals.timestamp;");

    ?>

    <div class="productConfirmation w-250 m-r-20 bg-dbdbdb">
        <br>
        <div class="line m-l-15 fw-bold fs-16px">products:</div>
        <div class="line m-r-20 m-l-15">
            <span class="pos-rel bg-dbdbdb zi-1">1 day (<?php echo $item[0]['title']; ?>)</span>
            <span class="fl-r pos-rel bg-dbdbdb zi-1"> <span class="fw-bold">x</span> <?php echo $item[0]['price']; ?>$</span>
            <span class="dotsExtended pos-abs zi-0">....................................</span>
        </div>
        <br><br>
        <div class="line m-r-20 m-l-15">.
            <span class="dotsExtended pos-abs zi-0">---------------------------------------------------------</span>
        </div>
        <br>
        <div class="total">
            Price : <span class="fl-r"><?php echo $item[0]['price']; ?>$</span><br> +20% VAT : <span class="fl-r"><?php echo ((int)$item[0]['price'] / 5); ?>$</span><br> TOTAL : <span class="fl-r"><?php echo ((int)$item[0]['price'] * 1.2); ?>$</span>
        </div>
        <a href="/websecurity/products/<?php echo $itemId; ?>/review"><button class="fl-r m-r-20 w-100 m-t-10 fs-20px btn btn-success">Book</button></a>
    </div>
    <div class="product w-600">
        <div class="item clearfix bg-dbdbdb p-10">
            <div class="itemSpec w-300 fl-l m-r-20">
                <img class="img-max-300" src="<?php echo '/websecurity/uploads/'.$item[0]['image']; ?>">
                <div>
                    <h2 class="fl-l fs-24px"><?php echo $item[0]['title']; ?></h2>
                    <h2 class="fl-r fs-24px fw-normal"><span class=""><?php echo $item[0]['price']; ?>$</span>/day</h2>
                </div>
                <h3 class="fs-16px fw-bold"><?php echo $rentier[0]['adress']; ?> <i class='fa fa-map-marker' aria-hidden='true'></i></h3>
                <div><?php echo htmlentities($item[0]['des']); ?></div>
            </div>
            <div class="personSpec fl-l f-cl-c">
                <img class="img-s-75" src="https://d30y9cdsu7xlg0.cloudfront.net/png/15724-200.png">
                <div class="personName">
                    <a href="/websecurity/profile/<?php echo $item[0]['userId'] ?>"><h3 class="fl-l"><?php echo $rentier[0]['firstname']; ?> <?php echo $rentier[0]['lastname']; ?></h3></a>
                    <img class="img-s-20 fl-l" src="http://www.gabbatracklistworld.com/img/online.png">
                </div>
                <div class='f-c m-0'>
                    <i class='fa fa-star fa-2 fa-star2' aria-hidden='true'></i>
                    <i class='fa fa-star fa-star2 fa-2' aria-hidden='true'></i>
                    <i class='fa fa-star fa-star2 fa-2' aria-hidden='true'></i>
                    <i class='fa fa-star fa-star2 fa-2' aria-hidden='true'></i>
                    <i class='fa fa-star-o fa-star-o2' aria-hidden='true'></i>
                </div>
                <div class="fbConfirmed">
                    <i class='fa fa-check-square-o' aria-hidden='true'></i>Facebook godkendt
                </div>
                <div class="phoneConfirmed">
                    <i class='fa fa-check-square-o' aria-hidden='true'></i>Mobilnr. verificeret
                </div>
                <div>
                    Tlf. og e-mail vises <br>efter bekræftet booking.
                </div>

            </div>
        </div>
    </div>
</div>
