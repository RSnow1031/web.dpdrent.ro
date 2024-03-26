<?php
?>
    <h4 class="faq-title">
        <a class="collapsed" data-bs-toggle="collapse" href="#faqThree" aria-expanded="false">Modify Book</a>
    </h4>
    <div id="faqThree" class="card-collapse collapse">
        <div class="review-sec mt-0">
            <div class="review-header">
                <h4>Check Availability</h4>
            </div>
            <div class="">		
                <form class="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <ul>
                        <li class="column-group-main">
                            <div class="input-block">
                                <label>Pickup Location</label>												
                                <div class="group-img">
                                    <select class="form-control" id="pickup_location" name="pickup_location">
                                        <option <?php if ($_SESSION['pickup_location'] == "Bucuresti") echo "selected" ?> value="Bucuresti">Bucuresti</option>
                                        <option <?php if ($_SESSION['pickup_location'] == "Aeroport Otopeni") echo "selected" ?> value="Aeroport Otopeni">Aeroport Otopeni</option>
                                        <option <?php if ($_SESSION['pickup_location'] == "Brasov") echo "selected" ?> value="Brasov">Brasov</option>
                                        <option <?php if ($_SESSION['pickup_location'] == "Aeroport Brasov") echo "selected" ?> value="Aeroport Brasov">Aeroport Brasov</option>
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li class="column-group-main">
                            <div class="input-block">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="same_location" name="same_location" <?php if ($_SESSION['same_location'] == 1) { ?> checked <?php } ?>>
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
                                    <input type="text" class="form-control" name="return_location" value="<?= $_SESSION['return_location']?>">
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
                                    <input type="text" class="form-control datetimepicker" name="pickup_date" value="<?= ($_SESSION['pickup_date'] != null) ? $_SESSION['pickup_date'] : date("d-m-Y"); ?>" id="pickup_date">
                                    <!-- <input type="text" id="pickup_date" name="pickup_date" class="form-control datetimepicker" placeholder="04/11/2023"> -->
                                    </div>
                                </div>
                                <div class="input-block">											
                                    <div class="group-img">
                                    <!-- <input type="text" class="form-control timepicker" placeholder="11:00 AM"> -->
								        <input type="text" class="form-control timepicker" name="pickup_time" placeholder="11:00 AM" value="<?= $_SESSION['pickup_time']?>">
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
        								<input type="text" class="form-control datetimepicker" id="return_date" name="return_date" value="<?=$_SESSION['return_date']?>">
                                    <!-- <input type="text" id="return_date" name="return_date" class="form-control datetimepicker" placeholder="04/11/2023"> -->
                                    </div>
                                </div>
                                <div class="input-block">											
                                    <div class="group-img">
								        <input type="text" class="form-control timepicker" name="return_time" value="<?= $_SESSION['return_time']?>">
                                    <!-- <input type="text" class="form-control timepicker" placeholder="11:00 AM"> -->
                                    </div>
                                </div>
                            </div>	
                        </li>
                        <li class="column-group-last">
                            <div class="input-block mb-0">
                                <div class="search-btn">
                                    <button class="btn btn-primary w-100" type="submit"> Calculator</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </form>	
            </div>	
        </div>
    </div>