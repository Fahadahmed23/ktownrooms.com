<?php


function asset_path($uri='') {
    return asset( '/' . ltrim($uri,'/') );
}

function site_url($uri='/') {
    return call_user_func_array( 'url', ['/' . ltrim($uri,'/')] + func_get_args() );
}

function constants($key) {
    return config( 'constants.' . $key );
}