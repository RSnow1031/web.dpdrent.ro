<?php
require_once 'core/init.php';
require_once './layout/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cID = $_POST['carId'];
    Session::put('carID', $cID);

    $pickup_date  = $_SESSION['pickup_date'] . ' ' . $_SESSION['pickup_time'];
    $dropoff_date  = $_SESSION['return_date'] . ' ' . $_SESSION['return_time'];
    $days = 0;
    $casco_days = 0;
    $hours = (strtotime($dropoff_date) - strtotime($pickup_date)) / 3600;
    if ($hours > 0) {
        if ($hours > 24) {
            if ((($hours) % 24) >= 4) {
                $d = ceil($hours / 24);
                $days = $d . ' x ' . getCarPriceBetweenTwoDatesWithDiscount($db, $cID, $d, $pickup_date, $_SESSION['pickup_location']);
                $casco_days = $d . ' x ' . getCarPriceBetweenTwoDatesWithDiscount($db, $cID, $d, $pickup_date);
            } else {
                $d = floor($hours / 24);
                $days = $d . ' x ' . getCarPriceBetweenTwoDatesWithDiscount($db, $cID, $d, $pickup_date, $_SESSION['pickup_location']);
                $casco_days = $d . ' x ' . getCarCascoBetweenTwoDates($db, $cID, $d, $pickup_date);
            }
        } else {
            $d = 1;
            $days = $d . ' x ' . getCarPriceBetweenTwoDatesWithDiscount($db, $cID, $d, $pickup_date, $_SESSION['pickup_location']);
            $casco_days = $d . ' x ' . getCarCascoBetweenTwoDates($db, $cID, $d, $pickup_date);
        }
    }

    $query = "SELECT * FROM pickup WHERE pickUpName = '" . $_SESSION['pickup_location'] . "'";
    $results = mysqli_query($db, $query);
    $location = mysqli_fetch_object($results);

    $total_price = 0;

    $rent_list  = explode(' x ', $days);
    if (count($rent_list) > 1) {
        $high_price_per_day = $rent_list[1] + $rent_list[1] * $location->discount_percent / 100;
        $high_price = round($high_price_per_day * $rent_list[0]);
        $r_price    = round($rent_list[0] * $rent_list[1]);
        $_SESSION['rent_list'] = $rent_list;
    }

    $total_price = $rent_list[0] * $rent_list[1];

    $casco_list = explode(' x ', $casco_days);

    $query = "SELECT * FROM cars WHERE carID = '" . $cID . "'";
    $results = mysqli_query($db, $query);
    $car = mysqli_fetch_object($results);

    $query = "SELECT * FROM car_photos WHERE carID = '" . $cID . "' ORDER BY primary_photo DESC";
    $results = mysqli_query($db, $query);
    $car_photos = mysqli_fetch_all($results, MYSQLI_ASSOC);

    $PickdateTime = new DateTime($_SESSION['pickup_date'] . ' ' . $_SESSION['pickup_time']);
    $DropdateTime = new DateTime($_SESSION['return_date'] . ' ' . $_SESSION['return_time']);

    if (date($office_start_time) > $PickdateTime->format('H:i') || date($office_end_time) < $PickdateTime->format('H:i') || date($office_start_time) > $DropdateTime->format('H:i') || date($office_end_time) < $DropdateTime->format('H:i'))        
    {
        $extra_content = 'Taxa extra hour';
        Session::put('extra_content', $extra_content);
    }
    else
    {
        $extra_content = 'Taxa livrare';
        Session::put('extra_content', $extra_content);
    }

    $extra_price = 10;

    if (date($office_start_time) > $PickdateTime->format('H:i') || date($office_end_time) < $PickdateTime->format('H:i'))
    {
        $extra_price += $office_extra_price;

    }

    if (date($office_start_time) > $DropdateTime->format('H:i') || date($office_end_time) < $DropdateTime->format('H:i'))
    {
        $extra_price += $office_extra_price;
    }

    Session::put('extra_price', $extra_price);

    $total_price += $extra_price;

    Session::put('casco', $casco_list);

    $_SESSION['casco_price'] = 0;
    

    if (isset($_POST['casco_check']))
    {
        
        if ($_POST['casco_check'] == 1)
        {
            Session::put('casco_price', $casco_list[1] * $casco_list[0]);
            Session::put('deposit', 0);
            $total_price += $casco_list[1] * $casco_list[0];
        }
        else
        {
            Session::put('casco_price', 0);
            Session::put('deposit', 1);
            $total_price = $_SESSION['total_price'] - $casco_list[1] * $casco_list[0];
        }
    }

    Session::put('distance_dropoff_price', 0);

    if ($_SESSION['same_location'] != 1) {
        $apiKey = "AIzaSyAqS0agVwwEXhsJ1bIGYTHG-t5KlaIlsCQ";
        $origin = $_SESSION['pickup_location']; // Starting location
        $destination = $_SESSION['return_location']; // Destination location

        // Build the request URL
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial";
        $url .= "&origins=" . urlencode($origin);
        $url .= "&destinations=" . urlencode($destination);
        $url .= "&key=" . urlencode($apiKey);

        // Make the request and decode the JSON response
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        $distance_dropoff_price = round($data['rows'][0]['elements'][0]['distance']['value']/1000 * $commision);
        Session::put('distance_dropoff_price', $distance_dropoff_price);
        $total_price += $distance_dropoff_price;
    }

    Session::put('total_price', $total_price);
    // $pickup = $_POST['pickup_location'];
    // $pickup_date = $_POST['pickup_date'];
    // $pickup_time = $_POST['pickup_time'];
    // $dropoff_date = $_POST['return_date'];
    // $dropoff_time = $_POST['return_time'];
    // Session::put('pickup_location', $pickup);
    // Session::put('pickup_date', $pickup_date);
    // Session::put('pickup_time', $pickup_time);
    // Session::put('return_date', $dropoff_date);
    // Session::put('return_time', $dropoff_time);
}


