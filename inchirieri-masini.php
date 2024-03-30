<?php
require_once 'core/init.php';
Session::put('url', 'inchirieri-masini');

require_once './layout/header.php';

$query = "SELECT * FROM categories JOIN cat_car ON categories.catID = cat_car.catID WHERE status = 'active' GROUP BY categories.catID ORDER BY categories.order ASC";
$results = mysqli_query($db, $query);
$cats = mysqli_fetch_all($results, MYSQLI_ASSOC);

if (Session::exists('pickup_location') != true && Session::exists('return_location') != true && Session::exists('pickup_date') != true 
    && Session::exists('pickup_time') != true && Session::exists('return_date') != true && Session::exists('return_time') != true)
{
    Session::put('step', 1);
}

$query = "SELECT * FROM content WHERE pageURL = 'inchirieri-masini'";
$results = mysqli_query($db, $query);
$page = mysqli_fetch_object($results);


if (Session::exists('step') && Session::get('step') > 1)
    Session::put('step', 2);
?>

<style>


.date-width {
    width: 156%;
    padding: 0 !important;
}
.mobile-calcutor-toggle {
    display: none;
}

#visible-tab
{
    margin-top: 85px;
}
@media (max-width: 767.98px) {
    #visible-tab {
        display: none;
    }

    .date-width {
        width: 94%;
        margin-left: 9px !important;
    }

    #discount_part {
        display: none;
    }

    #calculator-section {
        display: none;
    }

    /* .services .services-group .services-icon .icon-img {
        width: 35px;
        height: 35px;
    } */

    .mobile-calcutor-toggle {
        display: block;
    }
    #calculator-section {
        <?php if (Session::exists('step') and Session::get('step') > 1) { ?>
            display: none;
        <?php } else { ?>
            display: block;
        <?php } ?>
    }
}

.offer-section {
    width: 100%;
    display: flex;
    justify-content: center;
    position: fixed;
    z-index: 9999;
    top: 70px;
}


</style>
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

<style>
    .border-pulse {
      animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 red;
      }
      50% {
        box-shadow: 0 0 0 2px red;
      }
      100% {
        box-shadow: 0 0 0 0 red;
      }
    }
  </style>

<!-- <div class="border-pulse"></div> -->



<!-- /Breadscrumb Section -->
<?php if (Session::exists('step') && Session::get('step') > 1) { ?>
    <div class="container mobile-calcutor-toggle">
        <button class="btn btn-primary w-100 mt-3">Calculator</button>
    </div>
    <br>
<?php } ?>

