<?php
session_start();
@include 'config.php';



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
//Load Composer's autoloader
require 'vendor/autoload.php';

function send_password_reset($get_name,$get_email,$token)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();                                            //Send using SMTP
    $mail->SMTPAuth   = true;   
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through                                  
    $mail->Username   = "intipwreset@gmail.com";                     //SMTP username
    $mail->Password   = "pwreset123";         
    $mail->SMTPDebug = 2;
    $mail->SMTPSecure ="tls";  
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('intipwreset@gmail.com', $get_name);
    $mail->addAddress($get_email);     //Add a recipient
   
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Reset password Notification";
   $email_template="
   <h2>Hello</h2>
   <h3>You recieved this email because you requested for a password request for your INTI canteen account</h3>
   <br/><br/>
   <a href='http://localhost/canteen/password-change.php?'token=$token&email=$get_email'>click me</a>
   ";
    $mail->Body=$email_template;
    $mail->send();
}



//  if(isset($_POST['password_reset_link']))
// {
//     $email=mysqli_real_escape_string($conn,$_POST['email']);
//     $token = md5(rand());

//     $check_email="SELECT email FROM user_form WHERE email='$email' LIMIT 1";
//     $check_email_run=mysqli_query($conn,$check_email);
    
//     if(mysqli_num_rows($check_email_run)>0)
//     {
//             $row= mysqli_fetch_array($check_email_run);
          
//             $get_email= $row['email'];
            
//             $update_token="UPDATE user_form SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
//             $update_token_run=mysqli_query($conn,$update_token);

//             if($update_token_run){
//                 send_password_reset($get_email,$token);
//                 $_SESSION['status']="email sent with password reset link";
//                 header("Location:password-reset.php");
//                 exit(0);

//             }
//             else
//             {
//                 $_SESSION['status']="Something went wrong. #1";
//                 header("Location:password-reset.php");
//                 exit(0);
//             }
//     }
//     else
//     {
//         $_SESSION['status']="No email Found";
//         header("Location:password-reset.php");
//         exit(0);
//     }
// } 
 
?>