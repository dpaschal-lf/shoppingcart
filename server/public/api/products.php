<?php

// header('Content-Type: application/json');

// if (empty($_GET['id'])) {
//   readfile('dummy-products-list.json');
// } else {
//   readfile('dummy-product-details.json');
// }

require_once('functions.php');

set_exception_handler('error_handler');

$query = "SELECT * FROM products";

$result = mysqli_query($conn, $query);

if(!$result){
  throw new Exception(mysqli_error($conn));
}

$output = [];

while($row = mysqli_query($result)){
  $output[] = $row;
}

$json_output = json_encode($output);

?>
