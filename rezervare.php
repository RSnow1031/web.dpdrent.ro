<?php
require_once 'core/init.php';
require_once './layout/header.php';

if (!Session::exists('carID')) {
    echo '<script>window.location.href = "/inchirieri-masini.php";</script>';
    exit();
}

if (Session::exists('step') && Session::get('step') > 1)
    Session::put('step', 3);

$query = "SELECT * FROM cars WHERE carID = '" . $_SESSION['carID'] . "'";
$results = mysqli_query($db, $query);
$car = mysqli_fetch_object($results);

$cID = $_SESSION['carID'];

$query = "SELECT * FROM car_photos WHERE carID = '" . $_SESSION['carID'] . "' ORDER BY primary_photo DESC";
$results = mysqli_query($db, $query);
$car_photos = mysqli_fetch_all($results, MYSQLI_ASSOC);

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

Session::put('days', $days);
Session::put('casco_days', $casco_days);

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

Session::put('distance_dropoff_price', 0);

Session::put('drop_off_price', 0);

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
    Session::put('drop_off_price', $distance_dropoff_price);
    $total_price += $distance_dropoff_price;
}

Session::put('total_price', $total_price);

?>
<link rel="stylesheet" href="assets/css/alege-masina.css">
<!-- Breadscrumb Section -->
<div class="breadcrumb-bar section services" style="padding: 10px">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-md-12 col-12">
                <div class="container ">	
                    <!-- /Heading title -->
                    <div class="services-work">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-4 " data-aos="fade-down" >
                                <div class="services-group">
                                    <div class="services-icon <?php if (Session::exists('step') && Session::get('step') == 1) { ?>teeter-element<?php } ?>" style="border: 2px dashed #0db02b" >
                                        <img class="icon-img" style="background-color: #0db02b" src="assets/img/icons/services-icon-01.svg" alt="Choose Locations">
                                    </div>
                                    <div class="<?php if (Session::exists('step') && Session::get('step') > 1) { ?>line-progress<?php } else { ?>line<?php } ?>"></div>
                                    <div class="services-content <?php if (Session::exists('step') && Session::get('step') == 1) { ?>teeter-element<?php } ?>">
                                        <h3 style="color: #0db02b">1. Choose Location</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon <?php if (Session::exists('step') && Session::get('step') == 2) { ?>teeter-element<?php } ?>" <?php if ($_SESSION['step'] > 1) { ?> style="border: 2px dashed #0db02b" <?php } else { ?> style="border: 2px dashed #201F1D" <?php } ?>>
                                        <img class="icon-img" <?php if ($_SESSION['step'] > 1) { ?> style="background-color: #0db02b" <?php } else { ?> style="background-color: #201F1D"  <?php } ?> src="assets/img/icons/services-icon-02.svg" alt="Choose Locations">
                                    </div>
                                    <div class="<?php if (Session::exists('step') && Session::get('step') > 2) { ?>line-progress<?php } else { ?>line<?php } ?>"></div>
                                    <div class="services-content <?php if (Session::exists('step') && Session::get('step') == 2) { ?>teeter-element<?php } ?>">
                                        <h3 <?php if ($_SESSION['step'] > 1) { ?> style="color: #0db02b" <?php } else { ?> style="color: #FFFFFF" <?php } ?>> 2. Choose Car</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon <?php if (Session::exists('step') && Session::get('step') == 3) { ?>teeter-element<?php } ?>" <?php if ($_SESSION['step'] > 2) { ?> style="border: 2px dashed #0db02b" <?php } else { ?> style="border: 2px dashed #201F1D" <?php } ?>>
                                        <img class="icon-img" <?php if ($_SESSION['step'] > 2) { ?> style="background-color: #0db02b" <?php } else { ?> style="background-color: #201F1D"  <?php } ?> src="assets/img/icons/services-icon-03.svg" alt="Choose Locations">
                                    </div>
                                    <div class="services-content <?php if (Session::exists('step') && Session::get('step') == 3) { ?>teeter-element<?php } ?>">
                                        <h3 <?php if ($_SESSION['step'] > 2) { ?> style="color: #0db02b" <?php } else { ?> style="color: #FFFFFF" <?php } ?>> 3. Book a Car</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Breadscrumb Section -->

<div class="container"></div>

