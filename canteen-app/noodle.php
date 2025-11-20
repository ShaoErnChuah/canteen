<?php

@include 'config.php';
session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login.php');
}
$user_id=$_SESSION['user_name'];
if(isset($_POST['add_to_cart'])){
    $product_id=$_POST['foodID'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = 1;
   $user_id=$_SESSION['user_name'];
   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'AND user_name='$user_id'");

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'product already added to cart';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity,user_name,foodID) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity','$user_id','$product_id')");
      $message[] = 'product added to cart succesfully';
   }

}
$sort_option = "";
if(isset($_GET['sort_numeric']))
{
    if($_GET['sort_numeric'] == "low-high"){
        $sort_option = "ASC";
    }elseif($_GET['sort_numeric'] == "high-low"){
        $sort_option = "DESC";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
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
      
      $select_rows = mysqli_query($conn, "SELECT * FROM `cart`WHERE user_name='$user_id'") or die('query failed');
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


<div class="container">

<section class="products">

   <h1 class="heading">Noodle</h1>
   <form action="" method="GET">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="input-group mb-3">
                                        <select name="sort_numeric" class="form-control">
                                            <option value="">--Select Option--</option>
                                            <option value="low-high" <?php if(isset($_GET['sort_numeric']) && $_GET['sort_numeric'] == "low-high") { echo "selected"; } ?> > Low - High</option>
                                            <option value="high-low" <?php if(isset($_GET['sort_numeric']) && $_GET['sort_numeric'] == "high-low") { echo "selected"; } ?> > High - Low</option>
                                        </select>
                                        <button type="submit" class="input-group-text " id="basic-addon2">
                                            Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
   <div class="box-container">

      <?php
      
      $select_products = mysqli_query($conn, "SELECT * FROM products WHERE type='noodle'  AND quantity>0  ORDER BY price $sort_option;");
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

</div>


<script src="main.js"></script>
</body>
</html>