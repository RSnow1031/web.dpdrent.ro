<?php
class Redirect {
	public static function to($location = null){
		if($location){
			if(is_numeric($location)){
				switch($location){
					case 404:
						header('http/1.0 404 Not found');
						include 'includes/errors/404.php';
						exit();
					break;
				}
			}
			header('location: ' . $location);
			exit();
		}
	}
}