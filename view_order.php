<?php

@include 'config.php';

session_start();
error_reporting(0);
if(!isset($_SESSION['admin_name'])){
   header('location:login.php');
}

if(isset($_GET['complete_order'])){
   $username = mysqli_real_escape_string($conn, $_GET['complete_order']);
   mysqli_query($conn, "DELETE FROM `orders` WHERE `user_name` = '$username'");
  
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="header.css"/>
   <link rel="stylesheet" href="stylesheet2.css">
</head>
<body>





<header>
        <div class="menu-bar">
            <ul>
                <li><img src="img/inti.png" alt="inti" /></li>
                <li><a href="admin_dashboard.php">Home</a></li>
                
                
                <li id="log"><a href="#"class="fa fa-user" onclick="togglemenu()"></li><a>
                    <div class="sub-menu-wrap" id="subMenu">
                    <div class="sub-menu">
                    <div class="user-info">
                        <h2><?php echo $_SESSION['admin_name'] ?></h2>
                    </div>
                    <hr>
                        <a href="logout.php" class="sub-menu-link"><p>Logout</p><span>></span></a>
                    </div>

                    </div>
            </ul>
        </div>
    </header>
    

    <?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>
    

    <div class="display-order">

    
    
      <?php
      $select_cart = mysqli_query($conn, "SELECT `user_name`, SUM(`price` * `quantity`) as `total_price` FROM `orders` GROUP BY `user_name`");
     if(mysqli_num_rows($select_cart) > 0){
      while($row = mysqli_fetch_assoc($select_cart)){
          $username = $row['user_name'];
          $total_price = $row['total_price'];
        
         $total = 0;
         $grand_total = 0;
         echo "<br><br>";
            $select_user_cart = mysqli_query($conn, "SELECT * FROM `orders` WHERE `user_name` = '$username'");
            while($fetch_cart = mysqli_fetch_assoc($select_user_cart)){
               $price = $fetch_cart['price'];
               $quantity = $fetch_cart['quantity'];
               $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
               $grand_total = $total += $total_price;
               $time = $fetch_cart['time'];
               $name=$fetch_cart['name'];
           
           
           
             ?>
               <span><?= $name; ?>(Qty:<?= $quantity ?>)(Rm<?= $price* $quantity; ?>)</span>
              
               <?php 
                     
            }
           ?>
            <h3><?=$username;  ?></h3>
            <h3> <?=$time; ?>  </h3>
            <span class="grand-total"> grand total : Rm<?= $grand_total; ?> </span>
            

            <a href="view_order.php?complete_order=<?php echo urlencode($username) ?>" onclick="return confirm('Delete all orders for this user?');" class="delete-btn"> <i class="fas fa-trash"></i> Complete Order </a>
         <?php
         }
      }
      
      
      ?>
      </div>
            
      
     
   
      
      
      
      
   
   

    
    





   
   <form action="" method="post">
<p align="left"><a href="admin_dashboard.php" class="btn" >Back</a></p>
</form>

   <script src="main.js"></script>
</body>

</html>