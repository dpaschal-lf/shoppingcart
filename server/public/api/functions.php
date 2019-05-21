<?php

function error_handler( $error ){
    $output = [
        'success'=>false,
        'error'=>$error->getMessage()
    ];
    http_response_code(500);
    print( json_encode( $output ));
}


?>