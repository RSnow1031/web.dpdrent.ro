<?php
require_once './core/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cID = $_POST['carId'];
    Session::put('carID', $cID);
    Session::put('step', 3);
    
    // $pickup = $_POST['pickup_location'];
    // $pickup_date = $_POST['pickup_date'];
    // $pickup_time = $_POST['pickup_time'];
    // $dropoff_date = $_POST['return_date'];
    // $dropoff_time = $_POST['return_time'];
    // Session::put('pickup_location', $pickup);
    // Session::put('pickup_date', $pickup_date);
    // Session::put('pickup_time', $pickup_time);
    // Session::put('return_date', $dropoff_date);
    // Session::put('return_time', $dropoff_time);
}

header("Location: rezervare.php");
exit();
?>
