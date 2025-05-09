<?php
    include 'connection.php';
    session_start();

    $user_id = $_SESSION['user_id'];
    if(!isset($user_id)){
        header('location:login.php');
    }
    /*----------adding products to wishlist------------*/ 
    if(isset($_POST['add_to_wishlist'])){
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];

        $wishlist_number = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id='$user_id'") or die('query failed');
        $cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id='$user_id'") or die('query failed');

        if (mysqli_num_rows($wishlist_number) > 0){
            $message[] = 'Product already in wishlist';
        }
        else if(mysqli_num_rows($cart_number) > 0){
            $message[] = 'Product already in wishlist';
        }
        else{
            mysqli_query($conn, "INSERT INTO `wishlist`(`user_id`, `pid`, `name`, `price`, `image`) VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
            $message[] = 'Product successfully added into wishlist';
        }
        
    }


        /*----------adding products to cart------------*/ 
        if(isset($_POST['add_to_cart'])){
            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_image = $_POST['product_image'];
            $product_quantity = $_POST['product_quantity'];
    
            $cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id='$user_id'") or die('query failed');
            if(mysqli_num_rows($cart_number) > 0){
                $message[] = 'Product already in cart';
            }
            else{
                mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
                $message[] = 'Product successfully added into cart';
            }
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }

?>
<style type="text/css">
    <?php include 'main.css'; ?>
</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <title>Deelight</title>
</head>
<body>
    <?php include 'header.php'; ?>
       <div class="banner">
        <h1>product detail</h1>
        <p>Best cakes in the hood</p>

       </div> 


    <div class="view_page">
        <?php
        if (isset($_GET['pid'])){
            $pid = $_GET['pid'];
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$pid'") or die('query failed');
            
            if(mysqli_num_rows($select_products) > 0){
                while($fetch_products = mysqli_fetch_assoc($select_products)){


        
                
        if(isset($message)){
            foreach ($message as $message){
                echo '    <div class="message">
        <span>'.$message.'</span>
<i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
    </div>';
            }
        }
        ?>
        <form action="" method="post" class="box">
            <img src="images/<?php echo $fetch_products ['image'];?>">
            <div class="detail">
                <div class="price"><?php echo $fetch_products ['price'];?>/=</div>
                <div class="name"><?php echo $fetch_products ['name'];?></div>
                <div class="p_detail"><?php echo $fetch_products ['product_detail'];?></div>

                <input type="hidden" name="product_id" value="<?php echo $fetch_products ['id'];?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products ['name'];?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products ['price'];?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products ['image'];?>">
                <div class="icon">
                    
                    <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                    <input type="number" name="product_quantity" value="1" min="0" class="quantity">
                    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
        
            </div>
            
            <br><a href="customize.php" class="btn2" >Customize cake</a>
            <a href="shop.php" class="btn2" >continue shopping</a>
            
            </div>

            </form>
        <?php
                        }
                    }
                }
                        
        ?>

    </div>




    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>