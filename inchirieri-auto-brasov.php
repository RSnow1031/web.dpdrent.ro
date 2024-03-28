<?php
require_once 'core/init.php';
require_once './layout/header.php';

Session::put('pickup_location', 'Brasov');
Session::put('return_location', 'Brasov');

$query = "SELECT * FROM cars WHERE special = 1 LIMIT 6";
$results = mysqli_query($db, $query);
$data = mysqli_fetch_all($results, MYSQLI_ASSOC);

$query = "SELECT * FROM cars WHERE status = 'active' ORDER BY RAND() LIMIT 4";
$results = mysqli_query($db, $query);
$recommend_cars = mysqli_fetch_all($results, MYSQLI_ASSOC);

// if (!Session::exists('calcutor_check') && !Session::get('calcutor_check'))
// 	Session::put('recommand_cars', $recommend_cars);

Session::put('recommand_cars', $recommend_cars);
$current_date = date('d-m-Y');
$current_time = date("H:i");
?>

<style>
	.has-badge {
	position: relative;
	display: inline-block;
	overflow: hidden;
}

.badge-overlay {
	position: absolute;
	top: 0;
	left: 0;
	
	&.triangle {
		color: yellow;
		font-weight: bold;
		
		&:before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			border: 20px solid red;
			border-right-color: transparent;
			border-bottom-color: transparent;
		}
		
		&:after {
			content: 'H';
			position: absolute;
			top: 0px;
			left: 5px;
		}
	}
	
	&.circle {
		background-color: #F2711C;
		color: white;
		font-weight: bold;
		font-size: 12px;
		border-radius: 6px;
		padding: 3px 6px;
		position: absolute;
		right: 5px;
		left: auto;
		top: 5px;
		bottom: auto;
	}
	
	&.square {
		background-color: red;
		color: yellow;
		font-weight: bold;
		padding: 5px 10px;
		position: absolute;
		left: auto;
		right: 5px;
		bottom: 5px;
		top: auto;
	}
	
	&.strip {
		position: absolute;
		top: 11px;
		left: -30px;
		background-color: red;
		color: yellow;
		font-weight: bold;
		padding: 2px 40px;
		transform: rotate(-45deg);
		z-index: 1;
		width: 150px;
	}
}
</style>

<!-- Banner -->
<!-- <section class="banner-section show-banner">
	<div class="">
		<div class="home-banner">		
			<div class="row align-items-center">
				<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
					<div class="carousel-indicators">
						<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
						<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
						<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
					</div>
					<div class="carousel-inner">
						<div class="carousel-item active">
						<img src="https://dpdrent.ro/images/rentcar_tpl_06/slide_6.jpg" style="width: 100%">
						</div>
						<div class="carousel-item">
						<img src="https://dpdrent.ro/images/rentcar_tpl_06/slide_7.jpg" style="width: 100%">
						</div>
						<div class="carousel-item">
						<img src="https://dpdrent.ro/images/rentcar_tpl_06/slide_4.jpg" style="width: 100%">
						</div>
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>
			</div>
		</div>	
	</div>
</section> -->
<!-- /Banner -->

<!-- Banner -->
<section class="banner-section banner-slider">		
	<div class="container">
		<div class="home-banner">		
			<div class="row align-items-center">					    
				<div class="col-lg-6" data-aos="fade-down">
					<!-- <p class="explore-text"> <span><i class="fa-solid fa-thumbs-up me-2"></i></span>100% Trusted car rental platform in the World</p>
					<h1>Find Your Best <br>									
					<span>Dream Car for Rental</span></h1>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
					<div class="view-all">
						<a href="listing-grid.html" class="btn btn-view d-inline-flex align-items-center">View all Cars <span><i class="feather-arrow-right ms-2"></i></span></a>
					</div> -->
				</div>
				<div class="col-lg-6" data-aos="fade-down">
					<div class="banner-imgs text-center">
						<img src="assets/img/large.png" class="img-fluid aos" alt="bannerimage">
						<div class="view-all">
							<h4 style="color: #FFFFFF; margin-top: -20px; margin-bottom: 10px">Noul MG - De la 35&euro;/zi </h4>	
							<!-- <a href="/" class="btn btn-secondary d-inline-flex align-items-center">REZERVARE<span><i class="feather-arrow-right ms-2"></i></span></a> -->
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</section>
<!-- /Banner -->

