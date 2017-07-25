<?php
$html = file_get_contents('http://www.whatsmyip.org/');

echo $html;

// $start = strpos($html,"</head>");
// echo substr($html,$start);



// $curl_handle = curl_init();
// curl_setopt( $curl_handle, CURLOPT_URL, 'https://developers.facebook.com/apps/314158532346515/fb-login/quickstart/' );
// curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true ); // Fetch the contents too
// $html = curl_exec( $curl_handle ); // Execute the request

// echo $html;

// curl_close( $curl_handle );

?>