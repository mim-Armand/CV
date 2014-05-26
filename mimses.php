<?php

// Session and NOUNCE manager function by mim.Armand - 2014
// here we set the session cookie name (something different than PHPSESSID !)
session_name("mimses");

// here we tell the session that it is valid just in current dir, you may want to remove it depending on your needs
ini_set('session.cookie_path', '');

// session starts.
session_start();

// here we do the main check for Session and NONCE and output the results on $isTokenOk variable (bool)
if (isset($_SESSION['CSRFToken']) and isset($_POST['tok']) and $_POST['tok'] === $_SESSION['CSRFToken']) {
    $isTokenOk = true;
} else {
    $isTokenOk = false;
}

// we regenerate the session id in each request to increase the security
session_regenerate_id(TRUE);
setcookie("can_set_cookies", "1");

// if lastTok exist, set it to current CSRFToken (before changing it), otherwise set to empty
isset($_SESSION['lastTok']) ? $_SESSION['lastTok'] = $_SESSION['CSRFToken'] : $_SESSION['lastTok'] = '';

//$lastTok --> number, previous CSRF Token number (to check in case of page refresh if neccessary) --> please note it is the LAST token used (including in AJAX calls)
$lastTok = $_SESSION['lastTok'];

// Regenerate CSRFToken
$_SESSION['CSRFToken'] = UUIDGen(6);

// IF Request number exist, increament it by each request, otherwise set it to 1
isset($_SESSION['nthReq']) ? $_SESSION['nthReq']+= 1 : $_SESSION['nthReq'] = 1;

//$nthReq --> number, the number of requests already made using the current session, you can use it to incease security by limiting the allowed number of requests with each session
$nthReq = $_SESSION['nthReq'];

//$tok --> string, new CSRF protection token, to send back to client to use in future requests
$tok = $_SESSION['CSRFToken'];

// this function regenerate an acceptable UUID (Universal Unique ID) in each request
function UUIDGen($len) {
    return bin2hex(openssl_random_pseudo_bytes($len, $cstrong));
}
?>