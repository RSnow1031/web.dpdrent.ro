<?php 
    require_once '../core/init.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $car_type = $_POST['carID'];
        $pickupdate = $_POST['data_preluare'] . ' ' . $_POST['pickup_time'];
        $dropoffdate = $_POST['data_returnare'] . ' ' .$_POST['return_time'];
        $pick = $_POST['locatie_preluare'];

        $casco_days = 0;
        $hours = (strtotime($dropoffdate) - strtotime($pickupdate)) / 3600;
        if ($hours > 0) {
            if ($hours > 24) {
                if ((($hours) % 24) >= 4) {
                    $d = ceil($hours / 24);
                    $casco_days = $d . ' x ' . getCarPriceBetweenTwoDatesWithDiscount($db, $car_type, $d, $pickupdate);
                } else {
                    $d = floor($hours / 24);
                    $casco_days = $d . ' x ' . getCarCascoBetweenTwoDates($db, $car_type, $d, $pickupdate);
                }
            } else {
                $d = 1;
                $casco_days = $d . ' x ' . getCarCascoBetweenTwoDates($db, $car_type, $d, $pickupdate);
            }
        }
        echo $casco_days;
    }
?>