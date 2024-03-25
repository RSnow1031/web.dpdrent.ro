<?php
require_once 'core/init.php';
require_once './layout/header.php';
?>
<style>
/*------------------------*/
input:focus,
button:focus,
.form-control:focus{
	outline: none;
	box-shadow: none;
}
.form-control:disabled, .form-control[readonly]{
	background-color: #fff;
}
/*----------step-wizard------------*/
.d-flex{
	display: flex;
}
.justify-content-center{
	justify-content: center;
}
.align-items-center{
	align-items: center;
}

/*---------signup-step-------------*/
.bg-color{
	background-color: #333;
}
.signup-step-container{
	padding: 150px 0px;
	padding-bottom: 60px;
}




    .wizard .nav-tabs {
        position: relative;
        margin-bottom: 0;
        border-bottom-color: transparent;
    }

    .wizard > div.wizard-inner {
            position: relative;
    margin-bottom: 50px;
    text-align: center;
    }

.connecting-line {
    height: 2px;
    background: #e0e0e0;
    position: absolute;
    width: 75%;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 15px;
    z-index: 1;
}

.wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
    color: #555555;
    cursor: default;
    border: 0;
    border-bottom-color: transparent;
}

span.round-tab {
    width: 30px;
    height: 30px;
    line-height: 30px;
    display: inline-block;
    border-radius: 50%;
    background: #fff;
    z-index: 2;
    position: absolute;
    left: 0;
    text-align: center;
    font-size: 16px;
    color: #0e214b;
    font-weight: 500;
    border: 1px solid #ddd;
}
span.round-tab i{
    color:#555555;
}
.wizard li.active span.round-tab {
        background: #0db02b;
    color: #fff;
    border-color: #0db02b;
}
.wizard li.active span.round-tab i{
    color: #5bc0de;
}
.wizard .nav-tabs > li.active > a i{
	color: #0db02b;
}

.wizard .nav-tabs > li {
    width: 25%;
}

.wizard li:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: red;
    transition: 0.1s ease-in-out;
}



.wizard .nav-tabs > li a {
    width: 30px;
    height: 30px;
    margin: 20px auto;
    border-radius: 100%;
    padding: 0;
    background-color: transparent;
    position: relative;
    top: 0;
}
.wizard .nav-tabs > li a i{
	position: absolute;
    top: -15px;
    font-style: normal;
    font-weight: 400;
    white-space: nowrap;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
    font-weight: 700;
    color: #000;
}

    .wizard .nav-tabs > li a:hover {
        background: transparent;
    }

.wizard .tab-pane {
    position: relative;
    padding-top: 20px;
}


.wizard h3 {
    margin-top: 0;
}
.prev-step,
.next-step{
    font-size: 13px;
    padding: 8px 24px;
    border: none;
    border-radius: 4px;
    margin-top: 30px;
}
.next-step{
	background-color: #0db02b;
}
.skip-btn{
	background-color: #cec12d;
}
.step-head{
    font-size: 20px;
    text-align: center;
    font-weight: 500;
    margin-bottom: 20px;
}
.term-check{
	font-size: 14px;
	font-weight: 400;
}
.custom-file {
    position: relative;
    display: inline-block;
    width: 100%;
    height: 40px;
    margin-bottom: 0;
}
.custom-file-input {
    position: relative;
    z-index: 2;
    width: 100%;
    height: 40px;
    margin: 0;
    opacity: 0;
}
.custom-file-label {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1;
    height: 40px;
    padding: .375rem .75rem;
    font-weight: 400;
    line-height: 2;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: .25rem;
}
.custom-file-label::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 3;
    display: block;
    height: 38px;
    padding: .375rem .75rem;
    line-height: 2;
    color: #495057;
    content: "Browse";
    background-color: #e9ecef;
    border-left: inherit;
    border-radius: 0 .25rem .25rem 0;
}
.footer-link{
	margin-top: 30px;
}
.all-info-container{

}
.list-content{
	margin-bottom: 10px;
}
.list-content a{
	padding: 10px 15px;
    width: 100%;
    display: inline-block;
    background-color: #f5f5f5;
    position: relative;
    color: #565656;
    font-weight: 400;
    border-radius: 4px;
}
.list-content a[aria-expanded="true"] i{
	transform: rotate(180deg);
}
.list-content a i{
	text-align: right;
    position: absolute;
    top: 15px;
    right: 10px;
    transition: 0.5s;
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fdfdfd;
}
.list-box{
	padding: 10px;
}
.signup-logo-header .logo_area{
	width: 200px;
}
.signup-logo-header .nav > li{
	padding: 0;
}
.signup-logo-header .header-flex{
	display: flex;
	justify-content: center;
	align-items: center;
}
.list-inline li{
    display: inline-block;
}
.pull-right{
    float: right;
}
/*-----------custom-checkbox-----------*/
/*----------Custom-Checkbox---------*/
input[type="checkbox"]{
    position: relative;
    display: inline-block;
    margin-right: 5px;
}
input[type="checkbox"]::before,
input[type="checkbox"]::after {
    position: absolute;
    content: "";
    display: inline-block;   
}
input[type="checkbox"]::before{
    height: 16px;
    width: 16px;
    border: 1px solid #999;
    left: 0px;
    top: 0px;
    background-color: #fff;
    border-radius: 2px;
}
input[type="checkbox"]::after{
    height: 5px;
    width: 9px;
    left: 4px;
    top: 4px;
}
input[type="checkbox"]:checked::after{
    content: "";
    border-left: 1px solid #fff;
    border-bottom: 1px solid #fff;
    transform: rotate(-45deg);
}
input[type="checkbox"]:checked::before{
    background-color: #18ba60;
    border-color: #18ba60;
}

