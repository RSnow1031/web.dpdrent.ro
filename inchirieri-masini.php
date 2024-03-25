<?php
require_once 'core/init.php';
require_once './layout/header.php';

$query = "SELECT * FROM categories JOIN cat_car ON categories.catID = cat_car.catID WHERE status = 'active' GROUP BY categories.catID ORDER BY 'order' ASC";
$results = mysqli_query($db, $query);
$cats = mysqli_fetch_all($results, MYSQLI_ASSOC);
function getCarPriceBetweenTwoDatesWithDiscount($db,$carID, $days, $startDate = null, $cityID = '') {
    switch ($days) {
        case ($days >= 1 && $days <= 3):
            $price = 'price1';
            break;
        case ($days >= 4 && $days <= 7):
            $price = 'price2';
            break;
        case ($days >= 8 && $days <= 15):
            $price = 'price3';
            break;
        case ($days >= 16 && $days <= 21):
            $price = 'price4';
            break;
        case ($days > 21):
            $price = 'price5';
            break;
        default:
            $price = 'price1';
    }

    $query = "SELECT * FROM cars WHERE carID = " . $carID;
    $results = mysqli_query($db, $query);
    $row = mysqli_fetch_object($results);

    $standardPrice = $row->$price;
    if ($startDate != null) {
        //check current month & year for both dates
        $new_start = date("n", strtotime($startDate));

        $query = "SELECT * FROM prices JOIN pickup ON prices.cityID = pickup.pickID WHERE pickup.pickUpName = '" . $cityID ."' AND prices.month = " . $new_start;
        $results = mysqli_query($db, $query);
        $customPrice = mysqli_fetch_object($results);

        if ($customPrice->price > 0) {
            $pret_nou = $standardPrice + $customPrice->price;
            $pret_nou = number_format($pret_nou, 2, '.', '');
            return $pret_nou;
        } else {
            return $standardPrice;
        }

    } else {
        return $standardPrice;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pickup = $_POST['pickup_location'];
    $pickup_date = $_POST['pickup_date'];
    $pickup_time = $_POST['pickup_time'];
    $dropoff_date = $_POST['return_date'];
    $dropoff_time = $_POST['return_time'];
    Session::put('pickup_location', $pickup);
    Session::put('pickup_date', $pickup_date);
    Session::put('pickup_time', $pickup_time);
    Session::put('return_date', $dropoff_date);
    Session::put('return_time', $dropoff_time);
}
?>

<style>
    @media (max-width: 767.98px) {
        #visible-tab {
            display: none;
        }
    }
    
</style>
<div class="sortby-sec" id="visible-tab">
    <div class="container">
        <div class="sorting-div">
            <div class="row d-flex align-items-center">
                <div class="col-xl-12 col-lg-12 col-sm-12 col-12">
                    <div class="product-filter-group">
                        <div class="grid-listview">
                            <ul>
                                <li>
                                    <a href="#" class="active" id="grid-tab">
                                        <i class="feather-grid"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" id="list-tab">
                                        <i class="feather-list"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Car Grid View -->
