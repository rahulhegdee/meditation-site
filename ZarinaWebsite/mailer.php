
<?php

$curl = curl_init();
$name = $_POST['name']; 
$email = $_POST['email']; 
$subject = $_POST['subject']; 
$message = $_POST['message'];

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n  \"personalizations\": [\n    {\n      \"to\": [\n        {\n          \"email\": \"rahulh.hegde@gmail.com\"\n        }\n      ],\n      \"subject\": \"New Contact Form Submission\"\n    }\n  ],\n  \"from\": {\n    \"email\": \"contact@pconsulting.azurewebsites.net\"\n  },\n  \"content\": [\n    {\n      \"type\": \"text/html\",\n      \"value\": \"Name: $name<br><br>Email: $email<br><br>Subject: $subject<br><br>Message:<br>$message\"\n    }\n  ]\n}",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer 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",
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

?>