<!-- Search -->	
<div class="section-search"> 
	<div class="container">	  
		<div class="search-box-banner" >
			<form action="/inchirieri-ajax.php" method="post">
				<ul class="align-items-center">
					<li class="column-group-main">
						<div class="input-block">
							<label>Pickup Location</label>												
							<div class="group-img">
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
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="1" id="same_location" name="same_location" checked>
								<label class="form-check-label" for="same_location">
									Returnare la aceeasi locatie
								</label>
							</div>
						</div>
					</li>
					<li class="column-group-main" id="show_return_location">
						<div class="input-block">
							<label>Dropoff Location</label>												
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
								<input type="text" class="form-control " name="pickup_date" value="<?= (Session::exists('pickup_date')) ? Session::get('pickup_date') : date("d-m-Y"); ?>" id="pickup_date">
								<span><i class="feather-calendar"></i></span>
								</div>
							</div>
							<div class="input-block time-widge">											
								<div class="group-img">
								<input type="text" class="form-control timepicker" name="pickup_time" placeholder="11:00 AM" value="<?= (Session::exists('pickup_time')) ? $_SESSION['pickup_time'] : $current_time; ?>">
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
								<input type="text" class="form-control " id="return_date" name="return_date" value="<?= (Session::exists('return_date')) ? Session::get('return_date') : date("d-m-Y", strtotime("+2 days"))?>">
								<span><i class="feather-calendar"></i></span>
								</div>
							</div>
							<div class="input-block time-widge">											
								<div class="group-img">
								<input type="text" class="form-control timepicker" name="return_time" placeholder="11:00 AM" value="<?= $current_time?>">
								<span><i class="feather-clock"></i></span>
								</div>
							</div>
						</div>	
					</li>
					<li class="column-group-last">
						<div class="input-block">
							<div class="search-btn">
								<button class="btn search-button" style="background-color: #162153" type="submit"> Calculator</button>
							</div>
						</div>
					</li>
				</ul>
			</form>	
		</div>
	</div>	
</div>	
<!-- /Search -->

