<?php

@include 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login.php');
}
$user_id=$_SESSION['user_name'];
if(isset($_POST['order_btn'])){

 
 

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
         $product_price = number_format($product_item['price'] * $product_item['quantity']);
         $price_total += $product_price;
      };
   };

   $total_product = implode(', ',$product_name);
   
}

if(isset($_POST['save_time'])){
   $time =$_POST['time'];
   $insert=mysqli_query($conn,"UPDATE  `cart` SET time = '$time' WHERE user_name='$user_id'");
  
   if($insert){
     
      $message[]='Time saved';
  }else{
      $message[]='Unable to save Time';
  }

}
if(isset($_POST['reduce_qty'])){
  
   
   
  $time =$_POST['time'];
  $insert=mysqli_query($conn,"UPDATE  `cart` SET time = '$time' WHERE user_name='$user_id'");
 
  if(empty($_POST['time'])){
    
     $message[]='Enter time';

 }else{

   
   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_name='$user_id'");
 
   
   while ($cart_row = mysqli_fetch_assoc($select_cart)) {
       $quantity = $cart_row['quantity'];
       $foodID = $cart_row['foodID'];
       $price = $cart_row['price'];
       $total_price = number_format($price * $quantity);
       $time = $cart_row['time'];
       $username = $cart_row['user_name'];
       $productname = $cart_row['name'];
   
       $insert_product = mysqli_query($conn, "INSERT INTO `sales`(name, price,quantity,total,username,foodID) VALUES('$productname', '$price', '$quantity', '$total_price','$username',' $foodID')");
         $insert_order = mysqli_query($conn, "INSERT INTO `orders`(name, price,quantity,total,time,user_name,foodID) VALUES('$productname', '$price', '$quantity', '$total_price','$time','$username',' $foodID')");

      
      $del_product=mysqli_query($conn, "DELETE FROM `cart` WHERE user_name='$user_id'");
      $query = "UPDATE products SET quantity = quantity - $quantity WHERE foodID = $foodID";
      $upload = mysqli_query($conn, $query);
      header('location:receipt.php');
   }
   require 'vendor/phpmailer/phpmailer/src/Exception.php';
   require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
   require 'vendor/phpmailer/phpmailer/src/SMTP.php';
    //Load Composer's autoloader
    require 'vendor/autoload.php';
    $user_id=$_SESSION['user_name'];
   
    $query = mysqli_query($conn, " SELECT email FROM user_form WHERE name = '$user_id'");
    
    $result = mysqli_fetch_assoc($query);
    $email = $result['email'];
   
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host='smtp.gmail.com';
    $mail->Port=587;
    $mail->SMTPAuth=true;
    $mail->SMTPSecure='tls';

    $mail->Username='';
    $mail->Password='';

    $mail->setFrom('inticanteen@gmail.com',"Your order");
    $mail->addAddress($email,'Name');

    $mail->isHTML(true);
    $mail->Subject="Your Order";
    $order_details = '';
    $total = 0;
    $cart_query = mysqli_query($conn, "SELECT * FROM orders WHERE user_name = '$user_id'");
    
    while ($row = mysqli_fetch_assoc($cart_query)) {
        $order_details .= '<p>' . $row['name'] . ' - ' . $row['quantity'] . ' x RM' . $row['price'] .  '</p>';
        $total += ($row['quantity'] * $row['price']);
        $time=$row['time'];
    }
  
   
    $order_details .= '<p>Total: RM' . $total . '</p>';
    $order_details .= '<p>time for pickup: ' . $time . '</p>';


    $mail->Body = $order_details;

            if(!$mail->send()){
                ?>
                    <script>
                        alert("<?php echo "Mail failed to sernd "?>");
                    </script>
                <?php
            }else{
                ?>
                <script>
                    alert("<?php echo "mail sent" ?>");
                    
                </script>
                <?php
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
                <li><a href="home.php">Home</a></li>
                <li>
                    <a href="food-page.php" id="menu">Menu</a>
                    
                </li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">About Us</a></li>
                <?php
      
      $select_rows = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_name='$user_id'") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);

      ?>
                
                <li id="cart" class="cart"><a href="cart.php" class="fa fa-shopping-cart"><span><?php echo $row_count; ?></span></a></li>
                
                <li id="log"><a href="#"class="fa fa-user" onclick="togglemenu()"></li><a>
                    <div class="sub-menu-wrap" id="subMenu">
                    <div class="sub-menu">
                    <div class="user-info">
                        <h2><?php echo $_SESSION['user_name'] ?></h2>
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
    
        <h3>Your order</h3>
      <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_name='$user_id'");
         $total = 0;
        
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
               $quantity=$fetch_cart['quantity'];
               $foodID=$fetch_cart['foodID'];
               $price=$fetch_cart['price'];
               $name=$fetch_cart['name'];
               $total_price = number_format($price * $quantity);
            $grand_total = $total += $total_price;
            
      ?>
      
      <span><input type="hidden" name="foodID" value="<?=$foodID;?>"><?= $name; ?>(Qty:<?= $quantity; ?>)(Rm<?= $price* $quantity; ?>)</span>
      <?php
         }
      }else{
         echo "<div class='display-order'><span>your cart is empty!</span></div>";
      }
      ?>
      <span class="grand-total"> grand total : Rm<?= $grand_total; ?> </span>
   </div>

   <form action="" method="post">
<center>   <label for="appt">Time for pickup:</label>

<input type="time" id="time" name="time"></br>

</center>
 
<p align="right"> <button class="btn"  name="reduce_qty"> Place order</p></button>
<p align="left"><a href="home.php" class="btn" >continue shopping</a></p>
</form>

   <script src="main.js"></script>
</body>

</html>
