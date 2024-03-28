<?php
session_start();

$GLOBALS['config'] = array(
		'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db' => 'new_rental'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

$db = mysqli_connect('localhost', 'root', '', 'new_rental', '3306');
if (!$db) {
    die("Couldn't connect to database: " . mysqli_connect_error());
}

function getCarPriceBetweenTwoDatesWithDiscount($db,$carID, $days, $startDate = null, $cityID = '') {
    switch ($days) {
        case ($days >= 1 && $days <= 3):
            $price = 'price1';
            break;
        case ($days >= 4 && $days <= 7):
            $price = 'price2';
            break;
        case ($days >= 8 && $days <= 15):
            $price = 'price3';
            break;
        case ($days >= 16 && $days <= 21):
            $price = 'price4';
            break;
        case ($days > 21):
            $price = 'price5';
            break;
        default:
            $price = 'price1';
    }

    $query = "SELECT * FROM cars WHERE carID = " . $carID;
    $results = mysqli_query($db, $query);
    $row = mysqli_fetch_object($results);

    $standardPrice = $row->$price;
    if ($startDate != null) {
        //check current month & year for both dates
        $new_start = date("n", strtotime($startDate));

        $query = "SELECT * FROM prices JOIN pickup ON prices.cityID = pickup.pickID WHERE pickup.pickUpName = '" . $cityID ."' AND prices.month = " . $new_start;
        $results = mysqli_query($db, $query);
        $customPrice = mysqli_fetch_all($results, MYSQLI_ASSOC);
        if (isset($customPrice[0]['price'])) {
            $pret_nou = $standardPrice + $customPrice[0]['price'];
            $pret_nou = number_format($pret_nou, 2, '.', '');

            return $pret_nou;
        } else {
            return $standardPrice;
        }

    } else {
        return $standardPrice;
    }
}

function getCarCascoBetweenTwoDates($db,$carID, $days, $startDate = null) {
    switch ($days) {
		case ($days >= 1 && $days <= 3):
			$casco = 'casco1';
			break;
		case ($days >= 4 && $days <= 7):
			$casco = 'casco2';
			break;
		case ($days >= 8 && $days <= 15):
			$casco = 'casco3';
			break;
		case ($days >= 16 && $days <= 21):
			$casco = 'casco4';
			break;
		case ($days > 21):
			$casco = 'casco5';
			break;
		default:
			$casco = 'casco1';
	}

    $query = "SELECT * FROM cars WHERE carID = " . $carID;
    $results = mysqli_query($db, $query);
    $row = mysqli_fetch_object($results);

    $standardCasco = $row->$casco;

	return $standardCasco;
}

$query = "SELECT * FROM settings WHERE settingsID = 23";
$results = mysqli_query($db, $query);
$office_start_time_row = mysqli_fetch_object($results);

$office_start_time = $office_start_time_row->set;

$query = "SELECT * FROM settings WHERE settingsID = 24";
$results = mysqli_query($db, $query);
$office_end_time_row = mysqli_fetch_object($results);

$office_end_time = $office_end_time_row->set;

$query = "SELECT * FROM settings WHERE settingsID = 25";
$results = mysqli_query($db, $query);
$office_extra_price_row = mysqli_fetch_object($results);

$office_extra_price = $office_extra_price_row->set;

$query = "SELECT * FROM settings WHERE settingsID = 1";
$results = mysqli_query($db, $query);
$commision_set = mysqli_fetch_object($results);

$commision = $commision_set->set;

$query = "SELECT * FROM settings WHERE settingsID = 2";
$results = mysqli_query($db, $query);
$site_email_set = mysqli_fetch_object($results);

$site_email = $site_email_set->set;

$taxa_livrare = 10;

spl_autoload_register(function($class){
	require_once 'classes/' . $class . '.php';
});
// require_once 'functions/sanitize.php';

//  if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
//  	$hash = Cookie::get(Config::get('remember/cookie_name'));
//  	$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));
//  	if($hashCheck->count()){
//  		$user = new User($hashCheck->first()->user_id);
//  		$user->login();
//  	}
//  }