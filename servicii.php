<?php 
require_once 'core/init.php';
Session::put('url', 'servicii');
require_once './layout/header.php';

$query = "SELECT * FROM content WHERE pageURL = 'servicii'";
$results = mysqli_query($db, $query);
$page = mysqli_fetch_object($results);

$query = "SELECT * FROM content WHERE pageURL = 'services1'";
$results = mysqli_query($db, $query);
$services1 = mysqli_fetch_object($results);

$query = "SELECT * FROM content WHERE pageURL = 'services2'";
$results = mysqli_query($db, $query);
$services2 = mysqli_fetch_object($results);

$query = "SELECT * FROM content WHERE pageURL = 'services3'";
$results = mysqli_query($db, $query);
$services3 = mysqli_fetch_object($results);


?>
<!-- Breadscrumb Section -->
<div class="breadcrumb-bar section services" style="padding: 10px">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-md-12 col-12">
                <div class="container">	
                    <!-- /Heading title -->
                    <div class="services-work">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-4" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon" style="border: 2px dashed #0db02b">
                                        <img class="icon-img" style="background-color: #0db02b" src="assets/img/icons/services-icon-01.svg" alt="Choose Locations">
                                    </div>
                                    <div class="line-progress"></div>
                                    <div class="services-content">
                                        <h3 style="color: #0db02b">1. Choose Location</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon" style="border: 2px dashed #0db02b">
                                        <img class="icon-img" style="background-color: #0db02b" src="assets/img/icons/services-icon-02.svg" alt="Choose Locations">
                                    </div>
                                    <div class="line-progress"></div>
                                    <div class="services-content">
                                        <h3 style="color: #0db02b">2. Choose Car</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon" style="border: 2px dashed #0db02b">
                                        <img class="icon-img" style="background-color: #0db02b" src="assets/img/icons/services-icon-03.svg" alt="Choose Locations">
                                    </div>
                                    <div class="services-content">
                                        <h3 style="color: #0db02b">3. Book a Car</h3>
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

