<?php 
require_once 'core/init.php';
    
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

header('Location: inchirieri-masini.php');
exit();
?>