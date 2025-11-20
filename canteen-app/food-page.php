<?php

@include 'config.php';

session_start();
$user_id=$_SESSION['user_name'];
if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .box {
            background-color: orange;
            color: white;
            border: 2px solid black;
            margin: auto;
            padding: 20px;
            width: 50%;
            inline-size: 500px;
            text-align: center;
        }

        .box1 {
            background:url(img/rice2.jpg)no-repeat;
            background-position:center;
            border: 2px solid black;
            margin: auto;
            padding: 10px;
            width: 50px;
            inline-size: 500px;
            text-align: center;
        }
        .box2 {
            background:url(img/noodle2.jpg)no-repeat;
            background-size: cover;
            background-position:center;
            border: 2px solid black;
            margin: auto;
            padding: 10px;
            width: 50px;
            inline-size: 500px;
            text-align: center;
            max-width: 100%; 
        }
        
        .box3 {
            background:url(img/drink.jpg)no-repeat;
            background-position:center;
            border: 2px solid black;
            margin: auto;
            padding: 10px;
            width: 50px;
            inline-size: 500px;
            text-align: center;
        }
    </style>
</head>
<link rel="stylesheet" href="header.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href=stylesheet.css />
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

  
   

    


    <div class="box">
        <h1> Menu</h1>
    </div>

    <br />

    <div class="box1">
        <h2><a href="rice.php">Rice</h2></a>
    </div>

    <br />

    <div class="box2">
        <h2><a href="noodle.php">Noodle</a></h2>
    </div>

    <br />

    <div class="box3">
        <h2><a href="drink.php">Drinks</a></h2>
    </div>
    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>