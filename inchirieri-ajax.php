<?php
require_once './core/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Session::put('step', 2);
    $pickup = $_POST['pickup_location'];
    $pickup_date = $_POST['pickup_date'];
    $pickup_time = $_POST['pickup_time'];
    $dropoff_date = $_POST['return_date'];
    $dropoff_time = $_POST['return_time'];

    if (isset($_POST['same_location']))
    {
        $return_location = $_POST['pickup_location'];
        $same_location = $_POST['same_location'];
    }
    else
    {
        $return_location = $_POST['return_location'];
        $same_location = 0;
    }
    Session::put('pickup_location', $pickup);
    Session::put('return_location', $return_location);
    Session::put('pickup_date', $pickup_date);
    Session::put('pickup_time', $pickup_time);
    Session::put('return_date', $dropoff_date);
    Session::put('return_time', $dropoff_time);
    Session::put('same_location', $same_location);

}
header("Location: inchirieri-masini.php");
exit();
?>