<section class="signup-step-container">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="wizard">
                    <!-- <form role="form" action="" class=" needs-validation" method="POST" id="rezervare_form" novalidate> -->
                    <form role="form" action="/ajax/rezervare-form.php" class=" needs-validation" method="POST"  novalidate>
                        <div class="tab-content" id="main_form">
                            <div class="tab-pane active" role="tabpanel" id="step1">
                            <section class="section product-details">
                                
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-4 theiaStickySidebar">
                                            <div class="review-sec mt-0">
                                                <div class="review-header">
                                                    <h4>Detalii Comanda</h4>
                                                </div>
                                                <div class="booking-info service-tax">		
                                                    <ul>
                                                        <li class="column-group-main">
                                                            <div class="input-block">Preluare:
                                                                <!-- <label class="pull-right">, Romania</label> -->
                                                                <label id="text_locatie_preluare" class="pull-right"><?= $_SESSION['pickup_location']; ?></label>											
                                                            </div>
                                                        </li>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                Pickup Date: 
                                                                <label id="text_data_preluare" class="pull-right"><?= $_SESSION['pickup_date'] . ' ' . $_SESSION['pickup_time']; ?></label>												
                                                            </div>
                                                        </li>
                                                        <hr>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                Returnare Location:
                                                                <!-- <label class="pull-right">, Romania</label> -->
                                                                <label class="pull-right" id="text_locatie_returnare"><?= $_SESSION['return_location']; ?></label>												
                                                            </div>
                                                        </li>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                Dropoff Date: 
                                                                <label id="text_data_returnare" class="pull-right"><?= $_SESSION['return_date'] . ' ' . $_SESSION['return_time']; ?></label>												
                                                            </div>
                                                        </li>
                                                        <hr>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                Pret pe zi:
                                                                <label class="pull-right">&euro;</label><label id="text_pret_zi" class="pull-right"><?= $_SESSION['rent_list'][1]; ?></label>												
                                                            </div>
                                                        </li>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                Zile rezervare:
                                                                <label id="text_nr_zile" class="pull-right"> &nbsp;&nbsp;&nbsp;<?= $_SESSION['rent_list'][0]; ?></label>												
                                                            </div>
                                                        </li>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                <span id="tax_hour"><?= $extra_content;?>:</span>
                                                                <label id="text_taxa_livrare" class="pull-right" > &nbsp;&nbsp;&nbsp;&euro;<?= $extra_price;?></label>												
                                                            </div>
                                                        </li>
                                                        <li class="column-group-main">
                                                            <div class="input-block">
                                                                Predare in locatie diferita:
                                                                <label id="text_drop_off" class="pull-right">&euro;<?= $_SESSION['distance_dropoff_price'];?></label>												
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <hr>

                                                <ul>
                                                    <li class="column-group-main">
                                                        <div class="input-block">
                                                            Casco Pret:
                                                            <label id="text_casco" class="pull-right">&euro;0</label>											
                                                        </div>
                                                    </li>
                                                    
                                                </ul>
                                                <hr>
                                                <ul>
                                                    <li class="column-group-main">
                                                        Extra incluse:
                                                        <ul class="extra-rez listlist"></ul>
                                                    </li>
                                                    
                                                </ul>
                                                <hr>
                                                <ul>
                                                    <li class="column-group-main">
                                                        <div class="input-block">
                                                            TOTAL PRICE:
                                                            <label id="text_total" class="pull-right" style="color: red; font-size: 25px; margin: 0px"><?= $_SESSION['total_price'];?></label>
                                                            <label class="pull-right" style="color: red; font-size: 25px; margin: 0px">&euro;</label>
                                                            <br>											
                                                        </div>
                                                    </li>
                                                </ul>
                                                <hr>
                                                <ul>
                                                    <li class="column-group-main">
                                                        <div class="input-block">
                                                            Depozit:
                                                            <label id="text_depozit" class="pull-right">0</label><label class="pull-right">&euro;</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- <div class="review-sec mt-0">
                                                <div class="review-header">
                                                    <h4>Suna Acum - 24/7</h4>
                                                </div>
                                                <div class="booking-info service-tax">
                                                    <i class="fab fa-whatsapp" style="color: #00e900;font-size:30px;margin-right:10px"></i><a style="font-size: 25px" href="tel://00 40 (722) 332549" class="nodecoration">(+4)0722.33.25.49</a>
                                                </div>
                                            </div>
                                            <div class="review-sec mt-0">
                                                <div class="review-header">
                                                    <h4>Informatii</h4>
                                                </div>
                                                <div class="booking-info service-tax">
                                                    <?php 
                                                        $query = "SELECT * FROM content WHERE pageURL = 'rezervare'";
                                                        $results = mysqli_query($db, $query);
                                                        $page = mysqli_fetch_object($results);
                                                        echo $page->pageContent;
                                                    ?>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="detail-product">
                                                <div class="col-xl-12 col-lg-12 col-sm-12 col-12">
                                                    <div class="row">
                                                        <div class="listview-car">
                                                            <div class="card">
                                                                <div class="blog-widget d-flex">
                                                                    <div class="blog-img" style="width: 30%">
                                                                        <a href="listing-details.html">
                                                                            <img src="https://dpdrent.ro/uploads/cars/<?= $car->carPhoto; ?>" class="img-fluid" alt="blog-img">
                                                                        </a>														    
                                                                    </div>
                                                                    <div class="bloglist-content w-100">
                                                                    <div class="card-body">
                                                                            <div class="blog-list-head d-flex">
                                                                                <div class="blog-list-title">
                                                                                    <h3><a href="listing-details.html"><?= $car->carName?></a></h3>
                                                                                </div>
                                                                            </div>	
                                                                            <div class="listing-details-group">
                                                                                <ul>
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
                                                                            <div class="clear"></div>
                                                                            <div class="review_wrap">
                                                                                <div class="review_comment">
                                                                                    <p>
                                                                                        <?= $car->carText; ?>
                                                                                    </p>
                                                                                    <a href="#" class="read_more"></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>					 
                                                                    </div>			 
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form method="post" >

                                            <div class="review-sec extra-service">
                                                <div class="review-header">
                                                    <h4>Detalii rezervare</h4>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <div class="input-block">
                                                            <label>Locatie Preluare:</label>												
                                                            <div class="group-img">
                                                                <!-- <input type="text" class="form-control" placeholder="Enter City, Airport, or Address"> -->
                                                                <select class="form-control" name="locatie_preluare" id="locatie_preluare" onchange="calculateDistances();">
                                                                    <option <?php if ($_SESSION['return_location'] == 'Bucuresti') echo 'selected';?>>Bucuresti</option>
                                                                    <option <?php if ($_SESSION['return_location'] == 'Aeroport Otopeni') echo 'selected';?>>Aeroport Otopeni</option>
                                                                    <option <?php if ($_SESSION['return_location'] == 'Brasov') echo 'selected';?>>Brasov</option>
                                                                    <option <?php if ($_SESSION['return_location'] == 'Aeroport Brasov') echo 'selected';?>>Aeroport Brasov</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <div class="input-block">
                                                            <label>Locatie Returnare:</label>												
                                                            <div class="group-img">
                                                                <!-- <input type="text" class="form-control" id="locatie_returnare" name="locatie_returnare"> -->
                                                                <input type="text" class="form-control" id="locatie_returnare" value="<?= $_SESSION['return_location']?>" name="locatie_returnare" onchange="calculateDistances();">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <div class="input-block">																	
                                                            <label>Data Preluare:</label>
                                                        </div>
                                                        <div class="input-block-wrapp d-flex">
                                                            <div class="input-block date-widget" style="margin-right: 5px;">												
                                                                <div class="group-img">
                                                                <input type="text" class="form-control " id="data_preluare" name="data_preluare" value="<?= (Session::exists('pickup_date')) ? Session::get('pickup_date') : date("d-m-Y"); ?>" id="pickup_date">
                                                                </div>
                                                            </div>
                                                            <div class="input-block time-widge">											
                                                                <div class="group-img">
                                                                <input type="text" class="form-control timepicker" name="pickup_time" id="pickup_time" value="<?= (Session::exists('pickup_time')) ? $_SESSION['pickup_time'] : $current_time; ?>">
                                                                </div>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <div class="input-block">																	
                                                            <label>Data Returnare:</label>
                                                        </div>
                                                        <div class="input-block-wrapp d-flex">
                                                            <div class="input-block date-widge" style="margin-right: 5px;">												
                                                                <div class="group-img">
                                                                <input type="text" class="form-control " id="data_returnare" name="data_returnare" value="<?= (Session::exists('return_date')) ? Session::get('return_date') : date("d-m-Y", strtotime("+2 days"))?>">
                                                                </div>
                                                            </div>
                                                            <div class="input-block time-widge">											
                                                                <div class="group-img">
                                                                <input type="text" class="form-control timepicker" name="return_time" id="return_time" value="<?= (Session::exists('return_time')) ? $_SESSION['return_time'] : $current_time; ?>">
                                                                </div>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="review-sec extra-service">
                                                <div class="review-header">
                                                    <h4>Alege tipul de asigurare potrivit pentru tine !</h4>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-6 col-md-6">
                                                        <div class="input-block">
                                                            <label class="custom_radio">
                                                                <!-- <input type="text" hidden name="casco_add" id="casco_add" value="1" required> -->
                                                                <a class="btn" style="width: 200px; background-color: #FFFFFF; border: 2px solid #FFA633">FULL CASCO €<?= $_SESSION['casco'][1]?>/zi</a>
                                                                <div class="help-tip1">
                                                                    <p>No tienes proteccion para tu auto.<br> Podria perder el varlor total del deposito si el automovil se dana durante su arrendamiento.</p>
                                                                </div>
                                                                <!-- <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled tooltip">
                                                                <i class="feather-info" title="Do you like my fa-cog icon?"></i>
                                                                </span> -->
                                                            </label>
                                                            <!-- <span class="pull-right" id="casco_pe_zi"><?= $_SESSION['casco'][1]?></span><span class="pull-right">&euro;</span> -->
                                                        </div>
                                                        <div class="input-block">
                                                            <label class="custom_radio">
                                                                <!-- <input type="radio" name="casco_add" id="deposit" value="2" required> -->
                                                                <a class="btn" id="btn-add-casco" style="width: 200px; background-color: #FFFFFF; border: 2px solid #FFA633">Depozit <?=$car->deposit?></a>
                                                                <div class="help-tip">
                                                                <p>Exento al cliente por la cantidad que tiene que pagar en caso de danos.<br />
                                                                </p>
                                                            </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-lg-6 col-12 mb-3">✅️ Toate taxele incluse</div>
                                                            <div class="col-md-6 col-sm-6 col-lg-6 col-12 mb-3">✅️ Kilometri Nelimitati</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-lg-6 col-12 mb-3">✅️ Asistenta Non-Stop</div>
                                                            <div class="col-md-6 col-sm-6 col-lg-6 col-12 mb-3">✅️ Inlocuire auto gratuit</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review-sec extra-service">
                                                <div class="review-header">
                                                    <h4>Detalii sofer</h4>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <div class="input-block">																	
                                                            <label>Nume si Prenume:</label>
                                                        </div>
                                                        <div class="input-block-wrapp">
                                                            <div class="input-block date-widget">												
                                                                <div class="group-img">
                                                                    <input type="text" class="form-control " id="nume" name="nume" required>
                                                                </div>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <div class="input-block">																	
                                                            <label>Tara:</label>
                                                        </div>
                                                        <div class="input-block-wrapp">
                                                            <div class="input-block date-widget">												
                                                                <div class="group-img">
                                                                    <input type="text" class="form-control " id="tara" name="tara" required>
                                                                </div>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <div class="input-block">																	
                                                            <label>Judet:</label>
                                                        </div>
                                                        <div class="input-block-wrapp">
                                                            <div class="input-block date-widget">												
                                                                <div class="group-img">
                                                                    <input type="text" class="form-control " id="judet" name="judet" required>
                                                                </div>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <div class="input-block">																	
                                                            <label>Oras:</label>
                                                        </div>
                                                        <div class="input-block-wrapp">
                                                            <div class="input-block date-widget">												
                                                                <div class="group-img">
                                                                    <input type="text" class="form-control " id="oras" name="oras" required >
                                                                </div>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-12 col-12">
                                                        <div class="input-block">																	
                                                            <label>Adresa:</label>
                                                        </div>
                                                        <div class="input-block-wrapp">
                                                            <div class="input-block date-widget">												
                                                                <div class="group-img">
                                                                    <input type="text" class="form-control " id="adresa" name="adresa" placeholder="Strada, Numar, Bloc, Apartament" required>
                                                                </div>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <div class="input-block">																	
                                                            <label>E-mail:</label>
                                                        </div>
                                                        <div class="input-block-wrapp">
                                                            <div class="input-block date-widget">												
                                                                <div class="group-img">
                                                                    <input type="email" class="form-control " id="email" name="email" required>
                                                                </div>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <div class="input-block">																	
                                                            <label>Telefon: (ex: +40726616161):</label>
                                                        </div>
                                                        <div class="input-block-wrapp">
                                                            <div class="input-block date-widget">												
                                                                <div class="group-img" style="display: flex;">
                                                                    <i class="fab  fa-whatsapp" style="color: #00e900;font-size:45px;margin-right:10px"></i>
                                                                    <input type="text" class="form-control " id="telefon" name="telefon" required>
                                                                </div>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review-sec extra-service">
                                                <!-- Booking  -->        
                                                <section class="booking-section" style="padding:0px">
                                                    <div class="container">
                                                        <ul class="nav nav-pills booking-tab" id="pills-tab" role="tablist">
                                                            <li class="nav-item">
                                                            <a class="nav-link active" id="pills-booking-tab" data-bs-toggle="pill" href="#pills-booking" role="tab" aria-controls="pills-booking" aria-selected="true">
                                                                <h5>Persoana Fizica</h5>
                                                            </a>
                                                            </li>
                                                            <li class="nav-item">
                                                            <a class="nav-link" id="pills-payment-tab" data-bs-toggle="pill" href="#pills-payment" role="tab" aria-controls="pills-payment" aria-selected="false">
                                                                <h5>Persoana Juridica</h5>
                                                            </a>
                                                            </li>
                                                        </ul>
                                                        <div class="review-header">
                                                            <h4>Detalii facturare</h4>
                                                        </div>
                                                        <div class="tab-content" id="pills-tabContent">
                                                            <div class="tab-pane fade show active" id="pills-booking" role="tabpanel" aria-labelledby="pills-booking-tab">
                                                                <div class="booking-details" style="padding: 0px">
                                                                    <div class="booking-form">
                                                                        <div class="row">
                                                                            <label class="custom_check" > <strong>Aceleasi cu datele de livrare</strong>
                                                                                <input type="checkbox" name="factura_date_sofer" id="factura_date_sofer" value="1" CHECKED>
                                                                                <span class="checkmark"></span> 
                                                                            </label>
                                                                        </div>
                                                                        <div class="row" id="sofer_visible">
                                                                            <div class="col-lg-6">												
                                                                                <div class="input-block">														
                                                                                    <label>Nume si Prenume:</label>	
                                                                                    <input type="text" class="form-control" id="pf_nume" name="pf_nume">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">													
                                                                                <div class="input-block">
                                                                                    <label>Tara:</label>	
                                                                                    <input type="email" class="form-control" id="pf_tara" name="pf_tara">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">												
                                                                                <div class="input-block">														
                                                                                    <label>Judet:</span></label>	
                                                                                    <input type="text" class="form-control" id="pf_judet" name="pf_judet">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">													
                                                                                <div class="input-block">
                                                                                    <label>Oras:</label>	
                                                                                    <input type="text" class="form-control" id="pf_oras" name="pf_oras">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <div class="input-block">
                                                                                    <label>Adresa:</label>	
                                                                                    <input type="text" class="form-control" id="pf_adresa" name="pf_adresa" placeholder="Strada, Numar, Bloc, Apartament">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="pills-payment" role="tabpanel" aria-labelledby="pills-payment-tab">
                                                                <div class="booking-details" style="padding: 0px">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">												
                                                                            <div class="input-block">														
                                                                                <label>Denumire:</label>	
                                                                                <input type="text" class="form-control" id="denumire" name="denumire">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">													
                                                                            <div class="input-block">
                                                                                <label>CUI:</label>	
                                                                                <input type="email" class="form-control"  value="" id="cui" name="cui" placeholder="ex: RO12345">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">												
                                                                            <div class="input-block">														
                                                                                <label>Cod inregistrare (Reg. Com.):</span></label>	
                                                                                <input type="text" class="form-control" id="regCom" name="regCom" placeholder="ex: J23/XXXX/2007">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">													
                                                                            <div class="input-block">
                                                                                <label>Tara:</label>	
                                                                                <input type="text" class="form-control" value="" id="pj_tara" name="pj_tara">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">													
                                                                            <div class="input-block">
                                                                                <label>Oras:</label>	
                                                                                <input type="text" class="form-control" value="" id="pj_oras" name="pj_oras" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">												
                                                                            <div class="input-block">														
                                                                                <label>Judet:</span></label>	
                                                                                <input type="text" class="form-control" value="" id="pj_judet" name="pj_judet">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="input-block">
                                                                                <label>Adresa:</label>	
                                                                                <input type="text" class="form-control" value="" id="pj_adresa" name="pj_adresa">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                                <!-- /Booking  --> 
                                            </div>
                                            <div class="review-sec extra-service">
                                                <div class="booking-details" style="padding: 0px">
                                                    <div class="booking-form">
                                                        
                                                        <!-- <div class="row"> -->
                                                        <div class="col-12">
                                                            <div class="input-block">
                                                                <label class="custom_radio">
                                                                    <input type="radio" name="plata" id="platesc_preluare" value="cash" CHECKED>
                                                                    <span class="checkmark"></span> 
                                                                    Platesc la preluare cu cash sau cu card
                                                                </label>
                                                            </div>
                                                            <div class="input-block" >
                                                                <label class="custom_radio">
                                                                    <input type="radio" name="plata" id="platesc_online" value="online" disabled="disabled">
                                                                    <span class="checkmark" disabled></span> 
                                                                    <span style="color: #c0c0c0">Platesc online cu cardul</span> <img src="https://dpdrent.ro/images/credit_cards.png" alt="" class="ml10 vm">
                                                                </label>
                                                            </div>
                                                            <div class="input-block">
                                                                <label class="custom_radio">
                                                                    <input type="radio" name="plata" id="platesc_op" value="OP">
                                                                    <span class="checkmark"></span> 
                                                                    Platesc prin OP
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <!-- </div> -->
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label class="custom_check" ><strong style="color: red">Sunt deacord cu</strong><a href="/termeni-conditii.php">Termenii si Conditiile</a>
                                                                    <input type="checkbox" name="terms_check" id="terms_check" value="1" required>
                                                                    <span class="checkmark"></span> 
                                                                </label>
                                                            </div>
                                                            <div class="col-6">
                                                                <button type="submit" class="btn btn-primary pull-right teeter-element" id="sent">REZERVARE</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Listing Features Section-->
                                            <div class="review-sec specification-card ">
                                                <div class="review-header">
                                                    <h4>Adauga Extra</h4>
                                                </div>
                                                <?php 
                                                    $query = "SELECT * FROM extras WHERE status = 'active' ORDER BY extraID ASC";
                                                    $results = mysqli_query($db, $query);
                                                    $extras = mysqli_fetch_all($results, MYSQLI_ASSOC);
                                                ?>
                                                <div class="card-body">
                                                    <div class="lisiting-featues">
                                                        <div class="row">
                                                            <?php foreach ($extras as $extra) { ?>
                                                            <div class="featureslist d-flex align-items-center col-12">
                                                                <div class="feature-img">
                                                                    <img src="/assets/uploads/extras/<?= $extra['extraPhoto']?>" alt="Icon">
                                                                </div>
                                                                <div class="featues-info">
                                                                    <span><?=$extra['extraTitle'];?>- <?= ((int)$extra['extraPrice'] == 0) ? 'Gratuit' : '&euro;' . $extra['extraPrice'] . '/per.'; ?> </span>
                                                                    <h6><?=substr($extra['extraText'], 0, 200) . "...";?></h6>
                                                                </div>
                                                                <div class="feature-img" style="border: none" onchange="extra(<?= $extra['extraID']?>)">
                                                                    <label class="custom_check" > <strong>ADAUGA</strong>
                                                                        <input type="checkbox" name="extra_input[]" id="input<?= $extra['extraID']; ?>" value="<?= $extra['extraID']?>" >
                                                                        <input type="hidden" name="extra_title" id="extra_title<?= $extra['extraID'] ?>" value="<?= $extra['extraTitle']; ?>" />
                                                                        <input type="hidden" name="extra_price" id="extra_price<?= $extra['extraID'] ?>" value="<?= $extra['extraPrice'] ?>" />
                                                                        <span class="checkmark"></span> 
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <hr>
                                                        <div class="col-lg-12">
                                                            <div class="input-block">
                                                                <label>Observatii: <span class="text-danger"> </span> </label>	
                                                                <textarea rows="4" class="form-control" name="observatii" id="observatii"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <button type="submit" class="btn btn-primary" id="sent">REZERVARE</button>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="carID" id="carID" value="<?= $car->carID;?>" />
                                            <input type="hidden" name="taxa_livrare" id="taxa_livrare" value="<?= $taxa_livrare;?>" />
                                            <input type="hidden" id="taxa_livrare_con" value="<?= $taxa_livrare;?>" />
                                            <input type="hidden" name="total" id="total" value="<?= $_SESSION['total_price'] ?>" />
                                            <input type="hidden" name="rent" id="rent" value="<?= $_SESSION['days']; ?>" />
                                            <input type="hidden" name="casco" id="casco" value="<?= $_SESSION['casco_days']; ?>" />
                                            <input type="hidden" name="casco_total" id="casco_total" value="0" />
                                            <input type="hidden" name="depozit" id="depozit" value="<?= $car->deposit; ?>" />
                                            <input type="hidden" name="depozit_standard" id="depozit_standard" value="<?= $car->deposit; ?>" />
                                            <input type="hidden" name="carID" id="carID" value="<?= $_SESSION['carID'] ?>" />
                                            <input type="hidden" name="drop_off_price" id="drop_off_price" value="<?= $_SESSION['drop_off_price']; ?>" />
                                            <input type="hidden" name="total_extras" id="total_extras" value="0" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            
                            </div>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqS0agVwwEXhsJ1bIGYTHG-t5KlaIlsCQ"></script>

<script>
function sidebar() {
    //get hidden fields value
    var total = document.getElementById('total');
    var drop_off_price = document.getElementById('drop_off_price');
    var rent = document.getElementById('rent').value;
    var casco = document.getElementById('casco').value;
    var casco_total = document.getElementById('casco_total').value;
    //sidebar fileds
    var total1 = document.getElementById('text_total');
    var total2 = document.getElementById('text_total');
    var drop_off_price_p = document.getElementById('text_drop_off');
    var rent_per_day = document.getElementById('text_pret_zi');
    var casco_per_day = document.getElementById('casco_pe_zi');
    // var casco_per_day2 = document.getElementById('text_casco_zi2');
    var rent_days = document.getElementById('text_nr_zile');
    // var casco_days = document.getElementById('text_nr_zile');
    var depozit = document.getElementById('text_depozit');
    var depozit_price = document.getElementById('depozit');
    var depozit_standard = document.getElementById('depozit_standard');
    total1.innerHTML = '';
    total2.innerHTML = '';
    drop_off_price_p.innerHTML = '';
    rent_per_day.innerHTML = '';
    rent_days.innerHTML = '';
    //casco_per_day.innerHTML = '';
    // casco_per_day2.innerHTML = '';
    // casco_days.innerHTML = '';
    total_d = parseInt(total.value);
    total1.innerHTML = total_d;
    total2.innerHTML = total_d;
    drop_off_price_p.innerHTML = '&euro;' + drop_off_price.value;
    if (rent == 0) {
      rent_days.innerHTML = 0;
      rent_per_day.innerHTML = 0;
    } else {
      car = rent.split("x");
      rent_days.innerHTML = car[0];
      rent_per_day.innerHTML = car[1];
    }
    if (casco == 0) {
    //   casco_days.innerHTML = 0;
      casco_per_day.innerHTML = 0;
    //   casco_per_day2.innerHTML = 0;
    } else {
      car = casco.split("x");
    //   casco_days.innerHTML = car[0];
    //   casco_per_day2.innerHTML = car[1].replace(' ', '');
    }
  }

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
    // $('#rezervare_form').submit(function(e) {
    //     e.preventDefault();
    //     var formData = $(this).serialize();
    //     var formAction = '/ajax/rezervare-form.php'
    //     $.ajax({
    //         type: "POST",
    //         url: formAction,
    //         data: formData,
    //         success: function(response) {
    //            if (response == true)
    //            {
    //             window.location.replace('/multumim.php')
    //            }
    //         }
    //     });
    //     return false;
    // });
    
    // var dateToday = new Date();
    $("#data_preluare").datetimepicker({
        format: 'DD-MM-YYYY',
        icons: {
            up: "fas fa-angle-up",
            down: "fas fa-angle-down",
            next: 'fas fa-angle-right',
            previous: 'fas fa-angle-left'
        },
        minDate: moment().startOf('day')
    });

    $("#data_returnare").datetimepicker({
        format: 'DD-MM-YYYY',
        icons: {
            up: "fas fa-angle-up",
            down: "fas fa-angle-down",
            next: 'fas fa-angle-right',
            previous: 'fas fa-angle-left'
        },
        minDate: moment().add(2, 'days').startOf('day')
    });

    if ($('#same_location').prop('checked'))
    {
        $('#show_return_location').css( "display", "none" );
    }
    else
    {
        $('#show_return_location').css( "display", " " );
        $('#return_location').val($('#pickup_location').val());
    }

    if ($('#factura_date_sofer').prop('checked'))
    {
        $('#sofer_visible').css("display", "none");
    }
    else
    {
        $('#sofer_visible').css( "display", " " );
    }

    $('#factura_date_sofer').click(function() {
        if ($('#factura_date_sofer').prop('checked'))
        {
            console.log('===checked')
            $('#sofer_visible').css( "display", "none" );
            $('#pills-tabContent input').val('');
        }
        else
        {
            console.log('===no chekc')

            $('#pills-payment input').val('');
            $('#sofer_visible').show();
        }
    });

    $('#data_returnare').blur(function(e) {
        var formAction = '/ajax/pret.php';
        var dataString = $(this.form).serialize();
        $.ajax({
            type: "POST",
            url: formAction,
            data: dataString,
            success: function(response) {
                $('#rent').val(response),
                $('#text_data_returnare').html($('#data_returnare').val() + ' ' + $('#return_time').val() );
                calculTotal();
            }
        });
        return false;
    });

    $('#data_returnare').blur(function(e) {
      var formAction = '/ajax/casco.php';
      var dataString = $(this.form).serialize();
      $.ajax({
        type: "POST",
        url: formAction,
        data: dataString,
        success: function(response) {
            $('#casco').val(response),
            calculTotal();
        }
      });
      return false;
    });

    $('#return_date').blur(function(e) {
        var formAction = '/ajax/pret.php';
        var dataString = $(this.form).serialize();
        $.ajax({
            type: "POST",
            url: formAction,
            data: dataString,
            success: function(response) {
                $('#rent').val(response),
                $('#text_data_returnare').html($('#data_returnare').val() + ' ' + $('#return_time').val() );
                calculTotal();
            }
        });
        return false;
    });

    $('#return_date').blur(function(e) {
      var formAction = '/ajax/casco.php';
      var dataString = $(this.form).serialize();
      $.ajax({
        type: "POST",
        url: formAction,
        data: dataString,
        success: function(response) {
            $('#casco').val(response),
            calculTotal();
        }
      });
      return false;
    });

    $('#return_time').blur(function(e) {
        e.preventDefault();
        var formAction = '/ajax/pret.php';
        var dataString = $(this.form).serialize();
        $.ajax({
            type: "POST",
            url: formAction,
            data: dataString,
            success: function(response) {
                $('#rent').val(response),
                $('#text_data_returnare').html($('#data_returnare').val() + ' ' + $('#return_time').val() );
                calculTotal();
            }
        });
        return false;
    });

    $('#return_time').blur(function(e) {
        e.preventDefault();
        var formAction = '/ajax/casco.php';
        var dataString = $(this.form).serialize();
        $.ajax({
            type: "POST",
            url: formAction,
            data: dataString,
            success: function(response) {
                $('#casco').val(response),
                $('#text_data_returnare').html($('#data_returnare').val() + ' ' + $('#return_time').val() ),
                calculTotal();
            }
        });
        return false;
    });

    $('#pickup_time').blur(function(e) {
        e.preventDefault();
        var formAction = '/ajax/pret.php';
        var dataString = $(this.form).serialize();
        $.ajax({
            type: "POST",
            url: formAction,
            data: dataString,
            success: function(response) {
                $('#rent').val(response),
                $('#text_data_preluare').html($('#data_preluare').val() + ' ' + $('#pickup_time').val() );
                calculTotal();
            }
        });
        return false;
    });

    $('#pickup_time').blur(function(e) {
        e.preventDefault();
        var formAction = '/ajax/casco.php';
        var dataString = $(this.form).serialize();
        $.ajax({
            type: "POST",
            url: formAction,
            data: dataString,
            success: function(response) {
                $('#casco').val(response),
                calculTotal();
            }
        });
        return false;
    });

    $('#data_preluare').blur(function(e) {
        var pickup_date = $(this).val();
		var return_date = $('#data_returnare').val();

        var startDate = moment(pickup_date, 'DD-MM-YYYY');
		var endDate = moment(return_date, 'DD-MM-YYYY');

		var duration = endDate.diff(startDate, 'days');

        if (duration < 2) {
			$("#data_returnare").datetimepicker('destroy');

			$('#data_returnare').datetimepicker({
				minDate: moment(pickup_date, 'DD-MM-YYYY').add(2, 'days').startOf('day'),
				format: 'DD-MM-YYYY',
				icons: {
					up: "fas fa-angle-up",
					down: "fas fa-angle-down",
					next: 'fas fa-angle-right',
					previous: 'fas fa-angle-left'
				},
			})
		}

        var formAction = '/ajax/pret.php';
        var dataString = $(this.form).serialize();
        $.ajax({
            type: "POST",
            url: formAction,
            data: dataString,
            success: function(response) {
                $('#rent').val(response),
                $('#text_data_preluare').html($('#data_preluare').val() + ' ' + $('#pickup_time').val() );
                calculTotal();
            }
        });
        return false;
    });

    $('#data_preluare').blur(function(e) {
      var formAction = '/ajax/casco.php';
      var dataString = $(this.form).serialize();
      $.ajax({
        type: "POST",
        url: formAction,
        data: dataString,
        success: function(response) {
            $('#casco').val(response),
            calculTotal();
        }
      });
      return false;
    });

    $('input[name="casco_add"]').click(function() {
        calculTotal();
    })

    $('#locatie_preluare').change(function() {
        calculTotal();
    })

    
});

