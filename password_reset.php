<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
@include 'config.php';

session_start();

if(isset($_POST['password_reset_link'])){

  
   $email = mysqli_real_escape_string($conn, $_POST['email']);
  
   $select = " SELECT * FROM user_form WHERE email = '$email'  ";
  
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) == 0){

      $error[] = 'This email does not exist';

   }
      else{
         
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
                            window.location.replace('password_otp.php');
                        </script>
                        <?php
                    }
        }
      }
   }

   





?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>pass reset</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="login.css">

</head>
<body>
   
<div class="form-container">

   <form  method="post">
      <h3>Reset Password</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email"  name="email" required placeholder="enter your email">
      

   
      <input type="submit" name="password_reset_link" value="Send password reset link" class="form-btn">
      
   </form>

</div>




</body>
</html>