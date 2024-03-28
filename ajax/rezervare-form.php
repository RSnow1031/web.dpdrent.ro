<?php 
    require_once '../core/init.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $carID = $_POST['carID'];

        $query = "SELECT * FROM cars WHERE carID = " . $carID;
        $results = mysqli_query($db, $query);
        $car_inf = mysqli_fetch_object($results);
        $carName = $car_inf->carName; //car name
        $poza    = $car_inf->carPhoto;

        $extrasList = array();
        if (isset($_POST['extra_input']))
        {
            foreach ($_POST['extra_input']  as $exId) {
                $query = "SELECT * FROM extras WHERE extraID = " . $exId;
                $results = mysqli_query($db, $query);
                $extra_inf = mysqli_fetch_object($results);
                array_push($extrasList, $extra_inf->extraTitle);
            }
        }

        $extras = implode(';', $extrasList); //extra list

        $pick_up_location = $_POST['locatie_preluare'];
        $drop_off_location = $_POST['locatie_returnare'];
        $pick_up_date = $_POST['data_preluare'] . ' ' . $_POST['pickup_time'];
        $drop_off_date = $_POST['data_returnare'] . ' ' . $_POST['return_time'];

        $flight_no = ''; //$this->_getParam('numar_zbor');
        $invoice = ''; //$this->_getParam('date_factura');

        //buyer
        $title = 'Mr.';
        $fname = $_POST['nume'];
        $lname = ''; //$this->_getParam('prenume');
        $address = $_POST['adresa'];
        $city = $_POST['oras'];
        $county = $_POST['judet'];
        $country = $_POST['tara'];
        $email = $_POST['email'];
        $phone = $_POST['telefon'];
        $plata = $_POST['plata'];
        $message = $_POST['observatii'];

        /*
        * Detalii Facturare
        */
        $vatCode   = $_POST['cui'];
        $fact_nume  = $_POST['denumire'];
        $factura_date_sofer = (int)$_POST['factura_date_sofer'];
        if ($factura_date_sofer == 1 && $vatCode == '' && $fact_nume == '') {
            $fact_nume = '';
            $fact_tara = '';
            $fact_judet = '';
            $fact_oras = '';
            $fact_adresa = '';
            $isTaxPayer = 0; //PF
            $vatCode = '';
            $regCom = '';
        } else {
            #check if PF or PJ
            if ($vatCode != '' && $fact_nume != '') {
                #este PJ
                $fact_tara = $_POST['pj_tara'];
                $fact_judet = $_POST['pj_judet'];
                $fact_oras = $_POST['pj_oras'];
                $fact_adresa = $_POST['pj_adresa'];
                $isTaxPayer = 1; //PJ
                $factura_date_sofer = 0;
                $regCom = $_POST['regCom'];
            } else {
                //este PF
                $fact_nume   = $_POST['pf_nume'];
                $fact_tara   = $_POST['pf_tara'];
                $fact_judet  = $_POST['pf_judet'];
                $fact_oras   = $_POST['pf_oras'];
                $fact_adresa = $_POST['pf_adresa'];
                $isTaxPayer  = 0; //PF
                $factura_date_sofer = 0;
                $regCom = '';
            }
        }
        //end detalii facturare

        $taxa_livrare = $_POST['taxa_livrare'];
        $d = explode(' x ', $_POST['rent']);
        $total_days = $d[0];
        $price_per_day = $d[1];
        $drop_off_price = $_POST['drop_off_price'];
        $total_price = $_POST['total'];
        $casco = $_POST['casco_total'];
        $depozit = $_POST['depozit'];

        $params = array(
            'carID' => $carID,
            'carName' => $carName,
            'poza' => $poza,
            'extras' => $extras,
            'pick_up_location' => $pick_up_location,
            'drop_off_location' => $drop_off_location,
            'pick_up_date' => $pick_up_date,
            'drop_off_date' => $drop_off_date,
            'flight_no' => $flight_no,
            'title' => $title,
            'fname' => $fname,
            'lname' => $lname,
            'address' => $address,
            'city' => $city,
            'county' => $county,
            'country' => $country,
            'email' => $email,
            'phone' => $phone,
            'invoice' => $invoice,
            'message' => $message,
            'taxa_livrare' => $taxa_livrare,
            'total_days' => $total_days,
            'price_per_day' => $price_per_day,
            'drop_off_price' => $drop_off_price,
            'total_price' => $total_price,
            'factura_date_sofer' => $factura_date_sofer,
            'vatCode' => $vatCode,
            'isTaxPayer' => $isTaxPayer,
            'fact_nume' => $fact_nume,
            'fact_tara' => $fact_tara,
            'fact_judet' => $fact_judet,
            'fact_oras' => $fact_oras,
            'fact_adresa' => $fact_adresa,
            'regCom' => $regCom,
            'plata' => $plata,
            'deposit' => $depozit,
            'casco' => $casco,
        );



        $params = $_REQUEST;
        $params['data_preluare'] = $pick_up_date;
        $params['data_returnare'] = $drop_off_date;

        $cURL = curl_init("https://app.dpdrent.ro/rezervare/process-booking");
        curl_setopt($cURL, CURLOPT_POST, true);
        curl_setopt($cURL, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($cURL);
        curl_close($cURL);


        if ($response)
        {
            header("Location: ../multumim.php");
            exit();
        }

        // if(count($params)){
        //     $fields = $params;
        //     $table = 'orders';
		// 	$keys = array_keys($fields);
		// 	$values = '';
		// 	$x = 1;
		// 	foreach($fields as $field){
		// 		if($x < count($fields)) {
        //             $values .= "'" . $field . "',";
		// 		}
        //         else  $values .= "'" . $field . "'";

		// 		$x++;
		// 	}
		// 	$sql = "INSERT INTO {$table} (`". implode('`,`', $keys) ."`) VALUES ({$values})";
		// 	$insert_rs = mysqli_query($db, $sql);
		// }
        // echo $insert_rs;
    }
   
?>