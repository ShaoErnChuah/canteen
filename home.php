
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
@include 'config.php';
session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login.php');
}
$user_id=$_SESSION['user_name'];
if(isset($_POST['add_to_cart'])){
    
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_id=$_POST['foodID'];
   $product_quantity = 1;
   $user_id=$_SESSION['user_name'];
   

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_name='$user_id'");

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'product already added to cart';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity,user_name,foodID) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity','$user_id','$product_id')");
      $message[] = 'product added to cart succesfully';
   }

}

if(isset($_POST['submit'])){

   
   
   $feedback=$_POST['feedback'];
   $stud_id=$_POST['stud_id'];
    $user_name=$_POST['user_name'];
            
             $mail=$_POST['mail'];
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
 
             $mail->setFrom('inticanteen@gmail.com', 'Feedback');
             $mail->addAddress('inticanteen@gmail.com');
 
             $mail->isHTML(true);
             $mail->Subject="Feedback from $user_name";
             $mail->Body="<p>$feedback <br></h3>
             <br><br>
             <p>With regards,</p>
             <b>$user_name</b>
             <b>$stud_id</b>
            ";
 
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
<html>
<head>
    <meta charset="utf-8" />
    

    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="header.css"/>
    <link rel="stylesheet" href=stylesheet.css />
   
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
                <li><a href="#contact">Contact</a></li>
                <li><a href="#about">About Us</a></li>
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
                       <a href="receipt.php" class="sub-menu-link"><p>Reciept</p><span>></span></a>
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

       <section class="home" id="home">
           <div class="content">
               <h3>Inti College </h3>
               <h3>Canteen<h3>
               <p>Food for everyone </p>
               <a href="food-page.php" class="btn">See Menu</a>
           </div>


       </section>

       <section class="rec" id="rec">
           <center><h1>Recommendations</h1></center>
           <div class="box-container">

      <?php
      
      $select_products = mysqli_query($conn, "SELECT * FROM products WHERE recommend='yes'  AND quantity>0  ;");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>

      <form action="" method="post">
         <div class="box">
            <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="" >
            <h3><?php echo $fetch_product['name']; ?></h3>
            <div class="price">Rm <?php echo $fetch_product['price']; ?></div>
            <div class="price">Quantity: <?php echo $fetch_product['quantity']; ?></div>
            <input type="hidden" name="foodID" value="<?php echo $fetch_product['foodID']; ?>">
            <input type="hidden" name="product_quantity" value="<?php echo $fetch_product['quantity']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <input type="submit" class="btn" value="add to cart" name="add_to_cart">
         </div>
      </form>

      <?php
         };
      };
      ?>

   </div>

</section>

<div class="about" id="about">
		<div class="abt-container">
			<div class="content-section">
				<div class="title">
					<h1>About Us</h1>
				</div>
				<div class="content">
					<h3>Opens 6am-6pm</h3>
					<p>We at Inti college canteen provide the most fresh ingredients to our students and teachers,
                        with a variety of delicious meals vist us at 1-Z, Lebuh Bukit Jambul, Bukit Jambul, 11900 Bayan Lepas, Pulau Pinang
                        .</p>
					
				</div>
				<div class="social">
					<a href="https://www.facebook.com/INTI.edu"><i class="fab fa-facebook-f"></i></a>
					<a href="https://twitter.com/INTI_edu"><i class="fab fa-twitter"></i></a>
					<a href="https://www.instagram.com/inti_edu/"><i class="fab fa-instagram"></i></a>
				</div>
			</div>
			<div class="image-section">
				<img src="img/cook.jpg">
			</div>
		</div>
	</div>


       <section class="contact" id="contact">
        <div class="con-container">
            <h1>Contact Us</h1>
            <p>Contact Us if you have any question</p>
            <div class="contact-box">
                <div class="contact-left">
                    <h3>Send Your question</h3>
                    <form  method="post">
                        <div class="input-row">
                            <div class="input group">
                            <label>Name</label>
                            <input type="text" id="user_name" name="user_name" placeholder="Enter Your Name">
                        </div>
                        <div class="input group">
                            <label>Phone</label>
                            <input type="text" id="phone" placeholder="Enter Your Phone Number">
                        </div>
                        </div>

                        <div class="input-row">
                            <div class="input group">
                            <label>Email</label>
                            <input type="email" id="mail" name="mail" placeholder="Enter Your email">
                        </div>
                        <div class="input group">
                            <label>Student ID</label>
                            <input type="text" id="stud_id"name="stud_id" placeholder="Enter Your ID Number">
                        </div>
                        </div>
                        <label>Message</label>
                        <textarea rows="5" id="feedback" name="feedback" placeholder="Your message"></textarea>
                        <input type="submit" name="submit" value="send" class="form-btn">
                        
                    </form>
                </div>
                <div class="contact-right">
                    <h3>Reach Us</h3>
                    <table border="0">
                        <tr>
                            <td>Email</td>
                            <td>intiCanteen@gmail.com</td>
                        </tr>
                        <tr>
                      <td>Phone</td>
                            <td>012-555-555</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td> 1-Z, Lebuh Bukit Jambul, Bukit Jambul, 11900 Bayan Lepas, Pulau Pinang</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>




    </section>

    <script src="main.js"></script>

</body>


</html>


