
<?php

$curl = curl_init();
$name = $_POST['name']; 
$email = $_POST['email']; 
$subject = $_POST['subject']; 
$message = $_POST['message'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {

  // Build POST request:
  $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
  $recaptcha_secret = '[CAPTCHA KEY]';
  $recaptcha_response = $_POST['recaptcha_response'];

  // Make and decode POST request:
  $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
  $recaptcha = json_decode($recaptcha);

  // Take action based on the score returned:
  if ($recaptcha->score >= 0.5) {
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\n  \"personalizations\": [\n    {\n      \"to\": [\n        {\n          \"email\": \"\"\n        }\n      ],\n      \"subject\": \"New Contact Form Submission\"\n    }\n  ],\n  \"from\": {\n    \"email\": \"contact@pconsulting.azurewebsites.net\"\n  },\n  \"content\": [\n    {\n      \"type\": \"text/html\",\n      \"value\": \"Name: $name<br><br>Email: $email<br><br>Subject: $subject<br><br>Message:<br>$message\"\n    }\n  ]\n}",
      CURLOPT_HTTPHEADER => array(
        "authorization: Bearer SG.[API KEY]", //if mail does not work, create new API in send grid and input new API key
        "cache-control: no-cache",
        "content-type: application/json"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    header('Location: thank.html');
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }
      // Verified - send email
  } else {
    header('Location: error.html');
      // Not verified - show form error
  }

}



?>