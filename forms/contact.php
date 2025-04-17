<?php
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

  // Replace contact@example.com with your real receiving email address

  
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      // Reject non‑POST requests
      http_response_code(405);
      exit;
  }
  
  // 1) Sanitize & validate inputs
  $name    = strip_tags(trim($_POST['name'] ?? ''));
  $email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
  $phone   = strip_tags(trim($_POST['phone'] ?? ''));
  $message = trim($_POST['message'] ?? '');
  
  if ( empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
      // Bad request
      http_response_code(400);
      echo 'Please fill in all required fields.';
      exit;
  }
  
  // 2) Build the email
  $to      = 'nehalk751@gmail.com';
  $subject = "New contact form submission from $name";
  $body    = "You have received a new message from your website contact form.\n\n"
           . "Name: $name\n"
           . "Email: $email\n"
           . "Phone: $phone\n\n"
           . "Message:\n$message\n";
  $headers = "From: $name <$email>\r\n"
           . "Reply-To: $email\r\n";
  
  // 3) Send it
  if ( mail($to, $subject, $body, $headers) ) {
      // success
      http_response_code(200);
      // you can redirect to a thank‑you page:
      header('Location: /../news.html');
      exit;
  } else {
      // failure
      http_response_code(500);
      echo 'Sorry, something went wrong. Please try again later.';
      exit;
  }
  














  
  /*
  $receiving_email_address = 'contact@example.com';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  
  $contact->to = $receiving_email_address;
  $contact->from_name = $_POST['name'];
  $contact->from_email = $_POST['email'];
  $contact->subject = $_POST['subject'];

  // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  /*
  $contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
  );
  //

  $contact->add_message( $_POST['name'], 'From');
  $contact->add_message( $_POST['email'], 'Email');
  $contact->add_message( $_POST['message'], 'Message', 10);

  echo $contact->send();

*/




?>
