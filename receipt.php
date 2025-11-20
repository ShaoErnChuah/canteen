<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
@include 'config.php';
session_start();
$user_id=$_SESSION['user_name'];
if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}





if(isset($_POST['send_mail'])){
    
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

    $mail->Username='inticanteen@gmail.com';
    $mail->Password='zagpinvsfllzqzyy';

    $mail->setFrom('inticanteen@gmail.com',"Your order");
    $mail->addAddress($email,'Name');

    $mail->isHTML(true);
    $mail->Subject="";
    $order_details = '';
    $total = 0;
    $cart_query = mysqli_query($conn, "SELECT * FROM orders WHERE user_name = '$user_id'");
    
    while ($row = mysqli_fetch_assoc($cart_query)) {
        $order_details .= '<p>' . $row['name'] . ' - ' . $row['quantity'] . ' x ' . $row['price'] . '</p>';
        $total += ($row['quantity'] * $row['price']);
    }
    
    $order_details .= '<p>Total: ' . $total . '</p>';


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

   

 

 




?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
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


    <div class="display-order">
        <h3><?php echo $_SESSION['user_name'] ?>'s Order</h3>
      <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_name='$user_id'");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total = $total += $total_price;
            $time=($fetch_cart['time']);
      ?>
      <span><?= $fetch_cart['name']; ?>(Qty:<?= $fetch_cart['quantity']; ?>)(Rm<?= $fetch_cart['price']* $fetch_cart['quantity']; ?>)</span>
      
      <?php
         }
      }else{
         echo "<div class='display-order'><span>your cart is empty!</span></div>";
      }
      ?>
      <span class="grand-total"> grand total : Rm<?= $grand_total; ?> </span>
      
      <span>Time for pickup: <?=$time; ?>  </span>
     
<span id="myId"></span> 
<script> 
var date = new Date(); 
var dd = date.getDate(); 
var mm = date.getMonth() + 1; 
var yyyy = date.getFullYear(); 
var newDate = dd + "-" + mm + "-" +yyyy; 
var p = document.getElementById("myId"); 
p.innerHTML = newDate; 
</script>
   </div>
   <a href="home.php" class="btn" style="margin-top: 0;">continue shopping</a>
   




    <script src="main.js"></script>

</body>
</html>