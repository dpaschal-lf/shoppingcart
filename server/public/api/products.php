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
  $id = $_GET['id'];
  if(!is_numeric($id)){
    throw new Exception('id needs to be a number');
  }
  $whereClause = " WHERE `id`=$id";
} else {
  $id = false;
  $whereClause = '';
}

require_once('db_connection.php');
$query = "SELECT * FROM `products`$whereClause";

$result = mysqli_query($conn, $query);

if(!$result){
  throw new Exception(mysqli_error($conn));
}

if(mysqli_num_rows($result)===0 && $id!==false){
  throw new Exception("Invalid ID: $id", 404);
}

$output = [];

while($row = mysqli_fetch_assoc($result)){
  $output[] = $row;
}

$json_output = json_encode($output);

print($json_output);

?>