<!-- Popular Services -->
<section class="section popular-services popular-explore">		
	<div class="container">	
		<!-- Heading title-->
		<!-- <div class="section-heading" data-aos="fade-down">
			<h2>Explore Most Popular Cars</h2>
			<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
		</div> -->
		<!-- /Heading title -->
		<!-- <div class="row justify-content-center">
			<div class="col-lg-12" data-aos="fade-down">
				<div class="listing-tabs-group">
					<ul class="nav listing-buttons gap-3" data-bs-tabs="tabs">
						<li>
							<a class="active" aria-current="true" data-bs-toggle="tab" href="#Carmazda">
								<span>
									<img src="assets/img/icons/car-icon-01.svg" alt="Mazda">
								</span>
								Mazda
							</a>
						</li>
						<li>
							<a data-bs-toggle="tab" href="#Caraudi">
								<span>
									<img src="assets/img/icons/car-icon-02.svg" alt="Audi">
								</span>
								Audi
							</a>
						</li>
						<li>
							<a data-bs-toggle="tab" href="#Carhonda">
								<span>
									<img src="assets/img/icons/car-icon-03.svg" alt="Honda">
								</span>
								Honda
							</a>
						</li>
						<li>
							<a data-bs-toggle="tab" href="#Cartoyota">
								<span>
									<img src="assets/img/icons/car-icon-04.svg" alt="Toyota">
								</span>
								Toyota
							</a>
						</li>
						<li>
							<a data-bs-toggle="tab" href="#Caracura">
								<span>
									<img src="assets/img/icons/car-icon-05.svg" alt="Acura">
								</span>
								Acura 
							</a>
						</li>
						<li>
							<a data-bs-toggle="tab" href="#Cartesla">
								<span>
									<img src="assets/img/icons/car-icon-06.svg" alt="Tesla">
								</span>
								Tesla 
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div> -->
		<div class="tab-content">
			<div class="tab-pane active" id="Carmazda">	
				<div class="row">
					<?php foreach ($data as $index => $item) { 
					?>
					<!-- col -->
					<div class="col-lg-4 col-md-6 col-12 " data-aos="fade-down">
						<div class="listing-item has-badge">	
							<span class="badge-overlay strip">Special</span>
														
							<div class="listing-img">
								<a href="/inchirieri.php?carID=<?=$item['carID']?>">
									<img src="https://dpdrent.ro/uploads/cars/<?php echo $item['carPhoto'];?>"  class="img-fluid" style="height: 250px">
								</a>
								
							</div>										
							<div class="listing-content">
								<div class="listing-features">
									<h3 class="listing-title">
										<a href="listing-details.html"><?php echo $item['carName'];?></a>
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
										<?php if ($item['automatic']) { ?>
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
											<p><?php echo $item['limit_km']?> KM</p>
										</li>
										<li>
											<span><img src="assets/img/icons/car-parts-03.svg" alt="Petrol"></span>
											<p><?php echo $item['fuel']?></p>
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
									<div class="listing-price">
									<?php if (Session::exists('step') && Session::get('step') > 1) { 
										$cID = $item['carID'];
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
									?>
										<h6><strike style="font-size: 16px;margin-right: 5px; color: #000011">€<?php echo intval($rent_list[1] * $rent_list[0] * 1.1)?></strike><?php echo '€' . round($rent_list[1] * $rent_list[0] ) ?> <span>/ <?=$rent_list[0]?>Zi</span></h6>
									<?php } else { ?>
										<h6><strike style="font-size: 16px;margin-right: 5px; color: #000011">€<?php echo intval($item['price5'] * 1.1) . '~' . intval($item['price1'] * 1.1)?></strike><?php echo '€' . $item['price5'] . '~' . $item['price1']?> <span>/ Zi</span></h6>
									<?php } ?>
									</div>
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

<!-- Facts By The Numbers -->
<section class="section facts-number">
	
	<div class="container">
		<!-- Heading title-->
		<div class="section-heading" data-aos="fade-down">
			<h2 class="title text-white">Facts By The Numbers</h2>
			<p class="description text-white">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
		</div>
		<!-- /Heading title -->
		<div class="counter-group">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12 d-flex" data-aos="fade-down">
					<div class="count-group flex-fill">
						<div class="customer-count d-flex align-items-center">
							<div class="count-img">
								<img src="assets/img/icons/bx-heart.svg" alt="Icon">
							</div>
							<div class="count-content">
								<h4><span class="counterUp">16</span>K+</h4>
								<p>Happy Customers</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-12 d-flex" data-aos="fade-down">
					<div class="count-group flex-fill">
						<div class="customer-count d-flex align-items-center">
							<div class="count-img">
								<img src="assets/img/icons/bx-car.svg" alt="Icon">
							</div>
							<div class="count-content">
								<h4><span class="counterUp">2547</span>+</h4>
								<p>Count of Cars</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-12 d-flex" data-aos="fade-down">
					<div class="count-group flex-fill">
						<div class="customer-count d-flex align-items-center">
							<div class="count-img">
								<img src="assets/img/icons/bx-headphone.svg" alt="Icon">
							</div>
							<div class="count-content">
								<h4><span class="counterUp">625</span>K+</h4>
								<p>Car Center Solutions</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-12 d-flex" data-aos="fade-down">
					<div class="count-group flex-fill">
						<div class="customer-count d-flex align-items-center">
							<div class="count-img">
								<img src="assets/img/icons/bx-history.svg" alt="Icon">
							</div>
							<div class="count-content">
								<h4><span class="counterUp">200</span>K+</h4>
								<p>Total Kilometer</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /Facts By The Numbers -->

<!-- Rental deals -->
<section class="section popular-services">
	<div class="container">
		<div class="section-heading"  data-aos="fade-down">
			<h2>Recommended Car Rental deals</h2>
			<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
		</div>
		<div class="row">
			<div class="popular-slider-group">
				<div class="owl-carousel rental-deal-slider owl-theme">
					<?php foreach ($recommend_cars as $car) { ?>
					<div class="rental-car-item">
						<div class="listing-item mb-0">										
							<div class="listing-img">
								<a href="listing-details.html">
									<img src="https://dpdrent.ro/uploads/cars/<?php echo $car['carPhoto']?>" style="height: 250px !important">
								</a>
							</div>										
							<div class="listing-content">
								<div class="listing-features">												
									<div class="fav-item-rental">
										<span class="featured-text">&euro;<?php echo $car['price1']?>/zi</span>									
									</div>																  
									<div class="list-rating">							
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<span>(5.0)</span>
									</div>													
									<h3 class="listing-title">
										<a href="listing-details.html"><?php echo $car['carName'];?></a>
									</h3>
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
								<div class="listing-button">
									<a href="listing-details.html" class="btn btn-order"><span><i class="feather-calendar me-2"></i></span>Rent Now</a>
								</div>	
							</div>
						</div>
					</div>
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
	$(document).ready(function() {

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

	$(document).ready(function() {
		$("#pickup_date").datetimepicker({
			format: 'DD-MM-YYYY',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			},
			minDate: moment().startOf('day'),
		});

		$("#return_date").datetimepicker({
			format: 'DD-MM-YYYY',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			},
			minDate: moment().add(2, 'days').startOf('day')
		});
	});

	$("#pickup_date").blur(function() {
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

		
