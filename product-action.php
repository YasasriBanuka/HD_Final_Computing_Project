<?php
// Check if the 'action' parameter is set in the GET request
if (!empty($_GET["action"])) {
    // Retrieve and sanitize the product ID from GET parameters
    $productId = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
    // Retrieve and sanitize the quantity from POST parameters
    $quantity = isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '';

    // Handle different actions based on the 'action' parameter
    switch ($_GET["action"]) {
        // Add item to the cart
        case "add":
            // Proceed if the quantity is not empty
            if (!empty($quantity)) {
                // Prepare SQL query to fetch product details from the database
                $stmt = $db->prepare("SELECT * FROM dishes WHERE d_id = ?");
                $stmt->bind_param('i', $productId);
                $stmt->execute();
                // Fetch the product details
                $productDetails = $stmt->get_result()->fetch_object();
                // Create an item array for the cart
                $itemArray = array($productDetails->d_id => array(
                    'title' => $productDetails->title,
                    'd_id' => $productDetails->d_id,
                    'quantity' => $quantity,
                    'price' => $productDetails->price
                ));
                // Check if the cart already has items
                if (!empty($_SESSION["cart_item"])) {
                    // Check if the product is already in the cart
                    if (in_array($productDetails->d_id, array_keys($_SESSION["cart_item"]))) {
                        // Update quantity if product is already in the cart
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            if ($productDetails->d_id == $k) {
                                if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $quantity;
                            }
                        }
                    } else {
                        // Add the new item to the cart
                        $_SESSION["cart_item"] = $_SESSION["cart_item"] + $itemArray;
                    }
                } else {
                    // Initialize the cart with the new item if empty
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;

        // Remove item from the cart
        case "remove":
            if (!empty($_SESSION["cart_item"])) {
                // Iterate through the cart items
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    // Remove the item if it matches the product ID
                    if ($productId == $v['d_id']) {
                        unset($_SESSION["cart_item"][$k]);
                    }
                }
            }
            break;

        // Empty the cart
        case "empty":
            // Clear the cart by unsetting the session variable
            unset($_SESSION["cart_item"]);
            break;

        // Redirect to checkout page
        case "check":
            header("location:checkout.php");
            break;
    }
}
?>
