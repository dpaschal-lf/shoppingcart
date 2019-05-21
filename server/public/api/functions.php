<?php

function error_handler( $error ){
    $output = [
        'success'=>false,
        'error'=>$error->getMessage()
    ];
    print( json_encode( $output ));
}

?>