?>
<link rel="stylesheet" href="assets/css/alege-masina.css">

<!-- Breadscrumb Section -->
<div class="breadcrumb-bar">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-md-12 col-12">
                <div class="wizard">
                    <div class="wizard-inner">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <div class="connecting-line"></div>
                                <a href="" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>Choose Car</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <!-- <div class="connecting-line"></div> -->
                                <a href="" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span> <i style="color: #FFFFFF">Option</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <!-- <div class="connecting-line"></div> -->
                                <a href="" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab">3</span> <i style="color: #FFFFFF">Plata</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <!-- <div class="connecting-line"></div> -->
                                <a href="" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab">4</span> <i style="color: #FFFFFF">Confirmare</i></a>
                            </li>
                        </ul>
                    </div>
                </div>			
            </div>
        </div>
    </div>
</div>
<!-- /Breadscrumb Section -->
<!-- Detail Page Head-->
<section class="product-detail-head">
    <div class="container">
        <div class="detail-page-head">
            <div class="detail-headings">
                <div class="star-rated">
                    <div class="list-rating">
                        <span class="year">2023</span>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <span class="d-inline-block average-list-rating"> 5.0 </span>
                    </div>
                    <div class="camaro-info">
                        <h3>Chevrolet Camaro</h3>
                        <div class="camaro-location">
                            <div class="camaro-location-inner">
                                <i class="feather-map-pin me-2"></i>
                                
                                <span class="me-2"> <b>Location :</b> Miami St, Destin, FL 32550, USA </span> 
                            </div>
                            <div class="camaro-locations-inner">    
                                <i class="feather-eye me-2"></i>
                                
                                <span><b>Views :</b> 250 </span>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
            <div class="details-btn">
                <a href="#"> <img src="assets/img/git-compare.svg" alt="Icon"> Compare</a>
                <a href="#"><i class="feather-heart"></i> Wishlist</a>
            </div>				  
        </div>
    </div>
</section>
<!-- /Detail Page Head-->
<div class="container"></div>

