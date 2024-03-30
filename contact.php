<?php 
require_once 'core/init.php';
Session::put('url', 'contact');
require_once './layout/header.php';
?>
		
<!-- Contact us -->
<section class="contact-section">
    <div class="container">
        <div class="contact-info-area">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12 d-flex" data-aos="fade-down" data-aos-duration="1200" data-aos-delay="0.1"> 
                    <div class="single-contact-info flex-fill">
                        <span><i class="feather-phone-call"></i></span>
                        <h3>Phone Number</h3>
                        <a href="tel: +40 (722) 332 549">(+40) 722 332 549</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 d-flex" data-aos="fade-down" data-aos-duration="1200" data-aos-delay="0.2"> 
                    <div class="single-contact-info flex-fill">
                        <span><i class="feather-mail"></i></span>
                        <h3>Email Address</h3>
                        <a href="mailto:johnsmith@example.com"><?= $site_email?></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 d-flex" data-aos="fade-down" data-aos-duration="1200" data-aos-delay="0.3"> 
                    <div class="single-contact-info flex-fill">
                        <span><i class="feather-map-pin"></i></span>
                        <h3>Location</h3>
                        <a href="javascript:void(0);">B-dul Eroilor Nr.118, Voluntari Ilfov</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 d-flex" data-aos="fade-down" data-aos-duration="1200" data-aos-delay="0.4"> 
                    <div class="single-contact-info flex-fill">
                        <span><i class="feather-clock"></i></span>
                        <h3>Opening Hours</h3>
                        <a href="javascript:void(0);">24/7</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-info-area" data-aos="fade-down" data-aos-duration="1200" data-aos-delay="0.5">
            <div class="row">
                <div class="col-lg-6 d-flex">
                    <iframe width="700" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=B-dul+Eroilor+Nr.118,+Voluntari+Ilfov&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=39.916234,79.013672&amp;ie=UTF8&amp;hq=&amp;hnear=Bulevardul+Eroilor,+Voluntari,+Ilfov,+Romania&amp;t=m&amp;z=14&amp;ll=44.492,26.171719&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=B-dul+Eroilor+Nr.118,+Voluntari+Ilfov&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=39.916234,79.013672&amp;ie=UTF8&amp;hq=&amp;hnear=Bulevardul+Eroilor,+Voluntari,+Ilfov,+Romania&amp;t=m&amp;z=14&amp;ll=44.492,26.171719" style="color:#0000FF;text-align:left"></a></small>
                </div>
                <div class="col-lg-6">
                    <form action="/contact-post.php" method="POST" novalidate class="needs-validation">
                        <div class="row">
                            <h1>Get in touch!</h1>
                            <div class="col-md-12"> 
                                <div class="input-block">
                                    <label>Nume: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="input-block">
                                    <label>E-mail: <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="input-block">
                                    <label>Telefon: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>								
                            <div class="col-md-12"> 
                                <div class="input-block">
                                    <label>Mesaj: <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="4" cols="50" id="message" name="message" required></textarea>
                                </div>
                            </div>
                        </div>		
                        <button class="btn btn-danger w-100" type="submit">TRIMITE</button>					
                    </form>
                </div>
            </div>
        </div>	
    </div>	
</section>	
<!-- /Contact us -->	

<?php 
require_once './layout/footer.php';
?>