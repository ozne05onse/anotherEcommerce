<?php 
if(!isset($_REQUEST['id'])){ 
    header("Location: index.php"); 
} 
 
// Include the database config file 
include_once 'dbConfig.php'; 
 
// Fetch order details from database 
$result = $db->query("SELECT r.*, c.first_name, c.last_name, c.tablenum, c.phone, c.ordate, c.ortime FROM orders AS r LEFT JOIN customers AS c ON c.id = r.customer_id WHERE r.id = ".$_REQUEST["id"]); 
 
 // var_dump($result->num_rows);
if($result->num_rows > 0){ 
    $orderInfo = $result->fetch_assoc(); 
}else{ 
    // header("Location: index.php");
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Order Status - Manay's Eatery</title>
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

    <section class="container-fluid order-bg" style="position: relative; top:0;left: 0; right: 0; bottom: 0; ">
        <h1 class="display-3  text-center" style="margin: 0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);" >ORDER INFORMATION</h1>
    </section>

<div class="container">
    <div class="row">
        <?php if(!empty($orderInfo)){ ?>
            <div class="col-md-12 col-lg-12 col-sm-12 mt-4">
                <p class="alert alert-success">Your order has been placed successfully.</p>
			</div>

            <!-- Order status & shipping info -->
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-6 col-lg-6 col-sm-12">
                <h5 class="hdr">Order Info</h5>
                <div></div>
                    <p><b>Reference ID:</b> <?php echo $orderInfo['id']; ?></p>
                    <p><b>Total:</b> <?php echo 'P'.$orderInfo['grand_total'].' PHP'; ?></p>
                    <p><b>Buyer Name:</b> <?php echo $orderInfo['first_name'].' '.$orderInfo['last_name']; ?></p>
                    <p><b>Table Number:</b> <?php echo $orderInfo['tablenum']; ?></p>
                    <p><b>Phone Number:</b> <?php echo $orderInfo['phone']; ?></p>
                    <p><b>Time:</b> <?php echo $orderInfo['ortime']; ?></p>
                    <p><b>Date:</b> <?php echo $orderInfo['ordate']; ?></p>
                </div>
            <!-- Order items -->
            <div class="col-lg-6 col-md-6 col-sm-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>QTY</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php 
                        // Get order items from the database 
                        $result = $db->query("SELECT i.*, p.name, p.price FROM order_items as i LEFT JOIN products as p ON p.id = i.product_id WHERE i.order_id = ".$orderInfo['id']); 
                        if($result->num_rows > 0){  
                            while($item = $result->fetch_assoc()){ 
                                $price = $item["price"]; 
                                $quantity = $item["quantity"]; 
                                $sub_total = ($price*$quantity); 
                        ?>

                        <tr>
                            <td><?php echo $item["name"]; ?></td>
                            <td><?php echo 'P'.$price.' PHP'; ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo 'P'.$sub_total.' PHP'; ?></td>
                        </tr>
                        <?php } 
                        } ?>
                    </tbody>
                </table>
            </div>

            </div>
        </div>
			

        <?php  }else{ ?>
        <div class="col-md-12">
            <div class="alert alert-danger">Your order submission failed.</div>
        </div>
        <?php } ?>
    </div>
    </div>

<!-- Footer -->
<?php include_once 'parts/footer.php'; ?>
</body>
</html>