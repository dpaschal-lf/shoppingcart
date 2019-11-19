<?php

define('INTERNAL', true);

require_once('functions.php');

session_start();

set_exception_handler('error_handler');

require_once('db_connection.php');

switch($_SERVER['REQUEST_METHOD']){
  case 'POST':
    include('cart_add.php');
    break;
  case 'GET':
    include('cart_get.php');
    break;
}

// $query = "";

// $statement = mysqli_prepare($conn, "SELECT ?");
// $text = 'hello';
// mysqli_stmt_bind_param($statement, 's', $text );
// mysqli_stmt_execute($statement);
// $result = mysqli_stmt_get_result($statement);
// $data = mysqli_fetch_assoc($result);
// print_r($data);
?>
