<?php


@include 'config.php';

session_start();

if(isset($_POST['submit'])){

  
   $stud_id = mysqli_real_escape_string($conn, $_POST['studID']);
   $pass = md5($_POST['password']);
  
  

   $select = " SELECT * FROM user_form WHERE stud_id = '$stud_id' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   

      $row = mysqli_fetch_array($result);
      if(mysqli_num_rows($result) > 0){
         if($row["status"]==0){
            $error[]='Please verify your email before login';
         }
     else  if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         header('location:admin_dashboard.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         header('location:home.php');

      }
     
   }else{
      $error[] = 'incorrect username or password!';
   }


  






};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="login.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>login now!</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
       <input type="text" name="studID" id="studID" required placeholder="enter your student ID " minlength="9" maxlength="9"   pattern="[p-pP-P ][0-9]+" title="Enter valid student ID">
      
      <input type="password" name="password" id="password" required placeholder="enter your password" >
     <span>show password <img src="img/eye-close.png" id="eye-icon"></span>
   
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>don't have an account? <a href="register.php">register now</a></p>
      <a href="password_reset.php">Forgot Password</a>
   </form>

</div>

<script src="main.js"></script>


</body>
</html>