function convert_date(val) {
    var a = val.split('-');
    var b = a[0];
    a[0] = a[1];
    a[1] = b;
    return new Date(a.join('-'));
  }

function calculTotal() {
    var pick_up = convert_date(document.getElementById('data_preluare').value + ' ' + document.getElementById('pickup_time').value);
    var drop_off = convert_date(document.getElementById('data_returnare').value  + ' ' + document.getElementById('return_time').value);
    // var pick_up =  document.getElementById('data_preluare').value;
    // var drop_off =  document.getElementById('data_returnare').value;

    var total = document.getElementById('total');
    var rent = document.getElementById('rent').value;
    var casco = document.getElementById('casco').value;
    var casco_total = document.getElementById('casco_total');
    var casco_add = document.getElementById('casco_add');
    var drop_off_price = document.getElementById('drop_off_price');
    var total_extras = document.getElementById('total_extras');
    var text_casco = document.getElementById('text_casco');
    var taxa_livrare = document.getElementById('taxa_livrare_con');
    var depozit = document.getElementById('text_depozit');
    var casco_per_day = document.getElementById('casco_pe_zi');
    var depozit_price = document.getElementById('depozit');
    var depozit_standard = document.getElementById('depozit_standard');
    var washingService = 0;
    var office_start_time = '<?= $office_start_time?>';
    var office_end_time = '<?= $office_end_time?>';

    const options = {
      hour12: false,
      hour: 'numeric',
      minute: '2-digit',
    };
    var pick_up_date = pick_up.toLocaleTimeString('en-US', options);
    var drop_off_date = drop_off.toLocaleTimeString('en-US', options);

    var pick_timeParts = pick_up_date.split(':');
    var pick_hours = parseInt(pick_timeParts[0], 10);
    var pick_minutes = parseInt(pick_timeParts[1], 10);

    // Adjust the time if necessary
    if (pick_hours >= 24) {
      pick_hours %= 24;
    }

    // Format the time with leading zeros
    pick_up_date = ('00' + pick_hours).slice(-2) + ':' + ('00' + pick_minutes).slice(-2);

    var drop_timeParts = drop_off_date.split(':');
    var drop_hours = parseInt(drop_timeParts[0], 10);
    var drop_minutes = parseInt(drop_timeParts[1], 10);
    // Adjust the time if necessary
    if (drop_hours >= 24) {
      drop_hours %= 24;
    }

    // Format the time with leading zeros
    drop_off_date = ('00' + drop_hours).slice(-2) + ':' + ('00' + drop_minutes).slice(-2);

    console.log(pick_up_date, drop_off_date)

    var extra_price = 10;
    casco_per_day.innerHTML = '';

    if (rent != 0) {
        car = rent.split("x");
        cas = casco.split("x");
        casco_per_day.innerHTML = cas[1];

        if (casco_add.checked == true) {
            depozit.innerHTML = 0;
            depozit_price.value = 0;
            text_casco.innerHTML = "&euro;" + (parseInt(cas[0] * cas[1]));
            casco_total.value = Math.round(parseInt(cas[0] * cas[1]));
            tot = Math.round(parseInt(car[0] * car[1]) + (parseInt(cas[0] * cas[1])) + parseInt(drop_off_price.value) + parseInt(total_extras.value));
            total_tax_price = parseInt(taxa_livrare.value);
        } else {
            depozit.innerHTML = depozit_standard.value ;
            text_casco.innerHTML = "&euro;" + 0;
            casco_total.value = 0;
            tot = Math.round(parseInt(car[0] * car[1]) + parseInt(drop_off_price.value) + parseInt(total_extras.value));
            total_tax_price = parseInt(taxa_livrare.value);
            console.log(tot,'======')
            if ((new Date('2023-07-07 ' + pick_up_date) <  new Date('2023-07-07 ' +  office_start_time)) || (new Date('2023-07-07 ' + pick_up_date) >  new Date('2023-07-07 ' +  office_end_time)))
            {
            //   tot += extra_price;
            total_tax_price += parseInt(extra_price);
            }
            
            if ((new Date('2023-07-07 ' + drop_off_date) <  new Date('2023-07-07 ' +  office_start_time)) || (new Date('2023-07-07 ' + drop_off_date) >  new Date('2023-07-07 ' +  office_end_time)))
            {
            //   tot += extra_price;
            total_tax_price += parseInt(extra_price);
            }
            
            tot += total_tax_price;

            if ((new Date('2023-07-07 ' + pick_up_date) <  new Date('2023-07-07 ' +  office_start_time)) || (new Date('2023-07-07 ' + pick_up_date) >  new Date('2023-07-07 ' +  office_end_time)) || (new Date('2023-07-07 ' + drop_off_date) <  new Date('2023-07-07 ' +  office_start_time)) || (new Date('2023-07-07 ' + drop_off_date) >  new Date('2023-07-07 ' +  office_end_time)))
            {
                document.getElementById('tax_hour').innerHTML = "Taxa extra hour";
                document.getElementById('text_taxa_livrare').innerHTML = '&euro;' + total_tax_price;
            }
            else {
                document.getElementById('tax_hour').innerHTML = "Taxa livrare";
                document.getElementById('text_taxa_livrare').innerHTML = '&euro;' + taxa_livrare.value;
            }
            $('#taxa_livrare').val(total_tax_price);
        }
        total.value = tot;
    }
    
    sidebar();
  }

