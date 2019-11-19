<?php

if(!defined(INTERNAL)){
    die('no direct calls');
}

if(empty($_SESSION['cartId'])){
   print(json_encode([]));
   exit(); 
} 

$cartId = intval($_SESSION['cartId']);

$query = "SELECT ci.`count`, ci.`price`,  
    p.`name`, p.`shortDescription`, (SELECT url FROM images WHERE productID = p.id LIMIT 1) AS image
    FROM `cartItems` AS ci
    JOIN `products` AS p 
        ON p.`id` = ci.`productID`
    WHERE cartID = $cartId";

$result = mysqli_query($conn, $query);

if(!$result){
    throw new Exception('invalid fetch query for cart: '.mysqli_error($conn));
}

$output = [];

while($row = mysqli_fetch_assoc($result)){
    $output[] = $row;
}

print(json_encode( $output ));

?>