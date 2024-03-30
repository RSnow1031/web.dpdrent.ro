<?php
require_once 'core/init.php';
require_once './layout/header.php';

$query = "SELECT * FROM content WHERE pageURL = 'multumim'";
$results = mysqli_query($db, $query);
$page_content = mysqli_fetch_object($results);
Session::delete('pickup_location');
Session::delete('return_location');
Session::delete('pickup_date');
Session::delete('pickup_time');
Session::delete('return_date');
Session::delete('return_time');
Session::delete('same_location');
Session::put('step', 1);
Session::delete('extra_content');
Session::delete('carID');
Session::delete('extra_price');
Session::delete('casco');
Session::delete('distance_dropoff_price');
Session::delete('drop_off_price');
Session::delete('total_price');
?>

		
<!-- Breadscrumb Section -->
<!-- <div class="breadcrumb-bar">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">SUCCESS COMANDA</h2>
            </div>
        </div>
    </div>
</div> -->
<style>
    .payment-success .check {
        display: inline-block;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: #1FBC2F;
        margin: auto;
        margin-bottom: 25px;
    }
</style>
<!-- /Breadscrumb Section -->
<!-- Main Wrapper -->
<section class="contact-section pt-5" >
    <div class="container">
        <div class="form-info-area" data-aos="fade-down" data-aos-duration="1200" data-aos-delay="0.5">
        <div class="text-center mt-5 mb-5">
            <div class="payment-success">
                <span class="check"><i class="fa-solid fa-check-double" style="font-size: 120px;color: #FFFFFF;margin-top: 10px"></i></span>
            </div>						
            <h2 class="coming-soon" style="font-size: 28px !important"><?= $page_content->pageContent?></h2>
            <br>
            <br>
            <br>
            <br>
            <br>
            <a href="/" class="btn-maintance btn btn-primary">Back to Home</a>
        </div>
    </div>
</section>
<!-- /Main Wrapper -->
<h4 class="bold">
    
</h4>

<?php require_once './layout/footer.php';?>
