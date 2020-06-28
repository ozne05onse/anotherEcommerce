<?php 
// Initialize shopping cart class 
include_once 'Cart.class.php'; 
$cart = new Cart; 
 
// Include the database config file 
require_once 'dbConfig.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Manay's Eatery</title> 
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
<!-- Bootstrap core CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<!-- Custom style -->
<link href="css/style.css" rel="stylesheet">

</head>
</head>
<body>

<header>
    <div style="position: relative; height:450px;">
        <section class="container" style="text-align:center;margin: 0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);">
            <h1 class="display-1" style="color: white;">Manay's Eatery</h1>
            <p class="lead" style="color: white; font-size: 2.5rem;">Life is too short, let's make it long.</p>
        </section>
        <img src="images/table-in-vintage-restaurant-6267.jpg" style="position: absolute; top:-150px; left: 0; right: 0; bottom: 0; z-index: -9999; height: 700px; width: 100%;" class="img-fluid" alt="Manay's Header Background Image">
    </div>
</header>
    
    <!-- Cart basket -->
    <div class="cart-view shadow p-3">
        <a href="viewCart.php" class="color:white;" title="View Cart"><img height="60" src="images/cartIcon.png"> <br>(<?php echo ($cart->total_items() > 0)?$cart->total_items().' Items':'Empty'; ?>)</a>
    </div>
<div class="container">
	
    
    <!-- Product list -->
    <div class="row col-lg-12">
        <?php 
        // Get products from database 
        $result = $db->query("SELECT * FROM products ORDER BY id ASC LIMIT 10"); 
        if($result->num_rows > 0){  
            while($row = $result->fetch_assoc()){ 
        ?>
        <div class="col-lg-3">
            <div class="card mt-5 shadow p-1" style="border-radius: 10px;">
                <img height="200" src="<?php echo $row["image"]; ?>">
                <div class="card-body ">
                    <h5 class="card-title"><?php echo $row["name"]; ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Price: <?php echo 'P'.$row["price"].' PHP'; ?></h6>
                    <p class="card-text"><?php echo $row["description"]; ?></p>
                    <a href="cartAction.php?action=addToCart&id=<?php echo $row["id"]; ?>" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
        <?php } }else{ ?>
        <p>Product(s) not found.....</p>
        <?php } ?>
    </div>
</div>


<?php include_once 'parts/footer.php'; ?>
</body>
</html>