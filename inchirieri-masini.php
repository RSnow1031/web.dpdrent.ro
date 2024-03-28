<?php
require_once 'core/init.php';
require_once './layout/header.php';

$query = "SELECT * FROM categories JOIN cat_car ON categories.catID = cat_car.catID WHERE status = 'active' GROUP BY categories.catID ORDER BY 'order' ASC";
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

?>

<style>
@media (max-width: 767.98px) {
    #visible-tab {
        display: none;
    }
}
</style>
<!-- Breadscrumb Section -->
<div class="breadcrumb-bar section services" style="padding: 10px">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-md-12 col-12">
                <div class="container">	
                    <!-- /Heading title -->
                    <div class="services-work">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon" style="border: 2px dashed #0db02b">
                                        <img class="icon-img" style="background-color: #0db02b" src="assets/img/icons/services-icon-01.svg" alt="Choose Locations">
                                    </div>
                                    <div class="<?php if (Session::exists('step') && Session::get('step') > 1) { ?>line-progress<?php } else { ?>line<?php } ?>"></div>
                                    <div class="services-content">
                                        <h3 style="color: #0db02b">1. Choose Location</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon" <?php if ($_SESSION['step'] > 1) { ?> style="border: 2px dashed #0db02b" <?php } else { ?> style="border: 2px dashed #201F1D" <?php } ?>>
                                        <img class="icon-img" <?php if ($_SESSION['step'] > 1) { ?> style="background-color: #0db02b" <?php } else { ?> style="background-color: #201F1D"  <?php } ?> src="assets/img/icons/services-icon-02.svg" alt="Choose Locations">
                                    </div>
                                    <div class="<?php if (Session::exists('step') && Session::get('step') > 2) { ?>line-progress<?php } else { ?>line<?php } ?>"></div>
                                    <div class="services-content">
                                        <h3 <?php if ($_SESSION['step'] > 1) { ?> style="color: #0db02b" <?php } else { ?> style="color: #FFFFFF" <?php } ?>> 2. Choose Car</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon" <?php if ($_SESSION['step'] > 2) { ?> style="border: 2px dashed #0db02b" <?php } else { ?> style="border: 2px dashed #201F1D" <?php } ?>>
                                        <img class="icon-img" <?php if ($_SESSION['step'] > 2) { ?> style="background-color: #0db02b" <?php } else { ?> style="background-color: #201F1D"  <?php } ?> src="assets/img/icons/services-icon-03.svg" alt="Choose Locations">
                                    </div>
                                    <div class="services-content">
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
<!-- <div class="container">
<?= $page->pageContent;?>
</div> -->
<!-- <br><br><br> -->
<div class="section-search"> 
    <div class="container">	  
        <div class="search-box-banner1" >
            <form action="/inchirieri-ajax.php" method="POST">
                <ul class="align-items-center">
                    <li class="column-group-main">
                        <div class="input-block">
                            <label>Pickup Location</label>												
                            <div class="group-img">
                                <!-- <input type="text" class="form-control" name="pickup_location" > -->
                                <?php if (Session::exists('pickup_location') && Session::get('pickup_location')) { ?>
                                    <select class="form-control" id="pickup_location" name="pickup_location" style="padding-left: 35px">
                                        <option <?php if($_SESSION['pickup_location'] == 'Bucuresti') echo 'selected'; ?>>Bucuresti</option>
                                        <option <?php if($_SESSION['pickup_location'] == 'Aeroport Otopeni') echo 'selected'; ?>>Aeroport Otopeni</option>
                                        <option <?php if($_SESSION['pickup_location'] == 'Brasov') echo 'selected'; ?>>Brasov</option>
                                        <option <?php if($_SESSION['pickup_location'] == 'Aeroport Brasov') echo 'selected'; ?>>Aeroport Brasov</option>
                                    </select>
                                <?php } else { ?>
                                    <select class="form-control" id="pickup_location" name="pickup_location" style="padding-left: 35px">
                                        <option>Bucuresti</option>
                                        <option>Aeroport Otopeni</option>
                                        <option>Brasov</option>
                                        <option>Aeroport Brasov</option>
                                    </select>
                                <?php } ?>
                                <span><i class="feather-map-pin"></i></span>
                            </div>
                        </div>
                    </li>
                    <li class="column-group-main">
                        <div class="input-block">
                            <label>Return Location</label>												
                            <div class="group-img">
                                <?php if (Session::exists('return_location') && Session::get('return_location')) { ?>
                                <input type="text" class="form-control" name="return_location" value="<?= $_SESSION['return_location']?>">
                                <?php } else { ?>
                                    <input type="text" class="form-control" name="return_location" value="Bucuresti">
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
                            <div class="input-block date-widget">												
                                <div class="group-img">
                                <input type="text" class="form-control" id="pickup_date" name="pickup_date" 
                                    value="<?php if (Session::exists('pickup_date') && Session::get('pickup_date')) echo $_SESSION['pickup_date'];
                                    else  {
                                        echo date('d-m-YYYY');
                                    }
                                    ?>">
                                <span><i class="feather-calendar"></i></span>
                                </div>
                            </div>
                            <div class="input-block time-widge">											
                                <div class="group-img">
                                <input type="text" class="form-control timepicker" name="pickup_time" value="<?php if (Session::exists('pickup_time') && Session::get('pickup_time')) echo $_SESSION['pickup_time'];
                                    else  {
                                        echo date('H:i');
                                    }
                                    ?>">
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
                            <div class="input-block date-widge">												
                                <div class="group-img">
                                <input type="text" class="form-control" id="return_date" name="return_date" 
                                    value="<?php if (Session::exists('return_date') && Session::get('return_date')) echo $_SESSION['return_date'];
                                    else  {
                                        echo date('d-m-YYYY');
                                    }
                                    ?>">
                                <span><i class="feather-calendar"></i></span>
                                </div>
                            </div>
                            <div class="input-block time-widge">											
                                <div class="group-img">
                                <input type="text" class="form-control timepicker" name="return_time" value="<?php if (Session::exists('return_time') && Session::get('return_time')) echo $_SESSION['return_time'];
                                    else  {
                                        echo date('H:i');
                                    }
                                    ?>">
                                <span><i class="feather-clock"></i></span>
                                </div>
                            </div>
                        </div>	
                    </li>
                    <li class="column-group-last">
                        <div class="input-block">
                            <div class="search-btn">
                                <button class="btn search-button" type="submit">Calculator</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </form>	
        </div>
    </div>	
</div>	


<div class="" id="visible-tab" style="background-color: #fcfbfb; margin-top: 10px">
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
                <?php
                $i = 0;
                foreach($cats as $cat) { ?>
                <div class="clear"></div>
                <h3><?= $cat['catName']; ?></h3>
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
                                <div class="listing-features">
                                    
                                    <h3 class="listing-title">
                                        <a href="/inchirieri.php?carID=<?=$car['carID']?>"><?php echo $car['carName'];?></a>
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
                                    <ul style="display: ruby-text">

                                    <?php $equip = explode(';', $car['equip']);
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
<section class="section " id="list-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                 
                    <?php
                    foreach($cats as $cat) { ?>
                    <div class="clear"></div>
                    <h3><?= $cat['catName']; ?></h3>
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
                                            <div class="blog-list-title">
                                                <h3><a href="/inchirieri.php?carID=<?=$car['carID']?>"><?= $car['carName']?></a></h3>
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
                                            <?php $equip = explode(';', $car['equip']);
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
        $('#list-content').css('display', 'none')
        $('#grid-content').show();

        var currentDate = moment(); // Get the current date
        var futureDate = currentDate.add(2, 'days'); // Add 7 days to the current date

        console.log(moment(new Date(), 'DD-MM-YYYY'),'==+++'); 
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
    });

    function submit_form(id)
    {
        var step = <?= $_SESSION['step']?>;

        if (step > 1)
            $('#rent_form_' + id).unbind('submit').submit();
        else if (step == 1)
        {
            $('#exampleModal').modal('show');
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

</script>