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

		$body   = "<h4>Un nouveau report d'acanthasters a été effectué:</h4>"
				."<div>Observateur: ".$data['observer_name']."</div>"
				.($data['observer_tel']!== ''?"<div>Téléphone: ".$data['observer_tel']."</div>":"")
				.($data['observer_email']!== ''?"<div>Mail: ".$data['observer_email']."</div>":"")
				."<div>Date de l'observation: ".$data['observation_date']."</div>"
				."<div>Détails sur la position de l'observation: ".$data['observation_location']."</div>"
				."<div>Position: ".$data['observation_localisation']."</div>"
				.($data['observation_region']!== ''?"<div>Région: ".$data['observation_region']."</div>":"")
				.($data['observation_country']!== ''?"<div>Pays: ".$data['observation_country']."</div>":"")
				.($data['observation_number']!== ''?"<div>Nombre d'acanthsters: ".$data['observation_number']."</div>":"")
				.($data['observation_culled']!== ''?"<div>Nombre d'acanthsters nettoyés: ".$data['observation_culled']."</div>":"")
				."<div>Méthode d'observation: ".implode( ',', $data['observation_method'])."</div>"
				.($data['depth_range']!== ''?"<div>Tranche de profondeur: ".$data['depth_range']."</div>":"")
				.($data['counting_method_timed_swim']!== ''&&$data['counting_method_distance_swim']!== ''&&$data['counting_method_other']!== ''?"<div>Méthode(s) de comptage: </div>":"")
				.($data['counting_method_timed_swim']!== ''?"<div>temps de nage: ".$data['counting_method_timed_swim']."</div>":"")
				.($data['counting_method_distance_swim']!== ''?"<div>distance parcourue: ".$data['counting_method_distance_swim']."</div>":"")
				.($data['counting_method_other']!== ''?"<div>autre: ".$data['counting_method_other']."</div>":"")
				.($data['remarks']!== ''?"<div>Remarques: ".$data['remarks']."</div>":"")
				."<div>Observation validation: ".$valid." </div>";

		

		$subject = "Oreanet NC: nouveau report de présence d'acanthasters ".$id;
		$altBody = strip_tags( $body);

		$send = mail($to,$subject,$body,$headers);

		if ( $send !== true ) {
		    return 'Error sending email: ' . $send;
		} else {
		    return 'Mail sent';
		}
	}
?>