function extra(id)
{
    console.log('==',id)
    name = $('#extra_title' + id).val();
    price = $('#extra_price' + id).val();
    total_extras = $('#total_extras').val();
    var checkbox = $('#input' + id).is(':checked');

    if (checkbox == true) {
        $('.listlist').append('<li id="extralist' + id + '">' + name + '<span class="pull-right bold">&euro;' + price + '</span></li>');
        $('#total_extras').val(parseInt(total_extras) + parseInt(price));
        calculTotal();
    }
    if (checkbox != true) {
        $("#extralist" + id).remove(),
        $('#total_extras').val(parseInt(total_extras) - parseInt(price));
        calculTotal();
    }

}

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

var map;
var geocoder;
var bounds = new google.maps.LatLngBounds();

function initialize() {
geocoder = new google.maps.Geocoder();
}

function calculateDistances() {
    var origin1 = document.getElementById('locatie_preluare').value;
    var destinationA = document.getElementById('locatie_returnare').value;
    if (origin1 == "") {
        origin1 = "Bucharest, Romania";
    }
    if ((destinationA == " " && origin1 == "") || (destinationA == "" && origin1 == "")) {
        var destinationA = "Bucharest, Romania";
    }
    if ((destinationA == " " && origin1 != "") || (destinationA == "" && origin1 != "")) {
        var destinationA = origin1;
    }
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [origin1],
        destinations: [destinationA],
        travelMode: google.maps.TravelMode.DRIVING,
        avoidHighways: false,
        avoidTolls: false
    }, callback);
}


