<?php

	$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

	if ($contentType === "application/json") {
		//Receive the RAW post data.
		$content = trim(file_get_contents("php://input"));

		$decoded = json_decode($content, true);

		//If json_decode failed, the JSON is invalid.
		if(! is_array($decoded)) {
			$asunto_server = 'Formulario de contacto';
			$names = $decoded[0];
			$email = $decoded[1];
			$mensaje = $decoded[2];

			$contact_message .= "Nombres y apellidos: " . $names. "\r\n";
			$contact_message .= "Correo: " . $email. "\r\n";
			$contact_message .= "Mensaje: " . $mensaje. "\r\n";

			$headers .= 'MIME-Version: 1.0' . "\r\n"; 
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n"; 
			$headers .= 'From: CoDev < info@codev.design >' . "\r\n";

			if (mail("info@codev.design", $asunto_server, $contact_message, $headers)) {
				echo 'enviado';
			} else {
				echo 'no enviado';
			}
		} else {
			// Send error back to user.
			echo 'Array no decodificado'
		}
	}
?>