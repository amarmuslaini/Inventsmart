<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $message = $_POST["message"];
  
  $to = "yourname@example.com";
  $subject = "New Contact Form Message";
  $body = "Name: $name\nEmail: $email\nMessage: $message";
  $headers = "From: $email";

  if(mail($to, $subject, $body, $headers)) {
    echo "Message sent successfully!";
  } else {
    echo "Failed to send message.";
  }
}
?>