<div class="section-search mt-4" id="calculator-section"> 
    <div class="container">	  
        <div class="search-box-banner1 ">
            <form action="/inchirieri-ajax.php" method="POST" class="needs-validation" novalidate>
                <ul class="align-items-center">
                    <li class="column-group-main pickup-main">
                        <div class="input-block">
                            <label>Pickup Location</label>												
                            <div class="group-img">
                                <!-- <input type="text" class="form-control" name="pickup_location" > -->
                                <?php if (Session::exists('pickup_location') && Session::get('pickup_location')) { ?>
                                    <select class="form-control" id="pickup_location" name="pickup_location" style="padding-left: 35px" required>
                                        <option disabled value="">Alege locatia</option>
                                        <option value="Bucuresti" <?php if($_SESSION['pickup_location'] == 'Bucuresti') echo 'selected'; ?>>Bucuresti</option>
                                        <option value="Aeroport Otopeni" <?php if($_SESSION['pickup_location'] == 'Aeroport Otopeni') echo 'selected'; ?>>Aeroport Otopeni</option>
                                        <option value="Brasov" <?php if($_SESSION['pickup_location'] == 'Brasov') echo 'selected'; ?>>Brasov</option>
                                        <option value="Aeroport Brasov" <?php if($_SESSION['pickup_location'] == 'Aeroport Brasov') echo 'selected'; ?>>Aeroport Brasov</option>
                                    </select>
                                <?php } else { ?>
                                    <select class="form-control" id="pickup_location" name="pickup_location" style="padding-left: 35px" required>
                                        <option disabled selected value="">Alege locatia</option>
                                        <option value="Bucuresti">Bucuresti</option>
                                        <option value="Aeroport Otopeni">Aeroport Otopeni</option>
                                        <option value="Brasov">Brasov</option>
                                        <option value="Aeroport Brasov">Aeroport Brasov</option>
                                    </select>
                                <?php } ?>
                                <span><i class="feather-map-pin"></i></span>
                            </div>
                        </div>
                    </li>
                    <li class="column-group-main return-main">
                        <div class="input-block">
                            <label>Return Location</label>												
                            <div class="group-img">
                                <?php if (Session::exists('return_location') && Session::get('return_location')) { ?>
                                <input type="text" class="form-control" name="return_location" id="return_location" value="<?= $_SESSION['return_location']?>" required>
                                <?php } else { ?>
                                    <input type="text" class="form-control" name="return_location" id="return_location"  value="" required>
                                <?php }?>
                                <span><i class="feather-map-pin"></i></span>
                            </div>
                        </div>
                    </li>
                    <li class="column-group-main">						
                        <div class="input-block">																	
                            <label>Pickup Date</label>
                        </div>
                        <div class="input-block-wrapp">
                            <div class="input-block date-widget date-width">												
                                <div class="group-img">
                                <input type="text" class="form-control" id="pickup_date" name="pickup_date" 
                                    value="<?php if (Session::exists('pickup_date') && Session::get('pickup_date')) echo $_SESSION['pickup_date'];
                                    else  {
                                        echo date('d-m-YYYY');
                                    }
                                    ?>" required>
                                <span><i class="feather-calendar"></i></span>
                                </div>
                            </div>
                            <div class="input-block time-widge">											
                                <div class="group-img">
                                <input type="text" class="form-control timepicker" name="pickup_time" value="<?php if (Session::exists('pickup_time') && Session::get('pickup_time')) echo $_SESSION['pickup_time'];
                                    else  {
                                        echo date('H:i');
                                    }
                                    ?>" required>
                                <span><i class="feather-clock"></i></span>
                                </div>
                            </div>
                        </div>	
                    </li>
                    <li class="column-group-main">						
                        <div class="input-block">																	
                            <label>Return Date</label>
                        </div>
                        <div class="input-block-wrapp">
                            <div class="input-block date-widge date-width">												
                                <div class="group-img">
                                <input type="text" class="form-control" id="return_date" name="return_date" 
                                    value="<?php if (Session::exists('return_date') && Session::get('return_date')) echo $_SESSION['return_date'];
                                    else  {
                                        echo date('d-m-YYYY');
                                    }
                                    ?>" required>
                                <span><i class="feather-calendar"></i></span>
                                </div>
                            </div>
                            <div class="input-block time-widge">											
                                <div class="group-img">
                                <input type="text" class="form-control timepicker" name="return_time" value="<?php if (Session::exists('return_time') && Session::get('return_time')) echo $_SESSION['return_time'];
                                    else  {
                                        echo date('H:i');
                                    }
                                    ?>" required>
                                <span><i class="feather-clock"></i></span>
                                </div>
                            </div>
                        </div>	
                    </li>
                    <?php if (Session::exists('step') and Session::get('step') > 1) { ?>
                    <li class="column-group-last" >
                        <div class="input-block  d-flex p-0">
                            <div class="search-btn col-6" >
                                <button class="btn search-button" type="submit">Calculator</button>
                            </div>
                            <div class="search-btn col-6" id="reset_btn" style="margin-top: 40px;text-align: right display: flex">
                                &nbsp;<i class="fa fa-refresh"></i><a href="/reset-calculator-masini.php"> Reseteaza</a>
							</div>
                        </div>
                    </li>
                    <?php } else { ?>
                    <li class="column-group-last" >
                        <div class="input-block">
                            <div class="search-btn" >
                                <button class="btn search-button" type="submit">Calculator</button>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            </form>	
        </div>
    </div>	
</div>	

<!-- <div class="content p-2" id="discount_part">
    <div class="container">
        <ul class="status-lists">
            <li>
                <div class="status-info">
                    <?= $page->pageContent;?>
                </div>
            </li>
        </ul>
    </div>
</div> -->

<div class="mt-3" id="visible-tab">
    <div class="container">
        <div class="sorting-div">
            <div class="row d-flex align-items-center">
                <div class="">
                    <div class="product-filter-group d-flex">
                        <div class="flex-grow-1 me-2 teeter-element-operta">
                            <button class="btn btn-primary w-100" type="submit">Oferta Speciala!!!  Reducere 30% pentru luna Aprilie / Scaun Copil Gratuit !</button>
                        </div>
                        <div class="grid-listview">
                            <ul>
                                <li class="d-flex">
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
<section class="section car-listing p-0" id="grid-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                $i = 0;
                foreach($cats as $cat) { ?>
                <div class="clear"></div>
                <div class="section-heading mt-2 d-flex" data-aos="fade-down">
                    <h2 class="mb-3"><?= $cat['catName']; ?></h2>
                </div>
                <div class="row">
                    <?php 
                        $query = "SELECT * FROM cat_car JOIN cars ON cat_car.carID = cars.carID WHERE status = 'active' AND cat_car.catID = " . $cat['catID'] . " ORDER BY 'order' ASC";
                        $results = mysqli_query($db, $query);
                        $cars = mysqli_fetch_all($results, MYSQLI_ASSOC);
                        $rent_list = [];
                        foreach ($cars as $car) {
                            $cID = $car['carID'];
                            if (Session::exists('pickup_date') && Session::get('pickup_date')!= null) {
                                
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
                            }

                    ?>
                    <!-- col -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                        <div class="listing-item">										
                            <div class="listing-img">
                                <a href="/inchirieri.php?carID=<?=$car['carID']?>">
                                    <img src="https://dpdrent.ro/uploads/cars/<?=$car['carPhoto']?>" style="height: 220px" alt="Toyota">
                                </a>
                                
                            </div>										
                            <div class="listing-content">
                                <div class="listing-features rental-car-item">												
																								  
									<div class="list-rating">							
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<span>(5.0)</span>
									</div>													
									<h3 class="listing-title">
										<a href="/inchirieri.php?carID=<?=$car['carID']?>"><?php echo $car['carName'];?></a>
									</h3>
								</div> 
                                <div class="listing-details-group">
                                    <ul style="display: ruby-text">

                                    <?php $equip = explode(';', $car['equip']);
                                        $searchValue = ['24','23'];
                                        $matchingValues = array_intersect($equip, $searchValue);
                                        $remainingValues = array_diff($equip, $searchValue);

                                        $modifiedArray = array_merge($matchingValues, $remainingValues);

                                        $searchValue = ['27','34'];
                                        $matchingValues = array_intersect($modifiedArray, $searchValue);
                                        $remainingValues = array_diff($modifiedArray, $searchValue);

                                        $modifiedArray = array_merge($matchingValues, $remainingValues);
                                        
                                        foreach ($modifiedArray as $eqId) {
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
                                <div class="listing-location-details"   style="background-color: #FFA633;">
                                    <?php
                                    if (count($rent_list) > 1) { ?>
                                        <div class="col-12 drop-address">
                                            <div class="fav-item-rental  text-center">
                                                <h5 class="featured-text" style="color: #FFFFFF"><b>&euro;<?=$rent_list[1] * $rent_list[0]?>/<?= $rent_list[0]?> zile</b><h5>								
                                            </div>	
                                            <!-- <h5 style="color: #0db02b; text-align: right">&euro;<?=$rent_list[1] * $rent_list[0]?>/<?= $rent_list[0]?> zile</h5> -->
                                        </div>
                                        <!-- <h6><span style="color:red;font-size: 25px">&euro;<?= $r_price ?>/ <?=$rent_list[0]?>Zi</span><br></h6> -->
                                    <?php } else { ?>
                                        <div class="col-6 pickup-address text-center" style="color: #FFFFFF">
                                            <span>21+ zile</span>
                                            <h5>&euro;<?=$car['price5']?></h5>
                                        </div>
                                        <div class="col-6 drop-address text-center" style="color: #FFFFFF">
                                            <span>1-3 zile</span>
                                            <h5>&euro;<?=$car['price1']?></h5>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="listing-button">
                                    <form action="rezervare-ajax.php" method="post" id="rent_form_<?= $i?>">
                                        <input type="hidden" name="carId" id="carId_<?= $i?>" value="<?= $car['carID'] ?>" />
                                    </form>
                                    <button onclick="submit_form(<?=$i?>)" class="btn btn-order"><span><i class="feather-calendar me-2"></i></span>Rent Now</button>
                                </div>	
                            </div>
                        </div>		 
                    </div>
                    <!-- /col -->
                    <?php $i++; } ?>
                </div>
                <?php } ?>
            </div>		
        </div>
    </div>
</section>	
<!-- /Car  View -->	

<!-- Car List View -->
<section class="section p-0 car-listing" style="display:none;" id="list-content" >
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php
                    foreach($cats as $cat) { 
                    ?>
                    <div class="clear"></div>
                    <div class="section-heading d-flex mt-2" data-aos="fade-down">
                        <h2 class="mb-3" style="text-align: left;"><?= $cat['catName']; ?></h2>
                    </div>
                    <?php 
                        $query = "SELECT * FROM cat_car JOIN cars ON cat_car.carID = cars.carID WHERE status = 'active' AND cat_car.catID = " . $cat['catID'] . " ORDER BY 'order' ASC";
                        $results = mysqli_query($db, $query);
                        $cars = mysqli_fetch_all($results, MYSQLI_ASSOC);
                        foreach ($cars as $car) {
                            $cID = $car['carID'];
                            if (Session::exists('pickup_date') && Session::get('pickup_date')!= null) {
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
                            }

                    ?>
                    <div class="listview-car">
                        <div class="card">
                            <div class="blog-widget d-flex">
                                <div class="blog-img" style="overflow: unset">
                                    <a href="/inchirieri.php?carID=<?=$car['carID']?>">
                                        <img src="https://dpdrent.ro/uploads/cars/<?=$car['carPhoto']?>" style="height: 180px;width:250px" alt="blog-img">
                                    </a>														    
                                </div>
                                <div class="bloglist-content w-100">
                                    <div class="card-body">
                                        <div class="blog-list-head d-flex">
                                            <div class="blog-list-title" >
                                                <h3><a href="/inchirieri.php?carID=<?=$car['carID']?>"><?= $car['carName']?></a></h3>
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
                                                    <h5 style="color: #FFFFFF; text-align: center; padding: 3px; border-radius: 2%; background-color: #FFA633">&euro;<?=$rent_list[1] * $rent_list[0]?>/<?= $rent_list[0]?> zile</h5>
                                                <?php } else { ?>
                                                    <div class="pickup-address text-center mb-2" style="color: #FFFFFF">
                                                        <h5>21+ zile - &euro;<?=$car['price5']?></h5>
                                                    </div>
                                                    <div class="drop-address text-center" style="color: #FFFFFF">
                                                        <h5>1-3 zile - &euro;<?=$car['price1']?></h5>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>	
                                        <div class="listing-details-group">
                                            <ul>
                                            <?php $equip = explode(';', $car['equip']);
                                                $searchValue = ['24','23'];
                                                $matchingValues = array_intersect($equip, $searchValue);
                                                $remainingValues = array_diff($equip, $searchValue);
        
                                                $modifiedArray = array_merge($matchingValues, $remainingValues);
        
                                                $searchValue = ['27','34'];
                                                $matchingValues = array_intersect($modifiedArray, $searchValue);
                                                $remainingValues = array_diff($modifiedArray, $searchValue);
        
                                                $modifiedArray = array_merge($matchingValues, $remainingValues);
                                                
                                                foreach ($modifiedArray as $eqId) {
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
                                        <div class="blog-list-head list-head-bottom d-flex">
                                            <div class="blog-list-title">
                                            </div>
                                            <div class="listing-button">
                                                <form action="rezervare.php" method="post" id="rent_form_<?=$i?>">
                                                    <input type="hidden" name="carId" id="carId" value="<?= $car['carID']; ?>" >
                                                </form>
                                                <button onclick="submit_form(2)" class="btn btn-order"><span><i class="feather-calendar me-2"></i></span>Rent Now</button>
                                            </div>
                                        </div>	
                                    </div>					 
                                </div>			 
                            </div> 
                        </div>
                    </div>
                    <?php $i++; } ?>
                    <?php } ?>
                </div>
            </div>		
        </div>
    </div>
</section>

<!-- /Car List View -->	

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">AVERTIZARE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6>Vă rugăm să alegeți mai întâi locația și data</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<?php require_once './layout/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#grid-content').show();
        // $('#list-content').css('display', 'none');
        
        // var list_content = document.getElementById("list-content");
        // list_content.style.display = 'none';


        var currentDate = moment(); // Get the current date
        var futureDate = currentDate.add(2, 'days'); // Add 7 days to the current date

        var today = new Date();

        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0');
        var year = today.getFullYear();

        var formattedDate = day + '-' + month + '-' + year;
        
        var pickup_date = $('#pickup_date').datetimepicker({
			format: 'DD-MM-YYYY',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			},
            minDate: moment().startOf('day'),
		})

        var return_date = $('#return_date').datetimepicker({
			format: 'DD-MM-YYYY',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			},
			minDate: moment().add(2, 'days').startOf('day'),
		})

        $('#pickup_date').blur(function() {

            var pickup_date = $(this).val();
            var return_date = $('#return_date').val();

            var startDate = moment(pickup_date, 'DD-MM-YYYY');
            var endDate = moment(return_date, 'DD-MM-YYYY');

            var duration = endDate.diff(startDate, 'days');

            if (duration < 2) {
                $("#return_date").datetimepicker('destroy');

                $('#return_date').datetimepicker({
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
        })

        $('#pickup_location').change(function() {
            $('#return_location').val($('#pickup_location').val());
        })

        $('.mobile-calcutor-toggle').click(function() {

            if ($('#calculator-section').css('display') == 'none')
            {
                $('#calculator-section').show()
            }
            else
            {
                $('#calculator-section').css('display', 'none')
            }
        })
    });

    function submit_form(id)
    {
        var step = <?= $_SESSION['step']?>;

        if (step > 1)
            $('#rent_form_' + id).unbind('submit').submit();
        else if (step == 1)
        {
            $('.search-box-banner1').addClass('border-pulse')
            const section = document.getElementById('calculator-section');
            const headerHeight = document.getElementById('fixed-header').offsetHeight;
            const sectionTop = section.offsetTop - headerHeight;
            $('.search-box-banner1').css('border', '2px solid red');
            window.scrollTo({
                top: sectionTop,
                behavior: 'smooth'
            });
            // $('#exampleModal').modal('show');
        }
    }
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

    // var startDatePicker = $('#pickup_date').datetimepicker({
    //     format: 'DD-MM-YYYY',
    //     icons: {
    //         up: "fas fa-angle-up",
    //         down: "fas fa-angle-down",
    //         next: 'fas fa-angle-right',
    //         previous: 'fas fa-angle-left'
    //     }
    // });

    // var endDatePicker = $('#return_date').datetimepicker({
    //     format: 'DD-MM-YYYY',
    //     icons: {
    //         up: "fas fa-angle-up",
    //         down: "fas fa-angle-down",
    //         next: 'fas fa-angle-right',
    //         previous: 'fas fa-angle-left'
    //     }
    // });

    // // Set minDate for the endDatePicker based on the selected date of the startDatePicker
    // startDatePicker.on('change.datetimepicker', function (e) {
    //     console.log('=====')
    //     endDatePicker.datetimepicker('minDate', e.date);
    // });
    $(document).ready(function() {
        $(window).scroll(function() {
            var headerHeight = $('#fixed-header').outerHeight();
            var topDistance = $('#visible-tab').offset().top;
            var scrollTop = $(window).scrollTop();
            // var contentMarginTop = headerHeight;
            console.log(topDistance,scrollTop,'===========')

            if (scrollTop > 355) {
                console.log('====fix====')
                $('#visible-tab').addClass('offer-section');
            }
            else {
                $('#visible-tab').removeClass('offer-section');
            }

        })
    });
</script>