<section class="contact-section pt-5" >
    <div class="container">
        <div class="form-info-area" data-aos="fade-down" data-aos-duration="1200" data-aos-delay="0.5">
        <section class="">
            <div class="container">
                <div class="col-md-12">
                    <table>
                        <tr>
                            <td class="vt align-left">
                                <div style="margin-right: 30px !important"><?= $page->pageContent?></div>
                            </td>
                            <td class="vt align-left">
                                <!-- <i class="fa fa-plane stm-service-primary-color" style="font-size:100px;color: #000000"></i> -->
                                <img style="width: 200px" alt="Transfer Aeroport Otopeni"  src="/assets/img/home-cars-bg.jpeg" class="img-grey"/>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <table>
                        <tr>
                            <td class="vt align-left">
                                <div  style="margin-right: 30px !important"><?= $services1->pageContent; ?></div>
                            </td>
                            <td class="vt align-left">
                                <i class="fa fa-plane stm-service-primary-color" style="font-size:100px;color: #000000"></i>
                                <!-- <img  alt="Transfer Aeroport Otopeni"  src="https://dpdrent.ro/images/airport_transfer.jpg" class="img-grey"/> -->
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <table>
                        <tr>
                            <td class="mr-1 align-left">
                                <i class="fa fa-id-card stm-service-primary-color" style="font-size:100px;color: #000000"></i>
                                <!-- <img alt="Inchirieri auto cu Sofer"  src="https://dpdrent.ro/images/private-driver.jpg" class="img-grey"/> -->
                            </td>
                            <td class="vt align-left">
                                <div  style="margin-left: 30px !important"><?= $services2->pageContent; ?></div>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <table>
                        <tr>
                            <td class="vt align-left">
                            <div  style="margin-right: 30px !important"><?= $services3->pageContent; ?></div>
                            </td>
                            <td class="vt align-left">
                                <img  alt="Leasing Operational pentru auto noi si rulate"  src="https://dpdrent.ro/images/long_term.jpg" class="img-grey" style="margin-right:-5px;" />
                            </td>
                        </tr>
                    </table>
                    
                    <!-- <div class="review-sec extra-service">
                        <div class="review-header">
                            <h4>Extra Service</h4>
                        </div>
                        <div class="wishlist-wrap container">
                            <div class="listview-car">
                                <div class="card">
                                    <div class="blog-widget d-flex">
                                        <div class="blog-img">
                                            <a href="listing-details.html">
                                                <img src="assets/img/car-list-2.jpg" class="img-fluid" alt="blog-img">
                                            </a>		
                                        </div>
                                        <div class="bloglist-content w-100">
                                        <div class="card-body">
                                            <div class="blog-list-head d-flex">
                                                <div class="blog-list-title">
                                                    <h3><a href="listing-details.html">BMW 640 XI Gran Turismo</a></h3>
                                                        
                                                </div>
                                            </div>	
                                            
                                        </div>			 
                                    </div> 
                                </div>
                            </div>
                        </div>	
                    </div> -->
                </div>
            </div>
            <br><br><br>
            <div class="container">
                <h4>Interesat de unul din serviciile de mai sus?</h4>
                <div class="booking-form mt-5">
                    <form class="mb-5 needs-validation" method="POST" id="service-form" action="/ajax/service-ajax.php" novalidate>
                        <div class="row">
                            <div class="col-lg-4">						
                                <div class="input-block">														
                                    <label>Nume <span class="text-danger">*</span></label>	
                                    <input type="text" class="form-control" id="nume" name="nume" required>
                                </div>
                            </div>
                            <div class="col-lg-4">													
                                <div class="input-block">
                                    <label>Prenume: <span class="text-danger">*</span></label>	
                                    <input type="text" class="form-control" id="prenume" name="prenume" required>
                                </div>
                            </div>
                            <div class="col-lg-4">												
                                <div class="input-block">														
                                    <label>Telefon: (ex: +40726616161)<span class="text-danger">*</span></label>	
                                    <input type="text" class="form-control" id="telefon" name="telefon" required>
                                </div>
                            </div>
                            <div class="col-lg-4">													
                                <div class="input-block">
                                    <label>Serviciu: <span class="text-danger">*</span></label>	
                                    <select name="serviciu" id="serviciu" class="form-control" required>
                                        <option value="">alege...</option>
                                        <option value="Transfer Aeroport">Transfer Aeroport</option>
                                        <option value="Inchirieri Auto cu Sofer">Inchiriere Auto cu Sofer</option>
                                        <option value="Leasing Operational">Leasing Operational</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">													
                                <div class="input-block">
                                    <label>Locatie Preluare: <span class="text-danger">*</span></label>	
                                    <select class="form-control" name="locatie_preluare" id="locatie_preluare" required>
                                        <option value="">alege...</option>
                                        <option value="Bucuresti">Bucuresti</option>
                                        <option value="Aeroport Otopeni">Aeroport Otopeni</option>
                                        <option value="Brasov">Brasov</option>
                                        <option value="Aeroport Brasov">Aeroport Brasov</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">												    
                                <div class="input-block">
                                    <label>Destinatie:  <span class="text-danger">*</span></label>	
                                    <input type="text" class="form-control" id="destinatie" name="destinatie" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-block">
                                    <label>Data Preluare: <span class="text-danger">*</span></label>	
                                    <div class="input-block-wrapp d-flex">
                                        <div class="input-block date-widget">
                                            <div class="group-img">
                                            <input type="text" class="form-control " id="data_preluare" name="data_preluare" value="" required>
                                            </div>
                                        </div>
                                        <div class="input-block time-widge">											
                                            <div class="group-img">
                                            <input type="text" class="form-control timepicker" name="pickup_time" value="" required>
                                            </div>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                            <div class="col-lg-4">													
                                <div class="input-block">
                                    <label>Numar zbor: <span class="text-danger">*</span></label>	
                                    <input type="text" class="form-control" id="nr_zbor" name="nr_zbor" required>
                                </div>
                            </div>
                            <div class="col-lg-4">													
                                <div class="input-block">
                                    <label>Email: <span class="text-danger">*</span></label>	
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="input-block">
                                    <label>Detalii: <span class="text-danger"> </span> </label>	
                                    <textarea rows="4" class="form-control" id="detalii" name="detalii"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="payment-btn" style="float: right">
                            <button class="btn btn-danger submit-review" type="submit">TRIMITE<i class="fa-solid fa-arrow-right ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>

        </section>
        </div>	
    </div>	
</section>	

<?php 
require_once './layout/footer.php';
?>
<script>
    $(document).ready(function() {
        $('#data_preluare').datetimepicker({
            format: 'DD-MM-YYYY',
            icons: {
                up: "fas fa-angle-up",
                down: "fas fa-angle-down",
                next: 'fas fa-angle-right',
                previous: 'fas fa-angle-left'
            },
            minDate: moment().startOf('day'),
        })

        $('#service-form').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var formAction = '/ajax/service-ajax.php'
            $.ajax({
                type: "POST",
                url: formAction,
                data: formData,
                success: function(response) {
                    if (response == true)
                    {
                        window.location.replace('/servicii.php')
                    }
                }
            });
        })
    })
</script>