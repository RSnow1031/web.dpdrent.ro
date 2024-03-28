<?php 
require_once 'core/init.php';
require_once './layout/header.php';

$query = "SELECT * FROM content WHERE pageURL = 'extra'";
$results = mysqli_query($db, $query);
$page = mysqli_fetch_object($results);

$query = "SELECT * FROM extras WHERE status = 'active' ORDER BY 'extraID' ASC";
$results = mysqli_query($db, $query);
$extras = mysqli_fetch_all($results, MYSQLI_ASSOC);
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
                                    <div class="line-progress"></div>
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
                                    <div class="line1-progress"></div>
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
            <hr>
            <?php foreach ($extras as $index => $extra) { ?>
                <?php if ($index % 2 == 0) { ?>
                    <table class="w-100">
                        <tr>
                            <td class="mr-1 align-left">
                                <img alt="Inchirieri auto cu Sofer"  src="https://dpdrent.ro/uploads/extras/<?=$extra['extraPhoto']?>" class="img-grey"/>
                            </td>
                            <td class="vt align-left">
                                <div  style="margin-left: 30px !important">
                                    <h6><?= $extra['extraTitle'] . ' - ' . $extra['extraPrice']; ?>/Perioada</h6><br>
                                    <p><?= $extra['extraText'] ; ?></p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <hr>
                <?php } else { ?>
                    <table class="w-100">
                        <tr>
                            <td class="vt align-left">
                                <div  style="margin-right: 30px !important">
                                    <h6><?= $extra['extraTitle'] . ' - ' . $extra['extraPrice']; ?>/Perioada</h6><br>
                                    <p><?= $extra['extraText'] ; ?></p>
                                </div>
                            </td>
                            <td class="vt align-left">
                                <img style="float:right" alt="Inchirieri auto cu Sofer"  src="https://dpdrent.ro/uploads/extras/<?=$extra['extraPhoto']?>" class="img-grey"/>
                            </td>
                        </tr>
                    </table>
                    <hr>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</section>
<?php 
require_once './layout/footer.php';
?>