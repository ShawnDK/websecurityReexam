<div id="content" class="f-cl-c">
	<h1 class="h1-c">Products</h1>

	<div id="products" class="m-t-10">
		<div class="filter b-2 p-10 w-200 fl-l m-r-20">
			<h2 class="m-0 m-t-10">Categories</h2>
			<ul class="p-0 m-0 ul-noDeco">
				<li><input type="checkbox" name="vehicle" value="Car">Vehicles</li>
				<li><input type="checkbox" name="vehicle" value="Car2">Machines</li>
				<li><input type="checkbox" name="vehicle" value="Car3">Furniture</li>
			</ul>
			<h2 class="m-0 m-t-10">Price</h2>
			<ul class="p-0 m-0 ul-noDeco">
				<li><input type="checkbox" name="vehicle" value="Car">5$</li>
				<li><input type="checkbox" name="vehicle" value="Car2">10$</li>
				<li><input type="checkbox" name="vehicle" value="Car3">20$</li>
			</ul>
			<h2 class="m-0 m-t-10">Distance</h2>
			<ul class="p-0 m-0 ul-noDeco">
				<li><input type="checkbox" name="vehicle" value="Car">1km</li>
				<li><input type="checkbox" name="vehicle" value="Car2">10km</li>
				<li><input type="checkbox" name="vehicle" value="Car3">20km</li>
			</ul>
		</div>
		<div class="items b-2 w-600 fl-l f-cl-c">
			<div class="pagination f-row f-sa w-p-100 m-t-10">	
				<div class="item">
					<select name="itemsPerPage">
						<option value="12">12</option>
						<option value="24">24</option>
						<option value="36">36</option>
					</select> items per page		
				</div>
				<div class="item">
					<a href="#">1</a>
					<a href="#">2</a>
					<a href="#">3</a>
					<a href="#">4</a>
					...
					<a href="#">94</a>
					<input type="text" name="lname"> GO
				</div>
			</div>
			<div class="products m-t-20 group">
				<?php
				require_once 'db_connect.php';

				$rentals = $con->prepare("SELECT websecrentals.id, websecuserinfo.userId, websecrentals.title, websecrentals.image, websecuserinfo.firstname, websecuserinfo.image AS imageP, websecuserinfo.lastname, websecuserinfo.adress, websecrentals.des, websecrentals.price FROM websecrentals LEFT JOIN websecuserinfo ON websecuserinfo.userId = websecrentals.userId ORDER BY websecrentals.timestamp;");
				$rentals->execute();
				$rentalsCount = $rentals->rowCount();
				$rentals = $rentals->fetchAll();
				



				
				if($rentalsCount>0){
					foreach($rentals as $item){
						echo "
						<div class='item clearfix bg-dbdbdb p-10 m-t-10'>
							<div class='itemSpec w-300 fl-l m-r-20'>
								<img class='img-max-300' src='";

								if($item['image']){
									echo "uploads/".$item['image'];
								}else{
									echo "https://upload.wikimedia.org/wikipedia/commons/8/88/LargeDrill.jpg";
								}

								echo "'>
								<div style='height: 40px;'>
									<h2 class='fl-l fs-24px'>".$item['title']."</h2>
									<h2 class='fl-r fs-24px fw-normal'><span class=''>".$item['price']."$</span>/day</h2>
								</div>
								<h3 class='fs-16px fw-bold'>".$item['adress']."<i class='fa fa-map-marker' aria-hidden='true'></i></h3>
								<div>".htmlentities($item['des'])."</div>
							</div>
							<div class='personSpec fl-l f-cl-c'>
								<img class='img-s-75' src='";

								if($item['image']){
									echo 'uploads/'.$item['imageP'];
								}else{
									echo 'https://d30y9cdsu7xlg0.cloudfront.net/png/15724-200.png';
								}

								echo "'>
								
								<div class='personName'>
									<a href='profile/".$item['userId']."'>
										<h3 class='fl-l'>".$item['firstname']." ".$item['lastname']."<img class='img-s-20 fl-l' src='http://www.gabbatracklistworld.com/img/online.png'></h3>
										<h3>
										";
			

									//TESTING
									$reviews = $con->prepare("SELECT * FROM websecreviews WHERE user LIKE :profileId");
									$reviews->bindParam(':profileId', $item['userId']);
									$reviews->execute();
									$reviewsCount = $reviews->rowCount();
									$reviews = $reviews->fetchAll();
									//print_r($reviewsCount);
									
									if($reviewsCount>0 && $item['userId'] == $reviews[0]['user']){
									    $finalRating = 0;
									    $testFinalrating = 0;
									    foreach($reviews as $eachReview){
										$finalRating += $eachReview['rating'];      
									    }
									    $testFinalrating = round($finalRating/$reviewsCount);
									}
									
									echo "
									
									</h3>
									</a>	
								</div>
								
								";
								if($reviewsCount>0 && $item['userId'] == $reviews[0]['user']){
									echo "
								
								<div class='f-c m-0'>
									".str_repeat("<i class='fa fa-star fa-2' aria-hidden='true'></i>", $testFinalrating).str_repeat("<i class='fa fa-star-o' aria-hidden='true'></i>", (5-$testFinalrating))."
								</div>
								
								";
								}else{
									echo "<div class='f-c m-0'>
									".str_repeat("<i class='fa fa-star fa-2' aria-hidden='true'></i>", 0).str_repeat("<i class='fa fa-star-o' aria-hidden='true'></i>", (5))."
								</div>";
								}
								
								echo "
								
								
								<div class='fbConfirmed'>
									<i class='fa fa-check-square-o' aria-hidden='true'></i>Facebook godkendt
								</div>
								<div class='phoneConfirmed'>
									<i class='fa fa-check-square-o' aria-hidden='true'></i>Mobilnr. verificeret
								</div>
								<div>
									Tlf. og e-mail vises <br>efter bekræftet booking.
								</div>
								<a href='products/".$item['id']."'><button class='w-100 m-t-10 fs-20px btn btn-success'>Book</button></a>

							</div>
						</div>
						";
						}
					}else{
						echo "<h1>There are currently no items that are rented out</h1>";
					}


				// <div class="item clearfix bg-dbdbdb p-10 m-t-10">
				// 	<div class="itemSpec w-300 fl-l m-r-20">
				// 		<img class="img-max-300" src="https://upload.wikimedia.org/wikipedia/commons/8/88/LargeDrill.jpg">
				// 		<div>
				// 			<h2 class="fl-l fs-24px">drill 200w bosh</h2>
				// 			<h2 class="fl-r fs-24px fw-normal"><span class="">20$</span>/day</h2>
				// 		</div>
				// 		<h3 class="fs-16px fw-bold">Højskolevej 26, København NV 2400 <i class='fa fa-map-marker' aria-hidden='true'></i></h3>
				// 		<div>The drill is bla bla bla, very good, lorem ipsum dolorem sit wwwwwwwwwwwwwwwwwwwww</div>
				// 	</div>
				// 	<div class="personSpec fl-l f-cl-c">
				// 		<img class="img-s-75" src="https://d30y9cdsu7xlg0.cloudfront.net/png/15724-200.png">
				// 		<div class="personName">
				// 			<h3 class="fl-l">Petyo Zhechev</h3>
				// 			<img class="img-s-20 fl-l" src="http://www.gabbatracklistworld.com/img/online.png">	
				// 		</div>
				// 		<div class='f-c m-0'>
	   //                      <i class='fa fa-star fa-2 fa-star2' aria-hidden='true'></i>
	   //                      <i class='fa fa-star fa-star2 fa-2' aria-hidden='true'></i>
	   //                      <i class='fa fa-star fa-star2 fa-2' aria-hidden='true'></i>
	   //                      <i class='fa fa-star fa-star2 fa-2' aria-hidden='true'></i>
	   //                      <i class='fa fa-star-o fa-star-o2' aria-hidden='true'></i>
	   //                  </div>
	   //                  <div class="fbConfirmed">
	   //                      <i class='fa fa-check-square-o' aria-hidden='true'></i>Facebook godkendt
	   //                  </div>
	   //                  <div class="phoneConfirmed">
	   //                      <i class='fa fa-check-square-o' aria-hidden='true'></i>Mobilnr. verificeret
	   //                  </div>
	   //                  <div>
	   //                  	Tlf. og e-mail vises <br>efter bekræftet booking.
	   //                  </div>
	   //                  <button class="w-100 m-t-10 fs-20px btn btn-success">Book</button>

				// 	</div>
				// </div>
				// <div class="item clearfix bg-dbdbdb p-10 m-t-10">
				// 	<div class="itemSpec w-300 fl-l m-r-20">
				// 		<img class="img-max-300" src="https://upload.wikimedia.org/wikipedia/commons/8/88/LargeDrill.jpg">
				// 		<div>
				// 			<h2 class="fl-l fs-24px">drill 200w bosh</h2>
				// 			<h2 class="fl-r fs-24px fw-normal"><span class="">20$</span>/day</h2>
				// 		</div>
				// 		<h3 class="fs-16px fw-bold">Højskolevej 26, København NV 2400 <i class='fa fa-map-marker' aria-hidden='true'></i></h3>
				// 		<div>The drill is bla bla bla, very good, lorem ipsum dolorem sit wwwwwwwwwwwwwwwwwwwww</div>
				// 	</div>
				// 	<div class="personSpec fl-l f-cl-c">
				// 		<img class="img-s-75" src="https://d30y9cdsu7xlg0.cloudfront.net/png/15724-200.png">
				// 		<div class="personName">
				// 			<h3 class="fl-l">Petyo Zhechev</h3>
				// 			<img class="img-s-20 fl-l" src="http://www.gabbatracklistworld.com/img/online.png">	
				// 		</div>
				// 		<div class='f-c m-0'>
	   //                      <i class='fa fa-star fa-2 fa-star2' aria-hidden='true'></i>
	   //                      <i class='fa fa-star fa-star2 fa-2' aria-hidden='true'></i>
	   //                      <i class='fa fa-star fa-star2 fa-2' aria-hidden='true'></i>
	   //                      <i class='fa fa-star fa-star2 fa-2' aria-hidden='true'></i>
	   //                      <i class='fa fa-star-o fa-star-o2' aria-hidden='true'></i>
	   //                  </div>
	   //                  <div class="fbConfirmed">
	   //                      <i class='fa fa-check-square-o' aria-hidden='true'></i>Facebook godkendt
	   //                  </div>
	   //                  <div class="phoneConfirmed">
	   //                      <i class='fa fa-check-square-o' aria-hidden='true'></i>Mobilnr. verificeret
	   //                  </div>
	   //                  <div>
	   //                  	Tlf. og e-mail vises <br>efter bekræftet booking.
	   //                  </div>
	   //                  <button class="w-100 m-t-10 fs-20px btn btn-success">Book</button>

				// 	</div>
				// </div>
					?>
				</div>
				<div class="pagination f-row f-sa w-p-100">
					<select name="itemsPerPage">
						<option value="12">12</option>
						<option value="24">24</option>
						<option value="36">36</option>
					</select> items per page		
					<a href="#">1</a>
					<a href="#">2</a>
					<a href="#">3</a>
					<a href="#">4</a>
					...
					<a href="#">94</a>
					<input type="text" name="lname"> GO
				</div>

			</div>
		</div>
		
	</div>

