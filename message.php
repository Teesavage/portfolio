<?php

$name = $_POST["name"];
$email = $_POST["email"];
$subject = $_POST["subject"];
$message = $_POST["message"];


$host = "localhost";
$dbname = "myportfolio";
$username = "root";
$password = "";
        
$conn = mysqli_connect(hostname: $host,
                       username: $username,
                       password: $password,
                       database: $dbname);
        
if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}           
        
$sql = "INSERT INTO portfolio (name, email, subject, message)
        VALUES (?, ?, ?, ?)";

$stmt = mysqli_stmt_init($conn);

if ( ! mysqli_stmt_prepare($stmt, $sql)) {
 
    die(mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ssss",
                       $name,
                       $email,
                       $subject,
                       $message);

mysqli_stmt_execute($stmt);



require "mailer-vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = "ssl";
$mail->Port = 465;

$mail->Username = "numbteshop@gmail.com";
$mail->Password = "hiddenpassword";

$mail->setFrom($email, $name);
$mail->addAddress("teesavage077@gmail.com");
$mail->addReplyTo($email, $name);
$mail->isHTML(true);


$mail->Subject = $subject;
$mail->Body = "$message.";


$mail->send();



echo  '<script>
alert("Message Sent Successfully")
window.location.href = "index.html";
</script>';
