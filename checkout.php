<?php 
// Include the database config file 
require_once 'dbConfig.php'; 
 
// Initialize shopping cart class 
include_once 'Cart.class.php'; 
$cart = new Cart; 
 
// If the cart is empty, redirect to the products page 
if($cart->total_items() <= 0){ 
    header("Location: index.php"); 
} 
 
// Get posted data from session 
$postData = !empty($_SESSION['postData'])?$_SESSION['postData']:array(); 
unset($_SESSION['postData']); 
 
// Get status message from session 
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:''; 
if(!empty($sessData['status']['msg'])){ 
    $statusMsg = $sessData['status']['msg']; 
    $statusMsgType = $sessData['status']['type']; 
    unset($_SESSION['sessData']['status']); 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Checkout - Manay's Eatery</title>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
<!-- Bootstrap core CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<!-- Custom style -->
<link href="css/style.css" rel="stylesheet">
</head>
<body>

<!-- Header Nav -->
<?php include_once 'parts/header.php'; ?>

    <section class="container-fluid check-bg" style="position: relative; top:0;left: 0; right: 0; bottom: 0; ">
        <h1 class="display-2  text-center" style="margin: 0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);" >CHECK OUT</h1>
    </section>

<div class="container mt-5">
    <div class="col-12">
        <div class="checkout">
            <div class="row">
                <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
                <div class="col-md-12">
                    <div class="alert alert-success"><?php echo $statusMsg; ?></div>
                </div>
                <?php } elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
                <div class="col-md-12">
                    <div class="alert alert-danger"><?php echo $statusMsg; ?></div>
                </div>
                <?php } ?>
				
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your Cart</span>
                        <span class="badge badge-secondary badge-pill"><?php echo $cart->total_items(); ?></span>
                    </h4>
                    <ul class="list-group mb-3">
                        <?php 
                        if($cart->total_items() > 0){ 
                            //get cart items from session 
                            $cartItems = $cart->contents(); 
                            foreach($cartItems as $item){ 
                        ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0"><?php echo $item["name"]; ?></h6>
                                <small class="text-muted"><?php echo 'P'.$item["price"]; ?>(<?php echo $item["qty"]; ?>)</small>
                            </div>
                            <span class="text-muted"><?php echo 'P'.$item["subtotal"]; ?></span>
                        </li>
                        <?php } } ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (PHP)</span>
                            <strong><?php echo 'P'.$cart->total(); ?></strong>
                        </li>
                    </ul>
                    <a href="index.php" class="btn btn-block btn-info">Add Items</a>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Contact Details</h4>
                    <form method="post" action="cartAction.php">
                        <div class="row">
                            <div class="col-md-4 col-md-12 col-lg-4 mb-3">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" value="<?php echo !empty($postData['first_name'])?$postData['first_name']:''; ?>" required>
                            </div>
                            <div class="col-md-4 col-lg-4 col-md-12 mb-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="<?php echo !empty($postData['last_name'])?$postData['last_name']:''; ?>" required>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-4 col-md-12">
                                <label for="tablenum">Table #(Optional)</label>
                               

                                <select class="custom-select my-1 mr-sm-2" name="tablenum" id="tablenum">
    <option selected >Choose...</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
  </select>
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="mb-3 col-md-4 col-lg-4 col-md-12">
                                <label for="phone">Phone</label>
                                <input type="number" class="form-control" name="phone" value="<?php echo !empty($postData['phone'])?$postData['phone']:''; ?>" required>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-4 col-md-12">
                                <label for="ordate">Date</label>
                                <input type="date" class="form-control" name="ordate" value="<?php echo !empty($postData['ordate'])?$postData['ordate']:''; ?>" required>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-4 col-md-12">
                                <label for="ortime">Time</label>
                                <input type="time" class="form-control" name="ortime" value="<?php echo !empty($postData['ortime'])?$postData['ortime']:''; ?>" required>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="placeOrder"/>
                        <input class="btn btn-success btn-lg btn-block" type="submit" name="checkoutSubmit" value="Place Order">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include_once 'parts/footer.php'; ?>

</body>
</html>