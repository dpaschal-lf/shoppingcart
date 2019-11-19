<?php

function error_handler( $error, $code=500 ){
    $output = [
        'success'=>false,
        'error'=>$error->getMessage()
    ];
    http_response_code($code);
    print( json_encode( $output ));
}

function startup(){
    header("Content-type:application/json");
}

function get_body_data( ){
    $stdin = file_get_contents("php://input");
    $data = json_decode($stdin,true);
    return $data;
}


?>