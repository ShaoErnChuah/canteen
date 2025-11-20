<?php
@include 'config.php';
session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login.php');
}

if(isset($_POST['add_product'])){
    $product_name = $_POST['product_name'];
    $product_type = $_POST['product_type'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/'.$product_image;

    $select = " SELECT * FROM products WHERE name = '$product_name'";

    $result = mysqli_query($conn, $select);
    
    



    if(empty($product_name) || empty($product_price) || empty($product_image) || empty($product_quantity)){
        $message[]='Please fill out all';

    }else{
        if(mysqli_num_rows($result) > 0){
    
            $message[] = 'product already exist!';
         }
    else{
        $insert="INSERT INTO products(name,type,price,quantity,image) VALUES('$product_name','$product_type','$product_price','$product_quantity','$product_image')";
        $upload= mysqli_query($conn,$insert);
        if($upload){
            move_uploaded_file($product_image_tmp_name,$product_image_folder);
            $message[]='new product successfully added';
        }else{
            $message[]='Product Could not be added';
        }
    }
    }

};
if(isset($_GET['delete'])){
    $foodID =$_GET['delete'];
    mysqli_query($conn,"DELETE FROM products WHERE foodID=$foodID");
    header('location:admin_page.php');
}

if(isset($_POST['update_update_btn'])){
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
   
    $update_quantity_query = mysqli_query($conn, "UPDATE products SET quantity = '$update_value' WHERE foodID = '$update_id'");
    if($update_quantity_query){
       header('location:admin_page.php');
    };
 };
 

?>


<!DOCTYPE html>
<html lang="en">
    <head>
   
        <meta charset="uft-8">
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
        echo '<span class="message">'.$message.'</span>';
    }
}
 ?>

    <div class="container-1">
    <div class="admin-product-form-container">
    <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" >
    <h3>add new product</h3>
    <input type="text" placeholder="enter product name" name="product_name" class="box">
    <input type="text" placeholder="enter product type" name="product_type" class="box">
    <input type="number" placeholder="enter product price" name="product_price" class="box">
    <input type="number" placeholder="enter product quantity" name="product_quantity" class="box">
    <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
    <input type="submit" class="btn-1" name="add_product" value="add product">
</form>
    


    </div>
    <?php
    $select = mysqli_query($conn, "SELECT * FROM products");
   
    ?>
    <div class="product-display">
       <table class="product-display-table">
          <thead>
          <tr>
             <th>product image</th>
             <th>product name</th>
             <th>Product Type</th>
             <th>product price</th>
             <th>Product quantity</th>
             <th>action</th>
          </tr>
          </thead>
          <?php while($row = mysqli_fetch_assoc($select)){ ?>
          <tr>
             <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
             <td><?php echo $row['name']; ?></td>
             <td><?php echo $row['type'];?></td>
             <td>Rm<?php echo $row['price']; ?></td>
             <td>
              
             <form action="" method="post">
             <input type="hidden" name="update_quantity_id"  value="<?php echo $row['foodID']; ?>" >
                  <input type="number" name="update_quantity" min="0"  value="<?php echo $row['quantity']; ?>" >
                  <input type="submit" value="update" name="update_update_btn">
          </form>
            
             <td>
             
                <a href="admin_update.php?edit=<?php echo $row['foodID']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
                <a href="admin_page.php?delete=<?php echo $row['foodID']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
             </td>
          </tr>
       <?php } ?>

    </table>


</div>

    </div>    

    <script src="main.js"></script>
    
</body>
</html>




        