@media (max-width: 767px){
	.sign-content h3{
		font-size: 40px;
	}
	.wizard .nav-tabs > li a i{
		display: none;
	}
	.signup-logo-header .navbar-toggle{
		margin: 0;
		margin-top: 8px;
	}
	.signup-logo-header .logo_area{
		margin-top: 0;
	}
	.signup-logo-header .header-flex{
		display: block;
	}
}

</style>
<!-- Breadscrumb Section -->
<div class="breadcrumb-bar">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Chevrolet Camaro</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Listings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chevrolet Camaro</li>
                    </ol>
                </nav>							
            </div>
        </div>
    </div>
</div>
<!-- /Breadscrumb Section -->

<div class="container"></div>,<div class="container">

<section class="signup-step-container">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>Choosed Car</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span> <i>Option</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab">3</span> <i>Plata</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab">4</span> <i>Confirmare</i></a>
                            </li>
                        </ul>
                    </div>
    
                    <form role="form" action="index.html" class="login-box">
                        <div class="tab-content" id="main_form">
                            <div class="tab-pane active" role="tabpanel" id="step1">
                                <h4 class="text-center">Step 1</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First and Last Name *</label> 
                                            <input class="form-control" type="text" name="name" placeholder=""> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number  *</label> 
                                            <input class="form-control" type="text" name="name" placeholder=""> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email Address *</label> 
                                            <input class="form-control" type="email" name="name" placeholder=""> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password *</label> 
                                            <input class="form-control" type="password" name="name" placeholder=""> 
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn next-step">Continue to next step</button></li>
                                </ul>
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
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

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

<section class="section product-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="detail-product">
                    <div class="slider detail-bigimg">
                        <div class="product-img">
                            <img src="assets/img/cars/slider-01.jpg" alt="Slider">
                        </div>
                        <div class="product-img">
                            <img src="assets/img/cars/slider-02.jpg" alt="Slider">
                        </div>
                        <div class="product-img">
                            <img src="assets/img/cars/slider-03.jpg" alt="Slider">
                        </div>
                        <div class="product-img">
                            <img src="assets/img/cars/slider-04.jpg" alt="Slider">
                        </div>
                        <div class="product-img">
                            <img src="assets/img/cars/slider-05.jpg" alt="Slider">
                        </div>
                    </div>
                    <div class="slider slider-nav-thumbnails">
                        <div><img src="assets/img/cars/slider-thum-01.jpg" alt="product image"></div>
                        <div><img src="assets/img/cars/slider-thum-02.jpg" alt="product image"></div>
                        <div><img src="assets/img/cars/slider-thum-03.jpg" alt="product image"></div>
                        <div><img src="assets/img/cars/slider-thum-04.jpg" alt="product image"></div>
                        <div><img src="assets/img/cars/slider-thum-05.jpg" alt="product image"></div>
                    </div>
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
            <div class="col-lg-4 theiaStickySidebar">
                <div class="review-sec mt-0">
                    <div class="review-header">
                        <h4>Check Availability</h4>
                    </div>
                    <div class="">		
                        <form class="">
                            <ul>
                                <li class="column-group-main">
                                    <div class="input-block">
                                        <label>Pickup Location</label>												
                                        <div class="group-img">
                                            <input type="text" class="form-control" placeholder="45, 4th Avanue  Mark Street USA">
                                        </div>
                                    </div>
                                </li>
                                <li class="column-group-main">
                                    <div class="input-block">
                                        <label>Dropoff Location</label>												
                                        <div class="group-img">
                                            <input type="text" class="form-control" placeholder="78, 10th street Laplace USA">
                                        </div>
                                    </div>
                                </li>
                                <li class="column-group-main">						
                                    <div class="input-block m-0">																	
                                        <label>Pickup Date</label>
                                    </div>
                                    <div class="input-block-wrapp sidebar-form">
                                        <div class="input-block me-2">												
                                            <div class="group-img">
                                            <input type="text" class="form-control datetimepicker" placeholder="04/11/2023">
                                            </div>
                                        </div>
                                        <div class="input-block">											
                                            <div class="group-img">
                                            <input type="text" class="form-control timepicker" placeholder="11:00 AM">
                                            </div>
                                        </div>
                                    </div>	
                                </li>
                                <li class="column-group-main">						
                                    <div class="input-block m-0">																	
                                        <label>Return Date</label>
                                    </div>
                                    <div class="input-block-wrapp sidebar-form">
                                        <div class="input-block me-2">												
                                            <div class="group-img">
                                            <input type="text" class="form-control datetimepicker" placeholder="04/11/2023">
                                            </div>
                                        </div>
                                        <div class="input-block">											
                                            <div class="group-img">
                                            <input type="text" class="form-control timepicker" placeholder="11:00 AM">
                                            </div>
                                        </div>
                                    </div>	
                                </li>
                                <li class="column-group-last">
                                    <div class="input-block mb-0">
                                        <div class="search-btn">
                                            <button class="btn btn-primary check-available w-100" type="button" data-bs-toggle="modal" data-bs-target="#pages_edit"> Check Availability</button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </form>	
                    </div>	
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
</script>