function callback(response, status) {
    if (status != google.maps.DistanceMatrixStatus.OK) {
        alert('Error was: ' + status);
    } else {
        var origins = response.originAddresses;
        var destinations = response.destinationAddresses;
        var dropoffDiv = document.getElementById('text_drop_off');
        var dropoffPrice = document.getElementById('drop_off_price');
        dropoffDiv.innerHTML = '';
        for (var i = 0; i < origins.length; i++) {
            var results = response.rows[i].elements;
            for (var j = 0; j < results.length; j++) {
                dropoffDiv.innerHTML += Math.round((results[j].distance.value / 1000) * 0.8);
                dropoffPrice.value = Math.round((results[j].distance.value / 1000) * 0.8);
                calculTotal();
            }
        }
    }
}

    function read_more() {
        var readmore = $('.read_more');
        var comment = $('.review_comment p').text();

        //goes through each index of the array of 'review_comment p'
        $('.review_comment p').each(function(i){
        //calculates height of comment variable
        var commentheight = $(this).height();
        //calculates scroll height of comment on each div
        var scrollcommentheight =  $('.review_comment p')[i].scrollHeight;
        console.log("This is the comment height" + ' - ' + commentheight);
        console.log("This is the scroll height" + ' - ' + scrollcommentheight);

        //if comment height is same as scroll height then hide read more button
        if (commentheight == scrollcommentheight){
            $(this).siblings(readmore).hide();
        }
        //otherwise read more button shows
        else {
            $(this).siblings(readmore).text("Read More");
        }
    });


  readmore.on('click', function() {
    var $this = $(this);
    event.preventDefault();
    
    $this.siblings('.review_comment p').toggleClass('active');

    if ($this.siblings('.review_comment p').text().length < 230) {
      $this.text("Read More");
    }
    if ($('.review_comment p').hasClass('active')) {
      $this.text("Read Less");
    } else {
      $this.text("Read More");
    }
  });
};

$(function() {
  //Calling function after Page Load
  read_more();
});




</script>