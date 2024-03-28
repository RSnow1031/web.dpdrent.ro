<?php 
require_once 'core/init.php';
require_once './layout/header.php';

$query = "SELECT * FROM content WHERE pageURL = 'termeni-conditii'";
$results = mysqli_query($db, $query);
$page = mysqli_fetch_object($results);

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
                            <div class="col-lg-4 col-md-4 col-12" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon" style="border: 2px dashed #0db02b">
                                        <img class="icon-img" style="background-color: #0db02b" src="assets/img/icons/services-icon-01.svg" alt="Choose Locations">
                                    </div>
                                    <div class="services-content">
                                        <h3 style="color: #0db02b">1. Choose Location</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12" data-aos="fade-down">
                                <div class="services-group">
                                    <div class="services-icon" style="border: 2px dashed #0db02b">
                                        <img class="icon-img" style="background-color: #0db02b" src="assets/img/icons/services-icon-02.svg" alt="Choose Locations">
                                    </div>
                                    <div class="services-content">
                                        <h3 style="color: #0db02b">2. Choose Car</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12" data-aos="fade-down">
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

<section class="section product-details">
    <div class="container">
        <div class="col-md-12">
            <?= $page->pageContent?>
        </div>
    </div>
</section>
<?php 
require_once './layout/footer.php';
?>