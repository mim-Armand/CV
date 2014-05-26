<?php

/* Global variables in use:
$isTokenOk --> bool of NONCE and session checks
$tok --> string, new CSRF protection token, to send back to client to use in future requests
$nthReq --> number, the number of requests already made using the current session
$lastTok --> number, previous CSRF Token number (to check in case of page refresh if neccessary)
$isUserLogedIn --> bool, the result of Persona check, if the user is loged in or not (checked on every and each request)
$isAjax --> bool, shows if the request is AJAX or page request.
*/
error_reporting(-1);
include_once ("mimses.php");
// if $beingParanoid set to true, server will verify the user auth in each request with Persona servers, TODO: otherwise it will be checked once per each 12 requests
$beingParanoid = false;
//TODO: keep email adress in BCRYPTED format only 
$adminEmail = 'mim3dot@gmail.com';
$admin_page_address = findAdminPageAddress();
// this variable will keep the AJAX requested action name;
$act = '';
include_once ("persona.php");
include_once ("isajax.php");
include_once ("views.php");
//include_once ("debug.php");
$jsonArray = [];
if (!$isAjax) {
    echo $header . $login . $footer;
} else {
     isset($_POST['dataArray']['act']) ? $act = $_POST['dataArray']['act'] : $act = NULL;
     $jsonArray['action requested:'] = $act;
    if ($isTokenOk) {
        checkPersona();
        if ($isUserLogedIn) {
            $jsonArray['LOGED IN'] = 'YES!';
            jsonAnswer();
        } else {
            $jsonArray['LOGED IN'] = 'NO!';
            jsonAnswer();
        }
    } else {
        echo 'You are a BAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD persone!!!';
        die;
    }
}
/*************************************************** FUNCTIONS: **************************************************/
function jsonAnswer() {
    global $jsonArray;
    global $isTokenOk;
    global $isUserLogedIn;
    global $tok;
    $jsonArray['authStatus'] = $isUserLogedIn;
    $jsonArray['tokenStatus'] = $isTokenOk;
    $jsonArray['tok'] = $tok;
    echo json_encode($jsonArray);
}
function findAdminPageAddress() {
    $adadd = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $adadd.= $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
    return $adadd;
}

/********************************************************** VIEW CONSTRUCTORS ********************************************/
?>