<section class="signup-step-container">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="wizard">
                    <!-- <form role="form" action="index.html" class="login-box"> -->
                    
                        <div class="tab-content" id="main_form">
                            <div class="tab-pane active" role="tabpanel" id="step1">
                            <section class="section product-details">
                                
                                <div class="container">
                                    <div class="row">
                                        <div class="col-4 offset-8">
                                            <div class="list-inline pull-right d-flex">
                                                <a href="/inchirieri-masini.php" class="btn btn-success" style="margin-right: 10px; width: 200px">Another Car</a>
                                                <a href="/alege-optiune.php" class="btn btn-primary w-100">Choose Car</a>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-4 theiaStickySidebar">
                                            <?php include('./layout/calculator.php');?>
                                            
                                            
                                            <div class="review-sec mt-0">
                                                <div class="review-header">
                                                    <h4>Book Details</h4>
                                                </div>
                                                <div class="booking-info service-tax">		
                                                    <ul>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                <label>Pickup Location: &nbsp;&nbsp;&nbsp;<?= $_SESSION['pickup_location']; ?></label>												
                                                            </div>
                                                        </li>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                <label>Dropoff Location: &nbsp;&nbsp;&nbsp;<?= $_SESSION['return_location']; ?></label>												
                                                            </div>
                                                        </li>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                <label>Pickup Date: &nbsp;&nbsp;&nbsp;<?= $_SESSION['pickup_date'] . ' ' . $_SESSION['pickup_time']; ?></label>												
                                                            </div>
                                                        </li>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                <label>Dropoff Date: &nbsp;&nbsp;&nbsp;<?= $_SESSION['return_date'] . ' ' . $_SESSION['return_time']; ?></label>												
                                                            </div>
                                                        </li>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                <label>Pret pe zi: &nbsp;&nbsp;&nbsp;<?= $_SESSION['rent_list'][1]; ?></label>												
                                                            </div>
                                                        </li>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                <label>Zile rezervare: &nbsp;&nbsp;&nbsp;<?= $_SESSION['rent_list'][0]; ?></label>												
                                                            </div>
                                                        </li>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                <label><?= $extra_content;?>: &nbsp;&nbsp;&nbsp;&euro;<?= $extra_price;?></label>												
                                                            </div>
                                                        </li>
                                                        <?php 
                                                            if ($_SESSION['distance_dropoff_price'] > 0) { ?>
                                                            <li class="column-group-main">
                                                                <div class="input-block">
                                                                    <label>Predare in locatie diferita: &nbsp;&nbsp;&nbsp;&euro;<?= $_SESSION['distance_dropoff_price'];?></label>												
                                                                </div>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <hr>
                                                <ul>
                                                    <li class="column-group-main">
                                                        <div class="input-block">
                                                            <label>Casco Pret: &nbsp;&nbsp;&nbsp;&euro;<?= $_SESSION['casco_price'];?></label>												
                                                        </div>
                                                    </li>
                                                    <li class="column-group-main">
                                                        <div class="input-block">
                                                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                                <input type="text" name="casco" hidden value="<?= $casco_list[1]?>">
                                                                <input type="text" name="carId" hidden value="<?= $car->carID?>">
                                                                <?php if (intval($_SESSION['casco_price']) == 0) { ?>
                                                                    <input type="text" name="casco_check" hidden value="1">
                                                                    <label>Full casco (€<?= $casco_list[1]?>/zi): &nbsp;&nbsp;&nbsp;<button class="btn btn-primary" type="submit">ADAUGA</button</label>	
                                                                <?php } else { ?>
                                                                    <input type="text" name="casco_check" hidden value="2">
                                                                    <label>Full casco (€<?= $casco_list[1]?>/zi): &nbsp;&nbsp;&nbsp;<button class="btn btn-danger" type="submit">STERGE</button</label>	
                                                                <?php }?>
                                                            </form>											
                                                        </div>
                                                    </li>
                                                    <li class="column-group-main">
                                                        <div class="input-block">
                                                            <label>Depozit: &nbsp;&nbsp;&nbsp;&euro;
                                                            <?php if (intval($_SESSION['casco_price']) == 0) { ?>
                                                                <?= $car->deposit;?>
                                                            <?php } else { ?>
                                                                0
                                                            <?php }?>  
                                                            </label>												
                                                        </div>
                                                    </li>
                                                </ul>
                                                <hr>
                                                <ul>
                                                    <li class="column-group-main">
                                                        <div class="input-block">
                                                            <label style="color: red; font-size: 25px">TOTAL PRICE: &nbsp;&nbsp;&nbsp;&euro;<?= $_SESSION['total_price'];?></label>												
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
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
                                                        <div><img src="https://dpdrent.ro/uploads/carsinner/<?= $photo['photo']; ?>" alt="Slider" style="height: 150px"></div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="review-sec extra-service">
                                                <div class="review-header">
                                                    <h4>Car Details</h4>
                                                </div>
                                                <span>Baby Seat - $10</span>
                                            </div>
                                            <div class="review-sec extra-service">
                                                <div class="review-header">
                                                    <h4>Extra Service</h4>
                                                </div>
                                                <span>Baby Seat - $10</span>
                                            </div>
                                            <!--Listing Features Section-->
                                            <div class="review-sec specification-card ">
                                                <div class="review-header">
                                                    <h4>Specifications</h4>
                                                </div>
                                                <div class="card-body">
                                                <div class="lisiting-featues">
                                                    <div class="row">
                                                        <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                                            <div class="feature-img">
                                                                <img src="assets/img/specification/specification-icon-1.svg" alt="Icon">
                                                            </div>
                                                            <div class="featues-info">
                                                                <span>Body </span>
                                                                <h6> Sedan</h6>
                                                            </div>
                                                        </div>
                                                        <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                                            <div class="feature-img">
                                                                <img src="assets/img/specification/specification-icon-2.svg" alt="Icon">
                                                            </div>
                                                            <div class="featues-info">
                                                                <span>Make </span>
                                                                <h6> Nisssan</h6>
                                                            </div>
                                                        </div>
                                                        <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                                            <div class="feature-img">
                                                                <img src="assets/img/specification/specification-icon-3.svg" alt="Icon">
                                                            </div>
                                                            <div class="featues-info">
                                                                <span>Transmission </span>
                                                                <h6> Automatic</h6>
                                                            </div>
                                                        </div>
                                                        <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                                            <div class="feature-img">
                                                                <img src="assets/img/specification/specification-icon-4.svg" alt="Icon">
                                                            </div>
                                                            <div class="featues-info">
                                                                <span>Fuel Type </span>
                                                                <h6> Diesel</h6>
                                                            </div>
                                                        </div>
                                                        <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                                            <div class="feature-img">
                                                                <img src="assets/img/specification/specification-icon-5.svg" alt="Icon">
                                                            </div>
                                                            <div class="featues-info">
                                                                <span>Mileage </span>
                                                                <h6>16 Km</h6>
                                                            </div>
                                                        </div>
                                                        <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                                            <div class="feature-img">
                                                                <img src="assets/img/specification/specification-icon-6.svg" alt="Icon">
                                                            </div>
                                                            <div class="featues-info">
                                                                <span>Drivetrian </span>
                                                                <h6>Front Wheel</h6>
                                                            </div>
                                                        </div>
                                                        <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                                            <div class="feature-img">
                                                                <img src="assets/img/specification/specification-icon-7.svg" alt="Icon">
                                                            </div>
                                                            <div class="featues-info">
                                                                <span>Year</span>
                                                                <h6> 2018</h6>
                                                            </div>
                                                        </div>
                                                        <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                                            <div class="feature-img">
                                                                <img src="assets/img/specification/specification-icon-8.svg" alt="Icon">
                                                            </div>
                                                            <div class="featues-info">
                                                                <span>AC </span>
                                                                <h6> Air Condition</h6>
                                                            </div>
                                                        </div>
                                                        <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                                            <div class="feature-img">
                                                                <img src="assets/img/specification/specification-icon-9.svg" alt="Icon">
                                                            </div>
                                                            <div class="featues-info">
                                                                <span>VIN </span>
                                                                <h6> 45456444</h6>
                                                            </div>
                                                        </div>
                                                        <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                                            <div class="feature-img">
                                                                <img src="assets/img/specification/specification-icon-10.svg" alt="Icon">
                                                            </div>
                                                            <div class="featues-info">
                                                                <span>Door </span>
                                                                <h6> 4 Doors</h6>
                                                            </div>
                                                        </div>
                                                        <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                                            <div class="feature-img">
                                                                <img src="assets/img/specification/specification-icon-11.svg" alt="Icon">
                                                            </div>
                                                            <div class="featues-info">
                                                                <span>Brake </span>
                                                                <h6> ABS</h6>
                                                            </div>
                                                        </div>
                                                        <div class="featureslist d-flex align-items-center col-xl-3 col-md-4 col-sm-6">
                                                            <div class="feature-img">
                                                                <img src="assets/img/specification/specification-icon-12.svg" alt="Icon">
                                                            </div>
                                                            <div class="featues-info">
                                                                <span>Engine (Hp) </span>
                                                                <h6> 3,000</h6>
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
                            
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step2">
                                <h4 class="text-center">Step 2</h4>
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address 1 *</label> 
                                        <input class="form-control" type="text" name="name" placeholder=""> 
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City / Town *</label> 
                                        <input class="form-control" type="text" name="name" placeholder=""> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country *</label> 
                                        <select name="country" class="form-control" id="country">
                                            <option value="NG" selected="selected">Nigeria</option>
                                            <option value="NU">Niue</option>
                                            <option value="NF">Norfolk Island</option>
                                            <option value="KP">North Korea</option>
                                            <option value="MP">Northern Mariana Islands</option>
                                            <option value="NO">Norway</option>
                                        </select>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Registration No.</label> 
                                        <input class="form-control" type="text" name="name" placeholder=""> 
                                    </div>
                                </div>
                                </div>
                                
                                
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <li><button type="button" class="default-btn next-step skip-btn">Skip</button></li>
                                    <li><button type="button" class="default-btn next-step">Continue</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step3">
                                <h4 class="text-center">Step 3</h4>
                                    <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account Name *</label> 
                                        <input class="form-control" type="text" name="name" placeholder=""> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Demo</label> 
                                        <input class="form-control" type="text" name="name" placeholder=""> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Inout</label> 
                                        <input class="form-control" type="text" name="name" placeholder=""> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Information</label> 
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Select file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Number *</label> 
                                        <input class="form-control" type="text" name="name" placeholder=""> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Input Number</label> 
                                        <input class="form-control" type="text" name="name" placeholder=""> 
                                    </div>
                                </div>
                                    </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <li><button type="button" class="default-btn next-step skip-btn">Skip</button></li>
                                    <li><button type="button" class="default-btn next-step">Continue</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step4">
                                <h4 class="text-center">Step 4</h4>
                                <div class="all-info-container">
                                    <div class="list-content">
                                        <a href="#listone" data-toggle="collapse" aria-expanded="false" aria-controls="listone">Collapse 1 <i class="fa fa-chevron-down"></i></a>
                                        <div class="collapse" id="listone">
                                            <div class="list-box">
                                                <div class="row">
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>First and Last Name *</label> 
                                                            <input class="form-control" type="text"  name="name" placeholder="" disabled="disabled"> 
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Phone Number *</label> 
                                                            <input class="form-control" type="text" name="name" placeholder="" disabled="disabled"> 
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-content">
                                        <a href="#listtwo" data-toggle="collapse" aria-expanded="false" aria-controls="listtwo">Collapse 2 <i class="fa fa-chevron-down"></i></a>
                                        <div class="collapse" id="listtwo">
                                            <div class="list-box">
                                                <div class="row">
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Address 1 *</label> 
                                                            <input class="form-control" type="text" name="name" placeholder="" disabled="disabled"> 
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>City / Town *</label> 
                                                            <input class="form-control" type="text" name="name" placeholder="" disabled="disabled"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Country *</label> 
                                                            <select name="country2" class="form-control" id="country2" disabled="disabled">
                                                                <option value="NG" selected="selected">Nigeria</option>
                                                                <option value="NU">Niue</option>
                                                                <option value="NF">Norfolk Island</option>
                                                                <option value="KP">North Korea</option>
                                                                <option value="MP">Northern Mariana Islands</option>
                                                                <option value="NO">Norway</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Legal Form</label> 
                                                            <select name="legalform2" class="form-control" id="legalform2" disabled="disabled">
                                                                <option value="" selected="selected">-Select an Answer-</option>
                                                                <option value="AG">Limited liability company</option>
                                                                <option value="GmbH">Public Company</option>
                                                                <option value="GbR">No minimum capital, unlimited liability of partners, non-busines</option>
                                                            </select> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Business Registration No.</label> 
                                                            <input class="form-control" type="text" name="name" placeholder="" disabled="disabled"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Registered</label> 
                                                            <select name="vat2" class="form-control" id="vat2" disabled="disabled">
                                                                <option value="" selected="selected">-Select an Answer-</option>
                                                                <option value="yes">Yes</option>
                                                                <option value="no">No</option>
                                                            </select> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Seller</label> 
                                                            <input class="form-control" type="text" name="name" placeholder="" disabled="disabled"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Company Name *</label> 
                                                            <input class="form-control" type="password" name="name" placeholder="" disabled="disabled"> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-content">
                                        <a href="#listthree" data-toggle="collapse" aria-expanded="false" aria-controls="listthree">Collapse 3 <i class="fa fa-chevron-down"></i></a>
                                        <div class="collapse" id="listthree">
                                            <div class="list-box">
                                                <div class="row">
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Name *</label> 
                                                            <input class="form-control" type="text" name="name" placeholder=""> 
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Number *</label> 
                                                            <input class="form-control" type="text" name="name" placeholder=""> 
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <li><button type="button" class="default-btn next-step">Finish</button></li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</section>





<!-- Modal -->
    <div class="modal custom-modal fade check-availability-modal" id="pages_edit" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-header text-start mb-0">
                        <h4 class="mb-0 text-dark fw-bold">Availability Details</h4>
                    </div>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="align-center" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="available-for-ride">
                                <p><i class="fa-regular fa-circle-check"></i>Chevrolet Camaro is available for a ride</p>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="row booking-info">
                                <div class="col-md-4 pickup-address">
                                    <h5>Pickup</h5>
                                    <p>45, 4th Avanue  Mark Street USA</p>
                                    <span>Date & time : 11 Jan 2023</span>
                                </div>
                                <div class="col-md-4 drop-address">
                                    <h5>Drop Off</h5>
                                    <p>78, 10th street Laplace USA</p>
                                    <span>Date & time : 11 Jan 2023</span>
                                </div>
                                <div class="col-md-4 booking-amount">
                                    <h5>Booking Amount</h5>
                                    <h6><span>$300 </span> /day</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="booking-info seat-select">
                                <h6>Extra Service</h6>
                                <label class="custom_check">
                                    <input type="checkbox" name="rememberme" class="rememberme">
                                    <span class="checkmark"></span>
                                    Baby Seat - <span class="ms-2">$10</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="booking-info pay-amount">
                                <h6>Deposit Option</h6>
                                <div class="radio radio-btn">
                                    <label>
                                        <input type="radio" name="radio"> Pay Deposit
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="radio"> Full Amount
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="booking-info service-tax">
                                <ul>
                                    <li>Booking Price <span>$300</span></li>
                                    <li>Extra Service <span>$10</span></li>
                                    <li>Tax <span>$5</span></li>
                                </ul>
                            </div>
                            <div class="grand-total">
                                <h5>Grand Total</h5>
                                <span>$315</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="booking.html" class="btn btn-back">Go to Details<i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
<!-- /Modal -->
<?php require_once './layout/footer.php'; ?>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script>
   // ------------step-wizard-------------
$(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target);
        if (target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {
        var active = $('.wizard .nav-tabs li.active');
        active.next().removeClass('disabled');
        nextTab(active);

    });
    $(".prev-step").click(function (e) {

        var active = $('.wizard .nav-tabs li.active');
        prevTab(active);

    });
});

