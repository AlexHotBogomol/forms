<?php
	header("Access-Control-Allow-Origin: *");
	$rest_json = file_get_contents("php://input");
	$_POST = json_decode($rest_json, true);
	
	if(!empty($_POST)) {
		require $_SERVER['DOCUMENT_ROOT'] . '/libs/PHPMailer/src/PHPMailer.php';
		require $_SERVER['DOCUMENT_ROOT'] . '/libs/PHPMailer/src/Exception.php';
		require $_SERVER['DOCUMENT_ROOT'] . '/libs/PHPMailer/src/SMTP.php';
		
		date_default_timezone_set('Etc/UTC');
		
		$id = $_POST['id'];
		$uploadsDir = $_SERVER['SERVER_NAME'] . '/uploads/' . $id . '/';
		$uploadsDir2 = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $id . '/';
		
		$email = new PHPMailer\PHPMailer\PHPMailer();
		
		$Clientdata_Geschlecht = "";
		$Clientdata_Vorname = "";
		$Clientdata_Nachname = "";
		$Clientdata_Phone = "";
		$Clientdata_Email = "";
		$Clientdata_StrNr = "";
		$Clientdata_PLZ = "";
		$Clientdata_Stadt = "";
		$Clientdata_Rechtsschutzersicherung = "";
		$Clientdata_Schadennummer = "";
		$Clientdata_Vorwurf = "";
		
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
				$Clientdata_Rechtsschutzersicherung = $Clientdata['Rechtsschutzersicherung'];
			}
			if(isset($Clientdata['Schadennummer'])){
				$Clientdata_Schadennummer = $Clientdata['Schadennummer'];
			}
			if(isset($Clientdata['Vorwurf'])){
				$Clientdata_Vorwurf = $Clientdata['Vorwurf'];
			}
		}
		
		$Buss_Aktenzeichen = "";
		$Buss_Datum = "";
		$Buss_Behorde = "";
		$Buss_Behorde_Custom = "";
		$Buss_Upload = [];
		$Buss_Anhorungsbogen = [];
		$Buss_Zeugenfragebogen = [];
		
		if(isset($_POST['Buss'])){
			$Buss = $_POST['Buss'];
			if(isset($Buss['Aktenzeichen'])){
				$Buss_Aktenzeichen = $Buss['Aktenzeichen'];
			}
			if(isset($Buss['Datum'])){
				$Buss_Datum = $Buss['Datum'];
			}
			if(isset($Buss['Behorde'])){
				$Buss_Behorde = $Buss['Behorde'];
			}
			if(isset($Buss['Behorde'])){
				$Buss_Behorde_Custom = $Buss['BehordeCustom'];
			}
			if(isset($Buss['Upload'])){
				$doks = $Buss['Upload']['fileList'];
				foreach ($doks as $dok){
					$Buss_Upload[] = "<a href='" . $uploadsDir . $dok['name'] . "' target='_blank'>" . $dok['name'] . "</a>";
					$email->addAttachment($uploadsDir2 . $dok['name'], $dok['name']);
				}
			}
			if(isset($Buss['Anhorungsbogen'])){
				$doks = $Buss['Anhorungsbogen']['fileList'];
				foreach ($doks as $dok){
					$Buss_Anhorungsbogen[] = "<a href='" . $uploadsDir . $dok['name'] . "' target='_blank'>" . $dok['name'] . "</a>";
					$email->addAttachment($uploadsDir2 . $dok['name'], $dok['name']);
				}
			}
			if(isset($Buss['Zeugenfragebogen'])){
				$doks = $Buss['Zeugenfragebogen']['fileList'];
				foreach ($doks as $dok){
					$Buss_Zeugenfragebogen[] = "<a href='" . $uploadsDir . $dok['name'] . "' target='_blank'>" . $dok['name'] . "</a>";
					$email->addAttachment($uploadsDir2 . $dok['name'], $dok['name']);
				}
			}
		}
		
		$Fahrverbot_Frage = "";
		$Fahrverbot_Urlaub = "";
		$Fahrverbot_Gruende = "";
		$Fahrverbot_Gruende_Auftragsfristen = "false";
		$Fahrverbot_Gruende_Wirtschaftliche = "false";
		$Fahrverbot_Gruende_Sonstiges = "false";
		$Fahrverbot_Sonstige = "";
		$Fahrverbot_Urlaubswochen = "";
		$Fahrverbot_Urlaubstage = "";
		
		if(isset($_POST['Fahrverbot'])){
			$Fahrverbot = $_POST['Fahrverbot'];
			if(isset($Fahrverbot['Frage'])){
				$Fahrverbot_Frage = $Fahrverbot['Frage'];
			}
			if(isset($Fahrverbot['Urlaub'])){
				$Fahrverbot_Urlaub = $Fahrverbot['Urlaub'];
			}
			if(isset($Fahrverbot['Gruende'])){
				$Fahrverbot_Gruende = $Fahrverbot['Gruende'];
				if($Fahrverbot_Gruende === "Auftragsfristen"){
					$Fahrverbot_Gruende_Auftragsfristen = "true";
				}
				if($Fahrverbot_Gruende === "Wirtschaftliche"){
					$Fahrverbot_Gruende_Wirtschaftliche = "true";
				}
				if($Fahrverbot_Gruende === "Sonstiges"){
					$Fahrverbot_Gruende_Sonstiges = "true";
				}
			}
			if(isset($Fahrverbot['Sonstige'])){
				$Fahrverbot_Sonstige = $Fahrverbot['Sonstige'];
			}
			if(isset($Fahrverbot['Urlaubswochen'])){
				$Fahrverbot_Urlaubswochen = $Fahrverbot['Urlaubswochen'];
			}
			if(isset($Fahrverbot['Urlaubstage'])){
				$Fahrverbot_Urlaubstage = $Fahrverbot['Urlaubstage'];
			}
		}
		
		$Beschaftigung_Frage = "";
		$Beschaftigung_Selbststandig_Gewerbeart = "";
		$Beschaftigung_Selbststandig_StrNr = "";
		$Beschaftigung_Selbststandig_PLZ = "";
		$Beschaftigung_Selbststandig_Ort = "";
		$Beschaftigung_Angestellt_Berufsbezeichnung = "";
		$Beschaftigung_Angestellt_Arbeitgeber = "";
		$Beschaftigung_Angestellt_StrNr = "";
		$Beschaftigung_Angestellt_PLZ = "";
		$Beschaftigung_Angestellt_Ort = "";
		$Beschaftigung_Sonstiges_Detail = "";
		
		if(isset($_POST['Beschaftigung'])){
			$Beschaftigung = $_POST['Beschaftigung'];
			if(isset($Beschaftigung['Frage'])){
				$Beschaftigung_Frage = $Beschaftigung['Frage'];
			}
			if(isset($Beschaftigung['Selbststandig'])){
				$Beschaftigung_Selbststandig = $Beschaftigung['Selbststandig'];
				if(isset($Beschaftigung_Selbststandig['Gewerbeart'])){
					$Beschaftigung_Selbststandig_Gewerbeart = $Beschaftigung_Selbststandig['Gewerbeart'];
				}
				if(isset($Beschaftigung_Selbststandig['StrNr'])){
					$Beschaftigung_Selbststandig_StrNr = $Beschaftigung_Selbststandig['StrNr'];
				}
				if(isset($Beschaftigung_Selbststandig['PLZ'])){
					$Beschaftigung_Selbststandig_PLZ = $Beschaftigung_Selbststandig['PLZ'];
				}
				if(isset($Beschaftigung_Selbststandig['Ort'])){
					$Beschaftigung_Selbststandig_Ort = $Beschaftigung_Selbststandig['Ort'];
				}
			}
			if(isset($Beschaftigung['Angestellt'])){
				$Beschaftigung_Angestellt = $Beschaftigung['Angestellt'];
				if(isset($Beschaftigung_Angestellt['Berufsbezeichnung'])){
					$Beschaftigung_Angestellt_Berufsbezeichnung = $Beschaftigung_Angestellt['Berufsbezeichnung'];
				}
				if(isset($Beschaftigung_Angestellt['Arbeitgeber'])){
					$Beschaftigung_Angestellt_Arbeitgeber = $Beschaftigung_Angestellt['Arbeitgeber'];
				}
				if(isset($Beschaftigung_Angestellt['StrNr'])){
					$Beschaftigung_Angestellt_StrNr = $Beschaftigung_Angestellt['StrNr'];
				}
				if(isset($Beschaftigung_Angestellt['PLZ'])){
					$Beschaftigung_Angestellt_PLZ = $Beschaftigung_Angestellt['PLZ'];
				}
				if(isset($Beschaftigung_Angestellt['Ort'])){
					$Beschaftigung_Angestellt_Ort = $Beschaftigung_Angestellt['Ort'];
				}
			}
			if(isset($Beschaftigung['Sonstiges'])){
				$Beschaftigung_Sonstiges = $Beschaftigung['Sonstiges'];
				if(isset($Beschaftigung_Sonstiges['Detail'])){
					$Beschaftigung_Sonstiges_Detail = $Beschaftigung_Sonstiges['Detail'];
				}
			}
		}
		
		$Ausland_Frage = "";
		$Ausland_Regional = "false";
		$Ausland_Bundeswelt = "false";
		$Ausland_Ausland = "false";
		
		if(isset($_POST['Ausland'])){
			$Ausland = $_POST['Ausland'];
			if(isset($Ausland['Frage'])){
				$Ausland_Frage = $Ausland['Frage'];
			}
			if(isset($Ausland['ChechboxGroup'])){
				$Ausland_ChechboxGroup = $Ausland['ChechboxGroup'];
				if(in_array("Regional", $Ausland_ChechboxGroup)){
					$Ausland_Regional = "true";
				}
				if(in_array("Bundeswelt", $Ausland_ChechboxGroup)){
					$Ausland_Bundeswelt = "true";
				}
				if(in_array("Ausland", $Ausland_ChechboxGroup)){
					$Ausland_Ausland = "true";
				}
			}
		}
		
		$Berufsweg = "";
		if(isset($_POST['Berufsweg'])){
			$Berufsweg = $_POST['Berufsweg'];
		}
		
		$Taetigkeit_ChechboxGroup_Projektbetreuung = "false";
		$Taetigkeit_ChechboxGroup_Kundenakquise = "false";
		$Taetigkeit_ChechboxGroup_Sonstige = "false";
		$Taetigkeit_Sonstige = "";
		
		if(isset($_POST['Taetigkeit'])){
			$Taetigkeit = $_POST['Taetigkeit'];
			if(isset($Taetigkeit['ChechboxGroup'])){
				$Taetigkeit_ChechboxGroup = $Taetigkeit['ChechboxGroup'];
				if(in_array("Projektbetreuung / Kundenbetreuung", $Taetigkeit_ChechboxGroup)){
					$Taetigkeit_ChechboxGroup_Projektbetreuung = "true";
				}
				if(in_array("Kundenakquise", $Taetigkeit_ChechboxGroup)){
					$Taetigkeit_ChechboxGroup_Kundenakquise = "true";
				}
				if(in_array("Sonstige", $Taetigkeit_ChechboxGroup)){
					$Taetigkeit_ChechboxGroup_Sonstige = "true";
				}
			}
			if(isset($Taetigkeit['Sonstige'])){
				$Taetigkeit_Sonstige = $Taetigkeit['Sonstige'];
			}
		}
		
		$Fahrleistung = "";
		
		if(isset($_POST['Fahrleistung'])){
			$Fahrleistung = $_POST['Fahrleistung'];
		}
		
		$Mitfahrgelegenheit_Frage = "";
		$Mitfahrgelegenheit_Anbindung = "false";
		$Mitfahrgelegenheit_Arbeitsmaterialen = "false";
		$Mitfahrgelegenheit_Berufskraftfahrer = "false";
		$Mitfahrgelegenheit_Kundenstamm = "false";
		$Mitfahrgelegenheit_Terminabsprachen = "false";
		$Mitfahrgelegenheit_Berufsausubung = "false";
		
		if(isset($_POST['Mitfahrgelegenheit'])){
			$Mitfahrgelegenheit = $_POST['Mitfahrgelegenheit'];
			if(isset($Mitfahrgelegenheit['Frage'])){
				$Mitfahrgelegenheit_Frage = $Mitfahrgelegenheit['Frage'];
			}
			if(isset($Mitfahrgelegenheit['Select'])){
				$Mitfahrgelegenheit_Select = $Mitfahrgelegenheit['Select'];
				if(in_array("Anbindung", $Mitfahrgelegenheit_Select)){
					$Mitfahrgelegenheit_Anbindung = "true";
				}
				if(in_array("Arbeitsmaterialen", $Mitfahrgelegenheit_Select)){
					$Mitfahrgelegenheit_Arbeitsmaterialen = "true";
				}
				if(in_array("Berufskraftfahrer", $Mitfahrgelegenheit_Select)){
					$Mitfahrgelegenheit_Berufskraftfahrer = "true";
				}
				if(in_array("Kundenstamm", $Mitfahrgelegenheit_Select)){
					$Mitfahrgelegenheit_Kundenstamm = "true";
				}
				if(in_array("Terminabsprachen", $Mitfahrgelegenheit_Select)){
					$Mitfahrgelegenheit_Terminabsprachen = "true";
				}
				if(in_array("Berufsausubung", $Mitfahrgelegenheit_Select)){
					$Mitfahrgelegenheit_Berufsausubung = "true";
				}
			}
		}
		
		$Arbeitgeber = "Nein";
		
		if(isset($_POST['Arbeitgeber'])){
			$Arbeitgeber = $_POST['Arbeitgeber'];
		}
		
		$Freizeit = "";
		
		if(isset($_POST['Freizeit'])){
			$Freizeit = $_POST['Freizeit'];
		}
		
		$Voreintragung = "";
		
		if(isset($_POST['Voreintragung'])){
			$Voreintragung = $_POST['Voreintragung'];
		}
		
		$Informationen = "Nein";
		
		if(isset($_POST['Informationen'])){
			$Informationen = $_POST['Informationen'];
		}
		
		$Weitere_Dokumente = [];
		
		if(isset($_POST['Weitere_Dokumente'])){
			$doks = $_POST['Weitere_Dokumente']['fileList'];
			foreach ($doks as $dok){
				$Weitere_Dokumente[] = "<a href='" . $uploadsDir . $dok['name'] . "' target='_blank'>" . $dok['name'] . "</a>";
				$email->addAttachment($uploadsDir2 . $dok['name'], $dok['name']);
			}
		}
		$email->isSMTP();
		$email->SMTPAuth = true;
		$email->SMTPDebug = 0;
		
		$email->Host = 'ssl://smtp.ionos.de';
		$email->Port = 465;
		$email->Username = 'mandat@brs-ag.de';
		$email->Password = 'ztR9.81-sw21A';
		
		// $email->Host = 'ssl://smtp.ionos.de';
		// $email->Port = 465;
		// $email->Username = 'mandat@hallounfall.de';
		// $email->Password = '987LawNow!*31sva#123';
		
		$email->SetFrom("info@brs-ag.de", 'info@brs-ag.de');
		$email->isHTML(true);
		$email->CharSet = 'UTF-8';
		$email->Encoding = 'base64';
		$email->Subject   = 'Owi Form';
		$email->AddAddress( 'anselm.appel@42dbs.de' );
		$email->AddAddress( 'mandat@brs-ag.de' );
		$email->AddAddress( 'Zakablukov777@gmail.com' );
		$email->AddAddress( 'info@brs-ag.de' );
		
		$msg = "<h1>OWI</h1>";
		$msg .= "<p>Geschlecht: " . $Clientdata_Geschlecht . "</p>";
		$msg .= "<p>Vorname: " . $Clientdata_Vorname . "</p>";
		$msg .= "<p>Nachname: " . $Clientdata_Nachname . "</p>";
		$msg .= "<p>Telefon/Mobil: " . $Clientdata_Phone . "</p>";
		$msg .= "<p>E- Mail: " . $Clientdata_Email . "</p>";
		$msg .= "<p>Straße Nr: " . $Clientdata_StrNr . "</p>";
		$msg .= "<p>PLZ: " . $Clientdata_PLZ . "</p>";
		$msg .= "<p>Stadt: " . $Clientdata_Stadt . "</p>";
		$msg .= "<p>Rechtsschutzersicherung: " . $Clientdata_Rechtsschutzersicherung . "</p>";
		$msg .= "<p>Schadennummer: " . $Clientdata_Schadennummer . "</p>";
		$msg .= "<p>Vorwurf: " . $Clientdata_Vorwurf . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<p>Aktenzeichen Bussgeldstelle: " . $Buss_Aktenzeichen . "</p>";
		$msg .= "<p>Datum Bußgeldbescheid: " . date("Y-m-d", strtotime($Buss_Datum)) . " 00:00:00</p>";
		$msg .= "<p>Ausstellende Behoerde: " . "person:" . $Buss_Behorde . "</p>";
		$msg .= "<p>Ausstellende Behoerde (custom): " . "person:" . $Buss_Behorde_Custom . "</p>";
		$msg .= "<p>Upload Bußgeldbescheid: " . join("<br/>", $Buss_Upload) . "</p>";
		$msg .= "<p>Anhörungsbogen: " . join("<br/>", $Buss_Anhorungsbogen) . "</p>";
		$msg .= "<p>Zeugenfragebogen: " . join("<br/>", $Buss_Zeugenfragebogen) . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<p>Fahrverbot: " . $Fahrverbot_Frage . "</p>";
		$msg .= "<p>Beschäftigungsverhältnis: " . $Beschaftigung_Frage . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<p>Berufsbezeichnung: " . $Beschaftigung_Angestellt_Berufsbezeichnung . "</p>";
		$msg .= "<p>Arbeitgeber: " . $Beschaftigung_Angestellt_Arbeitgeber . "</p>";
		$msg .= "<p>Straße Nr Arbeitgeber: " . $Beschaftigung_Angestellt_StrNr . "</p>";
		$msg .= "<p>PLZ Arbeitgeber: " . $Beschaftigung_Angestellt_PLZ . "</p>";
		$msg .= "<p>Ort Arbeitgeber: " . $Beschaftigung_Angestellt_Ort . "</p>";
		$msg .= "<p>Gewerbeart: " . $Beschaftigung_Selbststandig_Gewerbeart . "</p>";
		$msg .= "<p>Straße Nr Gewerbe: " . $Beschaftigung_Selbststandig_StrNr . "</p>";
		$msg .= "<p>PLZ Gewerbe: " . $Beschaftigung_Selbststandig_PLZ . "</p>";
		$msg .= "<p>Ort Gewerbe: " . $Beschaftigung_Selbststandig_Ort . "</p>";
		$msg .= "<p>Sonstiges Detail: " . $Beschaftigung_Sonstiges_Detail . "</p>";
		$msg .= "<p>Unterwegs: " . $Ausland_Frage . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<h2>Ausland</h2>";
		$msg .= "<p>Regional: " . $Ausland_Regional . "</p>";
		$msg .= "<p>Bundeswelt: " . $Ausland_Bundeswelt . "</p>";
		$msg .= "<p>Ausland: " . $Ausland_Ausland . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<p>Berufsweg: " . $Berufsweg . "</p>";
		$msg .= "<p>Projektbetreuung: " . $Taetigkeit_ChechboxGroup_Projektbetreuung . "</p>";
		$msg .= "<p>Kundenakquise: " . $Taetigkeit_ChechboxGroup_Kundenakquise . "</p>";
		$msg .= "<p>Sonstiges: " . $Taetigkeit_ChechboxGroup_Sonstige . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<p>Sonstige: " . $Taetigkeit_Sonstige . "</p>";
		$msg .= "<p>Fahrleistung: " . $Fahrleistung . "</p>";
		$msg .= "<p>Mitfahrgelegenheit: " . $Mitfahrgelegenheit_Frage . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<p>Anbindung: " . $Mitfahrgelegenheit_Anbindung . "</p>";
		$msg .= "<p>Arbeitsmaterialen: " . $Mitfahrgelegenheit_Arbeitsmaterialen . "</p>";
		$msg .= "<p>Berufskraftfahrer: " . $Mitfahrgelegenheit_Berufskraftfahrer . "</p>";
		$msg .= "<p>Kundenstamm: " . $Mitfahrgelegenheit_Kundenstamm . "</p>";
		$msg .= "<p>Terminabsprachen: " . $Mitfahrgelegenheit_Terminabsprachen . "</p>";
		$msg .= "<p>Berufsausübung: " . $Mitfahrgelegenheit_Berufsausubung . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<p>Arbeitgeber2: " . $Arbeitgeber . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<p>Fahrverbot Urlaub: " . $Fahrverbot_Urlaub . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<h2>Info</h2>";
		$msg .= "<p>Urlaubswochen: " . $Fahrverbot_Urlaubswochen . "</p>";
		$msg .= "<p>Urlaubstage: " . $Fahrverbot_Urlaubstage . "</p>";
		$msg .= "<p>Gruende: " . $Fahrverbot_Gruende . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<p>Auftragsfristen: " . $Fahrverbot_Gruende_Auftragsfristen . "</p>";
		$msg .= "<p>Wirtschaftliche: " . $Fahrverbot_Gruende_Wirtschaftliche . "</p>";
		$msg .= "<p>Sonstiges: " . $Fahrverbot_Gruende_Sonstiges . "</p>";
		$msg .= "<p>Sonstiges2: " . $Fahrverbot_Sonstige . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<p>Freizeit: " . $Freizeit . "</p>";
		$msg .= "<p>Voreintragung: " . $Voreintragung . "</p>";
		
		$msg .= "<br/>";
		
		$msg .= "<p>Informationen: " . $Informationen . "</p>";
		$msg .= "<p>Weitere Dokumente: " . join("<br/>", $Weitere_Dokumente) . "</p>";
		
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
