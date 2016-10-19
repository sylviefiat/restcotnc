<?php

function sendMail($id, $data,$email_admin,$email_from)
	{
		
		$headers = "From: " . strip_tags($email_from) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($email_from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		// Set the recipient
		$to = $email_admin;	

		$valid = "<a href='http://oreanet.ird.nc/index.php/administrer-les-observations/".$id."?view=cot_admin'>Aller sur le site pour valider</a>";

		$body   = "<h4>A new cot observation has been reported:</h4>"
				."<div>Observer: ".$data['observer_name']."</div>"
				.($data['observer_tel']!== ''?"<div>Phone: ".$data['observer_tel']."</div>":"")
				.($data['observer_email']!== ''?"<div>Email: ".$data['observer_email']."</div>":"")
				."<div>Date: ".$data['observation_date']."</div>"
				."<div>Location details: ".$data['observation_location']."</div>"
				."<div>Location: ".$data['observation_localisation']."</div>"
				.($data['observation_region']!== ''?"<div>Region: ".$data['observation_region']."</div>":"")
				.($data['observation_country']!== ''?"<div>Country: ".$data['observation_country']."</div>":"")
				.($data['observation_number']!== ''?"<div>Acanthasters count: ".$data['observation_number']."</div>":"")
				.($data['observation_culled']!== ''?"<div>Acanthaster cleaned up: ".$data['observation_culled']."</div>":"")
				."<div>Observation method: ".implode( ',', $data['observation_method'])."</div>"
				.($data['depth_range']!== ''?"<div>Depth: ".$data['depth_range']."</div>":"")
				.($data['counting_method_timed_swim']!== ''&&$data['counting_method_distance_swim']!== ''&&$data['counting_method_other']!== ''?"<div>Counting methods: </div>":"")
				.($data['counting_method_timed_swim']!== ''?"<div>Swimming time: ".$data['counting_method_timed_swim']."</div>":"")
				.($data['counting_method_distance_swim']!== ''?"<div>Distance swim: ".$data['counting_method_distance_swim']."</div>":"")
				.($data['counting_method_other']!== ''?"<div>other: ".$data['counting_method_other']."</div>":"")
				.($data['remarks']!== ''?"<div>Remarks: ".$data['remarks']."</div>":"")
				."<div>Validation: ".$valid." </div>";

		

		$subject = "Oreanet VT: new cot observation ".$id;
		$altBody = strip_tags( $body);

		$send = mail($to,$subject,$body,$headers);

		if ( $send !== true ) {
		    return 'Error sending email: ' . $send;
		} else {
		    return 'Mail sent';
		}
	}
?>
