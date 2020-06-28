<?php 
// Initialize shopping cart class 
require_once 'Cart.class.php'; 
$cart = new Cart; 
 
// Include the database config file 
require_once 'dbConfig.php'; 
 
// Default redirect page 
$redirectLoc = 'index.php'; 
 
// Process request based on the specified action 
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){ 
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){ 
        $productID = $_REQUEST['id']; 
         
        // Get product details 
        $query = $db->query("SELECT * FROM products WHERE id = ".$productID); 
        $row = $query->fetch_assoc(); 
        $itemData = array( 
            'id' => $row['id'], 
            'name' => $row['name'], 
            'price' => $row['price'], 
            'qty' => 1 
        ); 
         
        // Insert item to cart 
        $insertItem = $cart->insert($itemData); 
         
        // Redirect to cart page 
        $redirectLoc = $insertItem?'viewCart.php':'index.php'; 
    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){ 
        // Update item data in cart 
        $itemData = array( 
            'rowid' => $_REQUEST['id'], 
            'qty' => $_REQUEST['qty'] 
        ); 
        $updateItem = $cart->update($itemData); 
         
        // Return status 
        echo $updateItem?'ok':'err';die; 
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){ 
        // Remove item from cart 
        $deleteItem = $cart->remove($_REQUEST['id']); 
         
        // Redirect to cart page 
        $redirectLoc = 'viewCart.php'; 
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0){ 
        $redirectLoc = 'checkout.php'; 
         
        // Store post data 
        $_SESSION['postData'] = $_POST; 
     
        $first_name = strip_tags($_POST['first_name']); 
        $last_name = strip_tags($_POST['last_name']); 
        $table = strip_tags($_POST['tablenum']); 
        $phone = strip_tags($_POST['phone']); 
        $date = strip_tags($_POST['ordate']); 
        $time = strip_tags($_POST['ortime']); 
         
        $errorMsg = ''; 
        if(empty($first_name)){ 
            $errorMsg .= 'Please enter your first name.<br/>'; 
        } 
        if(empty($last_name)){ 
            $errorMsg .= 'Please enter your last name.<br/>'; 
        } 

        if(empty($phone)){ 
            $errorMsg .= 'Please enter your phone number.<br/>'; 
        } 
        if(empty($date)){ 
            $errorMsg .= 'Please enter your date.<br/>'; 
        } 

        if(empty($time)){ 
            $errorMsg .= 'Please enter your time.<br/>'; 
        } 
         
        if(empty($errorMsg)){ 
            // Insert customer data in the database 
            $insertCust = $db->query("INSERT INTO customers (first_name, last_name, tablenum, phone, ordate, ortime) VALUES ('".$first_name."', '".$last_name."', '".$table."', '".$phone."', '".$date."','".$time."')"); 
             
            if($insertCust){ 
                $custID = $db->insert_id; 
                 
                // Insert order info in the database 
                $insertOrder = $db->query("INSERT INTO orders (customer_id, grand_total) VALUES ($custID, '".$cart->total()."')"); 
             
                if($insertOrder){ 
                    $orderID = $db->insert_id; 
                     
                    // Retrieve cart items 
                    $cartItems = $cart->contents(); 
                     
                    // Prepare SQL to insert order items 
                    $sql = ''; 
                    foreach($cartItems as $item){ 
                        $sql .= "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('".$orderID."', '".$item['id']."', '".$item['qty']."');"; 
                    } 
                     
                    // Insert order items in the database 
                    $insertOrderItems = $db->multi_query($sql); 
                     
                    if($insertOrderItems){ 
                        // Remove all items from cart 
                        $cart->destroy(); 
                         
                        // Redirect to the status page 
                        $redirectLoc = 'orderSuccess.php?id='.$orderID; 
                    }else{ 
                        $sessData['status']['type'] = 'error'; 
                        $sessData['status']['msg'] = 'Some problem occurred, please try again.'; 
                    } 
                }else{ 
                    $sessData['status']['type'] = 'error'; 
                    $sessData['status']['msg'] = 'Some problem occurred, please try again.'; 
                } 
            }else{ 
                $sessData['status']['type'] = 'error'; 
                $sessData['status']['msg'] = 'Some problem occurred, please try again.eto?'; 
            } 
        }else{ 
            $sessData['status']['type'] = 'error'; 
            $sessData['status']['msg'] = 'Please fill all the mandatory fields.<br>'.$errorMsg;  
        } 
        // $_SESSION['sessData'] = $sessData; 
    header("Location: $redirectLoc"); 
        
    } 
} 
 
// Redirect to the specific page 
header("Location: $redirectLoc"); 
exit();

?>