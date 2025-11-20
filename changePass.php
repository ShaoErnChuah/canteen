<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

@include 'config.php';
session_start();



if(isset($_POST['submit'])){

   
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $email = $_SESSION['mail'];
  
   

  
      if($pass != $cpass){
         $error[] = 'password not matched!';
      
        }else{
         $insert = "UPDATE user_form SET password='$pass' WHERE email='$email'";
         $upload = mysqli_query($conn, $insert);
      }

      ?>
                        <script>
                            alert("<?php echo "Password changed " ?>");
                            window.location.replace('login.php');
                        </script>
                        <?php
             
   }

   
 




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

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Change Password</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
     
      
    
      <input type="password" name="password" id="password" required placeholder="enter your New password">
      <input type="password" name="cpassword" id="password" required placeholder="confirm your password">
     
      
      <input type="submit" name="submit" value="Change" class="form-btn">
   
   </form>

</div>

</body>
</html>