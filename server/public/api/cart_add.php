<?php

if(!is_defined(INTERNAL)){
    die('no direct calls');
}

$bodyData = get_body_data( );

if(empty($bodyData['id'])){
    throw new Exception('must have a product id to add to cart');
}

$id = intval($bodyData['id']);

if($id<=0){
    throw new Exception('product id must be valid: '.$bodyData['id']);
}

if(!empty($_SESSION['cartId'])){
    $cartId = $_SESSION['cartId'];
} else {
    $cartId = false;
}

//get information for product

$select_query = "SELECT price FROM `products` WHERE `id` = $id";

$result = mysqli_query($conn, $select_query);

if(!$result){
    throw new Exception('invalid query '. mysqli_error($conn));
}

if(mysqli_num_rows($result)===0){
    throw new Exception('invalid product id '. $id);
}

$productData = mysqli_fetch_assoc($result);

$transactionResult = mysqli_query($conn, 'START TRANSACTION');

if(!$transactionResult){
    throw new Exception('unablet to start transaction '. mysqli_error($conn));
}

if(!$cartId){
    $insertQuery = "INSERT INTO `cart` SET created=NOW()";
    $insertResult = mysqli_query($conn, $insertQuery);
    if(!$insertResult){
        throw new Exception('invalid query for insert '. mysqli_error($conn));
    }
    if(mysqli_affected_rows($conn)===0){
        throw new Exception('cart did not get added');
    }
    $cartId = $_SESSION['cartId'] = mysqli_insert_id($conn);
}

$cartItemsInsertQuery = "INSERT INTO `cartItems` 
    SET `productID`= $id, `count`=1, price={$productData['price']}, added=NOW(), cartID=$cartId
    ON DUPLICATE KEY UPDATE
    `count`=`count`+1
    ";

$cartItemsResult = mysqli_query($conn, $cartItemsInsertQuery);

if(!$cartItemsResult){
    throw new Exception('invalid items query '. mysqli_error($conn));
}

if(mysqli_affected_rows($conn)===0){
    mysqli_query($conn, 'ROLLBACK');
    throw new Exception('unable to insert/update cart items ');
}

$transactionResult = mysqli_query($conn, "COMMIT");

?>