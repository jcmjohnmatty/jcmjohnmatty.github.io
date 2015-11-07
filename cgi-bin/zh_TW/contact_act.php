<?php
	// Check to make sure that all the required variables were specified, and if not display an error message.
	if (isset($_POST["name"])) {
		$name = $_POST["name"];

   		// Check Name
		if (strlen($name) < 2) {
			$error["name"] = "錯誤：字段「名稱」格式不正常。\n請重新輸入您的名稱。";
		}

		if (!$error and isset($_POST["emailaddr"])) {
			$emailaddr = $_POST["emailaddr"];

			// Check Email
			if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $emailaddr)) {
				$error["email"] = "錯誤：字段「郵箱」格式不正常。\n請輸入有效的郵箱。";
			}

			if (!$error and isset($_POST["msg"])) {
				$msg = $_POST["msg"];
				// Check message.
				if (strlen($contact_message) < 15) {
					$error["msg"] = "錯誤：字段「訊息」格式不正常。\n請重新輸入您的訊息，訊息至少應該有 15 個字。";
				}
			}
			else {
				$error["msg"] = "錯誤：字段「訊息」是必填的。";
			}
		}
		else {
			$erorr["email"] = "錯誤：字段「郵箱」是必填的。";
		}
	}
	else {
		$error["name"] = "錯誤：字段「名稱」是必填的。";
	}

	if (!$error) {
		// Add subject if we have it.
		if (isset($_POST["subject"])) {
			$subject = $_POST["subject"];
		}
		else {
			$subject = "在你的網站留下的信息......";
		}

		// Construct message body.
		$body = "基本資訊:\n名稱: $name\n郵箱: $emailaddr\n\n";
		$body .= "訊息:\n$msg";


		// Email Headers
		$headers = "From: " . $name . " <" . $emailaddr . ">" . "\r\n";
		$headers .= "Reply-To: ". $emailaddr . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";

		// Now that we have all of the required data, email myself.
		if (mail("jcmjohnmatty@me.com", $subject, $body, $headers)) {
			echo "傳送資訊成功！";
		}
		else {
			echo "發生錯誤。";
		}
	}
	else {
		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['msg'] . "<br />" : null;
		echo $response;
	}
?>