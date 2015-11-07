<?php
	// Check to make sure that all the required variables were specified, and if not display an error message.
	if (isset($_POST["name"])) {
		$name = $_POST["name"];

   		// Check Name
		if (strlen($name) < 2) {
			$error["name"] = "Error: Malformed field \"Name\".\nPlease enter your name.";
		}

		if (!$error and isset($_POST["emailaddr"])) {
			$emailaddr = $_POST["emailaddr"];

			// Check Email
			if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $emailaddr)) {
				$error["email"] = "Error: Malformed field \"Email\".\n  Please enter a valid email address.";
			}

			if (!$error and isset($_POST["msg"])) {
				$msg = $_POST["msg"];
				// Check message.
				if (strlen($contact_message) < 15) {
					$error["msg"] = "Erorr: Malformed field \"Message\".\nPlease enter your message.  It should have at least 15 characters.";
				}
			}
			else {
				$error["msg"] = "Error: Must specify required field \"Message\".";
			}
		}
		else {
			$erorr["email"] = "Error: Must specify required field \"Email\"";
		}
	}
	else {
		$error["name"] = "Error: Must specify required field \"Name\"";
	}

	if (!$error) {
		// Add subject if we have it.
		if (isset($_POST["subject"])) {
			$subject = $_POST["subject"];
		}
		else {
			$subject = "A MESSAGE LEFT AT YOUR WEBSITE";
		}

		// Construct message body.
		$body = "General Info:\nName: $name\nEmail: $emailaddr\n\n";
		$body .= "Message:\n$msg";


		// Email Headers
		$headers = "From: " . $name . " <" . $emailaddr . ">" . "\r\n";
		$headers .= "Reply-To: ". $emailaddr . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";

		// Now that we have all of the required data, email myself.
		if (mail("jcmjohnmatty@me.com", $subject, $body, $headers)) {
			echo "Message successfully sent!";
		}
		else {
			echo "Something went wrong, Please try again.";
		}
	}
	else {
		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['msg'] . "<br />" : null;
		echo $response;
	}
?>
