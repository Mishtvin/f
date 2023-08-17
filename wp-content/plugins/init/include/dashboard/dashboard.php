<?php

add_filter( 'lostpassword_url', 'change_lostpassword_url', 10, 2 );

function change_lostpassword_url( $url, $redirect ){
	$new_url = home_url( '/test_reset_pass' );
	return add_query_arg( array('redirect'=>$redirect), $new_url );
}

function generate_hash_key(){
    $hash = hash_init('md5');
    $key = rand(1000000000, 9999999999);
    hash_update($hash, $key);
    $hash = hash_final($hash);

    return $hash;
}

function clearName($name){
    return trim($name);
}