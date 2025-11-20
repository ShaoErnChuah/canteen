
<?php

@include 'config.php';
session_start();


if(!isset($_SESSION['admin_name'])){
   header('location:login.php');
}
if(isset($_GET['delete'])){
    $user_id =$_GET['delete'];
    mysqli_query($conn,"DELETE FROM user_form WHERE user_id=$user_id");
    header('location:user_dash.php');
}


if(isset($_GET['give'])){
    $user_id =$_GET['give'];
    mysqli_query($conn,"UPDATE user_form SET user_type='admin' WHERE user_id=$user_id");
    header('location:user_dash.php');
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
   
        <meta charset="uft-8">
        <title></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href=stylesheet.css />
    <link rel="stylesheet" href="header.css"/>
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
    $select = mysqli_query($conn, "SELECT * FROM user_form WHERE user_type='user'");
   
    ?>
    <div class="product-display">
       <table class="product-display-table">
          <thead>
          <tr>
             <th>name</th>
             <th>email</th>
             
             <th>action</th>
          </tr>
          </thead>
          <?php while($row = mysqli_fetch_assoc($select)){ ?>
          <tr>
             <td><?php echo $row['name']; ?></td>
             <td><?php echo $row['email']; ?></td>
            
             
            
             <td>
               
             <a href="user_dash.php?give=<?php echo $row['user_id']; ?>" class="btn"> <i class="fas fa-edit"></i> make admin </a>
                <a href="user_dash.php?delete=<?php echo $row['user_id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
             </td>
          </tr>
       <?php } ?>

    </table>


</div>

    </div>    




    <script src="main.js"></script>
</body>



</html>