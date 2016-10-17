<?php

// Include config.php
include_once('config-vt.php');
include_once('mail.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	// Get data
	$json = 'php://input';
	//read the json file contents
	$jsondata = file_get_contents($json);
	//convert json object to php associative array
	$data = json_decode($jsondata, true);

	$observer_name = isset($data['observer_name']) ? $data['observer_name'] : "";	
	$observer_tel = isset($data['observer_tel']) ? $data['observer_tel'] : "";
	$observer_email = isset($data['observer_email']) ? $data['observer_email'] : "";
	$observation_date = isset($data['observation_date']) ? $data['observation_date'] : "";
	$observation_year = isset($data['observation_year']) ? $data['observation_year'] : "";
	$observation_month = isset($data['observation_month']) ? $data['observation_month'] : "";
	$observation_day = isset($data['observation_day']) ? $data['observation_day'] : "";
	$observation_location = isset($data['observation_location']) ? $data['observation_location'] : "";
	$observation_localisation = isset($data['observation_localisation']) ? $data['observation_localisation'] : "";
	$observation_region = isset($data['observation_region']) ? $data['observation_region'] : "";
	$observation_country = isset($data['observation_country']) ? $data['observation_country'] : "";
	$observation_country_code = isset($data['observation_country_code']) ? $data['observation_country_code'] : "";
	$observation_latitude = isset($data['observation_latitude']) ? $data['observation_latitude'] : "";
	$observation_longitude = isset($data['observation_longitude']) ? $data['observation_longitude'] : "";
	$observation_number = isset($data['observation_number']) ? $data['observation_number'] : "";
	$observation_culled = isset($data['observation_culled']) ? $data['observation_culled'] : "";
	$observation_state = isset($data['observation_state']) ? $data['observation_state'] : "";
	$counting_method_timed_swim = isset($data['counting_method_timed_swim']) ? $data['counting_method_timed_swim'] : "";
	$counting_method_distance_swim = isset($data['counting_method_distance_swim']) ? $data['counting_method_distance_swim'] : "";
	$counting_method_other = isset($data['counting_method_other']) ? $data['counting_method_other'] : "";
	$depth_range = isset($data['depth_range']) ? $data['depth_range'] : "";
	$observation_method = isset($data['observation_method']) ? $data['observation_method'] : "";
	$remarks = isset($data['remarks']) ? $data['remarks'] : "";
	$localisation = isset($observation_latitude) && isset($observation_longitude) ? "GeomFromText('POINT(".$observation_latitude." ".$observation_longitude.")')" : "";
	$admin_validation = isset($data['admin_validation']) ? $data['admin_validation'] : "";
	

	$stmt = $mysqli->prepare("INSERT INTO oreanetvt.cot_cot_admin(id, observer_name, observer_tel, observer_email, observation_date, observation_year, observation_month, observation_day, observation_location, observation_localisation, observation_region, observation_country, observation_country_code, observation_latitude, observation_longitude, observation_number, observation_culled, observation_state, counting_method_timed_swim, counting_method_distance_swim, counting_method_other, depth_range, observation_method, remarks, localisation, admin_validation) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, $localisation, ?)");

	if(!$stmt){
		$json = array("status" => 0, "msg" => "non prepared statement");
	}
	
	$stmt->bind_param("ssssiiissssssssissssssss", $observer_name,$observer_tel,$observer_email,$observation_date,$observation_year, $observation_month, $observation_day,$observation_location,$observation_localisation,$observation_region, $observation_country, $observation_country_code, $observation_latitude, $observation_longitude, $observation_number, $observation_culled, $observation_state, $counting_method_timed_swim, $counting_method_distance_swim, $counting_method_other, $depth_range, $observation_method, $remarks, $admin_validation);


	$qur = $stmt->execute();

	if($qur){
		$id = $mysqli->insert_id;
		$sent = sendMail($id, $data, $email_admin, $email_from);
		$json = array("status" => 1, "msg" => $sent);
	}else{
		$json = array("status" => 0, "msg" => $stmt->error);
		}
	$stmt->close();
}else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
}

$mysqli->close();

/* Output header */
	/*header('Content-type: application/json');*/
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
	echo json_encode($json);
?>
