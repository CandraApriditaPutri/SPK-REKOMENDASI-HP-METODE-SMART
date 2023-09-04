<?php
function url(){
	$get_url = sprintf(
		"%s://%s%s",
		isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
		$_SERVER['SERVER_NAME'],
		$_SERVER['REQUEST_URI']
	);
	$split = explode('/', $get_url);
    $replace = str_replace(end($split), "", $get_url);

    return $replace;
}
?>