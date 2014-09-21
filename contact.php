<?php
$emailTo = 'bribios@gmail.com';
$siteTitle = 'JBrianGordon';

error_reporting(E_ALL ^ E_NOTICE); // hide all basic notices from PHP

//If the form is submitted
if(isset($_POST['submitted'])) {

	// require a name from user
	if(trim($_POST['contactName']) === '') {
		$nameError =  'Whoops, got a name error!';
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}

	// need valid email
	if(trim($_POST['email']) === '')  {
		$emailError = 'Forgot to enter in your e-mail address.';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	// we need at least some content
	if(trim($_POST['comments']) === '') {
		$commentError = 'You forgot to enter a message!';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}

	// upon no failure errors let's email now!
	if(!isset($hasError)) {

		$subject = 'New message to '.$siteTitle.' from '.$name;
		$sendCopy = trim($_POST['sendCopy']);
		$body = "Name: $name \n\nEmail: $email \n\nMessage: $comments";
		$headers = 'From: ' .' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);

        //Autorespond
		$respondSubject = 'Thanks for the message!';
		$respondBody = "Thanks for checking out $siteTitle! Your message has been delivered. \n\nThis is just an auto response,
		 but I'll get back to you soon.";
		$respondHeaders = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $emailTo;

		mail($email, $respondSubject, $respondBody, $respondHeaders);

        // set our boolean completion value to TRUE
		$emailSent = true;
	}
}
?>