<?php

function asset_version($src) {

    // if file is found
    if(is_file($real_path = public_path($src)))

        // add tol file.css: ?1234 (file modified timestamp)
        return $src . '?' . filemtime($real_path);

    // file not found? just return the same path
    return $src;

}