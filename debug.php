<?php
if (!$isAjax) {
    $debug_array = ["Token check status" => $isTokenOk, "current token" => $tok, "Number of requests" => $nthReq, "last used Token" => $lastTok, "Auth Status" => $isUserLogedIn, "is not Ajax" => !$isAjax, ];
    echo '<pre>';
    print_r($debug_array);
    echo '</pre>';
}
?>