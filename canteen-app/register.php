<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

@include 'config.php';
session_start();
function send_password_reset($get_email,$token){
   $to_email = $email;
   $subject = "<h2>Hello</h2>
   <h3>You recieved this email because you requested for a password request for your INTI canteen account</h3>
   <br/><br/>
   <a href='http://localhost/canteen/password-change.php?'token=$token&email=$get_email'>click me</a>
   ";
   $body = "Your account has been successfully created";
   $headers = "From: inticanteen@gmail.com";
   
   if (mail($to_email, $subject, $body, $headers)) {
       echo "Email successfully sent to $to_email...";
   } else {
       echo "Email sending failed...";
   }
}


if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user="user";
   $stud_id=$_POST['studID'];
   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass'&& stud_id='$stud_id' ";
  
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }
   
   else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO user_form(name, email, password,stud_id,user_type,status ) VALUES('$name','$email','$pass','$stud_id','$user',0)";
         mysqli_query($conn, $insert);
         if($result){
            $otp = rand(100000,999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['mail'] = $email;
            require 'vendor/phpmailer/phpmailer/src/Exception.php';
            require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
            require 'vendor/phpmailer/phpmailer/src/SMTP.php';
            //Load Composer's autoloader
            require 'vendor/autoload.php';
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->Port=587;
            $mail->SMTPAuth=true;
            $mail->SMTPSecure='tls';

            $mail->Username='inticanteen@gmail.com';
            $mail->Password='zagpinvsfllzqzyy';

            $mail->setFrom('inticanteen@gmail.com', 'OTP Verification');
            $mail->addAddress($_POST["email"]);

            $mail->isHTML(true);
            $mail->Subject="Your verify code";
            $mail->Body="<p>Dear user, </p> <h3>Your verify OTP code is $otp <br></h3>
            <br><br>
            <p>With regrads,</p>
            <b>Inti Canteen</b>
           ";

                    if(!$mail->send()){
                        ?>
                            <script>
                                alert("<?php echo "Register Failed, Invalid Email "?>");
                            </script>
                        <?php
                    }else{
                        ?>
                        <script>
                            alert("<?php echo "Register Successfully, OTP sent to " . $email ?>");
                            window.location.replace('verify.php');
                        </script>
                        <?php
                    }
        }
      }
   }

   
   

};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="login.css">
   <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>
</head>
<body>
   
<div class="form-container">

   <form action="" id=myform method="post">
      <h3>register now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" id="name" required placeholder="enter your name">
      <input type="email" name="email" required placeholder="Enter your email(eg.user@student.newinti.edu.my)" pattern=".+@student.newinti.edu\.my">
      <input type="text" name="studID" id="studID" required placeholder="enter your student ID " minlength="9" maxlength="9" pattern="[p-pP-P ][0-9]+" title="Enter valid student ID">
      <input type="password" name="password" id="password" required placeholder="enter your password(more than 8 words,non repeating)" pattern=".{5,}">
      <meter max="4" id="password-strength-meter"></meter>
      <p id="password-strength-text"></p>
      
      <span>show password <img src="img/eye-close.png" id="eye-icon"></span>
      <input type="password" name="cpassword" id="password" required placeholder="confirm your password">
     
      
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</div>

</body>
</html>

<script src="main.js"></script>

