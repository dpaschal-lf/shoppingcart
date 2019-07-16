<?php

// header('Content-Type: application/json');

// if (empty($_GET['id'])) {
//   readfile('dummy-products-list.json');
// } else {
//   readfile('dummy-product-details.json');
// }

require_once('functions.php');

set_exception_handler('error_handler');

startup();

if(!empty($_GET['id'])){
  $id = intval($_GET['id']);
  if(!is_numeric($id)){
    throw new Exception('id needs to be a number');
  }
  $query = "SELECT p.id, p.name, p.price, p.shortDescription, 
    GROUP_CONCAT( i.url)  AS images
    FROM products as p 
    JOIN images as i 
      ON p.id=i.productID
    WHERE p.id = $id
    GROUP BY p.id";
} else {
  $id = false;
  $query = "SELECT p.id, p.name, p.price, p.shortDescription,
  (SELECT url FROM images WHERE productID = p.id LIMIT 1) AS image
  FROM products AS p";
}

print($query);

require_once('db_connection.php');

$result = mysqli_query($conn, $query);

if(!$result){
  throw new Exception(mysqli_error($conn));
}

if(mysqli_num_rows($result)===0 && $id!==false){
  throw new Exception("Invalid ID: $id", 404);
}

$output = [];
if($id){
  $output = mysqli_fetch_assoc($result);
  $output['images'] = explode(',', $output['images'] );
} else {
  while($row = mysqli_fetch_assoc($result)){
    $output[] = $row;
  }
}


$json_output = json_encode($output);

print($json_output);

?>
