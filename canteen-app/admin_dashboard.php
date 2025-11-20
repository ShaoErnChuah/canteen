<?php

@include 'config.php';
session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login.php');
}


?>


<!DOCTYPE html>
<html>
<head>
<meta charset="uft-8"/>
<title></title>

</head>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
<link rel="stylesheet" href="header.css"/>
    <link rel="stylesheet" href=stylesheet2.css />
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

   
    <section class="dashboard">

<h1 class="heading">dashboard</h1>
<div class="dash-container">


<div class="dash">
<?php
            $select_rows = mysqli_query($conn, "SELECT * FROM `user_form` WHERE user_type='user';") or die('query failed');
            $row_count = mysqli_num_rows($select_rows);
      ?>
      <h3><?php echo $row_count; ?></h3>
      <p>Total Orders </p>
      <a href="view_order.php" class="btn">View orders</a>
   </div>



<div class="dash">
<?php
            $select_rows = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            $row_count = mysqli_num_rows($select_rows);
      ?>
      <h3><?php echo $row_count; ?></h3>
      <p>products added</p>
      <a href="admin_page.php" class="btn">Add products</a>
   </div>

   <div class="dash">
   <?php
            $select_rows = mysqli_query($conn, "SELECT * FROM `user_form` WHERE user_type='user';") or die('query failed');
            $row_count = mysqli_num_rows($select_rows);
      ?>
      <h3><?php echo $row_count; ?></h3>
      
      <p>Total users accounts </p>
      <a href="user_dash.php" class="btn">Edit user account</a>
   </div>

   <div class="dash">

   
      <p>Sales</p>
      <a href="sales.php" class="btn">View Sales</a>
   </div>
   <div class="dash">

   
<p>Sales Table</p>
<a href="saletable.php" class="btn">View Sales Table</a>
</div>
</section>









<script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>






</body>

</html>