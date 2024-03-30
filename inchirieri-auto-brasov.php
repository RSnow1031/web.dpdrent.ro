<?php
require_once 'core/init.php';
Session::put('url', 'Brasov');
require_once './layout/header.php';

Session::put('pickup_location', 'Brasov');
Session::put('return_location', 'Brasov');

$query = "SELECT * FROM cars WHERE special = 1 LIMIT 6";
$results = mysqli_query($db, $query);
$data = mysqli_fetch_all($results, MYSQLI_ASSOC);

$query = "SELECT * FROM cars WHERE status = 'active' ORDER BY RAND() LIMIT 4";
$results = mysqli_query($db, $query);
$recommend_cars = mysqli_fetch_all($results, MYSQLI_ASSOC);

$query = "SELECT count(*) FROM calendar_cars";
$results = mysqli_query($db, $query);
$car_count = mysqli_fetch_row($results);

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
		top: 0px;
		left: -39px;
		background-color: red;
		color: yellow;
		font-weight: bold;
		padding: 2px 22px;
		transform: rotate(-45deg);
		z-index: 1;
		width: 200px;
	}
}

@media (max-width: 767.98px) {
	.why-content img {
		height: 30px !important;
		width: 
		30px !important;
	}

	#why-us-section {
		display: none;
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
							<h4 style="color: #FFFFFF">Noul MG - De la 35&euro;/zi </h4>	
							<!-- <a href="/" class="btn btn-view d-inline-flex align-items-center">Rent Now <span><i class="feather-arrow-right ms-2"></i></span></a> -->
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
			<form action="/inchirieri-ajax.php" method="post" class="needs-validation" novalidate>
				<ul class="align-items-center">
					<li class="column-group-main">
						<div class="input-block">
							<label>Pickup Location</label>												
							<div class="group-img">
								<?php if (Session::exists('pickup_location') && Session::get('pickup_location')) { ?>
                                    <select class="form-control" id="pickup_location" name="pickup_location" style="padding-left: 35px" required placeholder="Alege locatia">
										<option disabled value="">Alege locatia</option>
                                        <option value="Bucuresti" <?php if($_SESSION['pickup_location'] == 'Bucuresti') echo 'selected'; ?>>Bucuresti</option>
                                        <option value="Aeroport Otopeni" <?php if($_SESSION['pickup_location'] == 'Aeroport Otopeni') echo 'selected'; ?>>Aeroport Otopeni</option>
                                        <option value="Brasov" <?php if($_SESSION['pickup_location'] == 'Brasov') echo 'selected'; ?>>Brasov</option>
                                        <option value="Aeroport Brasov" <?php if($_SESSION['pickup_location'] == 'Aeroport Brasov') echo 'selected'; ?>>Aeroport Brasov</option>
                                    </select>
                                <?php } else { ?>
                                    <select class="form-control" id="pickup_location" name="pickup_location" style="padding-left: 35px" required placeholder="Alege locatia">
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
					<li class="column-group-main">
						<div class="input-block">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="1" id="same_location" name="same_location" checked >
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
                                <input type="text" class="form-control" name="return_location" value="<?= $_SESSION['return_location']?>" required>
                                <?php } else { ?>
                                    <input type="text" class="form-control" name="return_location" value="">
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
								<!-- <input type="text" class="form-control " name="pickup_date" value="<?= (Session::exists('pickup_date')) ? Session::get('pickup_date') : ''; ?>" id="pickup_date" required> -->
								<input type="text" class="form-control " name="pickup_date" value="<?= (Session::exists('pickup_date')) ? Session::get('pickup_date') : date("d-m-Y"); ?>" id="pickup_date" required>
								<span><i class="feather-calendar"></i></span>
								</div>
							</div>
							<div class="input-block time-widge">											
								<div class="group-img">
								<!-- <input type="text" class="form-control timepicker" name="pickup_time" value="<?= (Session::exists('pickup_time')) ? $_SESSION['pickup_time'] : ''; ?>" required> -->
								<input type="text" class="form-control timepicker" name="pickup_time" placeholder="11:00 AM" value="<?= (Session::exists('pickup_time')) ? $_SESSION['pickup_time'] : $current_time; ?>" required>
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
								<!-- <input type="text" class="form-control " id="return_date" name="return_date" value="<?= (Session::exists('return_date')) ? Session::get('return_date') : ''?>" required> -->
								<input type="text" class="form-control " id="return_date" name="return_date" value="<?= (Session::exists('return_date')) ? Session::get('return_date') : date("d-m-Y", strtotime("+2 days"))?>" required>
								<span><i class="feather-calendar"></i></span>
								</div>
							</div>
							<div class="input-block time-widge">											
								<div class="group-img">
								<!-- <input type="text" class="form-control timepicker" name="return_time" value="" required> -->
								<input type="text" class="form-control timepicker" name="return_time" value="<?= $current_time?>" required>
								<span><i class="feather-clock"></i></span>
								</div>
							</div>
						</div>	
					</li>
					<li class="column-group-last d-flex">
						<div class="input-block col-6">
							<div class="search-btn">
								<button class="btn search-button" style="background-color: #162153" type="submit"> Calculator</button>
							</div>
						</div>
						<div class="input-block col-6">
							<div class="search-btn" id="reset_btn" style="margin-top: 40px;text-align: right">
								<i class="fa fa-refresh"></i><a href="/reset-calculator.php">Reseteaza</a>
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
		<div class="section-heading" data-aos="fade-down">
			<h2>Sepecial offer!!</h2>
		</div>
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
							<span class="badge-overlay strip">Pret Special!</span>
														
							<div class="listing-img">
								<a href="/inchirieri.php?carID=<?=$item['carID']?>">
									<img src="https://dpdrent.ro/uploads/cars/<?php echo $item['carPhoto'];?>"  class="img-fluid" style="height: 250px">
								</a>
								
							</div>										
							<div class="listing-content">
								<div class="listing-features rental-car-item">												
									<div class="fav-item-rental">
										<span class="featured-text">De la &euro;<?php echo $item['price5']?>/zi</span>									
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
										<a href="/inchirieri.php?carID=<?=$item['carID']?>"><?php echo $item['carName'];?></a>
									</h3>
								</div> 
								<div class="listing-details-group">
                                    <ul style="display: ruby-text">

                                    <?php $equip = explode(';', $item['equip']);
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
									}
									?>
										<!-- <h6><?php echo '<b>Pret de la</b>&nbsp;€' . $item['price5']?>/Zi</h6> -->
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

<section class="section popular-services popular-explore pt-0" id="why-us-section">		
	<div class="container">	
		<div class="tab-content">
			<div class="tab-pane active why-content" id="Carmazda">	
				<div class="section-heading" data-aos="fade-down">
					<h2>DE CE NOI?</h2>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12 d-flex">
						<img src="/assets/uploads/1.png" style="height: 64px; width: 64px; background-color: #f8aa00; border-radius: 50%; margin-right: 10px"/>
						
						<div class="icon-text">
							<h5 class="title heading-font" style="color:#888888">Rent a car Bucuresti la preturi accesibile</h5><div class="content" style="line-height:20px;"><p>Compania DpD Exclusive Rental ofera servicii de inchirieri auto Bucuresti si Rent a Car in regim Non Stop, pentru cele mai ravnite modele de masini. In prezent, DpD Exclusive Rental isi desfasoara activitatea in mai multe orase centrale, oferind o suita de avantaje alaturi de cele mai calitative servicii de inchirieri auto si rent a car Bucuresti in regim non-stop. Este suficient sa ne apelati si va vom inchiria masina pentru curse in Bucuresti, Otopeni sau chiar Brasov, Cluj si Aeroportul International din Cluj. De asemenea, oferim servicii de transfer de la si catre Aeroportul Otopeni, precum si posibilitatea de a opta pentru inchirieri masini cu sofer personal sau inchirieri auto pe termen lung. Preturile noastre incep de la 10 euro fara garantie.</p><p><strong>De ce sa alegeti DpD Exclusive Rental?</strong></p><p>DpD Exclusive Rental este o companie dedicata serviciilor de inchirieri auto si rent a car la preturi mai mult decat accesibile, ofertandu-va cu o calitate superioara a serviciilor complete. Pentru ca ne dorim sa va fim alaturi ori de cate ori aveti nevoie sa inchiriati o masina pentru o cursa in Bucuresti, Cluj sau Brasov, va degrevam de birocratie, propunandu-va un proces de plata rapid si sigur. Beneficiarii, persoane fizice si / sau juridice, pot achita costul serviciilor rent a car cash. Nu impunem plata cu cardul si nici o garantie preliminara, intocmai pentru ca tinem cont de timpul dumneavoastra. Locatiile in care facem livrari sunt Bucuresti, Otopeni, Cluj-Napoca, Brasov, Iasi, Timisoara si Craiova. Pentru persoanele care doresc sa opteze pentru <a href="https://dpd-rentacar.ro/" target="_blank" rel="noopener noreferrer">rent a car Bucuresti</a>, oferim si serviciul de inchirieri auto Bucuresti in sistem urgent.</p></div></div>
						
					</div>
					<div class="col-lg-6 col-md-6 col-12 d-flex">
						<img src="/assets/uploads/2.png" class="mr-5" style="height: 64px; width: 64px; background-color: #f8aa00; border-radius: 50%; margin-right: 10px"/>
						
						<div class="icon-text">
							<h5 class="title heading-font" style="color:#888888">Pentru ce locatii se poate folosi sistemul de inchirieri auto din Bucuresti?</h5><div class="content" style="line-height:20px;"><p>Compania DpD Exclusive Rental este localizata in Voluntari, la intersectia dintre Bucuresti si aeroportul Otopeni, intr-o zona cu iesire la strada, pentru accesul cat mai facil al autovehiculelor. Compania propune pachete de servicii premium de Rent a car in Bucuresti. Accesandu-le, puteti beneficia de: piese de schimb accesibile, asigurari tip RCA – Casco (serviciu accesat prin DpD Insurance), <a href="https://tractariauto.co.ro/" target="_blank" rel="noopener noreferrer">tractari auto Bucuresti si asistenta rutiera</a>, servicii complete de leasing operational cu masini si modele noi, dar si <a href="https://dpdautomotive.ro/" target="_blank" rel="noopener noreferrer">service auto in orasul Bucuresti</a> (Bosch Car Service Negruzzi).</p><p>In prezent, DpD Exclusive Rental inchiriaza masini in Bucuresti si aeroportul Otopeni (transfer la si de la aeroport), dar si in Iasi, Brasov, Cluj-Napoca (oras si aeroport), Timisoara si Craiova. De curand, am implementat serviciul de rent a car Bucuresti – Otopeni in sistem de urgenta, astfel ca, independent de ora sau zi, sa aveti siguranta ca va puteti deplasa acolo unde este nevoie de dumneavoastra cu o masina sigura!</p></div>
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12 d-flex">
						<img src="/assets/uploads/3.png" class="mr-5" style="height: 64px; width: 64px; background-color: #f8aa00; border-radius: 50%; margin-right: 10px"/>
						<div class="icon-text">
							<h5 class="title heading-font" style="color:#888888">Avantajele oferite pentru inchirieri auto Bucuresti</h5><div class="content" style="line-height:20px;"><p>Tariful propus de compania noastra pentru inchirieri auto in Bucuresti pornesc de la valoarea de 10 euro, pret ce nu include garantie. Tariful este aplicat si in cazul transferului efectuat de la si spre Aeroportul Otopeni, dar si inchirierea masinilor conduse de un sofer personal sau inchirierea auto pe un termen mai lung, agreat de beneficiar si DpD Exclusive Rental.</p><p>Acum Mai Aproape De Dumneavoastra In Aeroportul Otopeni Prin Ofertele Noastre De Rent A Car – O Varietate De Modele De Masini – Cutie Viteze Automata Sau Manuala!</p><p>Compania noastra va ofera servicii premium de rent a car si inchirieri auto in regim non-stop atat in Bucuresti, Otopeni, Brasov sau Cluj. In egala masura, va punem la dispozitie si servicii rent a car fara depozit (fara raspundere), fara a va limita de la suita de modele ale masinilor pe care le puteti inchiria.</p><p><strong>Ce modele de masini se pot inchiria la DpD Exclusive Rental?</strong></p><p>Portofoliul companiei DpD Exclusive Rental gazduieste un numar impresionant de marci si modele de masini pe care le puteti inchiria. Detinem o flota cu peste 150 de masini noi, disponibila pentru clientii interesati de inchirieri auto:</p><p>Inchirieri Auto De Lux Bucuresti Si Otopeni – Bmw X5 Si X6, Audi A4, A5, A7 Si A8 (Cutie Automata) – Q5 Si Q7, Mercedes CLS Si Cabrio<br>
							Rent A Car Bucuresti De La 10 Euro (Low Cost) – Dacia Logan, Chevrolet, Hyndai, Opel, Peugeot, Volkswagen, Ford, Kia, Suzuki.</p><p>Serviciile noastre complete se raporteaza si la optiunea de a beneficia de accesoriile masinii inchiriate de dumneavoastra, de la GPS, scaun pentru copil si pana la portbagaj auto suplimentar sau lanturi pentru iarna.</p></div></div>
					</div>
					<div class="col-lg-6 col-md-6 col-12 d-flex">
						<img src="/assets/uploads/4.png" class="mr-5" style="height: 64px; width: 64px; background-color: #f8aa00; border-radius: 50%; margin-right: 10px"/>
						<div class="icon-text">
							<h5 class="title heading-font" style="color:#888888">Servicii De Inchirieri Masini Bucuresti Constant Imbunatatite</h5><div class="content" style="line-height:20px;"><p>Pentru ca ne dorim sa venim in intampinarea nevoilor si asteptarilor dumneavoastra, va punem la dispozitie o gama de servicii rent a car complete atat pentru Bucuresti si Otopeni, cat si pentru Cluj-Napoca, Brasov sau Timisoara. Pentru DpD Exclusive Rental, siguranta dumneavoastra este prioritara, astfel ca flota noastra de masini noi este verificata constant si beneficiaza de toate avizele reprezentative. Puteti inchiria o masina pentru curse in locatiile sus-mentionate contomitent cu serviciul de tractari auto in Bucuresti, care functioneaza in regim non-stop.</p><p>* Orice persoana fizica sau juridica poate solicita de un pachet de asigurari, respectiv Depozit (returnat in urma prestarii serviciului) sau Full Casco (incepand de la 5 euro / zi si raspundere 0 la minimum 6 zile de inchiriere).</p><p>*In limita stocului disponibil!</p><p>De ce rent a car Bucuresti prin DpD Exclusive Rental? Va oferim: cele mai mici tarife pentru inchirieri auto profesionale; transparenta si raspundere; inchirieri si tractari auto in regim non-stop; accesul facil la serviciile si masinile din portofoliu; masina dorita la set cu accesoriile de care ai nevoie.</p></div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- Rental deals -->
<section class="section popular-services" style="padding: 0px">
	<div class="container">
		<div class="section-heading"  data-aos="fade-down">
			<h2>Recommended Car Rental deals</h2>
		</div>
		<div class="row">
			<div class="popular-slider-group">
				<div class="owl-carousel rental-deal-slider owl-theme">
					<?php foreach ($recommend_cars as $car) { ?>
					<div class="rental-car-item">
						<div class="listing-item mb-0">										
							<div class="listing-img">
								<a href="/inchirieri.php?carID=<?=$car['carID']?>">
									<img src="https://dpdrent.ro/uploads/cars/<?php echo $car['carPhoto']?>" style="height: 250px !important">
								</a>
							</div>										
							<div class="listing-content">
								<div class="listing-features">												
									<div class="fav-item-rental">
										<span class="featured-text">De la &euro;<?php echo $car['price5']?>/zi</span>									
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
								<div class="listing-button">
									<a href="/inchirieri.php?carID=<?=$car['carID']?>" class="btn btn-order"><span><i class="feather-calendar me-2"></i></span>Rent Now</a>
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


<!-- Facts By The Numbers -->
<section class="section facts-number" style="padding : 10px">
	
	<div class="container">
		<!-- Heading title-->
		<div class="section-heading" data-aos="fade-down">
			<h2 class="title text-white">Facts By The Numbers</h2>
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
								
								<h4><span class="counterUp"><?=$car_count[0]?></span>+</h4>
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
								<h4><span class="counterUp">25</span>K+</h4>
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

		
