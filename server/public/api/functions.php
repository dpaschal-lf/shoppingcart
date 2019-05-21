<?php

function error_handler( $error ){
    $output = [
        'success'=>false,
        'error'=>$error->getMessage()
    ];
    print( json_encode( $output ));
}

$output = file_get_contents('dummy-products-list.json');

print($output);
?>