$(document).ready(function() {
    // var dateToday = new Date();
    // $("#pickup_date_cal").datetimepicker({
    //     format: 'DD-MM-YYYY',
    //     icons: {
    //         up: "fas fa-angle-up",
    //         down: "fas fa-angle-down",
    //         next: 'fas fa-angle-right',
    //         previous: 'fas fa-angle-left'
    //     },
    // });

    // $("#return_date_cal").datetimepicker({
    //     format: 'DD-MM-YYYY',
    //     icons: {
    //         up: "fas fa-angle-up",
    //         down: "fas fa-angle-down",
    //         next: 'fas fa-angle-right',
    //         previous: 'fas fa-angle-left'
    //     },
    // });

    if ($('#same_location').prop('checked'))
    {
        $('#show_return_location').css( "display", "none" );
    }
    else
    {
        $('#show_return_location').css( "display", " " );
        $('#return_location').val($('#pickup_location').val());
    }
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

$('.nav-tabs').on('click', 'li', function() {
    $('.nav-tabs li.active').removeClass('active');
    $(this).addClass('active');
});

$('#same_location').click(function() {
    if ($('#same_location').prop('checked'))
    {
        $('#show_return_location').css( "display", "none" );
    }
    else
    {
        console.log('show return')
        $('#show_return_location').show();
        $('#return_location').val($('#pickup_location').val());
    }
});
</script>