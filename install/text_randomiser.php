<?php

function getRandomString($limit) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";	
    $str = '';
    $size = strlen( $chars );
    for( $i = 0; $i < $limit; $i++ ) {
        $str .= $chars[ rand( 0, $size - 1 ) ];
    }

    return $str;
}

?>