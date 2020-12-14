<?php
	header("Access-Control-Allow-Origin: *");
	$rest_json = file_get_contents("php://input");
	$_POST = json_decode($rest_json, true);
	
	if(!empty($_POST)) {
		require $_SERVER['DOCUMENT_ROOT'] . '/libs/PHPMailer/src/PHPMailer.php';
		require $_SERVER['DOCUMENT_ROOT'] . '/libs/PHPMailer/src/Exception.php';
		
		date_default_timezone_set('Etc/UTC');
		
		$email = new PHPMailer\PHPMailer\PHPMailer();
		
		$Clientdata_Geschlecht = "1";
		$Clientdata_Vorname = "";
		$Clientdata_Nachname = "";
		$Clientdata_Phone = "";
		$Clientdata_Email = "";
		$Clientdata_StrNr = "";
		$Clientdata_PLZ = "";
		$Clientdata_Stadt = "";
		$Clientdata_Rechtsschutzersicherung = [];
		$Clientdata_Schadennummer = "";
		
		if(isset($_POST['Clientdata'])){
			$Clientdata = $_POST['Clientdata'];
			if(isset($Clientdata['Geschlecht'])){
				$Clientdata_Geschlecht = $Clientdata['Geschlecht'];
			}
			if(isset($Clientdata['Vorname'])){
				$Clientdata_Vorname = $Clientdata['Vorname'];
			}
			if(isset($Clientdata['Nachname'])){
				$Clientdata_Nachname = $Clientdata['Nachname'];
			}
			if(isset($Clientdata['Phone'])){
				$Clientdata_Phone = $Clientdata['Phone'];
			}
			if(isset($Clientdata['Email'])){
				$Clientdata_Email = $Clientdata['Email'];
			}
			if(isset($Clientdata['StrNr'])){
				$Clientdata_StrNr = $Clientdata['StrNr'];
			}
			if(isset($Clientdata['PLZ'])){
				$Clientdata_PLZ = $Clientdata['PLZ'];
			}
			if(isset($Clientdata['Stadt'])){
				$Clientdata_Stadt = $Clientdata['Stadt'];
			}
			if(isset($Clientdata['Rechtsschutzersicherung'])){
				$Clientdata_Rechtsschutzersicherung = json_decode($Clientdata['Rechtsschutzersicherung']);
			}
			if(isset($Clientdata['Schadennummer'])){
				$Clientdata_Schadennummer = $Clientdata['Schadennummer'];
			}
		}
		
		$Aktenzeichen = "";
		
		if(isset($_POST['$Aktenzeichen'])){
			$Aktenzeichen = $_POST['$Aktenzeichen'];
		}
		
		$data = array(
			'aktenzeichen' => urlencode($Aktenzeichen),
			'geschlecht' => urlencode($Clientdata_Geschlecht),
			'vorname' => urlencode($Clientdata_Vorname),
			'nachname' => urlencode($Clientdata_Nachname),
			'telefon' => urlencode($Clientdata_Phone),
			'email' => urlencode($Clientdata_Email),
			'strase' => urlencode($Clientdata_StrNr),
			'plz' => urlencode($Clientdata_PLZ),
			'stadt' => urlencode($Clientdata_Stadt),
			'rechtsschutzersicherung' => urlencode($Clientdata['Rechtsschutzersicherung']),
			'schadennummer' => urlencode($Clientdata_Schadennummer)
		);
		
		$link = $_SERVER['SERVER_NAME'] . "/?" . http_build_query($data);
		
		$email->SetFrom("info@brs-ag.de", 'info@brs-ag.de');
		$email->isHTML(true);
		$email->CharSet = 'UTF-8';
		$email->Encoding = 'base64';
		$email->Subject   = $Clientdata_Vorname . " " . $Clientdata_Nachname . " - Telefonanfrage";
		$email->AddAddress( 'Zakablukov777@gmail.com' );

		$msg = "<h1>OWI</h1>";
		$msg .= "<p>Geschlecht: " . $Clientdata_Geschlecht . "</p>";
		$msg .= "<p>Vorname: " . $Clientdata_Vorname . "</p>";
		$msg .= "<p>Nachname: " . $Clientdata_Nachname . "</p>";
		$msg .= "<p>Telefon/Mobil: " . $Clientdata_Phone . "</p>";
		$msg .= "<p>E- Mail: " . $Clientdata_Email . "</p>";
		$msg .= "<p>Straße Nr: " . $Clientdata_StrNr . "</p>";
		$msg .= "<p>PLZ: " . $Clientdata_PLZ . "</p>";
		$msg .= "<p>Stadt: " . $Clientdata_Stadt . "</p>";
		$msg .= "<p>RechtsschutzersicherungName: " . $Clientdata_Rechtsschutzersicherung -> title . "</p>";
		$msg .= "<p>Rechtsschutzersicherung: person:" . $Clientdata_Rechtsschutzersicherung -> value . "</p>";
		$msg .= "<p>Schadennummer: " . $Clientdata_Schadennummer . "</p>";
		$msg .= "<p>Aktenzeichen: " . $Aktenzeichen . "</p>";
		$msg .= "<p>Link: <a href='" . $link . "' target='_blank'>" . $link . "</a></p>";
		
		
		$email->Body = $msg;
		
		if(!$email->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $email->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}
	} else {
		http_response_code(403);
		echo "There was a problem with your submission, please try again.";
	}