<section class="section car-listing" id="grid-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php foreach($cats as $cat) { ?>
                <div class="clear"></div>
                <h3><?= $cat['catName']; ?></h3>
                <div class="row">
                    <?php 
                        $query = "SELECT * FROM cat_car JOIN cars ON cat_car.carID = cars.carID WHERE status = 'active' AND cat_car.catID = " . $cat['catID'] . " ORDER BY 'order' ASC";
                        $results = mysqli_query($db, $query);
                        $cars = mysqli_fetch_all($results, MYSQLI_ASSOC);
                        foreach ($cars as $car) {
                            $cID = $car['carID'];
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
                            if ($_SESSION['pickup_location'] == null) $_SESSION['pickup_location'] = "Bucuresti";
                            $query = "SELECT * FROM pickup WHERE pickUpName = '" . $_SESSION['pickup_location'] . "'";
                            $results = mysqli_query($db, $query);
                            $location = mysqli_fetch_object($results);

                            $rent_list  = explode(' x ', $days);
                            if (count($rent_list) > 1) {
                                $high_price_per_day = $rent_list[1] + $rent_list[1] * $location->discount_percent / 100;
                                $high_price = round($high_price_per_day * $rent_list[0]);
                                $r_price    = round($rent_list[0] * $rent_list[1]);
                            }

                    ?>
                    <!-- col -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                        <div class="listing-item">										
                            <div class="listing-img">
                                <a href="listing-details.html">
                                    <img src="https://dpdrent.ro/uploads/cars/<?=$car['carPhoto']?>" style="height: 220px" alt="Toyota">
                                </a>
                                
                            </div>										
                            <div class="listing-content">
                                <div class="listing-features">
                                    
                                    <h3 class="listing-title">
                                        <a href="listing-details.html"><?php echo $car['carName'];?></a>
                                    </h3>																	  
                                    <div class="list-rating">							
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <span>(5.0)</span>
                                    </div>
                                </div>
                                <div class="listing-details-group">
                                    <ul>
                                        <?php if ($car['automatic']) { ?>
											<li>
												<span><img src="assets/img/icons/car-parts-01.svg" alt="Auto"></span>
												<p>Auto</p>
											</li>
										<?php } else { ?>
											<li>
												<span><img src="assets/img/icons/car-parts-05.svg" alt="Manual"></span>
												<p>Manual</p>
											</li>
										<?php } ?>
                                        <li>
											<span><img src="assets/img/icons/car-parts-02.svg" alt="10 KM"></span>
											<p><?php echo $car['limit_km']; ?> KM</p>
										</li>
                                        <li>
											<span><img src="assets/img/icons/car-parts-03.svg" alt="Petrol"></span>
											<p><?php echo $car['fuel']?></p>
										</li>
                                    </ul>	
                                    <ul>
                                        <li>
                                            <span><img src="assets/img/icons/car-parts-04.svg" alt="Power"></span>
                                            <p>Power</p>
                                        </li>
                                        <li>
                                            <span><img src="assets/img/icons/car-parts-05.svg" alt="2018"></span>
                                            <p>2018</p>	
                                        </li>
                                        <li>
                                            <span><img src="assets/img/icons/car-parts-06.svg" alt="Persons"></span>
                                            <p>5 Persons</p>
                                        </li>
                                    </ul>
                                </div>																 
                                <div class="listing-location-details">
                                    <div class="listing-price">
                                    </div>
                                    <?php
                                    if (count($rent_list) > 1) { ?>
                                        <h6><span class="red">Pret: </span><strike style="color:black;font-size: 15px">&euro;<?= $high_price?></strike></span> <span></span><span style="color:red;font-size: 25px">&euro;<?= $r_price ?>/ <?=$rent_list[0]?>Zi</span><br></h6>
                                    <?php } else { ?>
                                        <h6><strike style="font-size: 16px;margin-right: 5px; color: #000011">€<?php echo intval($car['price5'] * 1.1) . '~' . intval($car['price1'] * 1.1)?></strike><span style="color: red"><?php echo '€' . $car['price5'] . '~' . $car['price1']?> / Zi</span></h6>
                                    <?php } ?>
                                </div>
                                <div class="listing-button">
                                    <form action="rezervare.php" method="post">
                                        <input type="hidden" name="carId" id="carId" value="<?= $car['carID'] ?>" />
                                        <button type="submit" class="btn btn-order"><span><i class="feather-calendar me-2"></i></span>Rent Now</button>
                                    </form>
                                </div>	
                            </div>
                        </div>		 
                    </div>
                    <!-- /col -->
                    <?php } ?>
                </div>
                <?php } ?>
            </div>		
        </div>
    </div>
</section>	
<!-- /Car  View -->	

