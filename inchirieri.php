<?php
require_once 'core/init.php';
require_once './layout/header.php';
$cID = $_GET['carID'];

$query = "SELECT * FROM cars WHERE carID = '" . $cID . "'";
$results = mysqli_query($db, $query);
$car = mysqli_fetch_object($results);

$query = "SELECT * FROM car_photos WHERE carID = '" . $cID . "' ORDER BY primary_photo DESC";
$results = mysqli_query($db, $query);
$car_photos = mysqli_fetch_all($results, MYSQLI_ASSOC);

Session::put('url', 'inchirieri');

?>

<section class="section product-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="detail-product">
                    <div class="slider detail-bigimg">
                    <?php foreach ($car_photos as $photo) { ?>
                        <div class="product-img">
                            <img src="https://dpdrent.ro/uploads/carsinner/<?= $photo['photo']; ?>" alt="Slider">
                        </div>
                    <?php } ?>
                    </div>
                    <div class="slider slider-nav-thumbnails">
                        <?php foreach ($car_photos as $photo) { ?>
                            <div><img src="https://dpdrent.ro/uploads/carsinner/<?= $photo['photo']; ?>" alt="Slider" style="height: 120px"></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 theiaStickySidebar">
                <div class="review-sec mt-0">
                    <div class="review-header">
                        <h4>Detaliu masina</h4>
                    </div>
                    <div class="">
                        <h3><?= $car->carName; ?></h3>
                        <br>
                        <section class="booking-section" style="padding: 0px">
                                <div class="booking-details" style="padding: 0px">
                                    <div class="row booking-info">
                                    <?php if (Session::exists('step') && Session::get('step') > 1) {
                                        $cID = $car->carID;
                                        $pickup_date  = $_SESSION['pickup_date'] . ' ' . $_SESSION['pickup_time'];
                                        $dropoff_date  = $_SESSION['return_date'] . ' ' . $_SESSION['return_time'];
                                        $days = 0;
                                        $hours = (strtotime($dropoff_date) - strtotime($pickup_date)) / 3600;
                                        if ($hours > 0) {
                                            if ($hours > 24) {
                                                if ((($hours) % 24) >= 4) {
                                                    $d = ceil($hours / 24);
                                                    $days = $d . ' x ' . getCarPriceBetweenTwoDatesWithDiscount($db, $cID, $d, $pickup_date, $_SESSION['pickup_location']);
                                                } else {
                                                    $d = floor($hours / 24);
                                                    $days = $d . ' x ' . getCarPriceBetweenTwoDatesWithDiscount($db, $cID, $d, $pickup_date, $_SESSION['pickup_location']);
                                                }
                                            } else {
                                                $d = 1;
                                                $days = $d . ' x ' . getCarPriceBetweenTwoDatesWithDiscount($db, $cID, $d, $pickup_date, $_SESSION['pickup_location']);
                                            }
                                        }

                                        $rent_list  = explode(' x ', $days);
                                    ?>
                                        <div class="col-md-3 col-sm-6 pickup-address">
                                            <h5>Zile</h5>
                                            <span><?=$rent_list[0]?></span>
                                        </div>
                                        <div class="col-md-3 col-sm-6 drop-address">
                                            <h5>Pret/zi</h5>
                                            <span>&euro;<?=round($rent_list[1])?></span>
                                        </div>
                                        <div class="col-md-3 col-sm-6 drop-address">
                                            <h5>Total</h5>
                                            <span>&euro;<?=$rent_list[1] * $rent_list[0]?></span>
                                        </div>
                                        <div class="col-md-3 col-sm-6 drop-address">
                                            <h5>Depozit</h5>
                                            <span>&euro;<?=$car->deposit?></span>
                                        </div>
                                    <?php } else if (!Session::exists('step') || Session::get('step') == 1) { ?>
                                        <div class="col-md-4 col-sm-4 pickup-address">
                                            <h5>21+ zile</h5>
                                            <span>&euro;<?=$car->price5?></span>
                                        </div>
                                        <div class="col-md-4 col-sm-4 drop-address">
                                            <h5>1-3 zile</h5>
                                            <span>&euro;<?=$car->price1?></span>
                                        </div>
                                        <div class="col-md-4 col-sm-4 drop-address">
                                            <h5>Depozit</h5>
                                            <span>&euro;<?=$car->deposit?></span>
                                        </div>
                                    <?php } ?>
                                    </div>
                                    <div class="booking-form car-listing">
                                        <div class="row">
                                            <div class="listview-car">
                                                <div class="card" style="padding: 0px">
                                                    <div class="blog-widget ">
                                                        <div class="bloglist-content">
                                                            <div class="card-body">
                                                                <div class="listing-details-group p-0 m-0">
                                                                    <ul style="display: ruby-text">
                                                                        <?php $equip = explode(';', $car->equip);
                                                                        foreach ($equip as $eqId) {
                                                                            $query = "SELECT * FROM equip WHERE equipID = " . $eqId . " AND status = 'active'";
                                                                            $results = mysqli_query($db, $query);
                                                                            $eqInfo = mysqli_fetch_object($results);
                                                                        ?>
                                                                         <li>
                                                                            <span><img src="https://dpdrent.ro/uploads/equip/<?= $eqInfo->equipPhoto ?>"></span>
                                                                            <p><?= $eqInfo->equipName; ?></p>
                                                                        </li>
                                                                        <?php } ?>
                                                                    </ul>	
                                                                </div>	
                                                            </div>					 
                                                        </div>			 
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </section>
                        <h5>Informatii Masina</h5>
                        <span><?= $car->carText?></span>
                    </div>	
                    <?php if (Session::exists('step') && Session::get('step') > 1) { ?>
                        <a onclick="rent_now(<?=$car->carID?>)" class="btn btn-primary w-100">Rent Now</a>
                    <?php } else { ?>
                        <a href="/inchirieri-masini.php" class="btn btn-primary w-100">Rent Now</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="review-sec mt-0">
                <div class="review-header">
                    <h4>Oferte Similare</h4>
                </div>
                <div class="row d-flex">
                    <?php 
                        $query = "SELECT * FROM cat_car WHERE carID = " . $cID . " LIMIT 1 ";
                        $results = mysqli_query($db, $query);
                        $cat = mysqli_fetch_object($results);
                        $catID = $cat->catID;

                        $query = "SELECT * FROM cat_car JOIN cars ON cars.carID = cat_car.carID WHERE status='active' AND cat_car.catID = ".$catID." AND cars.carID != " . $cID . " GROUP BY cars.carID ORDER BY 'order' LIMIT 3 ";
                        $results = mysqli_query($db, $query);
                        $similars = mysqli_fetch_all($results, MYSQLI_ASSOC);
                        foreach ($similars as $item)
                        {
                    ?>
                        <!-- col -->
                        <div class="rental-car-item col-md-4 col-sm-4 col-lg-4">
                            <div class="listing-item mb-0">										
                                <div class="listing-img">
                                    <a href="/inchirieri.php?carID=<?=$item['carID']?>">
                                        <img src="https://dpdrent.ro/uploads/cars/<?php echo $item['carPhoto']?>" style="height: 250px !important">
                                    </a>
                                </div>										
                                <div class="listing-content">
                                    <div class="listing-features">												
                                        <div class="fav-item-rental">
                                            <span class="featured-text">&euro;<?php echo $item['price1']?>/zi</span>									
                                        </div>																  
                                        <h3 class="listing-title">
                                            <a href="listing-details.html"><?php echo $item['carName'];?></a>
                                        </h3>
                                    </div> 
                                    <div class="listing-button">
                                        <?php if (Session::exists('step') && Session::get('step') > 1) { ?>
                                            <a onclick="rent_now(<?=$item['carID']?>)" class="btn btn-order"><span><i class="feather-calendar me-2"></i></span>Rent Now</a>
                                        <?php } else { ?>
                                            <a href="/inchirieri-masini.php" class="btn btn-order"><span><i class="feather-calendar me-2"></i></span>Rent Now</a>
                                        <?php } ?>
                                    </div>	
                                </div>
                            </div>
                        </div>
                        <!-- /col -->
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php 
require_once './layout/footer.php';
?>
<script>
    function rent_now(id)
	{
		var carID = id;
        var formAction = '/ajax/index-rent-now.php';
		$.ajax({
			type: "POST",
            url: formAction,
            data: {
				id: id
			},
            success: function(response) {
               if (response == true)
               {
                window.location.replace('/rezervare.php')
               }
            }
		})
	}
</script>