<!-- Car List View -->
<section class="section " id="list-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php foreach($cats as $cat) { ?>
                    <div class="clear"></div>
                    <h3><?= $cat['catName']; ?></h3>
                    <?php 
                        $query = "SELECT * FROM cat_car JOIN cars ON cat_car.carID = cars.carID WHERE status = 'active' AND cat_car.catID = " . $cat['catID'] . " ORDER BY 'order' ASC";
                        $results = mysqli_query($db, $query);
                        $cars = mysqli_fetch_all($results, MYSQLI_ASSOC);
                        foreach ($cars as $car) {
                            $cID = $car['carID'];
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
                            $query = "SELECT * FROM pickup WHERE pickUpName = '" . $_SESSION['pickup_location'] . "'";
                            $results = mysqli_query($db, $query);
                            $location = mysqli_fetch_object($results);

                            $rent_list  = explode(' x ', $days);
                            if (count($rent_list) > 1) {
                                $high_price_per_day = $rent_list[1] + $rent_list[1] * $location->discount_percent / 100;
                                $high_price = round($high_price_per_day * $rent_list[0]);
                                $r_price    = round($rent_list[0] * $rent_list[1]);
                            }

                    ?>
                    <div class="listview-car">
                        <div class="card">
                            <div class="blog-widget d-flex">
                                <div class="blog-img" style="overflow: unset">
                                    <a href="listing-details.html">
                                        <img src="https://dpdrent.ro/uploads/cars/<?=$car['carPhoto']?>" style="height: 180px;width:250px" alt="blog-img">
                                    </a>														    
                                </div>
                                <div class="bloglist-content w-100">
                                    <div class="card-body">
                                        <div class="blog-list-head d-flex">
                                            <div class="blog-list-title">
                                                <h3><a href="listing-details.html"><?= $car['carName']?></a></h3>
                                                <h6>Category : <span>Ferrarai</span></h6>		
                                            </div>
                                            <div class="blog-list-rate">
                                                <div class="list-rating">							
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <span>(5.0)</span>
                                                </div>
                                                <?php
                                                if (count($rent_list) > 1) { ?>
                                                    <h6><span class="red">Pret: </span><strike style="color:black;font-size: 15px">&euro;<?= $high_price?></strike></span> <span></span><span style="color:red;font-size: 25px">&euro;<?= $r_price ?>/ <?=$rent_list[0]?>Zi</span><br></h6>
                                                <?php } else { ?>
                                                    <h6><strike style="font-size: 16px;margin-right: 5px; color: #000011">€<?php echo intval($car['price5'] * 1.1) . '~' . intval($car['price1'] * 1.1)?></strike><?php echo '€' . $car['price5'] . '~' . $car['price1']?> <span>/ Zi</span></h6>
                                                <?php } ?>
                                            </div>
                                        </div>	
                                        <div class="listing-details-group">
                                            <ul>
                                                <?php if ($car['automatic']) { ?>
                                                    <li>
                                                        <span><img src="assets/img/icons/car-parts-01.svg" alt="Auto"></span>
                                                        <p>Auto</p>
                                                    </li>
                                                <?php } else { ?>
                                                    <li>
                                                        <span><img src="assets/img/icons/car-parts-05.svg" alt="Manual"></span>
                                                        <p>Manual</p>
                                                    </li>
                                                <?php } ?>
                                                <li>
                                                    <span><img src="assets/img/icons/car-parts-02.svg" alt="10 KM"></span>
                                                    <p><?php echo $car['limit_km']; ?> KM</p>
                                                </li>
                                                <li>
                                                    <span><img src="assets/img/icons/car-parts-03.svg" alt="Petrol"></span>
                                                    <p><?php echo $car['fuel']?></p>
                                                </li>
                                                <li>
                                                    <span><img src="assets/img/icons/car-parts-04.svg" alt="Power"></span>
                                                    <p>Power</p>
                                                </li>
                                                <li>
                                                    <span><img src="assets/img/icons/car-parts-05.svg" alt="2018"></span>
                                                    <p>2018</p>	
                                                </li>
                                                <li>
                                                    <span><img src="assets/img/icons/car-parts-06.svg" alt="Persons"></span>
                                                    <p>5 Persons</p>
                                                </li>
                                            </ul>	
                                        </div>	
                                        <div class="blog-list-head list-head-bottom d-flex">
                                            <div class="blog-list-title">
                                                <div class="title-bottom">
                                                    <div class="car-list-icon">
                                                        <img src="assets/img/cars/car-list-icon-01.png" alt="car">
                                                    </div>
                                                    <div class="address-info">
                                                        <h5><a href="#">Toyota Of Lincoln Park</a></h5>
                                                        <h6><i class="feather-map-pin me-2"></i>Newyork, USA</h6>
                                                    </div>
                                                </div>	
                                            </div>
                                            <div class="listing-button">
                                                <form action="rezervare.php" method="post">
                                                    <input type="hidden" name="carId" id="carId" value="<?= $car['carID']; ?>" >
                                                    <button type="submit" class="btn btn-order"><span><i class="feather-calendar me-2"></i></span>Rent Now</button>
                                                </form>
                                            </div>
                                        </div>	
                                    </div>					 
                                </div>			 
                            </div> 
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                </div>
            </div>		
        </div>
    </div>
</section>	
<!-- /Car List View -->	

<?php require_once './layout/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#list-content').css('display', 'none')
        $('#grid-content').show()
    });
    // Add event listeners to the tabs
    $('#grid-tab').on('click', function() {
        $('#list-content').css('display', 'none')
        $('#grid-content').show()
        $('#list-tab').removeClass('active')
        $(this).addClass('active')
    });

    $('#list-tab').on('click', function() {
        $('#list-content').show()
        $('#grid-content').css('display', 'none')
        $('#grid-tab').removeClass('active')
        $(this).addClass('active')
    });
</script>